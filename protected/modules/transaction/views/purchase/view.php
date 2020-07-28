<?php
//$purchase as a PurchaseHeader model

$this->breadcrumbs = array(
    'Purchase' => array('/transaction/purchase/create'),
    'View',
);
?>

<style>
    table
    {
        margin-bottom: 0px;
    }
</style>

<h1>Purchase Order View<?php //echo $this->id . '/' . $this->action->id;    ?></h1>
<?php if (Yii::app()->user->hasFlash('confirm')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('confirm'); ?>
    </div>
<?php endif; ?>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $purchase,
    'attributes' => array(
        array(
            'label' => 'Order Pembelian #',
            'value' => $purchase->getCodeNumber(PurchaseHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::encode(CHtml::value($purchase, 'date'))),
        ),
        array(
            'label' => 'Supplier',
            'value' => $purchase->supplier->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => CHtml::encode(CHtml::value($purchase, 'note')),
        ),
    ),
));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'htmlOptions' => array(
        'margin' => '0px'
    ),
    'columns' => array(
        'product.name: Nama Barang',
        'product.size: Size',
        'product.brand.name: Merk',
        array(
            'header' => 'Quantity',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "quantity")), 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Satuan',
            'value' => 'CHtml::encode(CHtml::value($data, "product.unit.name"))',
        ),
        array(
            'header' => 'Harga',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "unit_price")), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
         array(
            'header' => 'Diskon (%)',
            'value' => 'number_format($data->discount, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Total',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "total")), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
    ),
));
?>

<table>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 58%; font-weight: bold">Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::encode(CHtml::value($purchase, 'subTotalQuantity')))); ?>
        </td>
        <td style="text-align: right; width: 30%; font-weight: bold">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::encode(CHtml::value($purchase, 'subTotal')))); ?>
        </td>
    </tr>

    <tr style="background-color: skyblue">
        <td colspan="3" style="font-weight: bold; width: 80%; text-align:right">Diskon  <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::encode(CHtml::value($purchase, 'discount_percentage')))); ?>%</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::encode(CHtml::value($purchase, 'discount_value')))); ?>
        </td>
    </tr>

    <?php if ($purchase->is_tax): ?>
        <tr style="background-color: skyblue">
            <td colspan="3" style="text-align:right; width: 80%">
                PPN 
                <?php echo CHtml::encode(CHtml::value($purchase, 'taxPercentage')); ?>%
            </td>
            <td style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::encode(CHtml::value($purchase, 'calculatedTax')))); ?>
            </td>
        </tr>
    <?php endif; ?>

    <tr style="background-color: skyblue">
        <td colspan="3" style="font-weight: bold; width: 80%; text-align:right">Grand Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::encode(CHtml::value($purchase, 'grandTotal')))); ?>
        </td>
    </tr>
</table>

<br /><br />

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php echo CHtml::link('Edit', array('update', 'id' => $purchase->id)); ?>
    <?php echo CHtml::link('Print', array('memo', 'id' => $purchase->id), array('target' => '_blank')); ?>
</div>
<br />
<?php if ((int) $purchase->is_approved === 0): ?>
    <div>
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::submitButton('APPROVE', array('name' => 'Submit', 'class' => 'btn-approve')); ?>
        <?php echo CHtml::endForm(); ?>
    </div>
<?php endif; ?>
