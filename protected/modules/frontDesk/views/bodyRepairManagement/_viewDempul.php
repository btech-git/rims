<div class="clearfix page-action">
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Queue' => array(
                    'content' => $this->renderPartial('_viewDempulQueue', array(
                        'queueDempulDataProvider' => $queueDempulDataProvider,
                    ), true),
                ),
                'Assigned' => array(
                    'content' => $this->renderPartial('_viewDempulEmployeeAssignment', array(
                        'assignDempulDataProvider' => $assignDempulDataProvider,
                    ), true ),
                ),
                'On-Progress' => array(
                    'content' => $this->renderPartial('_viewDempulProgress', array(
                        'progressDempulDataProvider' => $progressDempulDataProvider,
                    ), true),
                ),
                'Ready to QC' => array(
                    'content' => $this->renderPartial('_viewDempulQualityControl', array(
                        'qualityControlDempulDataProvider' => $qualityControlDempulDataProvider,
                    ), true),
                ),
                'Finished' => array(
                    'content' => $this->renderPartial('_viewDempulFinished', array(
                        'finishedDempulDataProvider' => $finishedDempulDataProvider,
                    ), true),
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_dempul',
        )); ?>
    </div>
</div>