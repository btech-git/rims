<div class="row">
    <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
        <table>
            <thead>
                <tr>
                    <td>Brand</td>
                    <td>Sub Brand</td>
                    <td>Sub Brand Series</td>
                    <td>ID</td>
                    <td>Code</td>
                    <td>Name</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                                'update' => '#product_sub_brand',
                            )) . 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>

                    <td>
                        <div id="product_sub_brand">
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                                    'update' => '#product_sub_brand_series',
                                )) . 
                                CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                    'update' => '#tire_stock_table',
                                )),
                            )); ?>
                        </div>
                    </td>

                    <td>
                        <div id="product_sub_brand_series">
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                    'update' => '#tire_stock_table',
                                )),
                            )); ?>
                        </div>
                    </td>

                    <td>
                        <?php echo CHtml::activeTextField($product, 'id', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeTextField($product, 'name', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <td>Section Width</td>
                    <td>Aspect Ratio</td>
                    <td>Construction Type</td>
                    <td>Rim Diameter</td>
                    <td>Load Rating</td>
                    <td>Speed Rating</td>
                    <td>DOT</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::textField('SectionWidth', $sectionWidth, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField('AspectRatio', $aspectRatio, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField('ConstructionType', $constructionType, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField('RimDiameter', $rimDiameter, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField('LoadRating', $loadRating, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField('SpeedRating', $speedRating, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::dropDownList('ProductionYear', $productionYear, $yearList, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
                                'update' => '#tire_stock_table',
                            )),
                        )); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="clear"></div>

        <div class="row buttons" style="text-align: center">
            <?php echo CHtml::submitButton('Clear', array('name' => 'ResetFilter'));  ?>
            <?php //echo CHtml::submitButton('Export Excel', array('name' => 'ExportProductExcel'));  ?>
        </div>

        <hr />

        <div id="tire_stock_table">
            <?php $this->renderPartial('_tireStockTable', array(
                'tireDataProvider' => $tireDataProvider,
                'branches' => $branches,
                'endDate' => $endDate,
                'productionYear' => $productionYear,
            )); ?>
        </div>
    </div>
</div>