<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Inventory'=>array('admin'),
	'Inventories'=>array('admin'),
	'Manage Inventories',
);

$this->menu=array(
	array('label'=>'List Inventory', 'url'=>array('index')),
	array('label'=>'Create Inventory', 'url'=>array('create')),
);

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
	$('#inventory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<style type="text/css">
	.red {
		background-color: #EF5350 !important;
	}
	.red-dark {
		color: #fff;
		font-weight: bold;
		background-color: #870000 !important;
	}
</style>

<?php
	$warehouses = Warehouse::model()->findAll();
?>
	<div id="maincontent">
			<div class="clearfix page-action">
				<?php 
					/*echo CHtml::ajaxLink('<span class="fa fa-plus"></span>Per Warehouse View',Yii::app()->createUrl("master/inventory/ajaxHtmlInventoryPerWarehouse"), array(
				        	'type'=>'POST',
				        	'success'=>'function(html){
				        		$("#inventory_per_warehouse_div").html(html);
								$("#inventory-per-warehouse-dialog").dialog("open");
				        	}'
				        ), array(
							'class'=>'button success right'
						)
				    );*/ 
				?>
				<!--<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/inventory/create';?>"><span class="fa fa-plus"></span>New Inventory</a>-->
				<h1>Manage Inventory</h1>
 
				<?php /*
				<!-- BEGIN aSearch -->
				<div class="search-bar">
					<div class="clearfix button-bar">
						<!--<div class="left clearfix bulk-action">
							<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
							<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
							<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
						<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>	
						<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button right button cbutton secondary')); ?>
					</div>
					<div class="clearfix"></div>
					<div class="search-form" style="display:none">
						<?php $this->renderPartial('_search',array(
							'model'=>$inventory2,
						)); ?>
					</div><!-- search-form -->
				</div>
				<!-- END aSearch -->	*/?>	

				<div class="search-bar">
				<div class="clearfix button-bar">
					<!--<div class="left clearfix bulk-action">
						<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
						<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
						<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
	         		</div>-->

						<div class="row">
							<div class="medium-12 columns">
							<?php $form=$this->beginWidget('CActiveForm', array(
								'action'=>Yii::app()->createUrl($this->route),
								'method'=>'get',
								)); ?>
								  <div class="row">
	    							<div class="medium-2 columns">
					       				<?php echo $form->textField($inventory2,'findkeyword', array('placeholder'=>'Find By Keyword', "style"=>"margin-bottom:0px;")); ?>
					       			</div>
	    							<div class="medium-2 columns">
					       				<?php echo $form->dropDownList($inventory2, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'),
											array(
						               		'prompt' => '[--Select Product Master Category--]',"style"=>"margin-bottom:0px;"
						          			)
						          		);?>
					       			</div>
	    							<div class="medium-2 columns">
	    							<?php echo $form->dropDownList($inventory2, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(), 'id', 'name'),
										array(
					               		'prompt' => '[--Select Product Sub Master Category--]',
										'onchange'=> 'jQuery.ajax({
											type: "POST",
											url: "' . CController::createUrl('ajaxGetProductSubCategory') . '",
											data: jQuery("form").serialize(),
											success: function(data){
												jQuery("#Inventory_product_sub_category_id").html(data);
											},
										});'
					               		))
	    							?>


					       			</div>
	    							<div class="medium-2 columns">
										<?php echo CHtml::dropDownList('Inventory[product_sub_category_id]', $inventory2->product_sub_category_id,$inventory2->product_sub_master_category_id != '' ? CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id'=>$inventory2->product_sub_master_category_id)), 'id', 'name') : array(), array(
											'prompt' => '[--Select Product Sub Category--]',
											'onchange'=> 'jQuery.ajax({
												type: "POST",
												url: "' . CController::createUrl('ajaxGetCode') . '",
												data: jQuery("form").serialize(),
												success: function(data){
													console.log(data);
													// if(jQuery("#Inventory_product_sub_master_category_id").val() == ""){
													// 	jQuery(".additional-specification").slideUp();
													// }
													// jQuery("#Inventory_product_sub_category_id").html(data);
												},
											});'
											)
											);

										?>
					       			</div>
	    							<div class="medium-2 columns">

	    							<?php echo $form->dropDownList($inventory2, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'),
							            array(
							            	'empty' => '[--Select a Brand--]',
											'onchange'=> 'jQuery.ajax({
							                  		type: "POST",
							                  		//dataType: "JSON",
							                  		url: "' . CController::createUrl('ajaxGetSubBrand') . '",
							                  		data: jQuery("form").serialize(),
							                  		success: function(data){
							                        	console.log(data);
							                        	jQuery("#Inventory_sub_brand_id").html(data);
							                    	},
							                	});'
											))
							        ?>

	    							</div>
	    							<div class="medium-2 columns">

	    							<?php echo CHtml::dropDownList('Inventory[sub_brand_id]', $inventory2->brand_id,$inventory2->brand_id != '' ? CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id'=>$inventory2->brand_id)), 'id', 'name') : array(), array(
										'prompt' => '[--Select Sub Brand--]',
										)
										);

									?>

	    							</div>
						          </div>
								<?php $this->endWidget(); ?>
							</div>
							<?php /*<div class="medium-2 columns">
								<a href="#" class="search-button right button cbutton secondary" id="advsearch" style="display: none;">Advanced Search</a>	
							</div>*/?>
						</div>

	         			<?php /*
						<div class="row">
							<div class="medium-10 columns">
							<?php $form=$this->beginWidget('CActiveForm', array(
								'action'=>Yii::app()->createUrl($this->route),
								'method'=>'get',
								)); ?>
								  <div class="row">
									<!--<div class="medium-3 columns">
					       				<?php //echo $form->textField($inventory2,'findkeyword', array('placeholder'=>'Find By Keyword', "style"=>"margin-bottom:0px;")); ?>
					       			</div> -->
	    							<div class="medium-3 columns">
					       				<?php echo $form->dropDownList($inventory2, 'product_id', CHtml::listData(Product::model()->findAll(), 'id', 'name'),
											array(
						               		'prompt' => '[--Select Product--]',"style"=>"margin-bottom:0px;"
						          			)
						          		);?>
					       			</div>
					       			<?php /*					       			
	    							<div class="medium-3 columns">
					       				<?php echo $form->dropDownList($inventory2, 'product_sub_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'),
											array(
						               		'prompt' => '[--Select Product Master Category--]',"style"=>"margin-bottom:0px;"
						          			)
						          		);?>
					       			</div>
	    							<div class="medium-3 columns">
	    							<?php echo $form->dropDownList($inventory2, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(), 'id', 'name'),
										array(
					               		'prompt' => '[--Select Product Sub Master Category--]',
					               		"style"=>"margin-bottom:0px;")
					               		)
	    							?>
					       			</div>
	    							<div class="medium-3 columns">
	    							
	    							<?php echo $form->dropDownList($inventory2, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'),
							            array(
							            	'empty' => '[--Select a Brand--]',
											"style"=>"margin-bottom:0px;"
							            ))
							        ?>

	    							</div>* /?>
						          </div>
								<?php $this->endWidget(); ?>
							</div>
							<div class="medium-2 columns">
								<a href="#" class="search-button right button cbutton secondary" id="advsearch" style="display: none;">Advanced Search</a>	
							</div>*/?>
						</div>
				</div>

				<div class="clearfix"></div>
					
				<div class="search-form" style="display:none">
						<?php /*$this->renderPartial('_search',array(
							'model'=>$model,
						)); */?>
				</div><!-- search-form -->
		</div>
		</div>
		<!-- END aSearch -->	


				<?php
					$warehouses = Warehouse::model()->findAll();
					$columns = array(
						//'id',
						//'product_id',
						array('name'=>'product_name', 'value'=>'CHTml::link($data["product_name"], array("detail", "product_id"=>$data["product_id"]))', 'type'=>'raw'),
						'manufacturer_code',
						'minimum_stock'
					);

					foreach($warehouses as $warehouse){
						array_push($columns, array(
							'header'=>'warehouse' . $warehouse->id, 
							'name'=>'warehouse' . $warehouse->id, 
							'value'=>'$data["warehouse' . $warehouse->id . '"]', 
							//'cssClassExpression'=>'$data["minimum_stock"] >= $data["warehouse' . $warehouse->id . '"] ? "red":""')
							'cssClassExpression'=>'
								($data["warehouse' . $warehouse->id . '"] <= $data["minimum_stock"]) ? (($data["warehouse' . $warehouse->id . '"] < 0 ) ? "red-dark":"red") : ""'
							)
						);
					}
					array_push($columns, array('header'=>'total', 'name'=>'total', 'value'=>'$data["total"]'));

					array_push($columns,array(
						'class'=>'CButtonColumn',
						'template'=>'{detail}',
						'buttons'=>array
						(
							'detail' => array
							(
								'label'=>'detail',
								'url'=>'Yii::app()->createUrl("master/inventory/detail", array("product_id"=>$data["product_id"]))',
							),
							'edit' => array
							(
								'label'=>'edit',
								'url'=>'Yii::app()->createUrl("master/product/update", array("id"=>$data->id))',
							),

						),
					));
				?>

				<!-- BEGIN gridview -->
				<div class="grid-view">
					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'inventory-grid',
						//'dataProvider'=>$model->search(),
						'dataProvider'=>$inventory2DataProvider,
						'filter'=>$inventory2,
						// 'htmlOptions'=>array('style'=>'overflow-x:scroll ; overflow-y: hidden; padding-bottom:10px;'),
						//'cssClassExpression'=>'20 > $data["warehouse1"] ? "red":""',
						'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'columns'=>$columns
						//'columns'=>array(
							//'id',
							//'warehouse_id',
							//'warehouse1'
							//array('name'=>'product_id', 'value'=>'$data->product->name'),
							//'warehouse_id',
							//array('name'=>'warehouse_id', 'value'=>'$data->warehouse->name'),
							//'total_stock',
							//'minimal_stock',
							//'status',
						)
					); ?>

					<?php //$inventoryPerWarehouse = Inventory::model()->inventoryPerWarehouse(); ?>
					<?php /*$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'inventory-grid',
						'dataProvider'=>$dataProvider,
						'ajaxUpdate' => true,
						'filter' => null,
						'filter'=>$dataProvider,
						'rowCssClassExpression'=>'$data->minimal_stock > $data->total_stock ? "red":""',
						'columns'=>$columns

						)
					);*/ ?>
					

				</div>
				<!-- END gridview -->

			</div>
			<!-- END maincontent -->		

		</div>
	</div>
