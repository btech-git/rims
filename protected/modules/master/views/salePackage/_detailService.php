<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th>Service</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($registrationTransaction->registrationServices as $i => $detail): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'service.name'));  ?></td>
            </tr>	
        <?php endforeach; ?>
    </tbody>
</table>