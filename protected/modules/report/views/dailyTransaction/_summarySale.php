<fieldset>
    <legend>Retail</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Registration #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Kendaraan</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrationTransactionRetailData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/frontDesk/generalRepairRegistration/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'repair_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'grand_total'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <hr />
    
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Invoice #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Jatuh Tempo</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Plat #</th>
                <th class="width1-5">Kendaraan</th>
                <th class="width1-5">Warna</th>
                <th class="width1-6">KM</th>
                <th class="width1-7">Status</th>
                <th class="width1-8">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceHeaderRetailData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->invoice_number), array("/transaction/invoiceHeader/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                    </td>
                    <td class="width1-3">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?>
                    </td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.color.name')); ?></td>
                    <td class="width1-6" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'registrationTransaction.vehicle_mileage'))); ?>
                    </td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-8" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_price'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <hr />
    
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Payment #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Note</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentInRetailData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->payment_number), array("/transaction/paymentIn/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->payment_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'payment_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'payment_amount'))); ?>
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
                <th class="width1-1">Registration #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Kendaraan</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrationTransactionCompanyData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/frontDesk/generalRepairRegistration/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'repair_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'grand_total'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <hr />
    
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Invoice #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Jatuh Tempo</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Plat #</th>
                <th class="width1-5">Kendaraan</th>
                <th class="width1-5">Warna</th>
                <th class="width1-6">KM</th>
                <th class="width1-7">Status</th>
                <th class="width1-8">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceHeaderCompanyData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->invoice_number), array("/transaction/invoiceHeader/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                    </td>
                    <td class="width1-3">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?>
                    </td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.color.name')); ?></td>
                    <td class="width1-6" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'registrationTransaction.vehicle_mileage'))); ?>
                    </td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-8" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_price'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr />

    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Payment #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Note</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentInCompanyData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->payment_number), array("/transaction/paymentIn/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->payment_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'payment_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'payment_amount'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>