<div class="reportDisplay">
    <h2>Pending Technical Report</h2>
    <span style="float: right"><?php echo ReportHelper::summaryText($pendingDataProvider); ?></span>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th>No</th>
                <th>RG #</th>
                <th>Tanggal</th>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>Customer</th>
                <th>SPK Customer #</th>
                <th>WO #</th>
                <th>DMS Reference #</th>
                <th>V-TAG #</th>
                <th>Invoice #</th>
                <th>Warranty Report</th>
                <th>Keluhan Customer</th>
                <th>Problem</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $runningNumber = 1; ?>
            <?php foreach ($pendingDataProvider->data as $activeRegistrationItem): ?>
                <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $activeRegistrationItem->id)); ?>
                <tr>
                    <td><?php echo CHtml::encode($runningNumber); ?></td>
                    <td>
                        <?php echo CHtml::link($activeRegistrationItem->transaction_number, array("saleRegistration/view", "id"=>$activeRegistrationItem->id), array(
                            "class" => "page-link", 
                            "data-record-id" => $activeRegistrationItem->id, 
                            'target' => '_blank', 
                            'style' => 'color:blue; text-decoration:underline'
                        )); ?>
                    </td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", strtotime(CHtml::value($activeRegistrationItem, 'transaction_date')))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'customer_work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'customer_document_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'technical_code_number')); ?></td>
                    <td><?php echo CHtml::encode($activeRegistrationItem->getInvoice($activeRegistrationItem)); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'warranty_report')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'customer_request_note')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'problem')); ?></td>
                </tr>
                <?php $runningNumber++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $pendingDataProvider->pagination,
        )); ?>
    </div>
    <br /><br />
</div>