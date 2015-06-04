<?php

namespace frontend\controllers;

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
        $quests_cnt = Quest::find()
            ->where(['status'=>Quest::ST_NEW])
            ->orWhere(['status'=>Quest::ST_IN_PROCESS])
            ->count();
        if ($quests_cnt < Quest::MAX_QUESTS)
        {

        }
        return $this->render('index');
    }
}