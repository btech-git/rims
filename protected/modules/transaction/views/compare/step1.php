<?php
/* @var $this TransactionRequestOrderController */
/* @var $model TransactionRequestOrder */

$this->breadcrumbs=array(
	'Transaction Request Orders'=>array('admin'),
	'Manage',
	);

$this->menu=array(
	array('label'=>'List TransactionRequestOrder', 'url'=>array('index')),
	array('label'=>'Create TransactionRequestOrder', 'url'=>array('create')),
	);
	?>
<div id="maincontent">
	<div class="clearfix page-action">

		<div class="row">
			<div class="small-12 medium-6 columns">
				<h3>Purchase Request</h3>
				<p>Select Request Order</p>

				<div class="search-bar">
					<div class="clearfix button-bar">

						<div class="row">
							<div class="medium-12 columns">
								<?php $form=$this->beginWidget('CActiveForm', array(
									'action'=>Yii::app()->createUrl($this->route),
									'method'=>'get',
									)
								);
								?>
								<div class="row">
									<div class="small-3 columns">
										<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $model,
											'attribute' => "request_order_date",
											'options'=>array(
												'dateFormat' => 'yy-mm-dd',
												'changeMonth'=>true,
												'changeYear'=>true,
												'yearRange'=>'1900:2020',
												),
											'htmlOptions'=>array(
												'placeholder'=>'Order Date',
												"style"=>"margin-bottom:0px;"
												),
											)
										);
										?>
									</div>
									<div class="small-3 columns">
										<?php echo  $form->dropDownList($model, 'has_compare', array('yes' => 'Done',
										'no' => 'Not Done', ), array('prompt' => '[--Select Status--]',"style"=>"margin-bottom:0px;")); ?>
									</div>

									<div class="small-3 columns">
										<?php echo $form->dropDownList($model, 'requester_branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'),array(
											'prompt' => '[--Select Branch--]',
											'onchange' => ''
											)
										); 
										?>
									</div>

									<div class="small-3 columns">
										<div class="field buttons text-right">
											<?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
										</div>
									</div>
								</div>

								<?php $this->endWidget(); ?>
							</div>
						</div>
					</div>
				</div><!-- search-form -->

				<div class="grid-view">
					<?php 
					$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'transaction-request-order-grid',
						'dataProvider'=>$dataProvider,
						// 'filter'=>$model,
						'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'columns'=>array(
							array(
								'class'=>'CCheckBoxColumn',  //CHECKBOX COLUMN ADDED.
								'selectableRows'=>2,         //MULTIPLE ROWS CAN BE SELECTED.
								'checked' =>function($data) use($prChecked) {
				           		    return in_array($data->id, $prChecked); 
				           		}, 
				                'disabled' => '($data->has_compare == "yes")?true:false',
				        	),	
							//'id',
							array('name'=>'request_order_no', 'value'=>'CHTml::link($data->request_order_no, array("transactionRequestOrder/view", "id"=>$data->id))', 'type'=>'raw'),
							array(
								'name'=>'total_items',
                                'header' => 'Qty',
								'value'=>'Yii::app()->numberFormatter->format("#,##0", $data->total_price)',
							),
							array(
								'name'=>'total_price',
                                'header' => 'Price',
								'value'=>'Yii::app()->numberFormatter->format("#,##0.00", $data->total_price)',
							),
                            array(
                                'header' => 'Order Date',
                                'filter' => false,
                                'name' => 'request_order_date',
                                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($data, "request_order_date"))'
                            ),
							array(
								'name'=>'requester_branch_id',
								'value'=>'empty($data->requesterBranch->name)?"branch non active":$data->requesterBranch->name'
							),
							array(
								'name'=>'main_branch_id',
								'value'=>'empty($data->mainBranch->name)?"branch non active":$data->mainBranch->name'
							),
							array(
								'header'=>'Status',
								'name'=>'has_compare',
								'value'=>'($data->has_compare == "yes")?"Done":""'
							),
						),
					)); ?>
					<div class="button-group">
						<?php echo CHtml::button("Selected Items",array("id"=>"btnProses", 'class'=>'button cbutton')); ?>
						<?php echo CHtml::button("Clear Selected",array("id"=>"btnClear", 'class'=>'button cbutton')); ?>
					</div>
				</div>
			</div>
			<div class="small-12 medium-6 columns">
				<h3>Total Product</h3>
				<p>Select Products</p>
								<div class="search-bar">
					<div class="clearfix button-bar">

						<div class="row">
							<div class="medium-12 columns">
							&nbsp;
							</div>
						</div>
					</div>
				</div><!-- search-form -->

				<div class="grid-view">

				<?php 
				$this->widget('ext.groupgridview.GroupGridView', array(
					'id'=>'transaction-request-order-detail-grid',
					'dataProvider'=>$modelDetail,
					// 'filter'=>$modelDetail,
					'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div>',
					// 'template' => '{items}<!--<div class="clearfix">{summary}{pager}</div>-->',
					'pager'=>array(
						'cssFile'=>false,
						'header'=>'',
						),
				    'mergeColumns' => array('product_id'),  
					'columns'=>array(
						// 'id',
						array(
							'class'=>'CCheckBoxColumn',  //CHECKBOX COLUMN ADDED.
							'selectableRows'=>2,         //MULTIPLE ROWS CAN BE SELECTED.
							'checked' =>function($data) use($pdChecked) {
							    return in_array($data->id, $pdChecked); 
							}, 
			                'disabled' => '($data->has_compare == "yes")?true:false',
		                ),	
						array(
							'name'=>'product_id',
							'value'=>'$data->product->name'
						),
                        array(
                            'name'=>'quantity',
                            'value'=>'Yii::app()->numberFormatter->format("#,##0", $data->quantity)',
                        ),
                        array(
                            'name'=>'unit_price',
                            'header' => 'Price',
                            'value'=>'Yii::app()->numberFormatter->format("#,##0.00", $data->unit_price)',
                        ),
                        array(
                            'name'=>'total_price',
                            'header' => 'Total',
                            'value'=>'Yii::app()->numberFormatter->format("#,##0.00", $data->total_price)',
                        ),
						array(
							'name'=>'supplier_id',
							'value'=>'$data->supplier->name'
						),
						'main',
						array(
							'name'=>'Status',
							'value'=>'($data->has_compare == "yes")?"Done":""'
						),
						// 'supplier_id',
						// 'unit_id',

						),
						)); ?>
				</div>
				<div class="button-group">
					<?php //echo CHtml::button("Add Other Product",array("id"=>"addProduct", 'class'=>'button cbutton')); ?>
					<?php echo CHtml::button("Next",array("id"=>"btnNextProduct", 'class'=>'button cbutton')); ?>
					<?php echo CHtml::button("Clear Selected",array("id"=>"btnClearPd", 'class'=>'button cbutton')); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
