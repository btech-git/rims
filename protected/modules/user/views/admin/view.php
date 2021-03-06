<?php
$this->breadcrumbs = array(
    UserModule::t('Users') => array('admin'),
    $model->username,
);


$this->menu = array(
    array('label' => UserModule::t('Create User'), 'url' => array('create')),
    array('label' => UserModule::t('Update User'), 'url' => array('update', 'id' => $model->id)),
    array('label' => UserModule::t('Delete User'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => UserModule::t('Are you sure to delete this item?'))),
    array('label' => UserModule::t('Manage Users'), 'url' => array('admin')),
    array('label' => UserModule::t('Manage Profile Field'), 'url' => array('profileField/admin')),
    array('label' => UserModule::t('List User'), 'url' => array('/user')),
);
?>

<?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/user/admin/update?id=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
<h1><?php echo UserModule::t('View User') . ' "' . $model->username . '"'; ?></h1>

<?php
$attributes = array(
    'id',
    'username',
);

//	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
//	if ($profileFields) {
//		foreach($profileFields as $field) {
//			array_push($attributes,array(
//					'label' => UserModule::t($field->title),
//					'name' => $field->varname,
//					'type'=>'raw',
//					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
//				));
//		}
//	}

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
