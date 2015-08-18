<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

// 如果使用者未登入，則轉到登錄頁面
if(Yii::app()->user->isGuest) {
    header('Location: index.php/site/login');
    exit();
}
?>

<h1>歡迎來到<i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<br>

<?php echo $this->renderPartial("/tbaBoard/announce"); ?>