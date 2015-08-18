<?php

// change the following paths if necessary
// 上傳到匯智網站時. 要注意 yii 的路徑要改成下面的
// $yii=dirname(__FILE__).'/yii/framework/yii.php';
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
