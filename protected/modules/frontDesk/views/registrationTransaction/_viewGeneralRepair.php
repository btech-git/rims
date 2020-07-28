<div class="row">
    <div class="large-12 columns">
        <h3>General Repair</h3>
        <hr>
        <div class="general-repair-counter">
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
                        'General Repair' => array(
                            'id' => 'tabgr',
                            'content' => $this->renderPartial(
                                '_viewGr',
                                array('grDatas' => $grDatas), true)
                        ),
                        'TBA(Tire Balancing)' => array(
                            'id' => 'tba',
                            'content' => $this->renderPartial(
                                '_viewTba',
                                array('tbaDatas' => $tbaDatas), true)
                        ),
                        'Oil' => array(
                            'id' => 'groil',
                            'content' => $this->renderPartial(
                                '_viewGrOil',
                                array('grOilDatas' => $grOilDatas), true)
                        ),
                        'Car Wash' => array(
                            'id' => 'grwash',
                            'content' => $this->renderPartial(
                                '_viewGrWash',
                                array('grWashDatas' => $grWashDatas), true)
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