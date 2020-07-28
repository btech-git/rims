<?php
/* @var $this CompanyController */
/* @var $company->header Company */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/company/admin';?>"><span class="fa fa-th-list"></span>Manage Company</a>
<h1><?php if($company->header->isNewRecord){ echo "New Company"; }else{ echo "Update Company";}?></h1>
<!-- begin FORM -->
<hr />

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($company->header); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
                        <?php echo $form->labelEx($company->header,'name',array('class'=>'prefix'));?>
                    </div>
					<div class="small-8 columns">
                        <?php echo $form->textField($company->header,'name',array('size'=>30,'maxlength'=>30)); ?>
                        <?php echo $form->error($company->header,'name'); ?>
					</div>
				</div>
			 </div>			

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
                        <?php echo $form->labelEx($company->header,'address',array('class'=>'prefix'));?>
                    </div>
					<div class="small-8 columns">
                        <?php echo $form->textArea($company->header,'address',array('rows'=>6, 'cols'=>50)); ?>
                        <?php echo $form->error($company->header,'address'); ?>
					</div>
				</div>
			 </div>
			 <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <?php echo $form->labelEx($company->header,'province_id',array('class'=>'prefix'));?>
                </div>
                <div class="small-8 columns">
				    <?php //echo  $form->dropDownList($model, 'province_id',  array('prompt' => 'Select',)); ?>
					<?php echo $form->dropDownList($company->header, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
                        'prompt' => '[--Select Province--]',
                        'onchange'=> 'jQuery.ajax({
                            type: "POST",
                            //dataType: "JSON",
                            url: "' . CController::createUrl('ajaxGetCity') . '" ,
                            data: jQuery("form").serialize(),
                            success: function(data){
                                console.log(data);
                                jQuery("#Company_city_id").html(data);
                            },
                        });'
					)); ?>
					<?php echo $form->error($company->header,'province_id'); ?>
                </div>
            </div>
         </div>
		 
		 <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <?php echo $form->labelEx($company->header,'city_id',array('class'=>'prefix'));?>
                </div>
                <div class="small-8 columns">
				    <?php //echo  $form->dropDownList($model, 'city_id',	 array('prompt' => 'Select',)); ?>
					<?php //echo $form->textField($model,'city_id',array('size'=>10,'maxlength'=>10)); ?>
					<?php if ($company->header->province_id == NULL) {
                        echo $form->dropDownList($company->header,'city_id',array(),array('prompt'=>'[--Select City-]'));
                    } else {
                        echo $form->dropDownList($company->header,'city_id',CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$company->header->province_id)), 'id', 'name'),array());
                    } ?>
					<?php echo $form->error($company->header,'city_id'); ?>
                </div>
            </div>
     	</div>

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
                        <?php echo $form->labelEx($company->header,'phone',array('class'=>'prefix'));?>
                    </div>
					<div class="small-8 columns">
                        <?php echo $form->textField($company->header,'phone',array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($company->header,'phone'); ?>
					</div>
				</div>
			 </div>

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
                        <?php echo $form->labelEx($company->header,'npwp',array('class'=>'prefix'));?>
                    </div>
					<div class="small-8 columns">
                        <?php echo $form->textField($company->header,'npwp',array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($company->header,'npwp'); ?>
					</div>
				</div>
			 </div>

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
                        <?php echo $form->labelEx($company->header,'tax_status',array('class'=>'prefix'));?>
                    </div>
					<div class="small-8 columns">
                        <?php echo  $form->dropDownList($company->header, 'tax_status', array('PKP' => 'PKP', 'Non PKP' => 'Non PKP', )); ?>
                        <?php echo $form->error($company->header,'tax_status'); ?>
					</div>
				</div>
			 </div>

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Banks</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::button('+', array(
							'id' => 'detail-bank-button',
							'name' => 'DetailBanks',
							'onclick' => '
								jQuery("#bank-dialog").dialog("open"); return false;'
							)
						); ?>
						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id' => 'bank-dialog',
							// additional javascript options for the dialog plugin
							'options' => array(
								'title' => 'Bank',
								'autoOpen' => false,
								'width' => 'auto',
								'modal' => true,
							),));
						?>

						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'bank-grid',
							'dataProvider'=>$bankDataProvider,
							'filter'=>$bank,
							// 'summaryText'=>'',
							'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
							'pager'=>array(
							   'cssFile'=>false,
							   'header'=>'',
							),
							'selectionChanged'=>'js:function(id){
								$("#bank-dialog").dialog("close");
								$.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('company/ajaxHtmlAddBankDetail', array('id'=>$company->header->id,'bankId'=>'')). '"+$.fn.yiiGridView.getSelection(id),
									data: $("form").serialize(),
									success: function(html) {
										// console.log(html);
										$("#bank").html(html);
										
									},
								});
								$("#bank-grid").find("tr.selected").each(function(){
				                   $(this).removeClass( "selected" );
				                });
							}',
							'columns'=>array(
								//'id',
								'code',
								'name'
							),
						)); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
    
	<div class="row">
		<div class="large-12 columns">
			<div class="field" id="bank">
				<div class="row collapse">
						<?php $this->renderPartial('_detailBank', array('company'=>$company)); ?>
				</div>
			</div> 
			<?php $this->endWidget(); ?>
		</div>
	</div>
    
    <div class="row">
		<div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						Branches</label>
					</div>
                    
					<div class="small-8 columns">
						<?php echo CHtml::button('Add Branch', array(
                            'id' => 'detail-branch-button',
                            'name' => 'Detail',
                            'class'=>'button extra right',
                            'onclick' => 'jQuery("#branch-dialog").dialog("open"); return false;',
                        ));
							
                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'branch-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Branch',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        ));
								
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'branch-grid',
                            'dataProvider'=>$branchDataProvider,
                            'filter'=>$branch,
                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                            'pager'=>array(
                               'cssFile'=>false,
                               'header'=>'',
                            ),
                            'columns'=>array(
                                 array(
											'name' => 'check',
											'id' => 'selectedIds',
											'value' => '$data->id',
											'class' => 'CCheckBoxColumn',
											'checked' => function($data) use($branchArray) {
                                                return in_array($data->id, $branchArray); 
					                        }, 
											'selectableRows' => '100',	
											'checkBoxHtmlOptions' => array(
											'onclick' => 'js: if($(this).is(":checked")==true){
                                                    var checked_val= $(this).val();

                                                    var selected_branch = $(this).parent("td").siblings("td").html();
                                                    var myArray = [];

                                                    jQuery("#branch tr").each(function(){													
                                                        var savedBranches = $(this).find("input[type=text]").val();																						
                                                        myArray.push(savedBranches); 
                                                    });
                                                    if(jQuery.inArray(selected_branch, myArray)!= -1) {
                                                        alert("Please select other branch, this is already added");
                                                        return false;
                                                    } else {

                                                            $.ajax({
                                                            type: "POST",
                                                            //dataType: "JSON",
                                                            url: "' . CController::createUrl('ajaxHtmlAddBranchDetail', array()) . '/id/'.$company->header->id.'/branchId/"+$(this).val(),
                                                            data: $("form").serialize(),
                                                            success: function(html) {
                                                                $("#branch").html(html);	
                                                                //$.fn.yiiGridView.update("#branch-grid");
                                                            },
                                                        });
                                                        $(this).parent("td").parent("tr").addClass("checked");
                                                        $(this).parent("td").parent("tr").removeClass("unchecked");
                                                    }
                                                } else {
                                                    var unselected_branch = $(this).parent("td").siblings("td").html();
                                                    var myArray = [];
                                                    var count = 0;
                                                    jQuery("#branch tr").each(function(){													
                                                        var savedBranch = $(this).find("input[type=text]").val();																						
                                                        myArray.push(savedBranch);																						
                                                        if(unselected_branch==savedBranch){
                                                            index_id = count-1;																		
                                                        }
                                                        count++;
                                                    });
                                                    
                                                    if (jQuery.inArray(unselected_branch, myArray)!= -1) {
                                                        $.ajax({
                                                            type: "POST",
                                                            //dataType: "JSON",
                                                            url: "' . CController::createUrl('ajaxHtmlRemoveBranchDetail', array()) . '/id/'.$company->header->id.'/branch_name/"+unselected_branch+"/index/"+index_id,
                                                            data: $("form").serialize(),
                                                            success: function(html) {
                                                                $("#branch").html(html);																							
                                                            },
                                                            update:"#branch",
                                                        });
                                                    } 

                                                    $(this).parent("td").parent("tr").removeClass("checked");
                                                    $(this).parent("td").parent("tr").addClass("unchecked");
												}'
											),											
										),
									//'code',
									'name'
								),
							));
							
							$this->endWidget(); ?>
						</div>
                    </div>
				</div>
			</div>
			<div class="field" id="branch">
				<div class="row collapse">
                    <?php $this->renderPartial('_detailBranch', array('company'=>$company)); ?>
				</div>
			</div>
			
