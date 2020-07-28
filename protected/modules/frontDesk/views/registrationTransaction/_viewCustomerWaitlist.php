<div>
    <?php echo CHtml::beginForm(); ?>
    <div>
        <table>
            <thead>
                <tr>
                    <td>Plate #</td>
                    <td>Customer</td>
                    <td>Type</td>
                    <td>Branch</td>
                    <td>Repair Type</td>
                    <td>SO Status</td>
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
                                'update' => '#customer_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($model, 'customer_name', array(
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#customer_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($model, 'customer_type', array(
                            'Individual' => 'Individual',
                            'Company' => 'Company',
                        ), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#customer_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#customer_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($model, 'repair_type', array(
                            'GR' => 'GR',
                            'BR' => 'BR',
                        ), array(
                            'empty' => '-- All --',
                            'onchange' => 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#customer_waitlist_table',
                            )),
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($model, 'status', array(
							'Registration'=>'Registration',
							'Pending'=>'Pending',
							'Available'=>'Available',
							'On Progress'=>'On Progress',
							'Finished'=>'Finished'
						), array(
                            'empty' => '-- All --',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateWaitlistTable'),
                                'update' => '#customer_waitlist_table',
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

<div id="customer_waitlist_table">
    <?php $this->renderPartial('_waitlistTable', array(
        'model' => $model,
        'modelDataProvider' => $modelDataProvider,
    )); ?>
</div>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $modelDataProvider->pagination->itemCount,
            'pageSize' => $modelDataProvider->pagination->pageSize,
            'currentPage' => $modelDataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>