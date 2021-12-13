<div>
    <?php echo CHtml::beginForm(); ?>
    <div>
        <table>
            <thead>
                <tr>
                    <td>Plate #</td>
                    <td>WO #</td>
                    <td>WO Status</td>
                    <td>Branch</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::textField('PlateNumber', $plateNumber, array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateMechanicWaitlistTable'),
                                'update' => '#mechanic_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField('WorkOrderNumber', $workOrderNumber, array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateMechanicWaitlistTable'),
                                'update' => '#mechanic_waitlist_table',
                            )),
                        )); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div>
            <?php echo CHtml::submitButton('Clear', array('name' => 'Clear')); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>

<div id="mechanic_waitlist_table" style="height: 430px">
    <?php $this->renderPartial('_mechanicWaitlistTable', array(
        'model' => $model,
        'waitlistDataProvider' => $waitlistDataProvider,
    )); ?>
</div>
