<?php $this->breadcrumbs=array(
    'Service Group'=>array('admin'),
    'Create',
); ?>

<div class="form">
    <?php echo CHtml::beginForm(); ?>
	<div class="row">
        <div id="maincontent">
            <h2>Service Group</h2>
            <div id="service">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Standard Flat Rate</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($serviceGroup->header, 'name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($serviceGroup->header, 'standard_flat_rate')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($serviceGroup->header, 'description')); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <h2>Vehicle Model</h2>
            <?php echo CHtml::button('Tambah Vehicle', array('name' => 'Search', 'onclick' => '$("#vehicle-model-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#vehicle-model-dialog").dialog("open"); return false; }')); ?>
            <?php echo CHtml::hiddenField('VehicleModelId'); ?>
            
            <br /><br />
            
            <div id="detail_vehicle_div">
                <?php //$this->renderPartial('_detailVehicle', array('serviceGroup' => $serviceGroup)); ?>
            </div>
        </div>
    </div>
    
    <hr />
    
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'class'=>'button alert', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton('Save', array('name' => 'Submit', 'class'=>'button primary', 'confirm' => 'Are you sure you want to save?')); ?>
	</div>

    <?php echo CHtml::endForm(); ?>
</div>

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'vehicle-model-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Vehicle Model',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'vehicle-model-grid',
        'dataProvider' => $vehicleCarModelDataProvider,
        'filter' => $vehicleCarModel,
        'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',	
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns' => array(
            array(
                'id' => 'selectedIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'header' => 'Car Make',
                'filter' => false,
                'value' => 'CHtml::value($data, "carMake.name")',
            ),
            'name',
            'description',
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Vehicle Model', CController::createUrl('ajaxHtmlAddVehicleModels', array('id' => $serviceGroup->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_vehicle_div").html(html);
            $("#vehicle-model-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>
