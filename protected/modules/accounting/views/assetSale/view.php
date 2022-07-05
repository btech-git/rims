<?php
/* @var $this AssetSaleController */
/* @var $model AssetSale */

$this->breadcrumbs=array(
    'Asset Sales'=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List AssetSale', 'url'=>array('index')),
    array('label'=>'Create AssetSale', 'url'=>array('create')),
    array('label'=>'Update AssetSale', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete AssetSale', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage AssetSale', 'url'=>array('admin')),
);
?>

<h1>View Asset Sale #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'transaction_number',
        'transaction_date',
        'transaction_time',
        array(
            'label' => 'Category',
            'value' => $model->assetPurchase->assetCategory->description,
        ),
        array(
            'label' => 'Item Description',
            'value' => $model->assetPurchase->description,
        ),
        array(
            'label' => 'Lama Pembukuan ( Bulan )',
            'value' => $model->assetPurchase->monthly_useful_life,
        ),
        array(
            'label' => 'Harga Beli',
            'value' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'assetPurchase.purchase_value'))),
        ),
        array(
            'label' => 'Akumulasi Depresiasi',
            'value' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'assetPurchase.accumulated_depreciation_value'))),
        ),
        array(
            'label' => 'Nilai Sekarang',
            'value' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'assetPurchase.current_value'))),
        ),
        array(
            'label' => 'Nilai Jual',
            'value' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'sale_price'))),
        ),
        array(
            'label' => 'Bank',
            'value' => $model->companyBank->bank->name,
        ),
        array(
            'label' => 'Coa Bank',
            'value' => $model->companyBank->coa->name,
        ),
        'note',
        'user.username',
    ),
)); ?>

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
                <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->transaction_number, 'is_coa_category' => 0)); ?>
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