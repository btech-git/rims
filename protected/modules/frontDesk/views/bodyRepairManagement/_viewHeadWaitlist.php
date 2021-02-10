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
                        <?php echo CHtml::activeTextField($model, 'plate_number', array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateHeadWaitlistTable'),
                                'update' => '#head_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($model, 'work_order_number', array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateHeadWaitlistTable'),
                                'update' => '#head_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($model, 'status', array(
							'Pending'=>'Pending',
							'Available'=>'Available',
							'On Progress'=>'On Progress',
							'Finished'=>'Finished'
						), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateHeadWaitlistTable'),
                                'update' => '#head_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateHeadWaitlistTable'),
                                'update' => '#head_waitlist_table',
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

<div id="head_waitlist_table">
    <?php $this->renderPartial('_headWaitlistTable', array(
        'model' => $model,
        'modelDataProvider' => $modelDataProvider,
    )); ?>
</div>