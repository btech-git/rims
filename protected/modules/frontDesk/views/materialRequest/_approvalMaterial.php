<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'material-request-form',
        'enableAjaxValidation' => false,
    )); ?>

        <!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->
    <div class="row">
        <div class="large-12 columns">
            <div class="field">
                <div class="row collapse">
                    <h2>Permintaan Bahan</h2>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Permintaan Bahan No</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'transaction_number')); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Date Transaction</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'dateTime')); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Status Document</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'status_document')); ?>
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
                            <td>Code</td>
                            <td>Category</td>
                            <td>Brand</td>
                            <td>Sub Brand</td>
                            <td>Sub Brand Series</td>
                            <td>Quantity</td>
                            <td>Unit</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materialRequest->details as $key => $detail): ?>
                        <?php $productInfo = $detail->product; ?>
                            <tr>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($productInfo, 'name')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($productInfo, 'manufacturer_code')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($productInfo, 'masterSubCategoryCode')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($productInfo, 'brand.name')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($productInfo, 'subBrand.name')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($productInfo, 'subBrandSeries.name')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'quantity'))); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($productInfo, 'unit.name')); ?>
                                </td>
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
                                            <td><?php echo $history->supervisor_id; ?></td>
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
                            <?php echo $form->hiddenField($model, 'material_request_header_id',array('value'=>$materialRequest->header->id)); ?>		
                            <?php echo $form->dropDownList($model, 'approval_type', array(
                                'Revised' => 'Need Revision',
                                'Rejected'=>'Rejected',
                                'Approved'=>'Approved'
                            ),array('prompt'=>'[--Select Approval Status--]')); ?>
                            <?php echo $form->error($model,'approval_type'); ?>
                        </td>
                        <td>
                            <?php $revisions = MaterialRequestApproval::model()->findAllByAttributes(array('material_request_header_id'=>$materialRequest->header->id)); ?>
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