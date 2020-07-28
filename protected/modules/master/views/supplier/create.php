<?php $this->breadcrumbs=array(
 	'Company',
 	'Suppliers'=>array('admin'),
 	'Create',
 ); ?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array(
        'supplier'=>$supplier,
		'bank'=>$bank,
		'bankDataProvider'=>$bankDataProvider,
		'coa'=>$coa,
		'coaDataProvider'=>$coaDataProvider,
		'coaOutstanding'=>$coaOutstanding,
		'coaOutstandingDataProvider'=>$coaOutstandingDataProvider,
	)); ?>
</div>