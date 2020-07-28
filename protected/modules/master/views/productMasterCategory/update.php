<?php
/* @var $this ProductMasterCategoryController */
/* @var $model ProductMasterCategory */

$this->breadcrumbs=array(
	'Product'=>Yii::app()->baseUrl.'/master/product/admin',
	'Product Master Categories'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Product Master Category',
);

$this->menu=array(
	array('label'=>'List ProductMasterCategory', 'url'=>array('index')),
	array('label'=>'Create ProductMasterCategory', 'url'=>array('create')),
	array('label'=>'View ProductMasterCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductMasterCategory', 'url'=>array('admin')),
);
?>


		<div id="maincontent">

			<?php $this->renderPartial('_form', array(
				'model'=>$model,
				'coaPersediaan'=>$coaPersediaan,
				'coaPersediaanDataProvider'=>$coaPersediaanDataProvider,
				'coaHpp'=>$coaHpp,
				'coaHppDataProvider'=>$coaHppDataProvider,
				'coaPenjualan'=>$coaPenjualan,
				'coaPenjualanDataProvider'=>$coaPenjualanDataProvider,
				'coaRetur'=>$coaRetur,
				'coaReturDataProvider'=>$coaReturDataProvider,
				'coaDiskon'=>$coaDiskon,
				'coaDiskonDataProvider'=>$coaDiskonDataProvider,
				'coaReturPembelian'=>$coaReturPembelian,
				'coaReturPembelianDataProvider'=>$coaReturPembelianDataProvider,
				'coaDiskonPembelian'=>$coaDiskonPembelian,
				'coaDiskonPembelianDataProvider'=>$coaDiskonPembelianDataProvider,
				'coaInventory'=>$coaInventory,
				'coaInventoryDataProvider'=>$coaInventoryDataProvider,
				'coaConsignment'=>$coaConsignment,
				'coaConsignmentDataProvider'=>$coaConsignmentDataProvider,)); ?>
		</div>
