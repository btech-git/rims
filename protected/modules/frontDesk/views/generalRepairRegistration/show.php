<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    $model->id,
);
?>

<div class="small-12 columns">
    <div id="maincontent">
        <div class="clearfix page-action">
            <h1>View Registration Transaction #<?php echo $model->transaction_number; ?></h1>

            <fieldset>
                <legend>Information</legend>
                <div class="row" style="height: 550px">
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Registration' => array(
                                'id' => 'info1',
                                'content' => $this->renderPartial('_viewRegistration', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Billing Estimation' => array(
                                'id' => 'info2',
                                'content' => $this->renderPartial('_viewBilling', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Customer Info' => array(
                                'id' => 'info3',
                                'content' => $this->renderPartial('_viewCustomer', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Vehicle Info' => array(
                                'id' => 'info4',
                                'content' => $this->renderPartial('_viewVehicle', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Messages' => array(
                                'id' => 'info5',
                                'content' => $this->renderPartial('_viewMemo', array(
                                    'registrationMemos' => $registrationMemos,
                                    'memo' => $memo,
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
    
    <hr /><br />
    
    <div class="detail">
        <fieldset>
            <legend>Details</legend>
            <?php
            $tabsArray = array();
            $tabsArray['Quick Service'] = array(
                'id' => 'quickService',
                'content' => $this->renderPartial('_viewQuickService', array(
                    'quickServices' => $quickServices,
                    'ccontroller' => $ccontroller,
                    'model' => $model
                ), TRUE)
            );
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
            );
            $tabsArray['Inspection'] = array(
                'id' => 'inspection',
                'content' => $this->renderPartial('_viewInspection', array(
                    'model' => $model
                ), TRUE)
            );
            
            ?>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => $tabsArray,
                // additional javascript options for the tabs plugin
                'options' => array('collapsible' => true),
            )); ?>
        </fieldset>
    </div>
</div>