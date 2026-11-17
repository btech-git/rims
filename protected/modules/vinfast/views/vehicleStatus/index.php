<?php
/* @var $this RegistrationTransactionController */
/* @var $data RegistrationTransaction */

$this->breadcrumbs = array(
    'Vehicle' => array('admin'),
    'Manage',
);
?>

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div class="tab reportTab">
    <div class="tabHead"><h4>Kendaraan Keluar / Masuk Bengkel</h4></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Customer</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('CustomerName', $customerName, array('class' => 'form-select',)); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Posisi Mobil</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('VehiclePosition', $vehiclePosition, array(
                                        'Masuk Lokasi' => 'Dalam Bengkel', 
                                        'Keluar Lokasi' => 'Di luar Bengkel',
                                    ), array('empty' => '-- All --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Plat #</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('PlateNumber', $plateNumber, array('class' => 'form-select',)); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Status Pekerjaan</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('ServiceStatus', $serviceStatus, array(
                                        'Pending' => 'Pending', 
                                        'On-Progress' => 'On-Progress', 
                                        'Completed' => 'Selesai'
                                    ), array('empty' => '-- All --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
                
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit'));  ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div class="relative">
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Dalam Bengkel' => array(
                            'content' => $this->renderPartial('_vehicleEntry', array(
                                'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
                            ), true),
                        ),
                        'Luar Bengkel' => array(
                            'content' => $this->renderPartial('_vehicleExit', array(
                                'vehicleExitDataprovider' => $vehicleExitDataprovider,
                            ), true),
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
            <div class="clear"></div>
        </div>
    </div>
</div>