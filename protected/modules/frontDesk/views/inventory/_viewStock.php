<div>
    <table>
        <thead>
            <tr>
                <th>Transaction Type</th>
                <th>Transaction Number</th>
                <th>Transaction Date</th>
                <th>Stock In</th>
                <th>Stock Out</th>
                <th>Total</th>
                <th>Warehouse</th>
                <th>Notes</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $totalstockin = 0; ?>
            <?php $totalstockout = 0; ?> 
            <?php $currentstock = 0; ?>
            <?php foreach ($dataProvider->data as $detail): ?>
                    <?php $totalstockout += $detail->stock_out; ?>
                    <?php $totalstockin += $detail->stock_in; ?>
                    <?php $currentstock += $detail->stock_in + $detail->stock_out; ?>
                    <tr>
                        <td><?php echo CHtml::encode($detail->transaction_type); ?></td>
                        <td><?php echo CHtml::link($detail->transaction_number, Yii::app()->createUrl("frontDesk/inventory/redirectTransaction", array("codeNumber" => $detail->transaction_number)), array('target' => '_blank')); ?></td>
                        <td><?php echo CHtml::encode($detail->transaction_date); ?></td>
                        <td><?php echo CHtml::encode($detail->stock_in); ?></td>
                        <td><?php echo CHtml::encode($detail->stock_out); ?></td>
                        <td><?php echo CHtml::encode($currentstock); ?></td>
                        <td><?php echo CHtml::encode($detail->warehouse->code); ?></td>
                        <td><?php echo CHtml::encode($detail->notes); ?></td>
                    </tr>
            <?php endforeach; ?>
            <?php $stockme = $totalstockin + $totalstockout; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total</strong></td>
                <td><?php echo CHtml::encode($totalstockin); ?></td>
                <td><?php echo CHtml::encode($totalstockout); ?></td>
                <td><?php //echo CHtml::encode($stockme); ?></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
    
    <?php $pagerId = $branchId == '' ? 'pager-all' : ('pager-' . $branchId); ?>
    
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'id' => $pagerId,
        'itemCount' => $dataProvider->pagination->itemCount,
        'pageSize' => $dataProvider->pagination->pageSize,
        'currentPage' => $dataProvider->pagination->getCurrentPage(false),
    )); ?>
</div>

<script>
    $('ul#<?php echo $pagerId; ?> > li').click(function(e) {
        e.preventDefault();
        if (!$(this).hasClass('hidden')) {
            var url = '<?php echo CController::createUrl('ajaxHtmlUpdateInventoryDetailGrid', array('productId' => $productId, 'branchId' => $branchId, 'currentPage' => '')); ?>';
            var pageNumber = 0;
            var num = 1;
            if ($(this).hasClass('previous')) {
                num = parseInt($(this).closest('ul').find('li.selected a').text()) - 1;
            } else if ($(this).hasClass('next')) {
                num = parseInt($(this).closest('ul').find('li.selected a').text()) + 1;
            } else {
                num = parseInt($('a', this).text());
            }
            pageNumber = num - 1;
            url += pageNumber;
            var el = this;
            $.ajax({
                type: 'POST',
                url: url,
                success: function(html) {
                    $(el).closest('div.ui-tabs-panel').html(html);
                }
            });
        }
    });
</script>