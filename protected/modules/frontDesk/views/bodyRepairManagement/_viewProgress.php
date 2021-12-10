<div id="maincontent">
    <div class="clearfix page-action">
        <h1>On-Progress</h1>
        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Bongkar' => array(
                        'content' => $this->renderPartial('_viewProgressBongkar', array(
                            'progressBongkarDataProvider' => $progressBongkarDataProvider,
                        ), true ),
                    ),
                    'Spare Part' => array(
                        'content' => $this->renderPartial('_viewProgressSparepart', array(
                            'progressSparePartDataProvider' => $progressSparePartDataProvider,
                        ), true),
                    ),
                    'Ketok/Las' => array(
//                        'content' => $this->renderPartial('_viewProgressKetok', array(
//                            'progressKetokDataProvider' => $progressKetokDataProvider,
//                        ), true),
                    ),
                    'Dempul' => array(
//                        'content' => $this->renderPartial('_viewProgressDempul', array(
//                            'progressDempulDataProvider' => $progressDempulDataProvider,
//                        ), true),
                    ),
                    'Epoxy' => array(
//                        'content' => $this->renderPartial('_viewProgressEpoxy', array(
//                            'progressEpoxyDataProvider' => $progressEpoxyDataProvider,
//                        ), true),
                    ),
                    'Cat' => array(
//                        'content' => $this->renderPartial('_viewProgressCat', array(
//                            'progressCatDataProvider' => $progressCatDataProvider,
//                        ), true),
                    ),
                    'Pasang' => array(
//                        'content' => $this->renderPartial('_viewProgressPasang', array(
//                            'progressPasangDataProvider' => $progressPasangDataProvider,
//                        ), true),
                    ),
                    'Poles' => array(
//                        'content' => $this->renderPartial('_viewProgressPoles', array(
//                            'progressPolesDataProvider' => $progressPolesDataProvider,
//                        ), true),
                    ),
                    'Cuci' => array(
//                        'content' => $this->renderPartial('_viewProgressCuci', array(
//                            'progressCuciDataProvider' => $progressCuciDataProvider,
//                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_progress',
            )); ?>
        </div>
    </div>
</div>