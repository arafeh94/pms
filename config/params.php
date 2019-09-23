<?php

return [
    'hostUrl' => 'http://localhost/usp/web',
    'timezone' => 'Asia/Beirut',
    'dateFormat' => 'yyyy-mm-dd',
    'timeFormat' => 'h:i:s',
    'dateTimeFormat' => 'y-m-d h:i:s',
    'titlesSelector' => ['Mr' => 'Mr', 'Dr' => 'Dr', 'Mrs' => 'Mrs', 'Ms' => 'Ms'],
    'booleanSelector' => ['1' => 'YES', '0' => 'NO'],
    'quarterSelector' => ['Q1' => 'Q1', 'Q2' => 'Q2', 'Q3' => 'Q3', 'Final' => 'Final'],
    'gpaSelector' => ['4' => 'A', '3.7' => 'A-', '3.3' => 'B+', '3' => 'B', '2.7' => 'B-', '2.3' => 'C+', '2' => 'C', '1.7' => 'C-', '1.3' => 'D+', '1' => 'D', '0' => 'F'],
    'behaviorSelector' => ["Can't Tell" => "Can't tell", "Excellent" => "Excellent", "Good" => "Good", "Occasional" => "Occasional", "Never" => "Never", "?" => "?"],
    'evaluationSelector' => ["Can't Tell" => "Can't Tell", "Top 25%" => "Top 25%", "Above Class Average" => "Above Class Average", "Average Student" => "Average Student", "Below Class Average" => "Below Class Average", "Must Withdraw" => "Must Withdraw", "?" => "?"],
    'yearSelector' => ['1' => 'First', '2' => 'Second', '3' => 'Third', '4' => 'Forth', '5' => 'Fifth'],
    'withdrawSelector' => ['I' => 'I', 'WI' => 'WI', 'WF' => 'WF', 'WP' => 'WP'],
    'seasonSelector' => ['Fall' => 'Fall', 'Summer' => 'Summer', 'Spring' => 'Spring'],
    'pdf' => function ($title) {

        $pdfHeader = [
            'L' => [
                'content' => '',
            ],
            'C' => [
                'content' => $title,
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'arial',
                'color' => '#333333',
            ],
            'R' => [
                'content' => 'PDF',
            ],
            'line' => true,
        ];

        $pdfFooter = [
            'L' => [
                'content' => '',
                'font-size' => 10,
                'color' => '#333333',
                'font-family' => 'arial',
            ],
            'C' => [
                'content' => '',
            ],
            'R' => [
                'content' => '',
                'font-size' => 10,
                'color' => '#333333',
                'font-family' => 'arial',
            ],
            'line' => true,
        ];
        return [
            'filename' => $title,
            'content' => 'samira',
            'config' => [
                'methods' => [
                    'SetHeader' => [
                        ['odd' => $pdfHeader, 'even' => $pdfHeader]
                    ],
                    'SetFooter' => [
                        ['odd' => $pdfFooter, 'even' => $pdfFooter]
                    ],
                ],
                'options' => [
                    'title' => 'Preceptors',
                    'subject' => 'Preceptors',
                    'keywords' => 'pdf, preceptors, export, other, keywords, here'
                ],
            ]
        ];
    },
];
