<div style="text-align: center; text-decoration: underline">
    <h2><?php echo 'Pending Journal Payment In'; ?></h2>
</div>

<div style="text-align: right">
    <?php echo ReportHelper::summaryText($paymentInDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>Payment In #</td>
            <td>Date</td>
            <td>Customer</td>
            <td>Branch</td>
            <td>Status</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($paymentInDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['payment_number']), array("/transaction/paymentIn/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['payment_date']); ?></td>
                <td><?php echo CHtml::encode($data['customer_name']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>