<div>
    <?php echo CHtml::beginForm(); ?>
    <div>
        <table>
            <thead>
                <tr>
                    <td>Branch</td>
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
                </tr>
            </tbody>
        </table>
        
        <div>
            <?php echo CHtml::submitButton('Clear', array('name' => 'Clear')); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>

<div id="transaction_history_table">
    <?php $this->renderPartial('_transactionHistoryTable', array(
        'registrationService' => $registrationService,
        'registrationServiceDataProvider' => $registrationServiceDataProvider,
    )); ?>
</div>