<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <fieldset>
                <legend>Information</legend>
                <div class="row" style="height: 500px">
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Hutang Supplier' => array(
                                'id' => 'info1',
                                'content' => $this->renderPartial('_viewPayable', array(
                                    'payableTransaction' => $payableTransaction,
                                    'payableTransactionDataProvider' => $payableTransactionDataProvider,
                                ), true)
                            ),
                            'Piutang Customer' => array(
                                'id' => 'info2',
                                'content' => $this->renderPartial('_viewReceivable', array(
                                    'receivableTransaction' => $receivableTransaction,
                                    'receivableTransactionDataProvider' => $receivableTransactionDataProvider,
                                ), true)
                            ),
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab',
                    )); ?>  
                </div>
            </fieldset>
        </div>
    </div>
</div>