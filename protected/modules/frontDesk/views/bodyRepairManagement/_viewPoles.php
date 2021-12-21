<div class="clearfix page-action">
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Queue' => array(
                    'content' => $this->renderPartial('_viewPolesQueue', array(
                        'queuePolesDataProvider' => $queuePolesDataProvider,
                    ), true),
                ),
                'Assigned' => array(
                    'content' => $this->renderPartial('_viewPolesEmployeeAssignment', array(
                        'assignPolesDataProvider' => $assignPolesDataProvider,
                    ), true ),
                ),
                'On-Progress' => array(
                    'content' => $this->renderPartial('_viewPolesProgress', array(
                        'progressPolesDataProvider' => $progressPolesDataProvider,
                    ), true),
                ),
                'Ready to QC' => array(
                    'content' => $this->renderPartial('_viewPolesQualityControl', array(
                        'qualityControlPolesDataProvider' => $qualityControlPolesDataProvider,
                    ), true),
                ),
                'Finished' => array(
                    'content' => $this->renderPartial('_viewPolesFinished', array(
                        'finishedPolesDataProvider' => $finishedPolesDataProvider,
                    ), true),
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_poles',
        )); ?>
    </div>
</div>