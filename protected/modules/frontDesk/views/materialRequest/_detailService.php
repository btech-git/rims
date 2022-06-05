<h2>Service List</h2>

<br />

<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th style="width: 5%">No.</th>
            <th>Service</th>
            <th style="width: 25%">Type</th>
            <th style="width: 15%">Status</th>
        </tr>
    </thead>

    <?php if (!empty($materialRequest->header->registrationTransaction)): ?>
        <tbody>
            <?php foreach ($materialRequest->header->registrationTransaction->registrationServices as $i => $detail): ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'service.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'service.serviceType.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'status'));  ?></td>
                </tr>	
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>