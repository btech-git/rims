<?php
/* @var $this ForecastingController */
/* @var $model Forecasting */

$this->breadcrumbs=array(
	'Forecastings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Forecasting', 'url'=>array('index')),
	array('label'=>'Create Forecasting', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#forecasting-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
            <?php if (Yii::app()->user->checkAccess("accounting.forecasting.manage")) { ?>
                <a class="button success right" href="<?php echo Yii::app()->baseUrl.'/accounting/forecasting/test';?>"><span class="fa fa-th"></span>List/Export Xls</a>
                <?php } ?>
                <h2>Manage Forecastings</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search',array(
                            'model'=>$modelpo,
                            )); ?>
                        </div><!-- search-form -->
                    </div>
                 </div>

                 <div class="grid-view">

                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'forecasting-grid',
                    'dataProvider'=>$modelpo->search(),
                    'filter'=>$modelpo,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
                    'pager'=>array(
                       'cssFile'=>false,
                       'header'=>'',
                    ),
                    'columns'=>array(
                        array('name'=>'transaction_id', 'value'=>'CHTml::link($data->transaction_id, array("view", "id"=>$data->id))', 'type'=>'raw', 'filterHtmlOptions' =>array('class'=>'adaloh')),

                        array(
                            'name'=>'type_forecasting',
                            'value'=>'($data->type_forecasting == "po" ? "Purchase Order":($data->type_forecasting == "so"?"Sales Order":"Cash Transaction"))',
                            'filter'=>false,
                        ),
                        'due_date',
                        'payment_date',
                        'realization_date',
                        'amount',
                        array(
                            'header'=>'Status',
                            'value'=>'($data->status == "OK") ? "OK":"NOT OK"',
                        ),
                        'notes',
                        array(
                            'header'=>'Supplier',
                            'name'=>'supplier_name',
                            'value'=>'$data->transaction_po->supplier->name',
                        ),
                        array(
                            'header'=>'Bank',
                            'name'=>'bank_name',
                            'value'=>'empty($data->bank)?"":$data->bank->coa->name'
                        ),
                        array(
                            'class'=>'CButtonColumn',
                            'template'=>'{edit} {transaksi_po}',
                            'buttons'=>array (
                                'edit'=> array (
                                    'label'=>'edit',
                                    'url' =>'Yii::app()->createUrl("accounting/forecasting/update",array("id"=>$data->id))',
                                    'visible'=>'(Yii::app()->user->checkAccess("accounting.forecasting.admin"))',
                                ),
                                'transaksi_po'=> array (
                                    'label'=>'transaction',
                                    'url' =>'
                                                Yii::app()->createUrl("transaction/transactionPurchaseOrder/view",array("id"=>$data->transaction_id));
                                    ',
                                    'visible'=>'(Yii::app()->user->checkAccess("accounting.forecasting.admin")) AND ($data->type_forecasting == "po")',
                                ),
                            ),
                        ),
                    ),
                )); ?>

                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'forecastingso-grid',
                    'dataProvider'=>$modelso->search(),
                    'filter'=>$modelso,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
                    'pager'=>array(
                       'cssFile'=>false,
                       'header'=>'',
                    ),
                    'columns'=>array(
                        array('name'=>'transaction_id', 'value'=>'CHTml::link($data->transaction_id, array("view", "id"=>$data->id))', 'type'=>'raw', 'filterHtmlOptions' =>array('class'=>'adaloh')),
                        array(
                            'name'=>'type_forecasting',
                            'value'=>'($data->type_forecasting == "po" ? "Purchase Order":($data->type_forecasting == "so"?"Sales Order":"Cash Transaction"))',
                            'filter'=>false,
                        ),
                        'due_date',
                        'payment_date',
                        'realization_date',
                        'amount',
                        array (
                            'header'=>'Status',
                            'value'=>'($data->status == "OK") ? "OK":"NOT OK"',
                        ),
                        'notes',
                        array (
                            'header'=>'Customer',
                            'name'=>'customer_name',
                            'value'=>'CHtml::encode(CHtml::value($data, "transaction_so.customer.name"))',
                        ),
                        array (
                            'header'=>'Bank',
                            'name'=>'bank_name',
                            'value'=>'empty($data->bank)?"":$data->bank->coa->name'
                        ),
                        array(
                            'class'=>'CButtonColumn',
                            'template'=>'{edit} {transaksi_so}',
                            'buttons'=>array (
                                'edit'=> array (
                                    'label'=>'edit',
                                    'url' =>'Yii::app()->createUrl("accounting/forecasting/update",array("id"=>$data->id))',
                                    'visible'=>'(Yii::app()->user->checkAccess("accounting.forecasting.admin"))',
                                ),

                                'transaksi_so'=> array (
                                    'label'=>'transaction',
                                    'url' =>'
                                        Yii::app()->createUrl("transaction/transactionSalesOrder/view",array("id"=>$data->transaction_id));
                                    ',
                                    'visible'=>'(Yii::app()->user->checkAccess("accounting.forecasting.admin")) AND ($data->type_forecasting == "so")',
                                ),
                            ),
                        ),
                    ),
                )); ?>

                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'forecastingcash-grid',
                    'dataProvider'=>$modelcash->search(),
                    'filter'=>$modelcash,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
                    'pager'=>array(
                       'cssFile'=>false,
                       'header'=>'',
                    ),
                    'columns'=>array(
                        array('name'=>'transaction_id', 'value'=>'CHTml::link($data->transaction_id, array("view", "id"=>$data->id))', 'type'=>'raw', 'filterHtmlOptions' =>array('class'=>'adaloh')),

                        array(
                            'name'=>'type_forecasting',
                            'value'=>'($data->type_forecasting == "po" ? "Purchase Order":($data->type_forecasting == "so"?"Sales Order":"Cash Transaction"))',
                            'filter'=>false,
                        ),
                        'due_date',
                        'payment_date',
                        'realization_date',
                        'amount',
                        array (
                            'header'=>'Status',
                            'value'=>'($data->status == "OK") ? "OK":"NOT OK"',
                        ),
                        'notes',
                        array (
                            'header'=>'Bank',
                            'name'=>'coa_name',
                            'value'=>'empty($data->coa_id)?"":$data->coa->name'
                        ),
                        array(
                            'class'=>'CButtonColumn',
                            'template'=>'{edit} {transaksi_ci}{transaksi_co}',
                            'buttons'=>array (
                                'edit'=> array (
                                    'label'=>'edit',
                                    'url' =>'Yii::app()->createUrl("accounting/forecasting/update",array("id"=>$data->id))',
                                    'visible'=>'(Yii::app()->user->checkAccess("accounting.forecasting.admin"))',
                                ),
                                'transaksi_ci'=> array (
                                    'label'=>'transaction',
                                    'url' =>'
                                        Yii::app()->createUrl("transaction/cashTransaction/view",array("id"=>$data->transaction_id));
                                    ',
                                    'visible'=>'(Yii::app()->user->checkAccess("accounting.forecasting.admin")) AND ($data->type_forecasting == "cash_in")',
                                ),
                                'transaksi_co'=> array (
                                    'label'=>'transaction',
                                    'url' =>'
                                        Yii::app()->createUrl("transaction/cashTransaction/view",array("id"=>$data->transaction_id));
                                    ',
                                    'visible'=>'(Yii::app()->user->checkAccess("accounting.forecasting.admin")) AND ($data->type_forecasting == "cash_out")',
                                ),								
                            ),
                        ),
                    ),
                )); ?>
             </div>
         </div>
     </div>
 </div>