<div style="text-align: right">
    <?php echo ReportHelper::summaryText($movementInDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <td>Movement In #</td>
            <td>Date</td>
            <td>Branch</td>
            <td>Status</td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($movementInDataProvider->data as $data): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($data['movement_in_number']), array("/transaction/movementInHeader/view", "id"=>$data['id']), array('target' => 'blank', 'class' => 'link')); ?></td>
                <td><?php echo CHtml::encode($data['date_posting']); ?></td>
                <td><?php echo CHtml::encode($data['branch_name']); ?></td>
                <td><?php echo CHtml::encode($data['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>