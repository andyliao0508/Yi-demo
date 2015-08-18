<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <meta name="viewport" content="width=device-width, initial-scale=1　,user-scalable=1"/>
        
<!--     blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile_main.css" />
                   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/table.css" />
                   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/tablemulti.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

   
        <?php Yii::app()->bootstrap->registerAllCss(); ?> <!-- 使用yii bootstrap css-->   
        <?php echo Yii::app()->bootstrap->registerCoreCss(); ?>
        <?php echo Yii::app()->bootstrap->registerCoreScripts(); //為了yii bootstrap dropdown ?> 
        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<script>
$(document).ready(function(){
    $("input[type='submit']").click(function(){
        $("#divBlock").show();
    });
    $("input[type='text']").focus(function(){
        $(this).css("background-color","#FFEE00");
    });
    $("input[type='text']").blur(function(){
        $(this).css("background-color","#ffffff");
    });
});
</script>             
</head>

<body>
<div class="container" id="page">

    <div id="header">
        <table style="border: 0px solid black;">
            <tr>
                <td width="30%" >
                    <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?>
                </td>
                <td  style="text-align:left">
                    <div id="quote" >

                        <?php Yii::app()->clientScript->registerCoreScript("jquery");
                            if(!Yii::app()->user->isGuest) :
                        ?>
                        <script type="text/javascript">
                            setInterval(function()
                            {
                                $('#quote').load('<?php echo Yii::app()->createAbsoluteUrl("TbaBoard/getQuote"); ?>');
                            },5000);
                        </script>
                        <?php endif ?>
                    </div>
                </td>
            </tr>
        </table>
    </div><!-- header -->

    <div id="mainmenu">       
        <?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>'JIT-MENU',
    'brandUrl'=>'#',
    'fluid' => true,
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array( 
        array(
            'class'=>'bootstrap.widgets.TbMenu',           
             // 'encodeLabel'=>!Yii::app()->user->isGuest,
            'items'=>array(                           
                array('label'=>'首頁', 'url'=>array('/site/index'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'基本資料管理', 'url'=>'#','visible'=>!Yii::app()->user->isGuest,'items'=>array(
                array('label'=>'個人基本資料管理', 'url'=>array('/user/chgpwd')),
                array('label'=>'權限管理', 'url'=>array('/rights')),
//                array('label'=>'管理員工資料', 'url'=>array('/user/admin')),
                array('label'=>'管理員工資料', 'url'=>array('/user/useradmin')),
                array('label'=>'每月薪資異動', 'url'=>array('/tbsEmpMonth/admin')),
                array('label'=>'薪資保底管理', 'url'=>array('/tbsBasesalary/admin')),                                   
                array('label'=>'在職狀態管理', 'url'=>array('/tbsWorkstatus/admin')),
                array('label'=>'區店長責任額', 'url'=>array('/tbsAreaduty/admin')),
                array('label'=>'部門管理', 'url'=>array('/tbsDepart/admin')),
                array('label'=>'區域管理', 'url'=>array('/tbsArea/admin')),
                array('label'=>'門市管理', 'url'=>array('/tbsStore/admin')),
                array('label'=>'門市市話設備', 'url'=>array('/TbsStoreTelEquip/admin')),
                array('label'=>'銀行管理', 'url'=>array('/tbsBank/admin')),
                array('label'=>'投保單位管理', 'url'=>array('/tbsInscom/admin')),
                array('label'=>'投保薪資管理', 'url'=>array('/tbsInslabor/admin')),
                array('label'=>'服務項目管理', 'url'=>array('/tbsService/admin')),
                array('label'=>'服務項目類別', 'url'=>array('/tbsServiceType1/admin')),
                array('label'=>'門市對應服務', 'url'=>array('tbpStService/admin')),
                array('label'=>'業績系統變數', 'url'=>array('tbpParam/admin')),              
                )),
                
                array('label'=>'業績管理系統', 
                                //'url'=>'',
                                'url'=>'#',
                                'visible'=>!Yii::app()->user->isGuest,
                                'items' => array(
                                    array('label'=>'門市服務明細', 'url'=>array('viewStoreService/admin')),
                                    array('label'=>'個人業績查詢', 'url'=>array('tbpPerformAudit/performqry')),
                                    array('label'=>'匯款資料查詢', 'url'=>array('tbpPerformAudit/performremitqry')),
                                    array('label'=>'業績手動輸入', 'url'=>array('tbpPerform/create')),
                                    array('label'=>'業績重慶2輸入', 'url'=>array('tbpPerform/create2'), 'visible'=>(Yii::app()->request->userHostAddress=='60.251.46.74' OR Yii::app()->user->checkAccess('Admin'))),
                                    array('label'=>'業績全區輸入', 'url'=>array('tbpPerform/officecreate')),
                                    array('label'=>'業績紀錄修改', 'url'=>array('tbpPerform/admin')),
                                    array('label'=>'業績報表(個人)', 'url'=>array('tbpPerformRpt/rpt01')),
                                    array('label'=>'業績報表(四級)', 'url'=>array('tbpPerformRpt/rpt07')),
                                    array('label'=>'期中期末報表', 'url'=>array('tbpPerformRpt/rpt09')),
                                    array('label'=>'業績月報表', 'url'=>array('tbpPerformRpt/rpt10')),
                                    array('label'=>'管理部報表', 'url'=>array('tbpPerformRpt/rpt08')),
                                    array('label'=>'管理報表設定', 'url'=>array('tbpPerformParamRpt08/admin')),
                                    array('label'=>'管理報表名稱', 'url'=>array('tbpPerformParamRpt08Name/admin')),
                                    array('label'=>'管理報表類別', 'url'=>array('tbpPerformParamRpt08Type/admin')),
                                    array('label'=>'北一區期中期末', 'url'=>array('tbpPerformRpt/rpt81')),
                                    array('label'=>'北二區期中期末', 'url'=>array('tbpPerformRpt/rpt82')),
                                    array('label'=>'北三區期中期末', 'url'=>array('tbpPerformRpt/rpt83')),
                                    array('label'=>'桃竹苗期中期末', 'url'=>array('tbpPerformRpt/rpt84')),
                                    array('label'=>'中彰區期中期末', 'url'=>array('tbpPerformRpt/rpt85')),
                                    array('label'=>'嘉南區期中期末', 'url'=>array('tbpPerformRpt/rpt86')),
                                    array('label'=>'高屏一期中期末', 'url'=>array('tbpPerformRpt/rpt87')),
                                    array('label'=>'高屏二期中期末', 'url'=>array('tbpPerformRpt/rpt88')),
                                    array('label'=>'高屏三期中期末', 'url'=>array('tbpPerformRpt/rpt89')),
                                    array('label'=>'東區報表', 'url'=>array('tbpPerformRpt/rpt90')),
//                                    array('label'=>'業績報表(區域)', 'url'=>array('perform/report3')),
//                                    array('label'=>'業績報表(高階)', 'url'=>array('perform/report4')),
                                ),                            
                            ),
                
                  array('label'=>'公佈欄系統', 
                                //'url'=>'',
                                'url'=>'#',                              
                                'visible'=>!Yii::app()->user->isGuest,
                                'items' => array(
                                    array('label'=>'公佈欄變數', 'url'=>array('tbaParam/admin')),
//                                    array('label'=>'公佈欄', 'url'=>array('tbaBoard/boardindex')),
                                    array('label'=>'公佈欄管理', 'url'=>array('tbaBoard/admin')),
//                                    array('label'=>'公佈欄管理', 'url'=>array('tbaBoardEmpLog/admin')),
                                ),                            
                            ), 
                
                array('label'=>'差勤獎懲系統', 
                                //'url'=>array('/'),
                                'url'=>'',
                                'visible'=>!Yii::app()->user->isGuest,
                                'items' => array(
                                    array('label'=>'差勤變數', 'url'=>array('tbaParam/admin')),
                                    array('label'=>'差勤權重表', 'url'=>array('tbaWeight/admin')),
                                    array('label'=>'JIT國定假日', 'url'=>array('tbaHoliday/holiday')),
                                    array('label'=>'差勤類別管理', 'url'=>array('tbaLogType/admin')),
                                    array('label'=>'差勤項目管理', 'url'=>array('tbaLogItem/admin')),
                                    array('label'=>'請假單管理', 'url'=>array('tbaLog/create1')),
                                    array('label'=>'遲到早退管理', 'url'=>array('tbaLog/create2')),
                                    array('label'=>'獎懲單管理', 'url'=>array('tbaLog/create3')),
                                    array('label'=>'差勤奬懲管理', 'url'=>array('tbaLog/querylog')),
                                    array('label'=>'差勤異常查詢', 'url'=>array('tbaFun/audit')),
                                    array('label'=>'差勤權重結算', 'url'=>array('tbaFun/settle')),
                                ),                            
                            ),                              
                
                array('label'=>'薪資管理系統', 
                                //'url'=>array('/'),
                                'url'=>'',
                                'visible'=>!Yii::app()->user->isGuest,
                                'items' => array(
                                    array('label'=>'薪資公用變數', 'url'=>array('tbmParam/admin')),
                                    array('label'=>'權重表', 'url'=>array('tbmWeight/admin')),
                                    array('label'=>'薪資項目表', 'url'=>array('tbmItem/admin')),
                                    array('label'=>'薪資項目群組表', 'url'=>array('tbmItemGroup/admin')),
                                    array('label'=>'薪資項目類別表', 'url'=>array('tbmItemType/admin')),
                                    array('label'=>'員工薪資項目', 'url'=>array('tbmEmpItem/admin')),
                                    array('label'=>'員工薪資匯入', 'url'=>array('tbmEmpItem/import')),
                                    array('label'=>'薪資產製結算', 'url'=>array('tbmSalary/salary')),
                                    array('label'=>'薪資修正', 'url'=>array('tbmSalary/modify')),
                                    array('label'=>'薪資檢核', 'url'=>array('tbmSalary/audit')),
                                    array('label'=>'薪資單列印', 'url'=>array('tbmPayroll/createpayroll')),
                                    array('label'=>'薪資封存拆算', 'url'=>array('tbmSalary/archive')),
                                    array('label'=>'歷史薪資計算', 'url'=>array('tbmHistory/admin')),
                                ),                            
                            ),                 
                    
                        array('label'=>'MIS功能', 
                               // 'url'=>array('/'),
                                'url'=>'',
                                'visible'=>Yii::app()->user->getId()=='01010475',
                                'items' => array(
                                    array('label'=>'密碼初始化', 'url'=>array('tbsAdmin/init')),
                                    array('label'=>'測試功能', 'url'=>array('tbsAdmin/test'))
                                ),                            
                            ),                               
                 array('label'=>'登入', 'url'=>array('/site/login'),  'visible'=>Yii::app()->user->isGuest),
                 array('label'=>'登出 ( '.Yii::app()->user->name.' )', 'url'=>array('/site/logout'),'visible'=>!Yii::app()->user->isGuest),
            ),
        ),     
    ),
)); ?>
    </div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

<div id="divBlock" 
    style="
    position: absolute;
    top: 30%;
    left: 35%;
    margin-top: -50px;
    margin-left: -50px;
    width: 50%;    //100px
    height: 50%;  //100px
    filter: Alpha(Opacity=80);
    display: none;">
<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif">
</div>

</body>
</html>
