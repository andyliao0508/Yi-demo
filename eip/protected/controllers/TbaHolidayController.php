<?php

class TbaHolidayController extends RController
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
		$model=new TbaHoliday;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TbaHoliday']))
		{
			$model->attributes=$_POST['TbaHoliday'];
                        $this->createData($model);  //呼叫RController
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

		if(isset($_POST['TbaHoliday']))
		{
			$model->attributes=$_POST['TbaHoliday'];
                        $this->updateData($model);  //呼叫RController
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
		$dataProvider=new CActiveDataProvider('TbaHoliday');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TbaHoliday('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TbaHoliday']))
			$model->attributes=$_GET['TbaHoliday'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TbaHoliday the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TbaHoliday::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TbaHoliday $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tba-holiday-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
       /*holiday page*/
        public function actionHoliday()   
    {
             if(isset( $_GET['date'])){
                $qry_year= $_GET['date'];
               }else{
                    $qry_year = date('Y'); //年份  
               }
               
             //$year=date('Y');
             $month=date('n'); //月份 
             $day=date('d');//天數
             $months=array('一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'); //月數
             
             if(isset($_POST['qry_year']))      $qry_year = $_POST['qry_year'];  //取輸入年份的資料
             
             /*defalut annual calendar vacation background color is red*/
            if(isset($_POST['vacation'])){
               $_varr=array(); //假日array()
      
                for ($reihe=1; $reihe<=3; $reihe++) {

                    for ($spalte=1; $spalte<=4; $spalte++) {
                        $this_month=($reihe-1)*4+$spalte;
                        $erster=date('w',mktime(0,0,0,$this_month,1,$qry_year));
                        $insgesamt=date('t',mktime(0,0,0,$this_month,1,$qry_year));

                        $i=1;
                        //月份期不足10補0使用
                        if($this_month<10){
                          $this_month= '0'.$this_month;
                          } 

                        while ($i<=$insgesamt) {
                          $rest=($i+$erster-1)%7;

                          //日期不足10補0使用
                          if($i<10){
                                  $i= '0'.$i;
                              }     
                              
                             $holiday = "$qry_year$this_month$i" ;
                             $vacation=$this->isWeekend($holiday); //判斷是否為星期六、日
    
                             //是六日、則被$_varr變數存入
                             if($vacation==true)
                              {                     
                                  array_push($_varr, $holiday);
                              }    		
                          $i++;
                      }
                    }
                }
            
            for ($i = 0; $i < count($_varr); $i++) {
                //從DB判斷日期是否存在
                $judgement= TbaHoliday::model()->findByAttributes(array(), 
                $conditon = " holiday = '$_varr[$i]' "
                );
              
               
                $holiday_model=new TbaHoliday;// object instance

                //if假日不存在新增至DB
                if(!isset($judgement)){                   
                   $holiday_model->holiday=$_varr[$i];
                   $holiday_model->save();
                }                                                       
            }       
            //CVarDumper::dump( isWeekend('2014-01-06'),10,true);          
            }
                              
             if(isset($_GET['update'])){
                 if(isset($_GET['holiday'])) {
                     
                      $qry_year = $_GET['date']; //得到年分
                     
                     $holiday =$_GET['holiday'];//取得所點選日期
                   
                    //從DB判斷日期是否存在                     
                     $judgement= TbaHoliday::model()->findByAttributes(array(), 
                     $conditon = " holiday = '$holiday' "
                     );
                     
                    $holiday_model=new TbaHoliday;// object instance

                    //if日期存在則抓出id
                    if(isset($judgement)){
                    $model=TbaHoliday::model()->findByPk($judgement->id);  
                    }
                    //日期不是空值
                    if(isset($model)){       
                      $this->loadModel($judgement->id)->delete();
                    }else
                        {            
                       $holiday_model->holiday=$holiday;
                       $holiday_model->save();
                        }
                        $this->redirect(array('holiday','date'=>$qry_year));//跳轉回holiday頁面
                     // CVarDumper::dump( $model,10,true);
                 }else{
                      Yii::app()->user->setFlash('error', '資料錯誤！');
                 }
             }
          
              $sql = "SELECT holiday FROM tba_holiday where MID(holiday,1,4) = '$qry_year'";
                     $_arr = Yii::app()->db->createCommand($sql)->queryAll(); 
                     
                    //將雙層array轉成單層array()
                     $result=array();
                     for ($i = 0; $i < count($_arr); $i++) {
                         array_push($result, $_arr[$i]['holiday']);                    
                     }
                   
            $this->render('holiday',array(
			'qry_year'=>$qry_year,
                        'month'=>$month,
                        'day'=>$day,
                        'months'=>$months,
                        'result'=>$result,
            )); 
    }
    
        //判斷是否為六日
        private function isWeekend($date) {
            $weekDay = date('w', strtotime($date));
            return ($weekDay == 0 || $weekDay == 6);
        }
            
}
