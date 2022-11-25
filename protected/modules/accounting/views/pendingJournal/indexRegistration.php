<div style="text-align: center; text-decoration: underline">
    <h2><?php echo 'Pending Journal Registration Transaction'; ?></h2>
</div>

<div style="text-align: right">
    <?php echo ReportHelper::summaryText($registrationTransactionDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>Registration #</td>
            <td>Date</td>
            <td>Customer</td>
            <td>Branch</td>
            <td>Type</td>
            <td>Status</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($registrationTransactionDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['transaction_number']), array("/frontDesk/generalRepairRegistration/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['transaction_date']); ?></td>
                <td><?php echo CHtml::encode($data['customer_name']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['repair_type']); ?></td>
                <td><?php echo CHtml::encode($data['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>