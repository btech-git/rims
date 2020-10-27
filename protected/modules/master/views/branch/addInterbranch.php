<?php $this->breadcrumbs=array(
    'Branch'=>array('admin'),
    'Add Coa Interbranch',
); ?>

<div class="form">
    <?php echo CHtml::beginForm(); ?>
	<div class="row">
        <?php echo CHtml::errorSummary($branch->header); ?>
        <div id="maincontent">
            <h2>Branch Asal</h2>
            <div id="branch">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Province</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($branch->header, 'code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($branch->header, 'name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($branch->header, 'address')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($branch->header, 'city.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($branch->header, 'province.name')); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <h2>Branch Tujuan</h2>
            <?php echo CHtml::button('Tambah Branch', array(
                'id' => 'btn_branch',
                'name' => 'Search',
                'onclick' => '$("#branch-dialog").dialog("open"); return false;',
                'onkeypress' => 'if (event.keyCode == 13) { $("#search-dialog").dialog("open"); return false; }'
            )); ?>
            <?php echo CHtml::hiddenField('BranchId'); ?>
            
            <br /><br />
            
            <div id="detail_div">
                <?php $this->renderPartial('_detailInterbranch', array(
                    'branch' => $branch,
                )); ?>
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

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'branch-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Branch Tujuan',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'branch-grid',
        'dataProvider' => $interbranchDataProvider,
        'filter' => null,
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
            'address',
            array(
                'name'=>'province_id', 
                'value'=>'$data->province->name',
            ),
            array(
                'name'=>'city_id', 
                'value'=>'$data->city->name',
            ),
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Interbranch', CController::createUrl('ajaxHtmlAddInterbranches', array('id' => $branch->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#branch-dialog").dialog("close");
        }'
    )); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>