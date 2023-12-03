<div id="maincontent">
    <h1>Data Log Master Vehicle <?php echo CHtml::encode(CHtml::value($vehicle, 'name')); ?></h1>

    <br />
    
    <table>
        <thead>
            <tr>
                <th>Plate #</th>
                <th>Car Make</th>
                <th>Car Model</th>
                <th>Car Sub Model</th>
                <th>Customer</th>
                <th>Updated Date</th>
                <th>Updated Time</th>
                <th>Updated User</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicleLog as $data): ?>
                <?php $carMake = VehicleCarMake::model()->findByPk($data->car_make_id); ?>
                <?php $carModel = VehicleCarModel::model()->findByPk($data->car_model_id); ?>
                <?php $carSubModel = VehicleCarSubModel::model()->findByPk($data->car_sub_model_id); ?>
                <?php $customer = Customer::model()->findByPk($data->customer_id); ?>
                <?php $updatedUser = Users::model()->findByPk($data->user_updated_id); ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'plate_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($carMake, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($carModel, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($carSubModel, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'date_updated')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'time_updated')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($updatedUser, 'username')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