<!--			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
                        <?php /*echo $form->labelEx($company->header,'branch_id',array('class'=>'prefix')); ?>
                    </div>
					<div class="small-8 columns">
                        <?php echo  $form->dropDownList($company->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'),array('prompt'=>'[--Select Branch-]')); ?>
                        <?php echo $form->error($company->header,'branch_id');*/ ?>
					</div>
				</div>
			 </div>-->
		</div>
    </div>
    
    <hr />

    <div class="field buttons text-center">
		<?php echo CHtml::submitButton($company->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<!--COA KAS BANK-->
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

	<?php
			/*$coumns = array(
			array('name'=>'product_name','value'=>'$data->product->name'),
			// array('name'=>'supplier_name','value'=>'$data->supplier->name'),
			// 'purchase_price'
			);

			$lsitSupplier = Supplier::model()->findAll();
			foreach ($lsitSupplier as $key => $value) {
				array_push($coumns, array('header'=>$value->name, 'value'=>'$data->getLasProductPrice($data->product_id,"'.$value->id.'")'));
			}*/

	?>
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
					
					$("#CompanyBank_"+currentDetail+"_coa_id").val(data.id);
					$("#CompanyBank_"+currentDetail+"_coa_code").val(data.code);
					$("#CompanyBank_"+currentDetail+"_coa_name").val(data.name);
					
				},
			});
			$("#coa-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
		'columns'=>
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