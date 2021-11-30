<div>
    <?php echo CHtml::beginForm(); ?>
    <div>
        <table>
            <thead>
                <tr>
                    <td>Branch</td>
                    <td>Start Date</td>
                    <td>End Date</td>
                </tr>
            </thead>
            <tbody>
                <tr>
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
                    <td>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'StartDate',
                            'attribute' => $startDate,
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Start Date'
                            ),
                        )); ?>
                    </td>
                    <td>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'EndDate',
                            'attribute' => $endDate,
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'End Date'
                            ),
                        )); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div>
            <?php echo CHtml::submitButton('Clear', array('name' => 'Clear')); ?>
            <?php echo CHtml::submitButton('Search', array('class'=>'button cbutton')); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>

<br />

<div id="transaction_history_table">
    <?php $this->renderPartial('_transactionHistory', array(
        'registrationService' => $registrationService,
        'registrationServiceHistoryDataProvider' => $registrationServiceHistoryDataProvider,
    )); ?>
</div>