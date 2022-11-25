<div style="text-align: center; text-decoration: underline">
    <h2><?php echo 'Pending Journal Receive Item'; ?></h2>
</div>

<div style="text-align: right">
    <?php echo ReportHelper::summaryText($receiveItemDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>Receive #</td>
            <td>Date</td>
            <td>Supplier</td>
            <td>Branch</td>
            <td>Type</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($receiveItemDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['receive_item_no']), array("/transaction/transactionReceiveItem/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['receive_item_date']); ?></td>
                <td><?php echo CHtml::encode($data['supplier_name']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['request_type']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>