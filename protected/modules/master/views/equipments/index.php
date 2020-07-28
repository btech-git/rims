<?php
/* @var $this EquipmentsController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	'Products',
	'Equipments'=>array('admin'),
	//$product->header->name=>array('view','id'=>$product->header->id),
	'Equipment List & Type',
);
?>
<div id="maincontent">
	<div class="clearfix page-action">
		<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipments/admin';?>"><span class="fa fa-th-list"></span>Manage Equipments</a>

		<h1>Equipment List &amp; Type</h1>
			<div class="view">
				<?php $this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$dataProvider,
					'itemView'=>'_view',
					// 'summaryText'=>'',
					'template' => '<table><thead><th>Equipment</th><th>Branch</th>
									<th>Equipment Type</th>
									<th>Equipment Sub-Type</th>
									<th>Equipment Details</th>
									</thead><tbody>{items}</tbody></table>
									<div class="clearfix">{summary}{pager}</div>',
					'pager'=>array(
					   'cssFile'=>false,
					   'header'=>'',
					),
				)); ?>
			</div>
	</div>
</div>