<div>
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::dropDownList('BranchId', $branchId, CHtml::listData(Branch::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- Pilih Branch --',
        'onchange' => CHtml::ajax(array(
            'type' => 'POST',
            'url' => CController::createUrl('ajaxHtmlUpdateWarehouseSelect'),
            'update' => '#warehouse_select_div',
        )),
    )); ?>
    <div id="warehouse_select_div">
        <?php $this->renderPartial('_warehouseSelect', array('inventory' => $inventory, 'branchId' => $branchId)); ?>
    </div>
    <div>
        <?php echo CHtml::textField('Specification[parts_serial_number]', CHtml::value($specification, 'parts_serial_number')); ?>
        <?php echo CHtml::textField('Specification[amp]', CHtml::value($specification, 'amp')); ?>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'class' => 'btn_blue')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
</div>

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'inventory-grid',
        'dataProvider' => $inventoryDataProvider,
        'template' => '<div style="overflow-x: scroll; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
           'cssFile' => false,
           'header' => '',
        ),
        'columns' => array(
            array(
                'header'=>'Manufacturer Code', 
                'value'=>'$data->product->manufacturer_code',
            ),
            array(
                'header'=>'Product', 
                'value'=>'$data->product->name',
            ),
            'total_stock',
            'minimal_stock',
            array(
                'header'=>'Amp', 
                'value'=>'CHtml::value($data, "product.productSpecificationBattery.amp)"',
            ),
        ),
    )); ?>
</div>