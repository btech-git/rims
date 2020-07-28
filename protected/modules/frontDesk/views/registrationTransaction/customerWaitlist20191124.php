<h1>Customer Waitlist</h1>
<?php
/*$this->renderPartial('_search_wl'); 

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#registration-transaction-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
*/
$nItemsPerPage = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$totalcw = count($models);
$current_from_cw = ($page == 1) ? 1 : (($page * $nItemsPerPage) + 1) - 10;
$current_to_cw = (($page * $nItemsPerPage) >= $totalcw) ? $totalcw : ($page * $nItemsPerPage);
$pagination = round(count($models) / 10);
?>
<div class="row">
    <div class="large-12 columns">
        <div class="waitlist grid-view">
            <table id="waitlisttable" class="sss">
                <thead>
                <tr>
                    <th>Plate#</th>
                    <th>Car Make</th>
                    <th>Car Model</th>
                    <th>Car Year</th>
                    <th>WO #</th>
                    <th>Position</th>
                    <th>Duration</th>
                    <th>Insurance</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach (array_slice($models, $nItemsPerPage * ($page - 1), $nItemsPerPage) as $i => $model): ?>
                    <tr>
                        <td><?php echo $model->vehicle != null ? $model->vehicle->plate_number : ' '; ?></td>
                        <td><?php echo $model->vehicle->carMake != null ? $model->vehicle->carMake->name : ' '; ?></td>
                        <td><?php echo $model->vehicle->carModel != null ? $model->vehicle->carModel->name : ' '; ?></td>
                        <td><?php echo $model->vehicle != null ? $model->vehicle->year : ' '; ?></td>
                        <td><?php echo $model->work_order_number != null ? $model->work_order_number : ' '; ?></td>
                        <td><?php echo $model->status != null ? $model->status : '-'; ?></td>
                        <?php
                        if ($model->repair_type == 'GR') {
                            $regServices = RegistrationService::model()->findAllByAttributes(array(
                                'registration_transaction_id' => $model->id,
                                'is_body_repair' => 0
                            ));
                        } else {
                            $regServices = RegistrationService::model()->findAllByAttributes(array(
                                'registration_transaction_id' => $model->id,
                                'is_body_repair' => 1
                            ));
                        }
                        $duration = 0;
                        foreach ($regServices as $key => $regService) {
                            $duration += $regService->service->flat_rate_hour;
                        }
                        ?>
                        <td><?php echo $duration; ?></td>
                        <td><?php echo $model->insuranceCompany != null ? $model->insuranceCompany->name : '-'; ?></td>
                        <td>
                            <?php /*echo CHtml::button('detail', array('class' => 'hello','disabled'=>count($regServices) == 0 ? true : false,
										'onclick'=>'$("#detail-'.$i.'").toggle();
									')); */ ?>

                            <?php
                            echo CHtml::tag('button', array(
                                    // 'name'=>'btnSubmit',
                                    'disabled' => count($regServices) == 0 ? true : false,
                                    'type' => 'button',
                                    'class' => 'hello button expand',
                                    'onclick' => '$("#detail-' . $i . '").toggle();'
                                ),
                                '<span class="fa fa-caret-down"></span> Detail'
                            );
                            ?>
                        </td>
                    </tr>
                    <tr id="detail-<?php echo $i ?>" class="hide">
                        <td colspan="9">
                            <table>
                                <thead>
                                <tr>
                                    <th width="400px">Service</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Duration</th>
                                    <th>Customer Name</th>
                                    <th>Customer Type</th>
                                    <th>Working By</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($regServices as $key => $regService) : ?>
                                    <tr>
                                        <td><?php echo $regService->service->name; ?></td>
                                        <td><?php echo $regService->start; ?></td>
                                        <td><?php echo $regService->end; ?></td>
                                        <td><?php echo $regService->service->flat_rate_hour; ?></td>
                                        <td><?php echo $regService->registrationTransaction->customer->name; ?></td>
                                        <td><?php echo $regService->registrationTransaction->customer->customer_type; ?></td>

                                        <td><?php $first = true;
                                            $rec = "";
                                            $eDetails = RegistrationServiceEmployee::model()->findAllByAttributes(array('registration_service_id' => $regService->id));
                                            foreach ($eDetails as $eDetail) {
                                                $employee = Employee::model()->findByPk($eDetail->employee_id);
                                                if ($first === true) {
                                                    $first = false;
                                                } else {
                                                    $rec .= ', ';
                                                }
                                                $rec .= $employee->name;

                                            }
                                            echo $rec;
                                            ?></td>
                                        <td><?php echo $regService->status; ?></td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                            <?php
                            $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $model->id));

                            if ($products != null) { ?>
                                <table>
                                    <tr>
                                        <th width="400px">Product</th>
                                        <th>Product Status</th>
                                        <th>Qty Movement</th>
                                        <th>Qty Movement Left</th>
                                    </tr>
                                    <?php foreach ($products as $key => $product) { ?>
                                        <tr>
                                            <td><?= $product->product->name ?></td>
                                            <td></td>
                                            <td><?= $product->quantity_movement ?></td>
                                            <td><?= $product->quantity_movement_left ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

            <div class="clearfix">
                <div class="summary">Displaying <?php echo $current_from_cw; ?>-<?php echo $current_to_cw; ?>
                    of <?php echo $totalcw; ?> results.
                </div>
                <div class="pager">
                    <ul class="yiiPager">
                        <li class="first"><?php echo CHtml::link('&lt;&lt; First',
                                array('registrationTransaction/customerWaitlist?page=1')); ?></li>
                        <li class="previous"><?php echo CHtml::link('&lt; Previous',
                                array('registrationTransaction/customerWaitlist?page=' . ($page - 1))); ?></li>
                        <?php
                        for ($i = 1; $i <= $pagination; $i++) {
                            $selected = ($i == $page) ? "selected" : "";
                            echo "<li class=\"page " . $selected . "\">";
                            echo CHtml::link($i, array('registrationTransaction/customerWaitlist?page=' . $i));
                            echo "</li>";
                        }
                        ?>
                        <li class="next"><?php echo CHtml::link('Next &gt;',
                                array('registrationTransaction/customerWaitlist?page=' . ($page + 1))); ?></li>
                        <li class="last"> <?php echo CHtml::link('Last &gt;&gt;',
                                array('registrationTransaction/customerWaitlist?page=' . $pagination)); ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <h3>Mechanics</h3>
        <hr/>
        <?php $employees = Employee::model()->findAll(); ?>

        <div class="row">
            <div class="large-12 columns">

                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Availability</th>
                        <th>Skill</th>
                        <th>Work Order Number</th>
                        <th>Plate Number</th>
                        <th>Branch</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($employees as $key => $employee): ?>
                        <tr>
                            <td>    <?php echo $employee->name; ?></td>
                            <td>    <?php echo $employee->availability; ?></td>
                            <td>    <?php echo $employee->skills; ?></td>
                            <td>
                                <ul style="margin-bottom: 0 !important; list-style: none;">
                                    <?php
                                    foreach (RegistrationServiceEmployee::model()->findAllByAttributes(array('employee_id' => $employee->id)) as $key => $value) {
                                        echo "<li>" . $value->registrationService->registrationTransaction->work_order_number . "</li>";
                                    }
                                    ?>
                                </ul>
                            </td>
                            <td>
                                <ul style="margin-bottom: 0 !important; list-style: none;">
                                    <?php
                                    foreach (RegistrationServiceEmployee::model()->findAllByAttributes(array('employee_id' => $employee->id)) as $key => $value) {
                                        echo "<li>" . $value->registrationService->registrationTransaction->vehicle->plate_number . "</li>";
                                    }
                                    ?>
                                </ul>
                            </td>
                            <td>    <?php echo empty($employee->branch->name) ? 'Branch Inactive' : $employee->branch->name; ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <h3>Time Counter</h3>
        <hr>
        <a name="timecounter"></a><a name="1"></a><a name="2"></a><a name="3"></a><a name="4"></a><a name="5"></a>
        <div class="time-counter">
            <div class="detail">

                <?php
                // $current_url=Yii::app()->request->requestUri;
                // $active_tab=parse_url($current_url,PHP_URL_FRAGMENT);
                $active_tab = !empty($_GET['RegistrationTransaction']['tab_type']) ? $_GET['RegistrationTransaction']['tab_type'] : '';
                // echo $active_tab;
                ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Epoxy' => array(
                            'id' => 'epoxy',
                            'content' => $this->renderPartial(
                                '_viewEpoxy',
                                array('epoxyDatas' => $epoxyDatas), true)
                        ),
                        'Cat' => array(
                            'id' => 'paint',
                            'content' => $this->renderPartial(
                                '_viewPaint',
                                array('paintDatas' => $paintDatas), true)
                        ),
                        'Finishing' => array(
                            'id' => 'finishing',
                            'content' => $this->renderPartial(
                                '_viewFinishing',
                                array('finishingDatas' => $finishingDatas), true)
                        ),
                        'Dempul' => array(
                            'id' => 'dempul',
                            'content' => $this->renderPartial(
                                '_viewDempul',
                                array('dempulDatas' => $dempulDatas), true)
                        ),
                        'Cuci/Salon' => array(
                            'id' => 'washing',
                            'content' => $this->renderPartial(
                                '_viewWashing',
                                array('washingDatas' => $washingDatas), true)
                        ),
                        'Opening' => array(
                            'id' => 'opening',
                            'content' => $this->renderPartial(
                                '_viewOpening',
                                array('openingDatas' => $openingDatas), true)
                        ),
                    ),
                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                        'active' => $active_tab,
                    ),
                    // set id for this widgets
                    // 'id'=>'view_tab',
                ));
                ?>
            </div>
        </div>
        <h3>General Repair</h3>
        <hr>
        <div class="general-repair-counter">
            <div class="detail">
                <?php
                // $current_url=Yii::app()->request->requestUri;
                // $active_tab=parse_url($current_url,PHP_URL_FRAGMENT);
                $active_tab = !empty($_GET['RegistrationTransaction']['tab_type']) ? $_GET['RegistrationTransaction']['tab_type'] : '';
                // echo $active_tab;
                ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'General Repair' => array(
                            'id' => 'tabgr',
                            'content' => $this->renderPartial(
                                '_viewGr',
                                array('grDatas' => $grDatas), true)
                        ),
                        'TBA(Tire Balancing)' => array(
                            'id' => 'tba',
                            'content' => $this->renderPartial(
                                '_viewTba',
                                array('tbaDatas' => $tbaDatas), true)
                        ),
                        'Oil' => array(
                            'id' => 'groil',
                            'content' => $this->renderPartial(
                                '_viewGrOil',
                                array('grOilDatas' => $grOilDatas), true)
                        ),
                        'Car Wash' => array(
                            'id' => 'grwash',
                            'content' => $this->renderPartial(
                                '_viewGrWash',
                                array('grWashDatas' => $grWashDatas), true)
                        ),
                    ),
                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                        'active' => $active_tab,
                    ),
                    // set id for this widgets
                    // 'id'=>'view_tab',
                ));
                ?>
            </div>
        </div>
        <?php
        $customer = new Customer('search');
        $customerCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);
        $customerCriteria->compare('customer_type', $customer->customer_type, true);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        )); ?>


        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'customer-dialog',
                // additional javascript options for the dialog plugin
                'options' => array(
                    'title' => 'Customer',
                    'autoOpen' => false,
                    'width' => 'auto',
                    'modal' => true,
                ),
            )
        );
        ?>

        <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'customer-grid',
                'dataProvider' => $customerDataProvider,
                'filter' => $customer,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'selectionChanged' => 'js:function(id){
			jQuery("#customer-dialog").dialog("close");
			jQuery.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCustomer', array('id' => '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					jQuery("#RegistrationTransaction_customer_name").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_epoxy").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_dempul").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_finishing").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_opening").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_paint").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_washing").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_tba").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_gr").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_grOil").val(data.name);
					jQuery("#RegistrationTransaction_customer_name_grWash").val(data.name);
				},
			});
		}',
                'columns' => array(
                    //'id',
                    //'code',
                    'customer_type',
                    'name',
                    'email',
                ),
            )
        );
        ?>

        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

        <?php
        /*Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/simplePagination.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.simplePagination.js', CClientScript::POS_END);
    ?>

    <?php
        Yii::app()->clientScript->registerScript('search',"

        $('#waitlisttable').pagination({
            items: 100,
            itemsOnPage: 10,
            cssStyle: 'light-theme'
        });
    ");*/
        ?>
	