
<div class="small-12 columns">
    <div id="maincontent">
        <div class="clearfix page-action">
            <h3>View Employee Time Sheet #<?php echo $model->id; ?></h3>
            
            <div class="row">
                <div class="large-12 columns">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                        'data'=>$model,
                        'attributes'=>array(
                            'id',
                            'employee.name',
                            array(
                                'name' => 'date',
                                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::encode(CHtml::value($model, 'date'))),
                            ),
                            'clock_in',
                            'clock_out',
                            array(
                                'name' => 'duration_late',
                                'value' => CHtml::encode(CHtml::value($model, 'lateTimeDiff')),
                            ),
                            array(
                                'name' => 'duration_work',
                                'value' => CHtml::encode(CHtml::value($model, 'workTimeDiff')),
                            ),
                            array(
                                'label' => 'Status',
                                'value' => CHtml::encode(CHtml::value($model, 'employeeOnleaveCategory.name')),
                            ),
                            array(
                                'label' => 'Overtime Approval',
                                'value' => CHtml::encode(CHtml::value($model, 'overtimeApprovalStatus')),
                            )
                        ),
                    )); ?>
                </div>
            </div>
            
            <fieldset>
                <legend>Attached Images</legend>

                <?php if (!empty($postImages)): ?>
                    <?php $postImage = $postImages[count($postImages) - 1]; ?>
                    <?php $src = Yii::app()->baseUrl . '/images/uploads/employeeTimesheet/' . $postImage->filename; ?>
                    <div class="row">
                        <div class="small-3 columns">
                            <div style="margin-bottom:.5rem">
                                <?php echo CHtml::image($src, $model->employee->name . "Image"); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </fieldset>

            <?php if ((int) $model->is_overtime_approved === 0): ?>
                <div>
                    <div class="field buttons text-center">
                        <?php echo CHtml::beginForm(); ?>
                        <?php echo CHtml::submitButton('Reject Overtime', array(
                            'name' => 'Reject',
                            'class' => 'button alert left', 
                            'style' => 'margin-left:10px',
                            'confirm' => 'Are you sure you want to reject this overtime?', 
                        )); ?>
                        <?php echo CHtml::submitButton('Approve Overtime', array(
                            'name' => 'Approve', 
                            'class' => 'button success left',
                            'style' => 'margin-left:10px',
                            'confirm' => 'Are you sure you want to approve this overtime?',
                        )); ?>
                        <?php echo CHtml::endForm(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>