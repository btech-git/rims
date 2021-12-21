<div class="clearfix page-action">
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Queue' => array(
                    'content' => $this->renderPartial('_viewPasangQueue', array(
                        'queuePasangDataProvider' => $queuePasangDataProvider,
                    ), true),
                ),
                'Assigned' => array(
                    'content' => $this->renderPartial('_viewPasangEmployeeAssignment', array(
                        'assignPasangDataProvider' => $assignPasangDataProvider,
                    ), true ),
                ),
                'On-Progress' => array(
                    'content' => $this->renderPartial('_viewPasangProgress', array(
                        'progressPasangDataProvider' => $progressPasangDataProvider,
                    ), true),
                ),
                'Ready to QC' => array(
                    'content' => $this->renderPartial('_viewPasangQualityControl', array(
                        'qualityControlPasangDataProvider' => $qualityControlPasangDataProvider,
                    ), true),
                ),
                'Finished' => array(
                    'content' => $this->renderPartial('_viewPasangFinished', array(
                        'finishedPasangDataProvider' => $finishedPasangDataProvider,
                    ), true),
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_pasang',
        )); ?>
    </div>
</div>