<fieldset>
    <legend>Retail</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 10%">Registration #</th>
                <th style="width: 5%">Tipe</th>
                <th style="width: 15%">Customer</th>
                <th style="width: 10%">Plat #</th>
                <th style="width: 5%">Status</th>
                <th style="width: 10%">WO #</th>
                <th style="width: 10%">Estimasi #</th>
                <th style="width: 10%">Total Parts</th>
                <th style="width: 10%">Total Jasa</th>
                <th style="width: 10%">Total</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrationTransactionRetailData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array(
                            "/frontDesk/generalRepairRegistration/view", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'repair_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'sales_order_number')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'subtotal_product'))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'subtotal_service'))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'grand_total'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span></span>Verify', array(
                                "/report/dailyTransaction/verifyRegistration", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px',  
                                'confirm' => 'Are you sure you want to verify this transaction?',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <hr />
    
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 10%">Invoice #</th>
                <th style="width: 8%">Jatuh Tempo</th>
                <th style="width: 15%">Customer</th>
                <th style="width: 7%">Plat #</th>
                <th style="width: 15%">Kendaraan</th>
                <th style="width: 5%">Warna</th>
                <th style="width: 5%">KM</th>
                <th style="width: 5%">Status</th>
                <th style="width: 10%">Amount</th>
                <th style="width: 5%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceHeaderRetailData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->invoice_number), array(
                            "/transaction/invoiceHeader/view", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.color.name')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'registrationTransaction.vehicle_mileage'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_price'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span></span>Verify', array(
                                "/report/dailyTransaction/verifyInvoice", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px',
                                'confirm' => 'Are you sure you want to verify this transaction?',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <hr />
    
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 10%">Payment #</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 30%">Customer</th>
                <th style="width: 20%">Note</th>
                <th style="width: 5%">Status</th>
                <th style="width: 10%">Amount</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentInRetailData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->payment_number), array(
                            "/transaction/paymentIn/view", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'payment_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'payment_amount'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array(
                                "/report/dailyTransaction/verifyPaymentIn", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px',
                                'confirm' => 'Are you sure you want to verify this transaction?',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>PT</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 10%">Registration #</th>
                <th style="width: 5%">Tipe</th>
                <th style="width: 15%">Customer</th>
                <th style="width: 10%">Plat #</th>
                <th style="width: 5%">Status</th>
                <th style="width: 10%">WO #</th>
                <th style="width: 10%">Estimasi #</th>
                <th style="width: 10%">Total Parts</th>
                <th style="width: 10%">Total Jasa</th>
                <th style="width: 10%">Total</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrationTransactionCompanyData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array(
                            "/frontDesk/generalRepairRegistration/view", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'repair_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'sales_order_number')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'subtotal_product'))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'subtotal_service'))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'grand_total'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span></span>Verify', array(
                                "/report/dailyTransaction/verifyRegistration", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px',
                                'confirm' => 'Are you sure you want to verify this transaction?',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <hr />
    
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 10%">Invoice #</th>
                <th style="width: 8%">Jatuh Tempo</th>
                <th style="width: 15%">Customer</th>
                <th style="width: 7%">Plat #</th>
                <th style="width: 15%">Kendaraan</th>
                <th style="width: 5%">Warna</th>
                <th style="width: 5%">KM</th>
                <th style="width: 5%">Status</th>
                <th style="width: 10%">Amount</th>
                <th style="width: 5%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceHeaderCompanyData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->invoice_number), array(
                            "/transaction/invoiceHeader/view", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.color.name')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'registrationTransaction.vehicle_mileage'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_price'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span></span>Verify', array(
                                "/report/dailyTransaction/verifyInvoice", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px',
                                'confirm' => 'Are you sure you want to verify this transaction?',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr />

    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 10%">Payment #</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 30%">Customer</th>
                <th style="width: 20%">Note</th>
                <th style="width: 5%">Status</th>
                <th style="width: 10%">Amount</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentInCompanyData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->payment_number), array(
                            "/transaction/paymentIn/view", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'payment_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'payment_amount'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array(
                                "/report/dailyTransaction/verifyPaymentIn", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px',
                                'confirm' => 'Are you sure you want to verify this transaction?',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>