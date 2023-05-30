<?php
/* @var $this MovementInHeaderController */
/* @var $model MovementInHeader */

$this->breadcrumbs = array(
    'Movement In' => array('admin'),
    'Manage',
);

/* $this->menu=array(
  array('label'=>'List MovementInHeader', 'url'=>array('index')),
  array('label'=>'Create MovementInHeader', 'url'=>array('create')),
  ); */

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
	$('#movement-in-header-grid').yiiGridView('update', {
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
                <?php //echo CHtml::link('<span class="fa fa-plus"></span>New Movement In', Yii::app()->baseUrl . '/transaction/movementInHeader/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("transaction.movementInHeader.create"))) ?>
                <h2>Manage Movement In</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>					
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
                    'id' => 'movement-in-header-grid',
                    'dataProvider' => $model->search(),
                    'filter' => null,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'movement_in_number',
                            'value' => 'CHTml::link($data->movement_in_number, array("view", "id"=>$data->id))',
                            'type' => 'raw'
                        ),
                        'date_posting',
                        array(
                            'name' => 'branch_id',
                            'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value' => '$data->branch->name'
                        ),
                        array(
                            'name' => 'receive_item_number',
                            'value' => '(!empty($data->receiveItem->receive_item_no)?$data->receiveItem->receive_item_no:"")'
                        ),
                        array(
                            'name' => 'return_item_number',
                            'value' => '(!empty($data->returnItem->return_item_no)?$data->returnItem->return_item_no:"")'
                        ),
                        'status',
                        array(
                            'header' => 'Input',
                            'name' => 'created_datetime',
                            'filter' => false,
                            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{edit}',
                            'buttons' => array(
                                'edit' => array(
                                    'label' => 'edit',
                                    'url' => 'Yii::app()->createUrl("transaction/movementInHeader/update", array("id"=>$data->id))',
//                                    'visible' => '($data->status != "Approved") && $data->status != "Rejected" && ($data->status != "Delivered") && ($data->status != "Finished" ) && Yii::app()->user->checkAccess("movementInEdit")',
                                ),
                            ),
                        ),
                    ),
                )); ?>
            </div>
            
            <fieldset>
                <legend>Pending Orders</legend>
                <div>
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Receive Item' => array(
                                'content' => $this->renderPartial('_viewReceive', array(
                                    'receiveItem' => $receiveItem,
                                    'receiveItemDataProvider' => $receiveItemDataProvider,
                                ), true)
                            ),
                            'Return Penjualan' => array(
                                'content' => $this->renderPartial('_viewReturn', array(
                                    'returnItem' => $returnItem,
                                    'returnItemDataProvider' => $returnItemDataProvider,
                                ), true)
                            ),
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab',
                    )); ?>
                </div>
            </fieldset>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->