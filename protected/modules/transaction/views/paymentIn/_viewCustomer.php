<div id="customer">
    <fieldset>
        <legend>Customer</legend>
        <table>
            <thead>
                <tr>
                    <td>Nama</td>
                    <td>Type</td>
                    <td>Alamat</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Mobile</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $form->hiddenField($model, 'customer_id', array('readonly' => true)); ?>
                        <input type="text" readonly="true" id="Customer_customer_name" value="<?php echo $model->customer->name; ?>"> 
                    </td>
                    <td><input type="text" readonly="true" id="Customer_customer_type" value="<?php echo $model->customer_id != "" ? $model->customer->customer_type : '' ?>"></td>
                    <td><textarea name="" id="Customer_customer_address" cols="30" rows="3" readonly="true"><?php echo $model->customer_id != "" ? $model->customer->address . '&#13;&#10;' . $model->customer->province->name . '&#13;&#10;' . $model->customer->city->name . '&#13;&#10;' . $model->customer->zipcode : ''; ?></textarea></td>
                    <td><input type="text" readonly="true" id="Customer_email" value="<?php echo $model->customer_id != "" ? $model->customer->email : ''; ?>"> </td>
                    <td>
                        <?php /*$getPhone = ""; ?>
                        <?php if ($model->customer_id != ""): ?>
                            <?php $phones = CustomerPhone::model()->findAllByAttributes(array('customer_id' => $model->customer_id, 'status' => 'Active')); ?>
                            <?php if (count($phones) > 0): ?>
                                <?php foreach ($phones as $key => $phone): ?>
                                    <?php $getPhone = $phone->phone_no . '&#13;&#10;'; ?>
                                <?php endforeach ?>
                                </textarea>
                            <?php endif ?>
                        <?php endif*/ ?>
                        <textarea name="" id="Customer_phones" cols="30" rows="3" readonly="true"><?php echo CHtml::encode(CHtml::value($model, 'customer.phone')); ?></textarea>
                    </td>
                    <td>
                        <?php /*$getMobile = "" ?>
                        <?php if ($model->customer_id != ""): ?>
                            <?php $mobiles = CustomerMobile::model()->findAllByAttributes(array('customer_id' => $model->customer_id, 'status' => 'Active')); ?>
                            <?php if (count($mobiles) > 0): ?>
                                <?php foreach ($mobiles as $key => $mobile): ?>
                                    <?php $getMobile .= $mobile->mobile_no . '&#13;&#10;'; ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        <?php endif*/ ?>
                        <textarea name="" id="Customer_mobiles" cols="30" rows="3" readonly="true"><?php echo CHtml::encode(CHtml::value($model, 'customer.mobile_phone')); ?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</div>