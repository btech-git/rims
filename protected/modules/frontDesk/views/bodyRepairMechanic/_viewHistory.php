<div>
    <?php echo CHtml::beginForm(); ?>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Plate #</th>
                    <th>Car Make</th>
                    <th>Car Model</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::textField('PlateNumber', $plateNumber, array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTransactionHistoryTable'),
                                'update' => '#transaction_history_table',
                            )),
                        )); ?>
                    </td>
                    
                    <td>
                        <?php echo CHtml::textField('CarMakeName', $carMakeName, array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTransactionHistoryTable'),
                                'update' => '#transaction_history_table',
                            )),
                        )); ?>                        
                    </td>
                    
                    <td>
                        <?php echo CHtml::textField('CarModelName', $carModelName, array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTransactionHistoryTable'),
                                'update' => '#transaction_history_table',
                            )),
                        )); ?>                        
                    </td>
                </tr>
            </tbody>
            
            <thead>
                <tr>
                    <th>WO #</th>
                    <th>WO Date</th>
                    <th>Branch</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::textField('WorkOrderNumber', $workOrderNumber, array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTransactionHistoryTable'),
                                'update' => '#transaction_history_table',
                            )),
                        )); ?>
                    </td>
                    
                    <td>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'WorkOrderDate',
                            'attribute' => $workOrderDate,
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Work Order Date',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateTransactionHistoryTable'),
                                    'update' => '#transaction_history_table',
                                )),
                            ),
                        )); ?>
                    </td>
                    
                    <td>
                        <?php echo CHtml::dropDownList('BranchId', $branchId, CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateTransactionHistoryTable'),
                                'update' => '#transaction_history_table',
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
 
<br />
 
<div id="transaction_history_table" style="height: 430px">
    <?php $this->renderPartial('_transactionHistoryTable', array(
        'registrationHistoryDataProvider' => $registrationHistoryDataProvider,
    )); ?>
</div>