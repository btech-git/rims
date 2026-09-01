<?php
/* @var $this PaymentInController */
/* @var $paymentOutHeader PaymentIn */

$this->breadcrumbs = array(
    'Payment Out' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle(600);
    $('.bulk-action').toggle();
    $(this).toggleClass('active');
    
    if ($(this).hasClass('active')) {
        $(this).text('');
    } else {
        $(this).text('Advanced Search');
    }
    
    return false;
});
$('.search-form form').submit(function(){
    $('#payment-out-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    
    return false;
});
");
?>

<h1>Data Pending Approval Pembayaran Pembelian</h1>

<div id="link">
    <?php echo CHtml::link('<span class="fa fa-list"></span> Manage', Yii::app()->baseUrl . '/accounting/paymentOut/admin', array(
        'class' => 'button cbutton right',
    )); ?>
</div>

<div class="field buttons text-left">
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::submitButton('Processing Approval', array('name' => 'Submit', 'confirm' => 'Are you sure you want to approve all this payments?')); ?>
    <?php echo CHtml::endForm(); ?>
</div>

<br /><br />

<?php echo CHtml::beginForm(array(''), 'get'); ?>
<center>
    <div class="search-bar">
        <div class="clearfix button-bar">
            <div class="search-form" style="display:none">
                <div class="wide form" id="advSearch">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                            'action'=>Yii::app()->createUrl($this->route),
                            'method'=>'get',
                    )); ?>

                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <!-- BEGIN FIELDS -->
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo $form->label($paymentOutHeader,'supplier_id', array('class'=>'prefix')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo $form->textField($paymentOutHeader,'supplier_name'); ?>
                                    </div>
                                </div>
                            </div>	

                            <!-- BEGIN FIELDS -->
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo $form->label($paymentOutHeader,'payment_type_id', array('class'=>'prefix')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo $form->dropDownList($paymentOutHeader, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- all --')); ?>
                                    </div>
                                </div>
                            </div>	

                            <div class="field buttons text-right">
                                <?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
                            </div>
                        </div>
                    </div>
                <?php $this->endWidget(); ?>

                </div>
            </div><!-- search-form -->
        </div>
    </div>
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'payment-out-grid',
    'dataProvider' => $dataProvider,
    'filter' => null,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
       'cssFile'=>false,
       'header'=>'',
    ),
    'columns' => array(
        array(
            'name' => 'payment_number',
            'header' => 'Pembayaran #',
            'value'=>'CHtml::link($data->payment_number, array("view", "id"=>$data->id), array("target" => "blank"))', 
            'type'=>'raw',
        ),
        array(
            'header' => 'Tanggal Bayar',
            'name' => 'payment_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->payment_date)'
        ),
        array(
            'header' => 'Supplier',
            'value' => 'CHtml::value($data, "supplier.name")',
        ),
        array(
            'name' => 'payment_amount', 
            'value' => 'number_format($data->payment_amount, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right'         
            ),
        ),
        array(
            'header' => 'Created By',
            'name' => 'user_id',
            'filter' => false,
            'value' => 'empty($data->user_id) ? "N/A" : $data->user->username '
        ),
        array(
            'header' => 'Approval Status',
            'value' => 'empty($data->paymentOutApprovals) ? "N/A" : $data->getApprovalStatus()'
        ),
        array(
            'header' => 'Tanggal Input',
            'name' => 'created_datetime',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->created_datetime)'
        ),
    ),
)); ?>
<?php //echo CHtml::endForm(); ?>
