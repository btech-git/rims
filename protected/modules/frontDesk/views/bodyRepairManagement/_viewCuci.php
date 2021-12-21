<div class="clearfix page-action">
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Queue' => array(
                    'content' => $this->renderPartial('_viewCuciQueue', array(
                        'queueCuciDataProvider' => $queueCuciDataProvider,
                    ), true),
                ),
                'Assigned' => array(
                    'content' => $this->renderPartial('_viewCuciEmployeeAssignment', array(
                        'assignCuciDataProvider' => $assignCuciDataProvider,
                    ), true ),
                ),
                'On-Progress' => array(
                    'content' => $this->renderPartial('_viewCuciProgress', array(
                        'progressCuciDataProvider' => $progressCuciDataProvider,
                    ), true),
                ),
                'Ready to QC' => array(
                    'content' => $this->renderPartial('_viewCuciQualityControl', array(
                        'qualityControlCuciDataProvider' => $qualityControlCuciDataProvider,
                    ), true),
                ),
                'Finished' => array(
                    'content' => $this->renderPartial('_viewCuciFinished', array(
                        'finishedCuciDataProvider' => $finishedCuciDataProvider,
                    ), true),
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_cuci',
        )); ?>
    </div>
</div>