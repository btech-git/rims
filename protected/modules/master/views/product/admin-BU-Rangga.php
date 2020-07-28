<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Product'=>array('admin'),
	'Products'=>array('admin'),
	'Manage Products',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
//$('#advsearch').click(function(){
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
		$('#Product_findkeyword').hide();
	}else {
		$('#Product_findkeyword').show();
		$(this).text('Advanced Search');
	}
	return false;
});

/*$('.search-form form').submit(function(){
	$('#product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
*/

$('form').submit(function(){
       $.fn.yiiGridView.update('product-grid', {
             data: $(this).serialize()
        });
         return false;
});

");
?>
<!-- BEGIN maincontent -->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.product.create")) { ?>
	<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/product/create';?>"><span class="fa fa-plus"></span>New Product</a>
			<?php }?>
	<h1>Manage Product</h1>
 
	<!-- BEGIN aSearch -->
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
					       				<?php echo $form->textField($model,'findkeyword', array('placeholder'=>'Find By Keyword', "style"=>"margin-bottom:0px;")); ?>
					       			</div>
	    							<div class="medium-2 columns">
					       				<?php echo $form->dropDownList($model, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'),
											array(
						               		'prompt' => '[--Select Product Master Category--]',"style"=>"margin-bottom:0px;"
						          			)
						          		);?>
					       			</div>
	    							<div class="medium-2 columns">
	    							<?php echo $form->dropDownList($model, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(), 'id', 'name'),
										array(
					               		'prompt' => '[--Select Product Sub Master Category--]',
										'onchange'=> 'jQuery.ajax({
											type: "POST",
											url: "' . CController::createUrl('ajaxGetProductSubCategory') . '",
											data: jQuery("form").serialize(),
											success: function(data){
												console.log(data);
												// jQuery("#Product_code").val("");
												// if(jQuery("#Product_product_sub_master_category_id").val() == ""){
												// 	jQuery(".additional-specification").slideUp();
												// }
												jQuery("#Product_product_sub_category_id").html(data);
											},
										});'
					               		))
	    							?>


					       			</div>
	    							<div class="medium-2 columns">
										<?php echo CHtml::dropDownList('Product[product_sub_category_id]', $model->product_sub_category_id,$model->product_sub_master_category_id != '' ? CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id'=>$model->product_sub_master_category_id)), 'id', 'name') : array(), array(
											'prompt' => '[--Select Product Sub Category--]',
											'onchange'=> 'jQuery.ajax({
												type: "POST",
												url: "' . CController::createUrl('ajaxGetCode') . '",
												data: jQuery("form").serialize(),
												success: function(data){
													console.log(data);
													// if(jQuery("#Product_product_sub_master_category_id").val() == ""){
													// 	jQuery(".additional-specification").slideUp();
													// }
													// jQuery("#Product_product_sub_category_id").html(data);
												},
											});'
											)
											);

										?>
					       			</div>
	    							<div class="medium-2 columns">

	    							<?php echo $form->dropDownList($model, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'),
							            array(
							            	'empty' => '[--Select a Brand--]',
											'onchange'=> 'jQuery.ajax({
							                  		type: "POST",
							                  		//dataType: "JSON",
							                  		url: "' . CController::createUrl('ajaxGetSubBrand') . '",
							                  		data: jQuery("form").serialize(),
							                  		success: function(data){
							                        	console.log(data);
							                        	jQuery("#Product_sub_brand_id").html(data);
							                    	},
							                	});'
											))
							        ?>

	    							</div>
	    							<div class="medium-2 columns">

	    							<?php echo CHtml::dropDownList('Product[sub_brand_id]', $model->brand_id,$model->brand_id != '' ? CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id'=>$model->brand_id)), 'id', 'name') : array(), array(
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


		<!-- BEGIN gridview -->
		<div class="grid-view">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'product-grid',
				'dataProvider'=>$model->search(),
				// 'filter'=>$model,
				'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
				'pager'=>array(
				   'cssFile'=>false,
				   'header'=>'',
				),
				'afterAjaxUpdate'=>'function(id, data){
	                	var textbold = $("#Product_findkeyword").val();
						var j = jQuery.noConflict();
						j("td").mark(textbold, {
						    "className": "higlig"
						});
           	    }',
				'columns'=>array(
					array (
						'class' 		 => 'CCheckBoxColumn',
						'selectableRows' => '2',	
						'header'		 => 'Selected',	
						'value' => '$data->id',				
					),
					array(
						'name'=>'product_master_category_id', 
						'value'=>'$data->productMasterCategory->name',
						'filter'=>CHtml::dropDownList('Product[product_master_category_id]', $model->product_master_category_id, CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'),
								array(
			               		'prompt' => '[--Select Product Master Category--]',
			                  	/*'onchange'=> 'jQuery.ajax({
			                  		type: "POST",
			                  		//dataType: "JSON",
			                  		url: "' . CController::createUrl('ajaxGetProductSubMasterCategory') . '",
			                  		data: jQuery("form").serialize(),
			                  		success: function(data){
			                        	console.log(data);
			                        	jQuery("#Product_code").val("");
			                        	jQuery("#Product_product_sub_master_category_id").html(data);
			                        	if(jQuery("#Product_product_sub_master_category_id").val() == ""){
			                        		jQuery(".additional-specification").slideUp();
					    					jQuery("#Product_product_sub_category_id").html("<option value=\"\">[--Select Product Sub Category--]</option>");
					    				}
			                    	},
			                	});'*/
			          			)
			          		)
					),
					// array(
					// 	'name'=>'product_master_category_id', 
					// 	'value'=>'$data->productMasterCategory->name',
					// 	'filter'=>CHtml::dropDownList('Product[product_master_category_id]', $model->product_master_category_id, CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'),
				 //            array('empty' => '(Select a Product Master)'))
					// ),
					// array('name'=>'product_sub_master_category_id', 'value'=>'$data->productSubMasterCategory->code'),
					array(
						'name'=>'product_sub_master_category_id', 
						'value'=>'$data->productSubMasterCategory->name',
						'filter'=>CHtml::dropDownList('Product[product_sub_master_category_id]', $model->product_sub_master_category_id,CHtml::listData(ProductSubMasterCategory::model()->findAll(), 'id', 'name'),
								array(
			               		'prompt' => '[--Select Product Sub Master Category--]',
			                  	/*'onchange'=> 'jQuery.ajax({
			                  		type: "POST",
			                  		url: "' . CController::createUrl('ajaxGetProductSubCategory') . '",
			                  		data: jQuery("form").serialize(),
			                  		success: function(data){
			                        	console.log(data);
			                        	jQuery("#Product_code").val("");
			                        	if(jQuery("#Product_product_sub_master_category_id").val() == ""){
			                        		jQuery(".additional-specification").slideUp();
			                        	}
			                        	jQuery("#Product_product_sub_category_id").html(data);
			                    	},
			                	});'*/
			          			)
			          		)
					),
					// array('name'=>'product_sub_category_id', 'value'=>'$data->productSubCategory->code'),
					array(
						'name'=>'product_sub_category_id', 
						'value'=>'$data->productSubCategory->name',
						'filter'=>CHtml::dropDownList('Product[product_sub_category_id]', $model->product_sub_category_id, CHtml::listData(ProductSubCategory::model()->findAll(), 'id', 'name'),
							array(
				            	'prompt' => '[--Select Product Sub Category--]',
				            	/*'onchange'=> 'jQuery.ajax({
			                  		type: "POST",
			                  		url: "' . CController::createUrl('ajaxGetCode') . '",
			                  		data: jQuery("form").serialize(),
			                  		success: function(data){
			                        	console.log(data);
			                    	},
			                	});'*/
			          			)
			          		)
					),
					array(
						'name'=>'brand_id', 
						'value'=>'$data->brand->name',
						'filter'=>CHtml::dropDownList('Product[brand_id]', $model->brand_id, CHtml::listData(Brand::model()->findAll(), 'id', 'name'),
				            array(
				            	'empty' => '[--Select a Brand--]',
								'style'=>'width:150px !important',
				            )
				        )
				    ),
					//'id',
					//'code',
					//'name',
					array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
					//'description',
					'production_year',
					//array('name'=>'product_master_category_id', 'value'=>'$data->productMasterCategory->code'),
					'manufacturer_code',
					/*
					'vehicle_car_make_id',
					'vehicle_car_model_id',
					'purchase_price',
					'recommended_selling_price',
					'hpp',
					'retail_price',
					'minimum_stock',
					'margin_type',
					'margin_amount',
					*/
					array(
						'class'=>'CButtonColumn',
						'template'=>'{price} {edit}',
						'buttons'=>array
						(
							'price' => array
							(
								'label'=>'price',
								'url'=>'Yii::app()->createUrl("master/product/ajaxHtmlPrice", array("id"=>$data->id))',
								'options' => array(  
									'ajax' => array(
										'type' => 'POST',
										// ajax post will use 'url' specified above 
										'url' => 'js: $(this).attr("href")',
										'success' => 'function(html) {
											$("#price_div").html(html);
											$("#price-dialog").dialog("open");
										}',
									),
								),
							),
							'edit' => array
							(
								'label'=>'edit',
								'url'=>'Yii::app()->createUrl("master/product/update", array("id"=>$data->id))',
							),

						),
					),
				),
			)); ?>

		</div>
		<!-- END gridview -->



</div>
<!-- END maincontent -->		
</div>

<!--Price Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'price-dialog',
        'options'=>array(
            'title'=>'Price List',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'480',
        ),
 )); ?>
 
<div id="price_div"></div>

<?php $this->endWidget(); ?>

<?php 
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.mark.min.js', CClientScript::POS_HEAD,array('charset'=>'UTF-8'));
    Yii::app()->clientScript->registerScript('search',"

    	$('#Product_findkeyword').keypress(function(e) {
		    if(e.which == 13) {
				$.fn.yiiGridView.update('product-grid', {
					data: $(this).serialize()
				});
		        return false;
		    }
		});

        $('#Product_product_master_category_id,#Product_product_sub_master_category_id,#Product_product_sub_category_id,#Product_brand_id,#Product_sub_brand_id').change(function(){
            $.fn.yiiGridView.update('product-grid', {
                data: $(this).serialize()
            });
            return false;
        });

		
    ");
?>