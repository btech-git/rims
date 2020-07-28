<?php
/* @var $this SupplierController */
/* @var $model Supplier */

$this->breadcrumbs=array(
 	'Company',
 	'Suppliers'=>array('admin'),
 	'View Supplier '.$model->name,
 );

// $this->menu=array(
// 	array('label'=>'List Supplier', 'url'=>array('index')),
// 	array('label'=>'Create Supplier', 'url'=>array('create')),
// 	array('label'=>'Update Supplier', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Supplier', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Supplier', 'url'=>array('admin')),
// );
?>

<!-- <h1>View Supplier #<?php echo $model->id; ?></h1> -->



		<div id="maincontent">
			<div class="clearfix page-action">
					<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
					<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/supplier/admin';?>"><span class="fa fa-th-list"></span>Manage Supplier</a>
				<?php if (Yii::app()->user->checkAccess("master.supplier.update")) { ?>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
				<?php if (Yii::app()->user->checkAccess("master.consignmentInHeader.create")) { ?>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/transaction/consignmentInHeader/create');?>"><span class="fa fa-plus"></span>Consignment In</a>
				<?php } ?>
				<?php if (Yii::app()->user->checkAccess("master.transactionPurchaseOrder.create")) { ?>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/transaction/transactionPurchaseOrder/create');?>"><span class="fa fa-plus"></span>Purchase</a>
				<?php } ?>
					<h1>View <?php echo $model->name ?></h1>

						<?php $this->widget('zii.widgets.CDetailView', array(
							'data'=>$model,
							'attributes'=>array(
								//'id',
								'date',
								'code',
								//'name',
								'company',
                                'person_in_charge',
                                'phone',
								'position',
								'address',
								'province_id',
								'city_id',
								'zipcode',
								'email_personal',
								'email_company',
								'npwp',
								'tenor',
								'company_attribute',
								array('name'=>'coa_name','value'=>$model->coa !=""? $model->coa->name: ''),
								array('name'=>'coa_code','value'=>$model->coa !=""? $model->coa->code: ''),
								array('name'=>'coa_outstanding_name','value'=>$model->coaOutstandingOrder !=""? $model->coaOutstandingOrder->name: ''),
								array('name'=>'coa_outstanding_code','value'=>$model->coaOutstandingOrder !=""? $model->coaOutstandingOrder->code: ''),

							),
						)); ?>

			</div>
		</div>
<div class="row">
	<div class="small-12 columns">
		<h3>Supplier PIC</h3>
		<table class="detail">
			
			<tr>
				<td>Name</td>
				<td>Company</td>
				<td>Position</td>
				<td>Address</td>
				<td>Province</td>
				<td>City</td>
				<td>Zipcode</td>
				<td>Fax</td>
				<td>Email Personal</td>
				<td>Email Company</td>
				<td>NPWP</td>
				<td>Description</td>
			</tr>
			<?php foreach ($picDetails as $key => $picDetail): ?>
				<tr>
					<td><?php echo $picDetail->name; ?></td>
					<td><?php echo $picDetail->company; ?></td>
					<td><?php echo $picDetail->position; ?></td>
					<td><?php echo $picDetail->address; ?></td>
					<td><?php echo $picDetail->province->name; ?></td>
					<td><?php echo $picDetail->city->name; ?></td>
					<td><?php echo $picDetail->zipcode; ?></td>
					<td><?php echo $picDetail->fax; ?></td>
					<td><?php echo $picDetail->email_personal; ?></td>
					<td><?php echo $picDetail->email_company; ?></td>
					<td><?php echo $picDetail->npwp; ?></td>
					<td><?php echo $picDetail->description; ?></td>
					<td><a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/updatePic',array('supId'=>$model->id,'picId'=>$picDetail->id));?>"><span class="fa fa-pencil"></span>edit</a></td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>
</div>
	<div class="row">
	<div class="small-12 columns">
		<h3>Supplier Bank Accounts</h3>
		<table >
			
			<tr>
				<td>Bank Name</td>
				<td>Account Name</td>
				<td>Account No</td>
				<td>Swift Code</td>
				<td>Action</td>
			</tr>
			<?php foreach ($supplierBanks as $key => $supplierBank): ?>
				<tr>
					<?php $bank = Bank::model()->findByPk($supplierBank->bank_id); ?>
					<td><?php echo $bank->name ?></td>
					<td><?php echo $supplierBank->account_name; ?></td>	
					<td><?php echo $supplierBank->account_no; ?></td>	
					<td><?php echo $supplierBank->swift_code; ?></td>	
					<td><a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/updateBank',array('supId'=>$model->id,'bankId'=>$supplierBank->id));?>"><span class="fa fa-pencil"></span>edit</a></td>
				</tr>
			<?php endforeach ?>
		</table>
	</div></div>
	<div class="detail">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'product-grid',
			'dataProvider'=>$supplierProductDataProvider,
			'filter'=>$supplierProduct,
			'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',	
			'pager'=>array(
				'cssFile'=>false,
				'header'=>'',
				),
			
			'columns'=>array(
				array('name'=>'product_name', 'value'=>'$data->product->name'),
				array('name'=>'product_master_category_name', 'value'=>'$data->product->productMasterCategory->name'),
				array('name'=>'product_sub_master_category_name', 'value'=>'$data->product->productSubMasterCategory->name'),
				array('name'=>'product_sub_category_name', 'value'=>'$data->product->productSubCategory->name'),
				array('name'=>'product_brand_name', 'value'=>'$data->product->brand->name'),
				
				),
			)
		);
		?>
		</div>
	</div>
	
	</div>


<!--
<div class="row">
	<div class="small-12 columns">
		<h3>Products</h3>
		<table >
			
			<tr>
				<td>Product Name</td>
				<td>Master Category</td>
				<td>Master Sub Category</td>
				<td>Sub Category</td>
				<td>Brand</td>
				<td>Sub Brand</td>
				<td>Sub Brand Series</td>
				
				
			</tr>
			<?php //foreach ($supplierProducts as $key => $supplierProduct): ?>
				<tr>
					<td><?php //echo $supplierProduct->product->name; ?></td>
					<td><?php //echo $supplierProduct->product->product_master_category_id == 0 ? '':$supplierProduct->product->productMasterCategory->name; ?></td>
					<td><?php //echo $supplierProduct->product->product_sub_master_category_id == 0 ? '':$supplierProduct->product->productSubMasterCategory->name; ?></td>
					<td><?php //echo $supplierProduct->product->product_sub_category_id == 0 ? '':$supplierProduct->product->productSubCategory->name; ?></td>
					<td><?php //echo $supplierProduct->product->brand_id == 0 ? '':$supplierProduct->product->brand->name; ?></td>
					<td><?php //echo $supplierProduct->product->sub_brand_id == 0 ? '':$supplierProduct->product->subBrand->name; ?></td>
					<td><?php //echo $supplierProduct->product->sub_brand_series_id == 0 ? '':$supplierProduct->product->subBrandSeries->name; ?></td>
				</tr>
			<?php //endforeach ?>
		</table>
	</div>
</div>


