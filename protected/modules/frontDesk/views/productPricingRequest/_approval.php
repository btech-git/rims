<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-pricing-request-form',
        'enableAjaxValidation' => false,
    )); ?>

    <div class="row">
        <div class="large-12 columns">
            <div class="field">
                <div class="row collapse">
                    <h2>Permintaan Harga</h2>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Permintaan Harga #</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'transaction_number')); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Tanggal</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'request_date')); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Status Document</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'status')); ?>
                    </div>
                </div>
            </div>
            <hr />
            <div class="field">
                <div class="row collapse">
                    <div class="small-12 columns">
                        <h2>Product Detail</h2>
                    </div>
                </div>
            </div>
            <div class="field">
                <table>
                    <thead>
                        <tr>
                            <td>Product</td>
                            <td>Brand</td>
                            <td>Category</td>
                            <td>Quantity</td>
                            <td>Recommended Price</td>
                            <td>Memo</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productPricingRequest->details as $detail): ?>
                            <tr>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'brand.name')); ?>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'subBrand.name')); ?>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'subBrandSeries.name')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'productMasterCategory.name')); ?>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'productSubMasterCategory.name')); ?>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'productSubCategory.name')); ?>
                                </td>
                                <td style="text-align: center">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'quantity'))); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'recommended_price'))); ?>
                                </td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <hr />
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-12 columns">
                        <h2>Revision History</h2>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-12 columns">
                        <?php if ($historis != null): ?>
                            <table>
                                <thead>
                                    <tr>
                                        <td>Approval type</td>
                                        <td>Revision</td>
                                        <td>Date</td>
                                        <td>Note</td>
                                        <td>Supervisor</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historis as $key => $history): ?>
                                        <tr>
                                            <td><?php echo $history->approval_type; ?></td>
                                            <td><?php echo $history->revision; ?></td>
                                            <td><?php echo $history->date; ?></td>
                                            <td><?php echo $history->note; ?></td>
                                            <td><?php echo $history->supervisor.username; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: echo "No Revision History"; ?>		
                        <?php endif; ?>			 
                    </div>
                </div>
            </div>

            <hr />
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-12 columns">
                        <h2>Approval</h2>
                    </div>
                </div>
            </div>

            <div class="field">
                <table>
                    <tr>
                        <td style="font-weight: bold; text-align: center">Approval Type</td>
                        <td style="font-weight: bold; text-align: center">Revision</td>
                        <td style="font-weight: bold; text-align: center">Date</td>
                        <td style="font-weight: bold; text-align: center">Note</td>
                        <td style="font-weight: bold; text-align: center">Supervisor</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'product_pricing_request_header_id'); ?>		
                            <?php echo $form->dropDownList($model, 'approval_type', array(
                                'Revised' => 'Need Revision',
                                'Rejected'=>'Rejected',
                                'Approved'=>'Approved'
                            ),array('prompt'=>'[--Select Approval Status--]')); ?>
                            <?php echo $form->error($model,'approval_type'); ?>
                        </td>
                        <td>
                            <?php $revisions = ProductPricingRequestApproval::model()->findAllByAttributes(array('product_pricing_request_header_id'=>$productPricingRequest->header->id)); ?>
                            <?php echo $form->textField($model, 'revision',array('value' => count($revisions) != 0 ? count($revisions) : 0, 'readonly' => true)); ?>		
                            <?php echo $form->error($model,'revision'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'date',array('readonly'=>true)); ?>
                            <?php echo $form->error($model,'date'); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($model, 'note', array('rows'=>5, 'cols'=>30)); ?>
                            <?php echo $form->error($model,'note'); ?>
                        </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'supervisor_id',array('readonly'=>true,'value'=> Yii::app()->user->getId()));?>
                            <?php echo $form->textField($model, 'supervisor_name',array('readonly'=>true,'value'=> Yii::app()->user->getName()));?>
                            <?php echo $form->error($model,'supervisor_id'); ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <hr />
            
            <div class="field buttons text-center">
                <?php echo CHtml::submitButton('Save', array('class' => 'button cbutton')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->