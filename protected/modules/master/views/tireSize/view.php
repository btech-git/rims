<?php
/* @var $this TireSizeController */
/* @var $model TireSize */

$this->breadcrumbs=array(
	'Tire Sizes'=>array('index'),
	$model->section_width,
);

$this->menu=array(
	array('label'=>'List TireSize', 'url'=>array('index')),
	array('label'=>'Create TireSize', 'url'=>array('create')),
	array('label'=>'Update TireSize', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TireSize', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TireSize', 'url'=>array('admin')),
);
?>

<h1>View Ukuran Ban #<?php echo $model->id; ?></h1>

<table>
    <thead>
        <tr>
            <td>ID</td>
            <td>Section Width</td>
            <td>Aspect Ratio</td>
            <td>Construction Type</td>
            <td>Rim Diameter</td>
            <td>Load Rating</td>
            <td>Speed Rating</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo CHtml::encode(CHtml::value($model, 'id')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($model, 'section_width')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($model, 'aspect_ratio')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($model, 'construction_type')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($model, 'rim_diameter')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($model, 'load_rating')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($model, 'speed_rating')); ?></td>
        </tr>
    </tbody>
</table>

<hr />

<h1>Rekomendasi Kendaraan</h1>

<table>
    <thead>
        <tr>
            <td>Merk</td>
            <td>Model</td>
            <td>Deksripsi</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model->tireSizeCarModelRecommendations as $recommendation): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($recommendation, 'vehicleCarModel.carMake.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($recommendation, 'vehicleCarModel.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($recommendation, 'vehicleCarModel.description')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr />

<div class="row">
    <div class="small-12 medium-4 columns">
        <div class="field">
            <table>
                <thead>
                    <tr>
                        <td>Premium Options</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->tireSizePremiumOptions as $premiumOption): ?>
                        <tr>
                            <td>
                                <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.subBrand.brand.name')); ?> - 
                                <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.subBrand.name')); ?> - 
                                <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.name')); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="small-12 medium-4 columns">
        <div class="field">
            <table>
                <thead>
                    <tr>
                        <td>Standard Options</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->tireSizeStandardOptions as $premiumOption): ?>
                        <tr>
                            <td>
                                <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.subBrand.brand.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.subBrand.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.name')); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="small-12 medium-4 columns">
        <div class="field">
            <table>
                <thead>
                    <tr>
                        <td>Ekonomis Options</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->tireSizeEconomicOptions as $premiumOption): ?>
                        <tr>
                            <td>
                                <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.subBrand.brand.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.subBrand.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($premiumOption, 'subBrandSeries.name')); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>