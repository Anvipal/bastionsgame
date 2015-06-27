<?php

namespace frontend\controllers;

use common\models\Hero;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Class HeroesController
 * @package frontend\controllers
 */
class HeroesController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Hero::find(),
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
            ],
            'pagination' => [
                'pageSize' => 20,
                'validatePage' => false,
            ]
        ]);

        return $this->render('index', ['heroes' => $dataProvider]);
    }

    /**
     * @return array|string
     * @throws ForbiddenHttpException
     */
    public function actionHire()
    {
        if (Yii::$app->request->isAjax) {
            $hero = new Hero();
            if ($hero->load(Yii::$app->request->post())) {
                $hero->id_user = 1;
                if ($hero->save()) {
                    return $this->redirect(['/heroes']);
                } else {
                    return $this->renderAjax('_hire', ['model' => $hero]);
                }
            }
            return $this->renderAjax('_hire', ['model' => $hero]);
        } else {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * @param $id
     * @var $hero \common\models\Hero
     * @return array
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        if (is_numeric($id) && Yii::$app->request->isAjax) {
            $hero = Hero::find(['id' => $id])->one();
            if ($hero) {
                if ($hero->delete()) {
                    $answer = [
                        'msg' => 'Герой був успішно видалений!'
                    ];
                    Yii::$app->response->format = 'json';
                    return $answer;
                } else {
                    $answer = [
                        'msg' => 'Виникла помилка додавання героя',
                        'err' => $hero->getFirstErrors()
                    ];
                    Yii::$app->response->format = 'json';
                    return $answer;
                }
            }
            return $this->redirect('/heroes/');
        } else
            throw new ForbiddenHttpException();

    }
}