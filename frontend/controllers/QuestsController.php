<?php

namespace frontend\controllers;

use common\models\Hero;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use common\models\Quest;
use yii\web\ForbiddenHttpException;

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
        $dataProvider = new ActiveDataProvider([
            'query' => Quest::find(['user_id' => 1])
                ->where(['status' => Quest::ST_IN_PROCESS ])
                ->orderBy('midhlevel desc')
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionNewQuests()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Quest::find(['user_id' => 1])
                ->where(['status' => Quest::ST_NEW ])
                ->orderBy('midhlevel desc')
        ]);
        return $this->render('newqests', ['dataProvider' => $dataProvider]);
    }

    /**
     * @return string|Response
     * @throws ForbiddenHttpException
     */
    public function actionStartQuest()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->get('id');
            if ($model = $this->findModel($id, Quest::ST_NEW)) {
                /* @var $model Quest */
                $model->timestart = time();
                $model->status = Quest::ST_IN_PROCESS;
                if ($model->save()) {
                    return $this->redirect(['/quests/new-quests']);
                }
                $this->renderAjax('_start_quest', ['model' => $model]);
            }
        }
        throw new ForbiddenHttpException();
    }

    public function actionSelectHero()
    {
        $dataProvider = Hero::find()->join('left','questsheroes',['id_hero' => 'id'])->andWhere(['is', 'id_hero', 'NULL']);
        //return $this->renderAjax()
    }

    /**
     * @param integer $id
     * @param integer|null $status
     * @return Quest
     * @throws ForbiddenHttpException
     */

    private function findModel($id, $status = null)
    {
        if ($status == null) {
            if ($model = Quest::findOne(['id' => $id])) {
                return $model;
            }
        } else {
            if ($model = Quest::findOne(['id' => $id, 'status' => $status])) {
                return $model;
            }

        }

        throw new ForbiddenHttpException();
    }
}