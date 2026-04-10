<?php $detailsCount = count($vehicleSystemCheck->detailTires); ?>
<div style="display: table; width: 100%; background-color: azure">
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(2); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red"><?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?></div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%">Tipe Accu</div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'accu_type_before_service'); ?>
                <?php echo CHtml::error($vehicleSystemCheck->header, 'accu_type_before_service'); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'accu_type_after_service'); ?>
                <?php echo CHtml::error($vehicleSystemCheck->header, 'accu_type_after_service'); ?>
            </div>
            <?php foreach ($vehicleSystemCheck->detailComponents[2] as $i => $detail): ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[2][$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeDropDownlist($detail, "[2][$i]component_condition_before_service", array(1 => 'OK', 2 => 'Not OK')); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[2][$i]component_condition_after_service"); ?></div>
            <?php endforeach; ?>
        </div>
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(5); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red"><?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?></div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'undercarriage_condition_after_service'); ?>
                <?php echo CHtml::error($vehicleSystemCheck->header, 'undercarriage_condition_after_service'); ?>
            </div>
            <?php foreach ($vehicleSystemCheck->detailComponents[5] as $i => $detail): ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[5][$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeDropDownlist($detail, "[5][$i]component_condition_before_service", array(1 => 'OK', 2 => 'Not OK')); ?></div>
                <div style="display: inline-block; width: 30%; visibility: hidden"><?php echo CHtml::activeTextField($detail, "[5][$i]component_condition_after_service"); ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(3); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red"><?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?></div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'electrical_condition_after_service'); ?>
                <?php echo CHtml::error($vehicleSystemCheck->header, 'electrical_condition_after_service'); ?>
            </div>
            <?php foreach ($vehicleSystemCheck->detailComponents[3] as $i => $detail): ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[3][$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeDropDownlist($detail, "[3][$i]component_condition_before_service", array(1 => 'OK', 2 => 'Not OK')); ?></div>
                <div style="display: inline-block; width: 30%; visibility: hidden"><?php echo CHtml::activeTextField($detail, "[3][$i]component_condition_after_service"); ?></div>
            <?php endforeach; ?>
        </div>
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(6); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red"><?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?></div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'underhood_condition_after_service'); ?>
                <?php echo CHtml::error($vehicleSystemCheck->header, 'underhood_condition_after_service'); ?>
            </div>
            <?php foreach ($vehicleSystemCheck->detailComponents[6] as $i => $detail): ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[6][$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeDropDownlist($detail, "[6][$i]component_condition_before_service", array(1 => 'OK', 2 => 'Not OK')); ?></div>
                <div style="display: inline-block; width: 30%; visibility: hidden"><?php echo CHtml::activeTextField($detail, "[6][$i]component_condition_after_service"); ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(4); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red"><?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?></div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <?php foreach ($vehicleSystemCheck->detailComponents[4] as $i => $detail): ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[4][$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeDropDownlist($detail, "[4][$i]component_condition_before_service", array(1 => 'OK', 2 => 'Not OK')); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[4][$i]component_condition_after_service"); ?></div>
            <?php endforeach; ?>
        </div>
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(7); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red"><?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?></div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <?php foreach ($vehicleSystemCheck->detailComponents[7] as $i => $detail): ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::activeHiddenField($detail, "[7][$i]component_inspection_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeDropDownlist($detail, "[7][$i]component_condition_before_service", array(1 => 'OK', 2 => 'Not OK')); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::activeTextField($detail, "[7][$i]component_condition_after_service"); ?></div>
            <?php endforeach; ?>
            <div style="display: inline-block; width: 30%">Penjelasan Underhood</div>
            <div style="display: inline-block; width: 60%">
                <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'underhood_note'); ?>
                <?php echo CHtml::error($vehicleSystemCheck->header, 'underhood_note'); ?>
            </div>
        </div>
    </div>
</div>

<?php /*
<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Component</th>
        <th style="text-align: center">Group</th>
        <th style="text-align: center">Sebelum</th>
        <th style="text-align: center">Sesudah</th>
    </tr>
    <?php foreach ($vehicleSystemCheck->detailComponents as $i => $detail): ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
            </td>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_group_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.componentInspectionGroup.name')); ?>
            </td>
            <td style="width: 15%"><?php echo CHtml::activeDropDownlist($detail, "[$i]component_condition_before_service", array(1 => 'OK', 2 => 'Not OK')); ?></td>
            <td style="width: 15%"><?php echo CHtml::activeTextField($detail, "[$i]component_condition_after_service"); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
*/ ?>