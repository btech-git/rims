<div class="clearfix page-action" id="service-type-processing-<?php echo $serviceType->id; ?>">
    <div>
        <table>
            <tr>
                <td><?php echo CHtml::link('Queue', '#', array('class' => 'status-link', 'data-status-type' => 'queue', 'data-processing-id' => $serviceType->id)); ?></td>
                <td><?php echo CHtml::link('Assigned', '#', array('class' => 'status-link', 'data-status-type' => 'assigned', 'data-processing-id' => $serviceType->id)); ?></td>
                <td><?php echo CHtml::link('On - Progress', '#', array('class' => 'status-link', 'data-status-type' => 'on-progress', 'data-processing-id' => $serviceType->id)); ?></td>
                <td><?php echo CHtml::link('Ready to QC', '#', array('class' => 'status-link', 'data-status-type' => 'ready-to-qc', 'data-processing-id' => $serviceType->id)); ?></td>
                <td><?php echo CHtml::link('Finished', '#', array('class' => 'status-link', 'data-status-type' => 'finished', 'data-processing-id' => $serviceType->id)); ?></td>
            </tr>
        </table>
    </div>
    <div class="status-<?php echo $serviceType->id; ?>" id="status-<?php echo $serviceType->id; ?>-queue" style="display: none">
        <?php $numbering = 1; ?>
        <h3>Queue</h3>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center; font-weight: bold">No.</th>
                    <th style="text-align: center; font-weight: bold">Customer</th>
                    <th style="text-align: center; font-weight: bold">Plate #</th>
                    <th style="text-align: center; font-weight: bold">Car Make</th>
                    <th style="text-align: center; font-weight: bold">Car Model</th>
                    <th style="text-align: center; font-weight: bold">WO #</th>
                    <th style="text-align: center; font-weight: bold">WO Date</th>
                    <th style="text-align: center; font-weight: bold">WO Time</th>
                    <th style="text-align: center; font-weight: bold">Service</th>
                    <th style="text-align: center; font-weight: bold">WO Status</th>
                    <th style="text-align: center; font-weight: bold">Branch</th>
                    <th style="text-align: center; font-weight: bold">Priority</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($registrationServiceManagementQueue as $row): ?>
                    <?php if ($row['service_type_id'] === $serviceType->id): ?>
                        <tr>
                            <td><?php echo $numbering; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['plate_number']; ?></td>
                            <td><?php echo $row['car_make']; ?></td>
                            <td><?php echo $row['car_model']; ?></td>
                            <td><?php echo CHtml::link($row['work_order_number'], array("/frontDesk/generalRepairManagement/viewDetailWorkOrder", "registrationId"=>$row['registration_transaction_id']), array('target' => 'blank')); ?></td>
                            <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $row['work_order_date']); ?></td>
                            <td><?php echo date("H:i:s", strtotime($row['transaction_date'])); ?></td>
                            <td><?php echo implode(', ', $serviceNames[$row['registration_transaction_id'] . ':' . $row['service_type_id']]); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['branch']; ?></td>
                            <td><?php echo $row['priority_level']; ?></td>
                            <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Mechanic', Yii::app()->createUrl("frontDesk/generalRepairManagement/assignMechanic", array("id"=>$row['service_management_id'])), array('class' => 'button warning', 'target' => '_blank')); ?></td>
                        </tr>
                        <?php $numbering++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="status-<?php echo $serviceType->id; ?>" id="status-<?php echo $serviceType->id; ?>-assigned" style="display: none">
        <h3>Assigned</h3>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center; font-weight: bold">No.</th>
                    <th style="text-align: center; font-weight: bold">Customer</th>
                    <th style="text-align: center; font-weight: bold">Plate #</th>
                    <th style="text-align: center; font-weight: bold">Car Make</th>
                    <th style="text-align: center; font-weight: bold">Car Model</th>
                    <th style="text-align: center; font-weight: bold">WO #</th>
                    <th style="text-align: center; font-weight: bold">WO Date</th>
                    <th style="text-align: center; font-weight: bold">WO Time</th>
                    <th style="text-align: center; font-weight: bold">Service</th>
                    <th style="text-align: center; font-weight: bold">WO Status</th>
                    <th style="text-align: center; font-weight: bold">Branch</th>
                    <th style="text-align: center; font-weight: bold">Priority</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($registrationServiceManagementAssigned as $row): ?>
                    <?php if ($row['service_type_id'] === $serviceType->id): ?>
                        <tr>
                            <td><?php echo $numbering; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['plate_number']; ?></td>
                            <td><?php echo $row['car_make']; ?></td>
                            <td><?php echo $row['car_model']; ?></td>
                            <td><?php echo CHtml::link($row['work_order_number'], array("/frontDesk/registrationTransaction/view", "id"=>$row['registration_transaction_id']), array('target' => 'blank')); ?></td>
                            <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $row['work_order_date']); ?></td>
                            <td><?php echo date("H:i:s", strtotime($row['transaction_date'])); ?></td>
                            <td><?php echo implode(', ', $serviceNames[$row['registration_transaction_id'] . ':' . $row['service_type_id']]); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['branch']; ?></td>
                            <td><?php echo $row['priority_level']; ?></td>
                            <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Processing', Yii::app()->createUrl("frontDesk/generalRepairManagement/startProcessing", array("id"=>$row['service_management_id'])), array('class' => 'button success')); ?></td>
                        </tr>
                        <?php $numbering++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="status-<?php echo $serviceType->id; ?>" id="status-<?php echo $serviceType->id; ?>-on-progress" style="display: none">
        <h3>On-Progress</h3>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center; font-weight: bold">No.</th>
                    <th style="text-align: center; font-weight: bold">Customer</th>
                    <th style="text-align: center; font-weight: bold">Plate #</th>
                    <th style="text-align: center; font-weight: bold">Car Make</th>
                    <th style="text-align: center; font-weight: bold">Car Model</th>
                    <th style="text-align: center; font-weight: bold">WO #</th>
                    <th style="text-align: center; font-weight: bold">WO Date</th>
                    <th style="text-align: center; font-weight: bold">WO Time</th>
                    <th style="text-align: center; font-weight: bold">Service</th>
                    <th style="text-align: center; font-weight: bold">WO Status</th>
                    <th style="text-align: center; font-weight: bold">Branch</th>
                    <th style="text-align: center; font-weight: bold">Priority</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($registrationServiceManagementProgress as $row): ?>
                    <?php if ($row['service_type_id'] === $serviceType->id): ?>
                        <tr>
                            <td><?php echo $numbering; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['plate_number']; ?></td>
                            <td><?php echo $row['car_make']; ?></td>
                            <td><?php echo $row['car_model']; ?></td>
                            <td><?php echo CHtml::link($row['work_order_number'], array("/frontDesk/registrationTransaction/view", "id"=>$row['registration_transaction_id']), array('target' => 'blank')); ?></td>
                            <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $row['work_order_date']); ?></td>
                            <td><?php echo date("H:i:s", strtotime($row['transaction_date'])); ?></td>
                            <td><?php echo implode(', ', $serviceNames[$row['registration_transaction_id'] . ':' . $row['service_type_id']]); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['branch']; ?></td>
                            <td><?php echo $row['priority_level']; ?></td>
                            <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>QC', Yii::app()->createUrl("frontDesk/generalRepairManagement/proceedToQualityControl", array("id"=>$row['service_management_id'])), array('class' => 'button success')); ?></td>
                        </tr>
                        <?php $numbering++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="status-<?php echo $serviceType->id; ?>" id="status-<?php echo $serviceType->id; ?>-ready-to-qc" style="display: none">
        <h3>Ready to QC</h3>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center; font-weight: bold">No.</th>
                    <th style="text-align: center; font-weight: bold">Customer</th>
                    <th style="text-align: center; font-weight: bold">Plate #</th>
                    <th style="text-align: center; font-weight: bold">Car Make</th>
                    <th style="text-align: center; font-weight: bold">Car Model</th>
                    <th style="text-align: center; font-weight: bold">WO #</th>
                    <th style="text-align: center; font-weight: bold">WO Date</th>
                    <th style="text-align: center; font-weight: bold">WO Time</th>
                    <th style="text-align: center; font-weight: bold">Service</th>
                    <th style="text-align: center; font-weight: bold">WO Status</th>
                    <th style="text-align: center; font-weight: bold">Branch</th>
                    <th style="text-align: center; font-weight: bold">Priority</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($registrationServiceManagementControl as $row): ?>
                    <?php if ($row['service_type_id'] === $serviceType->id): ?>
                        <tr>
                            <td><?php echo $numbering; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['plate_number']; ?></td>
                            <td><?php echo $row['car_make']; ?></td>
                            <td><?php echo $row['car_model']; ?></td>
                            <td><?php echo CHtml::link($row['work_order_number'], array("/frontDesk/registrationTransaction/view", "id"=>$row['registration_transaction_id']), array('target' => 'blank')); ?></td>
                            <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $row['work_order_date']); ?></td>
                            <td><?php echo date("H:i:s", strtotime($row['transaction_date'])); ?></td>
                            <td><?php echo implode(', ', $serviceNames[$row['registration_transaction_id'] . ':' . $row['service_type_id']]); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['branch']; ?></td>
                            <td><?php echo $row['priority_level']; ?></td>
                            <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Pass/Fail', Yii::app()->createUrl("frontDesk/generalRepairManagement/checkQuality", array("id"=>$row['service_management_id'])), array('class' => 'button success')); ?></td>
                        </tr>
                        <?php $numbering++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="status-<?php echo $serviceType->id; ?>" id="status-<?php echo $serviceType->id; ?>-finished" style="display: none">
        <h3>Finished</h3>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center; font-weight: bold">No.</th>
                    <th style="text-align: center; font-weight: bold">Customer</th>
                    <th style="text-align: center; font-weight: bold">Plate #</th>
                    <th style="text-align: center; font-weight: bold">Car Make</th>
                    <th style="text-align: center; font-weight: bold">Car Model</th>
                    <th style="text-align: center; font-weight: bold">WO #</th>
                    <th style="text-align: center; font-weight: bold">WO Date</th>
                    <th style="text-align: center; font-weight: bold">WO Time</th>
                    <th style="text-align: center; font-weight: bold">Service</th>
                    <th style="text-align: center; font-weight: bold">WO Status</th>
                    <th style="text-align: center; font-weight: bold">Branch</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($registrationServiceManagementFinished as $row): ?>
                    <?php if ($row['service_type_id'] === $serviceType->id): ?>
                        <tr>
                            <td><?php echo $numbering; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['plate_number']; ?></td>
                            <td><?php echo $row['car_make']; ?></td>
                            <td><?php echo $row['car_model']; ?></td>
                            <td><?php echo CHtml::link($row['work_order_number'], array("/frontDesk/registrationTransaction/view", "id"=>$row['registration_transaction_id']), array('target' => 'blank')); ?></td>
                            <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $row['work_order_date']); ?></td>
                            <td><?php echo date("H:i:s", strtotime($row['transaction_date'])); ?></td>
                            <td><?php echo implode(', ', $serviceNames[$row['registration_transaction_id'] . ':' . $row['service_type_id']]); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['branch']; ?></td>
                        </tr>
                        <?php $numbering++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
