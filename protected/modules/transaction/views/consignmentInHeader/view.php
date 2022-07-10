<?php
/* @var $this ConsignmentInHeaderController */
/* @var $model ConsignmentInHeader */

$this->breadcrumbs=array(
	'Consignment In Headers'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ConsignmentInHeader', 'url'=>array('admin')),
	array('label'=>'Create ConsignmentInHeader', 'url'=>array('create')),
	array('label'=>'Update ConsignmentInHeader', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ConsignmentInHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Consignment In', 'url'=>array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Consignment In', Yii::app()->baseUrl.'/transaction/consignmentInHeader/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("transaction.consignmentInHeader.admin"))) ?>

        <?php if($model->status_document != 'Approved' && $model->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/consignmentInHeader/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.consignmentInHeader.update"))) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/transaction/consignmentInHeader/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.consignmentInHeader.updateApproval"))) ?>
        <?php endif; ?>

        <h1>View Consignment In #<?php echo $model->consignment_in_number; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'consignment_in_number',
                'date_posting',
                'status_document',
                array('name'=>'supplier_name','value'=>$model->supplier->name,),
                'date_arrival',
                'user.username',
                'receiveBranch.name',
                ),
        )); ?>
    </div>
</div>

<br />

<div class="detail">
    <?php 
    $tabsArray = array(); 

    $tabsArray['Detail Item'] = array(
        'id'=>'test1',
        'content'=>$this->renderPartial('_viewDetail', array(
            'model' => $model,
            'details'=>$details
        ),TRUE)
    );
    $tabsArray['Detail Approval'] = array(
        'id'=>'test2',
        'content'=>$this->renderPartial('_viewDetailApproval', array(
            'historis'=>$historis
        ),TRUE)
    );
    if (Yii::app()->user->checkAccess("generalManager")) {
        $tabsArray['Journal'] = array(
            'id'=>'test3',
            'content'=>$this->renderPartial('_viewJournal', array(
                'model' => $model,
            ),TRUE)
        );
    }
    ?>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => $tabsArray,
        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id'=>'view_tab',
    )); ?>
</div>
