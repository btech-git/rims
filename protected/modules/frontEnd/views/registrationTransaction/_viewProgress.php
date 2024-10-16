<table>
    <thead>
        <tr>
            <th>Service name</th>
            <th>Total Time</th>
            <th>Mechanic</th>
            <th>Quality Check</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($registrationBodyRepairDetails) > 0): ?>
            <?php foreach ($registrationBodyRepairDetails as $i => $registrationBodyRepairDetail): ?>
                <tr>
                    <td><?php echo $registrationBodyRepairDetail->service_name; ?></td>
                    <td><?php echo $registrationBodyRepairDetail->total_time; ?></td>
                    <td><?php echo empty($registrationBodyRepairDetail->mechanic_id) ? '' : $registrationBodyRepairDetail->mechanic->name; ?></td>
                    <td><?php echo ($registrationBodyRepairDetail->to_be_checked == 0) ? '' : $registrationBodyRepairDetail->qualityControlStatus; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
