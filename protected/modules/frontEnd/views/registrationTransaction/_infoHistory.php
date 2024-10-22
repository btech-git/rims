    <?php $historyTransactions = RegistrationTransaction::model()->findAllByAttributes(array('vehicle_id'=>$vehicle->id), array('order' => 't.id DESC', 'limit' => 10)); ?>
    <?php if (count($historyTransactions) > 0): ?>
        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">Produk</legend>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="table-info">
                        <th>Transaction #</th>
                        <th>Tanggal</th>
                        <th>Repair Type</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historyTransactions as $i => $historyTransaction): ?>
                        <tr>
                            <td><?php echo $historyTransaction->transaction_number; ?></td>
                            <td><?php echo $historyTransaction->transaction_date; ?></td>
                            <td><?php echo $historyTransaction->repair_type; ?></td>
                            <td class="text-end"><?php echo number_format($historyTransaction->grand_total,0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <table class="table table-bordered table-bordered">
                                    <tr>
                                        <td>Problem</td>
                                        <td><?php echo $historyTransaction->problem; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Services</td>
                                        <td>
                                            <?php  $first = true;
                                            $rec = "";
                                            $sDetails = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$historyTransaction->id));
                                            foreach($sDetails as $sDetail)
                                            {
                                                $service = Service::model()->findByPk($sDetail->service_id);
                                                if ($first === true)
                                                {
                                                    $first = false;
                                                }
                                                else
                                                {
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
                                            $productDetails = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id'=>$historyTransaction->id));
                                            foreach ($productDetails as $productDetail)
                                            {
                                                if ($first === true)
                                                {
                                                    $first = false;
                                                }
                                                else
                                                {
                                                    $rec .= ', ';
                                                }
                                                $rec .= $productDetail->product->name;
                                            }
                                            echo $rec; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
	<?php else: ?>
            <?php echo "NO HISTORY"; ?>
	<?php endif; ?>