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
        $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Stock Adjustment', Yii::app()->baseUrl . '/frontDesk/adjustment/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.stockAdjustment.admin"))) ?>

        <?php /* if ($model->status!='Approved') : ?>
          <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/frontDesk/adjustment/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.stockAdjustment.update"))) ?>
          <?php endif; */ ?>

        <h1>View StockAdjustmentHeader #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'stock_adjustment_number',
                'date_posting',
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
                    'name' => 'user_id',
                    'header' => 'User',
                    'value' => $model->user->username,
                ),
                array(
                    'name' => 'supervisor_id',
                    'header' => 'SPV',
                    'value' => empty($model->supervisor_id) ? 'N/A' : $model->supervisor->name,
                ),
                array(
                    'name' => 'branch_id',
                    'header' => 'Branch',
                    'value' => $model->branch->name,
                ),
                'status',
                'note',
            ),
        )); ?>

        <hr />
        
        <h2>Detail Product</h2>
        
        <div class="row">
            <div class="small-12 columns">
                <div style="max-width: 90em; width: 100%;">
                    <div style="overflow-y: hidden; margin-bottom: 1.25rem;">
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'adjustment-detail-grid',
                            'dataProvider' => new CArrayDataProvider($model->stockAdjustmentDetails),
                            'columns' => array(
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
                                'product.unit.name: Unit',
                            ),
                        )); ?>

                        <?php //$this->renderPartial('_detailView', array('model'=>$model,'warehouse'=>$warehouse));  ?>
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="small-12 columns">
                <?php $this->renderPartial('_approval', array('listApproval' => $listApproval)); ?>
            </div>
        </div>
    </div>
</div>