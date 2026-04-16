<?php
/* @var $this StockAdjustmentController */
/* @var $vehicleSystemCheck StockAdjustmentHeader */

$this->breadcrumbs = array(
    'Vehicle System Check' => array('admin'),
    $vehicleSystemCheck->id,
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id;
        $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage', Yii::app()->baseUrl . '/frontDesk/vehicleSystemCheck/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("maintenanceRequestCreate"))) ?>
        <?php //echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/frontDesk/vehicleSystemCheck/updateApproval?headerId=' . $vehicleSystemCheck->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>

        <h1>View Vehicle System Check #<?php echo $vehicleSystemCheck->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $vehicleSystemCheck,
            'attributes' => array(
                'id',
                'transaction_number',
                'transaction_date',
                array(
                    'label' => 'RG #',
                    'value' => $vehicleSystemCheck->registrationTransaction->transaction_number,
                ),
                array(
                    'label' => 'WO #',
                    'value' => $vehicleSystemCheck->registrationTransaction->work_order_number,
                ),
                array(
                    'label' => 'Customer',
                    'value' => $vehicleSystemCheck->registrationTransaction->customer->name,
                ),
                array(
                    'label' => 'Kendaraan',
                    'value' => $vehicleSystemCheck->registrationTransaction->vehicle->carMakeModelSubCombination,
                ),
                array(
                    'label' => 'Plat #',
                    'value' => $vehicleSystemCheck->registrationTransaction->vehicle->plate_number,
                ),
                array(
                    'label' => 'Warna',
                    'value' => $vehicleSystemCheck->registrationTransaction->vehicle->color->name,
                ),
                array(
                    'label' => 'Kilometer',
                    'value' => $vehicleSystemCheck->registrationTransaction->vehicle_mileage,
                ),
            ),
        )); ?>

        <hr />
        
        <h2>Detail Items</h2>
        
        <div id="detail_div">
            <?php $this->renderPartial('_viewDetailTire', array(
                'vehicleSystemCheck' => $vehicleSystemCheck,
                'vehicleSystemCheckTireDetails' => $vehicleSystemCheckTireDetails,
            )); ?>
        </div>

        <hr />
        
        <div id="detail_div">
            <?php $this->renderPartial('_viewDetailComponent', array(
                'vehicleSystemCheck' => $vehicleSystemCheck,
            )); ?>
        </div>

        <hr />
        
        <div class="row">
            <table>
                <tr>
                    <td>Penjelasan Body Repair</td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'body_repair_note')); ?></td>
                    <td>Rekomendasi Kondisi Kendaraan</td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'vehicle_condition_recommendation')); ?></td>
                </tr>
                <tr>
                    <td>Rekomendasi Service Selanjutnya</td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'next_service_recommendation')); ?></td>
                    <td>Periode / KM Service Selanjutnya</td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicleSystemCheck, 'next_service_kilometer')); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>