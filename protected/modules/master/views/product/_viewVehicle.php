<div class="large-12 columns">
    <fieldset>
        <legend>List Kendaraan</legend>
        <table>
            <thead>
                <tr>
                    <th>Merk</th>
                    <th>Model</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model->productVehicles as $vehicle): ?>
                    <tr>
                        <td><?php echo CHtml::encode(CHtml::value($vehicle, 'vehicleCarMake.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($vehicle, 'vehicleCarModel.name')); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </fieldset>
</div>