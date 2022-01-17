<table>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold">Plate #</th>
            <th style="text-align: center; font-weight: bold">Car Make</th>
            <th style="text-align: center; font-weight: bold">Car Model</th>
            <th style="text-align: center; font-weight: bold">WO #</th>
            <th style="text-align: center; font-weight: bold">WO Date</th>
            <th style="text-align: center; font-weight: bold">Problem</th>
            <th style="text-align: center; font-weight: bold">Insurance</th>
            <th style="text-align: center; font-weight: bold">Branch</th>
            <th style="text-align: center; font-weight: bold">Priority</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($waitlistDataProvider->data as $data): ?>
            <tr>
                <?php $vehicle = $data->vehicle; ?>
                <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                <td><?php echo CHtml::link($data->work_order_number, array("/frontDesk/generalRepairMechanic/viewDetailWorkOrder", "registrationId"=>$data->id), array('target' => 'blank')); ?></td>
                <td><?php echo $data->work_order_date; ?></td>
                <td><?php echo $data->problem; ?></td>
                <td><?php echo $data->insurance_company_id != null ? $data->insuranceCompany->name : ' '; ?></td>
                <td><?php echo $data->branch_id != null ? $data->branch->code : '-'; ?></td>
                <td><?php echo $data->getPriorityLiteral($data->priority_level); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>