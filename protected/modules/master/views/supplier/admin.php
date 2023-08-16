<?php
/* @var $this SupplierController */
/* @var $model Supplier */

$this->breadcrumbs = array(
    'Company',
    'Suppliers' => array('admin'),
    'Manage Suppliers',
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
    $('#supplier-grid').yiiGridView('update', {
            data: $(this).serialize()
    });
    
    return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterSupplierCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/supplier/create'; ?>"><span class="fa fa-plus"></span>New Supplier</a>
        <?php } ?>
        <h1>Manage Supplier</h1>

        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'supplier-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array('name' => 'name', 'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type' => 'raw'),
                    'date',
                    'code',
                    'company',
                    'person_in_charge',
                    'phone',
                    'position',
                    array('name' => 'coa_name', 'value' => '$data->coa!=""?$data->coa->name : ""'),
                    array('name' => 'coa_code', 'value' => '$data->coa!=""?$data->coa->code : ""'),
                    array('name' => 'coa_outstanding_name', 'value' => '$data->coaOutstandingOrder!=""?$data->coaOutstandingOrder->name : ""'),
                    array('name' => 'coa_outstanding_code', 'value' => '$data->coaOutstandingOrder!=""?$data->coaOutstandingOrder->code : ""'),
                    array('name'=>'user_id', 'value'=>'$data->user->username'),
                    array('header' => 'Input', 'value' => '$data->createdDatetime'),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit}',
                        'buttons' => array(
                            'edit' => array(
                                'label' => 'edit',
                                'visible' => '(Yii::app()->user->checkAccess("master.supplier.update"))',
                                'url' => 'Yii::app()->createUrl("master/supplier/update", array("id"=>$data->id))',
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
<!-- end maincontent -->