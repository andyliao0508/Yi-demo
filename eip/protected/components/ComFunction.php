<?php
/**
 * 公用元件
 */
class ComFunction
{
    
    /**
     * 取得洗.染.燙業績
     * @param type $ary
     * @return int
     */
    public function getPerform($ary){
        
        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'1'));
        if(count($service)>0)
            foreach ($service as $row) {
                if(isset($ary[$row->serviceno]))
                    $sum = $sum + $ary[$row->serviceno] * $row->perform;
            }
        return $sum;
    }    
    
    /**
     * 取得洗助業績
     * @param type $ary
     * @return int
     */
    public function getAssist($ary){

        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'2'));
        if(count($service)>0)
            foreach ($service as $row) {
                if(isset($ary[$row->serviceno])) {

                    $sum = $sum + $ary[$row->serviceno] * $row->draw;
                }
            }        
        return $sum;
    }    

    /**
     * 取得銷售獎金
     * @param type $ary
     * @return int
     */
    public function getSaleBonus($ary){

        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'3'));
        if(count($service)>0)
            foreach ($service as $row) {
                if(isset($ary[$row->serviceno])) {

                    $sum = $sum + $ary[$row->serviceno] * $row->draw;
                }
            }        
        return $sum;
    }        
    
    /**
     * 取得銷售金額(剪.染.洗.燙.洗髮精
     * 與設計師有關.有抽成的商品
     * @param type $ary = array ('A01'=>1, 'D01'=>1);
     * @return int
     */
    public function getServiceArray(){
        
        $ary = array();
        $service = TbsService::model()->findAllByAttributes(
                array('opt1'=>'1'),
                $condition = "type1 in ('1','2','3','4','5')",
                $param = array() );
        if($service!=NULL)
            foreach ($service as $row) {
                $temp = array($row->serviceno=>0);
                $ary = array_merge($ary,$temp);
            }
        return $ary;
    }    
    
    /**
     * 取得銷售金額(剪.染.洗.燙.洗髮精
     * 與設計師有關.有抽成的商品
     * @param type $ary = array ('A01'=>1, 'D01'=>1);
     * @return int
     */
    public function getMoneySale($ary){
        
        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(
                array('opt1'=>'1'),
                $condition = "type1 in ('1','2','3')",
                $param = array() );
        if(count($service)>0)
            foreach ($service as $row) {
                if(isset($ary[$row->serviceno]))
                    $sum = $sum + $ary[$row->serviceno] * $row->price;
            }
        return $sum;
    }
    
    /**
     * 取得販賣金額(染膏燙劑)
     * 門市販賣.沒有設計師抽成的商品
     * @param type $ary = array ('N011'=>1, 'N012'=>1);
     * @return int
     */
    public function getMoneySell($ary){
        
        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'4'));
        if(count($service)>0)
            foreach ($service as $row) {
                if(isset($ary[$row->serviceno]))
                    $sum = $sum + $ary[$row->serviceno] * $row->price;
            }
        return $sum;
    }
    
    /**
     * 取得少收票卡金額
     * @param type $ary = array ('X01'=>1, 'X02'=>1);
     * @return int
     */
    public function getMoneyReduce($ary){
        
        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'5'));
        if(count($service)>0)
            foreach ($service as $row) {
                if(isset($ary[$row->serviceno])){
//                    print_r ($row->serviceno.' '.$row->noreceive.'<br>');
                    $data = TbsService::model()->findByAttributes(array('serviceno'=>$row->noreceive));
                    if($data!=NULL) $sum = $sum + $ary[$row->serviceno] * $data->price;
                }
            }
        return $sum;
    }      
    
    /**
     * 取得異匯異動金額
     * @param type $ary = array ('Z01'=>1, 'Z02'=>1);
     * @return int
     */
    public function getMoneyChange($ary){
        
        $sum = 0;
        $service = TbsService::model()->findAllByAttributes(array('type1'=>'6'));
        if(count($service)>0)
            foreach ($service as $row) {
                if(isset($ary[$row->serviceno]))
                    $sum = $sum + $ary[$row->serviceno] * $row->chgprice;
            }
        return $sum;
    }      
    
    /**
     * 取得區域陣列, array[0] 是 id=>區域名,  array[1]是 id=>區域權限
     * 回傳 array[0]=>array (
     *          '1'=>北一區,
     *          '2'=>北二區....)
     * 回傳 array[1]=>array (
     *          '1'=>AreaManager01,
     *          '2'=>AreaManager02....)
     * @param boolean $inUse - 是否使用
     * @return array
     */
    public function getAreaArray($inUse) {
        
        $areas = array();
        $areaRight = array();
        
        $TbsArea = array();
        
        if($inUse)
            $TbsArea = TbsArea::model()->findAllByAttributes(array('opt1'=>1));
        else
            $TbsArea = TbsArea::model()->findAll();
        
        foreach ($TbsArea as $area) {
            $areas[$area->id] = $area->areaname;
            $areaRight[$area->id] = $area->opt2;
        }
        
        return array($areas,$areaRight);
    }
    
    /**
     * 取得門市陣列, array[0] 是 店編=>店名,  array[1]是 店編=>區id, array[2]是 店編=>區名
     * 回傳 array[0]=>array (
     *          '007001'=>高雄聯興,
     *          '007002'=>高雄復興....)
     * 回傳 array[1]=>array (
     *          '007001'=>8,
     *          '007002'=>8)
     * 回傳 array[2]=>array (
     *          '007001'=>高屏二區,
     *          '007002'=>高屏二區) 
     * @param boolean $inUse
     * @return array - array(門市名稱), array(門市區域id), array(門市區域名稱)
     */
    public function getStoreArray($inUse) {
        
        $stores = array();
        $storesArea= array();
        $storesAreaName = array();
        
        $TbsStore = array();
        
        if($inUse)
            $TbsStore = TbsStore::model()->findAllByAttributes(array('opt1'=>1));
        else
            $TbsStore = TbsStore::model()->findAll();
        
        $area = $this->getAreaArray($inUse);
        
        foreach ($TbsStore as $store) {
            $stores[$store->storecode] = $store->storename;
            $storesArea[$store->storecode] = $store->area_id;
            $storesAreaName[$store->storecode] = $area[0][$store->area_id];
        }
        
        return array($stores,$storesArea,$storesAreaName);
    }    
    
    /**
     * 自動補0函數
     * @param type $num 需要補0的字串
     * @param type $digit 要補0的長度
     * @return type
     */
    function addZero($num, $digit){
        
        if(strlen($num)>$digit)
            return $num;
        else
            return $this->addZero ('0'.$num, $digit);
    }    
    
    /**
     * 依員工查詢出缺勤, 回傳曰期陣列, 並內含每日差勤
     * form參數, 主要是自動將變數轉成中文
     * @param String $daymonth - 年月 ( 201405 )
     * @param String $empno - 員工編號 ( 02010001) 
     * @param Boolean $form - 是否將1=>全天, 0.5=>半天, 預設為FALSE
     * @return array - 巢狀陣列
     */
    function getAbsenceByEmp($daymonth, $empno, $form){
         
        $format = is_bool($form)?$form:FALSE;
        
         //切割出年份
        $tmp_year=substr($daymonth,0,4);
        //切割出月份
        $tmp_mon =substr($daymonth,4,2);
        
        $aStart = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));//月初
        $aEnd = date("Ymd", mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year));//月底
        
         $sql= "SELECT logtype,logitem,logday,logname, num,opt2 FROM tba_log
               WHERE  empno = '$empno' and logday BETWEEN '$aStart'  AND '$aEnd' ORDER BY logday DESC ";
        
        $result = Yii::app()->db->createCommand($sql)->queryAll();
       
        // output array
        $_array = array();   
        
        if(count($result>0)) {
            // 用來比較的日期        
            $day = "";
            if(isset($result[0]['logday'])){
                $day = $result[0]['logday'];
            }
            // 每一天. 所有差勤獎懲的ARRAY
            $logAry = array();
            for ($i = 0; $i < count($result); $i++) {
                if($result[$i]['logday']==$day) {
                    if($format)
                        $logAry[$result[$i]['logname']] = $this->absenceByEmpFormat($result[$i]);
                    else
                        $logAry[$result[$i]['logitem']] =  (float)$result[$i]['num'];
                }else{             
                    $_array[$day] = $logAry; //array日期 存logname=>num
                    $day = $result[$i]['logday']; //day設成進來的日期
                    $logAry = array(); //清空
                    if($format)
                        $logAry[$result[$i]['logname']] = $this->absenceByEmpFormat($result[$i]);
                    else
                        $logAry[$result[$i]['logitem']] =  (float)$result[$i]['num'];
                }
            }
            $_array[$day] = $logAry;  //把最後一筆資料加進去           
        }

        return $_array;
    }
    
    /**
     * 將數字轉成符合需求的
     * @param array $log
     * @return real
     */
    private function absenceByEmpFormat($log) {
        
        $num = 0;
        
        if($log['logtype']==2 OR $log['opt2']==1){
            $num = (float)$log['num'];
        }else{
            if($log['num']==1) $num = '全天';
            elseif($log['num']==0.5) $num = '半天';
            else $num = $log['num'];
        }
        
        return $num;
    }
    
    /**
     * 依員工查詢權重
     * @param String $daymonth - 年月 ( 2014-01-01 )
     * @param String $empno - 員工編號 ( 02010001) 
     * @return int
     */
    public function getWeightByEmp($daymonth,$empno){
        
        $result = 0;
        // 員工出缺勤
        $absence = $this->getAbsenceByEmp($daymonth, $empno, FALSE);
        // 取得國定假日
        $dates = array();
        foreach ($absence as $key => $abs) {
            array_push($dates, $key);
        }
        $holidays = $this->getHolidayByDates($dates);
        // 取得有權重的差勤項目
        $logitems = TbaLogItem::model()->findAllByAttributes(array('weight'=>1,'opt1'=>1));
        $itemdays = array(); // 以天計
        $itemmins = array(); // 以分計 ( 遲到早退開小差 )
        $itemeach = array(); // 以支計 ( 小過, 大過 )
        foreach ($logitems as $item) {
            if($item->logtype==1) {
                if($item->opt2==0)
                    array_push($itemdays, $item->id);
                else
                    array_push($itemmins, $item->id);
            }else
                    array_push($itemeach, $item->id);
        }
        // 取得差勤權重
        $logweights = TbaWeight::model()->findAllByAttributes(array('opt1'=>1));
        $nweight = array(); // 平日權重
        $hweight = array(); // 假日權重
        foreach ($logweights as $weight) {
            $nweight[$weight->logitem] = $weight->nweight;
            $hweight[$weight->logitem] = $weight->hweight;
        }
        // 計算權重
        // 以 員工出缺勤 $absence 來 loop
        // 每一天都丟進 $holidays 來判斷是否為假日
        // 再逐項去判斷是否有權重. 若有則再做計算.
        // 而權重要判斷成是以天計, 以分計, 還是以支計
        foreach ($absence as $date => $abs) {
            
        }
        
        return $hweight;
    }
    
   /**
     * 依員工查詢出缺勤, 回傳曰期陣列, 並內含每日差勤
     * 給期中期末用
     * @param String $daymonth - 年月 ( 201405 )
     * @param String $emp - 員工編號　02010001
     * @return array - 巢狀陣列
     */
    function getAbsenceSumByEmp($daymonth, $empno){
        
        //切割出年份
        $tmp_year=substr($daymonth,0,4);
        //切割出月份
        $tmp_mon =substr($daymonth,4,2);
        
        $aStart = date("Ymd", mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));//月初
        $aEnd = date("Ymd", mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year));//月底
        
        $sql= "SELECT empno, logitem, sum(num) AS sum FROM tba_log
               WHERE  empno = '$empno' and logday BETWEEN '$aStart'  AND '$aEnd' GROUP BY logitem ";
        
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $_array = array();
        
       
        for ($i = 0; $i < count($result); $i++) {
         
            
           $_array['weight']= $this->getWeightByEmp($daymonth, $empno);
           $item = $result[$i]['logitem'];
           switch ($item) {
               case 1:
               $_array['late5'] = (float)$result[$i]['sum'];  //婚
               break;
           
               case 2:
               $_array['late6'] = (float)$result[$i]['sum']; //喪
               break;
           
               case 3:            
               case 10:
               $_array['late3'] = (float)$result[$i]['sum']; //病
               break;
           
               case 4:
               case 9:
               $_array['late2'] = (float)$result[$i]['sum']; //事
               break;
           
               case 6:
               case 7:
               case 8:
               case 11:
               $_array['late4'] = (float)$result[$i]['sum']; //公
               break;
           
               case 19:
               case 20:
               case 21:
               $_array['late1'] = (float)$result[$i]['sum']; //遲到
               break;
           
               case 18:
               $_array['late7'] = (float)$result[$i]['sum']; //曠職
               break;
        
           }
        }
         
        return $_array;
    }
    
    /**
     * 查詢JIT假日, 回傳曰期是否存在,
     * @param String $date - 年月 ( 201405 )
     * @return boolean - 是否為日期
     */    
    function getHolidayByDate($date){

        //預設false
        $existholiday=false;
        //從DB判斷日期是否存在
        $judge= TbaHoliday::model()->findByAttributes(array(), 
        $conditon = " holiday = '$date' "
        );

        //當$judge存在，則$existholiday為true
        if(isset($judge)){
            $existholiday=true;
        }

        return $existholiday;
    }
    
     /**
     * 查詢JIT假日, 回傳曰期陳列是否存在,
     * @param Array $dates - 日期陣列 ( 2014-05-01,2014-05-09,.... )
     * @return Array - 日期陣列
     */
    
    function getHolidayByDates($dates){

        $_arr=array();//回傳日期是否為假日的陣列
        
           // '2014-01-01','2014-01-02'  array轉成字串  
           if(count($dates)>0) {
                $_str = "'".implode("','", $dates)."'"; //每個日期加入單引號為了sql in查詢使用

                //從DB判斷日期是否存在            
                $sql= "SELECT holiday from tba_holiday where holiday  IN ($_str) ORDER BY holiday ASC ";
        
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                
                //將雙層array轉成單層array()
                $_array=array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($_array, $result[$i]['holiday']);                    
                }

               //假日true，平常日false
               for ($i = 0; $i < count($dates); $i++) {
  
                 $_arr[$dates[$i]]= in_array($dates[$i], $_array);  
                                        
                }          
                
           }
        return $_arr;
    }
    
    /**
     * 依年月直接取得該年月內所有日期的假日
     * @param String $daymonth - 年月, 如: 201405
     * @return Array - array('20140501'=>true, '20140502'=>false ... )
     */
    public function getHolidayByYearMonth($daymonth) {

        $dates = array();

        $aStart = $this->getTheFirstDayByYearMonth($daymonth,"Ymd");
        $aEnd = $this->getTheLastDayByYearMonth($daymonth,"Ymd");

        for ($i = 0; ($aStart + $i) <= $aEnd ; $i++) {
            array_push($dates, $aStart+$i);
        }

        return $this->getHolidayByDates($dates);
    }
    
    /**
     * 依年月取得該月第一天
     * @param type $daymonth
     * @param type $format
     * @return type
     */
    public function getTheFirstDayByYearMonth($daymonth,$format) {
        
        // 切割出年份
        $tmp_year=substr($daymonth,0,4);
        // 切割出月份
        $tmp_mon =substr($daymonth,4,2);

        return date($format, mktime(24, 0, 0, $tmp_mon, 0, $tmp_year));
    }
    
    /**
     * 依年月取得該月最後一天
     * @param type $daymonth
     * @param type $format
     * @return type
     */
    public function getTheLastDayByYearMonth($daymonth,$format) {
        
        // 切割出年份
        $tmp_year=substr($daymonth,0,4);
        // 切割出月份
        $tmp_mon =substr($daymonth,4,2);

        return date($format, mktime(0, 0, 0, $tmp_mon+1, 0, $tmp_year));        
    }
}