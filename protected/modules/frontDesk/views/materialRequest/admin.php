<?php
/* @var $this MaterialRequestController */
/* @var $model MaterialRequest */

$this->breadcrumbs=array(
    'Material Requests'=>array('admin'),
    'Manage',
);

$this->menu=array(
    //array('label'=>'List MaterialRequest', 'url'=>array('index')),
    array('label'=>'Create MaterialRequest', 'url'=>array('create')),
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
        $('#material-request-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        
        return false;
    });
"); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Permintaan Bahan WO', Yii::app()->baseUrl.'/frontDesk/materialRequest/create', array('class'=>'button success center', 'visible'=>Yii::app()->user->checkAccess("materialRequestCreate"))) ?> &nbsp;&nbsp;&nbsp;
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Permintaan Bahan Bulk', Yii::app()->baseUrl.'/frontDesk/materialRequest/createIndependent', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("materialRequestCreate"))) ?>
        <h1>Manage  Permintaan Bahan</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                    'model'=>$model,
                    'plateNumber' => $plateNumber,
                )); ?>
                </div><!-- search-form -->				
            </div>
         </div>

         <div class="grid-view">

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'material-request-grid',
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
//                    array(
//                        'name'=>'branch_id',
//                        'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
//                        'value'=>'$data->branch->code',
//                    ),
                    array(
                        'header' => 'Plate #',
                        'value' => 'empty($data->registration_transaction_id) ? "" : $data->registrationTransaction->vehicle->plate_number',
                    ),
                    array(
                        'header' => 'Status Document',
                        'value' => '$data->status_document',
                    ),
                    array(
                        'header' => 'Status Progress',
                        'value' => '$data->status_progress',
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
//                                'url'=>'Yii::app()->createUrl("frontDesk/materialRequest/update", array("id"=>$data->id))',
//                                'visible'=> 'Yii::app()->user->checkAccess("materialRequestEdit")', //$data->status_document != "Approved" && $data->status_document != "Rejected" && ',
//                            ),
//                        ),
//                    ),
                ),
            )); ?>
        </div>
    </div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
</script>