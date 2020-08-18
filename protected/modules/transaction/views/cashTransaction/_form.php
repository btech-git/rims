<?php
/* @var $this CashTransactionController */
/* @var $cashTransaction ->header CashTransaction */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'cash-transaction-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($cashTransaction->header); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($cashTransaction->header, 'transaction_type',
                            array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($cashTransaction->header, 'transaction_type', array(
                            'In' => 'In',
                            'Out' => 'Out',
                        ), array(
                            'prompt' => '[--Select Transaction Type--]',
                            'onchange' => 'ClearFields();$("#coa").hide();'
                        )); ?>
                        <?php echo $form->error($cashTransaction->header, 'transaction_type'); ?>
                    </div>
                </div>
            </div>


            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($cashTransaction->header, 'transaction_number',
                            array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($cashTransaction->header, 'transaction_number', array('readonly' => true)); ?>
                        <?php echo $form->error($cashTransaction->header, 'transaction_number'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($cashTransaction->header, 'transaction_date', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($cashTransaction->header, 'transaction_date', array('value' => date('Y-m-d'), 'readonly' => true,)); ?>
                        <?php echo $form->error($cashTransaction->header, 'transaction_date'); ?>
                    </div>
                </div>
            </div>


            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($cashTransaction->header, 'coa_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($cashTransaction->header, 'coa_id'); ?>
                        <?php echo CHtml::encode(CHtml::value($cashTransaction, 'branch.code')); ?>
                        <?php echo $form->textField($cashTransaction->header, 'coa_name', array(
                            'size' => 20,
                            'maxlength' => 20,
                            'readonly' => true,
                            'onclick' =>
                                'if($("#CashTransaction_transaction_type").val() == ""){
                                    alert("Please Select Transaction Type to Proceed.");
                                }else{
                                    jQuery("#coa-kas-dialog").dialog("open"); return false;
                                }',
                            'value' => $cashTransaction->header->coa_id != "" ? Coa::model()->findByPk($cashTransaction->header->coa_id)->name : ''
                        )); ?>

                        <?php echo $form->error($cashTransaction->header, 'coa_id'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($cashTransaction->header, 'branch_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($cashTransaction->header, 'branch_id', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array(
                            'prompt' => '[--Select Branch--]'
                        )); ?>
                        <?php echo $form->error($cashTransaction->header, 'branch_id'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($cashTransaction->header, 'user_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($cashTransaction->header, 'user_id', array(
                            'value' => $cashTransaction->header->isNewRecord ? Yii::app()->user->getId() : $cashTransaction->header->user_id,
                            'readonly' => true
                        )); ?>
                        <?php echo $form->textField($cashTransaction->header, 'user_name', array(
                            'size' => 30,
                            'maxlength' => 30,
                            'value' => $cashTransaction->header->isNewRecord ? Yii::app()->user->getName() : $cashTransaction->header->user->username,
                            'readonly' => true
                        )); ?>
                        <?php echo $form->error($cashTransaction->header, 'user_id'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($cashTransaction->header, 'status', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($cashTransaction->header, 'status', array(
                            'value' => $cashTransaction->header->isNewRecord ? 'Draft' : $cashTransaction->header->status,
                            'readonly' => true
                        )); ?>
                        <?php echo $form->error($cashTransaction->header, 'status'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="coa">
        <fieldset>
            <legend>Coa Detail</legend>
            <div class="row">
                <div class="large-12 columns">
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label for="" class="prefix">COA Code</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($cashTransaction, 'branch.code')); ?>
                                    <?php echo $form->textField($cashTransaction->header, 'coa_code', array(
                                        'size' => 20,
                                        'maxlength' => 20,
                                        'readonly' => true,
                                        'value' => $cashTransaction->header->coa_id != "" ? Coa::model()->findByPk($cashTransaction->header->coa_id)->code : ''
                                    )); ?>

                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label for="" class="prefix">COA Opening Balance</label>
                                </div>
                                <div class="small-8 columns">

                                    <?php echo $form->textField($cashTransaction->header, 'coa_opening_balance', array(
                                        'size' => 20,
                                        'maxlength' => 20,
                                        'readonly' => true,
                                        'value' => $cashTransaction->header->coa_id != "" ? Coa::model()->findByPk($cashTransaction->header->coa_id)->opening_balance : ''
                                    )); ?>

                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label for="" class="prefix">COA Normal Balance</label>
                                </div>
                                <div class="small-8 columns">

                                    <?php echo $form->textField($cashTransaction->header, 'coa_normal_balance', array(
                                        'size' => 20,
                                        'maxlength' => 20,
                                        'readonly' => true,
                                        'value' => $cashTransaction->header->coa_id != "" ? Coa::model()->findByPk($cashTransaction->header->coa_id)->normal_balance : ''
                                    )); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label for="" class="prefix">COA Debit Amount</label>
                                </div>
                                <div class="small-8 columns">

                                    <?php echo $form->textField($cashTransaction->header, 'coa_debit', array(
                                        'size' => 20,
                                        'maxlength' => 20,
                                        'readonly' => true,
                                        'value' => $cashTransaction->header->coa_id != "" ? Coa::model()->findByPk($cashTransaction->header->coa_id)->debit : ''
                                    )); ?>

                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label for="" class="prefix">COA Credit Amount</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo $form->textField($cashTransaction->header, 'coa_credit', array(
                                        'size' => 20,
                                        'maxlength' => 20,
                                        'readonly' => true,
                                        'value' => $cashTransaction->header->coa_id != "" ? Coa::model()->findByPk($cashTransaction->header->coa_id)->credit : ''
                                    )); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

    </div>


    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($cashTransaction->header, 'debit_amount',
                            array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($cashTransaction->header, 'debit_amount',
                            array('size' => 18, 'maxlength' => 18, 'readonly' => true)); ?>
                        <?php echo $form->error($cashTransaction->header, 'debit_amount'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($cashTransaction->header, 'credit_amount',
                            array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($cashTransaction->header, 'credit_amount',
                            array('size' => 18, 'maxlength' => 18, 'readonly' => true)); ?>
                        <?php echo $form->error($cashTransaction->header, 'credit_amount'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <fieldset>
                <legend>Details</legend>
                <p> <?php echo CHtml::button('Add Details', array(
                            'id' => 'detail-button',
                            'name' => 'Detail',
                            'onclick' => '
									if($("#CashTransaction_transaction_type").val() == ""){
							    		alert("Please Select Transaction Type to Proceed.");
							    	}else{
							    		jQuery("#coa-detail-dialog").dialog("open"); return false;
							    	}
									'
                        )
                    ); ?>
                    <?php echo CHtml::button('Count Total', array(
                        'id' => 'total-button',
                        'name' => 'Total',
                        'style' => 'display:none',
                        'onclick' => '
									$.ajax({
					                  type: "POST",
					                  url: "' . CController::createUrl('ajaxGetTotal',
                                array('id' => $cashTransaction->header->id,)) . '",
					                  data: $("form").serialize(),
					                  dataType: "json",
					                  success: function(data) {
					                      //console.log(data.total);
					                  	//console.log(data.requestType);
					                  	if($("#CashTransaction_transaction_type").val()=="In"){
					                  		$("#CashTransaction_credit_amount").val(data.total);
					                  	}
					                  	else{
					                  		$("#CashTransaction_debit_amount").val(data.total);
					                  	}
					                    
					                      
					                  },
					                });',
                    ));
                    ?>
                </p>
                <div class="row">
                    <div class="large-12 columns">
                        <div class="detail">
                            <?php $this->renderPartial('_detail', array(
                                'cashTransaction' => $cashTransaction
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="large-6">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($cashTransaction->header, 'images',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php if ($cashTransaction->header->isNewRecord): ?>
                                <?php //echo $form->labelEx($model, 'images', array('class' => 'label')); ?>
                                <?php
                                $this->widget('CMultiFileUpload', array(
                                    'model' => $cashTransaction->header,
                                    'attribute' => 'images',
                                    'accept' => 'jpg|jpeg|png|gif',
                                    'denied' => 'Only jpg, jpeg, png and gif are allowed',
                                    'max' => 10,
                                    'remove' => 'x',
                                    //'duplicate' => 'Already Selected',


                                ));
                                ?>
                            <?php else:
                                if ($allowedImages != 0): ?>
                                    <?php //echo $form->labelEx($model, 'images', array('class' => 'label')); ?>
                                    <?php
                                    $this->widget('CMultiFileUpload', array(
                                        'model' => $cashTransaction->header,
                                        'attribute' => 'images',
                                        'accept' => 'jpg|jpeg|png|gif',
                                        'denied' => 'Only jpg, jpeg, png and gif are allowed',
                                        'max' => 10,
                                        'remove' => 'x',
                                        //'duplicate' => 'Already Selected',


                                    ));
                                    ?>
                                <?php endif;

                                if ($postImages !== null): ?>
                                    <?php
                                    //$criteria = new CDbCriteria;
                                    //$criteria->select = 'max(`order`) AS max_order';
                                    //$row = ArticlesImages::model()->findByAttributes(array('article_id' => $model->id, 'status' => 1));

                                    //$count_banners = count($restaurantImages);

                                    //$down = SKINS . 'arrow_down.png';
                                    //$up = SKINS . 'arrow_up.png';
                                    ?>
                                    <?php //print_r($postImages); ?>
                                    <?php foreach ($postImages as $postImage):
                                        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashTransaction/' . $cashTransaction->header->id . '/' . $postImage->filename;
                                        $src = Yii::app()->baseUrl . '/images/uploads/cashTransaction/' . $cashTransaction->header->id . '/' . $postImage->filename;
                                        ?>
                                        <div class="row">
                                            <div class="small-3 columns">
                                                <div style="margin-bottom:.5rem">
                                                    <?php echo CHtml::image($src,
                                                        $cashTransaction->header->transaction_type . "Image"); ?>
                                                </div>
                                            </div>
                                            <div class="small-8 columns">
                                                <div style="padding:.375rem .5rem; border:1px solid #ccc; background:#fff; font-size:.8125rem; line-height:1.4; margin-bottom:.5rem;">
                                                    <?php echo(Yii::app()->baseUrl . '/images/uploads/cashTransaction/' . $cashTransaction->header->id . '/' . $postImage->filename); ?>
                                                </div>
                                            </div>
                                            <div class="small-1 columns">
                                                <?php echo CHtml::link('x', array(
                                                    'deleteImage',
                                                    'id' => $postImage->id,
                                                    'cash_transaction_id' => $cashTransaction->header->id
                                                ), array(
                                                    'class' => 'deleteImg right',
                                                    'confirm' => 'Are you sure you want to delete this image?'
                                                )); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif;
                            endif; ?>
                            <?php echo $form->error($cashTransaction->header, 'images'); ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="field buttons text-center">
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton($cashTransaction->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>
        </div>
    </div>


    <?php $this->endWidget(); ?>
    <script>
        if ($("#CashTransaction_coa_id").val() == "") {
            //alert("Test");
            $("#coa").hide();
        } else {
            $("#coa").show();
        }

        function ClearFields() {
            $('#coa').find('input:text').val('');
            $("#CashTransaction_coa_id").val('');
            $("#CashTransaction_coa_name").val('');
            $("#CashTransaction_debit_amount").val('');
            $("#CashTransaction_credit_amount").val('');
        }
    </script>

</div><!-- form -->


<!--COA Kas-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-kas-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA Kas',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
));
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'coa-kas-grid',
    'dataProvider' => $coaKasDataProvider,
    'filter' => $coaKas,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
			$("#coa-kas-dialog").dialog("close");
			$("#coa").show();
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#CashTransaction_coa_id").val(data.id);
					$("#CashTransaction_coa_code").val(data.code);
					$("#CashTransaction_coa_name").val(data.name);
					$("#CashTransaction_coa_opening_balance").val(data.opening_balance);
					$("#CashTransaction_coa_debit").val(data.debit);
					$("#CashTransaction_coa_credit").val(data.credit);
					if($("#CashTransaction_transaction_type").val() == "In"){
						$("#CashTransaction_debit_amount").val(data.opening_balance);
					}
					else{
						$("#CashTransaction_credit_amount").val(data.opening_balance);
					}
					
				},
			});
			$("#coa-kas-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
    'columns' =>
    //$coumns
        array(
            'name',
            'code',
            'normal_balance',
        ),
)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<!--COA Detail-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-detail-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
));
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'coa-detail-grid',
    'dataProvider' => $coaDetailDataProvider,
    'filter' => $coaDetail,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
			$("#coa-detail-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "' . CController::createUrl('ajaxHtmlAddDetail',
            array('id' => $cashTransaction->header->id, 'coaId' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					$(".detail").html(data);
					$("#total-button").show();
				},
			});
			$("#coa-detail-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
    'columns' =>
    //$coumns
        array(
            'name',
            'code',
            'normal_balance',
        ),
)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