</div>
<!-- END mainpage -->

<!--Inventory Per Warehouse Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'inventory-per-warehouse-dialog',
        'options'=>array(
            'title'=>'Price List',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'480',
        ),
 )); ?>
 
<div id="inventory_per_warehouse_div"></div>

<?php $this->endWidget(); ?>


<?php 
    Yii::app()->clientScript->registerScript('search',"

  //   	$('#Product_findkeyword').keypress(function(e) {
		//     if(e.which == 13) {
		// 		$.fn.yiiGridView.update('product-grid', {
		// 			data: $(this).serialize()
		// 		});
		//         return false;
		//     }
		// });

        $('#Inventory_product_id').change(function(){
            $.fn.yiiGridView.update('inventory-grid', {
                data: $(this).serialize()
            });
            return false;
        });

		$('#Inventory_findkeyword').keypress(function(e) {
		    if(e.which == 13) {
				$.fn.yiiGridView.update('inventory-grid', {
					data: $(this).serialize()
				});
		        return false;
		    }
		});

		$('#Inventory_product_master_category_id,#Inventory_product_sub_master_category_id,#Inventory_product_sub_category_id,#Inventory_brand_id,#Product_sub_brand_id').change(function(){
		    $.fn.yiiGridView.update('inventory-grid', {
		        data: $('form').serialize()
		    });
		    return false;
		});


		
    ");
?>