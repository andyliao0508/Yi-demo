<!-- 區期中期末報表 -->

<?php echo $this->renderPartial('_rpt8X', array(
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
    )); ?>