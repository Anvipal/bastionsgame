<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 20:56
 */

namespace backend\components;

use backend\widgets\toastr\ToastrFlash;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;

class Controller extends \yii\web\Controller
{

    /**
     * @param $url
     * @param array $array
     * @return array|Response
     */
    public function redirectAuto($url, $array = [])
    {
        if (Yii::$app->request->isAjax)
            return $this->renderJson(ArrayHelper::merge([
                'redirect' => $url !== false ? Url::to($url) : false,
            ], $array));
        else
            return $this->redirect(($url === false ? ['index'] : $url));
    }

    /**
     * @param array $array
     * @return array
     */

    public function renderJson($array = [])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ArrayHelper::merge([
            'result' => true,
            'message' => null
        ], $array);
    }

    /**
     * @param $view
     * @param null $viewAjax
     * @param array $params
     * @return null|string
     * @throws \Exception
     */
    public function renderAuto($view, $viewAjax = null, $params = [])
    {
        $viewAjax = $viewAjax == null ? $view : $viewAjax;
        if (is_array($viewAjax)) {
            $params = $viewAjax;
            $params['view'] = $view;
            $viewAjax = $view;
        }
        if (Yii::$app->request->isAjax) {

            $view = $this->getView();

            //ob_start();
            //ob_implicit_flush(false);

            echo ToastrFlash::widget([
                'options' => [
                    'positionClass' => 'toast-top-center full-width',//'toast-bottom-left'
                    'progressBar' => true,
                    'timeOut' => 6000,
                    'extendedTimeOut' => 2000,
                ]
            ]);

            $view->beginPage();
            $view->head();
            $view->beginBody();
            if (Yii::$app->request->get('layout', true))
                $view->beginContent('@app/views/' . $this->id . '/_popup.php', $params);

            echo $this->renderPartial($viewAjax, $params);

            if (isset($view->assetBundles['yii\bootstrap\BootstrapAsset']))
                unset($view->assetBundles['yii\bootstrap\BootstrapAsset']);

            if (Yii::$app->request->get('layout', true)) $view->endContent();

            $view->endBody();
            $view->endPage(true);

            //return ob_get_clean();
            return null;

        } else {
            return $this->render($view, $params);
        }
    }

}