<?php
/* @var $this ConsignmentInHeaderController */
/* @var $model ConsignmentInHeader */

$this->breadcrumbs=array(
	'Consignment In Headers'=>array('admin'),
	'Manage',
	);

$this->menu=array(
	array('label'=>'List ConsignmentInHeader', 'url'=>array('index')),
	array('label'=>'Create ConsignmentInHeader', 'url'=>array('create')),
	);

// Yii::app()->clientScript->registerScript('search', "
// $('.search-button').click(function(){
// 	$('.search-form').toggle();
// 	return false;
// });
// $('.search-form form').submit(function(){
// 	$('#consignment-in-header-grid').yiiGridView('update', {
// 		data: $(this).serialize()
// 	});
// 	return false;
// });
// ");
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').slideToggle(600);
		$('.bulk-action').toggle();
		$(this).toggleClass('active');
		if($(this).hasClass('active')){
			$(this).text('');
		}else {
			$(this).text('Advanced Search');
		}
		return false;
	});
$('.search-form form').submit(function(){
	$('#transaction-request-order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
return false;
});
");

?>
<div id="maincontent">
	<div class="clearfix page-action">
	
	<?php echo CHtml::link('<span class="fa fa-plus"></span>New Consignment In', Yii::app()->baseUrl.'/transaction/consignmentInHeader/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("transaction.consignmentInHeader.create"))) ?>
		<h1>Manage Consignment In</h1>
		<div class="search-bar">
			<div class="clearfix button-bar">
      			<!--<div class="left clearfix bulk-action">
	         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
	         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
	         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
	         	</div>-->
					<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button right button cbutton secondary')); ?>
	         	<div class="clearfix"></div>
	         	<div class="search-form" style="display:none">
	         		<?php $this->renderPartial('_search',array(
	         			'model'=>$model,
                    )); ?>
                </div><!-- search-form -->				
            </div>
         </div>

         <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'consignment-in-header-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                    ),
                'columns'=>array(
                    //'id',
                    array('name'=>'consignment_in_number', 'value'=>'CHTml::link($data->consignment_in_number, array("view", "id"=>$data->id))', 'type'=>'raw'),
                    //'consignment_in_number',
                    'date_posting',
                    'status_document',
                    array(
                        'name'=>'supplier_name',
                        'value'=>'$data->supplier->name',
                    ),
                    array(
                        'name'=>'receive_branch',
                        'filter' => CHtml::activeDropDownList($model, 'receive_branch', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value'=>'$data->receiveBranch->name',
                    ),
                    'date_arrival',
                    array(
                        'header' => 'Status',
                        'value' => '$data->totalRemainingQuantityReceived',
                    ),
                    /*
                    'receive_id',
                    'receive_branch',
                    'total_price',
                    */
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{edit}',
                        'buttons'=>array(
                            'edit' => array (
                                'label'=>'edit',
                                'url'=>'Yii::app()->createUrl("transaction/consignmentInHeader/update", array("id"=>$data->id))',
                                'visible'=>'$data->status_document != "Approved" && $data->status_document != "Rejected" && Yii::app()->user->checkAccess("transaction.consignmentInHeader.update")'
                            ),
                        ),
                    ),
                )
            )); ?>
        </div>
	</div>
</div>
