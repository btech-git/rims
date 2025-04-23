<?php
$this->breadcrumbs = array(
    UserModule::t('Users') => array('admin'),
    $model->username,
);


$this->menu = array(
    array('label' => UserModule::t('Create User'), 'url' => array('create')),
    array('label' => UserModule::t('Update User'), 'url' => array('update', 'id' => $model->id)),
    array('label' => UserModule::t('Delete User'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => UserModule::t('Are you sure to delete this item?'))),
    array('label' => UserModule::t('Manage User'), 'url' => array('admin')),
    array('label' => UserModule::t('Manage Profile Field'), 'url' => array('profileField/admin')),
    array('label' => UserModule::t('List User'), 'url' => array('/user')),
);
?>

<?php echo CHtml::link('Change Password', array("edit", "id" => $model->id), array('class' => 'button warning')); ?>
<?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/user/admin/update?id=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
<h1><?php echo UserModule::t('View User') . ' "' . $model->username . '"'; ?></h1>

<?php
$attributes = array(
    'id',
    'username',
);

    array_push(
        $attributes,
        'email',
        'create_at', 
        'lastvisit_at', 
        array(
            'name' => 'employee_id',
            'value' => $model->employee_id != "" ? Employee::model()->findByPk($model->employee_id)->name : '',
        ), 
        array(
            'name' => 'branch_id',
            'value' => $model->branch_id != "" ? Branch::model()->findByPk($model->branch_id)->name : '',
        ), 
        array(
            'name' => 'superuser',
            'value' => User::itemAlias("AdminStatus", $model->superuser),
        ), 
        array(
            'name' => 'status',
            'value' => User::itemAlias("UserStatus", $model->status),
        )
    );

$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => $attributes,
)); ?>

<br />

<div>
    <table>
        <tr>
            <td>Branch List</td>
            <?php foreach ($model->userBranches as $detail): ?>
                <td><?php echo $detail->branch->code; ?></td>
            <?php endforeach; ?>
        </tr>
    </table>
</div>

<br />

<?php if (count($attendances) != 0): ?>
    <table>
        <tr>
            <th>Date</th>
            <th>Login Time</th>
            <th>Logout Time</th>
        </tr>
        <?php foreach ($attendances as $key => $attendance): ?>
            <tr>
                <td><?php echo $attendance->date; ?></td>
                <td><?php echo $attendance->login_time; ?></td>
                <td><?php echo $attendance->logout_time; ?></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php else: ?>
    <?php echo "NO ATTENDANCE"; ?>
<?php endif; ?>

<br />
<br />

<table>
    <tr>
        <td>
            <?php if (CHtml::resolveValue($model, "roles[director]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            <?php echo CHtml::label('Director', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            
        </td>
        <td>
            <?php if (CHtml::resolveValue($model, "roles[generalManager]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            <?php echo CHtml::label('General Manager', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
        </td>
    </tr>
</table>

<fieldset>
    <legend>Back Office</legend>
    <div id="main-role-panel">
        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Pending' => array(
                        'content' => $this->renderPartial('_viewPending', array('model' => $model), true)
                    ),
                    'Resepsionis' => array(
                        'content' => $this->renderPartial('_viewFrontDesk', array('model' => $model), true)
                    ),
                    'Transaksi' => array(
                        'content' => $this->renderPartial('_viewTransaction', array('model' => $model), true)
                    ),
                    'Operasional' => array(
                        'content' => $this->renderPartial('_viewOperational', array('model' => $model), true)
                    ),
                    'Gudang' => array(
                        'content' => $this->renderPartial('_viewInventory', array('model' => $model), true)
                    ),
                    'Management' => array(
                        'content' => $this->renderPartial('_viewIdleManagement', array('model' => $model), true)
                    ),
                    'Accounting/Finance' => array(
                        'content' => $this->renderPartial('_viewFinance', array('model' => $model), true)
                    ),
                    'HRD' => array(
                        'content' => $this->renderPartial('_viewHumanResource', array('model' => $model), true)
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_tab_transaction',
            )); ?>
        </div>

        <br /><br />

        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Laporan' => array(
                        'content' => $this->renderPartial('_viewReport', array('model' => $model), true)
                    ),
                    'Setting Company' => array(
                        'content' => $this->renderPartial('_viewCompany', array('model' => $model), true)
                    ),
                    'Setting Accounting' => array(
                        'content' => $this->renderPartial('_viewAccounting', array('model' => $model), true)
                    ),
                    'Setting Product' => array(
                        'content' => $this->renderPartial('_viewProduct', array('model' => $model), true)
                    ),
                    'Setting Service' => array(
                        'content' => $this->renderPartial('_viewService', array('model' => $model), true)
                    ),
                    'Setting Vehicle' => array(
                        'content' => $this->renderPartial('_viewVehicle', array('model' => $model), true)
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_tab_master',
            )); ?>
        </div>
    </div>
</fieldset>

<br /><br />

<fieldset>
    <legend>Front Office</legend>
    <div id="front-role-panel">
        <?php echo $this->renderPartial('_viewRimsFront', array('model'=>$model)); ?>
    </div>
</fieldset>