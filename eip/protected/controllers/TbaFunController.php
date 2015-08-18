<?php

class TbaFunController extends RController
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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
            $this->render('view',array(
                    'model'=>$this->loadModel($id),
            ));
    }

    /**
     * Performs the AJAX validation.
     * @param TbaLogType $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
            if(isset($_POST['ajax']) && $_POST['ajax']==='tba-log-type-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }

    public function actionAudit()
    {  
        //得到起始 結束的年月日    
        $qry_dateS=date("Ymd", strtotime('-1 month')); //找尋前1個月
        $qry_dateE = date('Ymd');

        //得到所選日期區間
        if(isset($_POST['qry_dateS']))  $qry_dateS = $_POST['qry_dateS'];
        if(isset($_POST['qry_dateE']))  $qry_dateE = $_POST['qry_dateE'];

        // 篩選 logtype != 2 、  opt2 != 1, 獎懲, 遲到早退開小差, 代理 及其他都不計
        $sql= "SELECT logday,empno ,logname, num ,opt2 FROM tba_log
                    WHERE  logtype != 2 AND opt2 != 1 AND logitem !=16 AND logitem !=29  AND logday BETWEEN '$qry_dateS'  AND '$qry_dateE' 
                     ORDER BY logday DESC ";

        $result = Yii::app()->db->createCommand($sql)->queryAll();

         // output array
        $_array = array();   
        if(count(count($result)>0)) {
            // 用來比較的日期
            if(isset($result[0]['logday'])){
            $day = $result[0]['logday'];
            }
            // 用來比較的員編
            if(isset($result[0]['empno'])){
           $no = $result[0]['empno'];
            }
            //預設的array
            $logAry = array(
                'logday' =>'',
                'empno' => '',
                'logname' => '',
                'num' => 0
            );
            for ($i = 0; $i < count($result); $i++) {

                if($result[$i]['logday']==$day && $result[$i]['empno']==$no ) { //日期與員編相同
                    $logAry['logday'] = $result[$i]['logday'];
                    $logAry['empno'] = $result[$i]['empno'];
                    $logAry['logname'] = $logAry['logname'].' '.$this->auditByEmpFormat($result[$i]);//回傳字串相加
                    $logAry['num'] = $logAry['num'] + $result[$i]['num'];//num相加
                }else{         

                    array_push($_array, $logAry); 
                    $day = $result[$i]['logday']; //day設成進來的日期
                    $no = $result[$i]['empno']; //day設成進來的員編
                    $logAry = array(); //清空
                    $logAry['logday'] = $result[$i]['logday'];
                    $logAry['empno'] = $result[$i]['empno'];
                    $logAry['logname'] = $this->auditByEmpFormat($result[$i]);
                    $logAry['num'] = $result[$i]['num'];
                }
            }
            array_push($_array, $logAry);         
        }

        $final_result=array();
        if(count($_array)>0){                        
            for ($i = 0; $i < count($_array); $i++) {
                if($_array[$i]['num']>=1){  

                    //給sql查詢條件
                    $logday=$_array[$i]['logday'];
                    $empno=$_array[$i]['empno'];                   
                    $isExist= TbpPerformEmpLog::model()->findByAttributes(array(), 
                    $conditon = " pdate = '$logday' and empno = $empno ORDER BY pdate DESC "
                    );
                    if(isset($isExist)){ 
                        $temp = array(      //model塞值方式
                            'logdate' => $logday,
                            'storename' => $isExist->storename,
                            'empno'=> $isExist->empno,
                            'empname' => $isExist->empname,
                            'perform' => '有',
                            'logname' => $_array[$i]['logname'] //填入組合差勤假名稱
                        );
                       array_push($final_result,$temp);                          
                    }                                             
                }                    
            } 

        }                
         $this->render('audit',array( 
            'qry_dateS'=>$qry_dateS,
            'qry_dateE'=>$qry_dateE,                      
            'final_result'=>$final_result,            
        ));
    }
        
    /**
     * 將數字轉成符合需求的
     * @param array $log
     * @return real
     */
    private function auditByEmpFormat($log) {
        
        $str = $log['logname'];
        
        $num;
        
        if($log['num']==1) $num = '全天';
        elseif($log['num']==0.5) $num = '半天';
        else $num = $log['num'];
        
        $str = $str.'-'.$num;
        
        return $str ;
    }        
    
    /**
     * 
     */
    public function actionSettle()
    {
        
        //年月, 預設上個月
        $tmp = strtotime("-1 month", time());
        $qry_YM = date('Ym',$tmp);
        $qry_YM = '201405';

        $com = new ComFunction;
        
        //員編
        $qry_empno = '';
        //員工姓名
        $qry_empname = '';
        
        if(isset($_POST['qry_YM']))
            $qry_YM = $_POST['qry_YM'];
        if(isset($_POST['qry_empno']))
            $qry_empno = $_POST['qry_empno'];
        if(isset($_POST['qry_empname']))
            $qry_empname = $_POST['qry_empname'];
        
        // 標題列
        $title = array();
        // 欄位順序
        $col = array();
        // 畫面輸出陣列
        $output = array();        
        // 顯示差勤細項紀錄
        $showTotal = TRUE;
        
        if($_POST) {
            
            // 若員工編號或姓名不為空
            if($qry_empno !='')
            {
                $user = User::model()->findByPk($qry_empno);
                if(isset($user->emp))
                    $qry_empname = $user->emp->empname;
            }
            elseif($qry_empname !='')
            {
                $emp = TbsEmp::model()->findByAttributes(array('empname'=>$qry_empname));
                if(isset($emp))
                    $qry_empno = $emp->empno;
            }
            
            // 勾選顯示差勤
//            if(isset($_POST['showTotal']) && $_POST['showTotal'] == 1 )
//            $showTotal = TRUE;
            
            // 差勤結算
//            if(isset($_POST['settle'])) $showTotal = TRUE;
                
            // 取得此月份的國定假日
            $holidays = $com->getHolidayByYearMonth($qry_YM);

            // 取得所有的差勤項目
            $logitems = TbaLogItem::model()->findAllByAttributes(array('optshow'=>1));
            $items = array(); // 所有差勤項目
            $itemsettle = array(); // 差勤結算項目
            $itemname = array(); // 差勤名稱
            $itemdays = array(); // 以天計差勤項目 (公.婚.事.病.假.曠..)
            $itemmins = array(); // 以分計差勤項目 ( 遲到早退開小差 )
            $itemeach = array(); // 以支計差勤項目 ( 小過, 大過 )

            // 將資料分類
            foreach ($logitems as $item) {
                
                array_push($items, $item->id);
                $itemname[$item->id] = $item->logname;
                
                if($item->weight==1) {
                    if($item->logtype==1) {
                        if($item->opt2==0)
                            array_push($itemdays, $item->id);
                        else
                            array_push($itemmins, $item->id);
                    }else
                            array_push($itemeach, $item->id);
                }
                
                if($item->salaryitem != '')
                    $itemsettle[$item->id] = $item->salaryitem ;
            }
            
            // 輸出的表頭
            $title = $this->getWeightTitle($showTotal, $items, $itemdays, $itemmins, $itemeach, $itemname);   
            // 欄位順序
            $col = array_keys($title);
            
            // 取得差勤權重
            $logweights = TbaWeight::model()->findAllByAttributes(array('opt1'=>1));

            $nweight = array(); // 平日權重
            $hweight = array(); // 假日權重
            
            // 
            foreach ($logweights as $weight) {
                $nweight[$weight->logitem] = $weight->nweight;
                $hweight[$weight->logitem] = $weight->hweight;
                if($weight->opt2==1)
                    $nweight['opt2'] = $weight->nweight;
            }
                        
            // 計算權重
            // 查出目前所有的差勤紀錄
            // 每一天都丟進 $holidays 來判斷是否為假日
            // 再逐項去判斷是否有權重. 若有則再做計算.
            // 而權重要判斷成是以天計, 以分計, 還是以支計

            $aStart = $com->getTheFirstDayByYearMonth($qry_YM, "Ymd");
            $aEnd = $com->getTheLastDayByYearMonth($qry_YM, "Ymd");

            // 查出區間內之差勤紀錄, 依員編. 差勤項目. 排序
            $sql = "SELECT * 
                          FROM `tba_log` 
                       WHERE logday 
                   BETWEEN  '$aStart'
                           AND  '$aEnd' ";
            if($qry_empno != '') $sql = $sql."AND empno = '$qry_empno' ";
            $sql =$sql."ORDER BY empno, logitem, opt2";

            $logs = TbaLog::model()->findAllBySql($sql);

            // 針對每一筆. 先判斷是否有權重. 再判斷是那一種
            // logtype=1 => 天 => 再判斷平日.假日
            // logtype=1 => => opt2 = 1 ==> 分 , 該月累積超過30分, 則有權重
            // 支 => 每一筆皆有
            $emp = $logs[0]->empno;
            $empAry = array();
            $empAry['empname'] = $logs[0]->empname;

            for ($i = 0; $i < count($logs); $i++) {
                
                // 若符合要計算權重的項目才進行判斷
                if(in_array($logs[$i]->logitem, $items)) {
                    
                    // 同一個人一個 array 
                    if($logs[$i]->empno == $emp) {                        
                        if(isset($empAry[$logs[$i]->logitem]))
                            $empAry[$logs[$i]->logitem] = $empAry[$logs[$i]->logitem] + $logs[$i]->num ;
                        else
                            $empAry[$logs[$i]->logitem] = $logs[$i]->num ;
                        
                        $empAry = $this->setWeightValue($empAry, $logs[$i], $holidays, $nweight, $hweight);
                    }
                    else
                    {
                        // 寫入前, 把遲到分鐘數, 換算成權重
                        if(isset($empAry['opt2']) && isset($nweight['opt2']))
                            $empAry['opt2'] = $this->setLateWeight($empAry['opt2'],$nweight['opt2']);
                        else
                            $empAry['opt2'] = 0;
                        
                        $empAry['sum'] = $this->setSumWeight($col, $empAry);
                        $output[$emp] = $empAry;
                        $emp = $logs[$i]->empno;
                        
                        $empAry = array();
                        $empAry['empname'] = $logs[$i]->empname;
                        
                        if(isset($empAry[$logs[$i]->logitem]))
                            $empAry[$logs[$i]->logitem] = $empAry[$logs[$i]->logitem] + $logs[$i]->num ;
                        else
                            $empAry[$logs[$i]->logitem] = $logs[$i]->num ;
                        
                        $empAry = $this->setWeightValue($empAry, $logs[$i], $holidays, $nweight, $hweight);
                    }
                }// if(in_array($logs[$i]->logitem, $items)) 
            } // for ($i = 0; $i < count($logs); $i++) 
            
            if(isset($empAry['opt2']) && isset($nweight['opt2']))
                $empAry['opt2'] = $this->setLateWeight($empAry['opt2'],$nweight['opt2']);
            else
                $empAry['opt2'] = 0;
                        
            $empAry['sum'] = $this->setSumWeight($col, $empAry);
            $output[$emp] = $empAry;
            
            // 如果是結算, 則將結果寫入資料庫
            if(isset($_POST['settle'])) {
                
                // 先刪除該年月之資料
                $deleteAry = array();
                $param = TbmParam::model()->findByAttributes(array('param'=>'attend_settle'));
                if($param!=NULL){
                    $deleteAry = explode(",", $param->pvalue);
                }

                // 先刪除此年月之資料
                if($qry_empno!='' OR $qry_empname!='')
                    TbmEmpItem::model()->deleteAllByAttributes(array('daymonth'=>$qry_YM, 'empno'=>$qry_empno, 
                            'itemno'=>$deleteAry
                        ));
                else
                    TbmEmpItem::model()->deleteAllByAttributes(array('daymonth'=>$qry_YM,
                            'itemno'=>$deleteAry
                        ));
                $result = $this->createSettleItems($qry_YM,$itemsettle,$output);
                if(isset($result)) {
                    $check = isset($result[0])?$result[0]:FALSE;
                    $errmsg = isset($result[1])?$result[1]:"差勤結算失敗！";
                    if($check)
                        Yii::app()->user->setFlash('success', "[差勤結算]成功！$qry_YM 共計有 ".count($output)."筆 員工有差勤紀錄！");
                    else
                        Yii::app()->user->setFlash('error', "[差勤結算]失敗！$errmsg！");
                }
            }
            else {
                Yii::app()->user->setFlash('success', "[畫面輸出]查詢成功！$qry_YM 共計有 ".count($output)."筆 員工有差勤紀錄！");
            }
            
        } // if($_POST)
        else
            Yii::app()->user->setFlash('notice', "[畫面輸出]可以只查看此年月之差勤權重, 不會結算至薪資。[差勤結算]會將此年月之差勤結果寫入薪資項目，供薪資計算用。");

        $this->render('settle',
            array( 
                'qry_YM'=>$qry_YM,
                'qry_empno'=>$qry_empno,
                'qry_empname'=>$qry_empname,
//                'showTotal'=>$showTotal,
                'title'=>$title,
                'col'=>$col,
                'colAry'=>$output
            )
        );
    }
    
    /**
     * 
     * @param type $daymonth
     * @param type $itemsettle
     * @param type $empAry
     * @return Array - (boolean, string) 成功與否, 錯誤訊息 
     */
    private function createSettleItems($daymonth, $itemsettle, $empAry) {

        $itemsAry = array();
        foreach ($empAry as $empno => $logitems) {
            $late = 0;
            $empname = $logitems['empname'];
            // 只有要進入薪資項目的才建立
            foreach ($itemsettle as $logitem => $salaryitem) {
                if(isset($logitems[$logitem])) {
                    // 遲到, 早退, 開小差, 都是703, 要加起來
                    if($salaryitem == '703')
                        $late = $late + $logitems[$logitem];
                    else
                        array_push ($itemsAry, $this->createEmpItemMemo($daymonth, $empno, $empname, $salaryitem, $logitems[$logitem], ''));
                }
            }
            
            // 遲到
            if($late > 0)
                array_push ($itemsAry, $this->createEmpItemMemo($daymonth, $empno, $empname, '703', $late, ''));
            
            // 權重
            if(isset($logitems['sum']) && $logitems['sum'] > 0)
                array_push ($itemsAry, $this->createEmpItemMemo($daymonth, $empno, $empname, '801', $logitems['sum'], ''));
        }        
        
        // 寫入資料庫
        return $this->saveSettleItems($itemsAry);
    }


    /**
     * 計算並設定權重
     * @param type $empAry
     * @param type $log
     * @param type $nweight
     * @param type $hweight
     * @return type
     */
    private function setWeightValue($empAry, $log, $holidays, $nweight, $hweight) {
        
        if ($log->logtype == 1) {
            
            // 遲到部份, 累計滿30分後, 才開始計算權重, 所以先加總, 最後再判斷
            if($log->opt2 == 1) { 
                if(isset($empAry['opt2']))
                    $empAry['opt2'] = $empAry['opt2'] + $log->num;
                else
                    $empAry['opt2'] = $log->num;
            }else{
                
                // 要依平假日, 分開計算權重, 若是假日則使用 $hweight
                if($holidays[$log->logday]) {
                    if(isset($hweight[$log->logitem])) {
                        if(isset($empAry[$log->logitem.'h']))
                            $empAry[$log->logitem.'h'] = $empAry[$log->logitem.'h'] + $log->num * $hweight[$log->logitem];
                        else
                            $empAry[$log->logitem.'h'] = $log->num * $hweight[$log->logitem];
                    }
                }  else { // 平日則是 $nweight
                    if(isset($nweight[$log->logitem])) {
                        if(isset($empAry[$log->logitem.'n']))
                            $empAry[$log->logitem.'n'] = $empAry[$log->logitem.'n'] + $log->num * $nweight[$log->logitem];
                        else
                                $empAry[$log->logitem.'n'] = $log->num * $nweight[$log->logitem];
                    }
                }
            }                    

        }else{ // logtype == 2 ,  大小過, 若 opt3 == 1 客訴, 權重直接計算
            
            if($log->opt3 == 1) { // 客訴直接算
                
                if(isset($empAry[$log->logitem.'n']))
                    $empAry[$log->logitem.'n'] = $empAry[$log->logitem.'n'] + $log->num;
                else
                    $empAry[$log->logitem.'n'] = $log->num;
                
            }else{ // 大,小過, 依數量乘上權重
                if(isset($nweight[$log->logitem])) {
                    if(isset($empAry[$log->logitem.'n']))
                        $empAry[$log->logitem.'n'] = $empAry[$log->logitem.'n'] + $log->num * $nweight[$log->logitem];
                    else
                        $empAry[$log->logitem.'n'] = $log->num * $nweight[$log->logitem];
                }
            }
        }        
        
        return $empAry;
    }

    /**
     * 計算遲到權重
     * @param type $min
     * @param type $weight
     * @return int
     */
    private function setLateWeight($min, $weight) {
    
        $num = 0;
        
        if($min>30) {
            $num = ceil($min/60) * $weight ;
        }
        
        return $num;
    }

    /**
     * 設定權重合計
     * @param type $empAry
     * @return int
     */
    private function setSumWeight($col, $empAry) {
        
        $sum = 0;
        $check = FALSE;
        
        foreach ($col as $key) {
            
            if($check && isset($empAry[$key])) {
                $sum = $sum + $empAry[$key];
            }
            if($key == '|') $check = TRUE;
        }
        
        return $sum;
    }

        /**
     * 取得權重標題
     * @param type $showTotal
     * @param type $items
     * @param type $itemdays
     * @param type $itemmins
     * @param type $itemeach
     * @param type $itemname
     * @return string
     */
    private function getWeightTitle($showTotal, $items, $itemdays, $itemmins, $itemeach, $itemname){
        
        $ary = array(
            'empno'=>'員編',
            'empname'=>'姓名'
        );
        
        if($showTotal) {
            foreach ($items as $key => $id) {
                $ary[$id] = $itemname[$id];
            }

        }
        $ary['|'] = ' ';            
        foreach ($itemdays as $key => $id) {
            $ary[$id.'n'] = $itemname[$id].'<br>平日';
            $ary[$id.'h'] = $itemname[$id].'<br>假日';
        }
        
        $ary['opt2'] = '遲到';

        foreach ($itemeach as $key => $id) {
            $ary[$id.'n'] = $itemname[$id];
        }
        
        $ary['sum'] = '權重<br>合計';
        
        return $ary;
    }
    
    /**
     * 儲存結算結果
     * @param array $empSettleAry - array('02010007'=>array)
     * @param array $empSettle - array('02010007'=>'姓名')
     * @param string $daymonth
     * @return boolean
     * @throws @var:$empitem@mtd:getErrors
     */
    private function saveSettleItems($empSettleAry){
               
        $model =  TbmEmpItem::model();                    
        $transaction  = $model->dbConnection->beginTransaction();
        $valid = TRUE;
        $errorMsg = '';

        try {
            
            $sql = '';
            $result = 0;
            // 因為逐筆新增太耗資源, 直接一次全部寫入. 300個員工. 也不過 300 X 20 = 6000筆
            $sqlStart = "INSERT INTO `tbm_emp_item` (`id`, `daymonth`, `empno`, `empname`, `itemno`, `value`, `eachmonth`, `memo`, 
                            `opt1`, `opt2`, `opt3`, `cemp`, `uemp`, `ctime`, `utime`, `ip`) VALUES ";
            $sql = $sqlStart;
            $i = 0;
            
            foreach ($empSettleAry as $empitem) {



                $this->createData($empitem);        

                if($valid){

                    $sql = $sql."(DEFAULT, '$empitem->daymonth', '$empitem->empno', '$empitem->empname', '$empitem->itemno', ";
                    $sql = $sql."'$empitem->value', '$empitem->eachmonth', '$empitem->memo', '$empitem->opt1', '$empitem->opt2', ";
                    $sql = $sql."'$empitem->opt3', '$empitem->cemp', '$empitem->uemp', '$empitem->ctime', '$empitem->utime', '$empitem->ip'),";
                }else{

                    $valid =FALSE;
                    $errorMsg = $errorMsg."驗證失敗: $empitem->empname, $empitem->itemno 差勤結算失敗 !".CVarDumper::dumpAsString($empitem->getErrors())."<br>";
                    break;
                }

                if($i++ > 5000) {                            
                    $sql = substr_replace($sql, ";", -1);
                    $result = Yii::app()->db->createCommand($sql)->execute();
                    $sql=$sqlStart;
                    $i = 0;
                }

            }
            
            // 最後一將最後一個,號改成;號
            $sql = substr_replace($sql, ";", -1);
            $result = Yii::app()->db->createCommand($sql)->execute();

            if(!$valid or $result < 1 ){
                $valid = FALSE;
            }            
            
            if($valid){
                $transaction->commit();    
            }
            else{
                $errorMsg = " 差勤結算失敗 !<br>".$errorMsg;
                $transaction->rollback();
            }
            
        }catch(Exception $e){    
            $transaction->rollback();    
            throw $e;
        }
        
        return array($valid,$errorMsg);
    }        
    
    /**
     * 建立員工薪資項目&備註
     * @param type $daymonth
     * @param type $empno
     * @param type $empname
     * @param type $itemno
     * @param type $value
     * @param type $memo
     * @return TbmEmpItem
     */
    private function createEmpItemMemo($daymonth,$empno,$empname,$itemno,$value,$memo){
        
        $empitem = new TbmEmpItem;
        
        $empitem->daymonth   = $daymonth;
        $empitem->empno       = $empno;
        $empitem->empname   = $empname;
        $empitem->itemno       = $itemno;
        $empitem->value         = $value;
        $empitem->opt1 = '1';
        $empitem->memo = $memo;
        
        return $empitem;
    }        
}
