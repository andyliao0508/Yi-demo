<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

// Define a path alias for the Bootstrap extension as it's used internally.
// In this example we assume that you unzipped the extension under     protected/extensions.
    Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
return array(
//'defaultController' => 'tbaBoard/announce',
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'JIT資訊系統',

    // preloading 'log' component
    'preload'=>array('log'),
    // 語系
    'language'=>'zh_tw',

    // 預設登入時的位置
//    'defaultController' => 'site/login',    
    
    // 主題
//    'theme'=>'grey-stripes',
//    'theme'=>'abound',
//    'theme'=>'business3',
    
     
    // autoloading model and component classes
    'import'=>array(
            'application.models.*',
            'application.components.*',
            'application.modules.rights.*',
            'application.modules.rights.components.*',
            'application.modules.rights.components.dataproviders.*',
            'application.extensions.yiidebugtb.*', //debug extension
            'application.extensions.phpexcel.*', //phpexcel
//            'application.extensions.phpexcel.vendor.*', //phpexcel
//            'application.extensions.phpexcel.vendor.PHPExcel', //phpexcel
    ),

    'modules'=>array(
            // uncomment the following to enable the Gii tool
            'gii'=>array(
                    'class'=>'system.gii.GiiModule',
                    'password'=>'jit5566',
                    // If removed, Gii defaults to localhost only. Edit carefully to taste.
                    'ipFilters'=>array('127.0.0.1','::1'),
            ),
        'rights'=>array(
            'superuserName'=>'Admin',
            'userIdColumn'=>'empno',
            'userNameColumn'=>'username',
            'install'=>false,                                    // Enables the installer.
        ),	
    ),

    // application components
    'components'=>array(
        
            'user'=>array(
                    'class'=>'RWebUser',
                    // enable cookie-based authentication
                    'allowAutoLogin'=>true,
            ),
        
            'authManager'=>array(
                    // enable cookie-based authentication
                            'class'=>'RDbAuthManager',
            ),
            // uncomment the following to enable URLs in path-format

          'urlManager'=>array(
                    'urlFormat'=>'path',
                    'rules'=>array(
                            '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                            '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    ),
            ),


            'db'=>array(
// 本機                
                    'connectionString' => 'mysql:host=localhost;dbname=vhost47805-4',
                    'emulatePrepare' => true,
                    'username' => 'root',
                    'password' => '1234',
                    'charset' => 'utf8',
// WIS 匯智
//                    'connectionString' => 'mysql:host=localhost;dbname=jithouse_eip',
//                    'emulatePrepare' => true,
//                    'username' => 'jiteip',
//                    'password' => '13117826',
//                    'charset' => 'utf8',
// WIS 匯智測試機
//                    'connectionString' => 'mysql:host=localhost;dbname=jithouse_eip_test',
//                    'emulatePrepare' => true,
//                    'username' => 'jiteiptest',
//                    'password' => '13117826',
//                    'charset' => 'utf8',
// 智邦                    
//                    'connectionString' => 'mysql:host=localhost;dbname=vhost47805-4',
//                    'emulatePrepare' => true,
//                    'username' => 'vhost47805',
//                    'password' => '623100',
//                    'charset' => 'utf8',                                                      
            ),

            'errorHandler'=>array(
                    // use 'site/error' action to display errors
                    'errorAction'=>'site/error',
            ),
            'log'=>array(
                    'class'=>'CLogRouter',
                    'routes'=>array(
                            array(
                                    'class'=>'CFileLogRoute',
                                    'levels'=>'error, warning, trace',
                            ),
//                            array(
//                                'class'=>'XWebDebugRouter',
//                                'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
//                                'levels'=>'error, warning, trace, profile, info',
//                                'allowedIPs'=>array('127.0.0.1','::1','60.249.143.208'),
//                                ),                        
//                        array(
//                                'class'=>'CEmailLogRoute',
//                                'levels'=>'error, warning',
//                                'emails'=>'jitwinnie@gmail.com',
//                                'filter' => array(
//                                        'class' => 'CLogFilter',
//                                        'prefixUser' => true,
//                                    ),
//                                ),
                            // uncomment the following to show log messages on web pages                            
//                            array(
//                                    'class'=>'CWebLogRoute',
//                            ),
                    ),
            ), // log
//            'yexcel' => array(
//                'class' => 'ext.yexcel.Yexcel'
//            ),   
       'bootstrap'=>array(
        'class'=>'bootstrap.components.Bootstrap',
//        'coreCss' => true,
//        'responsiveCss' => true,
//        'yiiCss' => true,
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
            // this is used in contact page
            'adminEmail'=>'jitwinnie@gmail.com',
    ),  
      
);