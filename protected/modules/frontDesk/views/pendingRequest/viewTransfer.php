<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List TransactionTransferRequest', 'url' => array('index')),
    array('label' => 'Create TransactionTransferRequest', 'url' => array('create')),
    array('label' => 'Update TransactionTransferRequest', 'url' => array('update', 'id' => $model->id)),
    array(
        'label' => 'Delete TransactionTransferRequest',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
            'confirm' => 'Are you sure you want to delete this item?'
        )
    ),
    array('label' => 'Manage TransactionTransferRequest', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <h1>View Transaction Transfer Request #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'transfer_request_no',
                'transfer_request_date',
                'status_document',
                'estimate_arrival_date',
                array('name' => 'requester_id', 'value' => $model->user->username),
                array('name' => 'requester_branch_id', 'value' => $model->requesterBranch->name),
                array('name' => 'destination_branch_id', 'value' => $model->destinationBranch->name),
                array(
                    'name' => 'approved_by', 
                    'value' => empty($model->approvedBy) ? "" : $model->approvedBy->username
                ),
            ),
        )); ?>
    </div>
</div>
<div class="detail">
    <?php if (count($transferDetails)>0): ?>
        <table>
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Code</td>
                    <td>Kategori</td>
                    <td>Brand</td>
                    <td>Sub Brand</td>
                    <td>Sub Brand Series</td>
                    <td>Quantity</td>
                    <td>Unit</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transferDetails as $key => $transferDetail): ?>
                    <tr>
                        <td><?php echo $transferDetail->product ? $transferDetail->product->name : '-'; ?></td>
                        <td><?php echo $transferDetail->product ? $transferDetail->product->manufacturer_code : '-'; ?></td>
                        <td><?php echo $transferDetail->product ? $transferDetail->product->masterSubCategoryCode : '-'; ?></td>
                        <td><?php echo $transferDetail->product ? $transferDetail->product->brand->name : '-'; ?></td>
                        <td><?php echo $transferDetail->product ? $transferDetail->product->subBrand->name : '-'; ?></td>
                        <td><?php echo $transferDetail->product ? $transferDetail->product->subBrandSeries->name : '-'; ?></td>
                        <td style="text-align: center"><?php echo $transferDetail->quantity; ?></td>
                        <td><?php echo $transferDetail->unit->name; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold">Total Quantity</td>
                    <td style="text-align: center; font-weight: bold"><?php echo $model->total_quantity; ?></td>
                    <td>&nbsp;</td>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <?php echo "No Detail Available!"; ?>
    <?php endif; ?>
</div>
	
<div class="form">
    <?php echo CHtml::beginForm(); ?>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Reject', array('name' => 'Reject', 'confirm' => 'Are you sure you want to reject this transaction?')); ?>
            <?php echo CHtml::submitButton('Approve', array('class' => 'button cbutton', 'name' => 'Approve', 'confirm' => 'Are you sure you want to approve this transaction?')); ?>
        </div>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->
