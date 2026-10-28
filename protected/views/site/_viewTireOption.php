<div class="row">
    <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
        <table>
            <thead>
                <tr>
                    <td>Section Width</td>
                    <td>Aspect Ratio</td>
                    <td>Construction Type</td>
                    <td>Rim Diameter</td>
                    <td>Load Rating</td>
                    <td>Speed Rating</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::activeTextField($tireSize, 'section_width', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireOptionTable'),
                                'update' => '#tire_option_table',
                            )),
                        )); ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeTextField($tireSize, 'aspect_ratio', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireOptionTable'),
                                'update' => '#tire_option_table',
                            )),
                        )); ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeTextField($tireSize, 'construction_type', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireOptionTable'),
                                'update' => '#tire_option_table',
                            )),
                        )); ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeTextField($tireSize, 'rim_diameter', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireOptionTable'),
                                'update' => '#tire_option_table',
                            )),
                        )); ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeTextField($tireSize, 'load_rating', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireOptionTable'),
                                'update' => '#tire_option_table',
                            )),
                        )); ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeTextField($tireSize, 'speed_rating', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTireOptionTable'),
                                'update' => '#tire_option_table',
                            )),
                        )); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="clear"></div>

        <div class="row buttons" style="text-align: center">
            <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
            <?php echo CHtml::submitButton('Export Excel', array('name' => 'ExportProductExcel'));  ?>
        </div>

        <hr />

        <div id="tire_option_table">
            <?php $this->renderPartial('_tireOptionTable', array(
                'tireSizeDataProvider' => $tireSizeDataProvider,
            )); ?>
        </div>
    </div>
</div>