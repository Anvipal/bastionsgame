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
        return $this->render('index');
    }
}