Yii::app()->clientScript->registerScript('centang','
	$("#btnProses").click(function(){
        var checked=$("#transaction-request-order-grid").yiiGridView("getChecked","transaction-request-order-grid_c0");
        console.log(checked);
        var count=checked.length;
        // if(count>0 && confirm("Do you want to selected these "+count+" item(s)"))
        if(count>0){
            $.ajax({
                    data:{checked:checked},
                    url:"'.CHtml::normalizeUrl(array('compare/prTemp')).'",
                    success:function(data){
                    	// console.log(data);
                    	$("#transaction-request-order-detail-grid").yiiGridView("update",{});
                    },              
            });
        }else{
        	console.log("No Purchase Request items selected");
        	alert("No Purchase Request items selected");
        }
    });
	$("#btnClear").click(function(){
		var checked="clear";
		$.ajax({
            data:{checked:checked},
            url:"'.CHtml::normalizeUrl(array('compare/prTemp')).'",
            success:function(data){
            	$("#transaction-request-order-grid").yiiGridView("update",{});
            	$("#transaction-request-order-detail-grid").yiiGridView("update",{});
            },              
        });
    });

	$("#btnClearPd").click(function(){
		var checked="clear";
		$.ajax({
            data:{checked:checked},
            url:"'.CHtml::normalizeUrl(array('compare/pdTemp')).'",
            success:function(data){
            	$("#transaction-request-order-detail-grid").yiiGridView("update",{});
            },              
        });
    });

	$("#btnNextProduct").click(function(){
        var checked=$("#transaction-request-order-detail-grid").yiiGridView("getChecked","transaction-request-order-detail-grid_c0");
        var count=checked.length;
        if(count>0 && confirm("Do you want to selected these "+count+" item(s)")){
			$.ajax({
				data:{checked:checked},
				url:"'.CHtml::normalizeUrl(array('compare/pdTemp')).'",
				success:function(data){
			        window.location.href = "'.CHtml::normalizeUrl(array('compare/step2')).'";
				},              
			});
        }else{
        	console.log("No Product items selected");
        	alert("No Product items selected");
        }

    });

');


Yii::app()->clientScript->registerScript('search', "
$('form').submit(function(){
	$('#transaction-request-order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>