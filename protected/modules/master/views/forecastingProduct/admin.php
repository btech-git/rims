<?php
/* @var $this ForecastingProductController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Inventories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Inventory', 'url'=>array('index')),
	array('label'=>'Create Inventory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
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
	<div id="maincontent">
			<div class="clearfix page-action">
<h1>Forecasting Product</h1>

	<!-- BEGIN aSearch -->
	<div class="search-bar">

			<div class="clearfix button-bar">
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
												jQuery("#Inventory_product_sub_category_id").html(data);
											},
										});'
					               		))
	    							?>
					       			</div>
	    							<div class="medium-2 columns">
										<?php echo CHtml::dropDownList('Inventory[product_sub_category_id]', $model->product_sub_category_id,$model->product_sub_master_category_id != '' ? CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id'=>$model->product_sub_master_category_id)), 'id', 'name') : array(), array(
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

	    							<?php /*<div class="medium-2 columns">
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
							                        	jQuery("#Inventory_sub_brand_id").html(data);
							                    	},
							                	});'
											))
							        ?>
	    							</div>*/?>
	    							<div class="medium-4 columns">
		    							<div class="row">
		                                    <div class="small-6 columns">
		                                        <?php
		                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
														'model'=>$model,
														'attribute'=>'date1',
														'id'=>'dateranger1',
		                                                // 'name'=>'dateranger[]',
		                                                'options'=>array(
		                                                    'dateFormat'=>'yy-mm-dd',
		                                                ),
		                                                'htmlOptions'=>array(
		                                                    // 'readonly'=>true,
		                                                    'placeholder'=>'Tanggal Mulai',
		                                                ),
		                                            ));
		                                        ?>
		                                    </div>
		                                    <div class="small-6 columns">
		                                        <?php
		                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		                                            	'model'=>$model,
		                                                'attribute'=>'date2',
														'id'=>'dateranger2',
		                                                // 'name'=>'dateranger[]',
		                                                'options'=>array(
		                                                    'dateFormat'=>'yy-mm-dd',
		                                                ),
		                                                'htmlOptions'=>array(
		                                                    // 'readonly'=>true,
		                                                    'placeholder'=>'Tanggal Akhir',
		                                                ),
		                                            ));
		                                        ?>
		                                    </div>
	                                        <p><em>jika tanggal tidak di pilih default total semua rata rata penjualan.</em></p>
		    							</div>
						          	</div>
						          </div>
								<?php $this->endWidget(); ?>
							</div>
							<?php /*<div class="medium-2 columns">
								<a href="#" class="search-button right button cbutton secondary" id="advsearch" style="display: none;">Advanced Search</a>	
							</div>*/?>
						</div>

	         			
						</div>
				</div>

				<div class="clearfix"></div>
		</div>
		<!-- END aSearch -->		
<?php //echo (isset($_GET['Inventory[date1]']))?"a":"b"; ?>

