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
                        <a href="<?php echo Yii::app()->baseUrl . '/site/index'; ?>">Home</a>
                        <a href="<?php echo Yii::app()->baseUrl . '/master/vehicle/admin'; ?>">Vehicle</a>
                        <a href="<?php echo Yii::app()->baseUrl . '/master/vehicle/admin'; ?>">Vehicles</a>
                        <span>View Vehicles</span>
                </div>
        </div>
</div>-->

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/vehicle/admin'; ?>"><span class="fa fa-th-list"></span>Manage Vehicles</a>
        <?php if (Yii::app()->user->checkAccess("master.vehicle.update")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>		
        <?php } ?>
        <?php if (Yii::app()->user->checkAccess("master.registrationTransaction.create")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/registrationTransaction/create', array('type' => 2, 'id' => $model->id)); ?>"><span class="fa fa-plus"></span>Registration</a>
        <?php } ?>
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
                            'value' => $model->color->name
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
            <?php foreach ($registrationTransactions as $i => $regDetail): ?>
                <div class="row">
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction #</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Branch</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $regDetail->transaction_number; ?></td>
                                <td><?php echo $regDetail->transaction_date; ?></td>
                                <td><?php echo $regDetail->repair_type; ?></td>
                                <td><?php echo $regDetail->branch_id != "" ? $regDetail->branch->name : ''; ?></td>
                                <td><?php echo Yii::app()->numberFormatter->format("#,##0.00", $regDetail->grand_total); ?></td>
                                <td><?php echo $regDetail->status; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="large-6 columns">
                        <div class="row">
                            <div class="small-4 columns">Details</b></div>
                            <div class="small-8 columns">
                                <?php echo CHtml::tag('button', array(
                                    // 'name'=>'btnSubmit',
                                    'type' => 'button',
                                    'class' => 'hello button expand',
                                    'onclick' => '$("#transaction-detail-' . $i . '").toggle();'
                                ), '<span class="fa fa-caret-down"></span> Detail'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="transaction-detail-<?php echo $i ?>" class="hide">
                    <div class="large-12 columns">
                        <table>
                            <caption>Service</caption>
                            <thead>
                                <th>Service name</th>
                                <th>Claim</th>
                                <th>Price</th>
                                <th>Discount Type</th>
                                <th>Discount Price</th>
                                <th>Total Price</th>
                                <th>Hour</th>
                            </thead>
                            <tbody>
                                <?php foreach ($regDetail->registrationServices as $key => $service): ?>
                                    <?php if ($service->is_body_repair == 0 && $service->is_quick_service == 0) : ?>
                                        <tr>
                                            <td><?php echo $service->service->name; ?></td>
                                            <td><?php echo $service->claim; ?></td>
                                            <td><?php echo number_format($service->price, 2); ?></td>
                                            <td><?php echo $service->discount_type; ?></td>
                                            <td><?php echo $service->discount_type == 'Percent' ? $service->discount_price : number_format($service->discount_price, 0); ?></td>
                                            <td><?php echo number_format($service->total_price, 2); ?></td>
                                            <td><?php echo $service->hour; ?></td>

                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="large-12 columns">
                        <table>
                            <caption>Product</caption>
                            <thead>
                                <tr>
                                    <th>Product name</th>
                                    <th>Quantity</th>
                                    <th>Retail Price</th>
                                    <th>HPP</th>
                                    <th>Sale Price</th>
                                    <th>Discount Type</th>
                                    <th>Discount</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($regDetail->registrationProducts as $key => $product): ?>
                                    <?php if ($product->is_material == 0): ?>
                                        <tr>
                                            <td><?php echo $product->product->name; ?></td>
                                            <td><?php echo $product->quantity; ?></td>
                                            <td><?php echo number_format($product->retail_price, 2); ?></td>
                                            <td><?php echo number_format($product->hpp, 2); ?></td>
                                            <td><?php echo number_format($product->sale_price, 2); ?></td>
                                            <td><?php echo $product->discount_type; ?></td>
                                            <td><?php echo $product->discount_type == 'Percent' ? $product->discount : number_format($product->discount, 0); ?></td>
                                            <td><?php echo number_format($product->total_price, 2); ?></td>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="large-12 columns">
                        <table>
                            <thead>
                                <tr>
                                    <th>Inspection Date</th>
                                    <th>Inspection</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($model->vehicleInspections as $key => $inspectionDetail): ?>
                                    <tr>
                                        <td><?php echo $inspectionDetail->inspection_date; ?></td>
                                        <td><?php echo $inspectionDetail->inspection->name; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            <?php endforeach; ?>
        </fieldset>
    </div>
</div>