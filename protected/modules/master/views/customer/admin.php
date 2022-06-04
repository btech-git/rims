<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->breadcrumbs=array(
	'Company',
 	'Customers'=>array('admin'),
	'Manage Customers',
);

$this->menu=array(
	array('label'=>'List Customer', 'url'=>array('index')),
	array('label'=>'Create Customer', 'url'=>array('create')),
);


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
	$('#customer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="maincontent">
<div class="clearfix page-action">
	<?php if (Yii::app()->user->checkAccess("masterCustomerCreate")) { ?>
		<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/customer/create';?>"><span class="fa fa-plus"></span>New Customer</a>
	<?php }?>
	<?php if (Yii::app()->user->checkAccess("masterCustomerEdit")) { ?>
		<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/customer/exportExcel';?>"><span class="fa fa-print"></span>Export Excel</a> &nbsp;
	<?php }?>
	<h1>Manage Customer</h1>
	<div class="search-bar">
		<div class="clearfix button-bar">
			<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>   
		</div>

		<div class="clearfix"></div>
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
		</div><!-- search-form -->
	</div>
			
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'customer-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager'=>array(
               'cssFile'=>false,
               'header'=>'',
            ),
            'columns'=>array(
                array (
                    'class' 		 => 'CCheckBoxColumn',
                    'selectableRows' => '2',	
                    'header'		 => 'Selected',	
                    'value' => '$data->id',				
                    ),
                array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
                array('header'=>'Province Name','name'=>'province_name', 'value'=>'$data->province->name'),
                array('header'=>'City Name','name'=>'city_name', 'value'=>'$data->city->name'),
                'email',
                array(
                    'header'=>'Customer Type', 
                    'name'=>'customer_type',
                    'value'=>'$data->customer_type',
                    'type'=>'raw',
                    'filter'=>CHtml::dropDownList('Customer[customer_type]', $model->customer_type, 
                        array(
                            ''=>'All',
                            'Company' => 'Company',
                            'Individual' => 'Individual',
                        )
                    ),
                ),
                array(
                    'header'=>'Status',
                    'name'=>'status',
                    'value'=>'$data->status',
                    'type'=>'raw',
                    'filter'=>CHtml::dropDownList('Customer[status]', $model->status, 
                        array(
                            ''=>'All',
                            'Active' => 'Active',
                            'Inactive' => 'Inactive',
                        )
                    ),
                ),
                array('name'=>'coa_name','value'=>'$data->coa!="" ? $data->coa->name : ""'),
                array('name'=>'coa_code','value'=>'$data->coa!="" ? $data->coa->code : ""'),
                'date_created',
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{edit} {export}',
                    'buttons'=>array (
                        'edit' => array (
                            'label'=>'edit',
                            'url'=>'Yii::app()->createUrl("master/customer/update", array("id"=>$data->id))',
                            'visible'=>'(Yii::app()->user->checkAccess("master.customer.update"))'

                        ),
                        'export' => array (
                            'label'=>'export',
                            'url'=>'Yii::app()->createUrl("master/customer/exportExcel", array("id"=>$data->id))',
                            'visible'=>'(Yii::app()->user->checkAccess("master.customer.export"))'
                        ),
                    ),
                ),
            ),
        )); ?>
        </div>
    </div>
    <!-- end maincontent -->
</div>