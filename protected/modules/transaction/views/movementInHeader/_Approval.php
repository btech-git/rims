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

        <!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->
    <div class="row">
        <div class="medium-12 columns">
            <div class="field">
                <div class="row collapse">
                    <h2>Movement In</h2>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Movement In No</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($movement, 'movement_in_number', array('value' => $movement->movement_in_number, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Date Posting</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($movement, 'date_posting', array('value' => $movement->date_posting, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <hr />
            <div class="field">
                <div class="row collapse">
                    <h2>Details</h2>
                </div>
            </div>
            <div class="field">
                <?php $details = MovementInDetail::model()->findAllByAttributes(array('movement_in_header_id' => $movement->id)); ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Warehouse</th>
                            <th>Quantity Transaction</th>
                            <th>Quantity</th>
                            <th>Quantity in warehouse</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $quantityInventory = array(); ?>
                        <?php $cekInventory = "NO"; ?>
                        <?php foreach ($details as $key => $detail): ?>
                            <tr>
                                <td><?php echo $detail->product->name; ?></td>
                                <td><?php echo $detail->warehouse == "" ? "" : $detail->warehouse->name ?></td>
                                <td><?php echo $detail->quantity_transaction; ?></td>
                                <td><?php echo $detail->quantity; ?></td>
                                <?php
                                $stockInventory = Inventory::model()->findByAttributes(array('product_id' => $detail->product_id, 'warehouse_id' => $detail->warehouse_id));
                                if (!empty($stockInventory) && $stockInventory->total_stock < $detail->quantity) {
                                    $quantityInventory[] = 'NO';
                                } else {
                                    $quantityInventory[] = 'YES';
                                }
                                ?>
                                <td><?php echo!empty($stockInventory) ? $stockInventory->total_stock : '0'; ?></td>
                                <td><?php echo!empty($stockInventory) && $stockInventory->total_stock > $detail->quantity ? 'OK' : 'Not OK'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
                                            <td><?php echo $history->supervisor_id; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        <?php
                        else:
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
                            <?php echo $form->hiddenField($model, 'movement_in_id', array('value' => $movement->id)); ?>		
                            <?php echo $form->dropDownList($model, 'approval_type', array('Revised' => 'Need Revision', 'Rejected' => 'Rejected', 'Approved' => 'Approved'), array('prompt' => '[--Select Approval Status--]')); ?>
                            <?php echo $form->error($model, 'approval_type'); ?>
                        </td>
                        <td>
                            <?php $revisions = MovementInApproval::model()->findAllByAttributes(array('movement_in_id' => $movement->id)); ?>
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
            <?php echo IdempotentManager::generate(); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->