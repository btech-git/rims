<?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
            <table>
                <thead>
                    <tr>
                        <td>Jasa</td>
                        <td>Kode</td>
                        <td>Kategori</td>
                        <td>Tipe</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo CHtml::activeTextField($service, 'name', array(
                                'class' => 'form-select',
                                'onchange' => 
                                    CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                                        'update' => '#service_data_container',
                                    )),
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($service, 'code', array(
                                'class' => 'form-select',
                                'onchange' => 
                                    CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                                        'update' => '#service_data_container',
                                    )),
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($service, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'class' => 'form-select',
                                'onchange' => 
                                    CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                                        'update' => '#service_data_container',
                                    )),
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($service, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'class' => 'form-select',
                                'onchange' => 
                                    CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                                        'update' => '#service_data_container',
                                    )),
                            )); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter', 'class' => 'btn btn-danger'));  ?>
    </div>

    <hr />

    <div id="service_data_container">
        <?php $this->renderPartial('_serviceDataTable', array(
            'serviceDataProvider' => $serviceDataProvider,
        )); ?>
    </div>
<?php echo CHtml::endForm(); ?>