<?php

namespace app\components;

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\FileCache;

/**
 * Class DropboxShell
 * @package app\components
 * @property Dropbox $dropbox
 */
class DropboxShell extends Component
{
    public $clientId = '';
    public $clientSecret = '';
    public $accessToken = '';
    public $path = '/';
    public $folder = '';

    private $dropbox;

    public function init()
    {
        parent::init();
        $app = new DropboxApp($this->clientId, $this->clientSecret, $this->accessToken);
        $this->dropbox = new Dropbox($app);
        $this->dropbox->getClient()->setHttpClient(new DropboxGuzzleClient());
        $this->checkParameters();
    }

    public function upload($path, $name = null)
    {
        if ($name == null) {
            $name = substr($path, strrpos($path, '\\') ? strrpos($path, '\\') + 1 : strrpos($path, '/') ? strrpos($path, '/') + 1 : 0);
            $name = strtolower($name);
        }

        $pathOnDrive = strtolower(\Yii::getAlias($path));
        $pathOnDropbox = $this->path . $this->folder . $name;
        return $this->dropbox->upload($pathOnDrive, $pathOnDropbox, ['autorename' => true]);
    }

    public function link($path)
    {
        return $this->dropbox->getTemporaryLink($path)->getLink();
    }

    public function download($path)
    {
        $link = $this->link($path);
    }

    public function folder($folder)
    {
        $this->folder = $folder;
    }

    private function checkParameters()
    {
        if (!Tools::str_ends_with($this->path, '/')) {
            throw new InvalidConfigException('path must end with /');
        }
        if (!Tools::str_starts_with($this->path, '/')) {
            throw new InvalidConfigException('path must start with /');
        }
        if ($this->folder !== '' && !Tools::str_ends_with($this->folder, '/')) {
            throw new InvalidConfigException('folder name must ends with /');
        }

    }

}
