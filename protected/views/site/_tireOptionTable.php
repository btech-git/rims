<div class="reportDisplay">
    <?php echo ReportHelper::summaryText($tireSizeDataProvider); ?>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th style="text-align: center">Ukuran Ban</th>
                <th style="text-align: center">Rekomendasi Kendaraan</th>
                <th style="text-align: center">Opsi Premium</th>
                <th style="text-align: center">Opsi Standar</th>
                <th style="text-align: center">Opsi Ekonomis</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($tireSizeDataProvider->data as $tireSize): ?>
                <tr>
                    <td><?php echo CHtml::link(CHtml::value($tireSize, 'tireName')); ?></td>
                    <td>
                        <table>
                            <?php foreach ($tireSize->tireSizeCarModelRecommendations as $carRecommendation): ?>
                                <tr>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($carRecommendation, 'vehicleCarModel.carMake.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($carRecommendation, 'vehicleCarModel.name')); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                    <td>
                        <table>
                            <?php foreach ($tireSize->tireSizePremiumOptions as $premiumOption): ?>
                                <tr>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.subBrand.brand.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.subBrand.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.name')); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                    <td>
                        <table>
                            <?php foreach ($tireSize->tireSizeStandardOptions as $standardOption): ?>
                                <tr>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($standardOption, 'subBrandSeries.subBrand.brand.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($standardOption, 'subBrandSeries.subBrand.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($standardOption, 'subBrandSeries.name')); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                    <td>
                        <table>
                            <?php foreach ($tireSize->tireSizeEconomicOptions as $economicOption): ?>
                                <tr>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($economicOption, 'subBrandSeries.subBrand.brand.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($economicOption, 'subBrandSeries.subBrand.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($economicOption, 'subBrandSeries.name')); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $tireSizeDataProvider->pagination,
        )); ?>
    </div>
</div>