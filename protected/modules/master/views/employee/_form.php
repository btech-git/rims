<?php
/* @var $this EmployeeController */
/* @var $model Employee */
/* @var $form CActiveForm */
?>
<?php //echo 'here1'; exit;?>
<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/employee/admin';?>"><span class="fa fa-th-list"></span>Manage Employee</a>
	<h1><?php if($employee->header->isNewRecord){ echo "New Employee"; }else{ echo "Update Employee";}?></h1>
	<!-- begin FORM -->

	<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'employee-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
			)
		); 
		?>
		<hr>
		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($employee->header); ?>
		<?php echo $form->errorSummary($employee->phoneDetails); ?>
		<?php echo $form->errorSummary($employee->mobileDetails); ?>

		<div class="row">
			<div class="small-12 medium-6 columns">

	        <!--  <div class="field">
	            <div class="row collapse">
	                <div class="small-4 columns">
	                  <label class="prefix"><?php //echo $form->labelEx($employee->header,'code'); ?></label>
	                </div>
	                <div class="small-8 columns">
					    <?php //echo $form->textField($employee->header,'code',array('size'=>20,'maxlength'=>20)); ?>
						<?php //echo $form->error($employee->header,'code'); ?>
					</div>
	            </div>
	        </div> -->

<!--            <h2>Branch</h2>-->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($employee->header,'branch_id'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($employee->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'),array(
                            'prompt' => '[--Select Branch--]',
                            'onchange' => ''
                            )
                        ); 
                        ?>

                        <?php echo $form->error($employee->header,'branch_id'); ?>
                    </div>
                </div>
            </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'name'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo $form->textField($employee->header,'name',array('size'=>60,'maxlength'=>100,'style'=>'text-transform: capitalize')); ?>
	        			<?php echo $form->error($employee->header,'name'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'local_address'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo $form->textArea($employee->header,'local_address',array('rows'=>6, 'cols'=>50)); ?>
	        			<?php echo $form->error($employee->header,'local_address'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'province_id'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php //echo $form->textField($model,'province_id',array('size'=>10,'maxlength'=>10)); ?>
	        			<?php echo $form->dropDownList($employee->header, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
	        				'prompt' => '[--Select Province--]',
	        				'onchange'=> 'jQuery.ajax({
	        					type: "POST",
                 			//dataType: "JSON",
	        					url: "' . CController::createUrl('ajaxGetCity') . '",
	        					data: jQuery("form").serialize(),
	        					success: function(data){
	        						console.log(data);
	        						jQuery("#Employee_city_id").html(data);
	        					},
	        				});'
                        )); ?>

	        			<?php echo $form->error($employee->header,'province_id'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'city_id'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php //echo $form->textField($model,'city_id',array('size'=>10,'maxlength'=>10)); ?>
	        			<?php //echo  $form->dropDownList($model, 'city_id',	 array('prompt' => 'Select',)); ?>
	        			<?php
	        			if($employee->header->province_id == NULL) {
	        				echo $form->dropDownList($employee->header,'city_id',array(),array('prompt'=>'[--Select City-]'));
	        			}else{
	        				echo $form->dropDownList($employee->header,'city_id',CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$employee->header->province_id)), 'id', 'name'),array());
	        			}
	        			?>
	        			<?php echo $form->error($employee->header,'city_id'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'home_address'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo $form->textArea($employee->header,'home_address',array('rows'=>6, 'cols'=>50)); ?>
	        			<?php echo $form->error($employee->header,'home_address'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'home_province'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php //echo $form->textField($model,'province_id',array('size'=>10,'maxlength'=>10)); ?>
	        			<?php echo $form->dropDownList($employee->header, 'home_province', CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
	        				'prompt' => '[--Select Province--]',
	        				'onchange'=> 'jQuery.ajax({
	        					type: "POST",
                  				//dataType: "JSON",
	        					url: "' . CController::createUrl('ajaxGetCityHome') . '" ,
	        					data: jQuery("form").serialize(),
	        					success: function(data){
	        						console.log(data);
	        						jQuery("#Employee_home_city").html(data);
	        					},
	        				});'
	        				)
	        			); 
	        			?>

	        			<?php echo $form->error($employee->header,'home_province'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'home_city'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php //echo $form->textField($model,'city_id',array('size'=>10,'maxlength'=>10)); ?>
	        			<?php //echo  $form->dropDownList($model, 'city_id',	 array('prompt' => 'Select',)); ?>
	        			<?php
	        			if($employee->header->home_province == NULL) {
	        				echo $form->dropDownList($employee->header,'home_city',array(),array('prompt'=>'[--Select City-]'));
	        			}else{
	        				echo $form->dropDownList($employee->header,'home_city',CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$employee->header->home_province)), 'id', 'name'),array());
	        			}
	        			?>
	        			<?php echo $form->error($employee->header,'home_city'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'sex'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php //echo $form->textField($model,'sex',array('size'=>20,'maxlength'=>20)); ?>
	        			<?php 
	        			echo $form->dropDownList($employee->header,'sex', array(
	        				'Male'=>'Male',
	        				'Female'=>'Female',
	        				)
	        			);
	        			?>
	        			<?php echo $form->error($employee->header,'sex'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'email'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo $form->textField($employee->header,'email',array('size'=>20,'maxlength'=>60)); ?>
	        			<?php echo $form->error($employee->header,'email'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'id_card'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo $form->textField($employee->header,'id_card',array('size'=>20,'maxlength'=>60)); ?>
	        			<?php echo $form->error($employee->header,'id_card'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'driving_license'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo $form->textField($employee->header,'driving_license',array('size'=>20,'maxlength'=>60)); ?>
	        			<?php echo $form->error($employee->header,'driving_license'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'salary_type'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo  $form->dropDownList($employee->header, 'salary_type', array('Hourly' => 'Hourly',
	        			'Daily' => 'Daily', 'Weekly'=>'Weekly', 'Monthly'=>'Monthly', 'One Time Payment'=>'One Time Payment' )); ?>
	        			<?php echo $form->error($employee->header,'salary_type'); ?>
	        		</div>
	        	</div>
	        </div>
	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><p style="color:#c00;"><?php echo "Basic Salary* Rp"; //echo $form->labelEx($employee->header,'basic_salary');?></p></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo $form->textField($employee->header,'basic_salary',array('size'=>50,'maxlength'=>50,'placeholder'=>'in Rp')); ?>
	        			<?php echo $form->error($employee->header,'basic_salary'); ?>
	        		</div>
	        	</div>
	        </div>
	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'payment_type'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo  $form->dropDownList($employee->header, 'payment_type', array('Cash' => 'Cash',
	        			'Transfer' => 'Transfer' )); ?>
	        			<?php echo $form->error($employee->header,'payment_type'); ?>
	        		</div>
	        	</div>
	        </div> 

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'off_day'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo  $form->dropDownList($employee->header, 'off_day', array('Monday' => 'Monday',
	        			'Tuesday' => 'Tuesday','Wednesday' => 'Wednesday','Thursday' => 'Thursday','Friday' => 'Friday','Saturday' => 'Saturday','Sunday' => 'Sunday' ),array('prompt'=>'[--Select Day Off--]')); ?>
	        			<?php echo $form->error($employee->header,'off_day'); ?>
	        		</div>
	        	</div>
	        </div>

	        <div class="field">
	        	<div class="row collapse">
	        		<div class="small-4 columns">
	        			<label class="prefix"><?php echo $form->labelEx($employee->header,'skills'); ?></label>
	        		</div>
	        		<div class="small-8 columns">
	        			<?php echo $form->textArea($employee->header,'skills',array('rows'=>6, 'cols'=>50)); ?>
	        			<?php echo $form->error($employee->header,'skills'); ?>
	        		</div>
	        	</div>
	        </div>
	    </div>
	    <?php $this->endWidget(); ?>

	    <div class="small-12 medium-6 columns">
	    	<div class="row">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo 'Phones'; ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::button('+', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'onclick' => '
                                jQuery.ajax({	
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddPhoneDetail', array('id' => $employee->header->id)) . '",
                                    data: jQuery("form").serialize(),
                                    success: function(html) {
                                        jQuery("#phone").html(html);
                                    },
                                });',

                                )
                            ); 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="field" id="phone">
                    <div class="row collapse">
                        <?php $this->renderPartial('_detailPhone', array(
                            'employee'=>$employee
                            )
                        );
                        ?>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo 'Mobiles'; ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::button('+', array(
                                'id' => 'detail-mobile-button',
                                'name' => 'DetailMobile',
                                'onclick' => '
                                jQuery.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddMobileDetail', array('id' => $employee->header->id)) . '",
                                    data: jQuery("form").serialize(),
                                    success: function(html) {
                                        jQuery("#mobile").html(html);
                                    },
                                });',

                                )
                            ); 
                            ?>
                        </div>
                    </div>
                </div>

                <div class="field" id="mobile">
                    <div class="row collapse">
                        <?php $this->renderPartial('_detailMobile', array(
                            'employee'=>$employee		
                            )
                        ); 
                        ?>
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
                            )); ?>
                            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                'id' => 'bank-dialog',
                            // additional javascript options for the dialog plugin
                                'options' => array(
                                    'title' => 'Bank',
                                    'autoOpen' => false,
                                    'width' => 'auto',
                                    'modal' => true,
                                    ),)
                            );
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
                                        url: "' . CController::createUrl('ajaxHtmlAddBankDetail', array('id'=>$employee->header->id,'bankId'=>'')) .'"+$.fn.yiiGridView.getSelection(id),
                                        data: $("form").serialize(),
                                        success: function(html) {
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
                                )
                            );
                            ?>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
                <div class="field" id="bank">
                    <div class="row collapse">
                        <?php $this->renderPartial('_detailBank', array('employee'=>$employee)); ?>
                    </div>
                </div>


                <!-- Deduction details-->
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Deduction</label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::button('+', array(
                                'id' => 'detail-deduction-button',
                                'name' => 'Detaildeductions',
                                'onclick' => '
                                jQuery("#deduction-dialog").dialog("open"); return false;')
                            ); 
                            ?>
                            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                'id' => 'deduction-dialog',
                            // additional javascript options for the dialog plugin
                                'options' => array(
                                    'title' => 'Deduction',
                                    'autoOpen' => false,
                                    'width' => 'auto',
                                    'modal' => true,
                                    ),)
                            );
                            ?>

                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'deduction-grid',
                                'dataProvider'=>$deductionDataProvider,
                                'filter'=>$deduction,
                                // 'summaryText'=>'',
                                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                'pager'=>array(
                                    'cssFile'=>false,
                                    'header'=>'',
                                    ),
                                'selectionChanged'=>'js:function(id){
                                    $("#deduction-dialog").dialog("close");
                                    $.ajax({
                                        type: "POST",
                                    //dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxHtmlAddDeductionDetail', array('id'=>$employee->header->id,'deductionId'=>'')) .'"+$.fn.yiiGridView.getSelection(id),
                                        data: $("form").serialize(),
                                        success: function(html) {
                                            $("#deduction").html(html);

                                        },
                                    });
                                    $("#deduction-grid").find("tr.selected").each(function(){
                                        $(this).removeClass( "selected" );
                                    });
                                }',
                                'columns'=>array(
                                //'id',
                                    'id',
                                    'name',
                                    'amount'
                                    ),
                                )
                            );
                            ?>

                        </div>
                    </div>
                </div>
                <div class="field" id="deduction">
                    <div class="row collapse">
                        <?php $this->renderPartial('_detail_deduction', array('employee'=>$employee)); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>		 

                <!-- end of Deduction details-->


                <!-- incentives details-->
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Incentive</label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::button('+', array(
                                'id' => 'detail-incentive-button',
                                'name' => 'Detailincentives',
                                'onclick' => '
                                jQuery("#incentive-dialog").dialog("open"); return false;'
                                )
                            ); 
                            ?>
                            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                'id' => 'incentive-dialog',
                                // additional javascript options for the dialog plugin
                                'options' => array(
                                    'title' => 'Incentive',
                                    'autoOpen' => false,
                                    'width' => 'auto',
                                    'modal' => true,
                                    ),)
                            );
                            ?>

                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'incentive-grid',
                                'dataProvider'=>$incentiveDataProvider,
                                'filter'=>$incentive,
                                // 'summaryText'=>'',
                                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                'pager'=>array(
                                    'cssFile'=>false,
                                    'header'=>'',
                                    ),
                                'selectionChanged'=>'js:function(id){
                                    $("#incentive-dialog").dialog("close");
                                    $.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxHtmlAddIncentiveDetail', array('id'=>$employee->header->id,'incentiveId'=>'')) .'"+$.fn.yiiGridView.getSelection(id),
                                        data: $("form").serialize(),
                                        success: function(html) {
                                            $("#incentive").html(html);

                                        },
                                    });
                                    $("#incentive-grid").find("tr.selected").each(function(){
                                        $(this).removeClass( "selected" );
                                    });
                                }',
                                'columns'=>array(
                                    //'id',
                                    'id',
                                    'name',
                                    'amount'
                                    ),
                                )
                            );
                            ?>

                        </div>
                    </div>
                </div>
                <div class="field" id="incentive">
                    <div class="row collapse">
                        <?php $this->renderPartial('_detailIncentive', array('employee'=>$employee)); ?>
                    </div>
                </div>

                <!-- end of incentives details-->

	    		<?php echo CHtml::button('Add Detail', array(
	    			'id' => 'detail-button',
	    			'name' => 'Detail',
	    			'class'=>'button extra right',
	    			'onclick' => '

	    			$.ajax({
	    				type: "POST",
								//dataType: "JSON",
	    				url: "' . CController::createUrl('ajaxHtmlAddDivisionDetail', array()) . '/id/'.$employee->header->id.'/branchId/"+$(this).val(),
	    				data: $("form").serialize(),
	    				success: function(html) {
	    					$("#branch").html(html);	
									//$.fn.yiiGridView.update("#branch-grid");
	    				},
	    			});'

	    			)
	    		); 

	    		$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	    			'id' => 'branch-dialog',
						// additional javascript options for the dialog plugin
	    			'options' => array(
	    				'title' => 'Branch',
	    				'autoOpen' => false,
	    				'width' => 'auto',
	    				'modal' => true,
	    				),)
	    		);

	    		$this->widget('zii.widgets.grid.CGridView', array(
	    			'id'=>'branch-grid',
	    			'dataProvider'=>$branchDataProvider,
	    			'filter'=>$branch,
    				// 'summaryText'=>'',
	    			'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	    			'columns'=>array(
						//'id',
						//'code',
	    				array(
	    					'name' => 'check',
	    					'id' => 'selectedIds',
	    					'value' => '$data->id',
	    					'class' => 'CCheckBoxColumn',
	    					'selectableRows' => '100',	
	    					'checkBoxHtmlOptions' => array(
	    						'onclick' => 'js: if($(this).is(":checked")==true){
	    							var checked_branch= $(this).val();

	    							var selected_branch = $(this).parent("td").siblings("td").html();
	    							var myArray = [];

	    							jQuery("#branch tr").each(function(){													
	    								var savedBranch = $(this).find("input[type=text]").val();																						
	    								myArray.push(savedBranch); 
	    							});
	    							if(jQuery.inArray(selected_branch, myArray)!= -1) {
	    								alert("Please select other branch, this is already added");
	    								return false;
	    							} else {

	    								$.ajax({
	    									type: "POST",
													//dataType: "JSON",
	    									url: "' . CController::createUrl('ajaxHtmlAddDivisionDetail', array()) . '/id/'.$employee->header->id.'/branchId/"+$(this).val(),
	    									data: $("form").serialize(),
	    									success: function(html) {
	    										$("#branch").html(html);	
														//$.fn.yiiGridView.update("#branch-grid");
	    									},
	    								});
	    								$(this).parent("td").parent("tr").addClass("checked");
	    								$(this).parent("td").parent("tr").removeClass("unchecked");
	    							}


	    						}else{
										//start from this with editing for branch
	    							var unchecked_val= $(this).val();

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
	    							if(jQuery.inArray(unselected_branch, myArray)!= -1) {

	    								$.ajax({
	    									type: "POST",
												//dataType: "JSON",
	    									url: "' . CController::createUrl('ajaxHtmlRemoveDivisionDetail', array()) . '/id/'.$employee->header->id.'/index/"+index_id,
	    									data: $("form").serialize(),
	    									success: function(html) {
	    										$("#branch").html(html);																							
	    									},
	    									update:"#branch",
	    								});
	    							} 


	    							$(this).parent("td").parent("tr").removeClass("checked");
	    							$(this).parent("td").parent("tr").addClass("unchecked");
	    						}'),											
	    					),
	    				'name'

	    				),
	    			)
	    		);
	    		?>
	    		<?php $this->endWidget(); ?>

	    		<h2>Division - Position - Level</h2>
	    		<div class="grid-view" id="branch" >
	    			<?php $this->renderPartial('_detailDivision', array('employee'=>$employee)); ?>
	    			<div class="clearfix"></div><div style="display:none" class="keys"></div>
	    		</div>
	    	</div>



	    	<div></div>



	    	<!-- end RIGHT -->
	    </div>
	</div>
	<hr>
	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($employee->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>
	<?php $this->endWidget('CActiveForm'); ?>
<!-- end of form-->