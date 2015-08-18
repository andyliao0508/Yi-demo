<?php

class TbpPerformRptController extends RController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';

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
     * 業績報表(個人)
     */
    public function actionRpt01()
    {
       $empno='';
        if(isset($_GET['empno'])){        
            Yii::app()->session['empno'] = $_GET['empno'];
            $this->redirect(array('rpt01'));//跳轉回rpt01頁面        
        }else
            { 
                if(Yii::app()->session['empno']!=''){
                    $empno=Yii::app()->session['empno'];
                    //沒使用到清空
                //    unset(Yii::app()->session['empno']);
                }else{
                        // 取得員工編號
                        $empno = Yii::app()->user->id;
                     }
            }
        
        // 查詢員工資料
        $user = User::model()->findByPk($empno);
        
        //得到達成率的年月
        $achYM = isset($_POST['achYm'])?$_POST['achYm']:date('Ym');
        
        // 預設月初至今天
       $qryStart = date("Ym01");   
       $qryEnd = date("Ymd");   
       
       if(isset($_POST["qryDates"])) {
           if(isset($_POST['qryStart']))  $qryStart = $_POST['qryStart'];
           if(isset($_POST['qryEnd']))  $qryEnd = $_POST['qryEnd'];
       }
               
        if($qryEnd < $qryStart ){
               Yii::app()->user->setFlash('error', '結束日期不可小於起始日期！');
           } 
           
        //切割出年份
        $tmp_year=substr($achYM,0,4);
        //切割出月份
        $tmp_mon =substr($achYM,4,2);

        if(isset($_POST['achieveqry'])){
            $qryStart = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));
            $qryEnd = date("Ymd", mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year));            
        }               
        
        $aStart = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));
        $aEnd = date("Ymd", mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year));

        // 先利用GROUP算出此員工在此日期區間內各項業績總和. 用來產生欄位數, 並取得中文名稱
        $sql = "SELECT a.serviceno, b.showname, a.num 
                     FROM (
                            ( SELECT serviceno, SUM( num ) AS num FROM tbp_perform_emp_log 
                              WHERE empno = '$empno' AND pdate BETWEEN '$aStart' AND '$aEnd' GROUP BY serviceno ) a
                          LEFT JOIN tbs_service b
                                     ON a.serviceno = b.serviceno
                    )
                    ORDER BY a.serviceno ";

        $result = Yii::app()->db->createCommand($sql)->queryAll();
      
         // 門市. 門市ID
        $storeAry = array();
        $storeAreaId = array();
        $TbsStores = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsStores as $store) {
            $storeAry[$store->storecode] = $store->storename;
            $storeAreaId[$store->storecode] = $store->area_id;
        }
        unset($TbsStores);

        // 區域
        $areaAry = array();
        $TbsAreas = TbsArea::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsAreas as $area) {
            $areaAry[$area->id] = $area->areaname;
        }
        unset($TbsAreas);
        
        // 職位
        $positionAry = array();
        $TbsPositions = TbsPosition::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsPositions as $pos) {
            $positionAry[$pos->id] = $pos->pcname;
        }
        unset($TbsPositions);
        
        // 薪資, 責任額
        $salaryAry = array(); 
        $dutyAry = array();
        
        $TbsBaseSalary = TbsBasesalary::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsBaseSalary as $salary) {
            $salaryAry[$salary->id] = $salary->salary;
            $dutyAry[$salary->id] = $salary->duty;
        }
        unset($TbsBaseSalary);
        
        $acol = $this->getRpt01Col();
        $atitle = $this->getRpt01Title($acol);
        $colAry = array();
        
        $col = $this->getRpt01Col2(); // 欄位ID
        $title = $this->getRpt01Title2($col); // 抬頭
         // 合計
        $sum = array(
            'col1'=>0,
            'col2'=>0,
            'col3'=>0,
            'col4'=>0,
            'col5'=>0,
            'col6'=>0,
//            'col7'=>0,
//            'col8'=>0,
            'col9'=>0,
            'col10'=>0,
            'col11'=>0,
            'col12'=>0,
            'col13'=>0,
            'col14'=>0,
            'col15'=>0,
            'col16'=>0,
            'col17'=>0, 
        );
        $logArray = array(); // 個人業績紀錄
       
        // 利用 col 把每一個ARRAY的值丟進入
        // col[0]='A01', col[1]='B01'
        // title['A01']='剪髮, title['B01']='燙髮'
        // sum['A01]=剪髮合計, sum['B01]=燙髮合計
        $empMonth = TbsEmpMonth::model()->findByDayMonth($empno, $achYM);
            
        if($empMonth!=NULL){

            if($result!= NULL){
            Yii::app()->user->setFlash('success', $tmp_year.'年'.$tmp_mon.'月'.'業績查詢成功！染髮顆數包含燙髮，洗髮(促)為洗髮不加十元顆數！');
            }else{
                Yii::app()->user->setFlash('error', $tmp_year.'年'.$tmp_mon.'月'.'查無業績！');
            }

            $row = array();
            // 年月
            $row['ym'] = $achYM;
            // 營業區
            $row['area'] = $areaAry[$empMonth->area];
            // 門市
            $row['store'] = $storeAry[$empMonth->storecode];
            // 職稱
            $row['position'] = $positionAry[$empMonth->position1];
            // 員編
            $row['empno'] = $empno;
            // 姓名
            $row['name'] = ($user->emp)?$user->emp->empname:''; 
            // 到職日
            $row['arrivedate'] = Yii::app()->dateFormatter->format("yyyy-MM-dd",$empMonth->arrivedate,"yyyy-MM-dd");
            // 狀態
            $row['status'] = TbsEmp::model()->getHireType($empMonth->hiretype);
            // 保底
            $row['salary'] = $salaryAry[$empMonth->salary];
            // 責任業績, 區店長需動態算, opt2欄位設成管理門市數
            // 103/7/1 區店長責任額修正
//            if($empMonth->position1 == 9){
//                $areaduty = TbsAreaduty::model()->findByAttributes(array('storenum'=>$empMonth->opt2));
//                if(isset($areaduty))
//                    $row['duty'] = $areaduty->duty;
//            }else
                $row['duty'] = $dutyAry[$empMonth->salary];

            $asum = array();

            for ($i = 0; $i < count($result); $i++) {
                $asum[$result[$i]['serviceno']] = $result[$i]['num'];
            }

            // 設定各欄位業績及洗助算法
             $row = $this->setRpt01RowData($row,$asum);

            // 達成率
            $rate = ($row['duty']==0)?0:round( ($row['perform']/$row['duty']),4 );
            $row['rate'] = $rate*100 . "%";

//                //洗髮+10 
//                $row['col10'] = isset($empData['col10'])?$empData['col10']:0;
//
//                //洗髮不加10 
////                $row['col11'] = 0;
//                $row['col11'] = isset($empData['col11'])?$empData['col11']:0;

            // 是否達成
            $row['achi'] = ($rate>=1)?'達成':'未達成';            

            if( ($row['perform'] + $row['assist']) > 0)

            array_push($colAry, $row);

        // ================== 以下為業績區間 ======================================
         
        // 查詢業績區間
        for ($i = 0; $i <= ( $qryEnd - $qryStart ); $i++) {
            
            $pdate = $qryEnd-$i;
            // 利用員編+日期查詢
            $emplog = TbpPerformEmpLog::model()->findAllByAttributes(
                    array('empno'=>$empno,'pdate'=>$pdate));
          
            $count = count($emplog);
            
            if($count > 0){
                
                $ary = array(
                    'col1'=>0,
                    'col2'=>0,
                    'col3'=>0,
                    'col4'=>0,
                    'col5'=>0,
                    'col6'=>0,
//                    'col7'=>0,
//                    'col8'=>0,
                    'col9'=>0,
                    'col10'=>0,
                    'col11'=>0,
                    'col12'=>0,
                    'col13'=>0,
                    'col14'=>0,
                    'col15'=>0,
                    'col16'=>0,
                    'col17'=>0
                );
                // 門市
                $pstore = $emplog[0]->storecode;
                
                // 如果同一天有2間門市以上之業績時, 會有多筆
                for ($logi = 0; $logi < $count; $logi++) {
                    //  需要PUSH多筆
                    if($pstore != $emplog[$logi]->storecode){

                        $sum['store'] = '合計';
                        $sum['col1'] = $sum['col1'] + $ary['col1'];
                        $sum['col2'] = $sum['col2'] + $ary['col2'];
                        $sum['col3'] = $sum['col3'] + $ary['col3'];
                        $sum['col5'] = $sum['col5'] + $ary['col5'];
                        $sum['col6'] = $sum['col6'] + $ary['col6'];
//                        $sum['col7'] = $sum['col7'] + $ary['col7'];            
//                        $sum['col8'] = $sum['col8'] + $ary['col8'];
                        $sum['col9'] = $sum['col9'] + $ary['col9'];
                        $sum['col10'] = $sum['col10'] + $ary['col10'];
                        $sum['col11'] = $sum['col11'] + $ary['col11'];
                        $sum['col12'] = $sum['col12'] + $ary['col12'];
                        $sum['col13'] = $sum['col13'] + $ary['col13'];         
                        $sum['col14'] = $sum['col14'] + $ary['col14'];
                        $sum['col15'] = $sum['col15'] + $ary['col15'];
                        $sum['col16'] = $sum['col16'] + $ary['col16'];
                        $sum['col17'] = $sum['col17'] + $ary['col17'];
                        array_push($logArray, $ary);
                        
                        $pstore = $emplog[$logi]->storecode;                        
                        $ary = array(
                            'col1'=>0,
                            'col2'=>0,
                            'col3'=>0,
                            'col4'=>0,
                            'col5'=>0,
                            'col6'=>0,
//                            'col7'=>0,
//                            'col8'=>0,
                            'col9'=>0,
                            'col10'=>0,
                            'col11'=>0,
                            'col12'=>0,
                            'col13'=>0,
                            'col14'=>0,
                            'col15'=>0,
                            'col16'=>0,
                            'col17'=>0
                        );
                    }
                    
                    // 日期
                    $ary['pdate'] = $emplog[$logi]->pdate;
                    // 門市
                    $ary['store'] = $emplog[$logi]->storename;
                    
                    // 剪
                    if($emplog[$logi]->serviceno == 'A01') $ary['col1'] = $ary['col1'] + $emplog[$logi]->num;
                    if($emplog[$logi]->serviceno == 'S01') $ary['col1'] = $ary['col1'] + $emplog[$logi]->num;
                    if($emplog[$logi]->serviceno == 'S05') $ary['col1'] = $ary['col1'] + $emplog[$logi]->num;
                    //染
                    if($emplog[$logi]->serviceno == 'B01') $ary['col2'] = $ary['col2'] + $emplog[$logi]->num;
                    //助染
                    if($emplog[$logi]->serviceno == 'B02') $ary['col3'] = $ary['col3'] + $emplog[$logi]->num;
                    //優染
                    if($emplog[$logi]->serviceno == 'S03') $ary['col5'] = $ary['col5'] + $emplog[$logi]->num;
                    //優助染
                    if($emplog[$logi]->serviceno == 'S04') $ary['col6'] = $ary['col6'] + $emplog[$logi]->num;
                    //舒活SPA
//                    if($emplog[$logi]->serviceno == 'E01') $ary['col7'] = $ary['col7'] +$emplog[$logi]->num;
                    //養護SPA
//                    if($emplog[$logi]->serviceno == 'E02') $ary['col8'] = $ary['col8'] + $emplog[$logi]->num;
                    //洗髮精
                    if($emplog[$logi]->serviceno == 'N041') $ary['col9'] = $ary['col9'] + $emplog[$logi]->num;
                    if($emplog[$logi]->serviceno == 'N042') $ary['col12'] = $ary['col12'] + $emplog[$logi]->num;
                    if($emplog[$logi]->serviceno == 'N043') $ary['col13'] = $ary['col13'] + $emplog[$logi]->num;
                    //洗髮+10
                    if($emplog[$logi]->serviceno == 'D01') $ary['col10'] = $ary['col10'] + $emplog[$logi]->num;
                    //洗髮不+10
                    if($emplog[$logi]->serviceno == 'S02') $ary['col11'] = $ary['col11'] + $emplog[$logi]->num;
                    if($emplog[$logi]->serviceno == 'S06') $ary['col11'] = $ary['col11'] + $emplog[$logi]->num;
                    //髮油
                    if($emplog[$logi]->serviceno == 'N051') $ary['col14'] = $ary['col14'] + $emplog[$logi]->num;                   
                    //瞬護
                    if($emplog[$logi]->serviceno == 'F07') $ary['col15'] = $ary['col15'] + $emplog[$logi]->num;
                    //隔離
                    if($emplog[$logi]->serviceno == 'F08') $ary['col16'] = $ary['col16'] + $emplog[$logi]->num;                   
                    //髮雕
                    if($emplog[$logi]->serviceno == 'N052') $ary['col17'] = $ary['col17'] + $emplog[$logi]->num;
                    
                }
                    
                    $sum['store'] = '合計';
                    $sum['col1'] = $sum['col1'] + $ary['col1'];
                    $sum['col2'] = $sum['col2'] + $ary['col2'];
                    $sum['col3'] = $sum['col3'] + $ary['col3'];
                    $sum['col5'] = $sum['col5'] + $ary['col5'];
                    $sum['col6'] = $sum['col6'] + $ary['col6'];
//                    $sum['col7'] = $sum['col7'] + $ary['col7'];            
//                    $sum['col8'] = $sum['col8'] + $ary['col8'];
                    $sum['col9'] = $sum['col9'] + $ary['col9'];
                    $sum['col10'] = $sum['col10'] + $ary['col10'];
                    $sum['col11'] = $sum['col11'] + $ary['col11'];
                    $sum['col12'] = $sum['col12'] + $ary['col12'];
                    $sum['col13'] = $sum['col13'] + $ary['col13'];
                    $sum['col14'] = $sum['col14'] + $ary['col14'];
                    $sum['col15'] = $sum['col15'] + $ary['col15'];
                    $sum['col16'] = $sum['col16'] + $ary['col16'];
                    $sum['col17'] = $sum['col17'] + $ary['col17'];
                    
                    array_push($logArray, $ary);
                }
            }   
            array_push($logArray, $sum);
        }
   
       $com=new ComFunction;
       $attendance=$com->getAbsenceByEmp($achYM, $empno,TRUE);  //呼叫差勤結果
       $weight=$com->getWeightByEmp($achYM, $empno);  //呼叫差勤結果

        $this->render('rpt01',array(
            'user'=>$user,
            'achYM'=>$achYM,
            'qryStart'=>$qryStart,
            'qryEnd'=>$qryEnd,
            'acol'=>$acol,
            'atitle'=>$atitle,
            'col'=>$col,
            'title'=>$title,
            'sum'=>$sum,
            'logArray'=>$logArray,
            'colAry'=>$colAry,
            'attendance'=>$attendance,
            'weight'=>$weight,
        ));
    }

  /**
    * 
    * @return string
    */
    private function getRpt01Col(){
              
        $acol = array(0 => 'ym',
                            1 => 'area',
                            2 => 'store',
                            3 => 'position',
                            4 => 'empno',
                            5 => 'name',
                            6 => 'arrivedate',
                            7 => 'status',
                            8 => 'salary',
                            9 => 'col1', // 剪髮
                            10 => 'col2', // 染髮
                            11 => 'col3', // 助染
                            12 => 'col5', // 優染
                            13 => 'col6', // 優助染
                            14 =>'col10',//洗髮+10
                            15 =>'col11',//洗髮(不加)
//                            16 => 'col7', // 舒活SPA 
//                            17 => 'col8', // 養護SPA
                            16 => 'col9', // 洗髮精
                            17 => 'col12', // 髮油
                            18 => 'col13', // 瞬護 
                            19 => 'col14', // 隔離
                            20 => 'col15', // 髮雕
                            21 => 'perform',
                            22 => 'assist',
                            23 => 'duty',
                            24 => 'rate',
                            25 => 'achi',
                         
            );        
          return $acol;
    }
    /**
     * 
     * @param type $col
     * @return string
     */
    private function getRpt01Title($acol){
       
        $atitle = array('ym' => '年月',
                            'area' => '營業區',
                            'store' => '門市',
                            'position' => '職稱',
                            'empno' => '員編',
                            'name' => '姓名',
                            'arrivedate' => '到職日',
                            'status' => '狀態',
                            'salary' => '薪資<br>福利',
                            'col1' => '剪髮',
                            'col2' => '染髮',
                            'col3' => '助染',
                            'col5' => '優染',
                            'col6' => '優助染',
//                            'col7' => '舒活<br>SPA',
//                            'col8' => '養護<br>SPA',
                            'col9' => '洗髮精',
                            'col12' => '髮油',
                            'col13' => '瞬護',
                            'col14' => '隔離',
                            'col15' => '髮雕',
                            'perform' => '剪.染.燙',
                            'assist' => '洗助',
                            'duty' => '責任額',
                            'rate' => '達成率',
                            'achi' => '達成<br>與否',
                            'col10' => '洗髮',
                            'col11' => '洗髮(促)',
                            
            );
        
        return $atitle;    
    }
    
    /**
    * 
    * @return string
    */
    private function getRpt01Col2(){
              
        $col = array(0 => 'pdate',
                    1 => 'store',
                    2 => 'col1', // 剪髮
                    3 => 'col2', // 染髮
                    4 => 'col3', // 助染
                    5 => 'col5', // 優染
                    6 => 'col6', // 優助染
                    7 =>'col10', //洗髮+10
                    8 =>'col11', //洗髮(不加)
//                            9 => 'col7', // 舒活SPA 
//                            10 => 'col8', // 養護SPA
                    9 => 'col9', // 深層潔淨洗髮精
                    10 => 'col12', // 茶樹SPA洗髮精
                    11 => 'col13', // 保溼修護洗髮精
                    12 => 'col14',  // 髮油
                    13 => 'col15',  // 瞬護
                    14 => 'col16',  // 隔離
                    15 => 'col17',  // 髮雕
                            
            );         
          return $col;
    }
    
    /**
     * 
     * @param type $col
     * @return string
     */
    private function getRpt01Title2($col){
       
        $title = array('pdate' => '日期',
                'store' => '門市',
                'col1' => '剪髮',
                'col2' => '染髮',
                'col3' => '助染',
                'col5' => '優染',
                'col6' => '優助染',
//                            'col7' => '舒活<br>SPA',
//                            'col8' => '養護<br>SPA',
                'col9' => '深層潔淨<br>洗髮精',
                'col10' => '洗髮',
                'col11' => '洗髮(促)',
                'col12' => '茶樹SPA<br>洗髮精',
                'col13' => '保溼修護<br>洗髮精',
                'col14' => '髮油',
                'col15' => '瞬護',
                'col16' => '隔離',
                'col17' => '髮雕',
                            
            );
        
        return $title;    
    }
    
    private function setRpt01RowData($row, $asum){
        
            // 剪髮 = A01 + S01 + S05
            $row['col1'] = 0;
            if(isset($asum['A01'])) $row['col1'] = $asum['A01'];
            if(isset($asum['S01'])) $row['col1'] = $row['col1'] + $asum['S01'];
            if(isset($asum['S05'])) $row['col1'] = $row['col1'] + $asum['S05'];
            
            // 染髮 = B01 + C01
            $row['col2'] = 0;
            if(isset($asum['B01'])) $row['col2'] = $asum['B01'];
            if(isset($asum['C01'])) $row['col2'] = $row['col2'] + $asum['C01'];

            // 助染 = B02 + C02
            $row['col3'] = 0;
            if(isset($asum['B02'])) $row['col3'] = $asum['B02'];
            if(isset($asum['C02'])) $row['col3'] = $row['col3'] + $asum['C02'];

            // 洗髮+10 = D01 + S02 + S06
            $row['col10'] = 0;
            if(isset($asum['D01'])) $row['col10'] = $asum['D01'];
            
            // 洗髮不+10 = S02 + S06
            $row['col11'] = 0;
            if(isset($asum['S02'])) $row['col11'] = $asum['S02'];
            if(isset($asum['S06'])) $row['col11'] = $row['col11'] + $asum['S06'];            

            // 優染 = S03
            $row['col5'] = 0;
            if(isset($asum['S03'])) $row['col5'] = $asum['S03'];
            
            // 優助染 = S04
            $row['col6'] = 0;
            if(isset($asum['S04'])) $row['col6'] = $asum['S04'];
            
            // 舒活SPA = E01
//            $row['col7'] = 0;
//            if(isset($asum['E01'])) $row['col7'] = $asum['E01'];
            
            // 養護SPA = E02
//            $row['col8'] = 0;
//            if(isset($asum['E02'])) $row['col8'] = $asum['E02'];
            
            // 洗髮精 = N041 + N042 + N043
            $row['col9'] = 0;
            if(isset($asum['N041'])) $row['col9'] = $asum['N041'];
            if(isset($asum['N042'])) $row['col9'] = $row['col9'] + $asum['N042'];
            if(isset($asum['N043'])) $row['col9'] = $row['col9'] + $asum['N043'];
                                                
            // 髮油 = N051
            $row['col12'] = 0;
            if(isset($asum['N051'])) $row['col12'] = $asum['N051'];    
            
            // 瞬護 = F07
            $row['col13'] = 0;
            if(isset($asum['F07'])) $row['col13'] = $asum['F07'];
            
            // 隔離 = F08
            $row['col14'] = 0;
            if(isset($asum['F08'])) $row['col14'] = $asum['F08'];
            
            // 髮雕 = N052
            $row['col15'] = 0;
            if(isset($asum['N052'])) $row['col15'] = $asum['N052'];
                                    
            // 剪染燙
            $row['perform'] = $this->getPerform($asum);
            // 洗助
            $row['assist'] = $this->getAssist($asum);

            return $row;
    }
        
    
    /**
     * 四級報表
     */
    public function actionRpt07(){

        //得到達成率的年月
        $achYM = date('Ym');
        
        if(isset($_POST['achYm']))
            $achYM = $_POST['achYm'];
        
        //切割出年份
        $tmp_year=substr($achYM,0,4);
        //切割出月份
        $tmp_mon =substr($achYM,4,2);

        $aStart = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));
        $aEnd = date("Ymd", mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year));        
        
        // 營業部
        $empAry = array();
        if(isset($_POST['qry'])){
            $empAry = TbsEmpMonth::model()->findAllByAttributes(array('depart'=>3,'daymonth'=>$achYM),array('order'=>'area, storecode'));
//            $empAry = TbsEmpMonth::model()->findAllByAttributes(array('empno'=>'03010460'),array('order'=>'area, storecode'));
        }
        
        // 取得欄位及表頭
        $col = $this->getRpt07Col();
        $title = $this->getRpt07Title($col);
        
        $colAry = array();
        // 門市. 開市ID
        $storeAry = array();
        $storeAreaId = array();
        $TbsStores = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsStores as $store) {
            $storeAry[$store->storecode] = $store->storename;
            $storeAreaId[$store->storecode] = $store->area_id;
        }
        
        // 區域
        $areaAry = array();
        $TbsAreas = TbsArea::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsAreas as $area) {
            $areaAry[$area->id] = $area->areaname;
        }
        
        // 職位
        $positionAry = array();
        $TbsPositions = TbsPosition::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsPositions as $pos) {
            $positionAry[$pos->id] = $pos->pcname;
        }
        
        foreach ($empAry as $emp) {
//        $emp = new TbsEmp();
//        $emp = $empAry[0];
            $row = array();
            // 查詢員工資料
            $salary = TbsBasesalary::model()->findByPk($emp->salary);
            
            // 年月
            $row['ym'] = $achYM;
            
            // 營業區
            $row['area'] = $areaAry[$storeAreaId[$emp->storecode]];
            // 門市
            $row['store'] = $storeAry[$emp->storecode];
            // 職稱
            $row['position'] = $positionAry[$emp->position1];
            // 員編
            $row['empno'] = $emp->empno;
            // 姓名
            $user = User::model()->findByPk($emp->empno);
            $row['name'] = isset($user->emp)?$user->emp->empname:"";
            // 到職日
            $row['arrivedate'] = Yii::app()->dateFormatter->format("yyyy-MM-dd",$emp->arrivedate,"yyyy-MM-dd");
            // 狀態
            $row['status'] = TbsEmp::model()->getHireType($emp->hiretype);
            // 保底
            $row['salary'] = $salary->salary;
            // 責任業績, 區店長需動態算, opt2欄位設成管理門市數
            // 103/7/1 區店長責任額修正
//            if($emp->position1 == 9){
//                $areaduty = TbsAreaduty::model()->findByAttributes(array(storenum=>$emp->opt2));
//                if(isset($areaduty))
//                    $row['duty'] = $areaduty->duty;
//            }else
                $row['duty'] = $salary->duty;
            
            // 先利用GROUP算出此員工在此日期區間內各項業績總和. 用來產生欄位數, 並取得中文名稱
            $sql = "SELECT a.serviceno, b.showname, a.num 
                         FROM (
                                ( SELECT serviceno, SUM( num ) AS num FROM tbp_perform_emp_log 
                                  WHERE empno = '$emp->empno' AND pdate BETWEEN '$aStart' AND '$aEnd' GROUP BY serviceno ) a
                              LEFT JOIN tbs_service b
                                         ON a.serviceno = b.serviceno
                        )
                        ORDER BY a.serviceno ";

            $result = Yii::app()->db->createCommand($sql)->queryAll();            
            $asum = array(); // 數字            
            
            // 利用 col 把每一個ARRAY的值丟進入
            // col[0]='A01', col[1]='B01'
            // title['A01']='剪髮, title['B01']='燙髮'
            // sum['A01]=剪髮合計, sum['B01]=燙髮合計
            for ($i = 0; $i < count($result); $i++) {
                $asum[$result[$i]['serviceno']] = $result[$i]['num'];
            }
            // 設定各欄位業績及洗助算法
            $row = $this->setRpt07RowData($row,$asum);

            // 達成率            
            $rate = ($row['duty']==0)?0:round( ($row['perform']/$row['duty']),4 );
            $row['rate'] = $rate*100 . "%";
            
            // 是否達成
            $row['achi'] = ($rate>=1)?'達成':'未達成';            
            
            if( ($row['perform'] + $row['assist']) > 0)
                array_push($colAry,$row);
        }        

        $this->render('rpt07',array(

            'achYM'=>$achYM,
            'col'=>$col,
            'title'=>$title,
            'colAry'=>$colAry,
        ));                
        
    }
    
    public function actionIndex()
    {
        $this->render('index',array(
        ));
    }    
    
    /**
     * 取得洗.染.燙業績
     * @param type $ary
     * @return int
     */
    private function getPerform($ary){
        
        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'1'));
        if(count($service)>0)
            foreach ($service as $row) {
                $serviceno = $row->serviceno;
                if(isset($ary[$serviceno]))
                    $sum = $sum + $ary[$serviceno] * $row->perform;
            }
        return $sum;
    }
    
    /**
     * 取得洗助業績
     * @param type $ary
     * @return int
     */
    private function getAssist($ary){
       
        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'2'));
        if(count($service)>0)
            foreach ($service as $row) {
                $serviceno = $row->serviceno;
                if(isset($ary[$serviceno]))
                    $sum = $sum + $ary[$serviceno] * $row->draw;
            }
        return $sum;       
    }
    
    /**
     * 
     * @return type
     */
    private function getRpt07Col(){
        
        $col = array(0 => 'ym',
                            1 => 'area',
                            2 => 'store',
                            3 => 'position',
                            4 => 'empno',
                            5 => 'name',
                            6 => 'arrivedate',
                            7 => 'status',
                            8 => 'salary',
                            9 => 'col1', // 剪髮
                            10 => 'col2', // 染髮
                            11 => 'col3', // 助染
                            12 => 'col4', // 洗髮
                            13 => 'col5', // 優染
                            14 => 'col6', // 優助染
                            15 => 'col7', // 舒活SPA 
                            16 => 'col8', // 養護SPA
                            17 => 'col9', // 洗髮棈
                            18 => 'perform',
                            19 => 'assist',
                            20 => 'duty',
                            21 => 'rate',
                            22 => 'achi'
            );
        
        return $col;
    }
    
    /**
     * 取得表頭
     * @return type
     */
    private function getRpt07Title($col){
        
        for ($i = 0; $i < count($col); $i++) {
            
        }
        
        $title = array('ym' => '年月',
                            'area' => '營業區',
                            'store' => '門市',
                            'position' => '職稱',
                            'empno' => '員編',
                            'name' => '姓名',
                            'arrivedate' => '到職日',
                            'status' => '狀態',
                            'salary' => '保底',
                            'col1' => '剪髮',
                            'col2' => '染髮',
                            'col3' => '助染',
                            'col4' => '洗髮',
                            'col5' => '優染',
                            'col6' => '優助染',
                            'col7' => '舒活<br>SPA',
                            'col8' => '養護<br>SPA',
                            'col9' => '洗髮精',
                            'perform' => '剪.染.燙',
                            'assist' => '洗助',
                            'duty' => '責任業績',
                            'rate' => '達成率',
                            'achi' => '達成'
            );
        
        return $title;    
    }
    
    /**
     * 四級報表用加總
     * @param type $row
     * @param type $asum
     * @return type
     */
    private function setRpt07RowData($row, $asum){
        
            // 剪髮 = A01 + S01 + S05
            $row['col1'] = 0;
            if(isset($asum['A01'])) $row['col1'] = $asum['A01'];
            if(isset($asum['S01'])) $row['col1'] = $row['col1'] + $asum['S01'];
            if(isset($asum['S05'])) $row['col1'] = $row['col1'] + $asum['S05'];
            
            // 染髮 = B01 + C01
            $row['col2'] = 0;
            if(isset($asum['B01'])) $row['col2'] = $asum['B01'];
            if(isset($asum['C01'])) $row['col2'] = $row['col2'] + $asum['C01'];

            // 助染 = B02 + C02
            $row['col3'] = 0;
            if(isset($asum['B02'])) $row['col3'] = $asum['B02'];
            if(isset($asum['C02'])) $row['col3'] = $row['col3'] + $asum['C02'];

            // 洗髮 = D01 + S02 + S06
            $row['col4'] = 0;
            if(isset($asum['D01'])) $row['col4'] = $asum['D01'];
            if(isset($asum['S02'])) $row['col4'] = $row['col4'] + $asum['S02'];
            if(isset($asum['S06'])) $row['col4'] = $row['col4'] + $asum['S06'];            

            // 優染 = S03
            $row['col5'] = 0;
            if(isset($asum['S03'])) $row['col5'] = $asum['S03'];
            
            // 優助染 = S04
            $row['col6'] = 0;
            if(isset($asum['S04'])) $row['col6'] = $asum['S04'];
            
            // 舒活SPA = E01
            $row['col7'] = 0;
            if(isset($asum['E01'])) $row['col7'] = $asum['E01'];
            
            // 養護SPA = E02
            $row['col8'] = 0;
            if(isset($asum['E02'])) $row['col8'] = $asum['E02'];
            
            // 洗髮精 = N041 + N042 + N043
            $row['col9'] = 0;
            if(isset($asum['N041'])) $row['col9'] = $asum['N041'];
            if(isset($asum['N042'])) $row['col9'] = $row['col9'] + $asum['N042'];
            if(isset($asum['N043'])) $row['col9'] = $row['col9'] + $asum['N043'];
            
            // 剪染燙
            $row['perform'] = $this->getPerform($asum);
            // 洗助
            $row['assist'] = $this->getAssist($asum);

            return $row;
    }

    /**
     * 管理部報表
     */
    public function actionRpt08(){

        // 用以計算開始/結束時間之變數
        $time_start = microtime(true);

        // Sleep for a while
        usleep(100);          
        
        //得到起始 結束的年月日
        $qry_dateS = date('Ymd');
        $qry_dateE = date('Ymd');
        
        $qry_area = ""; //區域
        $qry_store = ""; // 門市
        $qry_empno = ""; //員編
        $qry_empname = ""; //姓名
        
        $qry_serviceno = array(); //服務項目
        $serviceno_seq = array(); //服務項目順序
 
        $rpttype =""; // 報表類型
        $rptname = ""; // 報表名稱
        
        if(isset($_POST['qry_dateS']))        $qry_dateS = $_POST['qry_dateS'];
        if(isset($_POST['qry_dateE']))        $qry_dateE = $_POST['qry_dateE'];
        if(isset($_POST['qry_area']))          $qry_area = $_POST['qry_area'];    
        if(isset($_POST['qry_store']))         $qry_store = $_POST['qry_store']; 
        if(isset($_POST['rpttype']))            $rpttype = $_POST['rpttype']; 
        if(isset($_POST['rptname']))          $rptname = $_POST['rptname'];
        if(isset($_POST['qry_empno']))      $qry_empno = $_POST['qry_empno'];
        if(isset($_POST['qry_empname']))  $qry_empname = $_POST['qry_empname'];
        if(isset($_POST['qry_serviceno']))  $qry_serviceno = $_POST['qry_serviceno'];
        
        // 服務項目陣列(上面的篩選條件)
        $serviceary = array();
        
        // 報表預設之欄位名稱
        $defaultAry =  TbpPerformParamRpt08::model()->getRptCol();
        // 報表預設之中文名稱
        $servicearyname = TbpPerformParamRpt08::model()->getRptTitle();
        
        // 產生畫面用的篩選checkboxlist
        // 先取得預設. 再查詢目前已設定之服務項目
        foreach ($defaultAry as $i=>$value) {
            $serviceary[$value] = $servicearyname[$value];
        }        
        
        // 查目前系統已設定之服務項目
        $servicedata = CHtml::listData(TbsService::model()->findAll(array('order'=>'serviceno ASC','condition'=>'opt1=1')),'serviceno','cname');        
        foreach ($servicedata as $i=>$data) {
            $serviceary[$i] = $data;
        }     
        
        // 篩選條件初始的預設值
        $default_serviceno = array();
        
        if(count($qry_serviceno)==0) {
            $tbpParam = TbpParam::model()->findByAttributes(array('param'=>'performRpt08'));
            if($tbpParam != NULL) $default_serviceno = explode(",", $tbpParam->pvalue);
            else $default_serviceno = $qry_serviceno;
        }else {
            $default_serviceno = $qry_serviceno;
        }

        // 若有指定報表, 則以報表設定作為勾選值
        if ($rptname != '') {

            $tbpParamRpt08 = TbpPerformParamRpt08::model()->findByAttributes(array('rptname'=>$rptname));
            
            if($tbpParamRpt08 != NULL){
                
                //切割字串轉成陣列
                $qry_serviceno = explode(",", $tbpParamRpt08->check);
                //順序陣列
                $serviceno_seq = explode(",", $tbpParamRpt08->sequence);
                
            }else
                $qry_serviceno = $default_serviceno;
        }
       else{
           //  篩選條件初始的預設值
           $qry_serviceno = $default_serviceno;
       }
       
       unset($default_serviceno);
       
        // 畫面呈現的表格欄位, col是欄位名稱, title是欄位顯示的中文字
        $col = array();
        $title = array();
         
        //　取得選取的服務項目產生欄位
        $serviceno = TbsService::model()->findAllByAttributes(
                array(),
                // 將陣列切割成字串, 丟到SQL裡        
                $condition = "serviceno IN ('".implode("','", $qry_serviceno)."') AND opt1 = '1' ORDER BY serviceno "
        );         
         
        // 若有報表. 而且有指定順序
        if($rptname !='' && count($serviceno_seq) != 0 ){
            // 將指定的順序放進去, 再重新排序
            $col = array_combine($serviceno_seq, $qry_serviceno);
            ksort($col);           
        }else
            $col = $qry_serviceno;        
        
        unset($serviceno_seq);

        // 取得預設報表抬頭
        $title = $this->getRpt08Title($col);

        // 設定報表抬頭
        foreach ($serviceno as $row) {
            $title[$row->serviceno] = $row->cname;
        }

        // 輸出在畫面上的陣列
        $colAry = array();
        //店編對應區域名稱的陣列
        $stores = array();
        //儲存篩選出來的門市
        $tbsStroes = array();
        //儲存塞選出的門市的店編
        $sqlStroe = array();
        //合計陣列
        $sum = array();
        foreach ($title as $key => $value) {
            $sum[$key] = 0;
        }
        
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

        // 員編查詢SQL
        $qryStrno = '';
        $check_emp = TRUE;
        
        //如果有打員編
        if($qry_empno != '' ) {

            $emp = TbsEmp::model()->findByAttributes(array('empno'=>$qry_empno));
            
            if($emp == NULL) {
                
                $check_emp = FALSE;
                Yii::app()->user->setFlash('error', '查無此人，請重新輸入！');
            }else{
                $qryStrno = " AND empno = '$qry_empno' ";  
                $qry_empname = $emp->empname;
            }
        }
        
        //如果有打姓名
        elseif($qry_empname != '' ){

            //先去tbsemp找出員編
            $emp = TbsEmp::model()->findByAttributes(array('empname'=>$qry_empname));

            if($emp == NULL){
                $check_emp = FALSE;
                Yii::app()->user->setFlash('error', '查無此人，請重新輸入！');
            }else
            {
                $qryStrno = "AND empno = '$emp->empno'";
                $qry_empno = $emp->empno;
            }
        }
        
         //按下查詢
        if(isset($_POST['qry']) && $check_emp){
          
            $sql = "SELECT * FROM ( "
                    . "( SELECT pdate, storecode, storename, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                    . "WHERE pdate BETWEEN '$qry_dateS' AND '$qry_dateE' $qryStr $qryStrno "
                    . "GROUP BY pdate, storecode, storename, serviceno ORDER BY pdate, storecode ) ";
            if($qry_empno=='' && $qry_empname=='')
                    $sql = $sql. "UNION ALL "
                    . "( SELECT pdate, storecode, storename, serviceno, sum(num) as num FROM tbp_perform_log "
                    . "WHERE pdate BETWEEN '$qry_dateS' AND '$qry_dateE' $qryStr "
                    . "GROUP BY pdate, storecode, storename, serviceno ORDER BY pdate, storecode ) ";
      
            $sql = $sql. " ) a order by pdate, storecode, serviceno";//一定要照pdate排序,因為loop要照日期去跑
            $emplog = Yii::app()->db->createCommand($sql)->queryAll();
                   
            if($emplog !=NULL && count($emplog)>0) {
                $colAry = $this->getDailyData($emplog,$stores,$qry_empname,$qry_dateS,$qry_dateE,$sum);
                Yii::app()->user->setFlash('success', '以日期區間' . $qry_dateS . ' ~ ' . $qry_dateE . ' 查詢成功！合計'. (count($colAry)-1) .'筆資料');
            }
            else
                Yii::app()->user->setFlash('error', '以日期區間' . $qry_dateS . ' ~ ' . $qry_dateE . ' 查無資料');
            
            unset($emplog);
            
        //按下合併查詢,則顯示日期區間各門市業績的總和            
        }elseif(isset($_POST['qry2']) && $check_emp){
 
            $sql = "SELECT * FROM ( "
                    . "( SELECT storecode, storename, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                    . "WHERE pdate BETWEEN '$qry_dateS' AND '$qry_dateE' $qryStr $qryStrno "
                    . "GROUP BY storecode, storename, serviceno ORDER BY storecode ) ";
            if($qry_empno=='' && $qry_empname=='')
                    $sql = $sql. "UNION ALL "
                    . "( SELECT storecode, storename, serviceno, sum(num) as num FROM tbp_perform_log "
                    . "WHERE pdate BETWEEN '$qry_dateS' AND '$qry_dateE' $qryStr "
                    . "GROUP BY storecode, storename, serviceno ORDER BY storecode ) ";
      
            $sql = $sql. " ) a order by storecode, serviceno";
            $emplog = Yii::app()->db->createCommand($sql)->queryAll();
            
            if($emplog !=NULL && count($emplog)>0){
                $colAry = $this->getSumData($emplog,$stores,$qry_empname,$qry_dateS,$qry_dateE,$sum);

            Yii::app()->user->setFlash('success', '以日期區間' . $qry_dateS . ' ~ ' . $qry_dateE . ' 查詢成功！合計'. (count($colAry)-1) .'筆資料');
            }else{
                Yii::app()->user->setFlash('error', '以日期區間' . $qry_dateS . ' ~ ' . $qry_dateE . ' 查無資料');
            }
            
            unset($emplog);
        }else
            Yii::app()->user->setFlash('notice', '日期區間裡，起始日期不可大於結束日期！');
        
        // 將輸出陣列做瘦身
//        $resultAry = array();
//        for ($i = 0; $i < count($colAry); $i++) {
//            $result = array();
//            for ($j = 0; $j < count($col); $j++) {
//                $result[$col[$j]] = $colAry[$i][$col[$j]];
//            }
//            array_push($resultAry, $result);
//        }
//        CVarDumper::dump($resultAry,10,true);
        // 用以計算開始/結束時間之變數         
        $time_end = microtime(true);
        $computetime = $time_end - $time_start;        
        
        try {
                $this->render('rpt08',array(
                'qry_dateS'=>$qry_dateS,
                'qry_dateE'=>$qry_dateE,
                'qry_area'=>$qry_area,
                'qry_store'=>$qry_store,
                'qry_empno'=>$qry_empno,
                'qry_empname'=>$qry_empname,
                'qry_serviceno'=>$qry_serviceno,
                'serviceary'=>$serviceary,
                'rpttype'=>$rpttype,
                'rptname'=>$rptname,  
                'col'=>$col,
                'title'=>$title,
                'colAry'=>$colAry,
                'computetime'=>$computetime
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
            
    }

      /**
       * 
       */
      private function getRpt08Col(){
        
          if(isset($_POST['qry2'])){
              $col = TbpPerformParamRpt08::model()->getRptCol();
              unset($col[0]);
            }  else {
                $col = TbpPerformParamRpt08::model()->getRptCol();
            }
            return $col;
      }
      /**
       * 
       * @param type $col
       * @return string
       */
      private function getRpt08Title($col){
          
          $title = TbpPerformParamRpt08::model()->getRptTitle();
        
        return $title;    
      }

      /**
       * 
       * @param type $emplog - 員工資料
       * @param type $stores - 門市陣列
       * @param type $empname - 員工姓名
       * @param type $qry_dateS - 起
       * @param type $qry_dateE - 訖
       * @return type
       */
      private function getDailyData($emplog,$stores,$empname,$qry_dateS,$qry_dateE) {
          
          $colAry = array();
          //每一行的陣列
          $row = array();
          //合計陣列
          $sum = TbpPerformParamRpt08::model()->getRptTitle();
          if(isset($sum))
              foreach ($sum as $key => $value) {
                  $sum[$key] = 0;
              }
          
          //全域變數
          $pdate = '';
          $store = '';

          //如果撈出的結果>0,就先把第一筆資料先放進去
          if(count($emplog>0)){
              //讓全域變數等於第一筆資料(起始日)的日期
            $pdate = $emplog[0]['pdate'];
            $store = $emplog[0]['storecode'];
            $row['pdate'] = $emplog[0]['pdate'];
            //店名也是第一筆資料的店名
            $row['storecode'] = $emplog[0]['storecode'];
            $row['storename'] = $emplog[0]['storename'];
            $row['empname'] = $empname; 

            $row['remit'] = 0;
          }
      
          //開始對每一筆資料跑loop
          for ($i = 0; $i < count($emplog); $i++){
            //如果日期=起始日,店編=第一筆資料的店編,就把num填入服務項目的欄位
                if($emplog[$i]['pdate'] == $pdate && $emplog[$i]['storecode'] == $store){
                    
                    $row['area'] = $stores[$emplog[$i]['storecode']];
                    $row[$emplog[$i]['serviceno']] =  $emplog[$i]['num'];
                    $row['empname'] = $empname;
                 
                }
                //同一天不同分店
                elseif ($emplog[$i]['pdate'] == $pdate && $emplog[$i]['storecode'] != $store) {
                    array_push($colAry,$row);
                    $row = array();
                    $pdate = $emplog[$i]['pdate'];
                    $store = $emplog[$i]['storecode'];

                    $row['pdate']=$emplog[$i]['pdate'];
                    $row['area'] = $stores[$emplog[$i]['storecode']];
                    $row['storecode']=$emplog[$i]['storecode'];
                    $row['storename']=$emplog[$i]['storename'];
                    $row[$emplog[$i]['serviceno']] =  $emplog[$i]['num'];

                }
                else {
                    //跑完一天之後push進畫面
                    array_push($colAry,$row);
                    //把row清空,再把全域變數換成下一天的日期,店名
                    $row = array();
                    $pdate = $emplog[$i]['pdate'];
                    $store = $emplog[$i]['storecode'];
                    $row['pdate'] = $emplog[$i]['pdate'];
                    $row['area'] = $stores[$emplog[$i]['storecode']];
                    $row['storecode']=$emplog[$i]['storecode'];
                    $row['storename'] = $emplog[$i]['storename'];
                    $row[$emplog[$i]['serviceno']] =  $emplog[$i]['num'];    

                    }
                    //合計
                    if(!isset($sum[$emplog[$i]['serviceno']]))
                        $sum[$emplog[$i]['serviceno']] = 0;
            }
              
            //最後一天push進畫面
            array_push($colAry,$row);              
             
            $peform_service = TbsService::model()->findAllByAttributes(array('type1'=>'1'));
            $assist_service = TbsService::model()->findAllByAttributes(array('type1'=>'2'));
            // 利用 col 把每一個ARRAY的值丟進入
            //'A01'->'10','B01'->0...
            for ($j = 0; $j < count($colAry); $j++) {
                
                $colAry[$j] = $this->setRpt08RowData($colAry[$j], $colAry[$j], $peform_service, $assist_service);
                //合計
                foreach ($sum as $key => $value) {
                    if(isset($colAry[$j][$key]))
                        $sum[$key] = $sum[$key] + $colAry[$j][$key];
                }

                
            }
         
         // 門市資料
         $tbpPerforms = TbpPerform::model()->findAllByAttributes(
                 array(),
                 $condition = "pdate between '$qry_dateS' and '$qry_dateE' "
                );
         
         $totalAry = array();
         $outputAry = array();
         $remitAry = array();
         $realRemitAry = array();
         $realTypeAry = array();
         $realMemoAry = array();
         
         foreach ($tbpPerforms as $perform) {
             
             $key = $perform->pdate.$perform->storecode;
             
             $totalAry[$key] = $perform->total;
             $outputAry[$key] = $perform->output;
             $remitAry[$key] = $perform->remit;
             $realRemitAry[$key] = $perform->realremit;
             $realTypeAry[$key] = $perform->realtype;
             $realMemoAry[$key] = $perform->realmemo;
         }

        //放匯款金額進$colAry
        for ($j = 0; $j < count($colAry); $j++) {
            
            $key = $colAry[$j]['pdate'].$colAry[$j]['storecode'];
            // 取得
            $total = $totalAry[$key];
            $output = $outputAry[$key];
            $remit = $remitAry[$key];
            $realremit = $realRemitAry[$key];
            $realtype = $realTypeAry[$key];
            $realmemo = $realMemoAry[$key];
            
            // 填入
            $colAry[$j]['total'] = $total;
            $colAry[$j]['output'] = $output;
            $colAry[$j]['remit'] = $remit;
            $colAry[$j]['realremit'] = $realremit;
            $colAry[$j]['realtype'] = $realtype;
            $colAry[$j]['realmemo'] = $realmemo;
            
            // 合計
            if(isset($sum['total'])) { $sum['total'] = $sum['total'] + $total; } else { $sum['total'] = $total; }
            if(isset($sum['output'])) { $sum['output'] = $sum['output'] + $output; } else { $sum['output'] = $output; }
            if(isset($sum['remit'])) { $sum['remit'] = $sum['remit'] + $remit; } else { $sum['remit'] = $remit; }
            if(isset($sum['realremit'])) { $sum['realremit'] = $sum['realremit'] + $realremit; } else { $sum['realremit'] = $realremit; }
        }

        array_push($colAry,$sum);
        
         return $colAry;
      }
      
      /**
       * 
       * @param type $emplog
       * @return array
       */
      private function getSumData($emplog,$stores,$empname,$qry_dateS,$qry_dateE) {
          //畫面上的陣列
          $colAry = array();
          //年月
          $pdate = substr($qry_dateS, 0, 6);
          
          //每一行的陣列
          $row = array();
          
          //合計陣列
          $sum = TbpPerformParamRpt08::model()->getRptTitle();
          if(isset($sum))
              foreach ($sum as $key => $value) {
                  $sum[$key] = 0;
              }
          
          //全域變數
          $store = '';
          
          //如果撈出的結果>0,就先把第一筆資料先放進去
          if(count($emplog>0)){
                //讓全域變數等於第一筆資料的門市
                $store = $emplog[0]['storecode'];
                $row['storename'] = $emplog[0]['storename'];
                $row['storecode'] = $emplog[0]['storecode'];
                $row['empname'] = $empname; 
                $row['pdate'] = $pdate;
          }
          
          //開始對每一筆資料跑loop
          for ($i = 0; $i < count($emplog); $i++) {
                //如果門市=第一筆資料的門市,就把num填入服務項目的欄位
                if($emplog[$i]['storecode'] == $store){
                  $row['area'] = $stores[$emplog[$i]['storecode']];
                  $row[$emplog[$i]['serviceno']] =  $emplog[$i]['num'];
                  $row['empname'] = $empname; 
                } else {
                    //跑完一天之後push進畫面
                    array_push($colAry, $row);
                    //把row清空,再把全域變數換成下一間門市
                    $row = array();
                    $store = $emplog[$i]['storecode'];
                    $row['area'] = $stores[$emplog[$i]['storecode']];
                    $row['storecode'] = $emplog[$i]['storecode'];
                    $row['storename'] = $emplog[$i]['storename'];
                    $row['pdate'] = $pdate;
                    $row[$emplog[$i]['serviceno']] =  $emplog[$i]['num'];    
                }
              
                //合計
                if(!isset($sum[$emplog[$i]['serviceno']]))
                    $sum[$emplog[$i]['serviceno']] = 0;
           }
            //最後一天push進畫面
            array_push($colAry,$row);
            
            $peform_service = TbsService::model()->findAllByAttributes(array('type1'=>'1'));
            $assist_service = TbsService::model()->findAllByAttributes(array('type1'=>'2'));
            
            // 利用 col 把每一個ARRAY的值丟進入
            //'A01'->'10','B01'->0...
            for ($j = 0; $j < count($colAry); $j++) {
                $colAry[$j] = $this->setRpt08RowData($colAry[$j], $colAry[$j],$peform_service,$assist_service)  ;
                //合計
                foreach ($sum as $key => $value) {
                    if(isset($colAry[$j][$key]))
                        $sum[$key] = $sum[$key] + $colAry[$j][$key];
                }
            }

            $tbpPerforms = TbpPerform::model()->findAllByAttributes(
               array(),
               $condition = "pdate between '$qry_dateS' and '$qry_dateE' "
            );
        
            // 建立storecode->remit的array
            $totalAry = array();
            $outputAry = array();
            $remitAry = array();
            $realRemitAry = array();
//            $realTypeAry = array();
            $realMemoAry = array();
            $sumTotal = array();
            $sumOutput = array();
            $sumRemit = array();
            $sumRealRemit = array();
//            $sumRealType = array();
            $sumRealMemo = array();

            foreach ($tbpPerforms as $perform) {
                
                if(isset($sumTotal[$perform->storecode]))  
                    $sumTotal[$perform->storecode] = $sumTotal[$perform->storecode] + $perform->total;
                else
                   $sumTotal[$perform->storecode] = $perform->total;

                if(isset($sumOutput[$perform->storecode]))  
                    $sumOutput[$perform->storecode] = $sumOutput[$perform->storecode] + $perform->output;
                else
                   $sumOutput[$perform->storecode] = $perform->output;
                
                if(isset($sumRemit[$perform->storecode]))  
                    $sumRemit[$perform->storecode] = $sumRemit[$perform->storecode] + $perform->remit;
                else
                   $sumRemit[$perform->storecode] = $perform->remit;
                
                if(isset($sumRealRemit[$perform->storecode]))  
                    $sumRealRemit[$perform->storecode] = $sumRealRemit[$perform->storecode] + $perform->realremit;
                else
                   $sumRealRemit[$perform->storecode] = $perform->realremit;
                
                // 備註
                if(isset($sumRealMemo[$perform->storecode]))  {
                    
                    $str = $sumRealMemo[$perform->storecode];
                    if($str != '' && $perform->realmemo != '')
                        $str = $str.', '.'['.$perform->pdate.']'.$perform->realmemo;
                    elseif($str == '' && $perform->realmemo != '')
                        $str =  '['.$perform->pdate.']'.$perform->realmemo;
                    
                    $sumRealMemo[$perform->storecode] = $str;
                }
                else{
                    if($perform->realmemo=='')
                        $sumRealMemo[$perform->storecode] = $perform->realmemo;
                    else
                        $sumRealMemo[$perform->storecode] = '['.$perform->pdate.']'.$perform->realmemo;
                }
                
                $totalAry[$pdate.$perform->storecode] = $sumTotal[$perform->storecode];
                $outputAry[$pdate.$perform->storecode] = $sumOutput[$perform->storecode];
                $remitAry[$pdate.$perform->storecode] = $sumRemit[$perform->storecode];
                $realRemitAry[$pdate.$perform->storecode] = $sumRealRemit[$perform->storecode];
                $realMemoAry[$pdate.$perform->storecode] = $sumRealMemo[$perform->storecode];
              
            }
         
            // 放匯款金額進 $colAry
            for ($j = 0; $j < count($colAry); $j++) {

                $key = $colAry[$j]['pdate'].$colAry[$j]['storecode'];
                // 取得
                $total = $totalAry[$key];
                $output = $outputAry[$key];
                $remit = $remitAry[$key];
                $realremit = $realRemitAry[$key];
//                $realtype = $realTypeAry[$key];
                $realmemo = $realMemoAry[$key];

                // 填入
                $colAry[$j]['total'] = $total;
                $colAry[$j]['output'] = $output;
                $colAry[$j]['remit'] = $remit;
                $colAry[$j]['realremit'] = $realremit;
//                $colAry[$j]['realtype'] = $realtype;
                $colAry[$j]['realmemo'] = $realmemo;

                // 合計
                if(isset($sum['total'])) { $sum['total'] = $sum['total'] + $total; } else { $sum['total'] = $total; }
                if(isset($sum['output'])) { $sum['output'] = $sum['output'] + $output; } else { $sum['output'] = $output; }
                if(isset($sum['remit'])) { $sum['remit'] = $sum['remit'] + $remit; } else { $sum['remit'] = $remit; }
                if(isset($sum['realremit'])) { $sum['realremit'] = $sum['realremit'] + $realremit; } else { $sum['realremit'] = $realremit; }
                if(isset($sum['realmemo'])) { 
                    
                    $str = $sum['realmemo'];
                    if($str != '' && $realmemo != '')
                        $str = $str.', '.$realmemo;
                    elseif($str == '' && $realmemo != '')
                        $str = $realmemo;
                    
                    $sum['realmemo'] = $str;
                } else
                    $sum['realmemo'] = $realmemo;                     
        }

        array_push($colAry,$sum);
                
        return $colAry;
     }
     
     /**
      * 
      */
     public function actionDynamicstores( )
    {
        // 依傳入之areaid來查詢對應門市, 並且要已啟用
        $stores = TbsStore::model()->findAllByAttributes(
                        
                    array(),
                    $condition  = "area_id = :id and opt1 = '1' order by storecode ",
                    $params     = array(
                        ':id'=>(int) $_POST['qry_area'],
                    )
                );

        // 取出店編號對應店名
        $data = CHtml::listData($stores,'storecode', 'storename');
        // 回傳至畫面
        //連動結果第一筆為空
        echo CHtml::tag('option',
                       array('value'=>''),'',true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                       array('value'=>$value),CHtml::encode($name),true);
        }
    }                     

    /**
     * 報表用加總
     * @param type $row
     * @param type $asum
     * @return type
     */
    private function setRpt08RowData($row, $asum,$perform,$assist){
        
            // 剪髮(含少收) = A01 + S01 + S05 + X01 + X07 + X10
            $row['col1'] = 0;
            if(isset($asum['A01'])) $row['col1'] = $asum['A01'];
            if(isset($asum['S01'])) $row['col1'] = $row['col1'] + $asum['S01'];
            if(isset($asum['S05'])) $row['col1'] = $row['col1'] + $asum['S05'];
            if(isset($asum['X01'])) $row['col1'] = $row['col1'] + $asum['X01'];
            if(isset($asum['X07'])) $row['col1'] = $row['col1'] + $asum['X07'];
            if(isset($asum['X10'])) $row['col1'] = $row['col1'] + $asum['X10'];
            
            // 染髮(含少收) = B01 + C01 + X03 + X04
            $row['col2'] = 0;
            if(isset($asum['B01'])) $row['col2'] = $asum['B01'];
            if(isset($asum['C01'])) $row['col2'] = $row['col2'] + $asum['C01'];
            if(isset($asum['X03'])) $row['col2'] = $row['col2'] + $asum['X03'];
            if(isset($asum['X04'])) $row['col2'] = $row['col2'] + $asum['X04'];

            // 助染 = B02 + C02
            $row['col3'] = 0;
            if(isset($asum['B02'])) $row['col3'] = $asum['B02'];
            if(isset($asum['C02'])) $row['col3'] = $row['col3'] + $asum['C02'];

            // 洗髮(含少收) = D01 + S02 + S06 + X02 + X08 + X11
            $row['col4'] = 0;
            if(isset($asum['D01'])) $row['col4'] = $asum['D01'];
            if(isset($asum['S02'])) $row['col4'] = $row['col4'] + $asum['S02'];
            if(isset($asum['S06'])) $row['col4'] = $row['col4'] + $asum['S06'];            
            if(isset($asum['X02'])) $row['col4'] = $row['col4'] + $asum['X02'];            
            if(isset($asum['X08'])) $row['col4'] = $row['col4'] + $asum['X08'];            
            if(isset($asum['X11'])) $row['col4'] = $row['col4'] + $asum['X11'];            

            // 優染(含少收) = S03 + X09
            $row['col5'] = 0;
            if(isset($asum['S03'])) $row['col5'] = $asum['S03'];
            if(isset($asum['X09'])) $row['col5'] = $row['col5'] + $asum['X09'];
            
            // 優助染 = S04
            $row['col6'] = 0;
            if(isset($asum['S04'])) $row['col6'] = $asum['S04'];
            
            // 舒活SPA(含少收) = E01 + X05
            $row['col7'] = 0;
            if(isset($asum['E01'])) $row['col7'] = $asum['E01'];
            if(isset($asum['X05'])) $row['col7'] = $row['col7'] + $asum['X05'];
            
            // 養護SPA(含少收) = E02
            $row['col8'] = 0;
            if(isset($asum['E02'])) $row['col8'] = $asum['E02'];
            if(isset($asum['X06'])) $row['col8'] = $row['col8'] + $asum['X06'];
            
            // 洗髮精(含少收) = N041 + N042 + N043 + X12 + X13 + X14
            $row['col9'] = 0;
            if(isset($asum['N041'])) $row['col9'] = $asum['N041'];
            if(isset($asum['N042'])) $row['col9'] = $row['col9'] + $asum['N042'];
            if(isset($asum['N043'])) $row['col9'] = $row['col9'] + $asum['N043'];
            if(isset($asum['X12']))  $row['col9'] = $row['col9'] + $asum['X12'];
            if(isset($asum['X13']))  $row['col9'] = $row['col9'] + $asum['X13'];
            if(isset($asum['X14']))  $row['col9'] = $row['col9'] + $asum['X14'];
            
            // 剪髮(促)(含少收) = S05 + X10
            $row['col10'] = 0;
            if(isset($asum['S05'])) $row['col10'] = $asum['S05'];
            if(isset($asum['X10'])) $row['col10'] = $row['col10'] + $asum['X10'];            
            
            // 洗髮(促)(含少收) = S02 + S06 + X08 + X11
            $row['col11'] = 0;
            if(isset($asum['S02'])) $row['col11'] = $asum['S02'];
            if(isset($asum['S06'])) $row['col11'] = $row['col11'] + $asum['S06'];            
            if(isset($asum['X08'])) $row['col11'] = $row['col11'] + $asum['X08'];            
            if(isset($asum['X11'])) $row['col11'] = $row['col11'] + $asum['X11'];                    
            
            // 剪染燙
            $row['perform'] = $this->getPerform($asum,$perform);
            
            // 洗助
            $row['assist'] = $this->getAssist($asum,$assist);

            return $row;
    }    

    /**
     * 期中期末達成率
     */
    public function actionRpt09(){
        
        // 用以計算開始/結束時間之變數
        $time_start = microtime(true);        
        
        //得到達成率的年月
        $qry_date = date('Ym');
        $qry_area = ""; //區域
        $qry_store = ""; // 門市
        $qry_empno = ""; //員編
        $qry_empname = ""; //姓名

        // 如果目前是月中. 則預設不勾選
        $check1 = 0;//顯示期中
        $check2 = 0;//顯示期末
        // 是否顯示助理
        $checkAssist = 0;
        
        if(isset($_POST['qry_date']))         $qry_date = $_POST['qry_date'];
        if(isset($_POST['qry_area']))         $qry_area = $_POST['qry_area'];    
        if(isset($_POST['qry_store']))        $qry_store = $_POST['qry_store']; 
        if(isset($_POST['qry_empno']))      $qry_empno = $_POST['qry_empno'];
        if(isset($_POST['qry_empname']))  $qry_empname = $_POST['qry_empname'];
        if(isset($_POST['check1']))           $check1 = $_POST['check1'];
        if(isset($_POST['check2']))           $check2 = $_POST['check2'];  
        if(isset($_POST['checkAssist']))     $checkAssist = $_POST['checkAssist'];  
 
        //切割出年份
        $tmp_year=substr($qry_date,0,4);
        //切割出月份
        $tmp_mon =substr($qry_date,4,2);

        $dateS = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));
        $dateE = date("Ymd", mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year));        
        
        // 取得欄位及表頭
        $col = $this->getRpt09Col($check1,$check2);
        $title = $this->getRpt09Title($col);
        
        // 輸出在畫面上的陣列
        $colAry = array();

        
        // 門市. 門市ID
        $storeAry = array();
        $storeAreaId = array();
        $TbsStores = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsStores as $store) {
            $storeAry[$store->storecode] = $store->storename;
            $storeAreaId[$store->storecode] = $store->area_id;
        }
        unset($TbsStores);
        
        // 區域
        $areaAry = array();
        $TbsAreas = TbsArea::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsAreas as $area) {
            $areaAry[$area->id] = $area->areaname;
        }
        unset($TbsAreas);
        
        // 職位
        $positionAry = array();
        $TbsPositions = TbsPosition::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsPositions as $pos) {
            $positionAry[$pos->id] = $pos->pcname;
        }
        unset($TbsPositions);
        
        // 薪資, 責任額
        $salaryAry = array(); 
        $dutyAry = array();
        $TbsBaseSalary = TbsBasesalary::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsBaseSalary as $salary) {
            $salaryAry[$salary->id] = $salary->salary;
            $dutyAry[$salary->id] = $salary->duty;
        }
        unset($TbsBaseSalary);
        
        //員工SQL
        $qryStrno = '';
        $check_emp = TRUE;
        $check_area = TRUE;
        $check_store = TRUE;
        $check_all = TRUE;
        $check_query = TRUE;
        
        //如果有打員編
        if($qry_empno != '' ) {

            $tbsemp = TbsEmp::model()->findByAttributes(array('empno'=>$qry_empno));
            
            if($tbsemp == NULL) {
                
                $check_emp = FALSE;
                Yii::app()->user->setFlash('error', '查無此人，請重新輸入！');
            }else{ 
                
                $qryStrno = "AND empno = '$tbsemp->empno'";
                $qry_empname = $tbsemp->empname;
            }
            unset($tbsemp);
        }
        
        //如果有打姓名
        elseif($qry_empname != '' ){

            //先去tbsemp找出員編
            $tbsemp = TbsEmp::model()->findByAttributes(array('empname'=>$qry_empname));
            
            if($tbsemp == NULL){
                $check_emp = FALSE;
                Yii::app()->user->setFlash('error', '查無此人，請重新輸入！');
            }else{
                $qryStrno = "AND empno = '$tbsemp->empno'";
                $qry_empno = $tbsemp->empno;
            }
            unset($tbsemp);
        }        
        else // 若是沒有輸入員工, 則以門市, 區域去查出員編
        {
            //儲存篩選出來的門市
            $tbsStroes = array();
            //儲存篩選出的門市的店編
            $sqlStroe = array();

            //如果有選門市,就只選出那一家門市
            if($qry_store != '') {
                $tbsStroes = TbsStore::model()->findAllByAttributes(array('storecode'=>$qry_store));
                if(count($tbsStroes)<1) $check_store = FALSE;
            }
            //如果只選區域,就選出區域內的所有門市
            elseif($qry_area != '') {
                $tbsStroes = TbsStore::model()->findAllByAttributes(array('area_id'=>$qry_area));
                if(count($tbsStroes)<1) $check_area = FALSE;
            }
            //如果都沒有選,就全部選出來
            else {
                $tbsStroes = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
                if(count($tbsStroes)<1) $check_all = FALSE;
            }

            foreach ($tbsStroes as $store) {
                //找出篩選出的門市的區域代碼
                $area = TbsArea::model()->findByPK($store->area_id);
                if($area!=NULL){
                    //push店編
                    array_push($sqlStroe, $store->storecode);
                }
            }

            // 查詢用的SQL
            $qryStr = '';

            //如果有選門市或區域就需要sql=AND storecode in('007001',007002')  
            if($qry_store != '' OR $qry_area != '') {
                //sql=sql.in('007001')因為只有一筆的時候沒有' , '  所以直接把店編放進去
                if(count($sqlStroe)>0) {
//                    $qryStr = " AND storecode in ('$sqlStroe[0]'";
                    $qryStr = "WHERE a.storecode in ('$sqlStroe[0]'";
                    //如果門市>1,就需要' , '
                    if(count($sqlStroe)>1)
                        for ($i = 1; $i < count($sqlStroe); $i++) {
                            $qryStr = $qryStr.",'$sqlStroe[$i]'";
                        }
                    $qryStr = $qryStr.")";
                }
            }
            
            // 查出符合查詢條件的員工編號清單
//            $empSql =  "SELECT empno, daymonth, storecode
//                                FROM (
//                                    SELECT * 
//                                       FROM tbs_emp_month
//                                    WHERE depart = '3' $qryStr
//                                     ORDER BY daymonth DESC
//                                ) AS a
//                                GROUP BY empno
//                                ORDER BY storecode";
            
            $empSql = "SELECT a.empno, a.daymonth, a.storecode
                            FROM (
                            tbs_emp_month a
                            INNER JOIN (
                            SELECT id, empno, MAX( daymonth ) AS daymonth, storecode
                            FROM tbs_emp_month
                            WHERE depart =  '3'
                            AND daymonth <=  '$qry_date'
                            GROUP BY empno
                            )b ON a.empno = b.empno
                            AND a.daymonth = b.daymonth
                            ) $qryStr ";
            
            $result = Yii::app()->db->createCommand($empSql)->queryAll();
            
            //sql=sql.in('007001')因為只有一筆的時候沒有' , '  所以直接把店編放進去
            if(count($result)>0) {
                $qryStrno = " AND empno in ('".$result[0]['empno']."'";
                //如果名單>1,就需要' , '
                if(count($result)>1)
                    for ($i = 1; $i < count($result); $i++) {
                        $qryStrno = $qryStrno.",'".$result[$i]['empno']."'";
                    }
                $qryStrno = $qryStrno.")";
            }else
            {
                if ($check_emp && $check_store && $check_area)
                    $check_query =FALSE;
                
                if($check_store) Yii::app()->user->setFlash('error', '查無門市所屬人員，請重新查詢！');
                if($check_area) Yii::app()->user->setFlash('error', '查無區域所屬門市及人員，請重新輸入！');
                    
            }
            unset($result);
        }
        
        // 如果是查詢員工. 要判斷這個區店長有沒有這個權限
