<?php
/* @var $this CustomerController */
/* @var $model Customer */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/customer/admin';?>"><span class="fa fa-th-list"></span>Manage Customer</a>
<h1><?php if($customer->header->isNewRecord){ echo "New Customer"; }else{ echo "Update Customer";}?></h1>
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>false,
)); ?>
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($customer->header); ?>
	<?php echo $form->errorSummary($customer->phoneDetails); ?>
	<?php echo $form->errorSummary($customer->mobileDetails); ?>
	<?php echo $form->errorSummary($customer->vehicleDetails); ?>


	<div class="row">
		<div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'customer_type'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'customer_type',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->dropDownList($customer->header,'customer_type', array(
                            ''=>'[--Select Customer Type--]',
                            'Individual'=>'Individual',
                            'Company'=>'Company',
                        ), array(
                            'onchange' => '
                                clearFields();
                                if(jQuery("#Customer_customer_type").val()=="Company"){
                                    jQuery("#birthdate").hide();
                                    jQuery("#coa").show();
                                    jQuery("#birthdate").val()=="0000-00-00";
                                    jQuery("#flatrate").show();
                                } else {
                                    //clearFields();
                                    jQuery("#coa").hide();
                                    jQuery("#birthdate").show();
                                    jQuery("#flatrate").hide();
                                }
                            '
                        ));?>
						<?php echo $form->error($customer->header,'customer_type'); ?>
					</div>
				</div>			
			</div>
			<div id="coa">
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<label class="prefix"><?php echo $form->labelEx($customer->header,'coa_id'); ?></label>
						</div>
						<div class="small-8 columns">
							<?php echo $form->hiddenField($customer->header,'coa_id'); ?>
							<?php echo $form->textField($customer->header,'coa_name',array('readonly'=>true,'onclick'=>'jQuery("#coa-dialog").dialog("open"); return false;','value'=>$customer->header->coa_id != "" ? $customer->header->coa->name :'')); ?>
							<?php echo $form->textField($customer->header,'coa_code',array('readonly'=>true,'value'=>$customer->header->coa_id != "" ? $customer->header->coa->code :'')); ?>
							<?php echo $form->error($customer->header,'coa_id'); ?>
						</div>
					</div>			
				</div>
			</div>
			
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($customer->header,'name',array('size'=>60,'maxlength'=>100,'style'=>'text-transform: capitalize')); ?>
						<?php echo $form->error($customer->header,'name'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'address'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($customer->header,'address',array('rows'=>6, 'cols'=>50));; ?>
						<?php echo $form->error($customer->header,'address'); ?>
					</div>
				</div>			
			</div>
			
			<div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($customer->header,'province_id'); ?></label>
                </div>
                <div class="small-8 columns">
				    <?php //echo  $form->dropDownList($model, 'province_id',  array('prompt' => 'Select',)); ?>
					<?php echo $form->dropDownList($customer->header, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'), array(
                        'prompt' => '[--Select Province--]',
                        'onchange'=> 'jQuery.ajax({
                            type: "POST",
                            //dataType: "JSON",
                            url: "' . CController::createUrl('ajaxGetCity') . '" ,
                            data: jQuery("form").serialize(),
                            success: function(data){
                                console.log(data);
                                jQuery("#Customer_city_id").html(data);
                            },
                        });'
					)); ?>
					<?php echo $form->error($customer->header,'province_id'); ?>
				</div>
            </div>
         </div>
		 
		 <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($customer->header,'city_id'); ?></label>
                </div>
                <div class="small-8 columns">
				    <?php //echo  $form->dropDownList($model, 'city_id',	 array('prompt' => 'Select',)); ?>
					<?php //echo $form->textField($model,'city_id',array('size'=>10,'maxlength'=>10)); ?>
					<?php
                        if ($customer->header->province_id == NULL) {
                            echo $form->dropDownList($customer->header,'city_id',array(),array('prompt'=>'[--Select City-]'));
                        }
                        else {
                            echo $form->dropDownList($customer->header,'city_id',CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$customer->header->province_id)), 'id', 'name'),array());
                        }
						?>
					<?php echo $form->error($customer->header,'city_id'); ?>
				</div>
            </div>
         </div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'zipcode'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($customer->header,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($customer->header,'zipcode'); ?>
					</div>
				</div>			
			</div>
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix required" ><?php echo 'Mobiles *' ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::button('+', array(
							'id' => 'detail-mobile-button',
							'name' => 'DetailMobile',
							'onclick' => '
								jQuery.ajax({
									type: "POST",
									url: "' . CController::createUrl('ajaxHtmlAddMobileDetail', array('id' => $customer->header->id)) . '",
									data: jQuery("form").serialize(),
									success: function(html) {
										jQuery("#mobile").html(html);
									},
								});
                            ',
                        )); ?>
					</div>
				</div>
			</div>
			<div class="field" id="mobile">
                <div class="row collapse">
			<!-- 	<div class="row collapse">
					<div class="small-4 columns"></div>
					<div class="small-8 columns"> -->
                    <?php $this->renderPartial('_detailMobile', array('customer'=>$customer)); ?>
				</div>
					<!-- </div>
				</div> -->
				
				
			</div>
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo 'Phones' ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::button('+', array(
							'id' => 'detail-button',
							'name' => 'Detail',
							'onclick' => '
								jQuery.ajax({
									type: "POST",
									url: "' . CController::createUrl('ajaxHtmlAddPhoneDetail', array('id' => $customer->header->id)) . '",
									data: jQuery("form").serialize(),
									success: function(html) {
										jQuery("#phone").html(html);
									},
								});',

							)
						); ?>
					</div>
				</div>
			</div>
			<div class="field" id="phone">
				<div class="row collapse">
					<?php $this->renderPartial('_detailPhone', array(
						'customer'=>$customer
						
					)); ?>
				</div>
				
			</div>
			
			<!-- <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php //echo $form->labelEx($model,'phone'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
						<?php //echo $form->error($model,'phone'); ?>
					</div>
				</div>			
			</div> -->
			
			<!-- <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php //echo $form->labelEx($model,'mobile_phone'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'mobile_phone',array('size'=>20,'maxlength'=>20)); ?>
						<?php //echo $form->error($model,'mobile_phone'); ?>
					</div>
				</div>			
			</div> -->

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'fax'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($customer->header,'fax',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($customer->header,'fax'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'email'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($customer->header,'email',array('size'=>60,'maxlength'=>100)); ?>
						<?php echo $form->error($customer->header,'email'); ?>
					</div>
				</div>			
			</div>
			

			<div class="field" id="birthdate" style="<?php echo $customer->header->customer_type == 'Company' ? 'display:none':'display:block' ?>" >
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'birthdate'); ?></label>
					</div>
					<div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $customer->header,
                             'attribute' => "birthdate",
                             // additional javascript options for the date picker plugin
                             'options'=>array(
                                 'dateFormat' => 'yy-mm-dd',
                                 'changeMonth'=>true,
                                 'changeYear'=>true,
                                 'yearRange'=>'1900:2020'
                             ),
                              'htmlOptions'=>array(

                                //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                ),
                         )); ?>
						<?php echo $form->error($customer->header,'birthdate'); ?>
					</div>
				</div>			
			</div>
			
			
			<div class="field" id="flatrate">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'flat_rate'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($customer->header,'flat_rate',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($customer->header,'flat_rate'); ?>
					</div>
				</div>			
			</div>
        </div>
        <div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'default_payment_type'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'customer_type',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->dropDownList($customer->header,'default_payment_type', array(
                            ''=>'[--Select Payment Type--]',
                            '1'=>'Cash, Credit, Debit',
                            '2'=>'Down Payment',
                            '3'=>'Terms of Payment',
                        ));?>
						<?php echo $form->error($customer->header,'default_payment_type'); ?>
					</div>
				</div>			
			</div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'tenor'); ?></label>
					</div>
					<div class="small-3 columns">
						<?php $range = range(10,100,5 ); ?>
						<?php echo $form->dropDownList($customer->header,'tenor',array_combine($range, $range),array('prompt'=>'[--Select Tenor--]')); ?>

						<?php echo $form->error($customer->header,'tenor'); ?>
					</div>
					<div class="small-5 columns">
						<?php echo ' &nbsp; days'; ?>
					</div>
				</div>			
			</div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($customer->header,'note'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($customer->header,'note',array('rows'=>6, 'cols'=>50));; ?>
						<?php echo $form->error($customer->header,'note'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($customer->header,'status'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($customer->header, 'status', array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($customer->header,'status'); ?>
					</div>
				</div>
			</div>	
            
			<div>
                <div>
					 <?php echo CHtml::button('Add Service Price Exception', array(
                        'id' => 'detail-price-button',
                        'name' => 'DetailPrice',
                        'class'=>'button extra left',
                        'onclick' => 'jQuery("#service-dialog").dialog("open"); return false;',

                    )); ?>
                </div> 
                <div class="clearfix"></div>	 
            </div>
            <div id="price">
                <?php $this->renderPartial('_detailPrice', array('customer'=>$customer)); ?>
            </div>
         </div>
    </div>
    <div class="small-12 medium-5b columns">
		<!-- begin RIGHT -->
		<?php echo CHtml::button('Add PIC', array(
            'id' => 'detail-button',
            'name' => 'Detail',
            'class'=>'button extra right',
            'onclick' => '
                jQuery.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddPicDetail', array('id' => $customer->header->id)) . '",
                    data: jQuery("form").serialize(),
                    success: function(html) {
                        jQuery("#pic").html(html);
                    },
                });
            ',
        )); ?>
		<h2>PIC</h2>
		<div id="pic">
            <?php $this->renderPartial('_detailPic', array('customer'=>$customer)); ?>
        </div>
		<div class="clearfix"></div>
	 </div>
	 <div class="small-12 medium-5b columns">
		<?php echo CHtml::button('Add Vehicle', array(
            'id' => 'detail-vehicle-button',
            'name' => 'Detail',
            'class'=>'button extra right',
            'onclick' => '
                jQuery.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddVehicleDetail', array('id' => $customer->header->id)) . '",
                    data: jQuery("form").serialize(),
                    success: function(html) {
                        jQuery("#vehicle").html(html);
                    },
                });
            ',
        )); ?>
		<h2>Vehicle</h2>
		<div id="vehicle">
            <?php $this->renderPartial('_detailVehicle', array('customer'=>$customer)); ?>
        </div>
    </div>

    <hr />
    <div class="field buttons text-center">
		  <?php echo CHtml::submitButton($customer->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
</div>	
	<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'service-dialog',
		'options' => array(
			'title' => 'Service',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
			),
    )); ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
	)); ?>
	<div class="row">
        <div class="medium-6 columns">
			<?php echo $form->textField($service,'findkeyword', array('placeholder'=>'Find By Keyword', "style"=>"margin-bottom:0px;")); ?>
		</div>
    </div>
    <?php $this->endWidget(); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'service-grid',
		'dataProvider'=>$serviceDataProvider,
		'filter'=>$service,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
			'cssFile'=>false,
			'header'=>'',
        ),
		'selectionChanged'=>'js:function(id){
			$("#service-dialog").dialog("close");
            jQuery.ajax({
                type: "POST",
                url: "' . CController::createUrl('ajaxHtmlAddServiceDetail', array('id' => $customer->header->id,'serviceId'=>'')) . '"+$.fn.yiiGridView.getSelection(id),
                data: jQuery("form").serialize(),
                success: function(html) {
                    jQuery("#price").html(html);
                },
            });
			
			$("#service-grid").find("tr.selected").each(function(){
				$(this).removeClass( "selected" );
			});
		}',
		'columns'=>array(
			array('name'=>'service_type_name','value'=>'$data->serviceType->name'),
			array('name'=>'service_category_name','value'=>'$data->serviceCategory->name'),
			'name',
        ),
    )); ?>
	<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php Yii::app()->clientScript->registerScript('search',"
    $('#Service_findkeyword').keypress(function(e) {
        if(e.which == 13) {
            $.fn.yiiGridView.update('service-grid', {
                data: $(this).serialize()
            });
            return false;
        }
    });
"); ?>
<!--COA Supplier-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coa-grid',
		'dataProvider'=>$coaDataProvider,
		'filter'=>$coa,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'selectionChanged'=>'js:function(id){
			$("#coa-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#Customer_coa_id").val(data.id);
					$("#Customer_coa_code").val(data.code);
					$("#Customer_coa_name").val(data.name);
					
				},
			});
			$("#coa-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
		'columns'=>
		//$coumns
		array(
			'name',
			'code',
			//array('name'=>'purchase','value'=>'empty($data->productPrices->purchase_price)?"":$data->productPrices->purchase_price'),
			//array('name'=>'purchase','value'=>'$data->productPrices->purchase_price'),
			//array('name'=>'Product.product_id','value'=>'$data->product->id'),
			//array('name'=>'ProductPrice.supplier_id','value'=>'$data->productPrices->supplier_id'),
			//array('name'=>'ProductPrice.purchase_price','value'=>'empty($data->productPrices->purchase_price)?null:$data->productPrices->purchase_price'),
		),
	)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>
	function clearFields() {
		$('#Customer_coa_id').val(''); 
		$('#Customer_coa_name').val(''); 
		$('#Customer_coa_code').val(''); 
	    //$('#coa').find('input:text').val('');
	    //$('#coa').find('input:hidden').val('');
	   
	}
	if(jQuery("#Customer_customer_type").val()=="Company"){
		jQuery("#birthdate").hide();
		jQuery("#coa").show();
		jQuery("#birthdate").val()=="0000-00-00";
		jQuery("#flatrate").show();
		// ClearFields();
	} else {
		jQuery("#coa").hide();
		jQuery("#birthdate").show();
		jQuery("#flatrate").hide();
		// ClearFields();
	}
</script>