<div class="<?php echo !$isSubmitted ? '' : 'd-none'; ?>" id="master-list">
    
            <?php echo $this->renderPartial('_listProduct', array(
                'product' => $product, 
                'productDataProvider' => $productDataProvider, 
                'branches' => $branches,
                'endDate' => $endDate,
            )); ?>
            <?php echo $this->renderPartial('_listService', array(
                'service' => $service,
                'serviceDataProvider' => $serviceDataProvider,
                'branches' => $branches,
                'endDate' => $endDate,
            )); ?>
    
    <div class="d-grid">
        <div class="row">
            <div class="col text-center">
                <?php echo CHtml::htmlButton('Next', array('id' => 'next-button', 'class'=>'btn btn-success')); ?>
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
