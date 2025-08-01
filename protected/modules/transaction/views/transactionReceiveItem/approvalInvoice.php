<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs=array(
    'Purchase Invoice'=>array('admin'),
    'Create',
);
?>
<div id="maincontent">
    <?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <h1><?php echo "New Purchase Invoice"; ?></h1>
    <!-- begin FORM -->
    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transaction-receive-item-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($receiveItem); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php if (empty($receiveItem->purchase_order_id)): ?>
                                <?php echo $form->labelEx($receiveItem, 'consignment_in_id', array('class' => 'prefix')); ?>
                            <?php else: ?>
                                <?php echo $form->labelEx($receiveItem, 'purchase_order_id', array('class' => 'prefix')); ?>
                            <?php endif; ?>
                        </div>
                        <div class="small-8 columns">
                            <?php if (empty($receiveItem->purchase_order_id)): ?>
                                <?php echo CHtml::encode(CHtml::value($receiveItem, 'consignmentIn.consignment_in_number')); ?>
                            <?php else: ?>
                                <?php echo CHtml::encode(CHtml::value($receiveItem, 'purchaseOrder.purchase_order_no')); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>			 
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem, 'receive_item_no', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem, 'receive_item_no')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem, 'receive_item_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem, 'receive_item_date')); ?>
                        </div>
                    </div>
                </div>

                <div id="supplier">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem, 'supplier_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($receiveItem, 'purchaseOrder.supplier.name')); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem, 'recipient_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem, 'user.username')); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem, 'supplier_delivery_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem, 'supplier_delivery_number')); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem, 'invoice_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_number')); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem, 'invoice_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_date')); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem, 'invoice_due_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_due_date')); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem, 'invoice_tax_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_tax_number')); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem, 'note', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem, 'note')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <br /><hr />
        
        <div class="detail">
            <?php if (count($receiveItem->transactionReceiveItemDetails) != 0): ?>
                <table>
                    <thead>
                        <tr>
                            <td>Product</td>
                            <td>Code</td>
                            <td>Kategori</td>
                            <td>Brand</td>
                            <td>Sub Brand</td>
                            <td>Sub Brand Series</td>
                            <td>Qty Order</td>
                            <td>Qty Received</td>
                            <td>Unit</td>
                            <td>Price</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($receiveItem->transactionReceiveItemDetails as $detail): ?>
                            <tr>
                                <?php $product = $detail->product; ?>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'qty_request')); ?></td>
                                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'qty_received')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'purchaseOrderDetail.price_before_tax'))); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'totalPrice'))); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10" style="text-align: right">TOTAL</td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveItem, 'subTotal'))); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align: right">PPn <?php echo CHtml::encode(CHtml::value($receiveItem, 'purchaseOrder.tax_percentage')); ?>%</td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveItem, 'taxNominal'))); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align: right">SUB TOTAL</td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveItem, 'grandTotal'))); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align: right">PEMBULATAN</td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveItem, 'invoice_rounding_nominal'))); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align: right">GRAND TOTAL</td>
                            <td style="text-align: right">
                                <span id="grand_total">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receiveItem, 'invoice_grand_total_rounded'))); ?>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
        </div>
        
        <div class="row">
            <div class="small-12 medium-6 columns">			 
                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton('Approve', array('class' => 'button cbutton', 'name' => 'Approve', 'confirm' => 'Are you sure you want to approve?')); ?>
                </div>
            </div>
        </div>
    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
</div>