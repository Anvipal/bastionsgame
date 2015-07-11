<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 21:31
 */

namespace backend\controllers;

use backend\components\Controller;
use common\models\StdHero;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class HeroesController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => StdHero::find(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderAuto('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new StdHero();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirectAuto(['view', 'id' => $model->id]);
        } else {
            return $this->renderAuto('create', '_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirectAuto(['view', 'id' => $model->id]);
        } else {
            return $this->renderAuto('update', '_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirectAuto(['index']);
    }


    /**
     * @param integer $id
     * @return StdHero
     * @throws NotFoundHttpException
     */
    private function findModel($id)
    {
        if (($model = StdHero::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('common','MSG_STDHERO_NOTFOUND'));
    }
}