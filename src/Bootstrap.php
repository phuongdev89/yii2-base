<?php
/**
 * Created by phuongdev89.
 * @project yii2-setting
 * @author  Phuong
 * @email   phuongdev89@gmail.com
 * @date    05/07/2016
 * @time    11:50 PM
 */

namespace phuongdev89\base;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        Yii::setAlias('phuongdev89', dirname(__DIR__, 2));
        Yii::setAlias('phuongdev89/base', __DIR__);
    }
}
