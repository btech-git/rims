<?php
/* @var $this BranchController */
/* @var $model Branch */

$this->breadcrumbs = array(
    'Company',
    'Branches' => array('admin'),
    'Manage Branches',
);

$this->menu = array(
    array('label' => 'List Branch', 'url' => array('index')),
    array('label' => 'Create Branch', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle(600);
    $('.bulk-action').toggle();
    $(this).toggleClass('active');
    
    if ($(this).hasClass('active')) {
        $(this).text('');
    } else {
        $(this).text('Advanced Search');
    }
    return false;
});

$('.search-form form').submit(function(){
    $('#branch-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<div class="row">
    <div class="small-12 columns">
        <div id="maincontent">
            <div class="row">
                <div class="small-12 columns">		
                    <div class="clearfix page-action">
                        <?php if (Yii::app()->user->checkAccess("master.branch.create")) { ?>
                            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/branch/create'; ?>"><span class="fa fa-plus"></span>New Branch</a>
                        <?php } ?>
                        <h2>Manage Branch</h2>
                    </div>

                    <div class="search-bar">
                        <div class="clearfix button-bar">
                            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>  
                            <div class="clearfix"></div>
                            <div class="search-form" style="display:none">
                                <?php $this->renderPartial('_search', array(
                                    'model' => $model,
                                )); ?>
                            </div><!-- search-form -->
                        </div>
                    </div>
                    
                    <div class="grid-view">
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'branch-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                            'pager' => array(
                                'cssFile' => false,
                                'header' => '',
                            ),
                            'columns' => array(
                                //'id',
                                array(
                                    'class' => 'CCheckBoxColumn',
                                    'selectableRows' => '2',
                                    'header' => 'Selected',
                                    'value' => '$data->id',
                                ),
                                array('name' => 'name', 'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type' => 'raw'),
                                array('name' => 'company', 'value' => '$data->company!=""?$data->company->name:""'),
                                'coa_prefix',
                                'code',
                                'address',
                                array('name' => 'province_name', 'value' => '$data->province->name'),
                                array('name' => 'city_name', 'value' => '$data->city->name'),
                                array('name' => 'coa_interbranch_inventory_code', 'value' => '$data->coaInterbranchInventory == null?"":$data->coaInterbranchInventory->code'),
                                array('name' => 'coa_interbranch_inventory_name', 'value' => '$data->coaInterbranchInventory == null?"":$data->coaInterbranchInventory->name'),
                                'zipcode',
                                array(
                                    'header' => 'Status',
                                    'name' => 'status',
                                    'value' => '$data->status',
                                    'type' => 'raw',
                                    'filter' => CHtml::dropDownList('Branch[status]', $model->status, array(
                                        '' => 'All',
                                        'Active' => 'Active',
                                        'Inactive' => 'Inactive',
                                            )
                                    ),
                                ),
                                array(
                                    'class' => 'CButtonColumn',
                                    'template' => '{edit}',
                                    'buttons' => array(
                                        'edit' => array(
                                            'label' => 'edit',
                                            'url' => 'Yii::app()->createUrl("master/branch/update",array("id"=>$data->id))',
                                            'visible' => '(Yii::app()->user->checkAccess("masterBranchEdit"))'
                                        ),
                                    ),
                                ),
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
            <!-- end maincontent -->
        </div>
    </div>
</div>