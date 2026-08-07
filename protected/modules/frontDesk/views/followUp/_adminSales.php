<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 5% }
    .width1-3 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 5% }
    .width1-7 { width: 5% }
    .width1-8 { width: 10% }
    .width1-9 { width: 5% }
    .width1-10 { width: 5% }
    .width1-11 { width: 3% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($model->branch_id); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: large">Customer Follow Up + Warranty</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($invoiceStartDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($invoiceEndDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th></th>
                <th>Customer</th>
                <th>Telpon</th>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>KM</th>
                <th>Keluhan / Permintaan Awal</th>
                <th>Problem</th>
                <th>Last RG #</th>
                <th>Invoice #</th>
                <th>Invoice Last Date</th>
                <th>Warrant (3 Days)</th>
                <th>Follow Up (3 Months)</th>
                <th>Last Service (Days)</th>
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->data as $i => $header): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i+1); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.mobile_phone')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($header, 'registrationTransaction.vehicle_mileage')), 0); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer_request_note')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.problem')); ?></td>
                    <td>
                        <?php echo CHtml::link($header->registrationTransaction->transaction_number, array(
                            "/frontDesk/registrationTransaction/view", 
                            "id"=>$header->registration_transaction_id
                        ), array('target' => '_blank',)); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'invoice_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->warranty_date))); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->follow_up_date))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'lastInvoiceDaysNumber')); ?></td>
                    <td>
                        <?php if (empty($header->registrationTransaction->feedback)): ?>
                            <?php echo CHtml::link('Feedback', Yii::app()->createUrl("frontDesk/followUp/updateFeedback", array("id"=>$header->registration_transaction_id))); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'lastInvoiceDaysNumber')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('.page-link').click(function(e) {
            e.preventDefault();
            
            var isMobileSize = window.innerWidth <= 768;
            
            if (isMobileSize) {
                window.location.href = 'viewMobile?id=' + $(this).attr('data-record-id');
            } else {
                window.location.href = 'view?id=' + $(this).attr('data-record-id');
            }
        });
    });
</script>