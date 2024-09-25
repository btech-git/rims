<?php if (count($bodyRepair->damageDetails) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Damage</th>
                <th>Description</th>
                <th>Hour</th>
                <th>Product</th>
                <th>Waiting Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bodyRepair->damageDetails as $i => $damageDetail): ?>
                <tr>
                    <td> <?php echo CHtml::activeHiddenField($damageDetail, "[$i]service_id", array('size' => 20, 'maxlength' => 20)); ?>
                        <?php $product = Product::model()->findByPk($damageDetail->service_id); ?>
                        <?php
                        echo CHtml::activeTextField($damageDetail, "[$i]service_name",
                                array(
                                    'size' => 15,
                                    'maxlength' => 10,
                                    'readonly' => true,
                                    'value' => $damageDetail->service_id == "" ? '' : $damageDetail->service->name
                        ));
                        ?>

                        <?php
                        echo CHtml::button('add to Service', array(
                            'id' => 'service-add-' . $i . '-button',
                            'name' => 'ServiceDetailAdd',
                            'class' => 'button',
                            'onclick' => '
                            var serviceId = $("#RegistrationDamage_' . $i . '_service_id").val();
                            var damageType = $("#RegistrationDamage_' . $i . '_damage_type").val();
                            $.ajax({
                            type: "POST",
                            //dataType: "JSON",
                            url: "' . CController::createUrl('ajaxHtmlAddServiceInsuranceDetail', array('id' => $bodyRepair->header->id)) . '&serviceId="+serviceId+"&insuranceId="+ $("#RegistrationTransaction_insurance_company_id").val()+"&damageType="+ damageType+"&repair="+ $("#RegistrationTransaction_repair_type").val(),
                            data:$("form").serialize(),
                            success: function(html) {
                                $("#service").html(html);
                            },
                        });'
                        ));
                        ?>
                    </td>
                    <td><?php echo CHtml::activeDropDownList($damageDetail, "[$i]damage_type", array('Easy' => "Easy", 'Medium' => 'Medium', 'Hard' => 'Hard'), array('prompt' => '[--Select Damage Type--]')); ?></td>
                    <td><?php echo CHtml::activeTextArea($damageDetail, "[$i]description") ?></td>

                    <td><?php echo CHtml::activeTextField($damageDetail, "[$i]hour", array('readonly' => 'true')); ?></td>
                    <td>
                        <?php
                        if ($damageDetail->service_id != "") {
                            $first = true;
                            $rec = "";

                            $materials = ServiceMaterial::model()->findAllByAttributes(array('service_id' => $damageDetail->service_id));
                            //echo count($materials);
                            foreach ($materials as $material) {
                                $product = Product::model()->findByPk($material->product_id);
                                if ($first === true) {
                                    $first = false;
                                } else {
                                    $rec .= ', ';
                                }
                                $rec .= $product->name;
                            }
                            //echo $rec;
                        }
                        ?>
                        <?php //echo $damageDetail->service_id; ?>
        <?php echo CHtml::activeTextArea($damageDetail, "[$i]products", array('readonly' => 'true', 'value' => isset($damageDetail->service_id) ? $rec : '')); ?>
                    </td>
                    <td><?php echo CHtml::activeTextField($damageDetail, "[$i]waiting_time"); ?>Hour</td>
                    <td>
                        <?php
                        echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDamageDetail', array('id' => $bodyRepair->header->id, 'index' => $i)),
                                'update' => '#damage',
                            )),
                        ));
                        ?>
                    </td>
                </tr>
    <?php endforeach ?>
        </tbody>
    </table>
    <?php
 endif ?>
