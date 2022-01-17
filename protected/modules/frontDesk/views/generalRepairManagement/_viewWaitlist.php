<div>
    <?php echo CHtml::beginForm(); ?>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Plate #</th>
                    <th>Car Make</th>
                    <th>Car Model</th>
                    <th>Branch</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::activeTextField($model, 'plate_number', array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($model, 'car_make_code', array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#waitlist_table',
                            )),
                        )); ?>                        
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($model, 'car_model_code', array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#waitlist_table',
                            )),
                        )); ?>                        
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#waitlist_table',
                            )),
                        )); ?>
                    </td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th>WO #</th>
                    <th>WO Date</th>
                    <th>Problem</th>
                    <th>Insurance</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <td>
                        <?php echo CHtml::activeTextField($model, 'work_order_number', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#waitlist_table',
                            )),
                        )); ?>
                    </td>
                    
                    <td>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model'=>$model,
                            'attribute' => 'work_order_date',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Work Order Date',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                    'update' => '#waitlist_table',
                                )),
                            ),
                        )); ?>
                    </td>
                    
                    <td>
                        <?php echo CHtml::activeTextField($model, 'problem', array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($model, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#waitlist_table',
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

<div id="waitlist_table">
    <?php $this->renderPartial('_waitlistTable', array(
        'model' => $model,
        'waitlistDataProvider' => $waitlistDataProvider,
    )); ?>
</div>