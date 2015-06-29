<?php

namespace console\controllers;

use Yii;
use common\models\Quest;

class ServerController extends \yii\console\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        Quest::userQuestUpdate();
    }
}