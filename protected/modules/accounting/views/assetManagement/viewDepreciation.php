<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */

$this->breadcrumbs=array(
    'Asset Depreciation'=>array('admin'),
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

<h1>View Asset Depreciation #<?php echo $model->id; ?></h1>

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
                <?php if (!empty($model->assetDepreciationDetails)): ?>
                    <?php foreach ($model->assetDepreciationDetails as $assetDepreciationDetail): ?>
                        <?php $depreciationJournals = JurnalUmum::model()->findAllByAttributes(array(
                            'kode_transaksi' => $model->transaction_number, 
                            'is_coa_category' => 0
                        )); ?>
                        <?php foreach ($depreciationJournals as $i => $depreciationJournal): ?>

                            <?php $amountDebit = $depreciationJournal->debet_kredit == 'D' ? CHtml::value($depreciationJournal, 'total') : 0; ?>
                            <?php $amountCredit = $depreciationJournal->debet_kredit == 'K' ? CHtml::value($depreciationJournal, 'total') : 0; ?>

                            <tr>
                                <td style="text-align: center"><?php echo $count + 1; ?></td>
                                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($depreciationJournal, 'branchAccountCode')); ?></td>
                                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($depreciationJournal, 'branchAccountName')); ?></td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($depreciationJournal, 'tanggal_transaksi'))); ?></td>
                                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?></td>
                                <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?></td>
                            </tr>

                            <?php $totalDebit += $amountDebit; ?>
                            <?php $totalCredit += $amountCredit; ?>
                            <?php $count += 1; ?>

                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
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

<?php if (!empty($model->assetDepreciationDetails)): ?>
    <br /> <hr />

    <div>
        <fieldset>
            <legend>Depreciation</legend>
            <table>
                <thead>
                    <tr>
                        <td>No.</td>
                        <td>Transaction #</td>
                        <td>Description</td>
                        <td>Date</td>
                        <td>Nilai Beli</td>
                        <td>Nilai Depresiasi</td>
                        <td>Nilai Akumulasi</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <?php foreach($model->assetDepreciationDetails as $i => $depreciation): ?>
                    <tbody>
                        <tr>
                            <td style="width: 5%"><?php echo $i +1; ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($depreciation, 'assetPurchase.transaction_number')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($depreciation, 'assetPurchase.description')); ?></td>
                            <td style="width: 15%"><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($depreciation, 'depreciation_date'))); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($depreciation, 'assetPurchase.purchase_value'))); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($depreciation, 'amount'))); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($depreciation, 'assetPurchase.accumulated_depreciation_value'))); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($depreciation, 'assetPurchase.status')); ?></td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </fieldset>
    </div>
<?php endif; ?>