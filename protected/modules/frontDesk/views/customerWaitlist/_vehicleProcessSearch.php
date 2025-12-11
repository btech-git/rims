<div>
    <table>
        <thead>
            <tr>
                <td>Plate #</td>
                <td>Customer</td>
                <td colspan="2">Tanggal Proses</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo CHtml::textField('PlateNumberProcess', $plateNumberProcess); ?></td>
                <td><?php echo CHtml::textField('CustomerNameProcess', $customerNameProcess); ?></td>
                <td>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name'=>'StartDateProcess',
                        'value' => $startDateProcess,
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
                        'name'=>'EndDateProcess',
                        'value' => $endDateProcess,
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
    <?php $this->renderPartial('_vehicleProcess', array(
        'startDateProcess' => $startDateProcess,
        'endDateProcess' => $endDateProcess,
        'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
    )); ?>
</div>