<?php
/* @var $this InsuranceCompanyController */
/* @var $model InsuranceCompany */

$this->breadcrumbs = array(
    'Company',
    'Insurance Companies' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List InsuranceCompany', 'url' => array('index')),
    array('label' => 'Create InsuranceCompany', 'url' => array('create')),
    array('label' => 'Update InsuranceCompany', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete InsuranceCompany', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage InsuranceCompany', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl . '/master/insuranceCompany/admin'; ?>"><span class="fa fa-th-list"></span>Manage Insurance Company</a>
        <?php if (Yii::app()->user->checkAccess("masterInsuranceEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>Insurance Company <?php echo $model->name ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'name',
                'address',
                array(
                    'label' => 'Province', 
                    'value' => $model->province_id != "" ? $model->province->name : ''
                ),
                array(
                    'label' => 'City', 
                    'value' => $model->city_id != "" ? $model->city->name : ''
                ),
                'email',
                'phone',
                'fax',
                'npwp',
                array(
                    'name' => 'coa_name', 
                    'value' => $model->coa != "" ? $model->coa->name : ''
                ),
                array(
                    'name' => 'coa_code', 
                    'value' => $model->coa != "" ? $model->coa->code : ''
                ),
            ),
        )); ?>
    </div>
</div>
<div class="row">
    <div class="small-12 columns">
        <h3>Price Lists</h3>
        <table >
            <thead>
                <tr>
                    <td>Service Type</td>
                    <td>Service Category</td>
                    <td>Service</td>
                    <td>Damage Type</td>
                    <td>Vehicle Type</td>
                    <td>Price</td>
                </tr>
            </thead>
            <?php foreach ($pricelists as $key => $pricelist): ?>
                <?php
                $service = Service::model()->findByPK($pricelist->service_id);
                $serviceType = ServiceType::model()->findByPK($service->service_type_id);
                $serviceCategory = ServiceCategory::model()->findByPK($service->service_category_id);
                ?>					
                <tr>
                    <td><?php echo $serviceType->name; ?></td>	
                    <td><?php echo $serviceCategory->name; ?></td>
                    <td><?php echo $service->name; ?></td>
                    <td><?php echo $pricelist->damage_type; ?></td>
                    <td><?php echo $pricelist->vehicle_type; ?></td>
                    <td><?php echo number_format($pricelist->price, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<fieldset>
    <legend>Vehicle List</legend>
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'registration-grid',
            'dataProvider' => $registrationTransactionDataProvider,
            'filter' => null,
            // 'summaryText'=>'',
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'header' => 'Plate #', 
                    'value' => 'empty($data->vehicle_id) ? "" : $data->vehicle->plate_number', 
                ),
                array(
                    'header' => 'Customer', 
                    'value' => 'empty($data->customer_id) ? "" : $data->customer->name', 
                ),
                array(
                    'header' => 'Car Make', 
                    'value' => 'empty($data->vehicle_id) ? "" : $data->vehicle->carMake->name', 
                ),
                array(
                    'header' => 'Model', 
                    'value' => 'empty($data->vehicle_id) ? "" : $data->vehicle->carModel->name', 
                ),
                array(
                    'header' => 'Sub Model', 
                    'value' => 'empty($data->vehicle_id) ? "" : $data->vehicle->carSubModel->name', 
                ),
            )
        )); ?>
    </div>
</fieldset>
