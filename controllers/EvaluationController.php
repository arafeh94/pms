<?php

namespace app\controllers;

use app\components\Tools;
use app\models\Course;
use app\models\Cycle;
use app\models\Department;
use app\models\EvaluationEmail;
use app\models\Instructor;
use app\models\InstructorEvaluationEmail;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\providers\CourseDataProvider;
use app\models\providers\EvaluationReportDataProvider;
use app\models\School;
use app\models\Season;
use app\models\Semester;
use app\models\Student;
use app\models\StudentCourseEnrollment;
use app\models\StudentCourseEvaluation;
use app\models\StudentSemesterEnrollment;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Json;

class EvaluationController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $provider = new EvaluationReportDataProvider();
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionFill($code)
    {
        $evaluations = Yii::$app->request->post('StudentCourseEvaluation', []);
        $evaluationsModels = [];
        $instructorEvaluationEmail = InstructorEvaluationEmail::find()->where(['EvaluationCode' => $code])->active()->one();
        $enrollments = (new Query())
            ->select('*')
            ->from(StudentCourseEnrollment::tableName())
            ->innerJoin(OfferedCourse::tableName(), 'studentcourseenrollment.OfferedCourseId = offeredcourse.OfferedCourseId')
            ->innerJoin(Instructor::tableName(), 'offeredcourse.InstructorId = instructor.InstructorId')
            ->innerJoin(Course::tableName(), 'offeredcourse.CourseId = course.CourseId')
            ->innerJoin(StudentSemesterEnrollment::tableName(), 'studentcourseenrollment.StudentSemesterEnrollmentId = studentsemesterenrollment.StudentSemesterEnrollmentId')
            ->innerJoin(Student::tableName(), 'student.StudentId = studentsemesterenrollment.StudentId')
            ->orderBy('offeredcourse.CourseId')
            ->where(['studentsemesterenrollment.SemesterId' => Semester::find()->current()->SemesterId])
            ->andWhere(['instructor.InstructorId' => $instructorEvaluationEmail->InstructorId])
            ->select('*')
            ->all();
        if (!$instructorEvaluationEmail) {
            return $this->render('error', ['name' => 'Evaluation Form Error', 'message' => 'WRONG EVALUATION CODE']);
        }
        if ($instructorEvaluationEmail->DateFilled) {
            return $this->render('error', ['name' => 'Evaluation Form Error', 'message' => 'EVALUATION ALREADY FILLED']);
        }
        if ($evaluations) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $hasError = false;
                foreach ($evaluations as $evaluation) {
                    $studentCourseEvaluation = new StudentCourseEvaluation();
                    if ($studentCourseEvaluation->load($evaluation, '')) {
                        if ($evaluation['StudentCourseEvaluationId']) {
                            $studentCourseEvaluation->StudentCourseEvaluationId = $evaluation['StudentCourseEvaluationId'];
                            if (!$studentCourseEvaluation->update()) $hasError = true;
                        } else {
                            if (!$studentCourseEvaluation->save()) $hasError = true;
                            if (!$hasError && $instructorEvaluationEmail->evaluationEmail->Quarter == 'Final') {
                                $studentCourseEnrollment = StudentCourseEnrollment::findOne($evaluation['StudentCourseEnrollmentId']);
                                $studentCourseEnrollment->FinalGrade = $studentCourseEvaluation->Grade;
                                $studentCourseEnrollment->save();
                            }
                        }
                        $evaluationsModels[] = $studentCourseEvaluation;
                    }
                }
                if ($hasError) {
                    $transaction->rollBack();
                } else {
                    $instructorEvaluationEmail->DateFilled = Tools::currentDate();
                    $instructorEvaluationEmail->save();
                    $transaction->commit();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
            }

        } else {
            foreach ($enrollments as $enrollment) {
                $studentCourseEvaluation = new StudentCourseEvaluation();
                $studentCourseEvaluation->InstructorEvaluationEmailId = $instructorEvaluationEmail->InstructorEvaluationEmailId;
                $studentCourseEvaluation->StudentCourseEnrollmentId = $enrollment['StudentCourseEnrollmentId'];
                $studentCourseEvaluation->StudentId = $enrollment['StudentId'];
                $evaluationsModels[] = $studentCourseEvaluation;
            }
        }
        return $this->render('fill', [
            'instructorEvaluationEmail' => $instructorEvaluationEmail,
            'enrollments' => $enrollments,
            'evaluations' => $evaluationsModels
        ]);
    }

}