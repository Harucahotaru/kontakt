<?php
namespace app\classes;

class AccessControl extends \yii\filters\AccessControl
{
    public function init()
    {
        parent::init();
        if ($this->user !== false) {
            $this->user->loginUrl = '/user/login';
        }
    }
}
