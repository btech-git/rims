<div style="text-align: center; text-decoration: underline">
    <h2><?php echo 'Pending Journal Movement Out'; ?></h2>
</div>

<div style="text-align: right">
    <?php echo ReportHelper::summaryText($movementOutDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>Movement Out #</td>
            <td>Date</td>
            <td>Branch</td>
            <td>Status</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($movementOutDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['movement_out_no']), array("/transaction/movementOutHeader/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['date_posting']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>