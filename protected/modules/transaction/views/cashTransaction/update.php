<?php
$this->breadcrumbs=array(
	'Cash Transactions'=>array('index'),
	$cashTransaction->header->id=>array('view','id'=>$cashTransaction->header->id),
	'Update',
);

?>

<h1>Update Cash Transaction <?php echo $cashTransaction->header->transaction_number; ?></h1>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(//'model'=>$model
            'cashTransaction'=>$cashTransaction,
            'coaKas'=>$coaKas,
            'coaKasDataProvider'=>$coaKasDataProvider,
            'coaDetail'=>$coaDetail,
            'coaDetailDataProvider'=>$coaDetailDataProvider,
            'postImages' => $postImages,
            'allowedImages' => $allowedImages,
    )); ?>
</div>