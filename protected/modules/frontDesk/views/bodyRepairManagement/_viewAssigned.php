<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Assigned Tasks</h1>
        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Bongkar' => array(
                        'content' => $this->renderPartial('_viewAssignBongkar', array(
                            'assignBongkarDataProvider' => $assignBongkarDataProvider,
                        ), true ),
                    ),
                    'Spare Part' => array(
                        'content' => $this->renderPartial('_viewAssignSparepart', array(
                            'assignSparePartDataProvider' => $assignSparePartDataProvider,
                        ), true),
                    ),
                    'Ketok/Las' => array(
//                        'content' => $this->renderPartial('_viewAssignKetok', array(
//                            'assignKetokDataProvider' => $assignKetokDataProvider,
//                        ), true),
                    ),
                    'Dempul' => array(
//                        'content' => $this->renderPartial('_viewAssignDempul', array(
//                            'assignDempulDataProvider' => $assignDempulDataProvider,
//                        ), true),
                    ),
                    'Epoxy' => array(
//                        'content' => $this->renderPartial('_viewAssignEpoxy', array(
//                            'assignEpoxyDataProvider' => $assignEpoxyDataProvider,
//                        ), true),
                    ),
                    'Cat' => array(
//                        'content' => $this->renderPartial('_viewAssignCat', array(
//                            'assignCatDataProvider' => $assignCatDataProvider,
//                        ), true),
                    ),
                    'Pasang' => array(
//                        'content' => $this->renderPartial('_viewAssignPasang', array(
//                            'assignPasangDataProvider' => $assignPasangDataProvider,
//                        ), true),
                    ),
                    'Poles' => array(
//                        'content' => $this->renderPartial('_viewAssignPoles', array(
//                            'assignPolesDataProvider' => $assignPolesDataProvider,
//                        ), true),
                    ),
                    'Cuci' => array(
//                        'content' => $this->renderPartial('_viewAssignCuci', array(
//                            'assignCuciDataProvider' => $assignCuciDataProvider,
//                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_assigned',
            )); ?>
        </div>
    </div>
</div>