<?php
/* @var $this InspectionSectionController */
/* @var $model InspectionSection */

$this->breadcrumbs = array(
    'Service',
    'Inspection Sections' => array('admin'),
    'View Inspection Section ' . $model->name,
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/inspectionSection/admin'; ?>"><span class="fa fa-th-list"></span>Manage Inspection Section</a>
        <?php if (Yii::app()->user->checkAccess("masterInspectionSectionEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>View <?php echo $model->name ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'code',
                'name',
            ),
        )); ?>
        
        <hr />
        
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Inspection</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $inspectionSections = InspectionSections::model()->findAllByAttributes(array('section_id' => $model->id)); ?>
                    <?php foreach ($inspectionSections as $inspectionSection): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($inspectionSection, 'inspection.code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($inspectionSection, 'inspection.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Module</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sectionModules = InspectionSectionModule::model()->findAllByAttributes(array('section_id' => $model->id)); ?>
                    <?php foreach ($sectionModules as $sectionModule): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($sectionModule, 'module.code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($sectionModule, 'module.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($sectionModule, 'module.checklistType.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
