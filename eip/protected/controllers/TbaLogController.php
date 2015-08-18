<?php

//�]��Rights�Ҳ�, �ҥHextends RController
//class TbaLogController extends Controller
class TbaLogController extends RController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column3';

    /**
    * Rights�Ҳ�
    * @return array action filters
    */
    public function filters()
    {
      return array(
          'rights',
      );
    }

    /**
    * Rights�Ҳ�
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
            $model=new TbaLog;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['TbaLog']))
            {
                    $model->attributes=$_POST['TbaLog'];
                    $this->createData($model);
                    if($model->save())
                            $this->redirect(array('view','id'=>$model->id));
            }

            $this->render('create',array(
                    'model'=>$model,
            ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if(isset($_POST['TbaLog']))
        {
            $model->attributes=$_POST['TbaLog'];

            // 檢查資料是否合法
            $checkData = TRUE;
            $logQry = TbaLog::model()->findByAttributes(array('logday'=>$model->logday,'empno'=>$model->empno,'logitem'=>$model->logitem));

            // 若有資料, 判斷是否同一筆, 若不同, 表示不能修改
            if( isset($logQry) && ($logQry->id != $id) ) {

                $checkData = FALSE;
                Yii::app()->user->setFlash('error', "無法修改！因為 [$logQry->empname] 於 [$logQry->logday] 已有 [$logQry->logname] 的紀錄");
            }

            if($checkData) {
                $model->empname= $this->getEmpName($model->empno);
                $model->storename = $this->getStoreName($model->storecode);
                $model = $this->setLogItem($model);                         
                
                $this->updateData($model);

                if($model->save()) {
                    $model = new TbaLog;
                    $this->redirect(array('querylog'));
                }
            }
        }  else {
            Yii::app()->user->setFlash('notice', "更新 [$model->empname] 於 [$model->logday] 的 [$model->logname] 的紀錄！");
        }
        
        $this->render('update',array(
                'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('querylog'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
            $dataProvider=new CActiveDataProvider('TbaLog');
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
            ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
            $model=new TbaLog('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['TbaLog']))
                    $model->attributes=$_GET['TbaLog'];

            $this->render('admin',array(
                    'model'=>$model,
            ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TbaLog the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
            $model=TbaLog::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
            return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TbaLog $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
            if(isset($_POST['ajax']) && $_POST['ajax']==='tba-log-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }

    
    public function actionQuerylog()
    {
        $model=new TbaLog('search');
        $model->unsetAttributes();  // clear any default values
        
        if(isset($_GET['TbaLog']))
                $model->attributes=$_GET['TbaLog'];

        $this->render('querylog',array(
                'model'=>$model,
        ));
    }

    //當按假單則執行 actionUpdateLeave函式
    public function actionUpdateLeave($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
                $model = new TbaLog;
                $model = $this->loadModel($id);

                //leavecheck 0便1，1便0
                if($model->leavecheck == 0)
                    $model->leavecheck = 1;
                elseif($model->leavecheck == 1)
                    $model->leavecheck = 0;

                if($model->save()){
                        echo 'Updated';
                }else{
                        echo 'Error while paying';
                }

        }else{
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }

    }    
        
    //當按假單則執行  actionUpdateProve函式
    public function actionUpdateProve($id)
    {
        if(Yii::app()->request->isPostRequest)
          {
                  $model = new TbaLog;
                  $model = $this->loadModel($id);

                     //provecheck 0便1，1便0
                  if($model->provecheck == 0)
                      $model->provecheck = 1;
                  elseif($model->provecheck == 1)
                      $model->provecheck = 0;

                  if($model->save()){
                          echo 'Updated';
                  }else{
                          echo 'Error while paying';
                  }

          }else{
                  throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
          }

    }      
        
    //當按假單則執行  actionUpdateClass函式
    public function actionUpdateClass($id)
    {
        
        if(Yii::app()->request->isPostRequest)
        {
                $model = new TbaLog;
                $model = $this->loadModel($id);

                 //classcheck 0便1，1便0
                if($model->classcheck == 0)
                    $model->classcheck = 1;
                elseif($model->classcheck == 1)
                    $model->classcheck = 0;

                if($model->save()){
                        echo 'Updated';
                }else{
                        echo 'Error while paying';
                }

        }else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }

    }          
    
    /**
     * 請假單
     */
    public function actionCreate1()
    {
        // 預設值
        $model=new TbaLog;
        //$model->logday = date('Ymd');
        $model->logtype = '1';
             
        $error = '';
       
        if(isset($_POST['TbaLog']))
        {
            // 如果只新增一天
            /*if(isset($_POST['create'])) {
                
                //接收日期array
                 if(isset($_POST['datemulti']) && $_POST['datemulti']>0){
                    $datemulti = $_POST['datemulti'];

                    if(count($datemulti)>1){
                       Yii::app()->user->setFlash('error', '若要新增多天, 請按[新增多天]按鈕！');
                    }else{                                         
                            for($i=0 ;$i<count($datemulti); $i++){                   
                                $model->logday =$datemulti[$i];
                            }                       
                         }
                }
                $model->attributes=$_POST['TbaLog'];

                // 不能點選新增多天
                if($model->num == '*') {
                    
                    Yii::app()->user->setFlash('error', '只能新增半天或全天, 若要新增多天, 請按[新增多天]按鈕！');
                    $model->addError ('num', '請選新增半天或全天！');
                }else{
                    
                    // 檢查資料是否合法
                    $checkdata = TRUE;
                    $logQry = TbaLog::model()->findByAttributes(array('logday'=>$model->logday,'empno'=>$model->empno));

                    // 若該天有資料
                    if(isset($logQry)) {
                        if($logQry->logitem == $model->logitem) {
                            $checkdata = FALSE;
                            Yii::app()->user->setFlash('error', "一個人一天只能有一種假別！$model->empname 於 $model->logday 已有 $model->logitem $model->num 天");
                        }
                    }
                    
                    // 檢查資料是否已存在
                    if($this->checkData($model)){
                        
                        $model->empname= $this->getEmpName($model->empno);
                        $model->storename = $this->getStoreName($model->storecode);
                        $model->logname = $this->getLogItemName($model->logitem);

                        $this->createData($model);
                        //0.5、1對應天數
                        $num='';
                        if($model->save()){                            
                           switch($model->num){
                               case  0.5 :
                                   $num='半天';
                                   break;
                               case  1 :
                                   $num='全天';
                                   break;
                           }

                            Yii::app()->user->setFlash('success', "新增 [ $model->storename ] [ $model->empname ] [ $model->logname ][$num] 成功！");
                            $model=new TbaLog;
                           // $model->logday = date('Ymd');
                            $model->logtype = '1';
                        }
                    }
                }
            }*/
            // 新增多天
            if (isset($_POST['batch'])) {
                
                
                 $model->attributes=$_POST['TbaLog'];
                
                    // 將員工姓名及差勤項目放入
                    $model->empname= $this->getEmpName($model->empno);
                    $model->storename = $this->getStoreName($model->storecode);
                    $model->logname = $this->getLogItemName($model->logitem);

                    $this->createData($model);
                    
                     $valid = TRUE;
                     
                    // 新增多天, 以選擇日期累加
                    if(isset($_POST['datemulti']) && count($_POST['datemulti'] >0 )){
                         $datemulti = $_POST['datemulti'];                                               
                    }else{
                            //一開始沒輸入日期，先驗證錯誤
                             $valid = $model->validate();                             
                         }               
                       
                        // $valid = TRUE;
                                              
                    if(isset($datemulti)){
                            // 檢查資料是否已存在
                            for ($i = 0; $i < count($datemulti); $i++) {
                                $model->logday = $datemulti[$i];
                                $valid = $this->checkData($model) && $valid ;
                                
                                //驗證為空的錯誤訊息
                                $valid = $model->validate() && $valid ;
                                
                                if(!$valid){                                   
                                //    Yii::app()->user->setFlash('error', CVarDumper::dumpAsString ($model->getErrors ()));
                                    break;
                                }
                            }
                         
                                             
                            if($valid) {

                             
                                    for ($i = 0; $i < count($datemulti); $i++) {

                                            $log = new TbaLog();
                                            $log->attributes = $model->attributes;
                                            $log ->id = null;

                                            //$log->num = 1;
                                            $model->logday = $datemulti[$i];
                                            $valid = $log->save() && $valid;
                                            if(!$valid)
                                                break;
                                    }
                                
                                if($valid ) {
                                    $num='';
                                    switch($model->num){
                                        case  0.5 :
                                            $num='半天';
                                            break;
                                        case  1 :
                                            $num='全天';
                                            break;
                                    }
                                    
                                      $_str='';
                                  
                                        $batchnum=count($datemulti);                                     
                                        if($batchnum>0){
                                           sort($datemulti); //排序
                                           $_str = implode(",", $datemulti);                                  
                                        }
                                    
                                   
                                    // if($model->save()){ 
                                    Yii::app()->user->setFlash('success', "新增[$model->storename][$model->empname][$_str][$num][$model->logname]成功！");
                                    $model=new TbaLog;
                                    //$model->logday = date('Ymd');
                                    $model->logtype = '1';    
                                //     }
                                }
                            }
                   }
            }
        }else
            Yii::app()->user->setFlash('notice', '*號欄位為必填，一定要選門市，若要新增多天, 請按[新增多天]按鈕！');

        $this->render('create1',array(
                'model'=>$model,
                'qry_area'=>''
        ));
    }    
    
    /**
     * 遲到早退
     */
    public function actionCreate2()
    {
        // 預設值
        $model=new TbaLog;
        $logday = date('Ymd');
        $logitem = 19; // 遲到

        if(isset($_POST['TbaLog']))
        {

            if(isset($_POST['create'])) {

                $storecode = isset($_POST['qry_store'])?$_POST['qry_store']:'';
                $storename = $this->getStoreName($storecode);
                
                $logday = isset($_POST['logday'])?$_POST['logday']:'';
                
                $logitem = isset($_POST['logitem'])?$_POST['logitem']:'';
                $logname = $this->getLogItemName($logitem);
                
                $valid = TRUE;
                
                foreach ($_POST['TbaLog'] as $j=>$TbaLog) {
                    
                    if (isset($_POST['TbaLog'][$j])) {
                        $log[$j]=new TbaLog;
                        $log[$j]->attributes=$TbaLog;
                        $log[$j]->logday = $logday;
                        $log[$j]->logitem = $logitem;
                        if($log[$j]->num > 0) 
                            $valid = $this->checkData($log[$j]) && $valid;
                    }
                }
                
                if($valid) {
                    foreach ($_POST['TbaLog'] as $j=>$TbaLog) {

                        if (isset($_POST['TbaLog'][$j])) {

                            $log[$j]=new TbaLog;
                            $log[$j]->attributes=$TbaLog;
                            if($log[$j]->num > 0) {

                                $log[$j]->logday = $logday;
                                $log[$j]->logtype = '1'; // 差勤類別
                                $log[$j]->logitem = $logitem;                        
                                $log[$j]->logname = $logname;                        
                                $log[$j]->storecode = $storecode;
                                $log[$j]->storename = $storename;
                                $log[$j]->opt2 = '1'; // 遲到早退開小差
                                $this->createData($log[$j]);
                                if($valid) $valid = $log[$j]->save() && $valid;
                            }
                            if(!$valid) {
                                CVarDumper::dump ($log[$j]->getErrors (),10,true);
                                break;
                            }
                        }
                    }                    
                    if($valid) {
                        Yii::app()->user->setFlash('success', "新增 [ $storename ] [ $logname ] 成功！");
                        $model=new TbaLog;
                        $logitem = 19; // 遲到
                    }
                }
            }

        }else
            Yii::app()->user->setFlash('notice', '*號欄位為必填，要先選門市，才會顯示員工清單！');

        $this->render('create2',array(
                'model'=>$model,
                'logday'=>$logday,
                'logitem'=>$logitem,
                'qry_area'=>'',
                'qry_store'=>''
        ));
    }        
    
    /**
     * 獎懲單
     */
    public function actionCreate3()
    {
        // 預設值
        $model=new TbaLog;
        $model->logday = date('Ymd');
        // 奬懲為第2類
        $model->logtype = '2';

        if(isset($_POST['TbaLog']))
        {
            
            if(isset($_POST['create'])) {
                
                $model->attributes=$_POST['TbaLog'];

                // 檢查資料是否已存在
                if($this->checkData($model)){                
                
                    $model->empname= $this->getEmpName($model->empno);
                    $model->storename = $this->getStoreName($model->storecode);
                    $model = $this->setLogItem($model);

                    $this->createData($model);

                    if($model->save()){
                        Yii::app()->user->setFlash('success', "新增 [ $model->storename ] [ $model->empname ] [ $model->logname ] 成功！");
                        $model=new TbaLog;
                        $model->logday = date('Ymd');
                        $model->logtype = '2';
                    }
                }
            }
        }else
            Yii::app()->user->setFlash('notice', '*號欄位為必填，一定要選門市！');

        $this->render('create3',array(
                'model'=>$model,
                'qry_area'=>''
        ));
    }        
  
    /**
     * 檢查資料是否合法
     * @param type $model
     * @return boolean
     */
    private function checkData($model) {
        
        // 檢查資料是否合法
        $checkdata = TRUE;
        $logQry = TbaLog::model()->findByAttributes(array('logday'=>$model->logday,'empno'=>$model->empno,'logitem'=>$model->logitem));

        // 若該天有資料
        if(isset($logQry)) {
            $checkdata = FALSE;
            Yii::app()->user->setFlash('error', "一個人一天任一種差勤獎懲只能有一筆！[$logQry->empname] 於 [$logQry->logday] 已有 [$logQry->logname] 的紀錄！");
        }
        
        return $checkdata;
    }


    /**
     * 取得員工姓名
     * @param string $empno - 員工編號
     * @return string - 員工姓名
     */
  private function getEmpName($empno) {
      
      $empname = "";

      $emp = TbsEmp::model()->findByEmpno($empno);
      if(isset($emp)) $empname = $emp->empname;

      return $empname;
  }
  
  /**
   * 取得門市名稱
   * @param string $storecode - 門市編號
   * @return string - 門市名稱
   */
  private function getStoreName($storecode) {
      
      $storename = "";
      
      $store = TbsStore::model()->findByAttributes(array('storecode'=>$storecode));
      if(isset($store)) $storename = $store->storename;           
      
      return $storename;
  }
  
  /**
   * 取得差勤項目名稱
   * @param type $logitem - logitem id - 差勤項目ID
   * @return type logname - 項目名稱
   */
  private function getLogItemName($logitem) {
      
      $logname = "";

      $logitem = TbaLogItem::model()->findByPk($logitem);
      if(isset($logitem)) $logname = $logitem->logname;      
      
      return $logname;
  }
  
  /**
   * 設定差勤項目遲到 - opt2
   * @param type $logitem - logitem id - 差勤項目ID
   * @return type opt2 - 項目名稱
   */
  private function setLogItem($model) {
      
      $logitem = TbaLogItem::model()->findByPk($model->logitem);
      if(isset($logitem)){
          $model->logname = $logitem->logname;
          $model->opt2 = $logitem->opt2;
          $model->opt3 = $logitem->opt3;
      }
      return $model;
  }  
  
  /**
   * 動態取得門市員工連動 - 遲到早退用
   * 
   * 判斷條件為 門市 storecode, 預設目前年月, 取得目前年月該門市之所屬員工
   * 1030527 當員工已離職. 若比目前年月早, 則在10號前仍可見
   * 比如: 5月離職員工. 在6/10以前皆可見, 6/11後不可見
   * 
   * 利用ajax, url 如下
   * 'url'=>CController::createUrl('tbaLog/dynamicemps')
   * 若結果第一列不想為空, 再傳入empty變數, 範例如下
   * 'url'=>CController::createUrl('tbaLog/dynamicemps',array('empty'=>FALSE))
   */
    public function actionDynamicemps( )
    {
        $empty = TRUE;
        if(isset($_GET['empty'])) $empty = $_GET['empty'];        
        
        $date = date('Ym');
        $storecode = $_POST['qry_store'];
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
         echo '<table>';
         echo '<tr>';
         echo '<td>員編</td><td>姓名</td><td>分鐘數</td><td>備註</td>';
         echo '</tr>';
         $i = 0;
         foreach($data as $empno=>$empname)
         {
             echo '<tr>';
             $name_empno = 'TbaLog'."[$i]".'[empno]';
             echo '<td>'.CHtml::textField($name_empno,$empno)."</td>";
             $name_empname = 'TbaLog'."[$i]".'[empname]';
             echo '<td>'.CHtml::textField($name_empname,$empname)."</td>";
             $name_num = 'TbaLog'."[$i]".'[num]';
             echo '<td>'.CHtml::textField($name_num,'')."</td>";
             $name_memo = 'TbaLog'."[$i]".'[memo]';
             echo '<td>'.CHtml::textArea($name_memo,'')."</td>";
             echo '</tr>';
             $i++;
         }
         echo '</table>';
    } 
  
}
