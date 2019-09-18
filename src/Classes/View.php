<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-09-18
 * Time: 12:32
 */

namespace jascoB\ViewModel\Classes;


use jascoB\ViewModel\Interfaces\Arrayable;

class View extends \yii\web\View
{

    public function renderFile($viewFile, $params = [], $context = null)
    {

        if ($params instanceof Arrayable){
            $params = $params->toArray();
        }
        return parent::renderFile($viewFile, $params, $context);
    }

    public function renderPhpFile($_file_, $_params_ = [])
    {
        if ($_params_ instanceof Arrayable){
            $_params_ = $_params_->toArray();
        }
        return parent::renderPhpFile($_file_, $_params_);
    }
}
