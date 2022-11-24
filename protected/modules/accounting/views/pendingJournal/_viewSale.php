<div style="text-align: right">
    <?php echo ReportHelper::summaryText($saleOrderDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>SO #</td>
            <td>Date</td>
            <td>Customer</td>
            <td>Branch</td>
            <td>Status</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($saleOrderDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['sale_order_no']), array("/transaction/transactionSalesOrder/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['sale_order_date']); ?></td>
                <td><?php echo CHtml::encode($data['customer_name']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['status_document']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>