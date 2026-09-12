<?php
/* @var $this CoaSubCategoryController */
/* @var $model CoaSubCategory */

$this->breadcrumbs = array(
    'Coa Sub Categories' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List CoaSubCategory', 'url' => array('index')),
    array('label' => 'Create CoaSubCategory', 'url' => array('create')),
    array('label' => 'Update CoaSubCategory', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete CoaSubCategory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage CoaSubCategory', 'url' => array('admin')),
);
?>

<!--<h1>View CoaSubCategory #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl . '/master/coaSubCategory/admin'; ?>">
            <span class="fa fa-th-list"></span>Manage
        </a>
        <?php if (Yii::app()->user->checkAccess("masterCoaSubCategoryEdit")) { ?>
            <a class="button warning right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>">
                <span class="fa fa-edit"></span>edit
            </a>
        <?php } ?>
            
        <h1>View Coa Sub Category #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'code',
                'name',
                array(
                    'label' => 'Category',
                    'name' => 'coa_category_id', 
                    'value' => $model->coaCategory->name
                ),
                array(
                    'label' => 'Posisi Cashflow',
                    'name' => 'cashflow_position', 
                    'value' => $model->cashflow_position
                ),
            ),
        )); ?>
    </div>
</div>