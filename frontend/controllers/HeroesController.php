<?php

namespace frontend\controllers;

use common\models\Hero;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Class HeroesController
 * @package app\controllers
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
        $heroes = Hero::find()->all();
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_hero_list', ['heroes' => $heroes]);
        }
        return $this->render('index', ['heroes' => $heroes]);
    }

    /**
     * @return array|string
     * @throws ForbiddenHttpException
     */
    public function actionHire()
    {
        if (Yii::$app->request->isAjax) {
            $hero = new Hero();
            if ($req = Yii::$app->request->post('Hero')) {
                $hero->hclass = $req['hclass'];
                $hero->hname = $req['hname'];
                $hero->user_id = 1;
                if ($hero->save()) {
                    $answer = [
                        'msg' => 'У вас додався новий герой!'
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
            return $this->renderPartial('_hire', ['model' => $hero]);
        } else {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * @param $id
     * @var $hero \app\models\Hero
     * @return array
     */
    public function actionDelete($id = null)
    {
        if (is_numeric($id)) {
            if (Yii::$app->request->isAjax) {
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
            }
            return $this->redirect('/heroes/');
        } else
            throw new ForbiddenHttpException();

    }
}