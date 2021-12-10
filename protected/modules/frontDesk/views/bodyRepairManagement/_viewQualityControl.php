<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Quality Control Check Up</h1>
        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Bongkar' => array(
                        'content' => $this->renderPartial('_viewQualityControlBongkar', array(
                            'qualityControlBongkarDataProvider' => $qualityControlBongkarDataProvider,
                        ), true ),
                    ),
                    'Spare Part' => array(
                        'content' => $this->renderPartial('_viewQualityControlSparepart', array(
                            'qualityControlSparePartDataProvider' => $qualityControlSparePartDataProvider,
                        ), true),
                    ),
                    'Ketok/Las' => array(
//                        'content' => $this->renderPartial('_viewQualityControlKetok', array(
//                            'qualityControlKetokDataProvider' => $qualityControlKetokDataProvider,
//                        ), true),
                    ),
                    'Dempul' => array(
//                        'content' => $this->renderPartial('_viewQualityControlDempul', array(
//                            'qualityControlDempulDataProvider' => $qualityControlDempulDataProvider,
//                        ), true),
                    ),
                    'Epoxy' => array(
//                        'content' => $this->renderPartial('_viewQualityControlEpoxy', array(
//                            'qualityControlEpoxyDataProvider' => $qualityControlEpoxyDataProvider,
//                        ), true),
                    ),
                    'Cat' => array(
//                        'content' => $this->renderPartial('_viewQualityControlCat', array(
//                            'qualityControlCatDataProvider' => $qualityControlCatDataProvider,
//                        ), true),
                    ),
                    'Pasang' => array(
//                        'content' => $this->renderPartial('_viewQualityControlPasang', array(
//                            'qualityControlPasangDataProvider' => $qualityControlPasangDataProvider,
//                        ), true),
                    ),
                    'Poles' => array(
//                        'content' => $this->renderPartial('_viewQualityControlPoles', array(
//                            'qualityControlPolesDataProvider' => $qualityControlPolesDataProvider,
//                        ), true),
                    ),
                    'Cuci' => array(
//                        'content' => $this->renderPartial('_viewQualityControlCuci', array(
//                            'qualityControlCuciDataProvider' => $qualityControlCuciDataProvider,
//                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_qc',
            )); ?>
        </div>
    </div>
</div>