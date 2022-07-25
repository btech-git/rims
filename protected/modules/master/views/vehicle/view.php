<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs = array(
    'Vehicle' => array('admin'),
    'Vehicles' => array('admin'),
    'View Vehicle ' . $model->plate_number,
);

$this->menu = array(
    array('label' => 'List Vehicle', 'url' => array('index')),
    array('label' => 'Create Vehicle', 'url' => array('create')),
    array('label' => 'Update Vehicle', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Vehicle', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Vehicle', 'url' => array('admin')),
);
?>
<!--<div class="row">
        <div class="small-12 columns">
                <div class="breadcrumbs">
                        <a href="<?php /*echo Yii::app()->baseUrl . '/site/index'; ?>">Home</a>
                        <a href="<?php echo Yii::app()->baseUrl . '/master/vehicle/admin'; ?>">Vehicle</a>
                        <a href="<?php echo Yii::app()->baseUrl . '/master/vehicle/admin';*/ ?>">Vehicles</a>
                        <span>View Vehicles</span>
                </div>
        </div>
</div>-->

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/vehicle/admin'; ?>"><span class="fa fa-th-list"></span>Manage Vehicles</a>
        <?php if (Yii::app()->user->checkAccess("masterVehicleEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>		
        <?php } ?>
        <?php //if (Yii::app()->user->checkAccess("master.registrationTransaction.create")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/registrationTransaction/create', array('type' => 2, 'id' => $model->id)); ?>"><span class="fa fa-plus"></span>Registration</a>
        <?php //} ?>
        <h1>View Vehicle <?php echo $model->plate_number; ?></h1>

        <div class="row">
            <div class="small-12 columns">
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'plate_number',
                        'machine_number',
                        'frame_number',
                        array(
                            'name' => 'car_make', 
                            'value' => $model->carMake->name
                        ),
                        array(
                            'name' => 'car_model', 
                            'value' => $model->carModel->name
                        ),
                        array(
                            'name' => 'car_sub_model', 
                            'value' => $model->carSubModel->name
                        ),
                        array(
                            'label' => 'Color', 
                            'value' => empty($model->color_id) ? '' : $model->color->name,
                        ),
                        'year',
                        'chasis.name: Chassis',
                        'notes',
                    ),
                )); ?>
            </div>
            
            <div class="small-12 columns">
                <?php if ($customers != "") : ?>
                    <h5>Customer</h5>
                    <table class="detail">
                        <tr>
                            <td>Name</td>
                            <td>Address</td>
                            <td>Province</td>
                            <td>City</td>
                            <td>Zipcode</td>
                            <td>Fax</td>
                            <td>Email</td>
                            <td>Note</td>
                            <td>Birthdate</td>
                        </tr>
                        
                        <?php foreach ($customers as $key => $customer): ?>
                            <tr>
                                <td><?php echo $customer->name; ?></td>
                                <td><?php echo $customer->address; ?></td>
                                <td><?php echo $customer->province_id != "" ? $customer->province->name : '-'; ?></td>
                                <td><?php echo $customer->city_id != "" ? $customer->city->name : '-'; ?></td>
                                <td><?php echo $customer->zipcode; ?></td>
                                <td><?php echo $customer->fax; ?></td>
                                <td><?php echo $customer->email; ?></td>
                                <td><?php echo $customer->note; ?></td>
                                <td><?php echo $customer->birthdate; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
            
            <div class="small-12 columns">
                <?php if ($picDetails != "") : ?>
                    <h5>Customer PIC</h5>
                    <table class="detail">
                        <tr>
                            <td>Name</td>
                            <td>Address</td>
                            <td>Province</td>
                            <td>City</td>
                            <td>Zipcode</td>
                            <td>Fax</td>
                            <td>Email</td>
                            <td>Note</td>
                            <td>Birthdate</td>
                        </tr>
                        <?php foreach ($picDetails as $key => $picDetail): ?>
                            <tr>
                                <td><?php echo $picDetail->name; ?></td>
                                <td><?php echo $picDetail->address; ?></td>
                                <td><?php echo $picDetail->province_id != "" ? $picDetail->province->name : '-'; ?></td>
                                <td><?php echo $picDetail->city_id != "" ? $picDetail->city->name : '-'; ?></td>
                                <td><?php echo $picDetail->zipcode; ?></td>
                                <td><?php echo $picDetail->fax; ?></td>
                                <td><?php echo $picDetail->email; ?></td>
                                <td><?php echo $picDetail->note; ?></td>
                                <td><?php echo $picDetail->birthdate; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<hr />
                
<div class="row">
    <div class="large-12 columns">
        <fieldset>
            <legend>Transaction History</legend>
            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'registration-transaction-grid',
                    'dataProvider' => $registrationTransactionDataProvider,
                    'filter' => $registrationTransaction,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'transaction_number',
                            'value' => 'CHtml::link($data->transaction_number, array("/frontDesk/registrationTransaction/view", "id"=>$data->id))',
                            'type' => 'raw'
                        ),
                        'transaction_date',
                        'repair_type',
                        'status',
                        array(
                            'name' => 'branch_id',
                            'header' => 'Branch',
                            'filter' => CHtml::activeDropDownList($registrationTransaction, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- all --')),
                            'value' => '$data->branch->name',
                        ),
                        array(
                            'name' => 'grand_total', 
                            'value' => 'AppHelper::formatMoney($data->grand_total)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                    ),
                )); ?>
            </div>
        </fieldset>
    </div>
</div>