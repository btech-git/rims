<?php
/* @var $this InspectionController */
/* @var $model Inspection */

$this->breadcrumbs = array(
    'Service',
    'Inspections' => array('admin'),
    'View Inspection ' . $model->name,
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/inspection/admin'; ?>">
            <span class="fa fa-th-list"></span>Manage Inspection
        </a>
        <?php if (Yii::app()->user->checkAccess("masterInspectionEdit")) { ?>
            <a class="button warning right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>">
                <span class="fa fa-edit"></span>edit
            </a>
        <?php } ?>
            
        <?php echo CHtml::beginForm('', 'get'); ?>
        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel', 'class' => 'button success')); ?>
        <?php echo CHtml::endForm(); ?>
            
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
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $inspectionSections = InspectionSections::model()->findAllByAttributes(array('inspection_id' => $model->id)); ?>
                    <?php foreach ($inspectionSections as $inspectionSection): ?>
                        <?php $sectionModules = InspectionSectionModule::model()->findAllByAttributes(array('section_id' => $inspectionSection->section_id)); ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($inspectionSection, 'section.code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($inspectionSection, 'section.name')); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table>
                                    <?php foreach ($sectionModules as $sectionModule): ?>
                                        <tr>
                                            <td><?php echo CHtml::encode(CHtml::value($sectionModule, 'module.code')); ?></td>
                                            <td><?php echo CHtml::encode(CHtml::value($sectionModule, 'module.name')); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>