<div>
    <table>
        <thead>
            <tr>
                <td>Plate #</td>
                <td>Customer</td>
                <td colspan="2">Tanggal Masuk</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo CHtml::textField('PlateNumberIn', $plateNumberIn); ?></td>
                <td><?php echo CHtml::textField('CustomerNameIn', $customerNameIn); ?></td>
                <td>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name'=>'StartDateIn',
                        'value' => $startDateIn,
                        'options'=>array(
                            'dateFormat'=>'yy-mm-dd',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                        ),
                        'htmlOptions'=>array(
                            'class' => 'form-select',
                            'style'=>'margin-bottom:0px;',
                            'placeholder'=>'Date From',
                        ),
                    )); ?>
                </td>
                <td>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name'=>'EndDateIn',
                        'value' => $endDateIn,
                        'options'=>array(
                            'dateFormat'=>'yy-mm-dd',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                        ),
                        'htmlOptions'=>array(
                            'class' => 'form-select',
                            'style'=>'margin-bottom:0px;',
                            'placeholder'=>'Date To',
                        ),
                    )); ?>
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
    <?php $this->renderPartial('_vehicleEntry', array(
        'startDateIn' => $startDateIn,
        'endDateIn' => $endDateIn,
        'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
    )); ?>
</div>