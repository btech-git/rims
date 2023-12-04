<?php
$this->breadcrumbs = array(
    $model->username,
);
?>
<h1><?php echo UserModule::t('View User') . ' "' . $model->username . '"'; ?></h1>

<?php echo CHtml::link('Change Password', array("edit", "id" => $model->id), array('class' => 'button warning')); ?>
<?php echo CHtml::link('Request Cuti', array("requestDayoff", "employeeId" => $model->employee_id), array('class' => 'button primary right')); ?>
<?php
$attributes = array(
    'id',
    'username',
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
        'name' => 'status',
        'value' => User::itemAlias("UserStatus", $model->status),
    )
);

$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => $attributes,
));
?>
<br>
<br>
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
<?php endif ?>
