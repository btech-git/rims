<?php if ($model->vehicle_id != ""): ?>
    <?php $historyTransactions = RegistrationTransaction::model()->findAllByAttributes(array('vehicle_id'=>$model->vehicle_id), array('order' => 't.id DESC', 'limit' => 10)); ?>
    <?php if (count($historyTransactions) > 0): ?>
        <div class="detail">
            <table>
                <thead>
                    <tr>
                        <th>Transaction Number</th>
                        <th>Transaction Date</th>
                        <th>Quick Service</th>
                        <th>Repair Type</th>
                        <th>Total Price</th>
                        <th>detail</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php foreach ($historyTransactions as $i => $historyTransaction): ?>
                        <tr>
                            <td><?php echo $historyTransaction->transaction_number; ?></td>
                            <td><?php echo $historyTransaction->transaction_date; ?></td>
                            <td><?php echo $historyTransaction->is_quick_service == 1 ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $historyTransaction->repair_type; ?></td>
                            <td><?php echo number_format($historyTransaction->grand_total,0); ?></td>
                            <td>
                                <?php echo CHtml::tag('button', array(
                                    // 'name'=>'btnSubmit',
                                    'type'=>'button',
                                    'class' => 'hello button expand',
                                    'onclick'=>'$("#detail-'.$i.'").toggle();'
                                ), '<span class="fa fa-caret-down"></span> Detail');?>
                            </td>
                        </tr>

                        <tr>
                            <td id="detail-<?php echo $i?>" class="hide" colspan=6>
                                <table>
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

                                            foreach($sDetails as $sDetail) {
                                                $service = Service::model()->findByPk($sDetail->service_id);
                                                if($first === true) {
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
                                            $pDetails = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id'=>$historyTransaction->id));

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
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <?php echo "NO HISTORY"; ?>
    <?php endif; ?>
<?php endif; ?>