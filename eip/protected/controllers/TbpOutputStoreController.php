<?php
/**
 * 門市零用金支出
 */
class TbpOutputStoreController extends RController
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
            if(isset($_POST['ajax']) && $_POST['ajax']==='tbp-outputstore-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }
    
    public function loadModel($id)
    {
            $model=TbpOutputLog::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
            return $model;
    }
    
    /**
     * 新增修改 門市支出明細
     */
    public function actionCreateandupdate()
    {
        
        $storecode='';
        $pdate = '';     

        if(isset($_GET['storecode'])) $storecode = $_GET['storecode'];//門市編號
        if(isset($_GET['pdate'])) $pdate = $_GET['pdate'];//門市日期
        
        // 是否存在(合法)
        $isExist = TRUE;
        // 門市
        $store = '';
        // 門市當天業績
        $perform = '';
        // 錯誤訊息
        $errorMsg = '';
        
        // 畫面顯示
        $result = array();
         
        //如果有門市編號及日期不為空, 就查出那一家門市資料
        if($storecode != '' && $pdate !=''){
            
            $store = TbsStore::model()->findByAttributes(array('storecode'=>$storecode));
            if(isset($store)) {
                
                //取得目前IP
                $myip = $this->getMyip();
                //$myip='211.75.115.206';
                //假ip，預設高雄聯興
    //            $myip='60.249.143.210';

                // 比較登入者門市的IP,是否合法
                if(!strstr($store->storeip1,$myip)){
                    $isExist = FALSE;
                    $errorMsg = "錯誤！所查詢之資料不屬於貴門市 [ IP: $myip ] ～請洽資訊組, 分機306<br>";
                }
                $perform = TbpPerform::model()->findByAttributes(array('pdate'=>$pdate,'storecode'=>$storecode,'opt1'=>1));
                if(!isset($perform)) {
                    $isExist = FALSE;
                    $errorMsg = $errorMsg."錯誤！所查詢之門市[$store->storename]、日期[$pdate]無業績資料！";
                }elseif($perform->output < 1) {
                    $isExist = FALSE;
                    $errorMsg = $errorMsg."錯誤！所查詢之門市[$store->storename]、日期[$pdate]當天支出為 0 ！";                    
                }
            }
            else{
                $isExist = FALSE;
                $errorMsg="錯誤！所查詢之門市 [ $storecode ] 不存在～請洽資訊組, 分機306";
            }
        }else{
            $isExist = FALSE;
            $errorMsg='錯誤！不正確的進入方式～請重新開啟EIP～若一直出現此情況，請洽資訊組, 分機306';
        }
        
        // 檢核日期是否合乎規範
        if($isExist){
            $isExist=$this->checkDate($pdate); 
            if(!$isExist)
               $errorMsg = $errorMsg.'已超過門市可修改門市支出明細時間，請聯絡會計組進行處理!!';
        }
               
        // 預設筆數, 由公用變數取得
        $default_num = 0;
        
        if(isset($_POST['default_num']) && $_POST['default_num'] > 0) {
            
                $default_num = $_POST['default_num'];
                Yii::app()->user->setFlash('success', '修改顯示筆數成功，請依照主、次、細項點選，金額必須填入!!');
                
        }else{
                $tbpParam = TbpParam::model()->findByAttributes(array('param'=>'output_num'));
                if($tbpParam!=NULL) $default_num = $tbpParam->pvalue;      
        }        
        
            //針對F5重複刷新做解決
           //The second parameter on print_r returns the result to a variable rather than displaying it
            $RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));
  
            if (Yii::app()->session['LastRequest'] == $RequestSignature)
            {          
                //echo $RequestSignature ;
                // 畫面顯示
                $result = TbpOutputLog::model()->findAllByAttributes(array('pdate' => $perform->pdate, 'storecode' => $perform->storecode));
            }
            else
            {
                
                // 若當天有業績, 且業績大於0
                if(!isset($_POST['reload']) && isset($_POST['TbpOutputLog']) && isset($perform) && $perform->output > 0)
                        $result = $this->createOutputData($result, $perform);
                else
                    // 畫面顯示
                    $result = TbpOutputLog::model()->findAllByAttributes(array('pdate' => $perform->pdate, 'storecode' => $perform->storecode));
                      Yii::app()->session['LastRequest'] = $RequestSignature;
            }
        
        $result_num = isset($result)?count($result):0;
        
        if(isset($_POST))
            if($result_num>0) {
                Yii::app()->user->setFlash('notice', '修改細項時，仍需按照主、次、細項點選，金額必須大於0才會紀錄!!');
            }else{
                Yii::app()->user->setFlash('notice', '請按照主、次、細項點選，金額必須大於0才會紀錄!!');
            }
        
            
        // 員工列數, 利用預設值產出列數
        if($result_num < $default_num)
            for ($i = 0; $i < ($default_num - $result_num); $i++) {
                // 零用金支出表紀錄
                $model = new TbpOutputLog;
                array_push($result, $model);
            }
        
        $this->render('createandupdate',array(           
                'pdate'=>$pdate,
                'store'=>$store,
                'perform'=>$perform,
                'isExist'=>$isExist,
                'default_num'=>$default_num,
                'array'=>$result,          
                'errorMsg'=>$errorMsg,
            )
        );  
    }

        
    /**
     * 全區業績支出
     */
    public function actionOfficecreate()
    {
    //  CVarDumper::dump($_POST,10,true) ;
        $qry_store='';
        //日期初始值
        $qry_date=date('Ymd');
             
        if(isset($_POST['qry_store']))        $qry_store = $_POST['qry_store'];
        if(isset($_POST['qry_date']))        $qry_date = $_POST['qry_date'];
           
        // 輸入列
        $array = array();                    
        
        //初始值
        $default_num=0;
         
        //得到更新欄位資料
        $default_num=$this->getOutputUpdate();
                
        //以門市編號找門市            
        $store = array();

        if($qry_store!=''){

               $store = TbsStore::model()->findAllByAttributes(array('storecode'=>$qry_store,'opt1'=>'1'));

              if(count($store)==0)
                  Yii::app()->user->setFlash('error', '查無任何資料');

               $array= $this->createOutputData($default_num,$store[0],$qry_date); 

        }
        
          
        $this->render('officecreate',array(               
                   'qry_store'=>$qry_store,
                   'qry_date'=>$qry_date,                
                   'default_num'=>$default_num,
                   'store'=>$store,
                   'array'=>$array,
                                  
               ));   
        
    }
    
    public function actionOutputcheck()
    {
        $qry_area = ""; //區域
        $qry_store='';
        $qry_date = date('Ym');
        
             
        if(isset($_POST['qry_area']))          $qry_area = $_POST['qry_area']; 
        if(isset($_POST['qry_store']))        $qry_store = $_POST['qry_store'];
        if(isset($_POST['qry_date']))        $qry_date = $_POST['qry_date'];
        
        
        
         //儲存塞選出的門市的店編
        $sqlStroe = array();
        
        //如果有選門市,就只選出那一家門市
        if($qry_store != '')
            $tbsStroes = TbsStore::model()->findAllByAttributes(array('storecode'=>$qry_store));
        //如果只選區域,就選出區域內的所有門市
        elseif($qry_area != '')
            $tbsStroes = TbsStore::model()->findAllByAttributes(array('area_id'=>$qry_area));
        //如果都沒有選,就全部選出來
        else
            $tbsStroes = TbsStore::model()->findAll();
        
        foreach ($tbsStroes as $store) {
            //找出篩選出的門市的區域代碼
            $area = TbsArea::model()->findByPK($store->area_id);
            if($area!=NULL){
                //push店編
                array_push($sqlStroe, $store->storecode);
                //店編對應區域名稱              
            }
        }
       
        // 查詢用的SQL
        $qryStr = '';
        
        //如果有選門市或區域就需要sql=AND storecode in('007001',007002')  
        if($qry_store != '' OR $qry_area != '') {
            //sql=sql.in('007001')因為只有一筆的時候沒有' , '  所以直接把店編放進去
            if(count($sqlStroe)>0) {
                $qryStr = "storecode in ('$sqlStroe[0]'";
                //如果門市>1,就需要' , '
                if(count($sqlStroe)>1)
                    for ($i = 1; $i < count($sqlStroe); $i++) {
                        $qryStr = $qryStr.",'$sqlStroe[$i]'";
                    }
                $qryStr = $qryStr.")";
            }
        }
       
         //得到起始 結束的年月日
        $sqlDate = "SELECT MID( pdate, 1, 6 ) as daymonth FROM  `tbp_perform` GROUP BY MID( pdate, 1, 6 ) ORDER BY daymonth DESC";
        $dateSqlResult = Yii::app()->db->createCommand($sqlDate)->queryAll();
      
        $dmAry = array();
        for ($i = 0; $i < count($dateSqlResult); $i++) {
            $daymonth = $dateSqlResult[$i]['daymonth'];
            $dmAry[$daymonth] = $daymonth;
        }
        
         //切割出年份
         $tmp_year=substr($qry_date,0,4);
         //切割出月份
         $tmp_mon =substr($qry_date,4,2);
         
         $aStart = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));//月初
         $aEnd = date("Ymd", mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year));//月底
                         
        // 判斷是有查詢某門市
         $store = array();
                      
        if($qryStr!=''){
            $store = TbsStore::model()->findAllByAttributes(
                                 array(),                              
                                 $condition = " $qryStr AND opt1 = '1' "
                         );          
        }

       // 當月每一列支出明細
       $models = array();
       
      if (isset($_POST['qry'])) {
          
         if(count($store)==0){
              Yii::app()->user->setFlash('error', '查無門市資料,請選擇門市!');
          }else
          {
             //針對每一間門市, 再去查它每一天是否有支出
             foreach ($store as $row) {

                 // 由起始日開始+1天, 一直到結束日
                 // 不能直接累加. 要用date來算 
                 $dateS = date_parse($aStart);
                 $i = 0;
                 // do while 是至少會做一次. 也就是當 qry_dateS 跟 qry_dateE 相同時. 至少會做一次
                  do {
                     $check_date = gmdate('Ymd', gmmktime(0,0,0,$dateS['month'],$dateS['day']+$i,$dateS['year']));

                     // 依日期, 門市.查詢該天的支出
                     $output = TbpOutputLog::model()->findAllByAttributes(array(),
                                $conditon = " pdate = '$check_date' and storecode= '$row->storecode' and opt1=1"
                             );

                       //假如有支出,則在下面顯示支出
                     if($output != NULL){
                          array_push($models,$output);                                            
                     }                                                                  
                     $i++;
                 } while($aEnd!=$check_date);

             }// foreach ($store as $row) {        
             
              if(isset($models) && count($models)>0){
                  //統計一維陣列
                 // Yii::app()->user->setFlash('success', '查詢成功！查詢結果合計 '.count($models).' 天資料！');
                  //統計二維陣列筆數
                  Yii::app()->user->setFlash('success', '查詢成功！合計 '.(count($models, COUNT_RECURSIVE) - count($models)).' 筆資料！');               
              }else
                    Yii::app()->user->setFlash('error', '無零用金輸出明細！');
          }
      }//if (isset($_POST['qry'])) {     
      //CVarDumper::dump($store,10,true);
        $this->render('outputcheck',array(
                    'qry_area'=>$qry_area,
                    'qry_store'=>$qry_store,
                    'dmAry'=>$dmAry,
                    'qry_date'=>$qry_date,
                    'models'=>$models,
               ));
    }
    
     public function actionInputcheck()
    {
        $qry_date = date('Ym');
             
        if(isset($_POST['qry_date']))        $qry_date = $_POST['qry_date'];
        
         //得到起始 結束的年月日
        $sqlDate = "SELECT MID( pdate, 1, 6 ) as daymonth FROM  `tbp_perform` GROUP BY MID( pdate, 1, 6 ) ORDER BY daymonth DESC";
        $dateSqlResult = Yii::app()->db->createCommand($sqlDate)->queryAll();
      
        $dmAry = array();
        for ($i = 0; $i < count($dateSqlResult); $i++) {
            $daymonth = $dateSqlResult[$i]['daymonth'];
            $dmAry[$daymonth] = $daymonth;
        }
        
         // 區域
        $areaAry = array();
        $TbsAreas = TbsArea::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsAreas as $area) {
            $areaAry[$area->id] = $area->areaname;
        }
        unset($TbsAreas);  
        
        //門市區域ID       
        $storeAreaId = array();
        $TbsStores = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsStores as $store) {           
            $storeAreaId[$store->storecode] = $store->area_id;
        }        
        unset($TbsStores); 
        
        //紀錄資料
        $colAry = array();
       
      if (isset($_POST['fill_qry'])) {                    
          
           $sql='';
           //合併查詢(有支出，支出表沒填)
           $sql = "SELECT  a.pdate,a.storecode,a.storename,a.output from
                        (SELECT pdate,storecode,storename,output FROM tbp_perform 
                         WHERE  mid(pdate,1,6)=$qry_date and output>0  
                         ORDER BY storecode ASC, pdate ASC) a
                         LEFT JOIN
                        (SELECT pdate,storename, sum(price) as output FROM tbp_output_log 
                         WHERE  mid(pdate,1,6)=$qry_date and price>0  
                         GROUP BY  pdate,storecode 
                         ORDER BY storecode ASC, pdate ASC) b
                            ON  a.storename=b.storename and a.pdate=b.pdate
                            WHERE b.storename is null and b.pdate is null
                            ORDER BY a.storecode , a.pdate ";
           
            $result = Yii::app()->db->createCommand($sql)->queryAll();
          
             if($result>0){
             foreach ($result as $nofill_Data) {  
                  $row = array(); 
                    // 日期
                    $row['pdate'] = $nofill_Data['pdate'];
                    //區域
                    $row['area'] = isset($nofill_Data['storecode']) ? $areaAry[$storeAreaId[$nofill_Data['storecode']]]:'';                    
                    // 門市名稱
                    $row['storename'] = $nofill_Data['storename'];
                    //支出金額
                    $row['output'] = $nofill_Data['output'];
                     array_push($colAry, $row);
             }
        } //if($result>0){
     
        if(count($colAry)>0)
               Yii::app()->user->setFlash('success', '以下為零用支出明細未填入的門市清單！');
            else
               Yii::app()->user->setFlash('error', '查詢不到未輸入支出明細門市！');
        
      }elseif (isset($_POST['conform_qry'])){ //金額不符合查詢 
          
           $sql='';
           //合併查詢 (金額不符查詢)
           $sql = "SELECT  a.pdate,a.storecode,a.storename,a.output from
                        (SELECT pdate,storecode,storename,output FROM tbp_perform 
                         WHERE  mid(pdate,1,6)=$qry_date and output>0  
                         ORDER BY storecode ASC, pdate ASC) a
                         INNER JOIN
                        (SELECT pdate,storename, sum(price) as output FROM tbp_output_log 
                         WHERE mid(pdate,1,6)=$qry_date and price>0  and opt1=1
                         GROUP BY  pdate,storecode 
                         ORDER BY storecode ASC, pdate ASC) b
                        ON a.output<>b.output and a.storename=b.storename and a.pdate=b.pdate
                        ORDER BY a.storecode , a.pdate";
           
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            
            if($result>0){
                foreach ($result as $conform_Data) {  
                     $row = array(); 
                       // 日期
                       $row['pdate'] = $conform_Data['pdate'];
                       //區域
                       $row['area'] = isset($conform_Data['storecode']) ? $areaAry[$storeAreaId[$conform_Data['storecode']]]:'';
                       // 門市名稱
                       $row['storename'] = $conform_Data['storename'];
                       //支出金額
                       $row['output'] = $conform_Data['output'];
                        array_push($colAry, $row);
                }
            } //if($result>0){
            
            if(count($colAry)>0)
               Yii::app()->user->setFlash('success', '以下為零用支出金額不符合門市清單！');
            else
               Yii::app()->user->setFlash('error', '查詢不到金額不符合支出明細門市！');
         
      }
        
       
     //    CVarDumper::dump($colAry,10,true);
         $this->render('inputcheck',array(
                    'qry_date'=>$qry_date,
                    'dmAry'=>$dmAry,
                    'colAry'=>$colAry,
               ));
         
    }
          
    /**
     * 新增支出
     * @param type $perform
     */
    private function createOutputData($array, $perform) {

        //支出金額初始值
        $outputTotal = 0;
        
        // 取得LOG的類別及細項
        $ary = $this->getLogItem();
        $logItemArray = $ary[0]; // 細項
        $logTypeArray = $ary[1]; // 類別
        $logMainArray = $ary[2]; // 主項
        $logSubArray = $ary[3]; // 次項
        
        // 錯誤訊息
        $errMsg = '';

        $model =  TbmEmpItem::model();             
        $transaction  = $model->dbConnection->beginTransaction();
        
        try{
            // 處理刪除
            $checkDelete = TRUE;
            // 驗證
            $valid = TRUE;
            // 刪除與取消刪除優先處理
            if (isset($_POST['TbpOutputLog'])) {
                foreach ($_POST['TbpOutputLog'] as $j => $TbpOutputLog) {
                    if (isset($_POST['TbpOutputLog'][$j])) {

                        $array[$j] = new TbpOutputLog;
                        $array[$j]->attributes = $TbpOutputLog;
                        $array[$j]->pdate = $perform->pdate;
                        $array[$j]->storecode = $perform->storecode;
                        $array[$j]->storename = $perform->storename;
                        // 幫itemID都查詢好main跟sub
                        if($array[$j]->itemid != '') {
                            $array[$j]->itemname = $logItemArray[$array[$j]->itemid];    //得到細項名稱
                            $array[$j]->type = $logTypeArray[$array[$j]->itemid];           //得到細項型態
                            $array[$j]->mainid = $logMainArray[$array[$j]->itemid];       //得到主項ID
                            $array[$j]->subid = $logSubArray[$array[$j]->itemid];           //得到次項ID
                        }

                        if ($TbpOutputLog['id'] != '') {
                            
                            $array[$j]->id = $TbpOutputLog['id'];

                            //當按了支出明細的刪除
                            if (isset($_POST[$j . 'delete'])) {  // Yii::app()->user->setFlash('success', '1');
                                
                                $array[$j] = TbpOutputLog::model()->findByPk($TbpOutputLog['id']);
                                $array[$j]->opt1 = 0;
                                $this->updateData($array[$j]);
                                $valid = $array[$j]->save() && $valid;
                                $checkDelete = FALSE;
                                
                            }elseif (isset($_POST[$j . 'cancel_del'])) { //當按了支出明細的取消刪除

                                $array[$j] = TbpOutputLog::model()->findByPk($TbpOutputLog['id']);
                                $array[$j]->opt1 = 1;
                                $this->updateData($array[$j]);
                                $valid = $array[$j]->save()&& $valid;
                                $checkDelete = FALSE;
                            }
                            if (!$valid) $errMsg = $errMsg.'第'.($j+2).'筆'.CVarDumper::dumpAsString($array[$j]->getErrors().'<br>');                            
                            
                        }// if($TbpOutputLog['id'] != '') {
                    }// if (isset($_POST['TbpOutputLog'][$j])) {
                }//foreach ($_POST['TbpOutputLog'] as $j=>$TbpOutputLog)
            }        

            if ($checkDelete && isset($_POST['send'])) {


                // 先針對所有的資料，做一次加總，看看總和對不對
                foreach ($array as  $log) {

                    // 以 price、itemid 值判斷金額相加
                    if ($log->itemid !='' && $log->price > 0) {
                        $outputTotal = $outputTotal + $log->price; //支出金額相加                                                                
                    }
                }

                // 檢查總計是否正確
                if ($perform->output > 0) {

                    if ($perform->output == $outputTotal)
                        Yii::app()->user->setFlash('success', '支出金額: ' . $perform->output . ' 與零用金明細金額: ' . $outputTotal . ' 吻合!');
                    else {
                        Yii::app()->user->setFlash('error', '支出金額: ' . $perform->output . ' 與零用金明細金額: ' . $outputTotal . ' 比對不吻合，重新輸入!!');
                        $valid = false;
                    }
                }                
                                
                if($valid) {

                    // 先針對所有的資料，做一次加總，看看總和對不對
                    foreach ($array as $k => $log) {

                        // 判斷資料是否已存在
                        if ($array[$k]->id != '') {

                            $tbpLog = TbpOutputLog::model()->findByPk($array[$k]->id);

                            if (isset($tbpLog)) {

                                /* 不加下面這個 下面$array[$i]->save(FALSE)資料庫驗證會錯誤 */
                                
                                $theSame = $array[$k]->compare($tbpLog);
                                $array[$k]->isNewRecord = FALSE; //他是舊的,如果是true Yii會認為是新的create

                                if (!$theSame) $this->updateData($array[$k]);
                            }
                        }else {// if($TbpOutputLog['id'] != '')
                            $this->createData($array[$k]);
                        }                    

                        // 以 price、itemid 值判斷
                        if ($array[$k]->itemid !='' && $array[$k]->price > 0) {
                            $valid = $array[$k]->validate() && $valid;
                            if (!$valid) $errMsg = $errMsg.'第'.($k+2).'筆'.CVarDumper::dumpAsString($array[$k]->getErrors().'<br>');
                        }

                    }

                    if($valid) {

                        for ($i = 0; $i < count($array); $i++) {

                            if (isset($array[$i]) && $array[$i]->price > 0 && $array[$i]->itemid != '')
                                $array[$i]->save(FALSE);
                        }                
                    }
                }

                if($errMsg!='') Yii::app()->user->setFlash('error', $errMsg);

            }
            
            
            if($valid){
                $transaction->commit();    
//                Yii::app()->user->setFlash('success', "成功！");
            }
            else{
                $transaction->rollback();
//                Yii::app()->user->setFlash('error', $errMsg ."失敗！");
            }            
            
        }catch(Exception $e){    
            $transaction->rollback();    
            throw $e;
        }

        
        return $array;
    }
      
    /**
     * 驗證日期是否可輸入支出
     * @param type $pdate
     * @return boolean
     */
    private function checkDate($pdate) {
        
        $valid=true;

        //當日年月份
        $today = date('Ymd', time());

        //切割出年份
        $tmp_year=substr($today,0,4);
        //切割出月份
        $tmp_mon =substr($today,4,2);

        //月初1號
        $mon_first = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));
        //月初2號
        $mon_Second = date("Ymd", mktime(24, 0, 0, $tmp_mon, 1, $tmp_year)); 
        //前一個月
        $last_month= date("Ymd", strtotime('-1 month'));
        //切割出前一個月的月份
        $tmp_last_mon =substr($last_month,4,2);
        //前一個月初
        $last_First = date("Ymd", mktime(24, 0, 0, $tmp_last_mon, 0, $tmp_year));
        //前一個月底 
        $last_End = date("Ymd", mktime(0, 0, 0, $tmp_last_mon+1, 0, $tmp_year));

        //日期小於當月1號
        if($pdate<$mon_first){
            $valid=false;
            //如果當天日期是當月1.2號依然可輸入前一個月支出
            if($today==$mon_first OR $today==$mon_Second){
                    //由起始日開始+1天, 一直到結束日
                    // 不能直接累加. 要用date來算 
                    $dateS = date_parse($last_First);
                    $i = 0;
                    // do while 是至少會做一次.
                     do {
                        $check_date = gmdate('Ymd', gmmktime(0,0,0,$dateS['month'],$dateS['day']+$i,$dateS['year']));

                          //假如日期相同，則$valid=true
                        if(strstr($pdate,$check_date) == true){
                            $valid =true;                                           
                        }                                                                  
                        $i++; 
                    } while($last_End!=$check_date);
            }    
        }

        return $valid;
    }
    
    /**
     * 取得細項項目屬性
     * @return type
     */
    private function getLogItem() {

        $ary1 = array(); // 中文字
        $ary2 = array(); // 類別
        $ary3 = array(); // 主項
        $ary4 = array(); // 次項

        $items = TbpOutputItem::model()->findAll();
        
        foreach ($items as $item) {
            $ary1[$item->id] = $item->cname;
            $ary2[$item->id] = $item->type;
            $ary3[$item->id] = $item->mainid;
            $ary4[$item->id] = $item->subid;
        }
        
        return array($ary1,$ary2,$ary3,$ary4);
    }
    
    //動態型態
