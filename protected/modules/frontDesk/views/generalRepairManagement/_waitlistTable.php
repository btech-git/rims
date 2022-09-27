<table>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold">Customer</th>
            <th style="text-align: center; font-weight: bold">Plate #</th>
            <th style="text-align: center; font-weight: bold">Car Make</th>
            <th style="text-align: center; font-weight: bold">Car Model</th>
            <th style="text-align: center; font-weight: bold">WO #</th>
            <th style="text-align: center; font-weight: bold">WO Date</th>
            <th style="text-align: center; font-weight: bold">Problem</th>
            <!--<th style="text-align: center; font-weight: bold">Insurance</th>-->
            <th style="text-align: center; font-weight: bold">Branch</th>
            <th style="text-align: center; font-weight: bold">Priority</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($waitlistDataProvider->data as $model): ?>
            <tr>
                <?php $vehicle = $model->vehicle; ?>
                <td><?php echo $model->customer->name; ?></td>
                <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                <td><?php echo CHtml::link($model->work_order_number, array("/frontDesk/generalRepairManagement/viewDetailWorkOrder", "registrationId"=>$model->id), array('target' => 'blank')); ?></td>
                <td><?php echo $model->work_order_date; ?></td>
                <td><?php echo $model->problem; ?></td>
                <!--<td><?php //echo $model->insurance_company_id != null ? $model->insuranceCompany->name : ' '; ?></td>-->
                <td><?php echo $model->branch_id != null ? $model->branch->code : '-'; ?></td>
                <td><?php echo $model->getPriorityLiteral($model->priority_level); ?></td>
                <td><?php echo CHtml::link('<span class="fa fa-angle-right"></span>Process to Queue', Yii::app()->createUrl("frontDesk/generalRepairManagement/proceedToQueue", array("id"=>$model->id)), array('class' => 'button secondary')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>