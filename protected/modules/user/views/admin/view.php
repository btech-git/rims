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

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[pendingHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php echo CHtml::label('PENDING', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
                
            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Daftar Transaksi Pending</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[pendingTransactionView]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Order Outstanding</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[orderOutstandingView]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Approval Permintaan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[requestApprovalView]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Approval Data Master</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterApprovalView]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[frontOfficeHead]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('RESEPSIONIS', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>General Repair</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[generalRepairCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[generalRepairEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][generalRepairApproval]", CHtml::resolveValue($model, "roles[generalRepairApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairApproval')); ?></td>
        </tr>
        <tr>
            <td>Body Repair</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[bodyRepairCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[bodyRepairEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][bodyRepairApproval]", CHtml::resolveValue($model, "roles[bodyRepairApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairApproval')); ?></td>
        </tr>
        <tr>
            <td>Inspeksi Kendaraan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[inspectionCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[inspectionEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][inspectionApproval]", CHtml::resolveValue($model, "roles[inspectionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionApproval')); ?></td>
        </tr>
        <tr>
            <td>SPK</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[workOrderApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][cashierCreate]", CHtml::resolveValue($model, "roles[cashierCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierCreate')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][cashierEdit]", CHtml::resolveValue($model, "roles[cashierEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierEdit')); ?></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[cashierApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Daftar Antrian Customer</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[customerQueueApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[purchaseHead]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('PEMBELIAN', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Order Permintaan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[requestOrderCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[requestOrderEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[requestOrderApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Order Pembelian</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[purchaseOrderCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[purchaseOrderEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[purchaseOrderApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[salesHead]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('PENJUALAN', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Order Penjualan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleOrderCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleOrderEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleOrderApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Penjualan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleInvoiceCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleInvoiceEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][saleInvoiceApproval]", CHtml::resolveValue($model, "roles[saleInvoiceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[accountingHead]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('PELUNASAN', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Payment In</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[paymentInCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[paymentInEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[paymentInApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Payment Out</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[paymentOutCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[paymentOutEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[paymentOutApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[cashierHead]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('TUNAI', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Transaksi Kas</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[cashTransactionCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[cashTransactionEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[cashTransactionApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Transaksi Jurnal Umum</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[adjustmentJournalCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[adjustmentJournalEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[adjustmentJournalApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[operationHead]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('OPERASIONAL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Permintaan Transfer</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[transferRequestCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[transferRequestEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[transferRequestApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Permintaan Kirim</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[sentRequestCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[sentRequestEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[sentRequestApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Retur Beli</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[purchaseReturnCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[purchaseReturnEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[purchaseReturnApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Retur Jual</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleReturnCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleReturnEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleReturnApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pengiriman Barang</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[deliveryCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[deliveryEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[deliveryApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penerimaan Barang</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[receiveItemCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[receiveItemEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[receiveItemApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penerimaan Konsinyasi</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[consignmentInCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[consignmentInEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[consignmentInApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pengeluaran Konsinyasi</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[consignmentOutCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[consignmentOutEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[consignmentOutApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[inventoryHead]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('GUDANG', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Barang Masuk Gudang</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementInCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementInEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementInApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Barang Keluar Gudang</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementOutCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementOutEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementOutApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pengeluaran Bahan Pemakaian</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementServiceCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementServiceEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementServiceApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penyesuaian Stok</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[stockAdjustmentCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[stockAdjustmentEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[stockAdjustmentApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Permintaan Bahan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[materialRequestCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[materialRequestEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[materialRequestApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Stok Gudang</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[warehouseStockReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Analisa Stok Barang</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[stockAnalysisReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[idleManagement]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('IDLE MANAGEMENT', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>BR Mechanic POV</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[brMechanicCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[brMechanicEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[brMechanicApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>GR Mechanic POV</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[grMechanicCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[grMechanicEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[grMechanicApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[areaManager]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('HEAD DEPT', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Laporan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Rincian Buku Besar Pembantu Piutang</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[payableJournalReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Buku Besar Pembantu Hutang</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[receivableJournalReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Inventory Stok Penjualan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[stockInventoryReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Kartu Stok Persediaan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[stockCardReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Financial Forecast</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[financialForecastReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>General Ledger</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[generalLedgerReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Balance Sheet (Induk)</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[summaryBalanceSheetReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Balance Sheet (Standard)</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[standardBalanceSheetReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Profit/Loss (induk)</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[summaryProfitLossReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Profit/Loss (Standar)</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[standardProfitLossReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Cash Transaction</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[cashTransactionReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Consignment In</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[consignmentInReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Consignment Out</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[consignmentOutReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Permintaan Bahan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[materialRequestReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Movement In</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementInReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Movement Out</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[movementOutReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pembelian</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[purchaseReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Hutang Supplier</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[supplierPayableReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Invoice Penjualan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleInvoiceReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Piutang Customer</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[customerReceivableReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Payment In</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[paymentInReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Payment Out</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[paymentOutReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Retail Summary</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleSummaryReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Retail Product</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleProductReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Retail Service</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleServiceReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pengiriman</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[deliveryReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penerimaan Barang</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[receiveReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Order Penjualan</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[saleOrderReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Sent Request</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[sentRequestReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Transfer Request</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[transferRequestReport]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[masterCompany]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php echo CHtml::label('SETTING COMPANY', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>User</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterUserCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterUserEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterUserApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?></td>
        </tr>
        <tr>
            <td>Company</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCompanyCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCompanyEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCompanyApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Insurance Company</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInsuranceCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInsuranceEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInsuranceApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Branch</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterBranchCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterBranchEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterBranchApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterSupplierCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterSupplierEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterSupplierApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Employee</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEmployeeCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEmployeeEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEmployeeApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Deduction</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterDeductionCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterDeductionEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterDeductionApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Incentive</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterIncentiveCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterIncentiveEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterIncentiveApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Position</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPositionCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPositionEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPositionApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Division</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterDivisionCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterDivisionEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterDivisionApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Level</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterLevelCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterLevelEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterLevelApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Unit</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterUnitCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterUnitEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterUnitApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Unit Conversion</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterConversionCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterConversionEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterConversionApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Public Holiday</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterHolidayCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterHolidayEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterHolidayApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[masterAccounting]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('SETTING ACCOUNTING', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Bank</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterBankCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterBankEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterBankApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>COA</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCoaCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCoaEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCoaApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>COA Category</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCoaCategoryCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCoaCategoryEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCoaCategoryApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>COA Sub Category</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCoaSubCategoryCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCoaSubCategoryEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCoaSubCategoryApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Payment Type</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPaymentTypeCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPaymentTypeEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPaymentTypeApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[masterProductInventory]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('SETTING PRODUCT', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Product</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Product Category</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductCategoryCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductCategoryEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductCategoryApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Product Sub Master Category</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Product Sub Category</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductSubCategoryCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductSubCategoryEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterProductSubCategoryApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Brand</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterBrandCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterBrandEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterBrandApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Sub Brand</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterSubBrandCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterSubBrandEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterSubBrandApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Sub Brand Series</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterSubBrandSeriesCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterSubBrandSeriesEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterSubBrandSeriesApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Equipment</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEquipmentCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEquipmentEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEquipmentApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Equipment Type</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEquipmentTypeCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEquipmentTypeEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEquipmentTypeApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Equipment Sub Type</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEquipmentSubTypeCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEquipmentSubTypeEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterEquipmentSubTypeApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Warehouse</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterWarehouseCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterWarehouseEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterWarehouseApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceList]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('SETTING SERVICE', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Service</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Service Category</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceCategoryCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceCategoryEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceCategoryApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Service Type</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceTypeCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceTypeEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterServiceTypeApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Price List Standard</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPricelistStandardCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPricelistStandardEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPricelistStandardApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Price List Group</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPricelistGroupCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPricelistGroupEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPricelistGroupApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Price List Set</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPricelistSetCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPricelistSetEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterPricelistSetApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Standard Flat Rate</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterStandardFlatrateCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterStandardFlatrateEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterStandardFlatrateApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Standard Value</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterStandardValueCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterStandardValueEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterStandardValueApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Quick Service</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterQuickServiceCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterQuickServiceEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterQuickServiceApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Inspection</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInspectionCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInspectionEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInspectionApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Inspection Section</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInspectionSectionCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInspectionSectionEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInspectionSectionApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Inspection Module</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInspectionModuleCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInspectionModuleEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterInspectionModuleApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
            <?php if (CHtml::resolveValue($model, "roles[masterVehicleInventory]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
                <?php echo CHtml::label('SETTING VEHICLE', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Vehicle</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterVehicleCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterVehicleEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterVehicleApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Customer</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCustomerCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCustomerEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCustomerApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Car Make</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarMakeCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarMakeEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarMakeApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Car Model</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarModelCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarModelEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarModelApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Car Sub Model</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarSubModelCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarSubModelEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarSubModelApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Car Sub Model Detail</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarSubModelDetailCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarSubModelDetailEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterCarSubModelDetailApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Color</td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterColorCreate]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?></td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterColorEdit]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
            <td style="text-align: center">
            <?php if (CHtml::resolveValue($model, "roles[masterColorApproval]")): ?>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
            <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>