//        if(isset($_POST['qry']) && $check_emp && $qry_empno != '') {
//            
//            $tbsemp = TbsEmpMonth::model()->findByDayMonth($qry_empno, $qry_date);
//            if($tbsemp->area != $qry_area) {
//                Yii::app()->user->setFlash('error', '您查詢的員工，這個月不屬於你的區喔，無法查詢！');
//                $check_query = FALSE;
//            }
//        }
        
        $empAry = array();
        $sql = '';
        
        if(isset($_POST['qry']) && $check_query){
            
            //查到15號的業績
            $midday = date("Ymd", mktime(0, 0, 0, $tmp_mon, 15, $tmp_year));  
            
            $sql =  "SELECT empno, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                    . "WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno "
                    . "GROUP BY empno, serviceno ORDER BY empno ";

            $sql2 = "SELECT empno, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                    . "WHERE pdate BETWEEN '$dateS' AND '$midday' $qryStrno "
                    . "GROUP BY empno, serviceno ORDER BY empno ";
                    
            $result1 = Yii::app()->db->createCommand($sql)->queryAll();            
            
            $empAry = $this->setEmpAry($result1);   
            
            $result2 = Yii::app()->db->createCommand($sql2)->queryAll();
            
            $empAry = $this->setMidEmpAry($empAry, $result2);
            
            // 查出洗髮+10元的剪髮顆數跟洗頭數
            $sql3 = "SELECT a.empno, sum(b.num) as cut, sum(a.num) as wash
                        FROM 
                        (
                        SELECT pdate, storecode, empno, num 
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno = 'D01' 
                        ) a
                        ,
                        (
                        SELECT pdate, storecode, empno, num 
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno = 'A01'
                        ) b 
                        WHERE a.pdate = b.pdate AND a.storecode = b.storecode AND a.empno = b.empno
                        GROUP BY a.empno";
            
            $result3 = Yii::app()->db->createCommand($sql3)->queryAll();            
            
            $empAry = $this->setWashEmpAry($empAry, $result3, 'col10', 'col12');
            
            // 查出洗髮不加10元的剪髮顆數跟洗頭數
            $sql4 = "SELECT a.empno, sum(b.num) as cut, sum(a.num) as wash
                        FROM 
                        (
                        SELECT pdate, storecode, empno, sum(num) as num
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno IN ('S02','S06')
                        GROUP BY pdate, storecode, empno
                        ) a
                        ,
                        (
                        SELECT pdate, storecode, empno, sum(num) as num
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno IN ('A01','S01','S05')
                        GROUP BY pdate, storecode, empno
                        ) b 
                        WHERE a.pdate = b.pdate AND a.storecode = b.storecode AND a.empno = b.empno
                        GROUP BY a.empno";
            
            $result4 = Yii::app()->db->createCommand($sql4)->queryAll();            
            
            $empAry = $this->setWashEmpAry($empAry, $result4, 'col11', 'col13');
        }
        
        foreach ($empAry as $empno => $empData) {
            
            // 查詢員工薪資福利
            $empMonth = new TbsEmpMonth;
            $empMonth = TbsEmpMonth::model()->findByDayMonth($empno, $qry_date);
            $user = User::model()->findByPk($empno);
            if($empMonth!=NULL) {
                
                $row = array();
                // 年月
                $row['ym'] = $qry_date;
                // 營業區
                $row['area'] = $areaAry[$empMonth->area];
                // 門市
                $row['store'] = $storeAry[$empMonth->storecode];
                // 職稱
                $row['position'] = $positionAry[$empMonth->position1];
                // 若不顯示助理. 則以下不用繼續進行
                if($empMonth->position1 == 17 && !($checkAssist)) continue;
                // 員編
                $row['empno'] = $empno;
                // 姓名
                $row['name'] = ($user->emp)?$user->emp->empname:''; 
                // 到職日
                $row['arrivedate'] = Yii::app()->dateFormatter->format("yyyy-MM-dd",$empMonth->arrivedate,"yyyy-MM-dd");
                // 狀態
                $row['status'] = TbsEmp::model()->getHireType($empMonth->hiretype);
                // 保底
                $row['salary'] = $salaryAry[$empMonth->salary];
                // 責任業績, 區店長需動態算, opt2欄位設成管理門市數
                // 103/7/1 區店長責任額修正
//                if($empMonth->position1 == 9){
//                    $areaduty = TbsAreaduty::model()->findByAttributes(array('storenum'=>$empMonth->opt2));
//                    if(isset($areaduty))
//                        $row['duty'] = $areaduty->duty;
//                }else
                    $row['duty'] = $dutyAry[$empMonth->salary];

                // 設定各欄位業績及洗助算法
                 $row = $this->setRpt09RowData($row,$empData);

                 // 達成率
                $rate = ($row['duty']==0)?0:round( ($row['perform']/$row['duty']),4 );
                $row['rate'] = $rate*100 . "%";

                //洗髮+10 
//                $row['col10'] = 0;
//                $row['col12'] = 0;
                $row['col10'] = isset($empData['col10'])?$empData['col10']:0;
                $row['col12'] = isset($empData['col12'])?$empData['col12']:0;
            
                //洗髮不加10 
//                $row['col11'] = 0;
//                $row['col13'] = 0;
                $row['col11'] = isset($empData['col11'])?$empData['col11']:0;
                $row['col13'] = isset($empData['col13'])?$empData['col13']:0;

                // 是否達成
                $row['achi'] = ($rate>=1)?'達成':'未達成';            
                if( ($row['perform'] + $row['assist']) > 0)

                // ================== 以下是期中 ==========================
                // 期中保底
                $row['midsalary'] = $row['salary'];
                
                // 期中責任業績
                $row['midduty'] = $row['duty'];

    //            CVarDumper::dump($midasum,10,TRUE);
                // 設定各欄位業績及洗助算法
                 $row = $this->setRpt09MidRowData($row,$empData);

                 // 達成率
                 if($row['midduty'] > 0) {
                     $rate = ($row['midduty']==0)?0:round( ($row['midperform']/$row['midduty']),4 );
                     $row['midrate'] = $rate*100 . "%";
                 }else
                     $row['midrate'] = "0%";

               // 是否達成
                $row['midachi'] = ($rate>=0.5)?'達成':'未達成';            
                if( ($row['midperform'] + $row['midassist']) > 0)

                //期末業績成長率
                if($row['midperform'] > 0) {
                    $ratecol14 = round( ( (($row['perform']-$row['midperform'])-$row['midperform'])/$row['midperform']),4);
//                print_r($ratecol14);
                    $row['col14'] = $ratecol14*100 . "%";
                }else
                    $row['col14'] = "0%";

                array_push($colAry, $row);
            }
            else{
                
                Yii::app()->user->setFlash('error', "查無員工 $empno ". (isset($user->emp)?$user->emp->empname:'') ." ,$qry_date 月的薪資福利資料");
                break;
            }
        }
        
        unset($empAry);
        
        // 用以計算開始/結束時間之變數         
        $time_end = microtime(true);
        $computetime = round(($time_end - $time_start),3);
        
