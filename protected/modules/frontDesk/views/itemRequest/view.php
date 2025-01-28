<?php
/* @var $this ItemRequestController */
/* @var $itemRequest ItemRequest */

$this->breadcrumbs = array(
    'Item Requests' => array('admin'),
    $itemRequest->id,
);

$this->menu = array(
    array('label' => 'List Item Request', 'url' => array('index')),
    array('label' => 'Create Item Request', 'url' => array('create')),
    array('label' => 'Update Item Request', 'url' => array('update', 'id' => $itemRequest->id)),
    array(
        'label' => 'Delete Item Request',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $itemRequest->id),
            'confirm' => 'Are you sure you want to delete this item?'
        )
    ),
    array('label' => 'Manage Item Request', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage', Yii::app()->baseUrl . '/frontDesk/itemRequest/admin', array(
            'class' => 'button cbutton right',
            'visible' => Yii::app()->user->checkAccess("frontDesk.itemRequest.admin")
        ));  ?>

        <?php //if ($itemRequest->status_document != 'Approved' && $itemRequest->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/frontDesk/itemRequest/update?id=' . $itemRequest->id, array(
                'class' => 'button cbutton right',
                'style' => 'margin-right:10px',
                'visible' => Yii::app()->user->checkAccess("itemRequestEdit")
            )); ?>
        <?php //endif; ?>

        <?php /*if ($itemRequest->status_document == "Draft" && Yii::app()->user->checkAccess("itemRequestApproval")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl . '/frontDesk/itemRequest/updateApproval?headerId=' . $itemRequest->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php elseif ($itemRequest->status_document != "Draft" && Yii::app()->user->checkAccess("itemRequestSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/frontDesk/itemRequest/updateApproval?headerId=' . $itemRequest->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php endif;*/ ?>
        
        <h1>View Permintaan Barang non-stock #<?php echo $itemRequest->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $itemRequest,
            'attributes' => array(
                'transaction_number',
                'transaction_date',
                'transaction_time',
                'status_document',
                'note',
                array(
                    'name' => 'branch_id', 
                    'value' => $itemRequest->branch->name
                ),
                array(
                    'name' => 'user_id', 
                    'label' => 'Created by',
                    'value' => $itemRequest->user->username
                ),
            ),
        )); ?>

    </div>
</div>

<hr />

<div class="detail">
    <h2>Detail List</h2>

    <br />

    <table style="border: 1px solid">
        <thead>
            <tr style="background-color: skyblue">
                <th style="width: 5%">No.</th>
                <th>Name</th>
                <th>Deskripsi</th>
                <th>Quantity</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($itemRequest->itemRequestDetails as $i => $detail): ?>
                <tr>
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'item_name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'description'));  ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity')));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'unit.name'));  ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price')));  ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total_price')));  ?></td>
                </tr>	
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align: right" colspan="3">Total Quantity</td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($itemRequest, 'total_quantity')));  ?></td>
                <td style="text-align: right" colspan="2">Grand Total</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($itemRequest, 'total_price')));  ?></td>
            </tr>
        </tfoot>
    </table>
</div>
	

