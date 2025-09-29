<?php
/* @var $this InspectionModuleController */
/* @var $model InspectionModule */

$this->breadcrumbs = array(
    'Service',
    'Inspection Modules' => array('admin'),
    'View Inspection Module ' . $model->name, $model->name,
);

/* $this->menu=array(
  array('label'=>'List InspectionModule', 'url'=>array('index')),
  array('label'=>'Create InspectionModule', 'url'=>array('create')),
  array('label'=>'Update InspectionModule', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete InspectionModule', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage InspectionModule', 'url'=>array('admin')),
  ); */
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/inspectionModule/admin'; ?>"><span class="fa fa-th-list"></span>Manage Inspection Module</a>
        <?php if (Yii::app()->user->checkAccess("masterInspectionModuleEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>View <?php echo $model->name ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'code',
                'name',
                array(
                    'name' => 'checklist_type_id',
                    'value' => $model->checklistType->name,
                ),
            ),
        )); ?>
        
        <hr />
        
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sectionModules = InspectionSectionModule::model()->findAllByAttributes(array('module_id' => $model->id)); ?>
                    <?php foreach ($sectionModules as $sectionModule): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($sectionModule, 'section.code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($sectionModule, 'section.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>