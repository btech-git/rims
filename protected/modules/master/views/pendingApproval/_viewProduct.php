<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$productDataProvider,
    'filter'=>$product,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        'id',
        'manufacturer_code',
        array(
            'name' => 'name',
            'value' => 'CHTml::link($data->name, array("/master/product/view", "id"=>$data->id))',
            'type' => 'raw'
        ),
        array(
            'name' => 'brand_id',
            'value' => '$data->brand ? $data->brand->name : \'\'',
        ),
        array(
            'name' => 'sub_brand_id',
            'value' => '$data->subBrand ? $data->subBrand->name : \'\'',
            'filter' => false,
        ),
        array(
            'name' => 'sub_brand_series_id',
            'value' => '$data->subBrandSeries ? $data->subBrandSeries->name : \'\'',
            'filter' => false,
        ),
        array(
            'header' => 'Master Category',
            'value' => '$data->productMasterCategory->name',
            'filter' => false,
        ),
        array(
            'header' => 'Sub Master Category',
            'value' => '$data->productSubMasterCategory->name',
            'filter' => false,
        ),
        array(
            'header' => 'Sub Category',
            'value' => '$data->productSubCategory->name',
            'filter' => false,
        ),
        'date_posting',
    ),
)); ?>