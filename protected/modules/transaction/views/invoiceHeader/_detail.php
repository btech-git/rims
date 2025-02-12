<?php if (count($invoice->details) != 0): ?>
    <table>
        <thead>
            <th>Product/Service</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <!--<th>Discount</th>-->
            <th>Price</th>
        </thead>
        <tbody>
            <?php foreach ($invoice->details as $i => $detail): ?>
                <?php echo $form->errorSummary($detail); ?>
                <tr>
                    <?php if ($detail->product_id != ""): ?>
                        <td>
                            <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                            <?php echo $detail->product->name; ?>
                        </td>
                    <?php elseif ($detail->service_id != ""): ?>
                            <?php echo CHtml::activeHiddenField($detail, "[$i]service_id"); ?>
                        <td><?php echo $detail->service->name; ?></td>
                    <?php elseif ($detail->quick_service_id != ""): ?>
                            <?php echo CHtml::activeHiddenField($detail, "[$i]quick_service_id"); ?>
                        <td><?php echo $detail->quickService->name; ?></td>
                    <?php endif; ?>
                    <td style="text-align: center">
                        <?php echo CHtml::activeHiddenField($detail, "[$i]quantity"); ?>
                        <?php echo number_format($detail->quantity, 0); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price"); ?>
                        <span class="numbers"><?php echo number_format($detail->unit_price, 2); ?></span>
                    </td>
<!--                    <td style="text-align: right">
                        <?php /*echo CHtml::activeHiddenField($detail, "[$i]discount"); ?>
                        <span class="numbers"><?php echo number_format($detail->discount, 2);*/ ?></span>
                    </td>-->
                    <td style="text-align: right">
                        <?php echo CHtml::activeHiddenField($detail, "[$i]total_price"); ?>
                        <span class="numbers"><?php echo number_format($detail->total_price, 2); ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '
    $(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>