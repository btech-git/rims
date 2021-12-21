<div class="clearfix page-action">
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Queue' => array(
                    'content' => $this->renderPartial('_viewSparepartQueue', array(
                        'queueSparePartDataProvider' => $queueSparePartDataProvider,
                    ), true),
                ),
                'Assigned' => array(
                    'content' => $this->renderPartial('_viewSparepartEmployeeAssignment', array(
                        'assignSparePartDataProvider' => $assignSparePartDataProvider,
                    ), true ),
                ),
                'On-Progress' => array(
                    'content' => $this->renderPartial('_viewSparepartProgress', array(
                        'progressSparePartDataProvider' => $progressSparePartDataProvider,
                    ), true),
                ),
                'Ready to QC' => array(
                    'content' => $this->renderPartial('_viewSparepartQualityControl', array(
                        'qualityControlSparePartDataProvider' => $qualityControlSparePartDataProvider,
                    ), true),
                ),
                'Finished' => array(
                    'content' => $this->renderPartial('_viewSparepartFinished', array(
                        'finishedSparePartDataProvider' => $finishedSparePartDataProvider,
                    ), true),
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_sparepart',
        )); ?>
    </div>
</div>