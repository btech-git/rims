<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Idle Management' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Registration Transaction', 'url' => array('admin')),
    array('label' => 'Create Registration Transaction', 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle(600);
    $('.bulk-action').toggle();
    $(this).toggleClass('active');
    if($(this).hasClass('active')){
            $(this).text('');
    }else {
            $(this).text('Advanced Search');
    }
    return false;
});
$('.search-form form').submit(function(){
    $('#registration-service-grid').yiiGridView('update', {
            data: $(this).serialize()
    });
    return false;
});

/*$('#registration-service-grid a.registration-service-start').live('click',function() {
    //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;

    var url = $(this).attr('href');
    //  do your post request here
    console.log(url);
    $.post(url,function(html){
        $.fn.yiiGridView.update('registration-service-grid');
    });
    return false;
    });

    $('#registration-service-grid a.registration-service-finish').live('click',function() {
    //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;

    var url = $(this).attr('href');
    //  do your post request here
    console.log(url);
    $.post(url,function(html){
        $.fn.yiiGridView.update('registration-service-grid');
    });
    
    return false;
});*/
"); ?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        <h1>General Repair Mechanic Assignment</h1>

        <div>
            <?php 
            $duration = 0;
            $damage = "";
            ?>
            <table>
                <tr>
                    <td style="width: 50%">Plate Number: <?php echo $vehicle->plate_number; ?></td>
                    <td>Problem : <?php echo $registrationTransaction->problem; ?></td>
                </tr>
                <tr>
                    <td>Car Make: <?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td>Total Duration: <?php echo $duration . ' hr'; ?></td>
                </tr>
                <tr>
                    <td>Car Model: <?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td>Last Update By: <?php echo $registrationTransaction->user->username; ?></td>
                </tr>
                <tr>
                    <td>Work Order #: <?php echo $registrationTransaction->work_order_number; ?></td>
                    <td>Status: <?php echo $registrationTransaction->status; ?></td>
                </tr>
                </tr>
            </table>
        </div>

        <br />

        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Products' => array(
                        'content' => $this->renderPartial('_viewProduct', array(
                            'registrationTransaction' => $registrationTransaction,
                        ), true),
                    ),
                    'Quick Service' => array(
                        'content' => $this->renderPartial('_viewQuickService', array(
                            'registrationTransaction' => $registrationTransaction,
                            'registrationQuickService' => $registrationQuickService,
                            'registrationQuickServiceDataProvider' => $registrationQuickServiceDataProvider,
                        ), true),
                    ),
                    'Service History' => array(
                        'content' => $this->renderPartial('_viewServiceHistory', array(
                            'registrationTransaction' => $registrationTransaction,
                            'vehicle' => $vehicle,
                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_tab',
            ));
            ?>
        </div>

        <br />

        <div class="grid-view">
            <table>
                <thead>
                    <tr style="background-color: yellow">
                        <th style="text-align: center">Service</th>
                        <th style="text-align: center">Category</th>
                        <th style="text-align: center">Duration</th>
<!--                        <th style="text-align: center">Start</th>
                        <th style="text-align: center">Finish</th>
                        <th style="text-align: center">Total Time</th>-->
                        <th style="text-align: center">Service Status</th>
                        <th style="text-align: center">Assign Mechanic</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php foreach ($registrationTransaction->registrationServices as $detail): ?>
                                <?php if ((int)$detail->service_type_id == (int)$registrationServiceManagement->service_type_id): ?>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?> <br />
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationServiceManagement, 'serviceType.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationServiceManagement, 'hour')); ?></td>
<!--                        <td><?php /*echo CHtml::encode(CHtml::value($registrationServiceManagement, 'start')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationServiceManagement, 'end')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationServiceManagement, 'total_time'));*/ ?></td>-->
                        <td><?php echo CHtml::encode(CHtml::value($registrationServiceManagement, 'status')); ?></td>
                        <td>
                            <?php echo CHtml::activeDropDownlist($registrationServiceManagement, 'assign_mechanic_id', CHtml::listData(EmployeeBranchDivisionPositionLevel::model()->findAllByAttributes(array(
                                "branch_id" => $registrationTransaction->branch_id,
                                "division_id" => 1,
                                "position_id" => 1,
                                "level_id" => array(1, 2, 3),
                            )), "employee_id", "employee.name"), array("empty" => "--Assign Mechanic--")); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="text-align:center">
    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'button success')); ?>
</div>
<?php echo CHtml::endForm(); ?>