//        Yii::app()->user->setFlash('notice', "最大記憶體 $MaxMem MB, 使用記憶體 $MEM MB！, 執行時間 $computetime 秒");
//        Yii::app()->user->setFlash('notice', "執行時間 $computetime 秒");
        
        if(isset($_POST['qry']) && $check_emp){
            if(count($colAry)<1)
                Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')."查無員工 $qry_empno ,$qry_date 月的業績資料");
            else
                Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success')."查詢成功. 共計 ".count($colAry)." 筆資料");
        }
                
        $this->render('rpt09',array(
            'qry_date'=>$qry_date,
            'qry_area'=>$qry_area,
            'qry_store'=>$qry_store,
            'qry_empno'=>$qry_empno,
            'qry_empname'=>$qry_empname,
            'check1'=>$check1,
            'check2'=>$check2,
            'checkAssist'=>$checkAssist,
            'col'=>$col,
            'title'=>$title,
            'colAry'=>$colAry,           
            'computetime'=>$computetime
        ));
    }
        
    // 設定整月項目
    private function setEmpAry($result) {
        
        $empAry = array();
        $emp = array();
        
        if(count($result)>0) {
            
            $empno = $result[0]['empno'];
    //        $emp[$result[0]['serviceno']] = $result[0]['num'];

            for ($i = 0; $i < count($result); $i++) {

                if($empno == $result[$i]['empno'])
                    $emp[$result[$i]['serviceno']] = $result[$i]['num'];
                else{
                    $empAry[$empno] = $emp;
                    $emp = array();
                    $empno = $result[$i]['empno'];
                    $emp[$result[$i]['serviceno']] = $result[$i]['num'];
                }
            }

            $empAry[$empno] = $emp;
        }        
        return $empAry;
    }
    
    // 設定期中項目
    private function setMidEmpAry($empAry, $result) {

        if(count($result)>0) {        
        
            $empno = $result[0]['empno'];
            $emp = array();
            if(isset($empAry[$empno]))
                $emp = $empAry[$empno];

    //        $emp['MID'.$result[0]['serviceno']] = $result[0]['num'];

            for ($i = 0; $i < count($result); $i++) {

                if($empno == $result[$i]['empno'])
                    $emp['MID'.$result[$i]['serviceno']] = $result[$i]['num'];
                else{
                    $empAry[$empno] = $emp;
                    $emp = array();
                    $empno = $result[$i]['empno'];
                    if(isset($empAry[$empno]))
                        $emp = $empAry[$empno];
                    $emp['MID'.$result[$i]['serviceno']] = $result[$i]['num'];
                }
            }

            $empAry[$empno] = $emp;        
        }
        return $empAry;
    }
    
    /**
     * 設定洗髮佔比
     * @param type $empAry
     * @param type $result
     * @param type $col
     * @param type $rate
     * @return type
     */
    private function setWashEmpAry($empAry, $result, $col, $rate) {
        
        for ($i = 0; $i < count($result); $i++) {
            
            $empno = $result[$i]['empno'];
            if(isset($empAry[$empno])){
                
                $emp = $empAry[$empno];
                $emp[$col] = $result[$i]['wash'];
                if($result[$i]['cut'] > 0)
                    $emp[$rate] = (ROUND($result[$i]['wash'] / $result[$i]['cut'],4)*100)."%";
                else
                    $emp[$rate] = "0%";
                $empAry[$empno] = $emp;
            }else
                continue;
        }
        return $empAry;
    }
    
    
   /**
    * 
    * @return string
    */
    private function getRpt09Col($check1,$check2){
        
        
        $col1 = array(0 => 'ym',
                            1 => 'area',
                            2 => 'store',
                            3 => 'position',
                            4 => 'empno',
                            5 => 'name',
                            6 => 'arrivedate',
                            7 => 'status',
                            8 => 'midsalary',
                            9 => 'midcol1', // 期中剪髮
                            10 => 'midcol2', // 期中染髮
                            11 => 'midcol3', // 期中助染
                            12 => 'midcol4', // 期中洗髮
                            13 => 'midcol5', // 期中優染
                            14 => 'midcol6', // 期中優助染
                            15 => 'midcol7', // 期中舒活SPA 
                            16 => 'midcol8', // 期中養護SPA
                            17 => 'midcol9', // 期中洗髮棈
                            18 => 'midcol15', // 期中髮油
                            19 => 'midperform',
                            20 => 'midassist',
                            21 => 'midduty',
                            22 => 'midrate',
                            23 => 'midachi'
                );        
        
        $col2 = array(0 => 'ym',
                            1 => 'area',
                            2 => 'store',
                            3 => 'position',
                            4 => 'empno',
                            5 => 'name',
                            6 => 'arrivedate',
                            7 => 'status',
                            8 => 'salary',
                            9 => 'col1', // 剪髮
                            10 => 'col2', // 染髮
                            11 => 'col3', // 助染
                            12 => 'col4', // 洗髮
                            13 => 'col5', // 優染
                            14 => 'col6', // 優助染
                            15 => 'col7', // 舒活SPA 
                            16 => 'col8', // 養護SPA
                            17 => 'col9', // 洗髮精
                            18 => 'col15', // 髮油
                            19 =>'col10',//洗髮+10
                            20 =>'col11',//洗髮(不加)
                            21 =>'col12',//洗髮+10比例
                            22 =>'col13',//洗髮(不加比例)
                            23 => 'perform',
                            24 => 'assist',
                            25 => 'duty',
                            26 => 'rate',
                            27 => 'achi',
                            28 => 'col14'//期末業績成長率
            );        
        $col = array();
        //勾選顯示期中
        if($check1)  $col = array_merge($col, $col1);
   
        // 勾選顯示期末
        if($check2)  $col = array_merge($col, $col2); 
        
        // 若都沒勾選, 
        if($check1 + $check2 == 0) $col = array_merge($col, $col1);
          
        return $col;
    }
    /**
     * 
     * @param type $col
     * @return string
     */
    private function getRpt09Title($col){
       
        $title = array('ym' => '年月',
                            'area' => '營業區',
                            'store' => '門市',
                            'position' => '職稱',
                            'empno' => '員編',
                            'name' => '姓名',
                            'arrivedate' => '到職日',
                            'status' => '狀態',
                            'salary' => '保底',
                            'col1' => '剪髮',
                            'col2' => '染髮',
                            'col3' => '助染',
                            'col4' => '洗髮',
                            'col5' => '優染',
                            'col6' => '優助染',
                            'col7' => '舒活<br>SPA',
                            'col8' => '養護<br>SPA',
                            'col9' => '洗髮精',
                            'col15' => '髮油',
                            'perform' => '剪.染.燙',
                            'assist' => '洗助',
                            'duty' => '責任業績',
                            'rate' => '達成率',
                            'achi' => '達成與否',
                            'midsalary'=> '期中保底',
                            'midcol1' => '期中剪髮',
                            'midcol2' => '期中染髮',
                            'midcol3' => '期中助染',
                            'midcol4' => '期中洗髮',
                            'midcol5' => '期中優染',
                            'midcol6' => '期中優助染',
                            'midcol7' => '期中舒活SPA',
                            'midcol8' => '期中養護SPA',
                            'midcol9' => '期中洗髮精',
                            'midcol15' => '期中髮油',
                            'midperform' => '期中剪.染.燙',
                            'midassist' => '期中洗助',
                            'midduty' => '期中責任業績',
                            'midrate' => '期中達成率',
                            'midachi' => '期中達成與否',
                            'col10' => '洗髮+10',
                            'col11' => '洗髮<br>(不加)',
                            'col12' => '洗髮<br>+10比例',
                            'col13' => '洗髮<br>(不加)比例',
                            'col14' => '期末業績成長率'
            );
        
        return $title;    
    }
    /**
     * 
     * @param type $row
     * @param type $asum
     * @return type
     */
    private function setRpt09RowData($row, $asum){
        
            // 剪髮 = A01 + S01 + S05
            $row['col1'] = 0;
            if(isset($asum['A01'])) $row['col1'] = $asum['A01'];
            if(isset($asum['S01'])) $row['col1'] = $row['col1'] + $asum['S01'];
            if(isset($asum['S05'])) $row['col1'] = $row['col1'] + $asum['S05'];
            
            // 染髮 = B01 + C01
            $row['col2'] = 0;
            if(isset($asum['B01'])) $row['col2'] = $asum['B01'];
            if(isset($asum['C01'])) $row['col2'] = $row['col2'] + $asum['C01'];

            // 助染 = B02 + C02
            $row['col3'] = 0;
            if(isset($asum['B02'])) $row['col3'] = $asum['B02'];
            if(isset($asum['C02'])) $row['col3'] = $row['col3'] + $asum['C02'];

            // 洗髮 = D01 + S02 + S06
            $row['col4'] = 0;
            if(isset($asum['D01'])) $row['col4'] = $asum['D01'];
            if(isset($asum['S02'])) $row['col4'] = $row['col4'] + $asum['S02'];
            if(isset($asum['S06'])) $row['col4'] = $row['col4'] + $asum['S06'];            

            // 優染 = S03
            $row['col5'] = 0;
            if(isset($asum['S03'])) $row['col5'] = $asum['S03'];
            
            // 優助染 = S04
            $row['col6'] = 0;
            if(isset($asum['S04'])) $row['col6'] = $asum['S04'];
            
            // 舒活SPA = E01
            $row['col7'] = 0;
            if(isset($asum['E01'])) $row['col7'] = $asum['E01'];
            
            // 養護SPA = E02
            $row['col8'] = 0;
            if(isset($asum['E02'])) $row['col8'] = $asum['E02'];
            
            // 洗髮精 = N041 + N042 + N043
            $row['col9'] = 0;
            if(isset($asum['N041'])) $row['col9'] = $asum['N041'];
            if(isset($asum['N042'])) $row['col9'] = $row['col9'] + $asum['N042'];
            if(isset($asum['N043'])) $row['col9'] = $row['col9'] + $asum['N043'];

            // 髮油
            $row['col15'] = 0;
            if(isset($asum['N051'])) $row['col15'] = $asum['N051'];
                        
            // 剪染燙
            $row['perform'] = $this->getPerform($asum);
            // 洗助
            $row['assist'] = $this->getAssist($asum);

            return $row;
    }
    /**
     * 取得期中業績
     * @param type $row
     * @param type $asum
     * @return type
     */
    private function setRpt09MidRowData($row, $asum){
        
            // 剪髮 = A01 + S01 + S05
            $row['midcol1'] = 0;
            if(isset($asum['MIDA01'])) $row['midcol1'] = $asum['MIDA01'];
            if(isset($asum['MIDS01'])) $row['midcol1'] = $row['midcol1'] + $asum['MIDS01'];
            if(isset($asum['MIDS05'])) $row['midcol1'] = $row['midcol1'] + $asum['MIDS05'];
            
            // 染髮 = B01 + C01
            $row['midcol2'] = 0;
            if(isset($asum['MIDB01'])) $row['midcol2'] = $asum['MIDB01'];
            if(isset($asum['MIDC01'])) $row['midcol2'] = $row['midcol2'] + $asum['MIDC01'];

            // 助染 = B02 + C02
            $row['midcol3'] = 0;
            if(isset($asum['MIDB02'])) $row['midcol3'] = $asum['MIDB02'];
            if(isset($asum['MIDC02'])) $row['midcol3'] = $row['midcol3'] + $asum['MIDC02'];

            // 洗髮 = D01 + S02 + S06
            $row['midcol4'] = 0;
            if(isset($asum['MIDD01'])) $row['midcol4'] = $asum['MIDD01'];
            if(isset($asum['MIDS02'])) $row['midcol4'] = $row['midcol4'] + $asum['MIDS02'];
            if(isset($asum['MIDS06'])) $row['midcol4'] = $row['midcol4'] + $asum['MIDS06'];            

            // 優染 = S03
            $row['midcol5'] = 0;
            if(isset($asum['MIDS03'])) $row['midcol5'] = $asum['MIDS03'];
            
            // 優助染 = S04
            $row['midcol6'] = 0;
            if(isset($asum['MIDS04'])) $row['midcol6'] = $asum['MIDS04'];
            
            // 舒活SPA = E01
            $row['midcol7'] = 0;
            if(isset($asum['MIDE01'])) $row['midcol7'] = $asum['MIDE01'];
            
            // 養護SPA = E02
            $row['midcol8'] = 0;
            if(isset($asum['MIDE02'])) $row['midcol8'] = $asum['MIDE02'];
            
            // 洗髮精 = N041 + N042 + N043
            $row['midcol9'] = 0;
            if(isset($asum['MIDN041'])) $row['midcol9'] = $asum['MIDN041'];
            if(isset($asum['MIDN042'])) $row['midcol9'] = $row['midcol9'] + $asum['MIDN042'];
            if(isset($asum['MIDN043'])) $row['midcol9'] = $row['midcol9'] + $asum['MIDN043'];

            // 髮油
            $row['midcol15'] = 0;
            if(isset($asum['MIDN051'])) $row['midcol15'] = $asum['MIDN051'];
            
            // 剪染燙
            $row['midperform'] = $this->getMidPerform($asum);
            // 洗助
            $row['midassist'] = $this->getMidAssist($asum);

            return $row;
    }    
    
    /**
     * 
     */
    public function actionDynamicrptname( )
    {
       // 依傳入之areaid來查詢對應門市, 並且要已啟用
        $type = TbpPerformParamRpt08Name::model()->findAllByAttributes(
                        
                    array(),
                    $condition  = "type_id = :id and opt1 = '1' order by id ",
                    $params     = array(
                        ':id'=>(int) $_POST['rpttype'],
                    )
                );

        // 取出店編號對應店名
        $data = CHtml::listData($type,'id', 'rptname');
        // 回傳至畫面
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                       array('value'=>$value),CHtml::encode($name),true);
        }
    }                     


    /**
     * 取得洗.染.燙業績
     * @param type $ary
     * @return int
     */
    private function getMidPerform($ary){
        
        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'1'));
        if(count($service)>0)
            foreach ($service as $row) {            
                $serviceno = 'MID'.$row->serviceno;
                if(isset($ary[$serviceno]))
                    $sum = $sum + $ary[$serviceno] * $row->perform;
            }
        return $sum;
    }
    
    /**
     * 取得洗助業績
     * @param type $ary
     * @return int
     */
    private function getMidAssist($ary){

        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'2'));
        if(count($service)>0)
            foreach ($service as $row) {
                $serviceno = 'MID'.$row->serviceno;
                if(isset($ary[$serviceno]))
                    $sum = $sum + $ary[$serviceno] * $row->draw;
            }        
        return $sum;
    }


    /*
     * Sample controller action
     * The javascript code will create a CSV file
     * in 'protected/csv'. That directory must be manually
     * created and the permissions should be set to allow php
     * to write to it.
     */
    public function actionExportCsv(){
        
        

    }

    /**
     * 北一區期中期末達成率
     */
    public function actionRpt81(){        
      
        $this->getAreaRpt09(1, 'rpt81');
    }

    /**
     * 北二區期中期末達成率
     */
    public function actionRpt82(){
      
        $this->getAreaRpt09(2, 'rpt82');
    }

    /**
     * 北三區期中期末達成率
     */
    public function actionRpt83(){
      
        $this->getAreaRpt09(3, 'rpt83');
    }

    /**
     * 桃竹苗期中期末達成率
     */
    public function actionRpt84(){
      
        $this->getAreaRpt09(4, 'rpt84');
    }

    /**
     * 中彰區期中期末達成率
     */
    public function actionRpt85(){
      
        $this->getAreaRpt09(5, 'rpt85');
    }

    /**
     * 嘉南區期中期末達成率
     */
    public function actionRpt86(){
      
        $this->getAreaRpt09(6, 'rpt86');
    }

    /**
     * 高屏一區期中期末達成率
     */
    public function actionRpt87(){

        $this->getAreaRpt09(7, 'rpt87');
    }

    /**
     * 高屏二區期中期末達成率
     */
    public function actionRpt88(){

        $this->getAreaRpt09(8, 'rpt88');
    }

    /**
     * 高屏三區期中期末達成率
     */
    public function actionRpt89(){
      
        $this->getAreaRpt09(9, 'rpt89');
    }

    /**
     *東區期中期末達成率
     */
    public function actionRpt90(){
      
        $this->getAreaRpt09(10, 'rpt90');
    }
    
    /**
     *東區期中期末達成率
     */
    private function getAreaRpt09($area,$rpt){

        // 用以計算開始/結束時間之變數
        $time_start = microtime(true);                
        
        //得到達成率的年月
        $qry_date = date('Ym');
        $qry_area = $area; //區域
        $qry_store = ""; // 門市
        $qry_empno = ""; //員編
        $qry_empname = ""; //姓名

        // 如果目前是月中. 則預設不勾選
        $check1 = 0;//顯示期中
        $check2 = 0;//顯示期末
        // 是否顯示助理
        $checkAssist = 0;
        
        if(isset($_POST['qry_date']))         $qry_date = $_POST['qry_date'];
//        if(isset($_POST['qry_area']))         $qry_area = $_POST['qry_area'];    
        if(isset($_POST['qry_store']))        $qry_store = $_POST['qry_store']; 
        if(isset($_POST['qry_empno']))      $qry_empno = $_POST['qry_empno'];
        if(isset($_POST['qry_empname']))  $qry_empname = $_POST['qry_empname'];
        if(isset($_POST['check1']))           $check1 = $_POST['check1'];
        if(isset($_POST['check2']))           $check2 = $_POST['check2'];  
        if(isset($_POST['checkAssist']))     $checkAssist = $_POST['checkAssist'];  
 
        //切割出年份
        $tmp_year=substr($qry_date,0,4);
        //切割出月份
        $tmp_mon =substr($qry_date,4,2);

        $dateS = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));
        $dateE = date("Ymd", mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year));        
        
        // 取得欄位及表頭
        $col = $this->getRpt09Col($check1,$check2);
        $title = $this->getRpt09Title($col);
        
        // 輸出在畫面上的陣列
        $colAry = array();

        
        // 門市. 門市ID
        $storeAry = array();
        $storeAreaId = array();
        $TbsStores = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsStores as $store) {
            $storeAry[$store->storecode] = $store->storename;
            $storeAreaId[$store->storecode] = $store->area_id;
        }
        unset($TbsStores);
        
        // 區域
        $areaAry = array();
        $TbsAreas = TbsArea::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsAreas as $area) {
            $areaAry[$area->id] = $area->areaname;
        }
        unset($TbsAreas);
        
        // 職位
        $positionAry = array();
        $TbsPositions = TbsPosition::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsPositions as $pos) {
            $positionAry[$pos->id] = $pos->pcname;
        }
        unset($TbsPositions);
        
        // 薪資, 責任額
        $salaryAry = array(); 
        $dutyAry = array();
        $TbsBaseSalary = TbsBasesalary::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsBaseSalary as $salary) {
            $salaryAry[$salary->id] = $salary->salary;
            $dutyAry[$salary->id] = $salary->duty;
        }
        unset($TbsBaseSalary);
        
        //員工SQL
        $qryStrno = '';
        $check_emp = TRUE;
        $check_area = TRUE;
        $check_store = TRUE;
        $check_all = TRUE;
        $check_query = TRUE;
        
        //如果有打員編
        if($qry_empno != '' ) {

            $tbsemp = TbsEmp::model()->findByAttributes(array('empno'=>$qry_empno));
            
            if($tbsemp == NULL) {
                
                $check_emp = FALSE;
                Yii::app()->user->setFlash('error', '查無此人，請重新輸入！');
            }else{ 
                
                $qryStrno = "AND empno = '$tbsemp->empno'";
                $qry_empname = $tbsemp->empname;
            }
            unset($tbsemp);
        }
        
        //如果有打姓名
        elseif($qry_empname != '' ){

            //先去tbsemp找出員編
            $tbsemp = TbsEmp::model()->findByAttributes(array('empname'=>$qry_empname));
            
            if($tbsemp == NULL){
                $check_emp = FALSE;
                Yii::app()->user->setFlash('error', '查無此人，請重新輸入！');
            }else{
                $qryStrno = "AND empno = '$tbsemp->empno'";
                $qry_empno = $tbsemp->empno;
            }
            unset($tbsemp);
        }        
        else // 若是沒有輸入員工, 則以門市, 區域去查出員編
        {
            //儲存篩選出來的門市
            $tbsStroes = array();
            //儲存篩選出的門市的店編
            $sqlStroe = array();

            //如果有選門市,就只選出那一家門市
            if($qry_store != '') {
                $tbsStroes = TbsStore::model()->findAllByAttributes(array('storecode'=>$qry_store));
                if(count($tbsStroes)<1) $check_store = FALSE;
            }
            //如果只選區域,就選出區域內的所有門市
            elseif($qry_area != '') {
                $tbsStroes = TbsStore::model()->findAllByAttributes(array('area_id'=>$qry_area));
                if(count($tbsStroes)<1) $check_area = FALSE;
            }
            //如果都沒有選,就全部選出來
            else {
                $tbsStroes = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
                if(count($tbsStroes)<1) $check_all = FALSE;
            }

            foreach ($tbsStroes as $store) {
                //找出篩選出的門市的區域代碼
                $area = TbsArea::model()->findByPK($store->area_id);
                if($area!=NULL){
                    //push店編
                    array_push($sqlStroe, $store->storecode);
                }
            }

            // 查詢用的SQL
            $qryStr = '';

            //如果有選門市或區域就需要sql=AND storecode in('007001',007002')  
            if($qry_store != '' OR $qry_area != '') {
                //sql=sql.in('007001')因為只有一筆的時候沒有' , '  所以直接把店編放進去
                if(count($sqlStroe)>0) {
//                    $qryStr = " AND storecode in ('$sqlStroe[0]'";
                    $qryStr = "WHERE a.storecode in ('$sqlStroe[0]'";
                    //如果門市>1,就需要' , '
                    if(count($sqlStroe)>1)
                        for ($i = 1; $i < count($sqlStroe); $i++) {
                            $qryStr = $qryStr.",'$sqlStroe[$i]'";
                        }
                    $qryStr = $qryStr.")";
                }
            }
            
            // 查出符合查詢條件的員工編號清單
//            $empSql =  "SELECT empno, daymonth, storecode
//                                FROM (
//                                    SELECT * 
//                                       FROM tbs_emp_month
//                                    WHERE depart = '3' $qryStr
//                                     ORDER BY daymonth DESC
//                                ) AS a
//                                GROUP BY empno
//                                ORDER BY storecode";
            
            $empSql = "SELECT a.empno, a.daymonth, a.storecode
                            FROM (
                            tbs_emp_month a
                            INNER JOIN (
                            SELECT id, empno, MAX( daymonth ) AS daymonth, storecode
                            FROM tbs_emp_month
                            WHERE depart =  '3'
                            AND daymonth <=  '$qry_date'
                            GROUP BY empno
                            )b ON a.empno = b.empno
                            AND a.daymonth = b.daymonth
                            ) $qryStr ";            
            
            $result = Yii::app()->db->createCommand($empSql)->queryAll();
            
            //sql=sql.in('007001')因為只有一筆的時候沒有' , '  所以直接把店編放進去
            if(count($result)>0) {
                $qryStrno = " AND empno in ('".$result[0]['empno']."'";
                //如果名單>1,就需要' , '
                if(count($result)>1)
                    for ($i = 1; $i < count($result); $i++) {
                        $qryStrno = $qryStrno.",'".$result[$i]['empno']."'";
                    }
                $qryStrno = $qryStrno.")";
            }else
            {
                if ($check_emp && $check_store && $check_area)
                    $check_query =FALSE;
                
                if($check_store) Yii::app()->user->setFlash('error', '查無門市所屬人員，請重新查詢！');
                if($check_area) Yii::app()->user->setFlash('error', '查無區域所屬門市及人員，請重新輸入！');
                    
            }
            unset($result);
        }
        
        // 如果是查詢員工. 要判斷這個區店長有沒有這個權限
        if(isset($_POST['qry']) && $check_emp && $qry_empno != '') {
            
            $tbsemp = TbsEmpMonth::model()->findByDayMonth($qry_empno, $qry_date);
            if($tbsemp->area != $qry_area) {
                Yii::app()->user->setFlash('error', '您查詢的員工，這個月不屬於你的區喔，無法查詢！');
                $check_query = FALSE;
            }
        }
        
        $empAry = array();
        $sql = '';
        
        if(isset($_POST['qry']) && $check_query){
            
            //查到15號的業績
            $midday = date("Ymd", mktime(0, 0, 0, $tmp_mon, 15, $tmp_year));  
            
            $sql =  "SELECT empno, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                    . "WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno "
                    . "GROUP BY empno, serviceno ORDER BY empno ";

            $sql2 = "SELECT empno, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                    . "WHERE pdate BETWEEN '$dateS' AND '$midday' $qryStrno "
                    . "GROUP BY empno, serviceno ORDER BY empno ";
                    
            $result1 = Yii::app()->db->createCommand($sql)->queryAll();            
            
            $empAry = $this->setEmpAry($result1);   
            
            $result2 = Yii::app()->db->createCommand($sql2)->queryAll();
            
            $empAry = $this->setMidEmpAry($empAry, $result2);
            
            // 查出洗髮+10元的剪髮顆數跟洗頭數
            $sql3 = "SELECT a.empno, sum(b.num) as cut, sum(a.num) as wash
                        FROM 
                        (
                        SELECT pdate, storecode, empno, num 
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno = 'D01' 
                        ) a
                        ,
                        (
                        SELECT pdate, storecode, empno, num 
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno = 'A01'
                        ) b 
                        WHERE a.pdate = b.pdate AND a.storecode = b.storecode AND a.empno = b.empno
                        GROUP BY a.empno";
            
            $result3 = Yii::app()->db->createCommand($sql3)->queryAll();            
            
            $empAry = $this->setWashEmpAry($empAry, $result3, 'col10', 'col12');
            
            // 查出洗髮不加10元的剪髮顆數跟洗頭數
            $sql4 = "SELECT a.empno, sum(b.num) as cut, sum(a.num) as wash
                        FROM 
                        (
                        SELECT pdate, storecode, empno, sum(num) as num
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno IN ('S02','S06')
                        GROUP BY pdate, storecode, empno
                        ) a
                        ,
                        (
                        SELECT pdate, storecode, empno, sum(num) as num
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno IN ('A01','S01','S05')
                        GROUP BY pdate, storecode, empno
                        ) b 
                        WHERE a.pdate = b.pdate AND a.storecode = b.storecode AND a.empno = b.empno
                        GROUP BY a.empno";
            
            $result4 = Yii::app()->db->createCommand($sql4)->queryAll();            
            
            $empAry = $this->setWashEmpAry($empAry, $result4, 'col11', 'col13');
        }
        
        foreach ($empAry as $empno => $empData) {
            
            // 查詢員工薪資福利
            $empMonth = new TbsEmpMonth;
            $empMonth = TbsEmpMonth::model()->findByDayMonth($empno, $qry_date);
            $user = User::model()->findByPk($empno);
            if($empMonth!=NULL) {
                
                $row = array();
                // 年月
                $row['ym'] = $qry_date;
                // 營業區
                $row['area'] = $areaAry[$empMonth->area];
                // 門市
                $row['store'] = $storeAry[$empMonth->storecode];
                // 職稱
                $row['position'] = $positionAry[$empMonth->position1];
                // 若不顯示助理. 則以下不用繼續進行
                if($empMonth->position1 == 17 && !($checkAssist)) continue;
                // 員編
                $row['empno'] = $empno;
                // 姓名
                $row['name'] = ($user->emp)?$user->emp->empname:''; 
                // 到職日
                $row['arrivedate'] = Yii::app()->dateFormatter->format("yyyy-MM-dd",$empMonth->arrivedate,"yyyy-MM-dd");
                // 狀態
                $row['status'] = TbsEmp::model()->getHireType($empMonth->hiretype);
                // 保底
                $row['salary'] = $salaryAry[$empMonth->salary];
                // 責任業績, 區店長需動態算, opt2欄位設成管理門市數
                // 103/7/1 區店長責任額修正
//                if($empMonth->position1 == 9){
//                    $areaduty = TbsAreaduty::model()->findByAttributes(array('storenum'=>$empMonth->opt2));
//                    if(isset($areaduty))
//                        $row['duty'] = $areaduty->duty;
//                }else
                    $row['duty'] = $dutyAry[$empMonth->salary];

                // 設定各欄位業績及洗助算法
                 $row = $this->setRpt09RowData($row,$empData);

                 // 達成率
                $rate = ($row['duty']==0)?0:round( ($row['perform']/$row['duty']),4 );
                $row['rate'] = $rate*100 . "%";

                //洗髮+10 
//                $row['col10'] = 0;
//                $row['col12'] = 0;
                $row['col10'] = isset($empData['col10'])?$empData['col10']:0;
                $row['col12'] = isset($empData['col12'])?$empData['col12']:0;
            
                //洗髮不加10 
//                $row['col11'] = 0;
//                $row['col13'] = 0;
                $row['col11'] = isset($empData['col11'])?$empData['col11']:0;
                $row['col13'] = isset($empData['col13'])?$empData['col13']:0;

                // 是否達成
                $row['achi'] = ($rate>=1)?'達成':'未達成';            
                if( ($row['perform'] + $row['assist']) > 0)

                // ================== 以下是期中 ==========================
                // 期中保底
                $row['midsalary'] = $row['salary'];
                
                // 期中責任業績
                $row['midduty'] = $row['duty'];

    //            CVarDumper::dump($midasum,10,TRUE);
                // 設定各欄位業績及洗助算法
                 $row = $this->setRpt09MidRowData($row,$empData);

                 // 達成率
                 if($row['midduty'] > 0) {
                     $rate = ($row['midduty']==0)?0:round( ($row['midperform']/$row['midduty']),4 );
                     $row['midrate'] = $rate*100 . "%";
                 }else
                     $row['midrate'] = "0%";

               // 是否達成
                $row['midachi'] = ($rate>=0.5)?'達成':'未達成';            
                if( ($row['midperform'] + $row['midassist']) > 0)

                //期末業績成長率
                if($row['midperform'] > 0) {
                    $ratecol14 = round( ( (($row['perform']-$row['midperform'])-$row['midperform'])/$row['midperform']),4);
//                print_r($ratecol14);
                    $row['col14'] = $ratecol14*100 . "%";
                }else
                    $row['col14'] = "0%";

                array_push($colAry, $row);
            }
            else{
                
                Yii::app()->user->setFlash('error', "查無員工 $empno ". (isset($user->emp)?$user->emp->empname:'') ." ,$qry_date 月的薪資福利資料");
                break;
            }
        }
        
        unset($empAry);
        
        // 用以計算開始/結束時間之變數         
        $time_end = microtime(true);
        $computetime = round(($time_end - $time_start),3);
        
