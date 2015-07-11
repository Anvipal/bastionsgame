<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 11.07.2015
 * Time: 2:30
 */

namespace backend\controllers;

use backend\components\Controller;
use common\models\StdObstacle;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ObstaclesController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => StdObstacle::find(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return null|string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->renderAuto('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return array|null|string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StdObstacle();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirectAuto(['view', 'id' => $model->id]);
        } else {
            return $this->renderAuto('create', '_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return array|null|string|\yii\web\Response
     * @throws NotFoundHttpException
     */
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

    /**
     * @param $id
     * @return array|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirectAuto(['index']);
    }


    /**
     * @param integer $id
     * @return StdObstacle
     * @throws NotFoundHttpException
     */
    private function findModel($id)
    {
        if (($model = StdObstacle::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('common','MSG_STDOBSTACLE_NOTFOUND'));
    }
}