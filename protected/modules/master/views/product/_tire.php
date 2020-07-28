			<!--Tire Specification-->
        	<div id="tire-specification" style="<?php echo $product->header->product_sub_category_id == 3 ? 'display: block;' : 'display: none;' ?>" class="additional-specification">
	        	<div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'serial_number'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationTire,'serial_number',array('size'=>30,'maxlength'=>30)); ?>
							<?php echo $form->error($productSpecificationTire,'serial_number'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'type'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationTire, 'type', array(
						    	'Radial'=>'Radial',
						    	'Bias'=>'Bias',
						    ), array(
						    	'prompt'=>'[-- Select Type --]'
						    )); ?>
							<?php echo $form->error($productSpecificationTire,'type'); ?>
						</div>
		            </div>
		        </div>

	        	<div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'sub_brand_id'); ?></label>
		                </div>
		                <div class="small-8 columns">
				          	<?php echo $form->dropDownList($productSpecificationTire, 'sub_brand_id', $product->header->brand_id != '' ? CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id'=>$product->header->brand_id)), 'id', 'name') : array(),array(
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
				                        	jQuery("#ProductSpecificationTire_sub_brand_series_id").html(data);
				                    	},
				                	});'
				          		)
				          	); ?>

							<?php echo $form->error($productSpecificationTire,'sub_brand_id'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'sub_brand_series_id'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php //echo $form->textField($productSpecificationTire,'sub_brand_series_id'); ?>
						    <?php echo $form->dropDownList($productSpecificationTire, 'sub_brand_series_id', $productSpecificationTire->sub_brand_id != '' ? CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$productSpecificationTire->sub_brand_id)), 'id', 'name') : array(),array(
				               		'prompt' => '[--Select Sub Brand Series--]',
				                  	
				          		)
				          	); ?>
							<?php echo $form->error($productSpecificationTire,'sub_brand_series_id'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'attribute'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationTire,'attribute',array('size'=>30,'maxlength'=>30)); ?>
							<?php echo $form->error($productSpecificationTire,'attribute'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'overall_diameter'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationTire,'overall_diameter'); ?>
							<?php echo $form->error($productSpecificationTire,'overall_diameter'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'section_width_inches'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationTire,'section_width_inches'); ?>
							<?php echo $form->error($productSpecificationTire,'section_width_inches'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'section_width_mm'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php $range = range(150,300,5); ?>
							<?php echo CHtml::activeDropDownList($productSpecificationTire,'section_width_mm',array_combine($range, $range),array('prompt'=>'[-- Select Section Width (mm) --]')); ?>
							<?php echo $form->error($productSpecificationTire,'section_width_mm'); ?>
						</div>
		            </div>
		        </div>
		        
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'aspect_ratio'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php $range = range(30,80); ?>
							<?php echo CHtml::activeDropDownList($productSpecificationTire,'aspect_ratio',array_combine($range, $range),array('prompt'=>'[-- Select Section Width (mm) --]')); ?>
							<?php echo $form->error($productSpecificationTire,'aspect_ratio'); ?>
						</div>
		            </div>
		        </div>
		        
				<div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'radial_type'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationTire, 'radial_type', array(
						    	'HR'=>'HR',
						    	'WR'=>'WR',
						    	'V'=>'V',
						    	'VR'=>'VR',
						    	'VVR'=>'VVR',
						    	'R'=>'R',
						    ), array(
						    	'prompt'=>'[-- Select Radial Type --]'
						    )); ?>
							<?php echo $form->error($productSpecificationTire,'radial_type'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'rim_diameter'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php $range = range(10,25); ?>
							<?php echo CHtml::activeDropDownList($productSpecificationTire,'rim_diameter',array_combine($range, $range),array('prompt'=>'[-- Select Rim Diameter --]')); ?>
							<?php echo $form->error($productSpecificationTire,'rim_diameter'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'load_index'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php $range = range(70,130); ?>
							<?php echo CHtml::activeDropDownList($productSpecificationTire,'load_index',array_combine($range, $range),array('prompt'=>'[-- Select Load Index --]')); ?>
							<?php echo $form->error($productSpecificationTire,'load_index'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'speed_symbol'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationTire, 'speed_symbol', array(
						    	'R'=>'R',
						    	'S'=>'S',
						    	'T'=>'T',
						    	'U'=>'U',
						    	'V'=>'V',
						    	'W'=>'W',
						    	'X'=>'X',
						    	'Y'=>'Y',
						    	'Z'=>'Z',
						    ), array(
						    	'prompt'=>'[-- Select Lettering --]'
						    )); ?>
							<?php echo $form->error($productSpecificationTire,'speed_symbol'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'ply_rating'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php $range = range(6,10); ?>
							<?php echo CHtml::activeDropDownList($productSpecificationTire,'ply_rating',array_combine($range, $range),array('prompt'=>'[-- Select Ply Rating --]')); ?>
							<?php echo $form->error($productSpecificationTire,'ply_rating'); ?>
						</div>
		            </div>
		        </div>

		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'lettering'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationTire, 'lettering', array(
						    	'OWT'=>'OWT',
						    	'OWL'=>'OWL',
						    	'RWT'=>'RWT',
						    	'RWL'=>'RWL',
						    ), array(
						    	'prompt'=>'[-- Select Lettering --]'
						    )); ?>
							<?php echo $form->error($productSpecificationTire,'lettering'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'terrain'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationTire, 'terrain', array(
						    	'AT'=>'AT',
						    	'MT'=>'MT',
						    ), array(
						    	'prompt'=>'[-- Select Terrain --]'
						    )); ?>
							<?php echo $form->error($productSpecificationTire,'terrain'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'local_import'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->dropDownList($productSpecificationTire, 'local_import', array(
						    	'Local'=>'Local',
						    	'Import'=>'Import',
						    ), array(
						    	'prompt'=>'[-- Select Local/Import --]'
						    )); ?>
							<?php echo $form->error($productSpecificationTire,'local_import'); ?>
						</div>
		            </div>
		        </div>
		        <div class="field">
		            <div class="row collapse">
		                <div class="small-4 columns">
		                  <label class="prefix"><?php echo $form->labelEx($productSpecificationTire,'car_type'); ?></label>
		                </div>
		                <div class="small-8 columns">
						    <?php echo $form->textField($productSpecificationTire,'car_type',array('size'=>10,'maxlength'=>10)); ?>
							<?php echo $form->error($productSpecificationTire,'car_type'); ?>
						</div>
		            </div>
		        </div>

		    </div>
		    <!--End Tire Specification-->