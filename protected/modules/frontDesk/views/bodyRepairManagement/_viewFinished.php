<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Finished Tasks</h1>
        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Bongkar' => array(
                        'content' => $this->renderPartial('_viewFinishedBongkar', array(
                            'finishedBongkarDataProvider' => $finishedBongkarDataProvider,
                        ), true ),
                    ),
                    'Spare Part' => array(
                        'content' => $this->renderPartial('_viewFinishedSparepart', array(
                            'finishedSparePartDataProvider' => $finishedSparePartDataProvider,
                        ), true),
                    ),
                    'Ketok/Las' => array(
//                        'content' => $this->renderPartial('_viewFinishedKetok', array(
//                            'finishedKetokDataProvider' => $finishedKetokDataProvider,
//                        ), true),
                    ),
                    'Dempul' => array(
//                        'content' => $this->renderPartial('_viewFinishedDempul', array(
//                            'finishedDempulDataProvider' => $finishedDempulDataProvider,
//                        ), true),
                    ),
                    'Epoxy' => array(
//                        'content' => $this->renderPartial('_viewFinishedEpoxy', array(
//                            'finishedEpoxyDataProvider' => $finishedEpoxyDataProvider,
//                        ), true),
                    ),
                    'Cat' => array(
//                        'content' => $this->renderPartial('_viewFinishedCat', array(
//                            'finishedCatDataProvider' => $finishedCatDataProvider,
//                        ), true),
                    ),
                    'Pasang' => array(
//                        'content' => $this->renderPartial('_viewFinishedPasang', array(
//                            'finishedPasangDataProvider' => $finishedPasangDataProvider,
//                        ), true),
                    ),
                    'Poles' => array(
//                        'content' => $this->renderPartial('_viewFinishedPoles', array(
//                            'finishedPolesDataProvider' => $finishedPolesDataProvider,
//                        ), true),
                    ),
                    'Cuci' => array(
//                        'content' => $this->renderPartial('_viewFinishedCuci', array(
//                            'finishedCuciDataProvider' => $finishedCuciDataProvider,
//                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_finished',
            )); ?>
        </div>
    </div>
</div>