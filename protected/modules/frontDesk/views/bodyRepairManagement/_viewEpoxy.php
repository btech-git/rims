<div class="clearfix page-action">
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Queue' => array(
                    'content' => $this->renderPartial('_viewEpoxyQueue', array(
                        'queueEpoxyDataProvider' => $queueEpoxyDataProvider,
                    ), true),
                ),
                'Assigned' => array(
                    'content' => $this->renderPartial('_viewEpoxyEmployeeAssignment', array(
                        'assignEpoxyDataProvider' => $assignEpoxyDataProvider,
                    ), true ),
                ),
                'On-Progress' => array(
                    'content' => $this->renderPartial('_viewEpoxyProgress', array(
                        'progressEpoxyDataProvider' => $progressEpoxyDataProvider,
                    ), true),
                ),
                'Ready to QC' => array(
                    'content' => $this->renderPartial('_viewEpoxyQualityControl', array(
                        'qualityControlEpoxyDataProvider' => $qualityControlEpoxyDataProvider,
                    ), true),
                ),
                'Finished' => array(
                    'content' => $this->renderPartial('_viewEpoxyFinished', array(
                        'finishedEpoxyDataProvider' => $finishedEpoxyDataProvider,
                    ), true),
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_epoxy',
        )); ?>
    </div>
</div>