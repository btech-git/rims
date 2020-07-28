<?php
/* @var $this CashTransactionController */
/* @var $model CashTransaction */

$this->breadcrumbs=array(
	'Cash Transactions'=>array('index'),
	$cashTransaction->header->id=>array('view','id'=>$cashTransaction->header->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List CashTransaction', 'url'=>array('index')),
	array('label'=>'Create CashTransaction', 'url'=>array('create')),
	array('label'=>'View CashTransaction', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CashTransaction', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update CashTransaction <?php echo $cashTransaction->header->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array(//'model'=>$model
			'cashTransaction'=>$cashTransaction,
			'coaKas'=>$coaKas,
			'coaKasDataProvider'=>$coaKasDataProvider,
			'coaDetail'=>$coaDetail,
			'coaDetailDataProvider'=>$coaDetailDataProvider,
			'postImages' => $postImages,
			'allowedImages' => $allowedImages,
		)); ?></div>