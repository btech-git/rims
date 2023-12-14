<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */

$this->breadcrumbs=array(
    'Asset Sales'=>array('admin'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List AssetPurchase', 'url'=>array('admin')),
    array('label'=>'Create AssetPurchase', 'url'=>array('create')),
    array('label'=>'Update AssetPurchase', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete AssetPurchase', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage AssetPurchase', 'url'=>array('admin')),
);
?>

<h1>View Asset Sales #<?php echo $model->id; ?></h1>

<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/accounting/assetManagement/admin';?>"><span class="fa fa-th-list"></span>Manage Asset</a>
                        
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'transaction_number',
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->transaction_date),
        ),
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
            'label' => 'Bank',
            'value' => $model->companyBank->account_name,
        ),
        array(
            'label' => 'Harga Beli',
            'value' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'purchase_value'))),
        ),
        array(
            'label' => 'Akumulasi Depresiasi',
            'value' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'accumulated_depreciation_value'))),
        ),
        array(
            'label' => 'Nilai Sekarang',
            'value' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'current_value'))),
        ),
        array(
            'label' => 'Harga Jual',
            'value' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'sale_price'))),
        ),
        'status',
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
                    <th style="width: 15%">Date</th>
                    <th style="width: 15%">Debit</th>
                    <th style="width: 15%">Kredit</th>
                </tr>
            </thead>

            <tbody>
                <?php $totalDebit = 0; $totalCredit = 0; $count = 0; ?>
                <?php $saleTransactions = AssetSale::model()->findAllByAttributes(array('asset_purchase_id' => $model->id)); ?>
                <?php foreach ($saleTransactions as $saleTransaction): ?>
                    <?php $saleJournals = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $saleTransaction->transaction_number, 'transaction_subject' => $model->transaction_number, 'is_coa_category' => 0)); ?>
                    <?php foreach ($saleJournals as $i => $saleJournal): ?>

                        <?php $amountDebit = $saleJournal->debet_kredit == 'D' ? CHtml::value($saleJournal, 'total') : 0; ?>
                        <?php $amountCredit = $saleJournal->debet_kredit == 'K' ? CHtml::value($saleJournal, 'total') : 0; ?>

                        <tr>
                            <td style="text-align: center"><?php echo $count + 1; ?></td>
                            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($saleJournal, 'branchAccountCode')); ?></td>
                            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($saleJournal, 'branchAccountName')); ?></td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($saleJournal, 'tanggal_transaksi'))); ?></td>
                            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?></td>
                            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?></td>
                        </tr>

                        <?php $totalDebit += $amountDebit; ?>
                        <?php $totalCredit += $amountCredit; ?>
                        <?php $count += 1; ?>

                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?></td>
                    <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?></td>
                </tr>        
            </tfoot>
        </table>
    </fieldset>
<?php endif; ?>