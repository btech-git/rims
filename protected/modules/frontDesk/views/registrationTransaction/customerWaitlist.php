<div>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Customer Waitlist' => array(
                'content' => $this->renderPartial('_viewCustomerWaitlist', array(
                        'model' => $model,
                        'modelDataProvider' => $modelDataProvider,
                    ),
                    true
                )
            ),
//            'Mechanics' => array(
//                'content' => $this->renderPartial(
//                    '_viewMechanics',
//                    array(),
//                    true
//                )
//            ),
        ),
        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id' => 'view_tab',
    )); ?>
</div>

<?php
$customer = new Customer('search');
$customerCriteria = new CDbCriteria;
//$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
$customerCriteria->compare('name', $customer->name, true);
$customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);
$customerCriteria->compare('customer_type', $customer->customer_type, true);

$customerDataProvider = new CActiveDataProvider('Customer', array(
    'criteria' => $customerCriteria,
)); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'customer-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Customer',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'customer-grid',
    'dataProvider' => $customerDataProvider,
    'filter' => $customer,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
        jQuery("#customer-dialog").dialog("close");
        jQuery.ajax({
            type: "POST",
            dataType: "JSON",
            url: "' . CController::createUrl('ajaxCustomer', array('id' => '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
            data: $("form").serialize(),
            success: function(data) {
                jQuery("#RegistrationTransaction_customer_name").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_epoxy").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_dempul").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_finishing").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_opening").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_paint").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_washing").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_tba").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_gr").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_grOil").val(data.name);
                jQuery("#RegistrationTransaction_customer_name_grWash").val(data.name);
            },
        });
    }',
    'columns' => array(
        'customer_type',
        'name',
        'email',
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
