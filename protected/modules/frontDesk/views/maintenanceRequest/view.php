<?php
/* @var $this StockAdjustmentController */
/* @var $maintenanceRequest StockAdjustmentHeader */

$this->breadcrumbs = array(
    'Maintenance Request' => array('admin'),
    $maintenanceRequest->id,
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id;
        $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Maintenance Request', Yii::app()->baseUrl . '/frontDesk/maintenanceRequest/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("maintenanceRequestCreate"))) ?>

        <h1>View Maintenance Request #<?php echo $maintenanceRequest->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $maintenanceRequest,
            'attributes' => array(
                'id',
                'transaction_number',
                'transaction_time',
                'maintenance_type',
                'description',
                'status',
                array(
                    'name' => 'branch_id',
                    'header' => 'Branch',
                    'value' => $maintenanceRequest->branch->name,
                ),
                array(
                    'name' => 'user_id_requestor',
                    'header' => 'Requestor',
                    'value' => $maintenanceRequest->userIdRequestor->username,
                ),
                array(
                    'name' => 'user_id_supervisor',
                    'header' => 'Requestor',
                    'value' => empty($maintenanceRequest->user_id_supervisor) ? 'N/A' : $maintenanceRequest->userIdSupervisor->username,
                ),
                array(
                    'name' => 'user_id',
                    'header' => 'User',
                    'value' => $maintenanceRequest->user->username,
                ),
                'note',
            ),
        )); ?>

        <hr />
        
        <h2>Detail Items</h2>
        
        <div class="row">
            <div class="small-12 columns">
                <div style="max-width: 90em; width: 100%;">
                    <div style="overflow-y: hidden; margin-bottom: 1.25rem;">
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'maintenance-request-detail-grid',
                            'dataProvider' => new CArrayDataProvider($maintenanceRequestDetails),
                            'columns' => array(
                                'item_name: Nama Item',
                                'item_code: Kode Item',
                                'quantity',
                                'memo',
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="small-12 columns">
                <?php //$this->renderPartial('_approval', array('listApproval' => $listApproval)); ?>
            </div>
        </div>
    </div>
</div>