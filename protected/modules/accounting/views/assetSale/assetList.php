<h1>List Asset</h1>
   
<div id="link">
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Depreciation', Yii::app()->baseUrl.'/accounting/assetDepreciation/admin' , array(
        'class'=>'button cbutton',
//        'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.admin"),
    )); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'asset-grid',
    'dataProvider' => $assetSaleDataProvider,
    'filter' => $assetSale,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'transaction_number',
            'value' => '$data->transaction_number',
        ),
        array(
            'name' => 'transaction_date',
            'value' => '$data->transaction_date',
        ),
        array(
            'header' => 'Category',
            'value' => '$data->assetCategory->description',
        ),
        'description',
        array(
            'header' => 'Harga Beli',
            'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0", $data->purchase_value))',
        ),
        array(
            'header' => 'Akumulasi Depresiasi',
            'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0", $data->accumulated_depreciation_value))',
        ),
        array(
            'header' => 'Nilai Sekarang',
            'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0", $data->current_value))',
        ),
        array(
            'header' => 'Lama (tahun)',
            'value' => '$data->monthly_useful_life',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "assetId" => $data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>