<?php

$this->breadcrumbs = array(
    'Body Repair Transactions' => array('admin'),
    $model->id,
);
?>

<?php echo CHtml::beginForm(); ?>
<div class="small-12 columns">
    <div id="maincontent">
        <div class="clearfix page-action">
            
            <?php $ccontroller = Yii::app()->controller->id; ?>
            <?php $ccaction = Yii::app()->controller->action->id; ?>
            <?php $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $model->id, 'user_id_cancelled' => null)); ?>

            <h3>View Registration #<?php echo $model->transaction_number; ?></h3>

            <fieldset>
                <legend>Information</legend>
                <div class="row" style="height: 1400px">
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Registration' => array(
                                'id' => 'info1',
                                'content' => $this->renderPartial('_viewRegistrationMobile', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Billing Estimation' => array(
                                'id' => 'info2',
                                'content' => $this->renderPartial('_viewBillingMobile', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Vehicle Info' => array(
                                'id' => 'info4',
                                'content' => $this->renderPartial('_viewVehicleMobile', array(
                                    'model' => $model,
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

        <div class="detail">
            <fieldset>
                <legend>Details</legend>
                <?php
                $tabsArray = array();
                $tabsArray['Service'] = array(
                    'id' => 'service',
                    'content' => $this->renderPartial('_viewServices', array(
                        'services' => $services
                    ), TRUE)
                );
                $tabsArray['Product'] = array(
                    'id' => 'product',
                    'content' => $this->renderPartial('_viewProducts', array(
                        'products' => $products,
                        'model' => $model
                    ), TRUE)
                );
                $tabsArray['Movement'] = array(
                    'id' => 'movement',
                    'content' => $this->renderPartial('_viewMovement', array(
                        'model' => $model
                    ), TRUE)
                );
                $tabsArray['History'] = array(
                    'id' => 'history',
                    'content' => $this->renderPartial('_viewHistory', array(
                        'model' => $model
                    ), TRUE)
                ); ?>
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => $tabsArray,
                    // additional javascript options for the tabs plugin
                    'options' => array('collapsible' => true),
                )); ?>
            </fieldset>
        </div>
    </div>
</div>

<?php echo CHtml::endForm(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
</script>