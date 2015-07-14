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
use common\models\StdHeroSkill;
use common\models\StdObstacle;
use yii\helpers\ArrayHelper;
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

    public function actionSkills($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => StdHeroSkill::find()->andWhere(['id_stdhero' => $id]),
        ]);
        return $this->renderAuto('skills', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateSkill()
    {
        $model = $this->findModel(\Yii::$app->request->get('id_stdhero'));
        $skill = new StdHeroSkill();
        $skill->id_stdhero = \Yii::$app->request->get('id_stdhero');
        if ($skill->load(\Yii::$app->request->post()) && $skill->save()) {
            return $this->redirectAuto(['skills', 'id' => $skill->id_stdhero]);
        }
        return $this->renderAuto('create_skill', '_skill_form', [
            'model' => $model,
            'skill' => $skill,
            'dropdownlists' => $this->dropDownArrays($skill->id_stdhero),
        ]);
    }

    public function actionUpdateSkill()
    {
        $model = $this->findModel(\Yii::$app->request->get('id_stdhero'));
        $skill = $this->findSkillModel(\Yii::$app->request->get('id_stdhero'), \Yii::$app->request->get('id_stdobstacle')) ?: new StdHeroSkill();

        if ($skill->load(\Yii::$app->request->post()) && $skill->save()) {
            return $this->redirectAuto(['skills', 'id' => $skill->id_stdhero]);
        }
        return $this->renderAuto('update_skill', '_skill_form', [
            'model' => $model,
            'skill' => $skill,
            'dropdownlists' => [],
        ]);
    }

    public function actionDeleteSkill()
    {
        $this->findSkillModel(\Yii::$app->request->get('id_stdhero'), \Yii::$app->request->get('id_stdobstacle'))->delete();

        return $this->redirectAuto(['skills', 'id' => \Yii::$app->request->get('id_stdhero')]);
    }

    public function dropDownArrays($id_stdhero)
    {
        return [
            'stdobstacles' => ArrayHelper::map(StdObstacle::find()->andWhere([
                'NOT IN',
                'id',
                ArrayHelper::map(StdHeroSkill::find()->select(['id_stdobstacle'])->andWhere(['id_stdhero' => $id_stdhero])->all(),'id_stdobstacle','id_stdobstacle')
            ])->all(),'id','title'),
        ];
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

    /**
     * @param integer $id_h
     * @param integer $id_o
     * @return StdHeroSkill
     * @throws NotFoundHttpException
     */
    private function findSkillModel($id_h, $id_o)
    {
        if (($model = StdHeroSkill::findOne(['id_stdhero' => $id_h, 'id_stdobstacle' => $id_o])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('common','MSG_STDHEROSKILL_NOTFOUND'));
    }
}
