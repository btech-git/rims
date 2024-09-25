<div class="row">
    <div class="large-12 columns">
        <h3>Time Counter</h3>
        <hr>
        <a name="timecounter"></a><a name="1"></a><a name="2"></a><a name="3"></a><a name="4"></a><a name="5"></a>
        <div class="time-counter">
            <div class="detail">

                <?php
                // $current_url=Yii::app()->request->requestUri;
                // $active_tab=parse_url($current_url,PHP_URL_FRAGMENT);
                $active_tab = !empty($_GET['RegistrationTransaction']['tab_type']) ? $_GET['RegistrationTransaction']['tab_type'] : '';
                // echo $active_tab;
                ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Epoxy' => array(
                            'id' => 'epoxy',
                            'content' => $this->renderPartial(
                                '_viewEpoxy',
                                array('epoxyDatas' => $epoxyDatas), true)
                        ),
                        'Cat' => array(
                            'id' => 'paint',
                            'content' => $this->renderPartial(
                                '_viewPaint',
                                array('paintDatas' => $paintDatas), true)
                        ),
                        'Finishing' => array(
                            'id' => 'finishing',
                            'content' => $this->renderPartial(
                                '_viewFinishing',
                                array('finishingDatas' => $finishingDatas), true)
                        ),
                        'Dempul' => array(
                            'id' => 'dempul',
                            'content' => $this->renderPartial(
                                '_viewDempul',
                                array('dempulDatas' => $dempulDatas), true)
                        ),
                        'Cuci/Salon' => array(
                            'id' => 'washing',
                            'content' => $this->renderPartial(
                                '_viewWashing',
                                array('washingDatas' => $washingDatas), true)
                        ),
                        'Opening' => array(
                            'id' => 'opening',
                            'content' => $this->renderPartial(
                                '_viewOpening',
                                array('openingDatas' => $openingDatas), true)
                        ),
                    ),
                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                        'active' => $active_tab,
                    ),
                    // set id for this widgets
                    // 'id'=>'view_tab',
                ));
                ?>
            </div>
        </div>
    </div>
</div>