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
				<p>Lorem ipsum dolor sit amet</p>
				<div class="grid-view">
					<?php 
					$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'transaction-request-order-grid',
						'dataProvider'=>$model->search(),
						// 'filter'=>$model,
						'template' => '{items}<!--<div class="clearfix">{summary}{pager}</div>-->',
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
                        	),	
							//'id',
							array('name'=>'request_order_no', 'value'=>'CHTml::link($data->request_order_no, array("view", "id"=>$data->id))', 'type'=>'raw'),
							'total_items',
							'total_price',
							array(
								'name'=>'requester_branch_id',
								'value'=>'$data->requesterBranch->name'
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
				<p>Lorem ipsum dolor sit amet</p>
				<?php 
				$this->widget('ext.groupgridview.GroupGridView', array(
					'id'=>'transaction-request-order-detail-grid',
					'dataProvider'=>$modelDetail,
					// 'filter'=>$modelDetail,
					'template' => '{items}<!--<div class="clearfix">{summary}{pager}</div>-->',
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
		                ),	
						array(
							'name'=>'product_id',
							'value'=>'$data->product->name'
						),
						'quantity',
						'unit_price',
						'total_price',
						array(
							'name'=>'supplier_id',
							'value'=>'$data->supplier->name'
						),
						// 'supplier_id',
						// 'unit_id',

						),
						)); ?>
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
