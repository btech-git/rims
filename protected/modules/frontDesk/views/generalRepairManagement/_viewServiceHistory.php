<div>
    <span style="text-align: center"><h3>Service History</h3></span>
    <table>
        <thead>
            <th>WO #</th>
            <th>WO Date</th>
            <th>Invoice #</th>
            <th>Quick Service</th>
            <th>Repair Type</th>
            <th>Total Price</th>
            <th>detail</th>
        </thead>

        <tbody>
            <?php $counter = 1; ?>
            <?php foreach (array_reverse($vehicle->registrationTransactions) as $i => $registrationHistory): ?>
                <?php if ($counter < 11 && $registrationHistory->id !== $registrationTransaction->id && $registrationHistory->repair_type = 'GR'): ?>
                    <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $registrationHistory->id)); ?>
                    <tr>
                        <td><?php echo $registrationHistory->work_order_number; ?></td>
                        <td><?php echo $registrationHistory->work_order_date; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?></td>
                        <td><?php echo $registrationHistory->is_quick_service == 1 ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $registrationHistory->repair_type; ?></td>
                        <td style="text-align: right"><?php echo number_format($registrationHistory->grand_total,0); ?></td>
                        <td>
                            <?php echo CHtml::tag('button', array(
                                'type'=>'button',
                                'class' => 'hello button expand',
                                'onclick'=>'$("#detail-history-'.$i.'").toggle();'
                            ), '<span class="fa fa-caret-down"></span> Detail');?>
                        </td>
                    </tr>

                    <tr>
                        <td id="detail-history-<?php echo $i?>" class="hide" colspan=6>
                            <table>
                                <tr>
                                    <td>Problem</td>
                                    <td><?php echo $registrationHistory->problem; ?></td>
                                </tr>
                                <tr>
                                    <td>Services</td>
                                    <td>
                                        <?php  $first = true;
                                        $rec = "";
                                        $sDetails = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$registrationHistory->id));

                                        foreach($sDetails as $sDetail) {
                                            $service = Service::model()->findByPk($sDetail->service_id);
                                            if ($first === true) {
                                                $first = false;
                                            }
                                            else {
                                                $rec .= ', ';
                                            }
                                            $rec .= $service->name;
                                        }

                                        echo $rec; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Products</td>
                                    <td>
                                        <?php  $first = true;
                                        $rec = "";
                                        $pDetails = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id'=>$registrationHistory->id));

                                        foreach($pDetails as $pDetail) {
                                            $product = Product::model()->findByPk($pDetail->product_id);
                                            if($first === true) {
                                                $first = false;
                                            }
                                            else {
                                                $rec .= ', ';
                                            }
                                            $rec .= $product->name;
                                        }

                                        echo $rec; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php $counter++; ?>
                <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
