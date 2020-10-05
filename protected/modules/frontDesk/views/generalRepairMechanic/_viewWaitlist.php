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
                    <td>Service Type</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::textField('PlateNumber', $plateNumber, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#mechanic_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField('WorkOrderNumber', $workOrderNumber, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#mechanic_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::dropDownList('Status', $status, array(
                            'Pending'=>'Pending',
                            'Available'=>'Available',
                            'On Progress'=>'On Progress',
                            'Finished'=>'Finished'
                        ), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#mechanic_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::dropDownList('BranchId', $branchId, CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#mechanic_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::dropDownList('ServiceTypeId', $serviceTypeId, CHtml::listData(ServiceType::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
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

<div id="mechanic_waitlist_table">
    <?php $this->renderPartial('_waitlistTable', array(
        'registrationService' => $registrationService,
        'registrationServiceDataProvider' => $registrationServiceDataProvider,
    )); ?>
</div>
