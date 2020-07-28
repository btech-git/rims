<?php
/* @var $this SupplierController */
/* @var $model Supplier */

$this->breadcrumbs = array(
    'Company',
    'Suppliers' => array('admin'),
    'Manage Suppliers',
);

// $this->menu=array(
// 	array('label'=>'List Supplier', 'url'=>array('index')),
// 	array('label'=>'Create Supplier', 'url'=>array('create')),
// );
// Yii::app()->clientScript->registerScript('search', "
// $('.search-button').click(function(){
// 	$('.search-form').toggle();
// 	return false;
// });
// $('.search-form form').submit(function(){
// 	$('#supplier-grid').yiiGridView('update', {
// 		data: $(this).serialize()
// 	});
// 	return false;
// });
// ");

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
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
        <?php if (Yii::app()->user->checkAccess("master.supplier.create")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/supplier/create'; ?>"><span class="fa fa-plus"></span>New Supplier</a>
        <?php } ?>
        <h1>Manage Supplier</h1>


        <div class="search-bar">
<!--            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>   
            </div>-->

            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php /*$this->renderPartial('_search', array(
                    'model' => $model,
                ));*/ ?>
            </div><!-- search-form -->
        </div>
    </div>


    <div class="grid-view">

        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'supplier-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            // 'summaryText' => '',
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                //'id',
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
                /*
                  'address',
                  'province_id',
                  'city_id',
                  'zipcode',
                  'fax',
                  'email_personal',
                  'email_company',
                  'npwp',
                  'description',
                  'tenor',
                 */
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{edit}',
                    'buttons' => array
                        (
                        'edit' => array
                            (
                            'label' => 'edit',
                            'visible' => '(Yii::app()->user->checkAccess("master.supplier.update"))',
                            'url' => 'Yii::app()->createUrl("master/supplier/update", array("id"=>$data->id))',
                        ),
                    ),
                ),
            ),
        ));
        ?>
    </div>
</div>
<!-- end maincontent -->