<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>List Outstanding  Estimasi</h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php echo CHtml::link('Manage', array("admin"), array('class' => 'btn btn-info btn-sm')); ?>
        </div>
    </div>
</div>

<hr />

<?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="col">
            <div class="my-2 row">
                <label class="col col-form-label">Transaksi #</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($saleEstimationHeader, 'transaction_number', array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateSaleEstimationDataTable'),
                            'update' => '#sale_estimation_data_container',
                        )),
                    )); ?>
                </div>
                <label class="col col-form-label">Tanggal</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($saleEstimationHeader, 'transaction_date', array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateSaleEstimationDataTable'),
                            'update' => '#sale_estimation_data_container',
                        )),
                    )); ?>
                </div>
            </div>
            <div class="my-2 row">
                <label class="col col-form-label">Customer</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($saleEstimationHeader, 'customer_id', array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateSaleEstimationDataTable'),
                            'update' => '#sale_estimation_data_container',
                        )),
                    )); ?>
                </div>
                <label class="col col-form-label">Plat #</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($saleEstimationHeader, 'transaction_date', array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateSaleEstimationDataTable'),
                            'update' => '#sale_estimation_data_container',
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

    <div id="product_data_container">
        <?php $this->renderPartial('_saleEstimationDataTable', array(
            'saleEstimationHeaderDataProvider' => $saleEstimationHeaderDataProvider,
        )); ?>
    </div>
<?php echo CHtml::endForm(); ?>
