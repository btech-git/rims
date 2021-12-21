<div class="clearfix page-action">
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Queue' => array(
                    'content' => $this->renderPartial('_viewBongkarQueue', array(
                        'queueBongkarDataProvider' => $queueBongkarDataProvider,
                    ), true),
                ),
                'Assigned' => array(
                    'content' => $this->renderPartial('_viewBongkarEmployeeAssignment', array(
                        'assignBongkarDataProvider' => $assignBongkarDataProvider,
                    ), true ),
                ),
                'On-Progress' => array(
                    'content' => $this->renderPartial('_viewBongkarProgress', array(
                        'progressBongkarDataProvider' => $progressBongkarDataProvider,
                    ), true),
                ),
                'Ready to QC' => array(
                    'content' => $this->renderPartial('_viewBongkarQualityControl', array(
                        'qualityControlBongkarDataProvider' => $qualityControlBongkarDataProvider,
                    ), true),
                ),
                'Finished' => array(
                    'content' => $this->renderPartial('_viewBongkarFinished', array(
                        'finishedBongkarDataProvider' => $finishedBongkarDataProvider,
                    ), true),
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_bongkar',
        )); ?>
    </div>
</div>