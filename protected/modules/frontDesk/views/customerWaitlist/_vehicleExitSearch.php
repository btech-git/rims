<div>
    <table>
        <thead>
            <tr>
                <td>Plate #</td>
                <td>Customer</td>
                <td colspan="2">Tanggal Keluar</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo CHtml::textField('PlateNumberExit', $plateNumberExit); ?></td>
                <td><?php echo CHtml::textField('CustomerNameExit', $customerNameExit); ?></td>
                <td>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name'=>'StartDateExit',
                        'value' => $startDateExit,
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
                        'name'=>'EndDateExit',
                        'value' => $endDateExit,
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
    <?php $this->renderPartial('_vehicleExit', array(
        'startDateExit' => $startDateExit,
        'endDateExit' => $endDateExit,
        'vehicleExitDataprovider' => $vehicleExitDataprovider,
    )); ?>
</div>