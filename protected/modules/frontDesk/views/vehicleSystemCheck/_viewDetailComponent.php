<div style="display: table; width: 100%; background-color: azure">
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(2); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red; color: white; padding: 4px 8px">
                <?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?>
            </div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%">Tipe Accu</div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'accu_type_before_service')); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'accu_type_after_service')); ?>
            </div>
            <?php $vehicleSystemCheckComponentDetails = VehicleSystemCheckComponentDetail::model()->findAllByAttributes(array(
                'vehicle_system_check_header_id' => $vehicleSystemCheck->id, 
                'component_inspection_group_id' => $componentInspectionGroup->id,
            )); ?>
            <?php foreach ($vehicleSystemCheckComponentDetails as $i => $detail): ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_before_service')); ?>
                </div>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_after_service')); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(5); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red; color: white; padding: 4px 8px">
                <?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?>
            </div>
            <div style="display: table-cell; width: 50%">
                <div style="display: inline-block; width: 49%"></div>
                <div style="display: inline-block; width: 49%">Sebelum service</div>
                <?php $vehicleSystemCheckComponentDetails = VehicleSystemCheckComponentDetail::model()->findAllByAttributes(array(
                    'vehicle_system_check_header_id' => $vehicleSystemCheck->id, 
                    'component_inspection_group_id' => $componentInspectionGroup->id,
                )); ?>
                <?php foreach ($vehicleSystemCheckComponentDetails as $i => $detail): ?>
                    <div style="display: inline-block; width: 49%">
                        <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                    </div>
                    <div style="display: inline-block; width: 49%">
                        <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_before_service')); ?>
                    </div>
                    <div style="display: inline-block; width: 49%; display: none">
                        <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_after_service')); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="display: table-cell; width: 49%">
                <div style="display: inline-block; width: 99%">Setelah service</div>
                <div style="display: inline-block; width: 81%">
                    <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'undercarriage_condition_after_service')); ?>
                </div>
            </div>
        </div>
    </div>
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(3); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red; color: white; padding: 4px 8px">
                <?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?>
            </div>
            <div style="display: table-cell; width: 50%">
                <div style="display: inline-block; width: 49%"></div>
                <div style="display: inline-block; width: 49%">Sebelum service</div>
                <?php $vehicleSystemCheckComponentDetails = VehicleSystemCheckComponentDetail::model()->findAllByAttributes(array(
                    'vehicle_system_check_header_id' => $vehicleSystemCheck->id, 
                    'component_inspection_group_id' => $componentInspectionGroup->id,
                )); ?>
                <?php foreach ($vehicleSystemCheckComponentDetails as $i => $detail): ?>
                    <div style="display: inline-block; width: 49%">
                        <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                    </div>
                    <div style="display: inline-block; width: 49%">
                        <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_before_service')); ?>
                    </div>
                    <div style="display: inline-block; width: 49%; display: none">
                        <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_after_service')); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="display: table-cell; width: 49%">
                <div style="display: inline-block; width: 99%">Setelah service</div>
                <div style="display: inline-block; width: 81%">
                    <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'electrical_condition_after_service')); ?>
                </div>
            </div>
        </div>
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(6); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red; color: white; padding: 4px 8px">
                <?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?>
            </div>
            <div style="display: table-cell; width: 50%">
                <div style="display: inline-block; width: 49%"></div>
                <div style="display: inline-block; width: 49%">Sebelum service</div>
                <?php $vehicleSystemCheckComponentDetails = VehicleSystemCheckComponentDetail::model()->findAllByAttributes(array(
                    'vehicle_system_check_header_id' => $vehicleSystemCheck->id, 
                    'component_inspection_group_id' => $componentInspectionGroup->id,
                )); ?>
                <?php foreach ($vehicleSystemCheckComponentDetails as $i => $detail): ?>
                    <div style="display: inline-block; width: 49%">
                        <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                    </div>
                    <div style="display: inline-block; width: 49%">
                        <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_before_service')); ?>
                    </div>
                    <div style="display: inline-block; width: 49%; display: none">
                        <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_after_service')); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="display: table-cell; width: 49%">
                <div style="display: inline-block; width: 99%">Setelah service</div>
                <div style="display: inline-block; width: 81%">
                    <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'underhood_condition_after_service')); ?>
                </div>
            </div>
        </div>
    </div>
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(4); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red; color: white; padding: 4px 8px">
                <?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?>
            </div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <?php $vehicleSystemCheckComponentDetails = VehicleSystemCheckComponentDetail::model()->findAllByAttributes(array(
                'vehicle_system_check_header_id' => $vehicleSystemCheck->id, 
                'component_inspection_group_id' => $componentInspectionGroup->id,
            )); ?>
            <?php foreach ($vehicleSystemCheckComponentDetails as $i => $detail): ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_before_service')); ?>
                </div>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_after_service')); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="display: table-cell; width: 50%">
            <?php $componentInspectionGroup = ComponentInspectionGroup::model()->findByPk(7); ?>
            <div style="width: 92%; font-size: larger; font-weight: bold; background-color: red; color: white; padding: 4px 8px">
                <?php echo CHtml::encode(CHtml::value($componentInspectionGroup, 'name')); ?>
            </div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <?php $vehicleSystemCheckComponentDetails = VehicleSystemCheckComponentDetail::model()->findAllByAttributes(array(
                'vehicle_system_check_header_id' => $vehicleSystemCheck->id, 
                'component_inspection_group_id' => $componentInspectionGroup->id,
            )); ?>
            <?php foreach ($vehicleSystemCheckComponentDetails as $i => $detail): ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_before_service')); ?>
                </div>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'component_condition_after_service')); ?>
                </div>
            <?php endforeach; ?>
            <div style="display: inline-block; width: 90%"></div>
            <div style="display: inline-block; width: 90%"></div>
            <div style="display: inline-block; width: 30%">Penjelasan Underhood</div>
            <div style="display: inline-block; width: 60%">
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'underhood_note')); ?>
            </div>
        </div>
    </div>
</div>