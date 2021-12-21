<div class="clearfix page-action">
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Queue' => array(
                    'content' => $this->renderPartial('_viewCatQueue', array(
                        'queueCatDataProvider' => $queueCatDataProvider,
                    ), true),
                ),
                'Assigned' => array(
                    'content' => $this->renderPartial('_viewCatEmployeeAssignment', array(
                        'assignCatDataProvider' => $assignCatDataProvider,
                    ), true ),
                ),
                'On-Progress' => array(
                    'content' => $this->renderPartial('_viewCatProgress', array(
                        'progressCatDataProvider' => $progressCatDataProvider,
                    ), true),
                ),
                'Ready to QC' => array(
                    'content' => $this->renderPartial('_viewCatQualityControl', array(
                        'qualityControlCatDataProvider' => $qualityControlCatDataProvider,
                    ), true),
                ),
                'Finished' => array(
                    'content' => $this->renderPartial('_viewCatFinished', array(
                        'finishedCatDataProvider' => $finishedCatDataProvider,
                    ), true),
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_cat',
        )); ?>
    </div>
</div>