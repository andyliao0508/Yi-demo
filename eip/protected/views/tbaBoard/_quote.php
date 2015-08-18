<?php 

$marquee = TbaParam::model()->findByAttributes(array('param'=>'marquee_size'));
$size = $marquee->pvalue;  //取的變數內容;

echo "<span style=font-size:".$size."px>";

echo CHtml::link( $quote->title,
              array('tbaBoard/empread?id='.($quote->id)),
              array('target'=>'_self')
          );
echo "</span>";

?>