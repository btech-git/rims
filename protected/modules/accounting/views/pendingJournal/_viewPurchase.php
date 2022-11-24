<div style="text-align: right">
    <?php echo ReportHelper::summaryText($purchaseOrderDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>PO#</td>
            <td>Date</td>
            <td>Supplier</td>
            <td>Branch</td>
            <td>Payment Status</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($purchaseOrderDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['purchase_order_no']), array("/transaction/transactionPurchaseOrder/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['purchase_order_date']); ?></td>
                <td><?php echo CHtml::encode($data['supplier_name']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['payment_status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>