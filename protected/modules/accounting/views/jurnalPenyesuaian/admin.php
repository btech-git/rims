<?php
/* @var $this JurnalPenyesuaianController */
/* @var $model JurnalPenyesuaian */

$this->breadcrumbs=array(
	'Jurnal Penyesuaians'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List JurnalPenyesuaian', 'url'=>array('index')),
	array('label'=>'Create JurnalPenyesuaian', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});
$('.search-form form').submit(function(){
	$('#jurnal-penyesuaian-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Jurnal Penyesuaians</h1>-->


<div id="maincontent">
	<div class="row">
		<div class="small-12 columns">
			<div class="clearfix page-action">
				<?php echo CHtml::link('<span class="fa fa-plus"></span>Create Jurnal Penyesuaian', Yii::app()->baseUrl.'/accounting/jurnalPenyesuaian/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("accounting.jurnalPenyesuaian.create"))) ?>
				<h2>Manage Jurnal Penyesuaian</h2>
			</div>

			<div class="search-bar">
				<div class="clearfix button-bar">
		  			<!--<div class="left clearfix bulk-action">
		         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
		         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
		         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
		         	</div>-->
					<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button right button cbutton secondary')); ?>					<div class="clearfix"></div>
					<div class="search-form" style="display:none">
					<?php $this->renderPartial('_search',array(
						'model'=>$model,
					)); ?>
					</div><!-- search-form -->
		        </div>
		    </div>
        	
        	<div class="grid-view">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'jurnal-penyesuaian-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					// 'summaryText'=>'',
					'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
					'pager'=>array(
					   'cssFile'=>false,
					   'header'=>'',
					),
					'columns'=>array(
						//'id',
						array('name'=>'transaction_number', 'value'=>'CHTml::link($data->transaction_number, array("view", "id"=>$data->id))', 'type'=>'raw'),
						//'transaction_number',
						'transaction_date',
						//'coa_biaya_id',
						//'coa_akumulasi_id',
						array('name'=>'coa_biaya_name','value'=>'$data->coaBiaya->name'),
						array('name'=>'coa_biaya_code','value'=>'$data->coaBiaya->code'),
						array('name'=>'coa_akumulasi_name','value'=>'$data->coaAkumulasi->name'),
						array('name'=>'coa_akumulasi_code','value'=>'$data->coaAkumulasi->code'),
						'amount',
						'status',
						array('name'=>'branch_id','value'=>'$data->branch->name'),
						//'branch_id',
						'user_id',
						
						array(
							'class'=>'CButtonColumn',
							'template'=>'{edit}',
							'buttons'=>array
							(
								
								'edit'=> array (
									'label'=>'edit',
				     				// 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
									'visible'=>'$data->status != "Approved" && $data->status != "Rejected" &&(Yii::app()->user->checkAccess("accounting.jurnalPenyesuaian.update"))',
									'url' =>'Yii::app()->createUrl("accounting/jurnalPenyesuaian/update",array("id"=>$data->id))',
								),
							)
						),
					),
				)); ?>
			</div>
		</div>
	</div> <!-- end row -->
</div> <!-- end maintenance -->
