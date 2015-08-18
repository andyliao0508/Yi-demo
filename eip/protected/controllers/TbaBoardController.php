<?php

class TbaBoardController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	/*public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}*/

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}*/
        
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new TbaBoard;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['TbaBoard']))
        {
            $model->attributes=$_POST['TbaBoard'];
            $this->createData($model);  //呼叫RController

          //  $model->image=  CUploadedFile::getInstance($model, 'image');
            
            $rnd = date(time());  // generate random number -> use time function
            $uploadedFile=CUploadedFile::getInstance($model,'image');
       
            if($uploadedFile){  //image exist
                 
                $output = explode(".", $uploadedFile);  //分割小數點為一個array()
                $fileName = "{$rnd}";  // rename file for  time function name
                    
                //分割名稱與副檔名
                $_array=array();
                for( $i=0; $i<count($output)-1;$i++){

                    $_array[$i] = $output[$i];
                    $point_count = implode(".", $_array);        //遇到逗號使用小數點組起來

                }
                $length = count($output);//取總數

                //Store in the DB
                $model->imagename=$point_count;
                $model->imagetype=$output[$length-1];
                $url= '/' . "protected" . '/' . "upload" . '/'.$fileName;
                $model->imageurl=$url;  
                
                //set image file name
                $model->image = $fileName;
            }
            
            $checkIndexImg = TRUE;
            if($model->opt3==1) {
                if(!$uploadedFile) {
                    $checkIndexImg = FALSE;
                    $model->addError('image', '勾選首頁圖片,需上傳圖片');
                }
            }
            if($checkIndexImg AND $model->save()){

                if($uploadedFile){ //if image file  exist then upload
                    $webroot = Yii::getPathOfAlias('webroot');
                    $filePath = $webroot . '/' . "protected" . '/' . "upload" . '/';

                    $uploadedFile->saveAs($filePath . $model->image );
                }
                $this->redirect(array('admin'));
               // $this->redirect(array('view','id'=>$model->id)); 
            }   
        }else
            {
               //得到起始的年月日
               $today = date('Ymd');
               $model->dates = $today;
               Yii::app()->user->setFlash('notice', '新增公告 *號為必填欄位！');
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
            $prevImage=$model;  //add this line
          
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['TbaBoard']))
            {     
                    $model->attributes=$_POST['TbaBoard'];
                    $this->updateData($model);  //呼叫RController
                    
                    /*----------*/
                    $webroot = Yii::getPathOfAlias('webroot');
                    $filePath = $webroot . '/' . "protected" . '/' . "upload" . '/';
                    /*----------*/
                    
                   // $model->image=CUploadedFile::getInstance($model,'image');
                    
                    
                    $rnd = date(time());  // generate random number ->time
                    $uploadedFile=CUploadedFile::getInstance($model,'image');
                  
                     if($uploadedFile){  //image exist
         
                            if(!empty($prevImage->imageurl))
                            {  
                              unlink($webroot.$model->imageurl);   
                            }              
                      /*------------------*/
                       $output = explode(".", $uploadedFile);  //分割小數點為一個array()
                       $fileName = "{$rnd}";  // rename file for  time function name
                    
                        //分割名稱與副檔名
                        $_array=array();
                        for( $i=0; $i<count($output)-1;$i++){

                            $_array[$i] = $output[$i];
                            $point_count = implode(".", $_array);        //遇到逗號使用小數點組起來

                        }
                        $length = count($output);//取總數

                        $model->imagename=$point_count;
                        $model->imagetype=$output[$length-1];
                        
                        $url= '/' . "protected" . '/' . "upload" . '/'.$fileName ;
                        $model->imageurl=$url;                 
                        $model->image = $fileName;                  
                    }
               
                    /*----------*/
                    if( $model->save()){
                        
                         if($uploadedFile)  // check if uploaded file is set or not
                            {
                            $uploadedFile->saveAs($filePath . $model->image);
                            }
                       
                      // $this->redirect(array('view','id'=>$model->id));
                         $this->redirect(array('admin'));
                    }      
            }
            else
            {
                Yii::app()->user->setFlash('notice', '新增公告 *號為必填欄位！');
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
           // $this->loadModel($id)->delete();
            $model=$this->loadModel($id);
           
            $webroot = Yii::getPathOfAlias('webroot');
            /*$filePath = $webroot . '/' . "protected" . '/' . "upload" . '/';
           
            if ($model->imagename && file_exists($filePath.$model->imagename.'.'.$model->imagetype)) {
                 
                   chmod($filePath.$model->imagename.'.'.$model->imagetype , 0755);
                   unlink($filePath.$model->imagename.'.'.$model->imagetype);     
            }*/
            if (Yii::app()->request->baseUrl.$model->imageurl ) {
                 
                chmod($webroot.$model->imageurl , 0755);
                unlink($webroot.$model->imageurl);     
            }
            
           $model->delete();
           /*----*/
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
             
    }
    
    public function actionAnnounce()   //notice history page
    {
        $this->render('announce'); 
    }

    public function actionBoardindex()   //notice history page
    {
        //得到起始 結束的年月日
        //$qry_dateS = date('Ymd');
        $qry_dateS=date("Ymd", strtotime('-3 month')); //找尋前3個月
        $qry_dateE = date('Ymd');
        
        $isread = '';
        $sqlcondition='';
       
         if(isset($_POST['qry_dateS']))
            $qry_dateS = $_POST['qry_dateS'];
         if(isset($_POST['qry_dateE']))
            $qry_dateE = $_POST['qry_dateE'];
         if(isset($_POST['isread']))
            $isread = $_POST['isread'];
  
        if(isset($_POST['qry'])){
            
           if(isset($_POST['isread']) && $_POST['isread'] == '1' ) {  //已讀
               $sqlcondition="where c.read =1";
            }
           if(isset($_POST['isread']) && $_POST['isread'] == '2' ){ //未讀
               $sqlcondition="where c.read is null";
            }  
       
           $today=date('Y-m-d'); //今天日期

           $sql= "SELECT c.* from( SELECT a.id, a.title, a.content, a.dates, b.read FROM 
                (SELECT * FROM `tba_board` WHERE datee >=' $today' and dates BETWEEN '$qry_dateS'  AND '$qry_dateE' )  a LEFT JOIN `tba_board_emp_log`  b
                ON a.id = b.board_id order by a.datee desc ) c ".$sqlcondition;
        
           $result = Yii::app()->db->createCommand($sql)->queryAll();
        }
        else {        
            // CVarDumper::dump($_POST,10,true);
            $today=date('Y-m-d'); //今天日期

           //使用sql寫法
            $sql= "SELECT a.id, a.title, a.content, a.dates, b.read FROM
                (SELECT * FROM `tba_board` WHERE datee >='$today' and dates BETWEEN '$qry_dateS'  AND '$qry_dateE' ) a LEFT JOIN `tba_board_emp_log` b
                ON a.id = b.board_id order by datee desc ".$sqlcondition;

            $result = Yii::app()->db->createCommand($sql)->queryAll();              
        }

            $this->render('boardindex',array(
                'result'=>$result,
                'qry_dateS'=>$qry_dateS,
                'qry_dateE'=>$qry_dateE,
                'isread'=>$isread
            ));
    }


    public function actionEmpread($id)
    {
      $msg = '';
      $boardcontent_id = $this->loadModel($id);
        
      /*紀錄id*/
      $prerecord = $this->preboard($id);
      $nextrecord = $this->nextboard($id);

     

      //判斷是否有上一筆
      if($prerecord==null){
         
            $preEmpty=true;
        }else{
       
            $preEmpty=false;
        }
        
      //判斷是否有下一筆
      if($nextrecord==null){
          
         $nextEmpty=true;
        }else{
            
         $nextEmpty=false;
        }

      /*判斷是否已讀*/
      if(isset($_POST['read'] )){

        $log_model=new TbaBoardEmpLog;

        $board = $this->loadModel($id);


        $log_model->board_id =  $board->id;
        $log_model->board_title =  $board->title;
        $log_model->empno= Yii::app()->user->id;
        $log_model->read= '1';
        $this->createData($log_model);  //呼叫RController

        $log = TbaBoardEmpLog::model()->findByAttributes( array(),
                 $conditon = " board_id = $log_model->board_id and "
                . " $log_model->empno = empno" 
                );
  
        if(!isset($log))
            if($log_model->save())     //寫入database
            {
                $msg = "[公告]讀取成功";
                Yii::app()->user->setFlash('success', $msg);
            }
            else
            {
               // CVarDumper::dumpAsString($log_model->getErrors(), 10, true);
                $msg = "[公告]讀取失敗";
                Yii::app()->user->setFlash('error', $msg);
            }

       }
        
         /*判斷已讀id*/
        $readState= $this->isRead($id);

         $this->render('empread',
                 array(
                    'boardcontent_id'=>$boardcontent_id,
                    'prerecord'=>$prerecord,
                    'nextrecord'=>$nextrecord,
                    'preEmpty'=>$preEmpty,
                    'nextEmpty'=>$nextEmpty,
                    'readState'=> $readState,
                )
            );

    }
    
     public function actionUpload()
    {
            $model=new TbaBoard;
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
 
            if(isset($_POST['fileUpload']))
            {
                    $model->attributes=$_POST['TbaBoard'];
                    $model->image=  CUploadedFile::getInstance($model, 'image');
                    $model->title =$model->image;   //upload file name store db
                    $model->content ='content';
                    
                     $output = explode(".", $model->image);
                     $model->imagename=$output[0];
                     $model->imagetype=$output[1];
                       
                    if($model->save()){
   
                        $webroot = Yii::getPathOfAlias('webroot');
                        $filePath = $webroot . '/' . "protected" . '/' . "tmp" . '/';
                        
                        if($model->image->saveAs($filePath . $model->image))
                            Yii::app()->user->setFlash('success', "成功！！");
                        else {
                            Yii::app()->user->setFlash('error', "fail！！");
                        }
                    }
                    else
                        Yii::app()->user->setFlash('error', "fail！！");
            }
            else
                Yii::app()->user->setFlash('notice', "........upload attention！！");

     
            $this->render('upload',array(
                    'model'=>$model,
            ));
    }
    
    public function actionDownload()
    {
           $model=new TbaBoard;
        
        $webroot = Yii::getPathOfAlias('webroot');
        $filePath = $webroot . '/' . "protected" . '/' . "tmp" . '/';
         $model->image=  CUploadedFile::getInstance($model, 'image');
       
       if ($fd = fopen ($filePath.'123.jpg', "r")) {
            $fsize = filesize($filePath);
            $path_parts = pathinfo($filePath);
            header("Content-type: application/octet-stream");
            //header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
            header('Content-Disposition: attachment; filename="'."123.jpg".'"');
            header("Content-length: $fsize" );
            header("Cache-control: private"); //use this to open files directly
            
            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            } 
        
        }
    }


    /**
     * Lists all models.
     */
    public function actionIndex()
    {
            $dataProvider=new CActiveDataProvider('TbaBoard');
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
            ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
            $model=new TbaBoard('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['TbaBoard']))
                    $model->attributes=$_GET['TbaBoard'];

            $this->render('admin',array(
                    'model'=>$model,
            ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TbaBoard the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
            $model=TbaBoard::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
            return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TbaBoard $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
            if(isset($_POST['ajax']) && $_POST['ajax']==='tba-board-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }

    /**
     * 取得上一筆的ID
     * @param string $current_id 目前公告的ID
     * @return string 上一筆公告的ID 或 NULL
     */
    private function preboard($current_id){

        $preid = null;

       /* $record = TbaBoard::model()->findByAttributes(
                    array(),
                    $conditon = " id < $current_id  ORDER BY id DESC "
                );*/
        
        $board = $this->loadModel($current_id);
        $record = TbaBoard::model()->findByAttributes(array(),
        $conditon = " datee > '$board->datee'  ORDER BY datee ");

        if($record !== null)
            $preid = $record->id;

        return $preid;
    }
    
    /**
     *  取得下一筆的ID
     * @param string $current_id 目前公告的ID
     * @return string 下一筆公告的ID 或 NULL
     */
    private function nextboard($current_id){
        
        $nextid = null;
        
       /* $record = TbaBoard::model()->findByAttributes(
                    array(),
                    $conditon = " id > $current_id  order by id asc "
                );*/
         
         //$board = $this->loadModel($current_id);
        /* $record = TbaBoard::model()->findByAttributes(array(),
         $conditon = " datee < '$board->datee' AND id != '$current_id' ORDER BY id DESC ");*/   //排序問題 先暫停
                
        
        $board = $this->loadModel($current_id);
        $record = TbaBoard::model()->findByAttributes(array(),
        $conditon = " datee < '$board->datee'  ORDER BY datee DESC ");
        
        
         if($record!==null)
           $nextid = $record->id;
         
         return $nextid;
    }
    
    /**
     * 判斷是否已讀
     * @param string $current_id 目前公告的ID
     * @return 讀取狀態
     */
    private function isRead($current_id){
            
        $isEmpty = TbaBoardEmpLog::model()->findByAttributes(
                array('board_id'=>$current_id ,'empno'=>Yii::app()->user->id)
            );
        if( $isEmpty==null){
            return false;
        }else{
            return true;
        }
    }
    
    private function getRandomQuote()
    {
    
        $today=date('Y-m-d'); //今天日期
        $result = TbaBoard::model()->findAllByAttributes(
           array(),
        $conditon = "datee >='$today' and opt1=1 and opt2=1 ");
        
        $quote=$result[array_rand($result, 1)];
   
        return $quote;
    }
    
    public function actionGetQuote()
    { 
//        $check = TRUE;
//        
//        $param = TbaParam::model()->findByAttributes(array('param'=>'board_quote_rand'));
//        if(isset($param))
//            $check = $param->pvalue;
//        
        
        
        $this->renderPartial('_quote', array(
            'quote' => $this->getRandomQuote(),
        ));
    
    }
    
}
