<div>
    <table>
        <thead>
            <tr>
                <td>Plate #</td>
                <td>Customer</td>
                <td>Type</td>
                <td>Branch</td>
                <td>Repair Type</td>
                <td>SO Status</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo CHtml::textField('PlateNumberWaitlist', $plateNumberWaitlist); ?></td>
                <td><?php echo CHtml::textField('CustomerNameWaitlist', $customerNameWaitlist); ?></td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'customer_type', array(
                        'Individual' => 'Individual',
                        'Company' => 'Company',
                    ), array('empty' => '-- All --')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                        'empty' => '-- All --'
                    )); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'repair_type', array(
                        'GR' => 'GR',
                        'BR' => 'BR',
                    ), array('empty' => '-- All --',)); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'status', array(
                        'Registration'=>'Registration',
                        'Pending'=>'Pending',
                        'Available'=>'Available',
                        'On Progress'=>'On Progress',
                        'Finished'=>'Finished'
                    ), array('empty' => '-- All --',)); ?>
                </td>
            </tr>
        </tbody>
    </table>

    <div>
        <?php echo CHtml::submitButton('Clear', array('name' => 'ResetFilter')); ?>
        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
    </div>
</div>

<div id="customer_waitlist_table">
    <?php $this->renderPartial('_waitlistCustomer', array(
        'dataProvider' => $dataProvider,
    )); ?>
</div>