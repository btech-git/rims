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
            
            <h2>Service</h2>
            <?php echo CHtml::button('Tambah Service', array('name' => 'Search', 'onclick' => '$("#service-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#service-dialog").dialog("open"); return false; }')); ?>
            <?php echo CHtml::hiddenField('ServiceId'); ?>
            
            <br /><br />
            
            <div id="detail_vehicle_div">
                <?php $this->renderPartial('_detailService', array('serviceGroup' => $serviceGroup)); ?>
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
        'id' => 'service-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Service',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'service-grid',
        'dataProvider' => $serviceDataProvider,
        'filter' => $service,
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
            'code',
            'name',
            array(
                'header' => 'Category',
                'filter' => false,
                'value' => 'CHtml::value($data, "serviceCategory.name")',
            ),
            array(
                'header' => 'Type',
                'filter' => false,
                'value' => 'CHtml::value($data, "serviceType.name")',
            ),
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Service', CController::createUrl('ajaxHtmlAddServices', array('id' => $serviceGroup->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_service_div").html(html);
            $("#service-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>