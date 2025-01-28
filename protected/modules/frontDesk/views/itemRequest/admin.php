<?php
/* @var $this ItemRequestController */
/* @var $model ItemRequest */

$this->breadcrumbs=array(
    'Item Requests'=>array('admin'),
    'Manage',
);

$this->menu=array(
    //array('label'=>'List ItemRequest', 'url'=>array('index')),
    array('label'=>'Create ItemRequest', 'url'=>array('create')),
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
        $('#item-request-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        
        return false;
    });
"); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New', Yii::app()->baseUrl.'/frontDesk/itemRequest/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("itemRequestCreate"))) ?> &nbsp;&nbsp;&nbsp;
        <h1>Manage  Permintaan Barang non stock</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                    'model'=>$model,
                )); ?>
                </div><!-- search-form -->				
            </div>
         </div>

         <div class="grid-view">

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'item-request-grid',
                'dataProvider'=>$dataProvider,
                'filter'=>null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile'=>false,
                    'header'=>'',
                ),
                'columns' => array(
                    array(
                        'name'=>'transaction_number', 
                        'value'=>'CHTml::link($data->transaction_number, array("view", "id"=>$data->id))', 
                        'type'=>'raw',
                    ),
                    'transaction_date',
                    array(
                        'header' => 'Status Document',
                        'value' => '$data->status_document',
                    ),
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'filter' => false,
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                    ),
                    array(
                        'name'=>'user_id',
                        'filter' => CHtml::activeDropDownList($model, 'user_id', CHtml::listData(Users::model()->findAll(), 'id', 'name'), array('empty' => '-- All --')),
                        'value'=>'$data->user->username',
                    ),
//                    array(
//                        'class'=>'CButtonColumn',
//                        'template'=>'{edit}',
//                        'buttons'=>array (
//                            'edit' => array (
//                                'label'=>'edit',
//                                'url'=>'Yii::app()->createUrl("frontDesk/itemRequest/update", array("id"=>$data->id))',
//                                'visible'=> 'Yii::app()->user->checkAccess("itemRequestEdit")', //$data->status_document != "Approved" && $data->status_document != "Rejected" && ',
//                            ),
//                        ),
//                    ),
                ),
            )); ?>
        </div>
    </div>
</div>