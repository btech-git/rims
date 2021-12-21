<div class="clearfix page-action">
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Queue' => array(
                    'content' => $this->renderPartial('_viewKetokQueue', array(
                        'queueKetokDataProvider' => $queueKetokDataProvider,
                    ), true),
                ),
                'Assigned' => array(
                    'content' => $this->renderPartial('_viewKetokEmployeeAssignment', array(
                        'assignKetokDataProvider' => $assignKetokDataProvider,
                    ), true ),
                ),
                'On-Progress' => array(
                    'content' => $this->renderPartial('_viewKetokProgress', array(
                        'progressKetokDataProvider' => $progressKetokDataProvider,
                    ), true),
                ),
                'Ready to QC' => array(
                    'content' => $this->renderPartial('_viewKetokQualityControl', array(
                        'qualityControlKetokDataProvider' => $qualityControlKetokDataProvider,
                    ), true),
                ),
                'Finished' => array(
                    'content' => $this->renderPartial('_viewKetokFinished', array(
                        'finishedKetokDataProvider' => $finishedKetokDataProvider,
                    ), true),
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_ketok',
        )); ?>
    </div>
</div>