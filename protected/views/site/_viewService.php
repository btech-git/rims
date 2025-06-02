<table style="border: 0px solid">
    <tr>
        <td style="border: 0px solid" colspan="4"><h1>List Jasa</h1></td>
    </tr>
    <tr>
        <td>Jasa</td>
        <td>
            <?php echo CHtml::activeTextField($service, 'name', array(
                'onchange' => '
                    $.fn.yiiGridView.update("service-grid", {data: {
                        Service: {
                            name: $(this).val(),
                            code: $("#' . CHtml::activeId($service, 'code') . '").val(),
                            service_category_id: $("#' . CHtml::activeId($service, 'service_category_id') . '").val(),
                            service_type_id: $("#' . CHtml::activeId($service, 'service_type_id') . '").val(),
                        }
                    }});
                ',
            )); ?>
        </td>
        <td>Kode</td>
        <td>
            <?php echo CHtml::activeTextField($service, 'code', array(
                'onchange' => '
                    $.fn.yiiGridView.update("service-grid", {data: {
                        Service: {
                            name: $("#' . CHtml::activeId($service, 'name') . '").val(),
                            service_category_id: $("#' . CHtml::activeId($service, 'service_category_id') . '").val(),
                            service_type_id: $("#' . CHtml::activeId($service, 'service_type_id') . '").val(),
                            code: $(this).val(),
                        }
                    }});
                ',
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Category</td>
        <td>
            <?php echo CHtml::activeDropDownList($service, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'name'), array(
                'empty' => '-- All --',
                'onchange' => '
                    $.fn.yiiGridView.update("service-grid", {data: {
                        Service: {
                            name: $("#' . CHtml::activeId($service, 'name') . '").val(),
                            code: $("#' . CHtml::activeId($service, 'code') . '").val(),
                            service_type_id: $("#' . CHtml::activeId($service, 'service_type_id') . '").val(),
                            service_category_id: $(this).val(),
                        }
                    }});
                ',
            )); ?>
        </td>
        <td>Type</td>
        <td>
            <?php echo CHtml::activeDropDownList($service, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(), 'id', 'name'), array(
                'empty' => '-- All --',
                'onchange' => '
                    $.fn.yiiGridView.update("service-grid", {data: {
                        Service: {
                            name: $("#' . CHtml::activeId($service, 'name') . '").val(),
                            code: $("#' . CHtml::activeId($service, 'code') . '").val(),
                            service_category_id: $("#' . CHtml::activeId($service, 'service_category_id') . '").val(),
                            service_type_id: $(this).val(),
                        }
                    }});
                ',
            )); ?>
        </td>
    </tr>
</table>

<div class="clear"></div>

<div class="row buttons" style="text-align: center">
    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
</div>

<hr />

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'service-grid',
        'dataProvider' => $serviceDataProvider,
        'filter' => null,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            'id',
            'code',
            array(
                'name' => 'name',
                'value' => 'CHtml::link($data->name, array("/master/service/view", "id"=>$data->id), array("target" => "_blank"))',
                'type'=>'raw',
            ),
            array(
                'name' => 'service_category_id',
                'value' => 'CHtml::value($data, "serviceCategory.name")',
            ),
            array(
                'name' => 'service_type_id',
                'value' => 'CHtml::value($data, "serviceType.name")',
            ),
            array(
                'header' => 'Sell Price',
                'value' => 'number_format(CHtml::value($data, "lastSalePrice"), 2)',
                'htmlOptions' => array('style' => 'text-align:right'),
            ),
        ),
    )); ?>
</div>