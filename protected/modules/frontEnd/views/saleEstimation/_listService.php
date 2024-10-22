<?php echo CHtml::beginForm(); ?>
    <div class="row">
        <h2>List Jasa</h2>
        <div class="col">
            <div class="my-2 row">
                <label class="col col-form-label">Jasa</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($service, 'name', array(
                        'class' => 'form-select',
                        'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                                'update' => '#service_data_container',
                            )),
                    )); ?>
                </div>
                <label class="col col-form-label">Kode</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($service, 'code', array(
                        'class' => 'form-select',
                        'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateServiceDataTable'),
                                'update' => '#service_data_container',
                            )),
                    )); ?>
                </div>
            </div>
            <div class="my-2 row">
                <label class="col col-form-label">Kategori</label>
                <div class="col">
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
                </div>
                <label class="col col-form-label">Tipe</label>
                <div class="col">
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
                </div>
            </div>
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