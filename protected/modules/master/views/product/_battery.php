			<!--Battery Specification-->
        	<div id="battery-specification" style="<?php echo $product->header->product_sub_category_id == 1 ? 'display: block;' : 'display: none;' ?>" class="additional-specification">
	        	<div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'category'); ?></label>
		                </div>
		                <div class="small-8 columns">
						   	<?php echo $form->dropDownList($productSpecificationBattery, 'category', array(
						    	'AMB'=>'AMB',
						    )); ?>
							<?php echo $form->error($productSpecificationBattery,'category'); ?>
						</div>
		            </div>
		        </div>

	        	<div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'type'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationBattery, 'type', array(
						    	'Hybrid'=>'Hybrid',
						    	'Maintenance Free'=>'Maintenance Free',
						    	'Conventional'=>'Conventional'
						    )); ?>
							<?php echo $form->error($productSpecificationBattery,'type'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'parts_serial_number'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationBattery,'parts_serial_number',array('size'=>30,'maxlength'=>30)); ?>
							<?php echo $form->error($productSpecificationBattery,'parts_serial_number'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'sub_brand_id'); ?></label>
		                </div>
		                <div class="small-8 columns">
				          	<?php echo $form->dropDownList($productSpecificationBattery, 'sub_brand_id', $product->header->brand_id != '' ? CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id'=>$product->header->brand_id)), 'id', 'name') : array(),array(
				               		'prompt' => '[--Select Sub Brand--]',
				                  	'onchange'=> 'jQuery.ajax({
				                  		type: "POST",
				                  		url: "' . CController::createUrl('ajaxGetSubBrandSeries') . '",
				                  		data: jQuery("form").serialize(),
				                  		success: function(data){
				                        	console.log(data);
				                        	//if(jQuery("#Product_product_sub_master_category_id").val() == ""){
				                        		//jQuery(".additional-specification").slideUp();
				                        	//}
				                        	jQuery("#ProductSpecificationBattery_sub_brand_series_id").html(data);
				                        	jQuery("#ProductSpecificationOil_sub_brand_series_id").html(data);
				                    	},
				                	});'
				          		)
				          	); ?>

							<?php echo $form->error($productSpecificationBattery,'sub_brand_id'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'sub_brand_series_id'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php //echo $form->textField($productSpecificationBattery,'sub_brand_series_id'); ?>
						    <?php echo $form->dropDownList($productSpecificationBattery, 'sub_brand_series_id', $productSpecificationBattery->sub_brand_id != '' ? CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$productSpecificationBattery->sub_brand_id)), 'id', 'name') : array(),array(
				               		'prompt' => '[--Select Sub Brand Series--]',
				                  	
				          		)
				          	); ?>
							<?php echo $form->error($productSpecificationBattery,'sub_brand_series_id'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'voltage'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationBattery,'voltage'); ?>
							<?php echo $form->error($productSpecificationBattery,'voltage'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'amp'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationBattery,'amp'); ?>
							<?php echo $form->error($productSpecificationBattery,'amp'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'capacity'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationBattery,'capacity'); ?>
							<?php echo $form->error($productSpecificationBattery,'capacity'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'description'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textArea($productSpecificationBattery,'description',array('rows'=>6, 'cols'=>50)); ?>
							<?php echo $form->error($productSpecificationBattery,'description'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'car_type'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationBattery,'car_type',array('size'=>30,'maxlength'=>30)); ?>
							<?php echo $form->error($productSpecificationBattery,'car_type'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationBattery,'size'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationBattery,'size'); ?>
							<?php echo $form->error($productSpecificationBattery,'size'); ?>
						</div>
		            </div>
		        </div>
		    </div>
		    <!--End Battery Specification-->