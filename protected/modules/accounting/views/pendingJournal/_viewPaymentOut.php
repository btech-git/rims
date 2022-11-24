<div style="text-align: right">
    <?php echo ReportHelper::summaryText($paymentOutDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>Payment Out #</td>
            <td>Date</td>
            <td>Supplier</td>
            <td>Branch</td>
            <td>Status</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($paymentOutDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['payment_number']), array("/transaction/paymentOut/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['payment_date']); ?></td>
                <td><?php echo CHtml::encode($data['supplier_name']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>