<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
use common\models\Quest;

class QuestsController extends Controller
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
        /*$quests = Quest::find(['user_id' => (User::find(['id' => 1])->limit(1)->one()[0])->id])
            ->where('status in (' . Quest::ST_NEW . ',' . Quest::ST_IN_PROCESS . ')')
            ->orderBy('status desc');*/
        return $this->render('index'/*, ['quests'=>$quests]*/);
    }
}