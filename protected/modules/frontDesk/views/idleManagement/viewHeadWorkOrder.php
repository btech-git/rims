<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Idle Management' => array('indexHead'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List RegistrationTransaction', 'url' => array('admin')),
    array('label' => 'Create RegistrationTransaction', 'url' => array('index')),
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
        <h1>Manage General Repair Progress</h1>

        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Work Order' => array(
                        'content' => $this->renderPartial('_viewWorkOrderHead', array(
                            'registration' => $registration,
                            'memo' => $memo,
                        ), true),
                    ),
                    'Products' => array(
                        'content' => $this->renderPartial('_viewProduct', array(
                            'registration' => $registration,
                        ), true),
                    ),
                    'Quick Service' => array(
                        'content' => $this->renderPartial('_viewQuickService', array(
                            'registration' => $registration,
                            'registrationQuickService' => $registrationQuickService,
                            'registrationQuickServiceDataProvider' => $registrationQuickServiceDataProvider,
                        ), true),
                    ),
                    'Service History' => array(
                        'content' => $this->renderPartial('_viewServiceHistory', array(
                            'registration' => $registration,
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

        <div>
            <h3>List Memo</h3>
            <table>
                <?php foreach ($registration->registrationMemos as $i => $detail): ?>
                    <tr>
                        <td style="width: 5%"><?php echo CHtml::encode($i + 1); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'date_time')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'user.username')); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </table>
        </div>

        <br />

        <div class="grid-view">
            <table>
                <thead>
                    <tr style="background-color: yellow">
                        <th style="text-align: center">No</th>
                        <th style="text-align: center">Service</th>
                        <th style="text-align: center">Category</th>
                        <th style="text-align: center">Duration</th>
                        <th style="text-align: center">Start</th>
                        <th style="text-align: center">Finish</th>
                        <th style="text-align: center">Total Time</th>
                        <th style="text-align: center">Service Status</th>
                        <th style="text-align: center">Assign Mechanic</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registration->registrationServices as $i => $registrationService): ?>
                        <tr>
                            <td style="text-align: center"><?php echo $i + 1; ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationService, 'service.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationService, 'service.serviceCategory.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationService, 'hour')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationService, 'start')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationService, 'end')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationService, 'total_time')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationService, 'status')); ?></td>
                            <td>
                                <?php echo CHtml::activeDropDownlist($registrationService, "[$i]assign_mechanic_id", CHtml::listData(EmployeeBranchDivisionPositionLevel::model()->findAllByAttributes(array(
                                    "branch_id" => $registration->branch_id,
                                    "division_id" => 1,
                                    "position_id" => 1,
                                    "level_id" => array(1, 2, 3),
                                )), "employee_id", "employee.name"), array("empty" => "--Assign Mechanic--")); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>                        
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="text-align:center">
    <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'button success')); ?>
</div>
<?php echo CHtml::endForm(); ?>