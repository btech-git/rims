<?php
/* @var $this FindProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Products',
	);
	?>
<fieldset class="fieldset" style="background-color:#FFF;">
  <legend>Find Products</legend>
	<div class="row" id="carikeyword">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route),
			'method'=>'get',
		)); ?>
		<div class="medium-3 columns">
				<label>
					<?php echo $form->textField($modelKeyword,'findkeyword', array('placeholder'=>'Find By Keyword')); ?>
				</label>
		</div>
		<div class="medium-9 columns">
				<div class="row">
					<div class="medium-4 columns">
						<label>
							<?php echo CHtml::dropDownList('Product[product_master_category_id]', $modelFilter->product_master_category_id, CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'), array(
								'prompt' => '[--Select Product Master Category--]',
								'onchange'=> 'jQuery.ajax({
									type: "POST",
				                  		//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetProductSubMasterCategory') . '",
									data: jQuery("form").serialize(),
									success: function(data){
										console.log(data);
										// jQuery("#Product_code").val("");
										jQuery("#Product_product_sub_master_category_id").html(data);
										if(jQuery("#Product_product_sub_master_category_id").val() == ""){
											jQuery(".additional-specification").slideUp();
											jQuery("#Product_product_sub_category_id").html("<option value=\"\">[--Select Product Sub Category--]</option>");
										}
									},
								});'
								)
							);
							?>
						</label>
					</div>
					<div class="medium-4 columns">
						<?php echo CHtml::dropDownList('Product[product_sub_master_category_id]', $modelFilter->product_sub_master_category_id, $modelFilter->product_master_category_id != '' ? CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id'=>$modelFilter->product_master_category_id)), 'id', 'name') : array(), array(
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
							)
						);
						?>

						<?php
						echo CHtml::dropDownList('Product[brand_id]', $modelFilter->brand_id, CHtml::listData(Brand::model()->findAll(), 'id', 'name'), array(
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
							)
						);
						?>


					</div>
					<div class="medium-4 columns" >
						<?php echo CHtml::dropDownList('Product[product_sub_category_id]', $modelFilter->product_sub_category_id,$modelFilter->product_sub_master_category_id != '' ? CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id'=>$modelFilter->product_sub_master_category_id)), 'id', 'name') : array(), array(
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

						<?php echo CHtml::dropDownList('Product[sub_brand_id]', $modelFilter->brand_id,$modelFilter->brand_id != '' ? CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id'=>$modelFilter->brand_id)), 'id', 'name') : array(), array(
							'prompt' => '[--Select Sub Brand--]',
							)
							);

						?>
					</div>
	                <?php //echo CHtml::submitButton('Search', array('class'=>'btn btn-primary btn-block')); ?>
				</div>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</fieldset>

<p></p>
	<div class="row">
		<div class="medium-12 columns" style="display:none;" id="rowFindByFilter">
			<?php 
			$this->widget('zii.widgets.CListView', array(
				'id'=>'findByFilter',
				'dataProvider'=>$modelFilter->search(),
				'itemView'=>'_findFilter',
				'template' => '{items}<div class="clearfix">{summary}{pager}</div>',				
				'pager'=>array(
					'cssFile'=>false,
					'header'=>'',
					),

				)); 
				?>
		</div>		
		<div class="medium-12 columns" style="display:none;" id="rowFindByKeyword">
			<?php 
				$this->widget('zii.widgets.CListView', array(
					'id'=>'findByKeyword',
					'dataProvider'=>$modelKeyword->searchKeyword(),
					'itemView'=>'_findKeyword',
					'template' => '{items}<div class="clearfix">{summary}{pager}</div>',				
					'pager'=>array(
						'cssFile'=>false,
						'header'=>'',
						),
	                'afterAjaxUpdate'=>'function(id, data){
	                	var textbold = $("#Findproduct_findkeyword").val();
						var j = jQuery.noConflict();
						j(".higlig").mark(textbold, {
						    "className": "higlig"
						});
           	        }',
				));
			?>

		</div>		
	</div>
<?php 
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.mark.min.js', CClientScript::POS_HEAD,array('charset'=>'UTF-8'));
    Yii::app()->clientScript->registerScript('search',"
        var ajaxUpdateTimeout;
        var ajaxRequest;
        $('#Findproduct_findkeyword').keyup(function(){
            ajaxRequest = $(this).serialize();
            clearTimeout(ajaxUpdateTimeout);
            ajaxUpdateTimeout = setTimeout(function () {
	            $('#rowFindByFilter').hide();
	            $('#rowFindByKeyword').show();
                $.fn.yiiListView.update(
                    'findByKeyword',
                    {data: ajaxRequest}
                );
            },
            300);
        });
        
        $('#carikeyword form').submit(function(){
            $('#rowFindByFilter').hide();
            $('#rowFindByKeyword').show();
            $.fn.yiiListView.update(
                'findByKeyword',
                {data: ajaxRequest}
            );
            return false;
        });

        $('#Product_product_master_category_id,#Product_product_sub_master_category_id,#Product_product_sub_category_id,#Product_brand_id,#Product_sub_brand_id').change(function(){
            $('#rowFindByFilter').show();
            $('#rowFindByKeyword').hide();
            $.fn.yiiListView.update('findByFilter', {
                data: $(this).serialize()
            });
            return false;
        });

		
    ");
?>