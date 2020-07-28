			<!--Oil Specification-->
        	<div id="oil-specification" style="<?php echo $product->header->product_sub_category_id == 2 ? 'display: block;' : 'display: none;' ?>" class="additional-specification">
	        	<div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'category_usage'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php //echo $form->textField($productSpecificationOil,'category_usage',array('size'=>30,'maxlength'=>30)); ?>
						    <?php echo $form->dropDownList($productSpecificationOil, 'category_usage', array(
						    	'Engine'=>'Engine',
						    	'Transmission'=>'Transmission',
						    	'Differential/Gear'=>'Differential/Gear',
						    	'Brake'=>'Brake',
						    	'Power Steering'=>'Power Steering'
						    ), array(
						    	'prompt'=>'[-- Select Category --]'
						    )); ?>
							<?php echo $form->error($productSpecificationOil,'category_usage'); ?>
						</div>
		            </div>
		        </div>

	        	<div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'oil_type'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php //echo $form->textField($productSpecificationOil,'oil_type',array('size'=>30,'maxlength'=>30)); ?>
						    <?php echo $form->dropDownList($productSpecificationOil, 'oil_type', array(
						    	'Full Synthetic'=>'Full Synthetic',
						    	'Semi Synthetic'=>'Semi Synthetic',
						    ), array(
						    	'prompt'=>'[-- Select Oil Type --]'
						    )); ?>
							<?php echo $form->error($productSpecificationOil,'oil_type'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'transmission'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationOil, 'transmission', array(
						    	'Automatic'=>'Automatic',
						    	'Manual'=>'Manual',
						    ), array(
						    	'prompt'=>'[-- Select Transmission --]'
						    )); ?>
							<?php echo $form->error($productSpecificationOil,'transmission'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'code_serial'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationOil,'code_serial',array('size'=>30,'maxlength'=>30)); ?>
							<?php echo $form->error($productSpecificationOil,'code_serial'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'sub_brand_id'); ?></label>
		                </div>
		                <div class="small-8 columns">
				          	<?php echo $form->dropDownList($productSpecificationOil, 'sub_brand_id', $product->header->brand_id != '' ? CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id'=>$product->header->brand_id)), 'id', 'name') : array(),array(
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
				                        	jQuery("#ProductSpecificationOil_sub_brand_series_id").html(data);
				                    	},
				                	});'
				          		)
				          	); ?>

							<?php echo $form->error($productSpecificationOil,'sub_brand_id'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'sub_brand_series_id'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php //echo $form->textField($productSpecificationOil,'sub_brand_series_id'); ?>
						    <?php echo $form->dropDownList($productSpecificationOil, 'sub_brand_series_id', $productSpecificationOil->sub_brand_id != '' ? CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$productSpecificationOil->sub_brand_id)), 'id', 'name') : array(),array(
				               		'prompt' => '[--Select Sub Brand Series--]',
				                  	
				          		)
				          	); ?>
							<?php echo $form->error($productSpecificationOil,'sub_brand_series_id'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'fuel'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationOil, 'fuel', array(
						    	'Diesel'=>'Diesel',
						    	'Gasoline'=>'Gasoline',
						    ), array(
						    	'prompt'=>'[-- Select Fuel --]'
						    )); ?>
							<?php echo $form->error($productSpecificationOil,'fuel'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'dot_code'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationOil, 'oil_type', array(
						    	'3'=>'3',
						    	'4'=>'4',
						    	'5'=>'5'
						    ), array(
						    	'prompt'=>'[-- Select DOT Code --]'
						    )); ?>
							<?php echo $form->error($productSpecificationOil,'dot_code'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'viscosity_low_t'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php //echo $form->textField($productSpecificationOil,'viscosity_low_t',array('size'=>10,'maxlength'=>10)); ?>
						    <?php $range = range(5,100,5); ?>
							<?php echo CHtml::activeDropDownList($productSpecificationOil,'viscosity_low_t',array_combine($range, $range),array('prompt'=>'[-- Select Viscosity (Low T) --]')); ?>
							<?php echo $form->error($productSpecificationOil,'viscosity_low_t'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'viscosity_high'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php //echo $form->textField($productSpecificationOil,'viscosity_high',array('size'=>10,'maxlength'=>10)); ?>
						    <?php $range = range(20,100,10); ?>
							<?php echo CHtml::activeDropDownList($productSpecificationOil,'viscosity_high',array_combine($range, $range),array('prompt'=>'[-- Select Viscosity High --]')); ?>
							<?php echo $form->error($productSpecificationOil,'viscosity_high'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'api_code'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php //echo $form->textField($productSpecificationOil,'api_code',array('size'=>10,'maxlength'=>10)); ?>
						    <?php echo $form->dropDownList($productSpecificationOil, 'api_code', array(
						    	'SN'=>'SN',
						    	'SM'=>'SM',
						    	'SL'=>'SL',
						    	'SJ'=>'SJ',
						    	'SH'=>'SH',
						    	'SG'=>'SG',
						    	'SF'=>'SF',
						    	'CJ-4'=>'CJ-4',
						    	'CJ-4 Plus'=>'CJ-4 Plus',
						    	'CI-4'=>'CI-4',
						    	'CH-4'=>'CH-4',
						    	'CG-4'=>'CG-4',
						    	'CF-2'=>'CF-2',
						    	'CF-4'=>'CF-4',
						    	'CF'=>'CF',
						    	'CE'=>'CE',
						    	'CD-II'=>'CD-II',
						    	'CD'=>'CD',
						    ), array(
						    	'prompt'=>'[-- Select API Code --]'
						    )); ?>
							<?php echo $form->error($productSpecificationOil,'api_code'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'size_measurements'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php //echo $form->textField($productSpecificationOil,'size_measurements',array('size'=>10,'maxlength'=>10)); ?>
						    <?php echo $form->dropDownList($productSpecificationOil, 'size_measurements', array(
						    	'Piece'=>'Piece',
						    	'Gallon'=>'Gallon',
						    	'Drum'=>'Drum',
						    ), array(
						    	'prompt'=>'[-- Select Size --]'
						    )); ?>
							<?php echo $form->error($productSpecificationOil,'size_measurements'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'size'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationOil,'size',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($productSpecificationOil,'size'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'name'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationOil,'name',array('size'=>50,'maxlength'=>50)); ?>
							<?php echo $form->error($productSpecificationOil,'name'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'description'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textArea($productSpecificationOil,'description',array('rows'=>6, 'cols'=>50)); ?>
							<?php echo $form->error($productSpecificationOil,'description'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationOil,'car_use'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationOil,'car_use',array('size'=>30,'maxlength'=>30)); ?>
							<?php echo $form->error($productSpecificationOil,'car_use'); ?>
						</div>
		            </div>
		        </div>
		        
		    </div>
		    <!--End Oil Specification-->