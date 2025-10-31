<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employees',
);

$this->menu=array(
	array('label'=>'Create Employee', 'url'=>array('create')),
	array('label'=>'Manage Employee', 'url'=>array('admin')),
);
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Employee Birthday List</div>
    <div><?php echo date('M Y');; ?></div>
</div>

<br />

<fieldset>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">ID</th>
                <th class="width1-3">Name</th>
                <th class="width1-4">Phone</th>
                <th class="width1-5">Division</th>
                <th class="width1-6">Position</th>
                <th class="width1-7">Level</th>
                <th class="width1-8">Status</th>
                <th class="width1-9">Tanggal Lahir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeBirthdayList as $i => $dataItem): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode($dataItem['id_card']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['name']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['mobile_phone_number']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['division']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['position']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['level']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['employment_type']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['birth_date']))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>
