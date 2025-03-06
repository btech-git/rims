<?php
/* @var $this ItemRequestController */
/* @var $itemRequest ItemRequest */

$this->breadcrumbs = array(
    'Item Requests' => array('admin'),
    $itemRequest->id,
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
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
	

