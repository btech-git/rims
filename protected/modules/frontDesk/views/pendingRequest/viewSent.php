<?php
/* @var $this TransactionSentRequestController */
/* @var $model TransactionSentRequest */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List TransactionSentRequest', 'url' => array('index')),
    array('label' => 'Create TransactionSentRequest', 'url' => array('create')),
    array('label' => 'Update TransactionSentRequest', 'url' => array('update', 'id' => $model->id)),
    array(
        'label' => 'Delete TransactionSentRequest',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
            'confirm' => 'Are you sure you want to delete this item?'
        )
    ),
    array('label' => 'Manage TransactionSentRequest', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <h1>View Transaction Sent Request #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'sent_request_no',
                'sent_request_date',
                'status_document',
                'estimate_arrival_date',
                array('name' => 'requester_id', 'value' => $model->user ? $model->user->username : null),
                array(
                    'name' => 'requester_branch_id',
                    'value' => $model->requesterBranch ? $model->requesterBranch->name : ""
                ),
                array(
                    'name' => 'approve_by', 
                    'value' => $model->approval ? $model->approval->username : null
                ),
                array(
                    'name' => 'destination_branch_id',
                    'value' => $model->destinationBranch ? $model->destinationBranch->name : ""
                ),
                'total_quantity',
                array(
                    'name' => 'total_price',
                    'value' => $this->format_money($model->total_price)
                ),
            )
        )); ?>

    </div>
</div>

<div class="detail">
    <?php if (count($sentDetails) > 0): ?>
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
                    <td>Unit Price (HPP)</td>
                    <td>Unit</td>
                    <td>Amount</td>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($sentDetails as $key => $sentDetail): ?>
                    <tr>
                        <td><?php echo $sentDetail->product ? $sentDetail->product->name : '-'; ?></td>
                        <td><?php echo $sentDetail->product ? $sentDetail->product->manufacturer_code : '-'; ?></td>
                        <td><?php echo $sentDetail->product ? $sentDetail->product->masterSubCategoryCode : '-'; ?></td>
                        <td><?php echo $sentDetail->product ? $sentDetail->product->brand->name : '-'; ?></td>
                        <td><?php echo $sentDetail->product ? $sentDetail->product->subBrand->name : '-'; ?></td>
                        <td><?php echo $sentDetail->product ? $sentDetail->product->subBrandSeries->name : '-'; ?></td>
                        <td><?php echo $sentDetail->quantity; ?></td>
                        <td><?php echo $sentDetail->unit->name; ?></td>
                        <td><?php echo $this->format_money($sentDetail->unit_price); ?></td>
                        <td><?php echo $this->format_money($sentDetail->amount); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
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