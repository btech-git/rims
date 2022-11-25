<div style="text-align: center; text-decoration: underline">
    <h2><?php echo 'Pending Journal Delivery'; ?></h2>
</div>

<div style="text-align: right">
    <?php echo ReportHelper::summaryText($deliveryOrderDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>Delivery #</td>
            <td>Date</td>
            <td>Branch</td>
            <td>Type</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($deliveryOrderDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['delivery_order_no']), array("/transaction/transactionDeliveryOrder/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['delivery_date']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['request_type']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>