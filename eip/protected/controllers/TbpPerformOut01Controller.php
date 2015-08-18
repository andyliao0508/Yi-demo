<?php

class TbpPerformOut01Controller extends RController
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
        * @return array action filters
        */
       public function filters()
       {
           return array(
               'rights',
           );
       }

       /**
        * Specifies the access control rules.
        * This method is used by the 'accessControl' filter.
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
		$model=new TbpPerformOut01;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TbpPerformOut01']))
		{
			$model->attributes=$_POST['TbpPerformOut01'];
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

		if(isset($_POST['TbpPerformOut01']))
		{
			$model->attributes=$_POST['TbpPerformOut01'];
                        $this->updateData($model);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TbpPerformOut01');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TbpPerformOut01('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TbpPerformOut01']))
			$model->attributes=$_GET['TbpPerformOut01'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TbpPerformOut01 the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TbpPerformOut01::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TbpPerformOut01 $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tbp-perform-out01-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionExport()
	{
             // 用以計算開始/結束時間之變數
            $time_start = microtime(true);
            //ini_set('memory_limit', '256M');
            //ini_set('max_execution_time', '300');

            // Sleep for a while
            usleep(100);          

            //得到起始 結束的年月日
            $qry_dateS = date('Ymd');
            $qry_dateE = date('Ymd');

            $qry_area = ""; //區域
            $qry_store = ""; // 門市         
            $qry_serviceno = array(); //服務項目
            $serviceno_seq = array(); //服務項目順序
            
            //預設取消匯出初始值
            $cancel_export=false;
            //預設查詢異動初始值
            $qry_move=false;

            if(isset($_POST['qry_dateS']))        $qry_dateS = $_POST['qry_dateS'];
            if(isset($_POST['qry_dateE']))        $qry_dateE = $_POST['qry_dateE'];
            if(isset($_POST['qry_area']))          $qry_area = $_POST['qry_area'];    
            if(isset($_POST['qry_store']))         $qry_store = $_POST['qry_store'];              
            if(isset($_POST['cancel_export']))        $cancel_export = $_POST['cancel_export'];
            if(isset($_POST['qry_move']))        $qry_move = $_POST['qry_move'];
                                
          
             // 篩選條件初始的預設值
            $default_serviceno = array();

        
                $tbpParam = TbpPerformOut01::model()->findByAttributes(array('name'=>'ching_hang'));
                if($tbpParam != NULL){ 
                    $default_serviceno = explode(",", $tbpParam->item);
                    $serviceno_seq=explode(",", $tbpParam->sequence);                 
                }
                     
              
            //  篩選條件初始的預設值
           $qry_serviceno = $default_serviceno;
        
            unset($default_serviceno);
            
            // 畫面呈現的表格欄位, col是欄位名稱, title是欄位顯示的中文字
            $col = array();
            $title = array();                     
            
//            $col = $qry_serviceno;    
//            
//            // 取得預設報表抬頭
//            $title = TbpPerformOut01::model()->getRptTitle($col);
//
//            // 設定報表抬頭
//            foreach ($serviceno as $row) {
//                $title[$row->serviceno] = $row->cname;
//            }
            
             
            //正航匯入title                 
        if(count($serviceno_seq) != 0 ){
            // 將指定的順序放進去, 再重新排序
            $col = array_combine($serviceno_seq, $qry_serviceno);
            ksort($col);           
        }else
        {       //models預設好的col
            $col=TbpPerformOut01::model()->getRemitCol();
        }
        
        unset($serviceno_seq);
        unset($qry_serviceno);
        
            // 取得預設報表抬頭
            $title =TbpPerformOut01::model()->getRemittitle();
                                  
           // 輸出在畫面上的陣列
            $colAry = array();
            //店編對應區域名稱的陣列
            $stores = array();
            //儲存篩選出來的門市
            $tbsStroes = array();
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
                    $stores[$store->storecode] = $area->areaname;
                }
            }
            
        // 查詢用的SQL
        $qryStr = '';
        
        //如果有選門市或區域就需要sql=AND storecode in('007001',007002')  
        if($qry_store != '' OR $qry_area != '') {
            //sql=sql.in('007001')因為只有一筆的時候沒有' , '  所以直接把店編放進去
            if(count($sqlStroe)>0) {
                $qryStr = " AND storecode in ('$sqlStroe[0]'";
                //如果門市>1,就需要' , '
                if(count($sqlStroe)>1)
                    for ($i = 1; $i < count($sqlStroe); $i++) {
                        $qryStr = $qryStr.",'$sqlStroe[$i]'";
                    }
                $qryStr = $qryStr.")";
            }
        }
        
         $fileName='';       
                     
         //按下查詢
         if(isset($_POST['qry']) OR isset($_POST['export']) ){
             
           
                $sql = "( SELECT pdate, storecode, storename, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                       . "WHERE pdate BETWEEN '$qry_dateS' AND '$qry_dateE' $qryStr AND num !=0 "
                       . "GROUP BY pdate, storecode, storename, serviceno ORDER BY pdate, storecode ,serviceno) ";

                $sql2 = "( SELECT pdate, storecode, storename, serviceno, sum(num) as num FROM tbp_perform_log "
                        . "WHERE pdate BETWEEN '$qry_dateS' AND '$qry_dateE' $qryStr AND num !=0 "
                        . "GROUP BY pdate, storecode, storename, serviceno ORDER BY pdate, storecode ,serviceno) ";

                $sql=$sql."UNION".$sql2;  //合併          
                $sql = $sql. "order by pdate, storecode, serviceno";//一定要照pdate排序,因為loop要照日期去跑
                    
          
                 $emplog = Yii::app()->db->createCommand($sql)->queryAll();
                 
                if($emplog !=NULL && count($emplog)>0) {
                   $colAry = $this->getDailyData($emplog);               
                    Yii::app()->user->setFlash('success', '以日期區間' . $qry_dateS . ' ~ ' . $qry_dateE . ' 查詢成功！合計'. count($colAry) .'筆資料');              
                }
                else
                    Yii::app()->user->setFlash('error', '以日期區間' . $qry_dateS . ' ~ ' . $qry_dateE . ' 查無資料');          
                              
            unset($emplog);
            
            if(isset($_POST['export'])) {
                $excelname=$qry_dateS.'-'.$qry_dateE;
                $fileName = $this->exportEXCEL($excelname,$col,$title,$colAry);
                
                $pdate=array();
                $storecode=array();
                //匯入成功
                if(isset($fileName)){
                     if(count($colAry)>0){                         
                         for ($i = 0; $i < count($colAry); $i++) {  
                             //給sql查詢條件                       
                              array_push($pdate, $colAry[$i]['pdate']);
                              array_push($storecode, $colAry[$i]['storecode']);                              
                         }
                         
                           $_pdatestr = "'".implode("','", $pdate)."'"; //每個日期加入單引號為了sql in查詢使用
                           $arr1= array_unique(explode(',',$_pdatestr)); //將重複日期刪除只保留一個的array
                           $_pdatestr=implode(',', $arr1); //再將不重複日期轉成字串
                           
                           $_storecodestr = "'".implode("','", $storecode)."'"; //每個店編加入單引號為了sql in查詢使用
                           $arr2= array_unique(explode(',',$_storecodestr)); //將重複店編刪除只保留一個的array
                           $_storecodestr=implode(',', $arr2); //再將不重複店編轉成字串
                         
                           //不只一筆所以用findAllByAttributes
                            $isExist= TbpPerform::model()->findAllByAttributes(array(), 
                                $conditon = " pdate IN ($_pdatestr) and storecode IN ($_storecodestr) ORDER BY pdate DESC "
                                );
                              
                            //將匯入日期、店編符合DB條件的，則opt2設定為1
                              if(isset($isExist) and count($isExist)>0){
                                  for ($i = 0; $i < count($isExist); $i++) {
                                      $isExist[$i]->opt2=1;
                                      $isExist[$i]->save();
                                  }                              
                              }                                         
                     }                
                }
                unset($pdate);
                unset($storecode);
                   //  CVarDumper::dump($remitAry,10,true); 
                
              //  $col = array();
              //  $title = array();
                $colAry = array();
                // unset($colAry);
                $clickUrl =  "<a href='".Yii::app()->request->baseUrl. '/' . "protected" . '/' . "tmp" . '/' .$fileName. "'>點我下載</a>";
                Yii::app()->user->setFlash('success', "正航匯入成功！請點擊下載 ".$clickUrl); 
            }else{}
                //Yii::app()->user->setFlash('success', "查詢成功！共計 ".count($colAry)."筆資料！");
          
        }//if(isset($_POST['qry']) OR isset($_POST['export']) 
        
        
        //查詢異動array
        $qry_move_result=array();
        
        if(isset($_POST['qry_move']) OR isset($_POST['move_export'])){
             
                 $qry_move = true;
                
                 //查詢日期區間被已被匯出資料
                $isExist= TbpPerform::model()->findAllByAttributes(array(), 
                    $conditon = "  opt2=1 AND uemp IS NOT  NULL AND opt3 IS NULL ORDER BY pdate ,storecode "
                    );
                
                 foreach($isExist as $value){                   
                      
                     $temp = array(      //model塞值方式
                                'pdate' => $value->pdate,
                                'storecode' => $value->storecode,
                                'storename' => $value->storename,
                                'total' => $value->total,
                                'output' => $value->output,
                                'remit' => $value->remit,
                                'cemp' =>  $value->cemp,
                                'ctime' => $value->ctime,
                                'uemp' =>  $value->uemp,
                                'utime' =>  $value->utime,
                            );
                    array_push($qry_move_result,$temp);
                }
                if(isset($qry_move_result) && count($qry_move_result) > 0){
                     Yii::app()->user->setFlash('success', "查出異動資料！共計 ".count($qry_move_result)."筆資料。");
                }else
                    {
                    Yii::app()->user->setFlash('error', "沒有任何異動資料！");
                    }
                    
            // 查詢異動用的SQL
            $qrymoveStr = '';
            //為了sql 使用 in(20140506,...)
            $dateStr='';
            //為了sql 使用 in(007002,...)
            $storecodeStr='';
            //日期array
            $sdate=array();
            //店編array
            $sstorecode=array();
                
                //先把$qry_move_result的日期與店編曲出來
                if(count($qry_move_result)>0) {

                    for($i=0 ; $i<count($qry_move_result) ; $i++){
                         array_push($sdate, $qry_move_result[$i]['pdate']); 
                         array_push($sstorecode, $qry_move_result[$i]['storecode']);
                    }

                    //每個日期加入單引號為了sql in查詢使用
                        if(count($sdate)>0) {
                               $dateStr = "'".implode("','", $sdate)."'"; 
                        }
                        
                    //每個店編加入單引號為了sql in查詢使用
                        if(count($sstorecode)>0) {
                               $storecodeStr = "'".implode("','", $sstorecode)."'"; 
                        }

                }//if(count($qry_move_result)>0)
        
                        //給sql查詢日期與店編
                        $qrymoveStr=$qrymoveStr."pdate IN ($dateStr) AND storecode IN ($storecodeStr)";
                        
                        //sql字串清空
                        $sql='';     
                        
                        if($dateStr!='' and $storecodeStr!=''){
                        
                            $sql = "( SELECT pdate, storecode, storename, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                                    . "WHERE $qrymoveStr AND num !=0 "
                                    . "GROUP BY pdate, storecode, storename, serviceno ORDER BY pdate, storecode ,serviceno) ";

                            $sql2 = "( SELECT pdate, storecode, storename, serviceno, sum(num) as num FROM tbp_perform_log "
                                    . "WHERE $qrymoveStr AND num !=0 "
                                    . "GROUP BY pdate, storecode, storename, serviceno ORDER BY pdate, storecode ,serviceno) ";

                            $sql=$sql."UNION".$sql2;  //合併          
                            $sql = $sql. "order by pdate, storecode, serviceno";//一定要照pdate排序,因為loop要照日期去跑

                             $emplog = Yii::app()->db->createCommand($sql)->queryAll();

                             if($emplog !=NULL && count($emplog)>0) {
                                $colAry = $this->getDailyData($emplog);                                                      
                             }
                        }
                         
                          unset($emplog);
                        
                if(isset($_POST['move_export'])) {
                    
                    $excelname="move_table";
                    $fileName = $this->exportEXCEL($excelname,$col,$title,$colAry);

                    
                       //  CVarDumper::dump($remitAry,10,true); 

                  //  $col = array();
                   // $title = array();
                    $colAry = array();                 
                    $clickUrl =  "<a href='".Yii::app()->request->baseUrl. '/' . "protected" . '/' . "tmp" . '/' .$fileName. "'>點我下載</a>";
                    Yii::app()->user->setFlash('success', "異動表匯入Excel成功！請點擊下載 ".$clickUrl);
                }
                                                                      
        }// if(isset($_POST['qry_move']) OR isset($_POST['move_export']))
        
        //取消正航匯出array
         $cancel_result=array();
            //取消匯出正航
            if(isset($_POST['cancel_export'])) {             
                
                $cancel_export = true;
                 //查詢日期區間被已被匯出資料
                $isExist= TbpPerform::model()->findAllByAttributes(array(), 
                    $conditon = " pdate BETWEEN $qry_dateS AND $qry_dateE AND opt2=1 ORDER BY pdate ,storecode "
                    );
               
                foreach($isExist as $value){
                     $temp = array(      //model塞值方式
                                'pdate' => $value->pdate,                              
                                'storename' => $value->storename,
                                'total' => $value->total,
                                'output' => $value->output,
                                'remit' => $value->remit,
                                'realremit' => $value->realremit,
                                'realmemo' => $value->realmemo,
                                'status' => '成功',                               
                            );
                    array_push($cancel_result,$temp);
                }
              
                //將日期區間DB條件的，則opt2設定為NULL
                if(isset($isExist) and count($isExist)>0){
                    for ($i = 0; $i < count($isExist); $i++) {
                        $isExist[$i]->opt2=NULL;
                        $isExist[$i]->save();
                    } 
                       Yii::app()->user->setFlash('success', "取消匯出成功！共計 ".count($isExist)."筆資料！");
                }else
                    {
                       Yii::app()->user->setFlash('error', "查無任何資料！");
                    }            
               
            }//if(isset($_POST['cancel_export']))
                      
            
             // 用以計算開始/結束時間之變數         
             $time_end = microtime(true);
             $computetime = $time_end - $time_start;   
            
            
             try {
		$this->render('export',array(
                'qry_dateS'=>$qry_dateS,
                'qry_dateE'=>$qry_dateE,
                'qry_area'=>$qry_area,
                'qry_store'=>$qry_store,                                              
                'col'=>$col,
                'title'=>$title,
                'colAry'=>$colAry,
                'fileName'=>$fileName,               
                'computetime'=>$computetime,
                'cancel_export'=>$cancel_export, // (取消匯出布林判斷)
                'cancel_result'=>$cancel_result, //要取消匯出的array
                'qry_move'=>$qry_move, // (查詢異動判斷)
                'qry_move_result'=>$qry_move_result,//查詢異動的array
		));
             } catch (Exception $exc) {
                echo $exc->getTraceAsString();
             }
	}            
          
             /**
       * 
       * @param type $emplog - 員工資料
       * @param type $stores - 門市陣列
       * @param type $qry_dateS - 起
       * @param type $qry_dateE - 訖
       * @return type
       */
      private function getDailyData($emplog) {
         
           //輸出陣列
          $colAry = array();
                //CVarDumper::dump($emplog,10,true);
          //每一行的陣列
          $Arylog = array();
          
              
          //儲存serviceno的金額
          $Aryprice = array();
          
          $servicenoPrice = TbsService::model()->findAllByAttributes(
                    array(),                              
                    $condition = "type1 != 5 AND opt1 = '1' ORDER BY serviceno "
            ); 
         
          //得到serviceno對應price
           if(count($servicenoPrice>0)){
                $temp=array();
                
                 for ($i = 0; $i < count($servicenoPrice); $i++) {
                $temp[$servicenoPrice[$i]->serviceno]=$servicenoPrice[$i]->price; //編號=>金額
                 }
                    array_push($Aryprice,$temp);                        
            }
             unset($servicenoPrice);
                        
          if(count($emplog>0)) {
         
                if(isset($emplog[0]['pdate']) OR isset($emplog[0]['storecode']) ){
                  $day = $emplog[0]['pdate'];
                  $storecode = $emplog[0]['storecode'];
                  
                  //流水號初始值
                // static $count = 1;              
                    // 每一行的陣列
                    $row = array();                 
                     for ($i = 0; $i < count($emplog); $i++) {
                                             
                          if($emplog[$i]['pdate']==$day and $emplog[$i]['storecode']==$storecode ) {
                              // $row['receiptno'] = $emplog[$i]['pdate'].'00'.$count;   
                              $row['receiptno'] = $emplog[$i]['pdate'].$emplog[$i]['storecode'];
                          }else{
                               //$count++; //累積流水號
                               $day = $emplog[$i]['pdate']; //day設成進來的日期
                               $storecode = $emplog[$i]['storecode']; //storecode設成進來的店編
                               //$row['receiptno'] = $emplog[$i]['pdate'].'00'.$count; 
                               $row['receiptno'] = $emplog[$i]['pdate'].$emplog[$i]['storecode'];
                          }                         

                        $row['pdate']=$emplog[$i]['pdate'];
                        $row['personno']=$emplog[$i]['storecode'];
                        $row['sales']=$emplog[$i]['storecode'];
                        $row['storecode']=$emplog[$i]['storecode'];
                        $row['currency'] = 'NTD';
                        $row['price'] = '1';
                        $row['taxclass'] = '4';
                       // $logAry[$emplog[$i]['serviceno']] = $emplog[$i]['num'];                      
                        $row['amount'] = $emplog[$i]['num'];
                                                                                  
                        //得到服務編碼
                        $serno=$emplog[$i]['serviceno'];
                        //　取得選取的服務項目產生欄位
                         $serviceno = TbsService::model()->findByAttributes(
                                 array(),                              
                                 $condition = "serviceno = '$serno' AND opt1 = '1' ORDER BY serviceno "
                         ); 
              
                        $row['warehouseno']=$emplog[$i]['storecode'];
                         
                        $row['old_productno']=$emplog[$i]['serviceno'];
                        
                        if(isset($serviceno)){
                                                                           
                            //轉成mappingno   
                            $row['productno']=$serviceno->mappingno;
                            
                            
                            //得到單價
                            if($serviceno->type1==5){
                                
                                //為了細項描述寫的
                                $row['co25']=$serviceno->cname;
                                
                                 foreach ($Aryprice as  $value) {
                                    $row['uprice']=$value[$serviceno->noreceive];  
                                 }                                                                                   
                            }else
                            {
                            $row['uprice']=$serviceno->price;                            
                            }
                            
                            //得到金額
                            $row['total']= $row['amount'] * $row['uprice'];

                            //是否贈品
                            if($serviceno->opt2==1){
                               $row['gift']=1; 
                            }else
                            {
                               $row['gift']=0;  
                            }
                        }//if(isset($serviceno))
                                        
                        array_push($Arylog,$row);
                     }//for ($i = 0; $i < count($emplog); $i++)
                }//if(isset($emplog[0]['pdate']) OR isset($emplog[0]['storecode']) )
          }//if(count($emplog>0))
      
          unset($Aryprice);
          unset($emplog);
         
        //處理排序問題
        $ary = array();
        
        foreach ($Arylog as $log) {
            if($log['productno']!=null){ //過濾mappingno是空值
                 $ary[$log['pdate'].$log['storecode'].$log['productno'].$log['old_productno']] = $log;
            }         
        }
        //釋放
       unset($Arylog);
      
        ksort($ary);
        $index_key=array_keys($ary);     
      //  CVarDumper::dump($ary,10,true);
            if(count($ary>0)) {       
            
                if(isset($ary[$index_key[0]]['pdate']) and isset($ary[$index_key[0]]['productno']) and isset($ary[$index_key[0]]['personno']) ){
                    
                    //預設第一筆資料
                    $pdate = $ary[$index_key[0]]['pdate'];
                    $personno = $ary[$index_key[0]]['personno'];
                    $productno = $ary[$index_key[0]]['productno'];
                    $amount=$ary[$index_key[0]]['amount'];  
                    $price=$ary[$index_key[0]]['uprice'];                   
                    $row = $ary[$index_key[0]];  //第一個array整個資料               
                    $row['amount']=0;//第一個array的amount預設0
                      
                     foreach ($ary as $key => $value) {                        
                       
                           if($value['pdate']==$pdate and $value['personno']==$personno) {
                               
                               if($value['productno']==$productno) {
                              
                                    if($value['gift'] == 0){
                                        $row['amount'] = $row['amount'] + $value['amount'];
                                        $row['total'] = $row['amount'] * $value['uprice'];
                                        
                                        //如果少收
                                        if(isset($value['co25'])){
                                            $row['co25']=$value['co25'].'*'.$value['amount']; 
                                        }                                                                         
                                    }
                                    else {
                                        $row['amount'] = $row['amount'] - $value['amount'];                                     
                                        $row['total'] = $row['amount'] * $price; 
                                        $value['co25']='';//防止免費眷殘留之前文字 
                                        array_push($colAry, $row);                                        
                                        $row = $value;                                   
                                    }
                                } 
                                else
                                {
                                    array_push($colAry, $row);
                                    $pdate = $value['pdate'];
                                    $personno = $value['personno'];
                                    $productno = $value['productno'];
                                    $amount= $value['amount'];  
                                    $price=$value['uprice'];
                                    $value['co25']='';//歸0不然此欄位會殘留之前的   
                                    $row = $value;
                                }
                           }// if($value['pdate']==$pdate and $value['personno']==$personno) {
                           else
                           {                             
                               array_push($colAry, $row);
                          
                                $pdate = $value['pdate'];
                                $personno = $value['personno'];
                                $productno = $value['productno'];
                                $amount= $value['amount'];  
                                $price=$value['uprice'];
                                $value['co25']='';//歸0不然此欄位會殘留之前的                     
                                $row = $value; 
                           } 
                     } // foreach ($ary as $key => $value) {                        
                     array_push($colAry, $row);
                } // if(isset($ary[$index_key[0]]['pdate']) and isset($ary[$index_key[0]]['productno']) and isset($ary[$index_key[0]]['personno']) ){
            } // if(count($ary>0))                         
           
             unset($ary);
                                       
         // CVarDumper::dump($row,10,true);
   
         return $colAry;
      }
      
          
     private function exportEXCEL( $excelname ,$col, $title, $colAry) {
      
        // PHP EXCEL 初始化
        XPHPExcel::init();
        $fileTitle = "JIT Excel File";
        $objPHPExcel= XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("JIT")
                               ->setLastModifiedBy("JIT")
                               ->setTitle($fileTitle)
                               ->setSubject("")
                               ->setDescription($fileTitle)
                               ->setKeywords("office 2007 openxml php")
                               ->setCategory("Excel File");
        
        
        // 第一列 填入標題
        $column = 0; // 第幾欄. 由第0欄開始
        for ($i = 0; $i < count($col); $i++) {
            if(isset($title[$col[$i]])) {
                $objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($column,1, (isset($title[$col[$i]]))?
                        $title[$col[$i]]:'',PHPExcel_Cell_DataType::TYPE_STRING);
                $column++;
            }
        }
   
        // 後續 填入內容
        // 第幾列, 由第2列開始
        $row = 2;
        for ($j = 0; $j < count($colAry); $j++) {
            
            if(isset($colAry[$j][$col[0]])) {
                
                $column = 0; // 第幾欄. 由第0欄開始
                for ($i = 0; $i < count($col); $i++) {
                    
                    // 若符合篩選欄位. 才進行
                    if(isset($title[$col[$i]])){
                   
                    /*$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, (isset($colAry[$j][$col[$i]]))?
                        $colAry[$j][$col[$i]]:'');*/
                        
                    //避免(007002變7002) 0被吃掉，所以關鍵 setValueExplicit所有都轉字串                          
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($column, $row)->setValueExplicit((isset($colAry[$j][$col[$i]]))?
                        $colAry[$j][$col[$i]]:'', PHPExcel_Cell_DataType::TYPE_STRING);
                    
                        $column++;
                    }
                }
                $row++;
            }
        }

       //CVarDumper::dump($colAry,10,true);
        
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($excelname.'-正航匯入表');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a web browser (Excel5)
        $webroot = Yii::getPathOfAlias('webroot');
        //$fileName =$excelname.'-'.time().'.xls';
        $fileName ='PerformOut01'.'.xls';
        $filePath = $webroot . '/' . "protected" . '/' . "tmp" . '/';
        $fileUrl = $filePath.$fileName;
        
        // If you're serving to IE over SSL, then the following may be needed
        //        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        //        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        //        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        //        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $fileName = Yii::app()->request->baseUrl."/protected/tmp/".$fileName;
//        CVarDumper::dump($fileName);
//        $objWriter->save($fileName);

        $objWriter->save($fileUrl);
//        
//        Yii::app()->end();
//        $objWriter->save(str_replace('.php', '.xls', __FILE__));
//        $objWriter->save(str_replace(__FILE__,'/protected/tmp/'.$fileName,__FILE__));
//        $objWriter->save('/protected/tmp/'.$fileName);
//        @readfile('/protected/tmp/'.$fileName); 
//        spl_autoload_register(array('YiiBase','autoload'),true,true);

        return $fileName;
    }
       
    public function actionTest()
    {          
         $model= new TbaLog;
         
          if(isset($_POST['TbaLog']))
        {

            if(isset($_POST['create'])) {
               // CVarDumper::dump($_POST['TbaLog'],10,true);         
            }
        }
             
         
        $this->render('test',array(
                  'model'=>$model,              
		));
    }
    
     public function actionDynamicemps( )
    {     
        $empty = TRUE;
        $index='';
        if(isset($_GET['empty'])) $empty = $_GET['empty']; 
        if(isset($_POST['logtype'])) $index = $_POST['logtype'];  

        $data= new TbaLog;
        switch($index){
            case 1:
                 $result=array(0=>array('logday'=>'20140628','ctime'=>'20140628','num'=>'','price'=>''),1=>array('logday'=>'20140628','ctime'=>'20140629','num'=>'3','price'=>''));
                break;
            case 2:
                 $result=array(0=>array('item'=>'衛生紙','num'=>'5'));
                break;
            case 3:
                 $result=array(0=>array('memo'=>'我沒文具'));
                break;
        }
       
        $this->renderPartial('_type'.$index,array('model'=>$data,'result'=>$result), false, true);     
           
    }        
}
