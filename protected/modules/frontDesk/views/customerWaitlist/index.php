<?php echo CHtml::beginForm(array(''), 'get'); ?>
<div>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Customer Waitlist' => array(
                'content' => $this->renderPartial('_waitlistCustomerSearch', array(
                    'model' => $model,
                    'plateNumberWaitlist' => $plateNumberWaitlist,
                    'customerNameWaitlist' => $customerNameWaitlist,
                    'dataProvider' => $dataProvider,
                ), true)
            ),
            'Mobil Masuk' => array(
                'content' => $this->renderPartial('_vehicleEntrySearch', array(
                    'startDateIn' => $startDateIn,
                    'endDateIn' => $endDateIn,
                    'plateNumberIn' => $plateNumberIn,
                    'customerNameIn' => $customerNameIn,
                    'vehicleEntry' => $vehicleEntry,
                    'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
                ), true)
            ),
            'Mobil Proses' => array(
                'content' => $this->renderPartial('_vehicleProcessSearch', array(
                    'startDateProcess' => $startDateProcess,
                    'endDateProcess' => $endDateProcess,
                    'plateNumberProcess' => $plateNumberProcess,
                    'customerNameProcess' => $customerNameProcess,
                    'vehicleProcess' => $vehicleProcess,
                    'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
                ), true)
            ),
            'Mobil Keluar' => array(
                'content' => $this->renderPartial('_vehicleExitSearch', array(
                    'startDateExit' => $startDateExit,
                    'endDateExit' => $endDateExit,
                    'plateNumberExit' => $plateNumberExit,
                    'customerNameExit' => $customerNameExit,
                    'vehicleExit' => $vehicleExit,
                    'vehicleExitDataprovider' => $vehicleExitDataprovider,
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
<?php echo CHtml::endForm(); ?>