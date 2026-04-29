<?php
$this->breadcrumbs = array(
    'Body Repair Transactions' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Registration Transaction', 'url' => array('admin')),
    array('label' => 'Create Registration Transaction', 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
    });
    
    $('.search-form form').submit(function(){
	$('#registration-transaction-grid').yiiGridView('update', {
            data: $(this).serialize()
	});
	return false;
    });
");
?>

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Registration', Yii::app()->baseUrl . '/frontDesk/customerRegistration/vehicleList', array(
            'class' => 'button success right', 
            'visible' => Yii::app()->user->checkAccess("bodyRepairCreate")
        )); ?>
        <h1>Manage Body Repair Registrations</h1>

        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary" id="menushow">Advanced Search</a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search',array(
                'model' => $model,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'plateNumber' => $plateNumber,
                'carMake' => $carMake,
                'carModel' => $carModel,
                'customerName' => $customerName,
            )); ?>
        </div><!-- search-form -->
    </div>
    <div class="clearfix"></div>
</div>

<br />

<div class="relative">
    <div class="table_wrapper">
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => $detailTabs,
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_tab',
        )); ?>
    </div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
        $('.page-link').click(function(e) {
            e.preventDefault();
            
            var isMobileSize = window.innerWidth <= 768;
            
            if (isMobileSize) {
                window.location.href = 'viewMobile?id=' + $(this).attr('data-record-id');
            } else {
                window.location.href = 'view?id=' + $(this).attr('data-record-id');
            }
        });
    });
</script>