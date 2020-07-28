<?php 
	 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'registration-transaction-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),
	'rowCssClassExpression' => '(($data->status == "Finished")?"hijau":"merah")',
	// 'rowCssClassExpression' => '(($data->status == "Finished")?"hijau":(($data->status == "Pending")?"merah":""))',
	'columns'=>array(
		'pic_id',
		'vehicle_id',
		'branch_id',
		'user_id',
		'total_quickservice',
		'total_quickservice_price',
		'total_service',
		'subtotal_service',
		'discount_service',
		'total_service_price',
		'total_product',
		'subtotal_product',
		'discount_product',
		'total_product_price',
		),
	));
 ?>