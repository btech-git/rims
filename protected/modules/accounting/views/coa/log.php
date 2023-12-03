<div id="maincontent">
    <h1>Data Log Master COA <?php echo CHtml::encode(CHtml::value($coa, 'name')); ?></h1>

    <br />
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>COA code</th>
                <th>COA name</th>
                <th>Updated Date</th>
                <th>Updated Time</th>
                <th>Updated User</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($coaLog as $data): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'customer_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'coa.code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'coa.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'date_updated')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'time_updated')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'userUpdated.username')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