//        Yii::app()->user->setFlash('notice', "最大記憶體 $MaxMem MB, 使用記憶體 $MEM MB！, 執行時間 $computetime 秒");
//        Yii::app()->user->setFlash('notice', "執行時間 $computetime 秒");
        
        if(isset($_POST['qry']) && $check_emp){
            if(count($colAry)<1)
                Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')."查無員工 $qry_empno ,$qry_date 月的業績資料");
            else
                Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success')."查詢成功. 共計 ".count($colAry)." 筆資料");
        }
        
        $this->render($rpt,array(
            'qry_date'=>$qry_date,
            'qry_area'=>$qry_area,
            'qry_store'=>$qry_store,
            'qry_empno'=>$qry_empno,
            'qry_empname'=>$qry_empname,
            'check1'=>$check1,
            'check2'=>$check2,
            'checkAssist'=>$checkAssist,
            'col'=>$col,
            'title'=>$title,
            'colAry'=>$colAry,           
            'computetime'=>$computetime
        ));
    }    
    

    /**
     * 業績月報表
     */
    public function actionRpt10(){

        // 用以計算開始/結束時間之變數
        $time_start = microtime(true);

        // Sleep for a while
        usleep(100);          
        
        //得到起始 結束的年月日
        $sqlDate = "SELECT MID( pdate, 1, 6 ) as daymonth FROM  `tbp_perform` GROUP BY MID( pdate, 1, 6 ) ORDER BY daymonth DESC";
        $dateSqlResult = Yii::app()->db->createCommand($sqlDate)->queryAll();
        
        $dmAry = array();
        for ($i = 0; $i < count($dateSqlResult); $i++) {
            $daymonth = $dateSqlResult[$i]['daymonth'];
            $dmAry[$daymonth] = $daymonth;
        }
        
        $qry_date = date('Ym');
        $qry_area = ""; //區域
        $qry_store = ""; // 門市
        
        $qry_store = array(); //服務項目
 

        if(isset($_POST['qry_date']))        $qry_date = $_POST['qry_date'];
        if(isset($_POST['qry_area']))          $qry_area = $_POST['qry_area'];    
        
        if(isset($_POST['qry_store']))         $qry_store = $_POST['qry_store']; 
        
        // 服務項目陣列(上面的篩選條件)
        $storeary = array();
        $tbsStroes = TbsStore::model()->findAll();
        
        // 業績月報表 是 區域 門市 (月份天數)  合計
        $qry_daymonth = $qry_date.'01';
        $days = date('t',strtotime($qry_daymonth));

        // 畫面呈現的表格欄位, col是欄位名稱, title是欄位顯示的中文字
        $col = $this->getRpt10Col($days);        
        $title = $this->getRpt10Title($days);
//        CVarDumper::dump($title,1,true);
        // 輸出在畫面上的陣列
        $colAry = array();
        //店編對應區域名稱的陣列
        $stores = array();
        //儲存篩選出來的門市
        $tbsStroes = array();
        //儲存塞選出的門市的店編
        $sqlStroe = array();
        //合計陣列
        $sum = array();
        
        foreach ($title as $key => $value) {
            $sum[$key] = 0;
        }
        
        //如果只選區域,就選出區域內的所有門市
        if($qry_area != '')
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

         //按下查詢
        if(isset($_POST['qry'])){
          
            $sql = "SELECT storecode, pdate, total 
                       FROM  `tbp_perform` 
                       WHERE mid(pdate,1,6) = '$qry_date'
                       ORDER BY storecode, pdate ";
      
            $result = Yii::app()->db->createCommand($sql)->queryAll();
                   
            if($result !=NULL && count($result)>0) {
                // 設定資料
                $colAry = $this->setRpt10Data($result, $title);
                Yii::app()->user->setFlash('success', '以日期區間' . $qry_date . ' 查詢成功！合計'. count($colAry) .'筆資料');
                // 重新排序
                $colAry = $this->reorderRpt10Data($colAry);
            }
            else
                Yii::app()->user->setFlash('error', '以日期區間' . $qry_dateS . ' 查無資料');
            
            unset($result);
    
        }else
            Yii::app()->user->setFlash('notice', '年月為資訊系統中有業績的日期, 本報表之業績為門市實際營業額！');
        
        $com = new ComFunction();
        $holidays = array();
        $result = $com->getHolidayByYearMonth($qry_date);
        if(isset($result))
            $holidays = $result;
        
        // 用以計算開始/結束時間之變數         
        $time_end = microtime(true);
        $computetime = $time_end - $time_start;        
        
        try {
                $this->render('rpt10',array(
                    'dmAry'=>$dmAry,
                    'qry_date'=>$qry_date,
                    'qry_area'=>$qry_area,
                    'qry_store'=>$qry_store,
                    'storeary'=>$storeary,
                    'col'=>$col,
                    'title'=>$title,
                    'colAry'=>$colAry,
                    'holidays'=>$holidays,
                    'computetime'=>$computetime
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
            
    }

  /**
    * 取得此年月之日期天數
    * @return string
    */
    private function getRpt10Col($days){
                     
        $col = array(0 => 'area',
                          1 => 'store',
        );
        
        array_push($col, 'total');        
        
        $com = new ComFunction;
        
        $j = 1;
        for ($i = 0; $i < $days; $i++) {
            array_push($col, $com->addZero($j,1));
            $j++;
        }

        return $col;
    }
    /**
     * 
     * @param type $col
     * @return string
     */
    private function getRpt10Title($days){
       
        $title = array('area' => '區域',
                            'store' => '門市',
                            'total' => '合計'
        );
        
        $com = new ComFunction;
        
        $j = 1;
        for ($i = 0; $i < $days; $i++) {
            $k = $com->addZero($j,1);
            $title[$k] = $j;
            $j++;
        }        

        return $title;
    }
            
    /**
     * 
     * @param array $result
     * @param string $title
     * @return array
     */
    private function setRpt10Data($result, $title) {
        
        $colAry = array();        
        
        // 利用 title 陣列作為範本
        foreach ($title as $key => $value) {
            $title[$key] = '';
        }
        // 合計陣列
        $sumAry = $title;
        $sumAry['area'] = '';
        $sumAry['store'] = '合計';
        
        if(isset($result) && count($result)>0) {
            
            $com = new ComFunction();
            $comArray = $com->getStoreArray(FALSE);
            $store = $comArray[0]; // 門市名 
            $area = $comArray[2]; // 區域名
            
            $storecode = $result[0]['storecode'];
            
            $storeary = $title;
            $storeary['area'] = $area[$storecode];
            $storeary['store'] = $store[$storecode];
            // 門市該月合計
            $sum = 0;
            
            for ($i = 0; $i < count($result); $i++) {
                // 相同的門市放同一列
                if($result[$i]['storecode'] == $storecode){    
                    
                    $total = round($result[$i]['total'],0);
                    $storeary[substr($result[$i]['pdate'], 6)] = $total;
                    $sum = $sum + $total;
                    // 合計
                    $sumAry[substr($result[$i]['pdate'], 6)] = $sumAry[substr($result[$i]['pdate'], 6)] + $total;
                    $sumAry['total'] = $sumAry['total'] + $total;
                    
                }  else {
                    // 門市不同後放入另一列
                    $storeary['total'] = $sum;
                    $colAry[$storecode] = $storeary;
                    
                    $storeary = $title;
                    $storecode = $result[$i]['storecode'];
                    $storeary['area'] = $area[$storecode];
                    $storeary['store'] = $store[$storecode];                    
                    $total = round($result[$i]['total'],0);
                    $storeary[substr($result[$i]['pdate'], 6)] = $total;
                    $sum = $total;
                    // 合計
                    $sumAry[substr($result[$i]['pdate'], 6)] = $sumAry[substr($result[$i]['pdate'], 6)] + $total;
                    $sumAry['total'] = $sumAry['total'] + $total;
                }
            }
            
            $storeary['total'] = $sum;
            $colAry[$storecode] = $storeary;
        }
        // 最後把合計陣列加入
        $colAry['sum'] = $sumAry;
        
        return $colAry;
    }
    
    /**
     * 將資料依區域做排序
     * @param type $colAry
     * @return type
     */
    private function reorderRpt10Data($colAry) {
        
        $reorderAry = array();
        
        $criteria = new CDbCriteria(array('order'=>'area_id, storecode'));
        $stores = TbsStore::model()->findAllByAttributes(array(),$criteria);
        
        foreach ($stores as $store) {
            if(isset($colAry[$store->storecode]))
                $reorderAry[$store->storecode] = $colAry[$store->storecode];
        }
        // 最後加入合計陣列
        $reorderAry['sum'] = $colAry['sum'];
        return $reorderAry;
    }
    
     public function actionRpt11(){
        
        //用以計算開始/結束時間之變數
        $time_start = microtime(true);
          
        //決定是門市設計師按鈕功能，false則是每日業績按鈕功能
        $isExist=true;
        
         //查詢的年月
        $qry_date = date('Ym');
        //區域
        $qry_area = "";
        //門市
        $qry_store = ""; 
        
        //顯示銷售情報
        $check_sale_Intelligence = 0;
          
        if(isset($_GET['storecode']) && isset($_GET['pdate'])){               

            Yii::app()->session['storecode'] = $_GET['storecode'];
            Yii::app()->session['pdate'] = $_GET['pdate'];
            $this->redirect(array('rpt11'));//跳轉回rpt11頁面
        }else
            { 
                        
                if(isset($_POST['qry_date']))         $qry_date = $_POST['qry_date'];
                if(isset($_POST['qry_area']))         $qry_area = $_POST['qry_area'];    
                if(isset($_POST['qry_store']))        $qry_store = $_POST['qry_store'];
                if(isset($_POST['check_sale_Intelligence']))           $check_sale_Intelligence = $_POST['check_sale_Intelligence'];  
                
                    if(Yii::app()->session['storecode']!='' && Yii::app()->session['pdate']!=''){
                        $qry_store=Yii::app()->session['storecode'];
                        $qry_date=Yii::app()->session['pdate'];

                        //沒使用到清空
                        unset(Yii::app()->session['storecode']);
                        unset(Yii::app()->session['pdate']);
                    }         
            }
                       
        //切割出年份
        $tmp_year=substr($qry_date,0,4);
        //切割出月份
        $tmp_mon =substr($qry_date,4,2);
       
        //月底
        $dateS = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));
        //月初
        $dateE = date("Ymd", mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year)); 
            
        // 取得欄位  
        $col = $this->getRpt11Col($check_sale_Intelligence);
        // 取得表頭   
        $title = $this->getRpt11Title();
        
        // 取得欄位2  
        $acol = $this->getRpt11_daily_Col();
        // 取得表頭2   
        $atitle = $this->getRpt11_daily_Title();
        
        // 取得欄位3  
        $acol2 = $this->getRpt11_daily2_Col();
        // 取得表頭3   
        $atitle2 = $this->getRpt11_daily2_Title();
        
        // 輸出在畫面上的陣列
        $colAry = array();
        $colAry2 = array();
        $colAry3 = array();
        //其他項目包含少收
        $other = array();
        
        // 門市. 門市ID
        $storeAry = array();
        $storeAreaId = array();
        $TbsStores = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsStores as $store) {
            $storeAry[$store->storecode] = $store->storename;
            $storeAreaId[$store->storecode] = $store->area_id;
        }
        unset($TbsStores);
        
        // 區域
        $areaAry = array();
        $TbsAreas = TbsArea::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsAreas as $area) {
            $areaAry[$area->id] = $area->areaname;
        }
        unset($TbsAreas);     
        // 職位
        $positionAry = array();
        $TbsPositions = TbsPosition::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsPositions as $pos) {
            $positionAry[$pos->id] = $pos->pcname;
        }
        unset($TbsPositions);
        
        // 薪資, 責任額
        $salaryAry = array(); 
        $dutyAry = array();
        $TbsBaseSalary = TbsBasesalary::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsBaseSalary as $salary) {
            $salaryAry[$salary->id] = $salary->salary;
            $dutyAry[$salary->id] = $salary->duty;
        }
        unset($TbsBaseSalary);
        
        //員工SQL
        $qryStrno = '';    
        $check_area = TRUE;
        $check_store = TRUE;
        $check_all = TRUE;
        $check_query = TRUE;

        
         //如果有選門市,就只選出那一家門市
        if($qry_store != ''){
            $tbsStroes = TbsStore::model()->findAllByAttributes(array('storecode'=>$qry_store));
            if(count($tbsStroes)<1) $check_store = FALSE;
        //如果只選區域,就選出區域內的所有門市
        }elseif($qry_area != ''){
            $tbsStroes = TbsStore::model()->findAllByAttributes(array('area_id'=>$qry_area));
            if(count($tbsStroes)<1) $check_area = FALSE;
        //如果都沒有選,就全部選出來
        }else{
            $tbsStroes = TbsStore::model()->findAll();
            if(count($tbsStroes)<1) $check_all = FALSE;
             }
        
        // 儲存篩選出的門市的店編
        $sqlStroe = array();
        foreach ($tbsStroes as $store) {
               //找出篩選出的門市的區域代碼
               $area = TbsArea::model()->findByPK($store->area_id);
               if($area!=NULL){
                   //push店編
                   array_push($sqlStroe, $store->storecode);
               }
        }
              
         // 查詢用的SQL
            $qryStr = '';

        //如果有選門市或區域就需要sql=AND storecode in('007001',007002')  
        if($qry_store != '' OR $qry_area != '') {
            //sql=sql.in('007001')因為只有一筆的時候沒有' , '  所以直接把店編放進去
            if(count($sqlStroe)>0) {
//                    $qryStr = " AND storecode in ('$sqlStroe[0]'";
                $qryStr = "WHERE a.storecode in ('$sqlStroe[0]'";
                //如果門市>1,就需要' , '
                if(count($sqlStroe)>1)
                    for ($i = 1; $i < count($sqlStroe); $i++) {
                        $qryStr = $qryStr.",'$sqlStroe[$i]'";
                    }
                $qryStr = $qryStr.")";
            }
        }
        
        $empSql = "SELECT a.empno, a.daymonth, a.storecode
                        FROM (
                        tbs_emp_month a
                        INNER JOIN (
                        SELECT id, empno, MAX( daymonth ) AS daymonth, storecode
                        FROM tbs_emp_month
                        WHERE depart =  '3'
                        AND daymonth <=  '$qry_date'
                        GROUP BY empno
                        )b ON a.empno = b.empno
                        AND a.daymonth = b.daymonth
                        ) $qryStr ";

        $result = Yii::app()->db->createCommand($empSql)->queryAll();
     
        //sql=sql.in('007001')因為只有一筆的時候沒有' , '  所以直接把店編放進去
        if(count($result)>0) {
            $qryStrno = " AND empno in ('".$result[0]['empno']."'";
            //如果名單>1,就需要' , '
            if(count($result)>1)
                for ($i = 1; $i < count($result); $i++) {
                    $qryStrno = $qryStrno.",'".$result[$i]['empno']."'";
                }
            $qryStrno = $qryStrno.")";             
        }else
        {
            if ( $check_store && $check_area)
                $check_query =FALSE;             
            if($check_store) Yii::app()->user->setFlash('error', '查無門市所屬人員，請重新查詢！');
            if($check_area) Yii::app()->user->setFlash('error', '查無區域所屬門市及人員！');                 
        }
        unset($result);
        
        $empAry = array();
        $sql = '';
        
        if(isset($_POST['qry_designer']) && $check_query OR ($qry_store!='' && $qry_date!='' && !isset($_POST['qry_daily']) && $check_query )){ //OR $qry_store!='' && $qry_date!='' && $check_query 為了GET
           
            //查到15號的業績
            $midday = date("Ymd", mktime(0, 0, 0, $tmp_mon, 15, $tmp_year));  
            
            $sql =  "SELECT empno, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                    . "WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno "
                    . "GROUP BY empno, serviceno ORDER BY empno ";

            $sql2 = "SELECT empno, serviceno, sum(num) as num FROM tbp_perform_emp_log "
                    . "WHERE pdate BETWEEN '$dateS' AND '$midday' $qryStrno "
                    . "GROUP BY empno, serviceno ORDER BY empno ";
                   
            $result1 = Yii::app()->db->createCommand($sql)->queryAll();            
           
            $empAry = $this->setEmpAry($result1);   
         
            $result2 = Yii::app()->db->createCommand($sql2)->queryAll();
            
            $empAry = $this->setMidEmpAry($empAry, $result2);
                 
            // 查出洗髮+10元的剪髮顆數跟洗頭數
            $sql3 = "SELECT a.empno, sum(b.num) as cut, sum(a.num) as wash
                        FROM 
                        (
                        SELECT pdate, storecode, empno, num 
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno = 'D01' 
                        ) a
                        ,
                        (
                        SELECT pdate, storecode, empno, num 
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno = 'A01'
                        ) b 
                        WHERE a.pdate = b.pdate AND a.storecode = b.storecode AND a.empno = b.empno
                        GROUP BY a.empno";
            
            $result3 = Yii::app()->db->createCommand($sql3)->queryAll();            
            
            $empAry = $this->setWashEmpAry($empAry, $result3, 'col10', 'col12');
            
            // 查出洗髮不加10元的剪髮顆數跟洗頭數
            $sql4 = "SELECT a.empno, sum(b.num) as cut, sum(a.num) as wash
                        FROM 
                        (
                        SELECT pdate, storecode, empno, sum(num) as num
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno IN ('S02','S06')
                        GROUP BY pdate, storecode, empno
                        ) a
                        ,
                        (
                        SELECT pdate, storecode, empno, sum(num) as num
                        FROM `tbp_perform_emp_log` 
                        WHERE pdate BETWEEN '$dateS' AND '$dateE' $qryStrno AND serviceno IN ('A01','S01','S05')
                        GROUP BY pdate, storecode, empno
                        ) b 
                        WHERE a.pdate = b.pdate AND a.storecode = b.storecode AND a.empno = b.empno
                        GROUP BY a.empno";
            
            $result4 = Yii::app()->db->createCommand($sql4)->queryAll();            
        
            $empAry = $this->setWashEmpAry($empAry, $result4, 'col11', 'col13');
           
            foreach ($empAry as $empno => $empData) {
  
           // 查詢員工薪資福利
           $empMonth = new TbsEmpMonth;
           $empMonth = TbsEmpMonth::model()->findByDayMonth($empno, $qry_date);
           $user = User::model()->findByPk($empno);
           if($empMonth!=NULL) {

               $row = array();
               //員編
               $row['empno'] = $empno;
               // 年月
               $row['ym'] = $qry_date;
               // 營業區
               $row['area'] = $areaAry[$empMonth->area];
               // 門市
               $row['store'] = $storeAry[$empMonth->storecode];
               // 職稱
               $row['position'] = $positionAry[$empMonth->position1];            
               // 姓名
               $row['name'] = ($user->emp)?$user->emp->empname:''; 
               // 到職日
               $row['arrivedate'] = Yii::app()->dateFormatter->format("yyyy-MM-dd",$empMonth->arrivedate,"yyyy-MM-dd");
               // 狀態
               $row['status'] = TbsEmp::model()->getHireType($empMonth->hiretype);
               // 底薪
               $row['salary'] = $salaryAry[$empMonth->salary];
               //已休
               $row['vacation']=' ';
                           
               // 責任業績, 區店長需動態算, opt2欄位設成管理門市數
//               if($empMonth->position1 == 9){
//                   $areaduty = TbsAreaduty::model()->findByAttributes(array('storenum'=>$empMonth->opt2));
//                   if(isset($areaduty))
//                       $row['duty'] = $areaduty->duty;
//               }else
                   $row['duty'] = $dutyAry[$empMonth->salary];
                
               // 設定各欄位業績及洗助算法
                $row = $this->setRpt11RowData($row,$empData);
            
                // 達成率
               $rate = ($row['duty']==0)?0:round( ($row['perform']/$row['duty']),4 );
               $row['rate'] = $rate*100 . "%";
               
                 // CVarDumper::dump($empData,10,true);
                 // 
               // 是否達成
               $row['achi'] = ($rate>=1)?'達成':'未達成';            
               if( ($row['perform'] + $row['assist']) > 0)

               // ================== 以下是期中 ==========================
  
   //            CVarDumper::dump($midasum,10,TRUE);
               // 設定各欄位業績及洗助算法
                $row = $this->setRpt11MidRowData($row,$empData);
                
                // 期中業績(不含洗住)
               $row['col8'] = $row['midperform'];
               
                // 期中責任業績
               $row['midduty'] = $row['duty'];

                // 達成率
                if($row['midduty'] > 0) {
                    $rate = ($row['midduty']==0)?0:round( ($row['midperform']/$row['midduty']),4 );
                    $row['midrate'] = $rate*100 . "%";
                }else
                    $row['midrate'] = "0%";

              // 是否達成
               $row['midachi'] = ($rate>=0.5)?'達成':'未達成';            
               if( ($row['midperform'] + $row['midassist']) > 0)

               //期末業績成長率
               if($row['midperform'] > 0) {
                   $ratecol14 = round( ( (($row['perform']-$row['midperform'])-$row['midperform'])/$row['midperform']),4);
//                print_r($ratecol14);
                   $row['col7'] = $ratecol14*100 . "%";
               }else
                   $row['col7'] = "0%";

               array_push($colAry, $row);
           }
           else{

               Yii::app()->user->setFlash('error', "查無員工 $empno ". (isset($user->emp)?$user->emp->empname:'') ." ,$qry_date 月的薪資福利資料");
               break;
           }
       }
      
       unset($empAry);
       
       //統計結果
       //$total=$this->getTotal($colAry);
            
        }elseif(isset($_POST['qry_daily']))
        {
            $isExist=false;
           
            /*--以下為每日業績--*/
            
            //儲存所選門市當月總業績金額
            $all_amount=array();
            //儲存所選門市當月每天業績金額
            $amount=array();
            //每一行的陣列
            $Arylog = array();           
            
          
            if(isset($_POST['qry_store']) && $qry_store!=''){
                
                //門市總業績
                $perform_sql='';
                $perform_sql="SELECT mid(pdate,1,6) AS  pdate , storecode  ,storename ,  sum(total) AS total FROM  tbp_perform 
                                WHERE  mid(pdate,1,6)=$qry_date  and storecode='$qry_store' ";
                
                $perform_result = Yii::app()->db->createCommand($perform_sql)->queryAll();
                
                //先將該門市整個月的業績存在all_amount array()裡
                if($perform_result>0){               
                        foreach ($perform_result as $value) {
                            $all_amount[$value['pdate']] = $value['total'];
                        }
                        unset($perform_result);           
                 }
               
                
            //該門市有業績的人員資料
            $personsql='';
            $personsql="SELECT mid(a.pdate,1,6) AS pdate , c.areaname ,d.storecode ,d.storename 
                        , b.position1 , a.empno , a.empname , b.arrivedate ,b.hiretype

                       FROM tbp_perform_emp AS a ,tbs_emp_month AS b ,tbs_area AS c , tbs_store AS d

                       where mid(a.pdate,1,6)='$qry_date' and a.storecode='$qry_store' and
                       a.empno=b.empno and b.area=c.id and  b.storecode=d.storecode

                       and d.storecode=(SELECT storecode  FROM tbs_emp_month
                       where empno=a.empno and  daymonth <='$qry_date'
                       order by daymonth DESC LIMIT 1)  "; //group by a.empno
            
             $person_result = Yii::app()->db->createCommand($personsql)->queryAll();
            
             //撈出在該門市有業績的員編
             $temp_arr=array();
             if(count($person_result)>0){
                  for ($i = 0; $i < count($person_result); $i++) {
                      array_push($temp_arr, $person_result[$i]['empno']);
                  }
             }//if(count($person_result)>0){
           
              $_str = "'".implode("','", $temp_arr)."'"; //每個員編加入單引號為了sql in查詢使用
               
              //得到員工剪、染、洗等..
              $personsql2='';
              $personsql2= "SELECT empno,empname ,serviceno, sum(num) as num FROM tbp_perform_emp_log 
                            WHERE mid(pdate,1,6)='$qry_date' and storecode='$qry_store' 
                            and empno in($_str) and num!=0
                             GROUP BY empno, serviceno ORDER BY empno , serviceno"; 
              $person_result2 = Yii::app()->db->createCommand($personsql2)->queryAll();
              
              $person_result2 = $this->setEmpAry($person_result2); 
              
              
            //有業績的人員資料及員工剪、染、洗等..，放在一起
             
              for ($i = 0; $i < count($person_result); $i++) {
            
                    $empno = $person_result[$i]['empno'];
                    if(isset($person_result2[$empno])){

                        $emp = $person_result2[$empno];
                        $emp['pdate'] = $person_result[$i]['pdate'];
                        $emp['areaname'] = $person_result[$i]['areaname'];
                        $emp['storecode'] = $person_result[$i]['storecode'];
                        $emp['storename'] = $person_result[$i]['storename'];
                        $emp['position1'] = $person_result[$i]['position1'];
                        $emp['empno'] = $person_result[$i]['empno'];
                        $emp['empname'] = $person_result[$i]['empname'];
                        $emp['arrivedate'] = $person_result[$i]['arrivedate'];
                        $emp['hiretype'] = $person_result[$i]['hiretype'];
                        
                        $person_result2[$empno] = $emp;
                    }else
                        continue;
                }
             
              foreach ($person_result2 as $empno => $empData) {
  
               $row = array();
              
               // 年月
               $row['ym'] = $empData['pdate'];
               // 營業區
               $row['areaname'] = $empData['areaname'];
               // 門市編號(為了計算本店與別店的占比)
               $row['storecode'] = $empData['storecode'];
               // 門市
               $row['storename'] = $empData['storename'];
               // 職稱
               $row['position'] = $positionAry[$empData['position1']]; 
               // 姓名
               $row['empname'] = $empData['empname'];
               // 到職日期
               $row['arrivedate'] = $empData['arrivedate'];
               // 狀態
               $row['hiretype'] = TbsEmp::model()->getHireType($empData['hiretype']);
               
               // 設定各欄位業績及洗助算法
               $row = $this->setRpt11Row_daily_Data2($row,$empData);
               
               // 業績百分比
               $total = (float)$all_amount[$empData['pdate']]; 
               $rate =round( ($row['perform']/$total),4 );
               $row['rate'] = $rate*100 . "%";
             
               array_push($colAry3, $row);
              }
              
              //存業績陣列
              $rank=array();
              //存業績排名陣列
              $rank2=array();
              for ($i = 0; $i < count($colAry3); $i++){
                  array_push($rank, $colAry3[$i]['perform']);
              }
              
              //create a copy and rsort
              $rank_copy = $rank;
              rsort($rank_copy);
              
              //reverses key and values
              $rank_copy = array_flip($rank_copy);

              //create result by using keys from sorted values + 1
              foreach($rank as $val){
                  $rank2[] = $rank_copy[$val]+1;
              }
              
              //插入排名到$colAry3
              foreach ($rank2 as $key=>$value) {
              
                    if(isset($colAry3[$key])){

                        $temp = $colAry3[$key];
                        $temp['perform_rank'] = $value;                      
                        
                        $colAry3[$key] = $temp;
                    }else
                        continue;
                }
                          
           //   CVarDumper::dump($colAry3,10,true);
             
                
                //門市服務項目SQL
                $sql='';
                $sql="(SELECT  pdate , storecode  , storename ,serviceno, sum(num) as amount  FROM tbp_perform_emp_log
                      WHERE mid(pdate,1,6)='$qry_date' and storecode='$qry_store' AND num !=0
                                    GROUP BY pdate , serviceno 
                                    ORDER BY  pdate DESC )";
                
                $sql2='';
                $sql2="(SELECT  pdate , storecode  , storename ,serviceno, sum(num) as amount  FROM tbp_perform_log
                      WHERE mid(pdate,1,6)='$qry_date' and storecode='$qry_store' AND num !=0
                                    GROUP BY pdate , serviceno 
                                    ORDER BY  pdate DESC )";
                
                 $sql=$sql."UNION".$sql2;  //合併          
                 $sql = $sql. "order by pdate DESC, storecode, serviceno";//一定要照pdate排序,因為loop要照日期去跑

                $result = Yii::app()->db->createCommand($sql)->queryAll();
               
                 //門市業績
                $sql3='';
                $sql3="SELECT  pdate , storecode  ,storename ,  total FROM  tbp_perform 
                        WHERE  mid(pdate,1,6)='$qry_date'  and storecode='$qry_store'
                        GROUP BY   pdate 
                        ORDER BY  storecode ASC ,  pdate DESC";

                $result2 = Yii::app()->db->createCommand($sql3)->queryAll();
                
                //先將該門市整個月的業績存在amount array()裡
                if($result2>0){               
                        foreach ($result2 as $value) {
                            $amount[$value['pdate']] = $value['total'];

                        }
                        unset($result2);           
                 }
                 
                 //將門市所有服務項目放在同個日期及門市
                  if(count($result>0)) {
                      
                         if(isset($result[0]['pdate']) OR isset($result[0]['storecode']) ){
                            $day = $result[0]['pdate'];
                            $storecode = $result[0]['storecode'];
                                        
                            // 每一行的陣列
                            $row = array(); 
                            for ($i = 0; $i < count($result); $i++) {
                                if($day == $result[$i]['pdate'] && $storecode == $result[$i]['storecode']){
                                    $row['pdate'] = $result[$i]['pdate'];
                                    $row['storecode'] = $result[$i]['storecode'];
                                    $row['storename'] = $result[$i]['storename'];                                 
                                    $row[$result[$i]['serviceno']] = $result[$i]['amount'];
                                    $row['total'] = $amount[$result[$i]['pdate']]; 
                                }else{
                                     array_push($Arylog, $row);
                                     $row = array();
                                     $day = $result[$i]['pdate'];
                                     $storecode = $result[$i]['storecode'];
                                    /*------*/
                                    $row['pdate'] = $result[$i]['pdate'];
                                    $row['storecode'] = $result[$i]['storecode'];
                                    $row['storename'] = $result[$i]['storename'];                                 
                                    $row[$result[$i]['serviceno']] = $result[$i]['amount'];
                                    $row['total'] = $amount[$result[$i]['pdate']];                                 
                                } 
                            
                            }//for ($i = 0; $i < count($result); $i++) {   
                            array_push($Arylog, $row);
                         }//if(isset($result[0]['pdate']) OR isset($result[0]['storecode']) ){                     
                  }//if(count($result>0)) {
                  
                  foreach ($Arylog as $key => $storeData) {
                        $row = array();
                        //日期
                        $row['ymd'] = $storeData['pdate'];
                        // 設定各欄位業績及洗助算法
                        $row = $this->setRpt11Row_daily_Data($row,$storeData);
                        //每日業績金額
                        $row['perform_amount'] = (float)$storeData['total'];
                        array_push($colAry2, $row);
                  }
              
                //計算其他項目
                $other_sql='';
                $other_sql="(SELECT  mid(pdate,1,6) as pdate , storecode  , storename ,serviceno, sum(num) as amount  FROM tbp_perform_log
                          WHERE mid(pdate,1,6)='$qry_date' and storecode='$qry_store' AND num !=0
                                        GROUP BY  serviceno 
                                        ORDER BY  pdate DESC )";
                 $other_result = Yii::app()->db->createCommand($other_sql)->queryAll();
                 
                 if(count($other_result>0)) {
                     if(isset($other_result[0]['storecode']) ){
                         
                            $storecode = $other_result[0]['storecode'];
                            // 每一行的陣列
                            $row = array(); 
                            for ($i = 0; $i < count($other_result); $i++) {
                                if( $storecode == $other_result[$i]['storecode']){                                 
                                    $row['storecode'] = $other_result[$i]['storecode'];
                                    $row['storename'] = $other_result[$i]['storename'];                                 
                                    $row[$other_result[$i]['serviceno']] = $other_result[$i]['amount'];                                   
                                }else{
                                     array_push($other, $row);
                                     $row = array();                                 
                                     $storecode = $other_result[$i]['storecode'];
                                    /*------*/                                  
                                    $row['storecode'] = $other_result[$i]['storecode'];
                                    $row['storename'] = $other_result[$i]['storename'];                                 
                                    $row[$other_result[$i]['serviceno']] = $other_result[$i]['amount'];                                                               
                                } 
                            }//for ($i = 0; $i < count($other_result); $i++) {
                             array_push($other, $row);
                     }//if(isset($result[0]['storecode']) ){
                 }//if(count($other_result>0)) {
                  
                 if(isset($other[0])){
                    $other= $this->getRpt11MoneySellandReduce($other[0]);
                 
                    //其他項目百分比
                   $other_amout = (float)$all_amount[$qry_date];
                   if($other['sum']!=0){
                   $rate =round( ($other['sum']/$other_amout),4 );
                   $other['rate']=$rate*100 . "%";
                   }
                   if($other['sum2']!=0){
                   $rate =round( ($other['sum2']/$other_amout),4 );
                   $other['rate2']=$rate*100 . "%";
                   }
                 }                                                        
            }
        }//elseif(isset($_POST['qry_daily']))
        
       
      // CVarDumper::dump($colAry,10,true);
       
        $time_end = microtime(true);
        $computetime = round(($time_end - $time_start),3);
        
        if(isset($_POST['qry_designer']) OR ($qry_store!='' && $qry_date!='' && !isset($_POST['qry_daily'])) ){
            if(count($colAry)<1)
                Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')."查無,$qry_date 月的業績資料");
            else
                Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success')."查詢成功. 共計 ".count($colAry)." 筆資料");
            
        }elseif(isset($_POST['qry_daily'])){
            
            if($qry_store!=''){
                if(count($colAry2)<1 and count($colAry3)<1)
                    Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')."查無,$qry_date 月的業績資料");
                else
                    Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success')."查詢成功.");
            }else{
                    Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')."請選擇門市!");
            }
        }
        
         $this->render('rpt11',array(         
             'isExist'=>$isExist,
             'qry_date'=>$qry_date,
             'qry_area'=>$qry_area,
             'qry_store'=>$qry_store,
             'tbsStroes'=>$tbsStroes,
             'check_sale_Intelligence'=>$check_sale_Intelligence,
             'col'=>$col,
             'title'=>$title,
             'colAry'=>$colAry,
             'acol'=>$acol,
             'atitle'=>$atitle,
             'colAry2'=>$colAry2,
             'acol2'=>$acol2,
             'atitle2'=>$atitle2,
             'colAry3'=>$colAry3,
            // 'total'=>$total,
             'other'=>$other,
             'computetime'=>$computetime,
         ));
    }
    
    
    /**
    * 
    * @return string
    */
    private function getRpt11Col($check_sale_Intelligence){
        
        if($check_sale_Intelligence){
            
            $col = array(0 => 'ym',
                                1 => 'area',
                                2 => 'store',
                                3 => 'position',
                                4 => 'name',
                                5 => 'arrivedate',
                                6 => 'status',
                                7 => 'salary',
                                8 => 'vacation',
                                9 =>  'col1', //剪髮
                                10 => 'col2', //染髮
                                11 => 'col3', //助染
                                12 => 'col4', //優染
                                13 => 'col5', //優助染
                                14 => 'col6', //洗髮
                                15 =>'shampoo',//洗髮精
                                16 =>'hair_oil',//髮油
                                17 =>'lotion',//髮雕
                                18 => 'perform', 
                                19 => 'assist', 
                                20 => 'duty', 
                                21 => 'rate', 
                                22 => 'achi', 
                                23 => 'col7', //期末業績成長率%
                                24 => 'col8', //期中業績(不含洗助)
                                25 => 'midduty',//期中責任額
                                26 => 'midrate',//其中達成率
                                27 => 'midachi'//其中達成率
                    );
        }else{
            
             $col = array(0 => 'ym',
                                1 => 'area',
                                2 => 'store',
                                3 => 'position',
                                4 => 'name',
                                5 => 'arrivedate',
                                6 => 'status',
                                7 => 'salary',
                                8 => 'vacation',                              
                                9 => 'perform', 
                                10 => 'assist', 
                                11 => 'duty', 
                                12 => 'rate', 
                                13 => 'achi', 
                                14 => 'col7', //期末業績成長率%
                                15 => 'col8', //期中業績(不含洗助)
                                16 => 'midduty',//期中責任額
                                17 => 'midrate',//其中達成率
                                18 => 'midachi'//其中達成率
                    );
            
             }
        return $col;
    }
    
    /**
     *   
     * @return string
     */
    private function getRpt11Title(){
       
        $title = array('ym' => '年月',
                            'area' => '營業區',
                            'store' => '門市',
                            'position' => '職稱',                                                   
                            'name' => '姓名',
                            'arrivedate' => '到職日',
                            'status' => '狀態',
                            'salary' => '薪資',
                            'vacation' => '已休',
                            'col1' => '剪髮',
                            'col2' => '染髮',
                            'col3' => '助染',
                            'col4' => '優染',
                            'col5' => '優助染',
                            'col6' => '洗髮',
                            'shampoo' =>'洗髮精',
                            'hair_oil' =>'髮油',
                            'lotion' =>'髮雕',
                            'perform' => '業績',                       
                            'assist' => '洗助',
                            'duty' => '責任業績',
                            'rate' => '期末達成率',
                            'achi' => '達成與否',
                            'col7' => '期末業績成長率%',
                            'col8' => '期中業績(不含洗助)',
                            'midduty' => '責任額',
                            'midrate' => '達成率',                        
                            'midachi' => '達成與否',                        
            );      
        return $title;    
    }
    
    /**
    * 
    * @return string
    */
    private function getRpt11_daily_Col(){
        
         $col = array(0 => 'ymd',                             
                                1 => 'col1', //剪髮
                                2 => 'col2', //染髮
                                3 => 'col3', //助染
                                4 => 'col4', //優染
                                5 => 'col5', //優助染
                                6 => 'col6', //洗髮
                                7 => 'col7', //染膏
                                8 =>'shampoo',//洗髮精
                                9 =>'moment',//瞬護
                                10 =>'isolation',//隔離
                                11 =>'hair_oil',//髮油
                                12 =>'lotion',//髮雕
                                13 => 'perform_amount',//營業額合計                                
                    );
          return $col;
    }
    
     /**
     *   
     * @return string
     */
    private function getRpt11_daily_Title(){
        
        $title = array('ymd' => '日期',                         
                            'col1' => '剪髮',
                            'col2' => '染髮',
                            'col3' => '助染',
                            'col4' => '優染',
                            'col5' => '優助染',
                            'col6' => '洗髮',
                            'col7' => '染膏',
                            'shampoo' =>'洗髮精',
                            'moment' =>'瞬護',
                            'isolation' =>'隔離',
                            'hair_oil' =>'髮油',
                            'lotion' =>'髮雕',
                            'perform_amount' => '營業額合計',                                                                      
            );      
        return $title;    
    }
    
    /**
    * 
    * @return string
    */
    private function getRpt11_daily2_Col(){
        
         $col = array(0 => 'ym',    
                                1 => 'areaname', //營業區
                                2 => 'storename', //分店
                                3 => 'position',//職稱
                                4 => 'empname',//姓名
                                5 => 'arrivedate',//到職日
                                6 => 'hiretype',//狀態
                                7 => 'col1', //剪髮
                                8 => 'col2', //染髮
                                9 => 'col3', //助染
                                10 => 'col4', //優染
                                11 => 'col5', //優助染
                                12 => 'col6', //洗髮                              
                                13 =>'shampoo',//洗髮精
                                14 =>'moment',//瞬護
                                15 =>'isolation',//隔離
                                16 =>'hair_oil',//髮油
                                17 =>'lotion',//髮雕
                                18 => 'perform',//業績合計  
                                19 => 'rate',//業績百分比 
                                20 => 'perform_rank',//業績排名 
                    );
          return $col;
    }
    
     /**
     *   
     * @return string
     */
    private function getRpt11_daily2_Title(){
        
        $title = array('ym' => '日期',
                            'areaname'=> '營業區' ,
                            'storename' => '分店', 
                            'position' => '職稱',
                            'empname' => '姓名',
                            'arrivedate' => '到職日',
                            'hiretype' => '狀態',
                            'col1' => '剪髮',
                            'col2' => '染髮',
                            'col3' => '助染',
                            'col4' => '優染',
                            'col5' => '優助染',
                            'col6' => '洗髮',                          
                            'shampoo' =>'洗髮精',
                            'moment' =>'瞬護',
                            'isolation' =>'隔離',
                            'hair_oil' =>'髮油',
                            'lotion' =>'髮雕',
                            'perform' => '業績合計',
                            'rate' => '業績百分比',
                            'perform_rank'=>'業績排名',
            );      
        return $title;    
    }
    
     /**
     * 
     * @param type $row
     * @param type $asum
     * @return type
     */
    private function setRpt11RowData($row, $asum){
        
            // 剪髮 = A01 + S01 + S05
            $row['col1'] = 0;
            if(isset($asum['A01'])) $row['col1'] = $asum['A01'];
            if(isset($asum['S01'])) $row['col1'] = $row['col1'] + $asum['S01'];
            if(isset($asum['S05'])) $row['col1'] = $row['col1'] + $asum['S05'];
            
            // 染髮 = B01 + C01
            $row['col2'] = 0;
            if(isset($asum['B01'])) $row['col2'] = $asum['B01'];
            if(isset($asum['C01'])) $row['col2'] = $row['col2'] + $asum['C01'];

            // 助染 = B02 + C02
            $row['col3'] = 0;
            if(isset($asum['B02'])) $row['col3'] = $asum['B02'];
            if(isset($asum['C02'])) $row['col3'] = $row['col3'] + $asum['C02'];

            // 優染 = S03
            $row['col4'] = 0;
            if(isset($asum['S03'])) $row['col4'] = $asum['S03'];
            
            // 優助染 = S04
            $row['col5'] = 0;
            if(isset($asum['S04'])) $row['col5'] = $asum['S04'];
            
            // 洗髮 = D01 + S02 + S06
            $row['col6'] = 0;
            if(isset($asum['D01'])) $row['col6'] = $asum['D01'];
            if(isset($asum['S02'])) $row['col6'] = $row['col6'] + $asum['S02'];
            if(isset($asum['S06'])) $row['col6'] = $row['col6'] + $asum['S06'];     
            
            // 洗髮精 = N041 + N042 + N043
            $row['shampoo'] = 0;
            if(isset($asum['N041'])) $row['shampoo'] = $asum['N041'];
            if(isset($asum['N042'])) $row['shampoo'] = $row['shampoo'] + $asum['N042'];
            if(isset($asum['N043'])) $row['shampoo'] = $row['shampoo'] + $asum['N043'];
            
            // 髮油
            $row['hair_oil'] = 0;
            if(isset($asum['N051'])) $row['hair_oil'] = $asum['N051'];
            
            // 髮雕
            $row['lotion'] = 0;
            if(isset($asum['N052'])) $row['lotion'] = $asum['N052'];
                                  
            // 剪染燙
            $row['perform'] = $this->getPerform($asum);
            // 洗助
            $row['assist'] = $this->getAssist($asum);

            return $row;
    }
    
     /**
     * 取得期中業績
     * @param type $row
     * @param type $asum
     * @return type
     */
    private function setRpt11MidRowData($row, $asum){
        
            // 剪髮 = A01 + S01 + S05
            $row['midcol1'] = 0;
            if(isset($asum['MIDA01'])) $row['midcol1'] = $asum['MIDA01'];
            if(isset($asum['MIDS01'])) $row['midcol1'] = $row['midcol1'] + $asum['MIDS01'];
            if(isset($asum['MIDS05'])) $row['midcol1'] = $row['midcol1'] + $asum['MIDS05'];
            
            // 染髮 = B01 + C01
            $row['midcol2'] = 0;
            if(isset($asum['MIDB01'])) $row['midcol2'] = $asum['MIDB01'];
            if(isset($asum['MIDC01'])) $row['midcol2'] = $row['midcol2'] + $asum['MIDC01'];

            // 助染 = B02 + C02
            $row['midcol3'] = 0;
            if(isset($asum['MIDB02'])) $row['midcol3'] = $asum['MIDB02'];
            if(isset($asum['MIDC02'])) $row['midcol3'] = $row['midcol3'] + $asum['MIDC02'];

            // 優染 = S03
            $row['midcol4'] = 0;
            if(isset($asum['MIDS03'])) $row['midcol4'] = $asum['MIDS03'];
            
            // 優助染 = S04
            $row['midcol5'] = 0;
            if(isset($asum['MIDS04'])) $row['midcol5'] = $asum['MIDS04'];
            
            // 洗髮 = D01 + S02 + S06
            $row['midcol6'] = 0;
            if(isset($asum['MIDD01'])) $row['midcol6'] = $asum['MIDD01'];
            if(isset($asum['MIDS02'])) $row['midcol6'] = $row['midcol6'] + $asum['MIDS02'];
            if(isset($asum['MIDS06'])) $row['midcol6'] = $row['midcol6'] + $asum['MIDS06'];  
            
            // 髮油
            $row['midhair_oil'] = 0;
            if(isset($asum['MIDN051'])) $row['midhair_oil'] = $asum['MIDN051'];
            
            // 髮雕
            $row['midlotion'] = 0;
            if(isset($asum['MIDN052'])) $row['midlotion'] = $asum['MIDN052'];
                   
            // 剪染燙
            $row['midperform'] = $this->getMidPerform($asum);
            // 洗助
            $row['midassist'] = $this->getMidAssist($asum);

            return $row;
    }
    
     /**
     * 
     * @param type $row
     * @param type $asum
     * @return type
     */
    private function setRpt11Row_daily_Data($row, $asum){
        
            // 剪髮(含少收) = A01 + S01 + S05 + X01 + X07 + X10
            $row['col1'] = 0;
            if(isset($asum['A01'])) $row['col1'] = $asum['A01'];
            if(isset($asum['S01'])) $row['col1'] = $row['col1'] + $asum['S01'];
            if(isset($asum['S05'])) $row['col1'] = $row['col1'] + $asum['S05'];
            if(isset($asum['X01'])) $row['col1'] = $row['col1'] + $asum['X01'];
            if(isset($asum['X07'])) $row['col1'] = $row['col1'] + $asum['X07'];
            if(isset($asum['X10'])) $row['col1'] = $row['col1'] + $asum['X10'];
            
            // 染髮(含少收) = B01 + C01 + X03 + X04
            $row['col2'] = 0;
            if(isset($asum['B01'])) $row['col2'] = $asum['B01'];
            if(isset($asum['C01'])) $row['col2'] = $row['col2'] + $asum['C01'];
            if(isset($asum['X03'])) $row['col2'] = $row['col2'] + $asum['X03'];
            if(isset($asum['X04'])) $row['col2'] = $row['col2'] + $asum['X04'];

            // 助染 = B02 + C02
            $row['col3'] = 0;
            if(isset($asum['B02'])) $row['col3'] = $asum['B02'];
            if(isset($asum['C02'])) $row['col3'] = $row['col3'] + $asum['C02'];

            // 優染(含少收) = S03 + X09
            $row['col4'] = 0;
            if(isset($asum['S03'])) $row['col4'] = $asum['S03'];
            if(isset($asum['X09'])) $row['col4'] = $row['col4'] + $asum['X09'];
            
            // 優助染 = S04
            $row['col5'] = 0;
            if(isset($asum['S04'])) $row['col5'] = $asum['S04'];
            
            // 洗髮(含少收) = D01 + S02 + S06 + X02 + X08 + X11
            $row['col6'] = 0;
            if(isset($asum['D01'])) $row['col6'] = $asum['D01'];
            if(isset($asum['S02'])) $row['col6'] = $row['col6'] + $asum['S02'];
            if(isset($asum['S06'])) $row['col6'] = $row['col6'] + $asum['S06'];
            if(isset($asum['X02'])) $row['col6'] = $row['col6'] + $asum['X02'];            
            if(isset($asum['X08'])) $row['col6'] = $row['col6'] + $asum['X08'];            
            if(isset($asum['X11'])) $row['col6'] = $row['col6'] + $asum['X11']; 
            
             // 染膏 = N031 
            $row['col7'] = 0;
            if(isset($asum['N031'])) $row['col7'] = $asum['N031'];        
            
            // 洗髮精(含少收) = N041 + N042 + N043 + X12 + X13 + X14
            $row['shampoo'] = 0;
            if(isset($asum['N041'])) $row['shampoo'] = $asum['N041'];
            if(isset($asum['N042'])) $row['shampoo'] = $row['shampoo'] + $asum['N042'];
            if(isset($asum['N043'])) $row['shampoo'] = $row['shampoo'] + $asum['N043'];
            if(isset($asum['X12']))  $row['shampoo'] = $row['shampoo'] + $asum['X12'];
            if(isset($asum['X13']))  $row['shampoo'] = $row['shampoo'] + $asum['X13'];
            if(isset($asum['X14']))  $row['shampoo'] = $row['shampoo'] + $asum['X14'];
            
            // 瞬護 (含少收)= F07 + X26
            $row['moment'] = 0;
            if(isset($asum['F07'])) $row['moment'] = $asum['F07'];
            if(isset($asum['X26']))  $row['moment'] = $row['moment'] + $asum['X26'];
            
            // 隔離 (含少收)= F08 + X27
            $row['isolation'] = 0;
            if(isset($asum['F08'])) $row['isolation'] = $asum['F08'];
            if(isset($asum['X27']))  $row['isolation'] = $row['isolation'] + $asum['X27'];
            
             // 髮油(含少收) = N051 + X15
            $row['hair_oil'] = 0;
            if(isset($asum['N051'])) $row['hair_oil'] = $asum['N051'];
            if(isset($asum['X15'])) $row['hair_oil'] = $row['hair_oil'] + $asum['X15'];
            
            // 髮雕(含少收) = N052 +X16
            $row['lotion'] = 0;
            if(isset($asum['N052'])) $row['lotion'] = $asum['N052'];
            if(isset($asum['X16'])) $row['lotion'] = $row['lotion'] + $asum['X16'];
                                   
            return $row;
    }
    
     /**
     * 
     * @param type $row
     * @param type $asum
     * @return type
     */
    private function setRpt11Row_daily_Data2($row, $asum){
        
            // 剪髮 = A01 + S01 + S05
            $row['col1'] = 0;
            if(isset($asum['A01'])) $row['col1'] = $asum['A01'];
            if(isset($asum['S01'])) $row['col1'] = $row['col1'] + $asum['S01'];
            if(isset($asum['S05'])) $row['col1'] = $row['col1'] + $asum['S05'];
            
            // 染髮 = B01 + C01
            $row['col2'] = 0;
            if(isset($asum['B01'])) $row['col2'] = $asum['B01'];
            if(isset($asum['C01'])) $row['col2'] = $row['col2'] + $asum['C01'];

            // 助染 = B02 + C02
            $row['col3'] = 0;
            if(isset($asum['B02'])) $row['col3'] = $asum['B02'];
            if(isset($asum['C02'])) $row['col3'] = $row['col3'] + $asum['C02'];

            // 優染 = S03
            $row['col4'] = 0;
            if(isset($asum['S03'])) $row['col4'] = $asum['S03'];
            
            // 優助染 = S04
            $row['col5'] = 0;
            if(isset($asum['S04'])) $row['col5'] = $asum['S04'];
            
            // 洗髮 = D01 + S02 + S06
            $row['col6'] = 0;
            if(isset($asum['D01'])) $row['col6'] = $asum['D01'];
            if(isset($asum['S02'])) $row['col6'] = $row['col6'] + $asum['S02'];
            if(isset($asum['S06'])) $row['col6'] = $row['col6'] + $asum['S06'];     
            
            // 洗髮精 = N041 + N042 + N043
            $row['shampoo'] = 0;
            if(isset($asum['N041'])) $row['shampoo'] = $asum['N041'];
            if(isset($asum['N042'])) $row['shampoo'] = $row['shampoo'] + $asum['N042'];
            if(isset($asum['N043'])) $row['shampoo'] = $row['shampoo'] + $asum['N043'];
            
            // 瞬護
            $row['moment'] = 0;
            if(isset($asum['F07'])) $row['moment'] = $asum['F07'];
            
            // 隔離
            $row['isolation'] = 0;
            if(isset($asum['F08'])) $row['isolation'] = $asum['F08'];
            
            // 髮油
            $row['hair_oil'] = 0;
            if(isset($asum['N051'])) $row['hair_oil'] = $asum['N051'];
            
            // 髮雕
            $row['lotion'] = 0;
            if(isset($asum['N052'])) $row['lotion'] = $asum['N052'];
                                  
            // 剪染燙
            $row['perform'] = $this->getRpt11Perform($asum);
            
            return $row;
    }
    
    /**
     * 取得銷售業績
     * @param type $ary
     * @return int
     */
    private function getRpt11Perform($ary){
        
        $sum = 0;
        $service= TbsService::model()->findAllByAttributes(array(), 
            $conditon = " opt1 = 1 and price!=0 "
        );
       // CVarDumper::dump($service,10,true);
        
        if(count($service)>0)
            foreach ($service as $row) {
                $serviceno = $row->serviceno;
                if(isset($ary[$serviceno]))
                    $sum = $sum + $ary[$serviceno] * $row->price;
            }
        return $sum;
    }
    
     /**
     * 取得販賣金額(染膏燙劑)
     * 門市販賣.沒有設計師抽成的商品
     * @param type $ary = array ('N011'=>1, 'N012'=>1);
     * @return int
     */
    public function getRpt11MoneySellandReduce($ary){
         $str['sum']=0;
         $str['sum2']=0;
         $str['item']='';
         $str['item2']='';
         $service= TbsService::model()->findAllByAttributes(array(), 
            $conditon = " type1 =4 and price!=0 "
        );
        if(count($service)>0)
            foreach ($service as $row) {
                if(isset($ary[$row->serviceno]))
                    if($row->price!=0){
                    $str['sum'] = $str['sum'] + $ary[$row->serviceno] * $row->price;
                    $str['item'].=$row->cname.':'.$ary[$row->serviceno];
                    }
            }
         $service2 = TbsService::model()->findAllByAttributes(array('type1'=>'5')); 
         
         if(count($service2)>0){
            foreach ($service2 as $row) {
                if(isset($ary[$row->serviceno])){
//                    print_r ($row->serviceno.' '.$row->noreceive.'<br>');
                    $data = TbsService::model()->findByAttributes(array('serviceno'=>$row->noreceive));
                    if($data!=NULL){
                        $str['sum'] = $str['sum'] + $ary[$row->serviceno] * $data->price;
                        $str['item'].='少收'.$data->cname.':'.$ary[$row->serviceno];
                    }
                }
            }//foreach ($service2 as $row) {
         }//if(count($service2)>0){
         
         $service3 = TbsService::model()->findAllByAttributes(array('type1'=>'6')); 
         
         if(count($service3)>0){
            foreach ($service3 as $row) {
                if(isset($ary[$row->serviceno])){
//                    print_r ($row->serviceno.' '.$row->noreceive.'<br>');
                    $data = TbsService::model()->findByAttributes(array('serviceno'=>$row->serviceno));
                    if($data!=NULL){
                        $str['sum2'] = $str['sum2'] + $ary[$row->serviceno] * $data->chgprice;
                        $str['item2'].='優待票'.$data->cname.':'.$ary[$row->serviceno];
                    }
                }
            }//foreach ($service3 as $row) {
         }//if(count($service3)>0){
                      
        return $str;
    }
    
    /**
     * 
     * @param type $colAry
     * @return string array() 
     */
    private function getTotal($colAry){
        
    $total = array();
    
        $total['col1'] = 0;
        $total['col2'] = 0;
        $total['col3'] = 0;
        $total['col4'] = 0;
        $total['col5'] = 0;
        $total['col6'] = 0;
        $total['shampoo'] = 0;
        $total['hair_oil'] = 0;
        $total['lotion'] = 0;
        $total['perform'] = 0;
        $total['assist'] = 0;
        $total['rate'] = 0;
        for ($j = 0; $j < count($colAry); $j++) {
            //剪髮總數
            $total['col1'] = $total['col1']+$colAry[$j]['col1'];
            //染髮總數
            $total['col2'] = $total['col2']+$colAry[$j]['col2'];
            //助染總數
            $total['col3'] = $total['col3']+$colAry[$j]['col3'];
             //優染總數
            $total['col4'] = $total['col4']+$colAry[$j]['col4'];
             //優助染總數
            $total['col5'] = $total['col5']+$colAry[$j]['col5'];
             //洗髮總數
            $total['col6'] = $total['col6']+$colAry[$j]['col6'];
            //洗髮精總數
            $total['shampoo'] = $total['shampoo']+$colAry[$j]['shampoo'];
            //髮油總數
            $total['hair_oil'] = $total['hair_oil']+$colAry[$j]['hair_oil'];
            //髮雕總數
            $total['lotion'] = $total['lotion']+$colAry[$j]['lotion'];
            //業績總數
            $total['perform'] = $total['perform']+$colAry[$j]['perform'];
            //洗助
            $total['assist'] = $total['assist']+$colAry[$j]['assist'];
            //期末達成率       
            $total['rate']=($total['rate']+$colAry[$j]['rate']);       
        }   
        if( $total['rate']>0 ){
         $total['rate']=round( $total['rate'] / count($colAry),2);
         $total['rate'] =  $total['rate'] . "%";
        }
        return $total;
    }
    
   public function actionRpt13(){
        //用以計算開始/結束時間之變數
        $time_start = microtime(true);
       
        //查詢的年月
        $qry_date = date('Ym');
        //區域
        $qry_area = "";
        //門市
        $qry_store = ""; 
        
        //顯示銷售情報
        $check_area = 0;
          
        if(isset($_GET['area']) && isset($_GET['pdate'])){               

            Yii::app()->session['area'] = $_GET['area'];
            Yii::app()->session['pdate'] = $_GET['pdate'];
            $this->redirect(array('rpt13'));//跳轉回rpt13頁面
        }else
            {      
                if(isset($_POST['qry_date']))         $qry_date = $_POST['qry_date'];
                if(isset($_POST['qry_area']))         $qry_area = $_POST['qry_area'];    
                if(isset($_POST['qry_store']))        $qry_store = $_POST['qry_store'];
                if(isset($_POST['check_area']))           $check_area = $_POST['check_area']; 
                
                    if(Yii::app()->session['area']!='' && Yii::app()->session['pdate']!=''){
                        $qry_area=Yii::app()->session['area'];
                        $qry_date=Yii::app()->session['pdate'];

                        //沒使用到清空
                        unset(Yii::app()->session['area']);
                        unset(Yii::app()->session['pdate']);
                    }         
            }
                             
        //切割出年份
        $tmp_year=substr($qry_date,0,4);
        //切割出月份
        $tmp_mon =substr($qry_date,4,2);
       
        //所選擇當月的前一個月
        $last_month = date("Ym", mktime(24, 0, 0, $tmp_mon-1, 0, $tmp_year));
        
        //所選擇當月的去年同個月
        $ly_same_month = date("Ym", mktime(24, 0, 0, $tmp_mon-12, 0, $tmp_year));
       
         // 取得欄位  
        $col = $this->getRpt13Col($check_area);
        // 取得表頭   
        $title = $this->getRpt13Title();
        
        // 輸出在畫面上的陣列
        $colAry = array();
        
        // 門市. 門市ID
        $storeAry = array();
        $storeAreaId = array();
        $TbsStores = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsStores as $store) {
            $storeAry[$store->storecode] = $store->storename;
            $storeAreaId[$store->storecode] = $store->area_id;
        }        
        unset($TbsStores);       
        // 區域
        $areaAry = array();
        $TbsAreas = TbsArea::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsAreas as $area) {
            $areaAry[$area->id] = $area->areaname;
        }
        unset($TbsAreas);           
           
      
         //如果有選門市,就只選出那一家門市
        if($qry_store != ''){
            $tbsStroes = TbsStore::model()->findAllByAttributes(array('storecode'=>$qry_store));        
        //如果只選區域,就選出區域內的所有門市
        }elseif($qry_area != ''){
            $tbsStroes = TbsStore::model()->findAllByAttributes(array('area_id'=>$qry_area));        
        //如果都沒有選,就全部選出來
        }else{
            $tbsStroes = TbsStore::model()->findAll();       
             }
        
        // 儲存篩選出的門市的店編
        $sqlStroe = array();
        foreach ($tbsStroes as $store) {
               //找出篩選出的門市的區域代碼
               $area = TbsArea::model()->findByPK($store->area_id);
               if($area!=NULL){
                   //push店編
                   array_push($sqlStroe, $store->storecode);
               }
        }
           
        //刪除區域重複值
        $unique_result = array_unique($storeAreaId);
        //排序
        sort($unique_result);
        //區域ID陣列轉字串，為了sql in查詢使用
        $_str = " ' ".implode(" ',' ",$unique_result)." ' ";      
        
        //區排名array
        $area_rank_Ary = array(); 
        $sql_area='';
        //查詢全部區排名SQL  
        $sql_area = "SELECT  c.storecode,c.storename , c.total, COUNT(d.total) area_rank  from (SELECT  mid(a.pdate,1,6) AS pdate,a.storecode,a.storename,sum(a.total) as total,sum(a.output) as output,b.area_id 
        FROM tbp_perform AS a INNER JOIN tbs_store AS b 
        ON a.storename=b.storename
        WHERE mid(a.pdate,1,6)=$qry_date
                      and b.area_id in ($_str)
        GROUP BY a.storename) c , 
        (SELECT  mid(a.pdate,1,6) AS pdate,a.storecode,a.storename,sum(a.total) as total,sum(a.output) as output,b.area_id 
        FROM tbp_perform AS a INNER JOIN tbs_store AS b 
        ON a.storename=b.storename

        WHERE mid(a.pdate,1,6)=$qry_date
                      and b.area_id in ($_str)
        GROUP BY a.storename) d

        WHERE (c.total< d.total and c.area_id=d.area_id) OR (c.total=d.total AND c.storename = d.storename ) 
        GROUP BY c.area_id , c.storename, c.total 
        ORDER BY c.area_id , c.total DESC, c.storename DESC;";

        $area_result = Yii::app()->db->createCommand($sql_area)->queryAll();
 
        if($area_result>0){               
               foreach ($area_result as $rank) {
                   $area_rank_Ary[$rank['storecode']] = $rank['area_rank'];

               }
               unset($area_result);           
        }
        
        //全部排名array
        $all_rank_Ary = array(); 
        //門市業績array
        $perform_Ary = array(); 
        //門市支出array
        $output_Ary = array(); 
        $sql_all='';
        
        $sql_all= "SELECT  c.storecode,c.storename , c.total,c.output, COUNT(d.total) all_rank  from (SELECT  mid(a.pdate,1,6) AS pdate,a.storecode,a.storename,sum(a.total) as total,sum(a.output) as output,b.area_id 
            FROM tbp_perform AS a INNER JOIN tbs_store AS b 
            ON a.storename=b.storename

            WHERE mid(a.pdate,1,6)=$qry_date

            GROUP BY a.storename) c , (SELECT  mid(a.pdate,1,6) AS pdate,a.storecode,a.storename,sum(a.total) as total,sum(a.output) as output,b.area_id 
            FROM tbp_perform AS a INNER JOIN tbs_store AS b 
            ON a.storename=b.storename

            WHERE mid(a.pdate,1,6)=$qry_date

            GROUP BY a.storename) d

            WHERE c.total< d.total OR (c.total=d.total AND c.storename = d.storename ) 
            GROUP BY c.storename, c.total 
            ORDER BY c.total DESC, c.storename DESC;";
        
        $all_result = Yii::app()->db->createCommand($sql_all)->queryAll();
 
        if($all_result>0){               
               foreach ($all_result as $rank) {
                   $all_rank_Ary[$rank['storecode']] = $rank['all_rank'];
                   $perform_Ary[$rank['storecode']] = $rank['total'];
                   $output_Ary[$rank['storecode']] = $rank['output'];
               }
               unset($all_result);           
        }
        
        //前月門市業績array
        $last_perform_Ary = array(); 
        //前月門市支出array
        $last_output_Ary = array(); 
        //上個月門市業績及支出SQL
         $last_total_output_sql='';
         $last_total_output_sql="SELECT mid(pdate,1,6) as pdate ,storecode , storename , SUM( total ) as total , SUM( output) as output  FROM  tbp_perform 
                                WHERE  mid(pdate,1,6) =$last_month 
                                GROUP BY   `storecode` 
                                ORDER BY  `storecode` ASC ,  `pdate` ASC";
         
         $last_total_output_result = Yii::app()->db->createCommand($last_total_output_sql)->queryAll();
         
         if($last_total_output_result>0){
              foreach ($last_total_output_result as $value) {                
                   $last_perform_Ary[$value['storecode']] = $value['total'];
                   $last_output_Ary[$value['storecode']] = $value['output'];
               }
               unset($last_total_output_result);             
         } 
         
        //去年同月門市業績array
        $ly_perform_Ary = array(); 
        //去年同月門市支出array
        $ly_output_Ary = array();
        //去年同月門市業績及支出SQL
        $ly_total_output_sql='';
        $ly_total_output_sql="SELECT mid(pdate,1,6) as pdate ,storecode , storename , SUM( total ) as total , SUM( output) as output  FROM  tbp_perform 
                                WHERE  mid(pdate,1,6) =$ly_same_month 
                                GROUP BY   `storecode` 
                                ORDER BY  `storecode` ASC ,  `pdate` ASC";
         
         $ly_total_output_result = Yii::app()->db->createCommand($ly_total_output_sql)->queryAll();
       
         if($ly_total_output_result>0){
              foreach ($ly_total_output_result as $value) {                
                   $ly_perform_Ary[$value['storecode']] = $value['total'];
                   $ly_output_Ary[$value['storecode']] = $value['output'];
               }
               unset($ly_total_output_result);             
         }       
      
        // 查詢用的SQL
        $qryStr = '';          

        //如果有選門市或區域就需要sql=AND storecode in('007001',007002')  
        if($qry_store != '' OR $qry_area != '') {
            //sql=sql.in('007001')因為只有一筆的時候沒有' , '  所以直接把店編放進去
            if(count($sqlStroe)>0) {
//                    $qryStr = " AND storecode in ('$sqlStroe[0]'";
                $qryStr = " storecode in ('$sqlStroe[0]'";
                //如果門市>1,就需要' , '
                if(count($sqlStroe)>1)
                    for ($i = 1; $i < count($sqlStroe); $i++) {
                        $qryStr = $qryStr.",'$sqlStroe[$i]'";
                    }
                $qryStr = $qryStr.")";           
            }
        }else{
                //沒選區域、門市，全部查詢出來            
                if(count($sqlStroe)>0) {
    //                    $qryStr = " AND storecode in ('$sqlStroe[0]'";
                    $qryStr = " storecode in ('$sqlStroe[0]'";
                    //如果門市>1,就需要' , '
                    if(count($sqlStroe)>1)
                        for ($i = 1; $i < count($sqlStroe); $i++) {
                            $qryStr = $qryStr.",'$sqlStroe[$i]'";
                        }
                    $qryStr = $qryStr.")";
            
                }                            
            }         
                    
        $empAry = array();
        $last_shampoo_Ary = array();     
        $sql = ''; 
        $sql2 = '';
        $sql3 = '';
        $sql4 = '';
       
        if(isset($_POST['qry']) OR ($qry_area!='' && $qry_date!='')){ //OR $qry_store!='' && $qry_date!='' 為了GET
                    
         //算剪、洗、助等....   tbp_perform_emp_log
        $sql = "(SELECT storecode , mid(pdate,1,6) AS pdate  , storename ,serviceno, sum(num) AS amount FROM tbp_perform_emp_log
            WHERE mid(pdate,1,6)=$qry_date  and $qryStr
            GROUP BY serviceno , storename
            ORDER BY  storename  , serviceno ) ";
        
        //算剪、洗、助等....  tbp_perform_log
        $sql2 = "(SELECT storecode , mid(pdate,1,6) AS pdate  , storename ,serviceno, sum(num) AS amount FROM tbp_perform_log
            WHERE mid(pdate,1,6)=$qry_date  and $qryStr and num!=0
            GROUP BY serviceno , storename
            ORDER BY  storename  , serviceno ) ";
          
          $sql=$sql."UNION".$sql2;  //合併
          $sql = $sql. "order by  storecode, serviceno";
  
        $result = Yii::app()->db->createCommand($sql)->queryAll();
      
         //前個月=>算剪、洗、助等....   tbp_perform_emp_log
        $sql3 = "(SELECT storecode , mid(pdate,1,6) AS pdate  , storename ,serviceno, sum(num) AS amount FROM tbp_perform_emp_log
            WHERE mid(pdate,1,6)=$last_month  and $qryStr
            GROUP BY serviceno , storename
            ORDER BY  storename  , serviceno ) ";
        
        //前個月=>算剪、洗、助等....   tbp_perform_log
        $sql4 = "(SELECT storecode , mid(pdate,1,6) AS pdate  , storename ,serviceno, sum(num) AS amount FROM tbp_perform_log
            WHERE mid(pdate,1,6)=$last_month  and $qryStr   and num!=0
            GROUP BY serviceno , storename
            ORDER BY  storename  , serviceno ) ";
        
         $sql3=$sql3."UNION".$sql4;  //合併
         $sql3 = $sql3. "order by  storecode, serviceno";
        
        $last_result = Yii::app()->db->createCommand($sql3)->queryAll();
        //  CVarDumper::dump($result,10,true);
        if($last_result>0){
             foreach ($last_result as $last_storeData) {  
                  $row = array(); 
                    // 門市編號
                    $row['storecode'] = $last_storeData['storecode'];
                    // 門市名稱
                    $row['storename'] = $last_storeData['storename'];
                    // 服務項目
                    $row['serviceno'] =  $last_storeData['serviceno'];
                    //數量
                    $row['amount'] =  $last_storeData['amount'];
                     array_push($last_shampoo_Ary, $row);
             }
        }
          $last_shampoo_Ary = $this->setlastStoreAry($last_shampoo_Ary);
          
          //紀錄前個月洗髮精數量
           $shampoo = array();
          //紀錄前個月髮油數量
           $hair_oil = array();
          //紀錄前個月髮雕數量
           $lotion = array();
          foreach ($last_shampoo_Ary as $key => $storeData) {
               $row = array();
                // 洗髮精(含少收) = N041 + N042 + N043 + X12 + X13 + X14
                $row['shampoo'] = 0;
                if(isset($storeData['N041'])) $row['shampoo'] = $storeData['N041'];
                if(isset($storeData['N042'])) $row['shampoo'] = $row['shampoo'] + $storeData['N042'];
                if(isset($storeData['N043'])) $row['shampoo'] = $row['shampoo'] + $storeData['N043'];
                if(isset($storeData['X12']))  $row['shampoo'] = $row['shampoo'] + $storeData['X12'];
                if(isset($storeData['X13']))  $row['shampoo'] = $row['shampoo'] + $storeData['X13'];
                if(isset($storeData['X14']))  $row['shampoo'] = $row['shampoo'] + $storeData['X14'];              
                          
                $shampoo[$storeData['storecode']] = $row['shampoo'];
                
                // 髮油(含少收)
                $row['hair_oil'] = 0;
                if(isset($storeData['N051'])) $row['hair_oil'] = $storeData['N051'];
                if(isset($storeData['X15'])) $row['hair_oil'] = $row['hair_oil'] + $storeData['X15'];
                
                $hair_oil[$storeData['storecode']] = $row['hair_oil'];
                
                // 髮雕(含少收)
                $row['lotion'] = 0;
                if(isset($storeData['N052'])) $row['lotion'] = $storeData['N052'];
                if(isset($storeData['X16'])) $row['lotion'] = $row['lotion'] + $storeData['X16'];
                
                $lotion[$storeData['storecode']] = $row['lotion'];
          }
         
        if($result>0){
            foreach ($result as $storeData) {           
                   $row = array(); 
                     // 日期
                     $row['pdate'] = $storeData['pdate'];
                     // 營業區ID
                     $row['areaid'] = $storeAreaId[$storeData['storecode']]; 
                     // 營業區
                     $row['area'] = $areaAry[$storeAreaId[$storeData['storecode']]]; 
                     // 門市編號
                     $row['storecode'] = $storeData['storecode'];
                     // 門市名稱
                     $row['storename'] = $storeData['storename'];
                     // 服務項目
                     $row['serviceno'] =  $storeData['serviceno'];
                     //數量
                     $row['amount'] =  $storeData['amount'];                                              

                     array_push($empAry, $row);                   
            }
        }
        $empAry = $this->setStoreAry($empAry);  
        //  CVarDumper::dump($empAry,10,true);
         unset($result);
                         
        }
        
        foreach ($empAry as $key => $storeData) {
 
               $row = array();
              
               // 年月
               $row['ym'] = $qry_date;
               // 營業區ID
               $row['areaid'] =$storeData['areaid'];
               // 營業區
               $row['area'] =$storeData['area'];
               // 門市編號
               $row['storecode'] = $storeData['storecode'];
               // 門市
               $row['store'] = $storeData['storename'];
            
               // 設定各欄位業績算法及總金額、總支出
               $row = $this->setRpt13RowData($row,$storeData);
               
               // 門市業績
               $row['perform'] =isset($perform_Ary[$storeData['storecode']]) ? (float)$perform_Ary[$storeData['storecode']] : ''; 
               
               // 同期門市業績
               $row['same_period'] =isset($ly_perform_Ary[$storeData['storecode']]) ? (float)$ly_perform_Ary[$storeData['storecode']] : ''; 
               
               // 支出
               $row['output'] = isset($output_Ary[$storeData['storecode']]) ? (float)$output_Ary[$storeData['storecode']] : '';  
               
               // 區域排名
               $row['area_rank'] =isset($area_rank_Ary[$storeData['storecode']]) ? $area_rank_Ary[$storeData['storecode']] : '';  
               // 全部排名
               $row['all_rank'] =isset($all_rank_Ary[$storeData['storecode']]) ? $all_rank_Ary[$storeData['storecode']] : '';
               //業績成長
               $row['perform_grow_up'] = isset($last_perform_Ary[$storeData['storecode']]) ? $row['perform'] -  $last_perform_Ary[$storeData['storecode']] : '';
               //支出成長
               $row['output_grow_up'] = isset($last_output_Ary[$storeData['storecode']]) ? $row['output'] -  $last_output_Ary[$storeData['storecode']] :''; 
               
               //洗髮精成長
               $row['shampoo_grow_up'] = isset($shampoo[$storeData['storecode']]) ? $row['shampoo'] -  $shampoo[$storeData['storecode']] :'';  
               
               //髮油成長
               $row['hair_oil_grow_up'] = isset($hair_oil[$storeData['storecode']]) ? $row['hair_oil'] -  $hair_oil[$storeData['storecode']] :'';
               
               //髮雕成長
               $row['lotion_grow_up'] = isset($lotion[$storeData['storecode']]) ? $row['lotion'] -  $lotion[$storeData['storecode']] :'';
               
               array_push($colAry, $row);
             
       }
          
       unset($empAry);
       
        //二維陣列比較函數，以區域ID排序
       function score_sort($a, $b){
                //要排序的值
                if($a['areaid'] == $b['areaid']) return 0;

                return ($a['areaid'] > $b['areaid']) ? 1 : -1;

       }
       
        //usort(要排序的陣列,使用的函數)
        usort($colAry, 'score_sort');
                  
       if(isset($_POST['qry']) OR ($qry_area!='' && $qry_date!='') ){
            if(count($colAry)<1)
                Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')."查無,$qry_date 月的業績資料");
            else
                Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success')."查詢成功. 共計 ".count($colAry)." 筆資料");
        }
    
      // CVarDumper::dump($colAry,10,true);
       
        $time_end = microtime(true);
        $computetime = round(($time_end - $time_start),3);
          
         $this->render('rpt13',array(                    
             'qry_date'=>$qry_date,
             'qry_area'=>$qry_area,
             'qry_store'=>$qry_store, 
             'check_area'=>$check_area,
             'col'=>$col,
             'title'=>$title,
             'colAry'=>$colAry,
             'computetime'=>$computetime,
         ));
        
    }
    
     /**
    * 
    * @return string
    */
    private function getRpt13Col($check_area){
        
         if($check_area){
            $col = array( 0 => 'ym',
                                1 => 'area',
                                2 => 'store',                        
                                3 =>  'col1', //剪髮
                                4 => 'col2', //染髮
                                5 => 'col3', //助染
                                6 => 'col4', //優染
                                7 => 'col5', //優助染
                                8 => 'col6', //洗髮
                                9 => 'shampoo', //洗髮精
                                10 =>'hair_oil',//髮油
                                11 =>'lotion',//髮雕
                                12 => 'perform', //門市業績
                                13=>'same_period',//同期業績
                                14 => 'output', //支出                         
                                15 => 'area_rank', //區排名 
                                16 => 'all_rank', //總排名
                                17 => 'perform_grow_up', //業績成長                         
                                18 => 'output_grow_up',//支出成長 
                                19 => 'shampoo_grow_up',//洗髮精成長 
                                20 => 'hair_oil_grow_up',//髮油成長
                                21 => 'lotion_grow_up',//髮雕成長
                    );     
         }else{
              $col = array( 0 => 'ym',
                                1 => 'area',
                                2 => 'store',                                                     
                                3 => 'perform', //門市業績
                                4=>'same_period',//同期業績
                                5 => 'output', //支出                         
                                6 => 'area_rank', //區排名 
                                7 => 'all_rank', //總排名
                                8 => 'perform_grow_up', //業績成長                         
                                9 => 'output_grow_up',//支出成長 
                                10 => 'shampoo_grow_up',//洗髮精成長
                                11 => 'hair_oil_grow_up',//髮油成長
                                12 => 'lotion_grow_up',//髮油雕成長
                    );     
             
              }
        return $col;
    }
    
    /**
     *   
     * @return string
     */
    private function getRpt13Title(){
       
        $title = array('ym' => '年月',
                            'area' => '營業區',
                            'store' => '分店',                         
                            'col1' => '剪髮',
                            'col2' => '染髮',
                            'col3' => '助染',
                            'col4' => '優染',
                            'col5' => '優助染',
                            'col6' => '洗髮',
                            'shampoo' => '洗髮精',
                            'hair_oil' =>'髮油' ,
                            'lotion' =>'髮雕' ,
                            'perform' => '門市業績',
                            'same_period'=>'同期業績',
                            'output' => '支出',                         
                            'area_rank' => '區內排名',
                            'all_rank' => '總排名',
                            'perform_grow_up' => '業績成長',
                            'output_grow_up' => '支出成長',  
                            'shampoo_grow_up' => '洗髮精成長',
                            'hair_oil_grow_up' => '髮油成長',
                            'lotion_grow_up' => '髮雕成長',
            );      
        return $title;    
    }
    
     // 設定整月服務項目放一起
    private function setStoreAry($result) {
        
        $storeAry = array();
        $store = array();
        
        if(count($result)>0) {
            
            $storecode = $result[0]['storecode']; 

            for ($i = 0; $i < count($result); $i++) {

                if($storecode == $result[$i]['storecode']){
                    $store['pdate'] = $result[$i]['pdate'];
                    $store['areaid'] = $result[$i]['areaid']; 
                    $store['area'] = $result[$i]['area'];
                    $store['storecode'] = $result[$i]['storecode'];
                    $store['storename'] = $result[$i]['storename'];
                    $store[$result[$i]['serviceno']] = $result[$i]['amount'];
                  
                }else{
                    $storeAry[$storecode] = $store;
                    $store = array();
                    $storecode = $result[$i]['storecode'];
                    /*------*/
                    $store['pdate'] = $result[$i]['pdate'];
                    $store['areaid'] = $result[$i]['areaid']; 
                    $store['area'] = $result[$i]['area'];
                    $store['storecode'] = $result[$i]['storecode'];
                    $store['storename'] = $result[$i]['storename'];
                    $store[$result[$i]['serviceno']] = $result[$i]['amount'];
                
                }
            }

            $storeAry[$storecode] = $store;
        }        
        return $storeAry;
    }
    
    // 設定前月洗髮精服務項目放一起
    private function setlastStoreAry($result) {
        
         $storeAry = array();
        $store = array();
        
        if(count($result)>0) {
            
            $storecode = $result[0]['storecode']; 

            for ($i = 0; $i < count($result); $i++) {

                if($storecode == $result[$i]['storecode']){                  
                    $store['storecode'] = $result[$i]['storecode'];
                    $store['storename'] = $result[$i]['storename'];
                    $store[$result[$i]['serviceno']] = $result[$i]['amount'];                  
                }else{
                    $storeAry[$storecode] = $store;
                    $store = array();
                    $storecode = $result[$i]['storecode'];
                    /*------*/                  
                    $store['storecode'] = $result[$i]['storecode'];
                    $store['storename'] = $result[$i]['storename'];
                    $store[$result[$i]['serviceno']] = $result[$i]['amount'];                
                }
            }

            $storeAry[$storecode] = $store;
        }        
        return $storeAry;                                                 
    }
       
    /**
     * 
     * @param type $row
     * @param type $asum
     * @return type
     */
    private function setRpt13RowData($row, $asum){
        
            // 剪髮(含少收) = A01 + S01 + S05 + X01 + X07 + X10
            $row['col1'] = 0;
            if(isset($asum['A01'])) $row['col1'] = $asum['A01'];
            if(isset($asum['S01'])) $row['col1'] = $row['col1'] + $asum['S01'];
            if(isset($asum['S05'])) $row['col1'] = $row['col1'] + $asum['S05'];
            if(isset($asum['X01'])) $row['col1'] = $row['col1'] + $asum['X01'];
            if(isset($asum['X07'])) $row['col1'] = $row['col1'] + $asum['X07'];
            if(isset($asum['X10'])) $row['col1'] = $row['col1'] + $asum['X10'];
            
             // 染髮(含少收) = B01 + C01 + X03 + X04
            $row['col2'] = 0;
            if(isset($asum['B01'])) $row['col2'] = $asum['B01'];
            if(isset($asum['C01'])) $row['col2'] = $row['col2'] + $asum['C01'];
            if(isset($asum['X03'])) $row['col2'] = $row['col2'] + $asum['X03'];
            if(isset($asum['X04'])) $row['col2'] = $row['col2'] + $asum['X04'];

            // 助染 = B02 + C02
            $row['col3'] = 0;
            if(isset($asum['B02'])) $row['col3'] = $asum['B02'];
            if(isset($asum['C02'])) $row['col3'] = $row['col3'] + $asum['C02'];

            // 優染(含少收) = S03 + X09
            $row['col4'] = 0;
            if(isset($asum['S03'])) $row['col4'] = $asum['S03'];
            if(isset($asum['X09'])) $row['col4'] = $row['col4'] + $asum['X09'];
            
            // 優助染 = S04
            $row['col5'] = 0;
            if(isset($asum['S04'])) $row['col5'] = $asum['S04'];
            
            // 洗髮(含少收) = D01 + S02 + S06 + X02 + X08 + X11
            $row['col6'] = 0;
            if(isset($asum['D01'])) $row['col6'] = $asum['D01'];
            if(isset($asum['S02'])) $row['col6'] = $row['col6'] + $asum['S02'];
            if(isset($asum['S06'])) $row['col6'] = $row['col6'] + $asum['S06'];
            if(isset($asum['X02'])) $row['col6'] = $row['col6'] + $asum['X02'];            
            if(isset($asum['X08'])) $row['col6'] = $row['col6'] + $asum['X08'];            
            if(isset($asum['X11'])) $row['col6'] = $row['col6'] + $asum['X11']; 
            
            // 洗髮精(含少收) = N041 + N042 + N043 + X12 + X13 + X14
            $row['shampoo'] = 0;
            if(isset($asum['N041'])) $row['shampoo'] = $asum['N041'];
            if(isset($asum['N042'])) $row['shampoo'] = $row['shampoo'] + $asum['N042'];
            if(isset($asum['N043'])) $row['shampoo'] = $row['shampoo'] + $asum['N043'];
            if(isset($asum['X12']))  $row['shampoo'] = $row['shampoo'] + $asum['X12'];
            if(isset($asum['X13']))  $row['shampoo'] = $row['shampoo'] + $asum['X13'];
            if(isset($asum['X14']))  $row['shampoo'] = $row['shampoo'] + $asum['X14'];
                                  
            // 髮油(含少收) = N051 + X15
            $row['hair_oil'] = 0;
            if(isset($asum['N051'])) $row['hair_oil'] = $asum['N051'];
            if(isset($asum['X15'])) $row['hair_oil'] = $row['hair_oil'] + $asum['X15'];
            
            // 髮雕(含少收) = N052 +X16
            $row['lotion'] = 0;
            if(isset($asum['N052'])) $row['lotion'] = $asum['N052'];
            if(isset($asum['X16'])) $row['lotion'] = $row['lotion'] + $asum['X16'];
            
            
            // 門市業績
        //    $row['perform'] = (float)$asum['total'];
            // 支出
         //   $row['output'] = (float)$asum['output'];

            return $row;
    }
    
    public function actionRpt14(){
        //用以計算開始/結束時間之變數
        $time_start = microtime(true);
              
        //查詢的年月
        $qry_date = date('Ym');
        //區域
        $qry_area = "";
        
        //顯示銷售情報
        $check_all = 0;
                   
        if(isset($_POST['qry_date']))         $qry_date = $_POST['qry_date'];
        if(isset($_POST['qry_area']))         $qry_area = $_POST['qry_area'];
        if(isset($_POST['check_all']))         $check_all = $_POST['check_all'];
        
        // 取得欄位  
        $col = $this->getRpt14Col($check_all);
        // 取得表頭   
        $title = $this->getRpt14Title();
        
        // 輸出在畫面上的陣列
        $colAry = array();
        
        // 門市. 門市ID
        $storeAry = array();
        $storeAreaId = array();
        $TbsStores = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsStores as $store) {
            $storeAry[$store->storecode] = $store->storename;
            $storeAreaId[$store->storecode] = $store->area_id;
        }        
        unset($TbsStores);       
        // 區域
        $areaAry = array();
        $TbsAreas = TbsArea::model()->findAllByAttributes(array('opt1'=>1));
        foreach ($TbsAreas as $area) {
            $areaAry[$area->id] = $area->areaname;
        }
        unset($TbsAreas);           
                         
        //刪除區域重複值
        $unique_result = array_unique($storeAreaId);
        //排序
        sort($unique_result);
        //區域ID陣列轉字串，為了sql in查詢使用
        $_str = " ' ".implode(" ',' ",$unique_result)." ' "; 
        
        //各區排名array
        $area_rank_Ary = array(); 
        //各區業績array
        $area_perform_Ary = array(); 
        //各區支出array
        $area_output_Ary = array(); 
        $sql='';
        
        $sql= "SELECT  c.area_id , c.total,c.output, COUNT(d.total) rank  from (SELECT  mid(a.pdate,1,6) AS pdate,b.area_id ,sum(a.total) as total,sum(a.output) as output
            FROM tbp_perform AS a INNER JOIN tbs_store AS b 
            ON a.storename=b.storename
            WHERE mid(a.pdate,1,6)=$qry_date
            and b.area_id in ($_str)

            GROUP BY b.area_id) c , (SELECT  mid(a.pdate,1,6) AS pdate,b.area_id ,sum(a.total) as total,sum(a.output) as output
            FROM tbp_perform AS a INNER JOIN tbs_store AS b 
            ON a.storename=b.storename
            WHERE mid(a.pdate,1,6)=$qry_date
            and b.area_id in ($_str)

            GROUP BY b.area_id) d

            WHERE c.total< d.total OR (c.total=d.total AND c.area_id= d.area_id) 
            GROUP BY c.area_id, c.total 
            ORDER BY c.total DESC, c.area_id DESC;";
        
        $all_result = Yii::app()->db->createCommand($sql)->queryAll();

        if($all_result>0){               
               foreach ($all_result as $value) {
                   $area_rank_Ary[$value['area_id']] = $value['rank'];
                   $area_perform_Ary[$value['area_id']] = $value['total'];
                   $area_output_Ary[$value['area_id']] = $value['output'];
               }
               unset($all_result);           
        }
        
              
         //切割出年份
        $tmp_year=substr($qry_date,0,4);
        //切割出月份
        $tmp_mon =substr($qry_date,4,2);
       
        //所選擇當月的前一個月
        $last_month = date("Ym", mktime(24, 0, 0, $tmp_mon-1, 0, $tmp_year));
        
        //所選擇當月的去年同個月
        $ly_same_month = date("Ym", mktime(24, 0, 0, $tmp_mon-12, 0, $tmp_year));
       
         //前月區業績array
        $last_region_total = array(); 
        //前月區支出array
        $last_region_output = array(); 
        //上個月區業績及支出SQL
         $regin_sql='';
         $regin_sql="SELECT  mid(a.pdate,1,6) AS pdate,b.area_id ,sum(a.total) as total,sum(a.output) as output
                    FROM tbp_perform AS a INNER JOIN tbs_store AS b 
                        ON a.storename=b.storename
                        WHERE mid(a.pdate,1,6)=$last_month
                        and b.area_id in ($_str)
                        GROUP BY b.area_id";
         
         $last_region_result = Yii::app()->db->createCommand($regin_sql)->queryAll();
         
         if($last_region_result>0){
              foreach ($last_region_result as $value) {                
                   $last_region_total[$value['area_id']] = $value['total'];
                   $last_region_output[$value['area_id']] = $value['output'];
              }
               unset($last_region_result);             
         } 
         
        //去年同月區業績array
        $ly_region_total = array(); 
        //去年同月區支出array
        $ly_region_output = array();
        //去年同月區業績及支出SQL
        $ly_regin_sql='';
        $ly_regin_sql="SELECT  mid(a.pdate,1,6) AS pdate,b.area_id ,sum(a.total) as total,sum(a.output) as output
                    FROM tbp_perform AS a INNER JOIN tbs_store AS b 
                        ON a.storename=b.storename
                        WHERE mid(a.pdate,1,6)=$ly_same_month
                        and b.area_id in ($_str)
                        GROUP BY b.area_id";
        
        $ly_region_result = Yii::app()->db->createCommand($ly_regin_sql)->queryAll();
       
         if($ly_region_result>0){
              foreach ($ly_region_result as $value) {                
                   $ly_region_total[$value['area_id']] = $value['total'];
                   $ly_region_output[$value['area_id']] = $value['output'];
              }
               unset($ly_region_result);             
         } 
       
         // 查詢用的SQL
        $qryStr = '';          
    
        //如果只選區域,就選該區域
        if( $qry_area != '') {   
                $qryStr = "and b.area_id in($qry_area)";      
        //如果都沒有選,就全部選出來
        }else{          
              $qryStr = "and b.area_id in($_str)";
        }
           
        $empAry = array();
        $last_shampoo_Ary = array();  
        $sql2 = '';
        $sql3 = '';
        $sql4 = '';
        $sql5 = '';
            
        if(isset($_POST['qry'])){ 

            //算區域剪、洗、助等....   tbp_perform_emp_log
           $sql2 = "(SELECT  mid(a.pdate,1,6) AS pdate,b.area_id  ,a.serviceno,sum(a.num) as num
            FROM tbp_perform_emp_log AS a INNER JOIN tbs_store AS b 
            ON a.storename=b.storename

            WHERE mid(a.pdate,1,6)=$qry_date
                                    $qryStr
            GROUP BY b.area_id ,a.serviceno)";
           
           //算區域剪、洗、助等....   tbp_perform_log
           $sql3 = "(SELECT  mid(a.pdate,1,6) AS pdate,b.area_id  ,a.serviceno,sum(a.num) as num
            FROM tbp_perform_log AS a INNER JOIN tbs_store AS b 
            ON a.storename=b.storename

            WHERE a.num!=0 and mid(a.pdate,1,6)=$qry_date
                                    $qryStr
            GROUP BY b.area_id ,a.serviceno)";
           
           $sql2=$sql2."UNION".$sql3;  //合併
           $sql2 = $sql2. "order by  area_id  ,serviceno";
   
           $result = Yii::app()->db->createCommand($sql2)->queryAll();
         
           //前月各區=>算剪、洗、助等....   tbp_perform_emp_log
           $sql4 = "(SELECT  mid(a.pdate,1,6) AS pdate,b.area_id  ,a.serviceno,sum(a.num) as num
            FROM tbp_perform_emp_log AS a INNER JOIN tbs_store AS b 
            ON a.storename=b.storename

            WHERE mid(a.pdate,1,6)=$last_month
                                    $qryStr
            GROUP BY b.area_id ,a.serviceno)";
           
           //前月各區=>算剪、洗、助等....   tbp_perform_log
           $sql5 = "(SELECT  mid(a.pdate,1,6) AS pdate,b.area_id  ,a.serviceno,sum(a.num) as num
            FROM tbp_perform_emp_log AS a INNER JOIN tbs_store AS b 
            ON a.storename=b.storename

            WHERE a.num!=0 and mid(a.pdate,1,6)=$last_month
                                    $qryStr
            GROUP BY b.area_id ,a.serviceno)";
           
           $sql4=$sql4."UNION".$sql5;  //合併
           $sql4 = $sql4. "order by  area_id  ,serviceno";
   
           $last_result = Yii::app()->db->createCommand($sql4)->queryAll();
           
        if($last_result>0){
             foreach ($last_result as $last_areaData) {  
                  $row = array(); 
                    // 區域編號
                    $row['area_id'] = $last_areaData['area_id'];                  
                    // 服務項目
                    $row['serviceno'] =  $last_areaData['serviceno'];
                    //數量
                    $row['num'] =  $last_areaData['num'];
                     array_push($last_shampoo_Ary, $row);
             }
        }     
        
        $last_shampoo_Ary = $this->setlastAreaAry($last_shampoo_Ary);
        unset($last_result);
        
        //紀錄前個月洗髮精數量
        $shampoo = array();
        //紀錄前個月髮油數量
        $hair_oil = array();
        //紀錄前個月髮雕數量
        $lotion = array();
        foreach ($last_shampoo_Ary as $key => $storeData) {
             $row = array();
            // 洗髮精(含少收) = N041 + N042 + N043 + X12 + X13 + X14
            $row['shampoo'] = 0;
            if(isset($storeData['N041'])) $row['shampoo'] = $storeData['N041'];
            if(isset($storeData['N042'])) $row['shampoo'] = $row['shampoo'] + $storeData['N042'];
            if(isset($storeData['N043'])) $row['shampoo'] = $row['shampoo'] + $storeData['N043'];
            if(isset($storeData['X12']))  $row['shampoo'] = $row['shampoo'] + $storeData['X12'];
            if(isset($storeData['X13']))  $row['shampoo'] = $row['shampoo'] + $storeData['X13'];
            if(isset($storeData['X14']))  $row['shampoo'] = $row['shampoo'] + $storeData['X14'];              

            $shampoo[$storeData['area_id']] = $row['shampoo'];
              
            // 髮油
            $row['hair_oil'] = 0;
            if(isset($storeData['N051'])) $row['hair_oil'] = $storeData['N051'];
            if(isset($storeData['X15'])) $row['hair_oil'] = $row['hair_oil'] + $storeData['X15'];

            $hair_oil[$storeData['area_id']] = $row['hair_oil'];  
            
             // 髮雕
            $row['lotion'] = 0;
            if(isset($storeData['N052'])) $row['lotion'] = $storeData['N052'];
            if(isset($storeData['X16'])) $row['lotion'] = $row['lotion'] + $storeData['X16'];
            
            $lotion[$storeData['area_id']] = $row['lotion']; 
        }
             
                if($result>0){
                        foreach ($result as $areaData) {           
                               $row = array(); 
                                 // 日期
                                 $row['pdate'] = $areaData['pdate'];
                                 // 營業區ID
                                 $row['areaid'] = $areaData['area_id'];
                                 // 營業區
                                 $row['area'] = $areaAry[$areaData['area_id']];                                
                                 // 服務項目
                                 $row['serviceno'] =  $areaData['serviceno'];
                                 //數量
                                 $row['num'] =  $areaData['num'];                                  
                              
                                 array_push($empAry, $row);                   
                        }
                }//if($result>0){
               
                $empAry = $this->setAreaAry($empAry);
                unset($result);
            
        }
    
        foreach ($empAry as $key => $areaData) {
 
               $row = array();
              
               // 年月
               $row['ym'] = $areaData['pdate'];
               // 營業區ID
               $row['areaid'] =$areaData['areaid'];
               // 營業區
               $row['area'] =$areaData['area'];          
            
               // 設定各欄位業績算法及總金額、總支出
               $row = $this->setRpt13RowData($row,$areaData);  
               
               // 區業績
               $row['perform'] = isset($area_perform_Ary[$areaData['areaid']]) ? (float)$area_perform_Ary[$areaData['areaid']] : '';  
               
               // 同期區業績
               $row['same_period'] =isset($ly_region_total[$areaData['areaid']]) ? (float)$ly_region_total[$areaData['areaid']] : ''; 
               
               // 支出
               $row['output'] = isset($area_output_Ary[$areaData['areaid']]) ? (float)$area_output_Ary[$areaData['areaid']] : '';
               //排名
               $row['rank'] = isset($area_rank_Ary[$areaData['areaid']]) ? $area_rank_Ary[$areaData['areaid']] : '';   
               //業績成長
               $row['perform_grow_up'] = isset($last_region_total[$areaData['areaid']]) ? $row['perform'] -  $last_region_total[$areaData['areaid']] : '';
               //支出成長
               $row['output_grow_up'] = isset($last_region_output[$areaData['areaid']]) ? $row['output'] -  $last_region_output[$areaData['areaid']] :''; 
               //洗髮精成長
               $row['shampoo_grow_up'] = isset($shampoo[$areaData['areaid']]) ? $row['shampoo'] -  $shampoo[$areaData['areaid']] :''; 
               //髮油成長
               $row['hair_oil_grow_up'] = isset($hair_oil[$areaData['areaid']]) ? $row['hair_oil'] -  $hair_oil[$areaData['areaid']] :'';
               //髮雕成長
               $row['lotion_grow_up'] = isset($lotion[$areaData['areaid']]) ? $row['lotion'] -  $lotion[$areaData['areaid']] :'';
              
               array_push($colAry, $row);
             
       }        
       unset($empAry);
       
        if(isset($_POST['qry']) ){
            if(count($colAry)<1)
                Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')."查無,$qry_date 月的業績資料");
            else
                Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success')."查詢成功. 共計 ".count($colAry)." 筆資料");
        }
       // CVarDumper::dump($empAry,10,true);
      
        $time_end = microtime(true);
        $computetime = round(($time_end - $time_start),3);
          
        $this->render('rpt14',array(                    
             'qry_date'=>$qry_date,
             'qry_area'=>$qry_area, 
             'check_all'=>$check_all,
             'col'=>$col,
             'title'=>$title,
             'colAry'=>$colAry,
             'computetime'=>$computetime,
         ));
    }
    
     /**
    * 
    * @return string
    */
    private function getRpt14Col($check_all){
        
        if($check_all){
            $col = array( 0 => 'ym',
                                1 => 'area',                                                
                                2 =>  'col1', //剪髮
                                3 => 'col2', //染髮
                                4 => 'col3', //助染
                                5 => 'col4', //優染
                                6 => 'col5', //優助染
                                7 => 'col6', //洗髮
                                8 => 'shampoo', //洗髮精
                                9 =>'hair_oil',//髮油
                                10 =>'lotion',//髮雕
                                11 => 'perform', //門市業績
                                12=>'same_period',//同期業績
                                13 => 'output', //支出                         
                                14 => 'rank', //排名                            
                                15 => 'perform_grow_up', //業績成長                         
                                16 => 'output_grow_up',//支出成長 
                                17 => 'shampoo_grow_up',//洗髮精成長
                                18 => 'hair_oil_grow_up',//髮油成長
                                19 => 'lotion_grow_up',//髮雕成長
                    );    
        }else{
            $col = array( 0 => 'ym',
                                1 => 'area',                                                                             
                                2 => 'perform', //門市業績
                                3=>'same_period',//同期業績
                                4 => 'output', //支出                         
                                5 => 'rank', //排名                            
                                6 => 'perform_grow_up', //業績成長                         
                                7 => 'output_grow_up',//支出成長 
                                8 => 'shampoo_grow_up',//洗髮精成長 
                                9 => 'hair_oil_grow_up',//髮油成長
                                10 => 'lotion_grow_up',//髮雕成長
                    ); 
             }
        return $col;
    }
    
    /**
     *   
     * @return string
     */
    private function getRpt14Title(){
       
        $title = array('ym' => '年月',
                            'area' => '營業區',                                                  
                            'col1' => '剪髮',
                            'col2' => '染髮',
                            'col3' => '助染',
                            'col4' => '優染',
                            'col5' => '優助染',
                            'col6' => '洗髮',
                            'shampoo' => '洗髮精',
                            'hair_oil' =>'髮油',
                            'lotion' =>'髮雕',
                            'perform' => '門市業績',
                            'same_period'=>'同期業績',
                            'output' => '支出',                         
                            'rank' => '排名',                          
                            'perform_grow_up' => '業績成長',
                            'output_grow_up' => '支出成長',  
                            'shampoo_grow_up' => '洗髮精成長',
                            'hair_oil_grow_up' => '髮油成長',
                            'lotion_grow_up' => '髮雕成長',
            );      
        return $title;    
    }
    
     // 設定整月服務項目放一起
    private function setAreaAry($result) {
        
        $areaAry = array();
        $area = array();
        
        if(count($result)>0) {
            
            $areaid = $result[0]['areaid']; 

            for ($i = 0; $i < count($result); $i++) {

                if($areaid == $result[$i]['areaid']){
                    $area['pdate'] = $result[$i]['pdate'];
                    $area['areaid'] = $result[$i]['areaid']; 
                    $area['area'] = $result[$i]['area'];                  
                    $area[$result[$i]['serviceno']] = $result[$i]['num'];             
                                  
                }else{
                    $areaAry[$areaid] = $area;
                    $area = array();
                    $areaid = $result[$i]['areaid'];
                    /*------*/
                    $area['pdate'] = $result[$i]['pdate'];
                    $area['areaid'] = $result[$i]['areaid']; 
                    $area['area'] = $result[$i]['area'];                  
                    $area[$result[$i]['serviceno']] = $result[$i]['num'];                
                }
            }

            $areaAry[$areaid] = $area;
        }        
        return $areaAry;
    }
    
    // 設定前月區域洗髮精服務項目放一起
    private function setlastAreaAry($result) {
        
         $areaAry = array();
         $area = array();
        
        if(count($result)>0) {
            
            $areaid = $result[0]['area_id']; 

            for ($i = 0; $i < count($result); $i++) {

                if($areaid == $result[$i]['area_id']){                  
                    $area['area_id'] = $result[$i]['area_id'];                  
                    $area[$result[$i]['serviceno']] = $result[$i]['num'];                  
                }else{
                    $areaAry[$areaid] = $area;
                    $area = array();
                    $areaid = $result[$i]['area_id'];
                    /*------*/                  
                    $area['area_id'] = $result[$i]['area_id'];                   
                    $area[$result[$i]['serviceno']] = $result[$i]['num'];                
                }
            }

            $areaAry[$areaid] = $area;
        }        
        return $areaAry;                                                 
    }
    
}
