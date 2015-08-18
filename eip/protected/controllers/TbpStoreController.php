<?php

class TbpStoreController extends RController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column3';

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
     * 業績支出查詢
     * 提供門市人員查詢門市業績支出
     */
    public function actionStoreperform()
    {
        // 每一列業績
        $models = array();
        // 年月下拉陣列
        $dmAry = array();
        // 查詢年月
        $qry_date = '';        
        
        //得到起始 結束的年月日
        $sqlDate = "SELECT MID( pdate, 1, 6 ) as daymonth 
                            FROM  `tbp_perform` 
                          GROUP BY MID( pdate, 1, 6 ) 
                          ORDER BY daymonth DESC
                            LIMIT 2";
        
        $dateSqlResult = Yii::app()->db->createCommand($sqlDate)->queryAll();
        
        for ($i = 0; $i < count($dateSqlResult); $i++) {
            $daymonth = $dateSqlResult[$i]['daymonth'];
            $dmAry[$daymonth] = $daymonth;
        }
        

        // 查詢門市IP
         $myip = $this->getMyip();
        // 假ip，預設聯興的
//         $myip='60.249.143.210';       
        
        // 透過IP找尋對應門市
        $store = TbsStore::model()->findByAttributes(
            array('storeip1'=>$myip)
        );   
        
        // 門市零用金填寫日
        $outputDates = array();
        
        if(isset($_POST['qry_date'])) {
            
            $qry_date = $_POST['qry_date'];

            // 查詢門市業績及支出
            if(isset($store)) {
                
                $models = $this->createPerformData($store,$qry_date);
                $outputDates = $this->getOutputDates($store->storecode, $qry_date);
            }                         
        }

        $this->render('storeperform',
            array(
                'dmAry'=>$dmAry,
                'qry_date'=>$qry_date,
                'myip'=>$myip,
                'store'=>$store,
                'models'=>$models,
                'outputDates'=>$outputDates
            )
        );
    }
    
    /**
     * 全區業績支出
     * 提供會計組人員查詢門市業績支出
     */
    public function actionOfficeperform()
    {  
        $qry_area = ""; //區域
        $qry_store = ""; // 門市 
        $qry_date = "";
        // 每一列業績
        $models = array();
        // 年月下拉陣列
        $dmAry = array();
        
        if(isset($_POST['qry_area']))        $qry_area = $_POST['qry_area'];    
        if(isset($_POST['qry_store']))       $qry_store = $_POST['qry_store'];
        if(isset($_POST['qry_date']))        $qry_date = $_POST['qry_date'];
                        
        //得到起始 結束的年月日
        $sqlDate = "SELECT MID( pdate, 1, 6 ) as daymonth 
                            FROM  `tbp_perform` 
                          GROUP BY MID( pdate, 1, 6 ) 
                          ORDER BY daymonth DESC";
        
        $dateSqlResult = Yii::app()->db->createCommand($sqlDate)->queryAll();
        
        for ($i = 0; $i < count($dateSqlResult); $i++) {
            $daymonth = $dateSqlResult[$i]['daymonth'];
            $dmAry[$daymonth] = $daymonth;
        }

        //透過找尋對應門市
        $store = TbsStore::model()->findByAttributes(
            array('storecode'=>$qry_store)
        );         
        
        // 門市零用金填寫日
        $outputDates = array(); 
         
        if(isset($_POST['qry_date'])) {
            
            $qry_date = $_POST['qry_date'];

            // 查詢門$models = $this->createPerformData($store, $qry_date);市業績及支出
            if(isset($store)) {
                
                $models = $this->createPerformData($store, $qry_date);
                
                $outputDates = $this->getOutputDates($store->storecode,$qry_date);
            }                
            else
                Yii::app()->user->setFlash('error', '查無門市資料,請選擇門市!');
         
        }
        
         $this->render('officeperform',array(                    
                    'qry_area'=>$qry_area,
                    'qry_store'=>$qry_store,
                    'dmAry'=>$dmAry,
                    'qry_date'=>$qry_date,
                    'models'=>$models,         
                    'outputDates'=>$outputDates
                )
            );
    }
    
    private function getOutputDates($storecode,$pdate) {
        
        $outputDates= array();
        
        $sql = "SELECT pdate, sum(price) AS price FROM `tbp_output_log` ".
                "WHERE storecode = '$storecode' ".
                  "AND MID(pdate,1,6) = '$pdate' ".
                  "AND opt1 = 1 ".
                "GROUP BY pdate";
                
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        
        if(isset($result) && count($result)>0)
            for ($i = 0; $i < count($result); $i++) {
                $outputDates[$result[$i]['pdate']] = $result[$i]['price'];
            }
            
        return $outputDates;
    }


    private function createPerformData($store,$daymonth){
         
         // 每一列業績
         $models = array();
         //業績查詢
         if (isset($_POST['qry_perform'])) {
                           
            $models = TbpPerform::model()->findAllByAttributes(
                    array(),
                    $condition = "MID(pdate,1,6) = '$daymonth' AND storecode= '$store->storecode' "
                );
            
            if(isset($models) && count($models)>0)
                 Yii::app()->user->setFlash('success', '以下為查詢結果！');
            else
                  Yii::app()->user->setFlash('error', '查無當月業績！');
 
        }elseif (isset($_POST['qry_output'])){ //支出查詢               
            
            $models = TbpPerform::model()->findAllByAttributes(
                                array(),
                                $condition = "MID(pdate,1,6) = '$daymonth' AND storecode= '$store->storecode' AND output > 0 "
                            );

            if(isset($models) && count($models)>0)
               Yii::app()->user->setFlash('success', '以下為查詢結果！');
            else
               Yii::app()->user->setFlash('error', '當月無零用金輸出金額！');

        }else //elseif (isset($_POST['qry_output']))
            {
              Yii::app()->user->setFlash('notice', '請選擇年月，以查詢業績謝謝！');
            }
        
            return $models;
     }
     
}
