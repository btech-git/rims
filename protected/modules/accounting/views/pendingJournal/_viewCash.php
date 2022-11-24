<div style="text-align: right">
    <?php echo ReportHelper::summaryText($cashTransactionDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>Cash Transaction #</td>
            <td>Date</td>
            <td>Type</td>
            <td>Branch</td>
            <td>Status</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($cashTransactionDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['transaction_number']), array("/transaction/cashTransaction/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['transaction_date']); ?></td>
                <td><?php echo CHtml::encode($data['transaction_type']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>