<?php $detailsCount = count($vehicleSystemCheckTireDetails); ?>
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
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'productIdFrontLeftBeforeService.tireSize.tireName')); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'productIdFrontLeftAfterService.tireSize.tireName')); ?>
            </div>
            <?php for ($i = 0; $i < $detailsCount; $i++): ?>
                <?php $detail = $vehicleSystemCheckTireDetails[$i]; ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::encode(CHtml::value($detail, 'front_left_before_service')); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::encode(CHtml::value($detail, 'front_left_after_service')); ?></div>
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
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'productIdFrontRightBeforeService.tireSize.tireName')); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'productIdFrontRightAfterService.tireSize.tireName')); ?>
            </div>
            <?php for ($i = 0; $i < $detailsCount; $i++): ?>
                <?php $detail = $vehicleSystemCheckTireDetails[$i]; ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::encode(CHtml::value($detail, 'front_right_before_service')); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::encode(CHtml::value($detail, 'front_right_after_service')); ?></div>
            <?php endfor; ?>
        </div>
    </div>
    
    <hr />
    
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <div style="font-size: larger; font-weight: bold">Ban kiri belakang</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'productIdRearLeftBeforeService.tireSize.tireName')); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'productIdRearLeftAfterService.tireSize.tireName')); ?>
            </div>
            <?php for ($i = 0; $i < $detailsCount; $i++): ?>
                <?php $detail = $vehicleSystemCheckTireDetails[$i]; ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::encode(CHtml::value($detail, 'rear_left_before_service')); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::encode(CHtml::value($detail, 'rear_left_after_service')); ?></div>
            <?php endfor; ?>
        </div>
        <div style="display: table-cell; width: 50%">
            <div style="font-size: larger; font-weight: bold">Ban kanan belakang</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'productIdRearRightBeforeService.tireSize.tireName')); ?>
            </div>
            <div style="display: inline-block; width: 30%">
                <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'productIdRearRightAfterService.tireSize.tireName')); ?>
            </div>
            <?php for ($i = 0; $i < $detailsCount; $i++): ?>
                <?php $detail = $vehicleSystemCheckTireDetails[$i]; ?>
                <div style="display: inline-block; width: 30%">
                    <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
                </div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::encode(CHtml::value($detail, 'rear_right_before_service')); ?></div>
                <div style="display: inline-block; width: 30%"><?php echo CHtml::encode(CHtml::value($detail, 'rear_right_after_service')); ?></div>
            <?php endfor; ?>
        </div>
    </div>
</div>