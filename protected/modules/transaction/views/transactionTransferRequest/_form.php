<?php
/* @var $this TransactionTransferRequestController */
/* @var $transferRequest ->header TransactionTransferRequest */
/* @var $form CActiveForm */
?>
<script>
    var totalPriceView;
    var totalQtyView;
    $(function () {
        totalPriceView = new Cleave("#TransactionTransferRequest_total_price_view", {
            numeral: true,
            numeralThousandsGroupStyle: "thousand"
        });
        /*totalQtyView = new Cleave("#TransactionTransferRequest_total_quantity_view", {
            numeral: true,
            numeralThousandsGroupStyle: "thousand"
        });*/
    })
</script>
<div class="clearfix page-action">
    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Transfer Request',
        Yii::app()->baseUrl . '/transaction/transactionTransferRequest/admin', array(
            'class' => 'button cbutton right',
            'visible' => Yii::app()->user->checkAccess("transaction.transactionTransferRequest.admin")
        )) ?>
    <h1><?php if ($transferRequest->header->id == "") {
            echo "New Transaction Transfer Request";
        } else {
            echo "Update Transaction Transfer Request";
        } ?></h1>
    <!-- begin FORM -->
    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transaction-transfer-request-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($transferRequest->header); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($transferRequest->header, 'transfer_request_no',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($transferRequest->header, 'transfer_request_no',
                                array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                            <?php echo $form->error($transferRequest->header, 'transfer_request_no'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($transferRequest->header, 'transfer_request_date',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $transferRequest->header,
                                'attribute' => "transfer_request_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
//                                    'yearRange' => '1900:2020'
                                ),
                                'htmlOptions' => array(
                                    'value' => $transferRequest->header->isNewRecord ? date('Y-m-d') : $transferRequest->header->transfer_request_date,
                                    //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                ),
                            ));
                            ?>
                            <?php echo $form->error($transferRequest->header, 'transfer_request_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($transferRequest->header, 'status_document',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">

                            <?php echo $form->textField($transferRequest->header, 'status_document', array(
                                'value' => $transferRequest->header->isNewRecord ? 'Draft' : $transferRequest->header->status_document,
                                'readonly' => true
                            ));
                            // if($transferRequest->header->isNewRecord)
                            // {

                            // 	echo $form->textField($transferRequest->header,'status_document',array('value'=>'Draft','readonly'=>true));
                            // }
                            // else
                            // {
                            // 	echo $form->dropDownList($transferRequest->header, 'status_document', array('Draft'=>'Draft','Revised' => 'Revised','Rejected'=>'Rejected','Approved'=>'Approved','Done'=>'Done'),array('prompt'=>'[--Select Status Document--]'));
                            // }

                            ?>
                            <?php echo $form->error($transferRequest->header, 'status_document'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($transferRequest->header, 'estimate_arrival_date',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $transferRequest->header,
                                'attribute' => "estimate_arrival_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
//                                    'yearRange' => '1900:2020'
                                ),
                                'htmlOptions' => array(
                                    'value' => $transferRequest->header->isNewRecord ? date('Y-m-d') : $transferRequest->header->estimate_arrival_date,
                                    //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                ),
                            ));
                            ?>
                            <?php echo $form->error($transferRequest->header, 'estimate_arrival_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($transferRequest->header, 'requester_id',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($transferRequest->header, 'requester_id', array(
                                'value' => $transferRequest->header->isNewRecord ? Yii::app()->user->getId() : $transferRequest->header->requester_id,
                                'readonly' => true
                            )); ?>
                            <?php echo $form->error($transferRequest->header, 'requester_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($transferRequest->header, 'requester_branch_id',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo $form->dropDownlist($transferRequest->header,'requester_branch_id',CHtml::listData(Branch::model()->findAll(),'id','name'),array('prompt'=>'[--Select Branch--]')); ?>

                            <?php echo $form->hiddenField($transferRequest->header, 'requester_branch_id', array(
                                'value' => $transferRequest->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $transferRequest->header->requester_branch_id,
                                'readonly' => true
                            )); ?>
                            <?php echo $form->textField($transferRequest->header, 'requester_branch_name', array(
                                'value' => $transferRequest->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $transferRequest->header->requesterBranch->name,
                                'readonly' => true
                            )); ?>
                            <?php echo $form->error($transferRequest->header, 'requester_branch_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($transferRequest->header, 'destination_branch_id',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownlist($transferRequest->header, 'destination_branch_id',
                                CHtml::listData(Branch::model()->findAll(), 'id', 'name'),
                                array('prompt' => '[--Select Branch--]')); ?>
                            <?php echo $form->error($transferRequest->header, 'destination_branch_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-12 columns">
                            <?php echo CHtml::button('Details', array(
                                    'id' => 'detail-button',
                                    'name' => 'Detail',
                                    'onclick' => '
										jQuery.ajax({
											type: "POST",
											url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $transferRequest->header->id)) . '",
											data: jQuery("form").serialize(),
											success: function(html) {
												jQuery(".detail").html(html);
												$(".detail_unit_price_view").each(function(idx) {
                                                    new Cleave(this, {
                                                        numeral: true,
                                                        numeralThousandsGroupStyle: "thousand",
                                                        onValueChanged: function(e) {
                                                            $("#TransactionTransferRequestDetail_"+idx+"_unit_price").val(e.target.rawValue);
                                                        }
                                                    });
                                                });
											},
										});
								')
                            ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="detail">

            <?php $this->renderPartial('_detailTransferRequest', array(
                'transferRequest' => $transferRequest,
                'product' => $product,
                'productDataProvider' => $productDataProvider
            ));
            ?>
        </div>
        <div class="row">
            <div class="small-12 medium-6 columns">

                <div class="field">
                    <div class="row collapse">
                        <div class="small-12 columns">
                            <?php echo CHtml::button('Total', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'onclick' => '
								$.ajax({
                  type: "POST",
                  url: "' . CController::createUrl('ajaxGetTotal', array('id' => $transferRequest->header->id,)) . '",
                  data: $("form").serialize(),
                  dataType: "json",
                  success: function(data) {
                      $("#TransactionTransferRequest_total_price").val(data.total);                      
                      $("#TransactionTransferRequest_total_quantity").val(data.totalItems);
                      totalPriceView.setRawValue(data.total);
                      //totalQtyView.setRawValue(data.totalItems);
                      $("#TransactionTransferRequest_total_quantity_view").val(data.totalItems);
                  },
                });',
                            )); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($transferRequest->header, 'total_quantity',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($transferRequest->header, 'total_quantity'); ?>
                            <?php echo $form->textField($transferRequest->header, 'total_quantity', array(
                                    'readonly' => true,
                                    'name' => '',
                                    'id' => 'TransactionTransferRequest_total_quantity_view'
                            )); ?>
                            <?php echo $form->error($transferRequest->header, 'total_quantity'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($transferRequest->header, 'total_price',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($transferRequest->header, 'total_price',
                                array('size' => 18, 'maxlength' => 18, 'readonly' => true)); ?>
                            <?php echo $form->textField($transferRequest->header, 'total_price',
                                array('id' => 'TransactionTransferRequest_total_price_view', 'name' => '', 'readonly' => true)); ?>
                            <?php echo $form->error($transferRequest->header, 'total_price'); ?>
                        </div>
                    </div>
                </div>


                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton($transferRequest->header->isNewRecord ? 'Create' : 'Save',
                        array('class' => 'button cbutton')); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>

    </div><!-- form -->
