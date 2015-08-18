<?php
/**
 * 公用元件 Controller
 */
class TbsComController extends RController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';
        
 /**
   * Rights
   * @return array action filters
   */       
        
        public function filters()
  {
      return array(
          'rights',
      );
  }
  
  /**
   * Rights
   * @return array access control rules
   */
  public function accessRules()
  {
      return 'index, suggestedTags';
  }	 
  
  /**
   * 動態取得區域門市連動 
   * 
   * 判斷條件為 區域id 
   * 
   * 可接受二種型態 ( 二種型態只能擇一)
   * 1. 一般查詢欄位 ( 比如: qry_area )
   * url'=>CController::createUrl('tbsCom/dynamicstores',array('update'=>'qry_area')),
   * 2. MODEL欄位 ( 比如: TbaLog 的model, 欄位是 storecode )
   * 'url'=>CController::createUrl('tbsCom/dynamicstores',array('model'=>'TbaLog','column'=>'storecode','empty'=>FALSE)), //url to call.
   * 3. 若結果第一列不想為空, 再傳入empty變數, 範例如下
   * 'url'=>CController::createUrl('tbsCom/dynamicstores',array('empty'=>FALSE))
   * 4. 若要加入權限判斷
   * 'url'=>CController::createUrl('tbsCom/dynamicstores',array('right'=>TRUE))
   */
    public function actionDynamicstores()
    {
        // 第一列預設為空
        $empty = TRUE;
        // 第一列是否為空
        if(isset($_GET['empty'])) $empty = $_GET['empty'];
        
        // 由異動欄位來的值
        $areaid = '';
        if(isset($_GET['model']) && isset($_GET['column'])){
            $areaid = $_POST[$_GET['model']][$_GET['column']];
        }elseif(isset($_GET['update'])){
            $areaid = $_POST[$_GET['update']];
        }

        // 依傳入之areaid來查詢對應門市, 並且要已啟用
        $stores = array();
        if($areaid=='')
            $stores = TbsStore::model()->findAll();
        else
            $stores = TbsStore::model()->findAllByAttributes(
                    array(),
                    $condition  = "area_id = :id and opt1 = '1' order by storecode ",
                    $params     = array(
                        ':id'=>(int) $areaid,
                    )
                );

        // 取出店編號對應店名
        $data = CHtml::listData($stores,'storecode', 'storename');
        
        // 回傳至畫面
        // 連動結果第一筆為空
        if($empty) echo CHtml::tag('option',array('value'=>''),'選擇門市',true);
        
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
        }
    }
    
  /**
   * 動態取得門市員工連動
   * 
   * 判斷條件為 門市 storecode, 預設目前年月, 取得目前年月該門市之所屬員工
   * 1030527 當員工已離職. 若比目前年月早, 則在10號前仍可見
   * 比如: 5月離職員工. 在6/10以前皆可見, 6/11後不可見
   * 
   * 可接受二種型態 ( 二種型態只能擇一)
   * 1. 一般查詢欄位 ( 比如: qry_area )
   * url'=>CController::createUrl('tbsCom/dynamicstores',array('update'=>'qry_area')),
   * 2. MODEL欄位 ( 比如: TbaLog 的model, 欄位是 storecode )
   * 'url'=>CController::createUrl('tbsCom/dynamicstores',array('model'=>'TbaLog','column'=>'storecode','empty'=>FALSE)), //url to call.
   * 3. 若結果第一列不想為空, 再傳入empty變數, 範例如下
   * 'url'=>CController::createUrl('tbsCom/dynamicstores',array('empty'=>FALSE))
   */
    public function actionDynamicemps( )
    {
        // 第一列預設為空
        $empty = TRUE;
        // 第一列是否為空
        if(isset($_GET['empty'])) $empty = $_GET['empty'];
        
        // 取得目前年月
        $date = date('Ym');        
        
        // 由異動欄位來的值
        $storecode = '';
        if(isset($_GET['model']) && isset($_GET['column'])){
            $storecode = $_POST[$_GET['model']][$_GET['column']];
        }elseif(isset($_GET['update'])){
            $storecode = $_POST[$_GET['update']];
        }
        
        $sql = "SELECT a.empno, a.empname, a.daymonth, a.opt3 as status
                             FROM (
                                 tbs_emp_month a
                                 INNER JOIN (
                                     SELECT id, empno, MAX( daymonth ) AS daymonth, storecode
                                     FROM tbs_emp_month
                                     WHERE depart =  '3'
                                     AND daymonth <=  '$date'
                                     GROUP BY empno
                                 ) b 
                                 ON a.empno = b.empno AND a.daymonth = b.daymonth
                             ) 
                           WHERE a.storecode = '$storecode'
                           ORDER BY a.empno ";

         $result = Yii::app()->db->createCommand($sql)->queryAll();        

         $data = array();
         // 若已離職(opt3=2). 且daymonth比這個月小的. 
         // 則在10號後不放(算薪水後)
         for ($i = 0; $i < count($result); $i++) {
             if($result[$i]['daymonth'] < $date) {
                 if( $result[$i]['status'] !=2 )
                    $data[$result[$i]['empno']] = $result[$i]['empname'];
                 else{
                     if(date('d')<10)
                         $data[$result[$i]['empno']] = $result[$i]['empname'];
                 }
             }else
                $data[$result[$i]['empno']] = $result[$i]['empname'];
         }
         // 回傳至畫面
         //連動結果第一筆為空
         if($empty) echo CHtml::tag('option',array('value'=>''),'選擇員工',true);
         foreach($data as $value=>$name)
         {
             echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
         }
    }    
  

  /**
   * 動態取得差勤項目連動
   * 
   * 判斷條件為 logtype(差勤類別) 及 optshow(是否顯示) 預設為 1
   * 
   * 可接受二種型態 ( 二種型態只能擇一)
   * 1. 一般查詢欄位 ( 比如: qry_area )
   * url'=>CController::createUrl('tbsCom/dynamicstores',array('update'=>'qry_area')),
   * 2. MODEL欄位 ( 比如: TbaLog 的model, 欄位是 storecode )
   * 'url'=>CController::createUrl('tbsCom/dynamicstores',array('model'=>'TbaLog','column'=>'storecode','empty'=>FALSE)), //url to call.
   * 3. 若結果第一列不想為空, 再傳入empty變數, 範例如下
   * 'url'=>CController::createUrl('tbsCom/dynamicstores',array('empty'=>FALSE))
   */
    public function actionDynamiclogitems()
    {        
        // 第一列預設為空
        $empty = TRUE;
        // 第一列是否為空
        if(isset($_GET['empty'])) $empty = $_GET['empty'];
        
        // 由異動欄位來的值
        $logtype = '';
        if(isset($_GET['model']) && isset($_GET['column'])){
            $logtype = $_POST[$_GET['model']][$_GET['column']];
        }elseif(isset($_GET['update'])){
            $logtype = $_POST[$_GET['update']];
        }        
                
        // 依傳入之areaid來查詢對應門市, 並且要已啟用
        $items = TbaLogItem::model()->findAllByAttributes(
                array(),
                 $condition  = "logtype = :id and optshow = '1' order by seqno ",
                 $params     = array(
                     ':id'=>(int) $logtype,
                 )
             );

        // 取出店編號對應店名
        $data = CHtml::listData($items,'id', 'logname');
        
        // 回傳至畫面
        // 連動結果第一筆為空
        if($empty) echo CHtml::tag('option',array('value'=>''),'選擇項目',true);
        
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
        }
    }        
        
    
}
