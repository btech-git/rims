<?php
/* @var $this StockAdjustmentController */
/* @var $model StockAdjustmentHeader */

$this->breadcrumbs = array(
    'Stock Adjustment Headers' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List StockAdjustmentHeader', 'url' => array('index')),
    array('label' => 'Create StockAdjustmentHeader', 'url' => array('create')),
    array('label' => 'Update StockAdjustmentHeader', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete StockAdjustmentHeader', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage StockAdjustmentHeader', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id;
        $ccaction = Yii::app()->controller->action->id;
        ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Stock Adjustment', Yii::app()->baseUrl . '/frontDesk/adjustment/admin', array('class' => 'button cbutton right')) ?>

        <?php if ($model->status == "Draft" && Yii::app()->user->checkAccess("stockAdjustmentApproval") && $model->status != 'CANCELLED!!!'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl . '/frontDesk/adjustment/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php elseif ($model->status != "Draft" && Yii::app()->user->checkAccess("stockAdjustmentSupervisor") && $model->status != 'CANCELLED!!!'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/frontDesk/adjustment/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
<?php endif; ?>

        <h1>View Stock Adjustment #<?php echo $model->id; ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'stock_adjustment_number',
                'date_posting',
                'transaction_type',
                array(
                    'name' => 'warehouse_id',
                    'header' => 'Gudang',
                    'value' => $model->warehouse->name,
                ),
                array(
                    'name' => 'branch_id',
                    'header' => 'Branch',
                    'value' => $model->branch->name,
                ),
                array(
                    'name' => 'branch_id_destination',
                    'header' => 'Branch Destination',
                    'value' => CHtml::encode(CHtml::value($model, 'branchIdDestination.name')),
                    'visible' => $model->transaction_type == 'Selisih Cabang' ? true : false,
                ),
                array(
                    'name' => 'user_id',
                    'header' => 'User',
                    'value' => $model->user->username,
                ),
                array(
                    'name' => 'supervisor_id',
                    'header' => 'SPV',
                    'value' => empty($model->supervisor_id) ? 'N/A' : $model->supervisor->username,
                ),
                'status',
                'note',
            ),
        ));
        ?>

        <hr />

        <h2>Detail Product</h2>

        <div class="row">
            <div class="small-12 columns">
                <div style="max-width: 120em; width: 100%;">
                    <div style="overflow-y: hidden; margin-bottom: 1.25rem;">
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'adjustment-detail-grid',
                            'dataProvider' => new CArrayDataProvider($model->stockAdjustmentDetails),
                            'columns' => array(
                                'product.id: ID',
                                'product.name: Nama Barang',
                                'product.manufacturer_code: Kode',
                                'product.masterSubCategoryCode: Kategori',
                                'product.brand.name: Brand',
                                'product.subBrand.name: Sub Brand',
                                'product.subBrandSeries.name: Sub Brand Series',
                                array(
                                    'header' => 'Jumlah Stok',
                                    'value' => 'number_format($data->quantity_current, 0)',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Jumlah Penyesuaian',
                                    'value' => 'number_format($data->quantity_adjustment, 0)',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Jumlah Perbedaan',
                                    'value' => 'number_format($data->getQuantityDifference(), 0)',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Jumlah Stok Tujuan',
                                    'value' => 'number_format($data->quantity_current_destination, 0)',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'visible' => $model->transaction_type == 'Selisih Cabang' ? true : false,
                                ),
                                array(
                                    'header' => 'Jumlah Penyesuaian Tujuan',
                                    'value' => 'number_format($data->quantity_adjustment_destination, 0)',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'visible' => $model->transaction_type == 'Selisih Cabang' ? true : false,
                                ),
                                array(
                                    'header' => 'Jumlah Perbedaan Tujuan',
                                    'value' => 'number_format($data->getQuantityDifferenceDestination(), 0)',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'visible' => $model->transaction_type == 'Selisih Cabang' ? true : false,
                                ),
                                'product.unit.name: Unit',
                                'memo',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <hr />

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
                                        <td><?php echo $history->supervisor_id !== null ? $history->supervisor->username : " "; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else:
                        echo "No Revision History";
                    ?>		
                    <?php endif; ?>			 
                </div>
            </div>
        </div>

        <hr />

        <div class="row">
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
                    <?php $totalDebit = 0;
                    $totalCredit = 0; ?>
<?php
$transactions = JurnalUmum::model()->findAllByAttributes(array(
    'kode_transaksi' => $model->stock_adjustment_number,
    'is_coa_category' => 0
        ));
?>
                    <?php foreach ($transactions as $i => $header): ?>
                        <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
                        <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>
                        <tr>
                            <td style="text-align: center"><?php echo $i + 1; ?></td>
                            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountDebit)); ?></td>
                            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountCredit)); ?></td>
                        </tr>
                                <?php $totalDebit += $amountDebit; ?>
    <?php $totalCredit += $amountCredit; ?>
                            <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                        <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid">
<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebit)); ?>
                        </td>
                        <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid">
<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCredit)); ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>