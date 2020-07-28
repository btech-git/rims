<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Permissions'),
); ?>

<div id="menu">
<?php $this->renderPartial('/_menu'); ?>
</div>
<div id="loadings">
  	<div id="loading-images"><p style="font-size: 2rem; padding-top: 86px;">SEDANG MENGAMBIL DATA <div id="loading-image-icon"></div></p></div>
</div>

<div id="permissions">

	<h2><?php echo Rights::t('core', 'Permissions'); ?></h2>

	<p>
		<?php echo Rights::t('core', 'Here you can view and manage the permissions assigned to each role.'); ?><br />
		<?php echo Rights::t('core', 'Authorization items can be managed under {roleLink}, {taskLink} and {operationLink}.', array(
			'{roleLink}'=>CHtml::link(Rights::t('core', 'Roles'), array('authItem/roles')),
			'{taskLink}'=>CHtml::link(Rights::t('core', 'Tasks'), array('authItem/tasks')),
			'{operationLink}'=>CHtml::link(Rights::t('core', 'Operations'), array('authItem/operations')),
		)); ?>
	</p>

	<p><?php echo CHtml::link(Rights::t('core', 'Generate items for controller actions'), array('authItem/generate'), array(
	   	'class'=>'generator-link',
	)); ?></p>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>'{items}',
		// 'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div>',
		'emptyText'=>Rights::t('core', 'No authorization items found.'),
		'htmlOptions'=>array('class'=>'grid-view permission-table'),
		'loadingCssClass'=>'grid-view-loading',
		'columns'=>$columns,
	)); ?>

	<p class="info">*) <?php echo Rights::t('core', 'Hover to see from where the permission is inherited.'); ?></p>
	<?php
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/dataTables.foundation.css');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/scroller.foundation.css');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.dataTables.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/dataTables.foundation.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/dataTables.scroller.js', CClientScript::POS_END);
	?>
	<script type="text/javascript">

		/**
		* Attach the tooltip to the inherited items.
		*/
		jQuery('.inherited-item').rightsTooltip({
			title:'<?php echo Rights::t('core', 'Source'); ?>: '
		});

		/**
		* Hover functionality for rights' tables.
		*/
		$('#rights tbody tr').hover(function() {
			$(this).addClass('hover'); // On mouse over
		}, function() {
			$(this).removeClass('hover'); // On mouse out
		});
		$(window).load(function() {
			$('#loadings').hide();
		    $('.items').DataTable( {
		        "scrollX": true
		    } );
		});
		// $(document).ready(function() {
		// } );

	</script>

</div>