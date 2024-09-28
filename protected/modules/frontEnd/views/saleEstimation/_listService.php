<table style="border: 0px solid">
    <tr>
        <td style="border: 0px solid" colspan="4"><h1>List Jasa</h1></td>
    </tr>
    <tr>
        <td>Jasa</td>
        <td>
            <?php echo CHtml::activeTextField($service, 'name', array(
                'onchange' => 
                    CHtml::ajax(array(
                        'type' => 'GET',
                        'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                        'update' => '#service_data_container',
                    )),
            )); ?>
        </td>
        <td>Kode</td>
        <td>
            <?php echo CHtml::activeTextField($service, 'code', array(
                'onchange' => 
                    CHtml::ajax(array(
                        'type' => 'GET',
                        'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                        'update' => '#service_data_container',
                    )),
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Category</td>
        <td>
            <?php echo CHtml::activeDropDownList($service, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'name'), array(
                'empty' => '-- All --',
                'onchange' => 
                    CHtml::ajax(array(
                        'type' => 'GET',
                        'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                        'update' => '#service_data_container',
                    )),
            )); ?>
        </td>
        <td>Type</td>
        <td>
            <?php echo CHtml::activeDropDownList($service, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(), 'id', 'name'), array(
                'empty' => '-- All --',
                'onchange' => 
                    CHtml::ajax(array(
                        'type' => 'GET',
                        'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                        'update' => '#service_data_container',
                    )),
            )); ?>
        </td>
    </tr>
</table>

<div class="clear"></div>

<div class="row buttons" style="text-align: center">
    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
</div>

<div id="service_data_container">
    <?php $this->renderPartial('_serviceDataTable', array(
        'serviceDataProvider' => $serviceDataProvider,
    )); ?>
</div>

<div>
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'pages' => $serviceDataProvider->pagination,
    )); ?>
</div>