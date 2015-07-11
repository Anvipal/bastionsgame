<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 11.07.2015
 * Time: 12:42
 */

namespace common\components\i18n;

use Yii;

class I18N extends \yii\i18n\I18N
{
    public function init()
    {
        return parent::init();
    }

    public function translate($category, $message, $params, $language)
    {
        $this->checkTranslate($category, $message, $language);
        return parent::translate($category, $message, $params, $language);
    }

    public function checkTranslate($category, $message, $language)
    {
        $messageSource = $this->translations[$category];
        $basePath = is_array($messageSource) ? $messageSource['basePath'] : $messageSource->basePath;
        $sourceLanguage = is_array($messageSource) ? $messageSource['sourceLanguage'] : $messageSource->sourceLanguage;
        if ($language != $sourceLanguage) {
            $baseDir = Yii::getAlias($basePath);
            $langDir = $baseDir . DIRECTORY_SEPARATOR . $language;
            $fileSrc = $langDir . DIRECTORY_SEPARATOR . $category . ".php";

            if (!is_dir($baseDir)) mkdir($baseDir, 0777);
            if (!is_dir($langDir)) mkdir($langDir, 0777);

            $translations = !file_exists($fileSrc) ? [] : require($fileSrc);
            $translations = is_array($translations) ? $translations : [];
            if (!isset($translations[$message])) {
                $translations[$message] = $message;
                $php_file = fopen($fileSrc, 'w');
                fwrite($php_file, "<? \n // " . htmlspecialchars("'", ENT_QUOTES) . " => ' (Symbol \"'\") \nreturn [ \n");
                foreach ($translations as $k => $v) {
                    fwrite($php_file, "     '$k'=>'$v', \n");
                }
                fwrite($php_file, "];");
                fclose($php_file);
            }
        }

    }
}