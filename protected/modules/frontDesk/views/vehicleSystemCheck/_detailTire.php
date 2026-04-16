<?php $detailsCount = count($vehicleSystemCheck->detailTires); ?>
<div style="width: 97%; font-size: larger; font-weight: bold; background-color: blue; color: white; padding: 4px 8px">Ban</div>
<div style="display: table; width: 100%; background-color: azure">
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <div style="font-size: larger; font-weight: bold">Ban kiri depan</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'product_id_front_left_before_service', array(
                    'readonly' => true,
                    'onclick' => '$("#ProductMode").val(1); $("#product-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#ProductMode").val(1);  $("#product-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'product_id_front_left_before_service_span')); ?>
                &nbsp;
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'productIdFrontLeftBeforeService.tireSize.tireName')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'product_id_front_left_after_service', array(
                    'readonly' => true,
                    'onclick' => '$("#ProductMode").val(2); $("#product-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#ProductMode").val(2);  $("#product-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'product_id_front_left_after_service_span')); ?>
                &nbsp;
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'productIdFrontLeftAfterService.tireSize.tireName')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            <?php for ($i = 0; $i < $detailsCount; $i++): ?>
                <?php $detail = $vehicleSystemCheck->detailTires[$i]; ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[$i]front_left_before_service"); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[$i]front_left_after_service"); ?></div >
            <?php endfor; ?>
        </div>
        <div style="display: table-cell; width: 50%">
            <a href="../materialRequest/_form.php"></a>
            <div style="font-size: larger; font-weight: bold">Ban kanan depan</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'product_id_front_right_before_service', array(
                    'readonly' => true,
                    'onclick' => '$("#ProductMode").val(3); $("#product-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#ProductMode").val(3);  $("#product-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'product_id_front_right_before_service_span')); ?>
                &nbsp;
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'productIdFrontRightBeforeService.tireSize.tireName')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'product_id_front_right_after_service', array(
                    'readonly' => true,
                    'onclick' => '$("#ProductMode").val(4); $("#product-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#ProductMode").val(4);  $("#product-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'product_id_front_right_after_service_span')); ?>
                &nbsp;
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'productIdFrontRightAfterService.tireSize.tireName')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            <?php for ($i = 0; $i < $detailsCount; $i++): ?>
                <?php $detail = $vehicleSystemCheck->detailTires[$i]; ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[$i]front_right_before_service"); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[$i]front_right_after_service"); ?></div >
            <?php endfor; ?>
        </div>
    </div>
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <div style="font-size: larger; font-weight: bold">Ban kiri belakang</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'product_id_rear_left_before_service', array(
                    'readonly' => true,
                    'onclick' => '$("#ProductMode").val(5); $("#product-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#ProductMode").val(5);  $("#product-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'product_id_rear_left_before_service_span')); ?>
                &nbsp;
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'productIdRearLeftBeforeService.tireSize.tireName')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'product_id_rear_left_after_service', array(
                    'readonly' => true,
                    'onclick' => '$("#ProductMode").val(6); $("#product-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#ProductMode").val(6);  $("#product-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'product_id_rear_left_after_service_span')); ?>
                &nbsp;
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'productIdRearLeftAfterService.tireSize.tireName')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            <?php for ($i = 0; $i < $detailsCount; $i++): ?>
                <?php $detail = $vehicleSystemCheck->detailTires[$i]; ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[$i]rear_left_before_service"); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[$i]rear_left_after_service"); ?></div >
            <?php endfor; ?>
        </div>
        <div style="display: table-cell; width: 50%">
            <div style="font-size: larger; font-weight: bold">Ban kanan belakang</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'product_id_rear_right_before_service', array(
                    'readonly' => true,
                    'onclick' => '$("#ProductMode").val(7); $("#product-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#ProductMode").val(7);  $("#product-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'product_id_rear_right_before_service_span')); ?>
                &nbsp;
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'productIdRearRightBeforeService.tireSize.tireName')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'product_id_rear_right_after_service', array(
                    'readonly' => true,
                    'onclick' => '$("#ProductMode").val(8); $("#product-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#ProductMode").val(8);  $("#product-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'product_id_rear_right_after_service_span')); ?>
                &nbsp;
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'productIdRearRightAfterService.tireSize.tireName')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            <?php for ($i = 0; $i < $detailsCount; $i++): ?>
                <?php $detail = $vehicleSystemCheck->detailTires[$i]; ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[$i]rear_right_before_service"); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[$i]rear_right_after_service"); ?></div >
            <?php endfor; ?>
        </div>
    </div>
</div>