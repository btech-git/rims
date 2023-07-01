<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */

$this->breadcrumbs = array(
    'Transaction Return Item' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List TransactionReturnItem', 'url' => array('index')),
    array('label' => 'Create TransactionReturnItem', 'url' => array('create')),
    array('label' => 'Update TransactionReturnItem', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete TransactionReturnItem', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage TransactionReturnItem', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Return Item', Yii::app()->baseUrl . '/transaction/transactionReturnItem/admin', array('class' => 'button cbutton right')) ?>

        <?php
        $movements = MovementInHeader::model()->findAllByAttributes(array('return_item_id' => $model->id));
//        if (empty($movements) && $model->status != 'Approved' && $model->status != 'Rejected'):
        ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/transaction/transactionReturnItem/update?id=' . $model->id, array(
                'class' => 'button cbutton right', 
                'style' => 'margin-right:10px', 
                'visible' => Yii::app()->user->checkAccess("saleReturnEdit")
            )); ?>
        <?php //endif; ?>
        
        <?php if ($model->status == "Draft" && Yii::app()->user->checkAccess("saleReturnApproval")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl . '/transaction/transactionReturnItem/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php elseif ($model->status != "Draft" && Yii::app()->user->checkAccess("saleReturnSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/transaction/transactionReturnItem/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php endif; ?>
        
        <h1>View Transaction Return Jual #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'return_item_no',
                'return_item_date',
                'estimate_arrival_date',
//                'user.username',
                'recipientBranch.name',
                'request_type',
                'estimate_arrival_date',
                'status',
            ),
        )); ?>
    </div>
</div>

<hr />
   
<div class="detail">
    <h3>Details</h3>

    <?php if ($model->request_type == 'Sales Order'): ?>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">SO no</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->salesOrder->sale_order_no; ?></label>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Customer</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo empty($model->customer) ? '-' : $model->customer->name; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($model->request_type == 'Sent Request'): ?>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Sent Request no</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->sentRequest->sent_request_no; ?></label>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Destination Branch</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo empty($model->destinationBranch) ? '-' : $model->destinationBranch->name; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($model->request_type == 'Transfer Request'): ?>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Transfer Request no</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->transferRequest->transfer_request_no; ?></label>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Destination Branch</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo empty($model->destinationBranch) ? '-' : $model->destinationBranch->name; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($model->request_type == 'Consignment Out'): ?>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Consignment Out no</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->consignmentOut->consignment_out_no; ?></label>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Customer</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo empty($model->customer) ? '-' : $model->customer->name; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($returnDetails)): ?>
        <table>
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Code</td>
                    <td>Kategori</td>
                    <td>Brand</td>
                    <td>Sub Brand</td>
                    <td>Sub Brand Series</td>
                    <td>Quantity Delivery</td>
                    <td>Quantity Return</td>
                    <td>Note</td>
                    <td>Barcode Product</td>
                    <td>Quantity Movement</td>
                    <td>Quantity Movement Left</td>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($returnDetails as $key => $returnDetail): ?>
                    <tr>
                        <td><?php echo $returnDetail->product->name == '' ? '-' : $returnDetail->product->name; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.manufacturer_code')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.masterSubCategoryCode')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.brand.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.subBrand.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.subBrandSeries.name')); ?></td>
                        <td><?php echo $returnDetail->quantity_delivery == '' ? '-' : $returnDetail->quantity_delivery; ?></td>
                        <td><?php echo $returnDetail->quantity == '' ? '-' : $returnDetail->quantity; ?></td>
                        <td><?php echo $returnDetail->note == '' ? '-' : $returnDetail->note; ?></td>
                        <td><?php echo $returnDetail->barcode_product == '' ? '-' : $returnDetail->barcode_product; ?></td>
                        <td><?php echo $returnDetail->quantity_movement; ?></td>
                        <td><?php echo $returnDetail->quantity_movement_left; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>	
    <?php else: ?>
        <?php echo 'No Details Available'; ?>
    <?php endif; ?>
</div>

<hr />
    
<br />

<?php if (Yii::app()->user->checkAccess("generalManager")): ?>
    <fieldset>
        <legend>Journal Transactions</legend>
        <table class="report">
            <thead>
                <tr id="header1">
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Kode COA</th>
                    <th>Nama COA</th>
                    <th style="width: 15%">Debit</th>
                    <th style="width: 15%">Kredit</th>
                </tr>
            </thead>

            <tbody>
                <?php $totalDebit = 0; $totalCredit = 0; ?>
                <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->return_item_no, 'is_coa_category' => 0)); ?>
                <?php foreach ($transactions as $i => $header): ?>

                    <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
                    <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>

                    <tr>
                        <td style="text-align: center"><?php echo $i + 1; ?></td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                        <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                        <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?></td>
                        <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?></td>
                    </tr>

                    <?php $totalDebit += $amountDebit; ?>
                    <?php $totalCredit += $amountCredit; ?>

                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?></td>
                    <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?></td>
                </tr>        
            </tfoot>
        </table>
    </fieldset>
<?php endif; ?>