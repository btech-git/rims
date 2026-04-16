<div id="maincontent">
    <div class="clearfix page-action">
        <h1>New Vehicle System Check</h1>
        
        <div id="maincontent">
            <?php echo $this->renderPartial('_form', array(
                'vehicleSystemCheck' => $vehicleSystemCheck,
                'registrationTransaction' => $registrationTransaction,
                'product' => $product, 
                'productDataProvider' => $productDataProvider,
            ));?>
        </div>

    </div>
</div>