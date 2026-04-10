<?php $detailsCount = count($vehicleSystemCheck->detailTires); ?>
<div style="display: table; width: 100%; background-color: azure">
    <div style="display: table-row">
        <div style="display: table-cell; width: 50%">
            <div style="font-size: larger; font-weight: bold">Ban kiri depan</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
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
            <div style="font-size: larger; font-weight: bold">Ban kanan depan</div>
            <div style="display: inline-block; width: 30%"></div>
            <div style="display: inline-block; width: 30%">Sebelum service</div>
            <div style="display: inline-block; width: 30%">Sesudah service</div>
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

<?php /*
<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Component</th>
        <th style="text-align: center">Depan Kiri Sebelum</th>
        <th style="text-align: center">Depan Kiri Sesudah</th>
        <th style="text-align: center">Depan Kanan Sebelum</th>
        <th style="text-align: center">Depan Kanan Sesudah</th>
        <th style="text-align: center">Belakang Kiri Sebelum</th>
        <th style="text-align: center">Belakang Kiri Sesudah</th>
        <th style="text-align: center">Belakang Kanan Sebelum</th>
        <th style="text-align: center">Belakang Kanan Sesudah</th>
    </tr>
    <?php $detailsCount = count($vehicleSystemCheck->detailTires); ?>
    <?php for ($i = 0; $i < $detailsCount; $i++): ?>
        <?php $detail = $vehicleSystemCheck->detailTires[$i]; ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
            </td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]front_left_before_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]front_left_after_service"); ?></td>
        </tr>
    <?php endfor; ?>
    <?php for ($i = 0; $i < $detailsCount; $i++): ?>
        <?php $detail = $vehicleSystemCheck->detailTires[$i]; ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
            </td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]front_right_before_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]front_right_after_service"); ?></td>
        </tr>
    <?php endfor; ?>
    <?php for ($i = 0; $i < $detailsCount; $i++): ?>
        <?php $detail = $vehicleSystemCheck->detailTires[$i]; ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
            </td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]rear_left_before_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]rear_left_after_service"); ?></td>
        </tr>
    <?php endfor; ?>
    <?php for ($i = 0; $i < $detailsCount; $i++): ?>
        <?php $detail = $vehicleSystemCheck->detailTires[$i]; ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
            </td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]rear_right_before_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]rear_right_after_service"); ?></td>
        </tr>
    <?php endfor; ?>
    <?php /*foreach ($vehicleSystemCheck->detailTires as $i => $detail): ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]component_inspection_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'componentInspection.name')); ?>
            </td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]front_left_before_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]front_left_after_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]front_right_before_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]front_right_after_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]rear_left_before_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]rear_left_after_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]rear_right_before_service"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]rear_right_after_service"); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
*/ ?>