<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'transaction-request-order-form',
        'enableAjaxValidation' => false,
    ));
    ?> 

    <div class="row">
        <div class="large-12 columns">
            <div class="field">
                <div class="row collapse">
                    <h2>Stock Adjustment</h2>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Adjustment No</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($stockAdjustmentHeader, 'stock_adjustment_number', array('value' => $stockAdjustmentHeader->stock_adjustment_number, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Date Posting</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($stockAdjustmentHeader, 'date_posting', array('value' => $stockAdjustmentHeader->date_posting, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Type</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($stockAdjustmentHeader, 'transaction_type', array('value' => $stockAdjustmentHeader->transaction_type, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Status Document</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($stockAdjustmentHeader, 'status', array('value' => $stockAdjustmentHeader->status, 'readonly' => true)); ?>
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
                    <tr>
                        <td style="font-weight: bold; text-align: center">Product</td>
                        <td style="font-weight: bold; text-align: center">Kode</td>
                        <td style="font-weight: bold; text-align: center">Kategori</td>
                        <td style="font-weight: bold; text-align: center">Brand</td>
                        <td style="font-weight: bold; text-align: center">Sub Brand</td>
                        <td style="font-weight: bold; text-align: center">Sub Brand Series</td>
                        <td style="font-weight: bold; text-align: center">Jumlah Stok</td>
                        <td style="font-weight: bold; text-align: center">Jumlah Penyesuaian</td>
                        <td style="font-weight: bold; text-align: center">Jumlah Perbedaan</td>
                        <td style="font-weight: bold; text-align: center">Unit</td>
                        <td style="font-weight: bold; text-align: center">Memo</td>
                    </tr>
                        <?php $stockAdjustmentDetails = StockAdjustmentDetail::model()->findAllByAttributes(array('stock_adjustment_header_id' => $stockAdjustmentHeader->id)) ?>
                        <?php foreach ($stockAdjustmentDetails as $key => $stockAdjustmentDetail): ?>
                        <tr>
                            <?php $product = Product::model()->findByPK($stockAdjustmentDetail->product_id); ?>
                            <td><?php echo CHtml::encode(CHtml::value($stockAdjustmentDetail, 'product.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($stockAdjustmentDetail, 'product.manufacturer_code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($stockAdjustmentDetail, 'product.masterSubCategoryCode')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($stockAdjustmentDetail, 'product.brand.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($stockAdjustmentDetail, 'product.subBrand.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($stockAdjustmentDetail, 'product.subBrandSeries.name')); ?></td>
                            <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($stockAdjustmentDetail, 'quantity_current'))); ?></td>
                            <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($stockAdjustmentDetail, 'quantity_adjustment'))); ?></td>
                            <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($stockAdjustmentDetail, 'getQuantityDifference'))); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($stockAdjustmentDetail, 'product.unit.name')); ?></td>
                            <td><?php echo $stockAdjustmentDetail->memo; ?></td>
                        </tr>
                    <?php endforeach; ?>
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
                                        <td>date</td>
                                        <td>note</td>
                                        <td>supervisor</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historis as $key => $history): ?>
                                        <tr>
                                            <td><?php echo $history->approval_type; ?></td>
                                            <td><?php echo $history->revision; ?></td>
                                            <td><?php echo $history->date; ?></td>
                                            <td><?php echo $history->note; ?></td>
                                            <td><?php echo $history->supervisor_id !== null ? $history->supervisor->username : " "; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else:
                            echo "No Revision History";
                        ?>		
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
                            <?php echo $form->hiddenField($model, 'stock_adjustment_header_id', array('value' => $stockAdjustmentHeader->id)); ?>		
                            <?php echo $form->dropDownList($model, 'approval_type', array(
                                'Revised' => 'Need Revision', 
                                'Rejected' => 'Rejected', 
                                'Approved' => 'Approved'
                            ), array('prompt' => '[--Select Approval Status--]')); ?>
                            <?php echo $form->error($model, 'approval_type'); ?>
                        </td>
                        <td>
                            <?php $revisions = TransactionPurchaseOrderApproval::model()->findAllByAttributes(array('purchase_order_id' => $stockAdjustmentHeader->id)); ?>
                            <?php echo $form->textField($model, 'revision', array('value' => count($revisions) != 0 ? count($revisions) : 0, 'readonly' => true)); ?>		
                            <?php echo $form->error($model, 'revision'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'date', array('readonly' => true)); ?>
                            <?php echo $form->error($model, 'date'); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($model, 'note', array('rows' => 5, 'cols' => 30)); ?>
                            <?php echo $form->error($model, 'note'); ?>
                        </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'supervisor_id', array('readonly' => true, 'value' => Yii::app()->user->getId())); ?>
                            <?php echo $form->textField($model, 'supervisor_name', array('readonly' => true, 'value' => Yii::app()->user->getName())); ?>
                            <?php echo $form->error($model, 'supervisor_id'); ?>
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
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->