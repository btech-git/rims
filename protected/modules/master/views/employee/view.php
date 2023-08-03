<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs = array(
    'Company',
    'Employees' => array('admin'),
    'View Employee ' . $model->name,
);

$this->menu = array(
    array('label' => 'List Employee', 'url' => array('index')),
    array('label' => 'Create Employee', 'url' => array('create')),
    array('label' => 'Update Employee', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Employee', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Employee', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/employee/admin'; ?>"><span class="fa fa-list"></span>Manage Employees</a>
        <?php if (Yii::app()->user->checkAccess("masterEmployeeEdit") && $model->status == 'Active') { ?>
            <a class="button cbutton warning right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
            <a class="button cbutton alert right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/delete', array('id' => $model->id)); ?>"><span class="fa fa-ban"></span>Resign</a>
        <?php } ?>
        <h1>View Employee <?php echo $model->name; ?></h1>

        <fieldset>
            <h3>Data Karyawan</h3>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'code',
                    array(
                        'name' => 'recruitment_date',
                        'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::encode(CHtml::value($model, 'recruitment_date'))),
                    ),
                    'name',
                    'employment_type',
                    array(
                        'name' => 'branch_id', 
                        'value' => CHtml::encode(CHtml::value($model, 'branch.name')),
                    ),
                    array(
                        'name' => 'division_id', 
                        'value' => CHtml::encode(CHtml::value($model, 'division.name')),
                    ),
                    array(
                        'name' => 'position_id', 
                        'value' => CHtml::encode(CHtml::value($model, 'position.name')),
                    ),
                    array(
                        'name' => 'level_id', 
                        'value' => CHtml::encode(CHtml::value($model, 'level.name')),
                    ),
                    array(
                        'name' => 'employee_head_id', 
                        'value' => CHtml::encode(CHtml::value($model, 'employeeHead.name')),
                    ),
                    array(
                        'header' => 'Kuota Cuti',
                        'name' => 'onleave_allocation', 
                        'value' => CHtml::encode(CHtml::value($model, 'onleave_allocation')),
                    ),
                    'off_day',
                ),
            )); ?>
        </fieldset>

        <fieldset>
            <h2>Information</h2>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'birth_place',
                    array(
                        'name' => 'birth_date',
                        'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::encode(CHtml::value($model, 'birth_date'))),
                    ),
                    'id_card',
                    'family_card_number',
                    'mother_name',
                    'sex',
                    'skills',
                    'religion',
                    'marriage_status',
                    array(
                        'label' => 'Jumlah Anak',
                        'name' => 'children_quantity',
                        'value' => CHtml::encode(CHtml::value($model, 'children_quantity')),
                    ),
                    'home_address',
                    'local_address',
                ),
            )); ?>
        </fieldset>

        <fieldset>
            <h2>Contact Information</h2>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'mobile_phone_number',
                    'email',
                    'school_degree',
                    'school_subject',
                    'bank_name',
                    'bank_account_number',
                    'tax_registration_number',
                ),
            )); ?>
        </fieldset>

        <fieldset>
            <h2>Kontak Darurat</h2>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'emergency_contact_name',
                    'emergency_contact_relationship',
                    'emergency_contact_mobile_phone',
                    'emergency_contact_address',
                ),
            )); ?>
        </fieldset>
    </div>
</div>