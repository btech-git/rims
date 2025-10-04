<div class="<?php echo !$isSubmitted ? '' : 'd-none'; ?>" id="master-list">
    
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Produk' => array(
                'content' => $this->renderPartial('_listProduct', array(
                    'product' => $product, 
                    'productDataProvider' => $productDataProvider, 
                    'branches' => $branches,
                    'endDate' => $endDate,
                ), true),
            ),
            'Jasa' => array(
                'content' => $this->renderPartial('_listService', array(
                    'service' => $service,
                    'serviceDataProvider' => $serviceDataProvider,
                    'branches' => $branches,
                    'endDate' => $endDate,
                ), true),
            ),
        ),
        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id' => 'view_tab',
    )); ?>
    
    <div class="d-grid">
        <div class="row">
            <div class="col text-center">
                <?php echo CHtml::htmlButton('Next', array('id' => 'next-button', 'class'=>'btn btn-success btn-sm')); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#next-button').on('click', function() {
            $('#master-list').addClass('d-none');
            $('#transaction-form').removeClass('d-none');
        });
    });
</script>