//     public function actionDynamicemps( )
//    {     
//        // CVarDumper::dump($_POST,10,true);
//        $index='';
//        $row = '';
//       
//        if(isset($_GET['index'])) $row = $_GET['index'];
//        if(isset($_POST)) $index = $_POST['TbpOutputLog'][$row]['type'];
//        
//        $model = new TbpOutputLog;
//        $this->renderPartial('_type'.$index,array('model'=>$model,'row'=>$row), false, true);    
//           
//    }  
//    
    //動態次項
     public function actionDynamicoutputsubs()
    {
          
        $row = '';
        $mainid = '';
       
        if(isset($_GET['index'])) $row = $_GET['index'];
        // 由異動欄位來的值
        if(isset($_POST)) $mainid = $_POST['TbpOutputLog'][$row]['mainid'];
        
      
        // 依傳入之mainid來查詢對應次項, 並且要已啟用
        $sub = TbpOutputSub::model()->findAllByAttributes(
                array(),
                 $condition  = "mainid = :id and opt1 = '1' order by mainid ",
                 $params     = array(
                     ':id'=>(int) $mainid,
                 )
             );

        // 取出店編號對應店名
        $data = CHtml::listData($sub,'id', 'cname');
        
        // 第一列預設為空
        $empty = TRUE;
        
        // 連動結果第一筆為空
        if($empty) echo CHtml::tag('option',array('value'=>''),'選擇次項',true);
        
        // 回傳至畫面     
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
        }
        
    }
    
    //動態細項
     public function actionDynamicoutputitems()
    {
                   
        $row = '';
        $subid = '';
       
        if(isset($_GET['index'])) $row = $_GET['index'];
        // 由異動欄位來的值
        if(isset($_POST)) $subid = $_POST['TbpOutputLog'][$row]['subid'];
        
      
        // 依傳入之mainid來查詢對應次項, 並且要已啟用
        $item = TbpOutputItem::model()->findAllByAttributes(
                array(),
                 $condition  = "subid = :id and opt1 = '1' order by subid ",
                 $params     = array(
                     ':id'=>(int) $subid,
                 )
             );
             
        // 取出店編號對應店名
        $data = CHtml::listData($item,'id', 'cname');
        
        // 第一列預設為空
        $empty = TRUE;
        
        // 連動結果第一筆為空
        if($empty) echo CHtml::tag('option',array('value'=>''),'選擇細項',true);
        
         // 依傳入之mainid來查詢對應次項, 並且要已啟用
//        $sub = TbpOutputSub::model()->findAllByAttributes(
//            array(),
//             $condition  = "id = :id and opt1 = '1' ",
//             $params     = array(
//                 ':id'=>(int) $subid,
//             )
//         );
//        if($sub[0]->nextlog==1){
//             echo CHtml::tag('option',array('value'=>''),'請選擇',true);          
//        }else
//            {
//             //依傳入之mainid來查詢對應次項, 並且要已啟用
//                $type = TbpOutputItem::model()->findAllByAttributes(
//                        array(),
//                        $condition  = "subid = :id",
//                        $params     = array(
//                            ':id'=>(int)$sub[0]->id,
//                        )
//                     );
//            
//                $model = new TbpOutputLog;
//                $this->renderPartial('_type'.$type[0]->type,array('model'=>$model,'row'=>$row), false, true);
//            }
        
        // 回傳至畫面
              
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
        }
        
    }
    
   //型態細項
     public function actionDynamictype()
    {
                  
        $row = '';
        $itemname = '';
       
            
        if(isset($_GET['index'])) 
            $row = $_GET['index'];
        if(isset($_GET['TbpOutputLog'][$row]['itemid'])) 
           $itemid = $_GET['TbpOutputLog'][$row]['itemid'];
           
        // 由異動欄位來的值

        //依傳入之mainid來查詢對應次項, 並且要已啟用
        $item = TbpOutputItem::model()->findByAttributes(
                array(),
                 $condition  = "id = :id and opt1 = '1' order by id ",
                 $params     = array(
                     ':id'=> $itemid,
                 )
             );
        
             
         // 依傳入之$item[0]->subid來查詢對應次項, 並且要已啟用
//        $summary = TbpOutputSub::model()->findAllByAttributes(
//            array(),
//             $condition  = "id = :id and opt1 = '1' ",
//             $params     = array(
//                 ':id'=>(int) $item[0]->subid,
//             )
//         );
         
        $model = new TbpOutputLog;
        $this->renderPartial('_type'.$item->type,array('model'=>$model,'row'=>$row,'summary'=>$item->summary), false, true);  
    }
    
}
