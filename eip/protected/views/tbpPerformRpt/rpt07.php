<?php
/* @var $this TbpPerformController */
/* @var $dataProvider CActiveDataProvider */

//$this->breadcrumbs=array(
//	'Tbp Performs',
//);

//$this->menu=array(
//	array('label'=>'Create TbpPerform', 'url'=>array('create')),
//	array('label'=>'Manage TbpPerform', 'url'=>array('admin')),
//);
?>

<h1><?php // echo $user->emp->empname; ?> 四級業績報表</h1><br>
<hr><br>

<div class="form">
<?php echo CHtml::beginForm(); ?>
     達成率：<input size="10" maxlength="10" name="achYm" id="achYm" value="<?php echo $achYM; ?>" type="text" />
     <input type="submit" name="qry" value="查詢">
<?php echo CHtml::endForm(); ?>
</div><!-- form -->

<div class="table">
    <table>
        <tr bgColor="#F0F0F0">
            <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td ><?php echo $title[$col[$i]]; ?></td>
            <?php endfor; ?>
        </tr> 
        
            <?php for ($j = 0; $j < count($colAry); $j++) : ?>
        <tr bgColor="#00F0F0">
                 <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td ><?php echo $colAry[$j][$col[$i]]; ?></td>
                <?php endfor; ?>
        </tr>    
            <?php endfor; ?>
        
    </table>
</div>

</div>