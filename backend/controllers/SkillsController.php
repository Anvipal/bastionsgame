<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 11.07.2015
 * Time: 1:20
 */

namespace backend\controllers;

use backend\components\Controller;
use common\models\StdHero;
use common\models\StdHeroSkill;
use common\models\StdObstacle;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class SkillsController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => StdHeroSkill::find()->andWhere(['id_stdhero' => $id]),
        ]);
        return $this->renderAuto('view', [
            'model' => $this->findParentModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateSkill($id_stdhero)
    {
        $model = new StdHeroSkill();
        $model->id_stdhero = $id_stdhero;
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirectAuto(['view', 'id' => $model->id_stdhero]);
        }
        return $this->renderAuto('create_skill', '_form', [
            'model' => $model,
            'dropdownlists' => $this->dropDownArrays(),
        ]);
    }

    public function actionUpdateSkill()
    {
        $model = $this->findModel(\Yii::$app->request->get('id_stdhero'), \Yii::$app->request->get('id_stdobstacle')) ?: new StdHeroSkill();

        if ($model->load(\Yii::$app->request->get()) && $model->save()) {
            return $this->redirectAuto(['view', 'id' => $model->id_stdhero]);
        }
        return $this->renderAuto('update_skill', '_form', [
            'model' => $model,
            'dropdownlists' => $this->dropDownArrays(),
        ]);
    }

    public function actionDeleteSkill()
    {
        $this->findModel(\Yii::$app->request->get('id_stdhero'), \Yii::$app->request->get('id_stdobstacle'))->delete();

        return $this->redirectAuto(['view', 'id' => \Yii::$app->request->get('id_stdhero')]);
    }


    /**
     * @param integer $id_h
     * @param integer $id_o
     * @return StdHeroSkill
     * @throws NotFoundHttpException
     */
    private function findModel($id_h, $id_o)
    {
        if (($model = StdHeroSkill::findOne(['id_stdhero' => $id_h, 'id_stdobstacle' => $id_o])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('common','MSG_STDHEROSKILL_NOTFOUND'));
    }

    /**
     * @param integer $id
     * @return StdHero
     * @throws NotFoundHttpException
     */
    private function findParentModel($id)
    {
        if (($model = StdHero::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('common','MSG_STDHERO_NORFOUND'));
    }

    public function dropDownArrays()
    {
        return [
            'stdobstacles' => ArrayHelper::map(StdObstacle::find()->all(),'id','title'),
        ];
    }
}