<div class="grid-view">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inventory-grid',
	'dataProvider'=>$model->search(),
	'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),

	// 'filter'=>$model,
	'columns'=>array(
		// 'id',
		// 'product_id',
		array(
			'name'=>'product_name', 
			'value'=>'CHTml::link($data->product->name, array("/master/product/view", "id"=>$data->product_id))', 
			'type'=>'raw'
		),
		[
			'name'=>'manufacturer_code',
			'value'=>'$data->product->manufacturer_code'
		],
		[
			'name'=>'code',
			'value'=>'$data->product->code'
		],
		[
			'name'=>'warehouse_id',
			'value'=>'!empty($data->warehouse->name)?$data->warehouse->name:"-"',
            'filter'=>CHtml::listData(Warehouse::model()->findAll(), 'id', 'name'),
		],
		[
			'header'=>'Rata Rata Penjualan',
			'value'=>'CHtml::hiddenField("Inventory[rata]",$data->getAverageMovementOut($data->id,(isset($_GET["Inventory"]["date1"])?$_GET["Inventory"]["date1"]:0),(isset($_GET["Inventory"]["date2"])?$_GET["Inventory"]["date2"]:0))).$data->getAverageMovementOut($data->id,(isset($_GET["Inventory"]["date1"])?$_GET["Inventory"]["date1"]:0),(isset($_GET["Inventory"]["date2"])?$_GET["Inventory"]["date2"]:0))',
			'type'=>'raw'
		],
		[
			'name'=>'total_stock',
			'value'=>'CHtml::hiddenField("Inventory[total_stock]",$data->total_stock).$data->total_stock',
			'type'=>'raw'
		],

		// 'total_stock',
		[
			'header'=>'kategori',
			'name'=>'category',
			'value'=>'CHtml::dropDownList("Inventory[category]", "$data->category", 
						array(
							""=>"[--Pilih Kategori--]",
							"1.5" => "Fast",
							"1" => "Normal",
							"0.5" => "Slow",
							"0" => "Dead",
						)
					)',
			'type'=>'raw'
		],
		[
			'header'=>'Hasil',
			'name'=>'inventory_result',
			'value'=>'!empty($data->inventory_result)?$data->inventory_result:CHtml::textField("Inventory[result]","$data->inventory_result",["id"=>"result_$data->id","disabled"=>"disabled"])',
			'type'=>'raw',
		],
		[
	        'value'=>'CHtml::button("SAVE",array("id"=>"btnsave","rel"=>"$data->id", "class"=>"button cbutton secondary", "style"=>"background-color:#767171; color:#fff;"))',
	        'type'=>"raw"
		],
		// 'manufacturer_code',
		// 'warehouse_id',
		// 'minimal_stock',
		// 'status',
		/*array(
			'class'=>'CButtonColumn',
			'template'=>'{save}',
			'buttons'=>array
			(
				'save' => array
				(
					'label'=>'Save',
					// 'url'=>'Yii::app()->createUrl("master/forecastingProduct/calculate", array("id"=>$data->id))',
					'visible'=>'(Yii::app()->user->checkAccess("master.forecastingProduct.admin"))',
					'click'=>'js:function(){
					}',
					'options'=>[
						'rel'=>'".$data->id."',
					]
				),
			),
		),*/
	),
)); ?>
		</div>
		<!-- END gridview -->
</div>
<!-- END maincontent -->		
</div>

<?php
	Yii::app()->clientScript->registerScript('myforecastingProduct', '
		$("body").on("click","#btnsave",function(){
			var id = $(this).attr("rel");
			var data={};
			var product_result = "";
			var sibs=$(this).parent().siblings();
			data.inventory_id=id;
			data.product_name=$(sibs[0]).children().html();
			data.product_average=$(sibs[4]).children().val();
			data.product_stock=$(sibs[5]).children().val();
			data.product_category=$(sibs[6]).children().val();
			// console.log($("#Inventory_total_stock"));
			if (data.product_category == "") {
				alert("silahkan pilih kategori")
			}else{
				// console.log(data);
				// product_result = (data.product_average * data.product_stock * data.product_category);
				// $("#result_"+id).val(product_result);
				$.ajax({
				    "url":"'.CHtml::normalizeUrl(array("forecastingProduct/calculate")).'",
				    "data":data,
				    "type":"POST",
				    "success":function(data){
				    	console.log(data);
				    	$("#inventory-grid").yiiGridView("update",{});
				    },
				})
			}
			return false;
		});
    ', CClientScript::POS_END);
?>


<?php 
    Yii::app()->clientScript->registerScript('search',"
    	$('#inventory-grid').hide();
        $('#Inventory_product_id').change(function(){
            $.fn.yiiGridView.update('inventory-grid', {
                data: $(this).serialize()
            });
            return false;
        });

        // $('#dateranger1').change(function(){
        // 	var dateranger_val1 = $(this).val();

        // 	console.log(dateranger_val1);
        //     // $.fn.yiiGridView.update('inventory-grid', {
        //     //     data: $(this).serialize()
        //     // });
        //     return false;
        // });

        $('#dateranger2').change(function(){
        	var dateranger_val1 = $('#dateranger1').val();

        	if ((dateranger_val1 == '')) {
        		alert('tanggal mulai tidak boleh kosong');
        		$(this).val('');
	            return false;
        	}else{
	            $.fn.yiiGridView.update('inventory-grid', {
	                data: $('form').serialize()
	            });
	            return false;
        	}

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
	        // console.log($('form').serialize());
		    return false;
		});
		
    ");
?>