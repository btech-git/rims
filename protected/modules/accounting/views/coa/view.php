<?php
/* @var $this CoaController */
/* @var $model Coa */

$this->breadcrumbs = array(
    'Coas' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List Coa', 'url' => array('index')),
    array('label' => 'Create Coa', 'url' => array('create')),
    array('label' => 'Update Coa', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Coa', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Coa', 'url' => array('admin')),
);

Yii::app()->clientScript->registerScript('coa', '
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
');
?>

<!--<h1>View Coa #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Coa', Yii::app()->baseUrl . '/accounting/coa/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("accounting.coa.admin"))) ?>
        <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/accounting/coa/update?id=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("accounting.coa.update"))) ?>
        <h1>View Coa #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'id',
                'name',
                'code',
                array(
                    'label' => 'Kategori',
                    'name' => 'coa_category_id',
                    'value' => $model->coaCategory->name,
                ),
                array(
                    'label' => 'Sub Kategori',
                    'name' => 'coa_cub_category_id',
                    'value' => $model->coaSubCategory->name,
                ),
                'normal_balance',
                'opening_balance',
                'closing_balance',
                'debit',
                'credit',
                'status',
                array(
                    'label' => 'Created',
                    'value' => $model->createdDatetime,
                ),
                array(
                    'label' => 'Approved',
                    'value' => $model->approvedDatetime,
                ),
            ),
        )); ?>
    </div>
</div>

<br />

<?php $customer = Customer::model()->findByAttributes(array('coa_id' => $model->id)); ?>
<?php if (!empty($customer)): ?>
    <fieldset>
        <legend>Data Customer</legend>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Type</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><?php echo $customer->id; ?></td>
                    <td><?php echo $customer->name; ?></td>
                    <td><?php echo $customer->customer_type; ?></td>
                </tr>
            </tbody>
        </table>
    </fieldset>

<br />
<?php endif; ?>

<fieldset>
    <legend>COA DETAIL</legend>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
<!--    <div class="search-bar">
        <div class="clearfix button-bar">
            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-2 columns">
                                <span class="prefix">Tanggal </span>
                            </div>
                            <div class="small-5 columns">
                                <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name' => 'StartDate',
                                    'options' => array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'changeMonth'=>true,
                                        'changeYear'=>true,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'placeholder' => 'Mulai',
                                    ),
                                )); ?>
                            </div>

                            <div class="small-5 columns">
                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name' => 'EndDate',
                                    'options' => array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'changeMonth'=>true,
                                        'changeYear'=>true,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'placeholder' => 'Sampai',
                                    ),
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="medium-6 columns">
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('class' => 'button cbutton'));*/ ?>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'coa-grid',
            'dataProvider' => $jurnalUmumDataProvider,
            'filter' => null,
            // 'summaryText'=>'',
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                'kode_transaksi',
                'tanggal_transaksi',
                'transaction_type',
                array(
                    'header' => 'Debit', 
                    'value' => '$data->debet_kredit == "D" ? CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $data->total)) : 0', 
                ),
                array(
                    'header' => 'Kredit', 
                    'value' => '$data->debet_kredit == "K" ? CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $data->total)) : 0', 
                ),
            )
        )); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</fieldset>

<div>
    <div class="row">
        <div class="large-6 columns">
            <div class="small-4 columns"><label for="">Period : </label></div>
            <div class="small-6 columns"><input type="text"></div>
            <div class="small-2 columns"><button>View</button></div>
        </div>
    </div>
    <?php
    $criteria = new CDbCriteria();
    $criteria->select = "MONTHNAME(tanggal_posting) as nama_bulan,month(tanggal_posting) as bulan, sum(total) as total";
    $criteria->group = "nama_bulan, bulan";
    $criteria->order = "bulan ASC";
    $jurnalUmums = JurnalUmum::model()->findAll($criteria);
    ?>

    <table>
        <thead>
            <tr>
                <th>Months</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $lastmonth = ""; ?>
            <?php foreach ($jurnalUmums as $key => $jurnalUmum): ?>
                <tr>
                    <td><?php echo $lastmonth == $jurnalUmum->nama_bulan ? $lastmonth : $jurnalUmum->nama_bulan; ?></td>
                    <td><?php echo $lastmonth == $jurnalUmum->nama_bulan ? ($jurnalUmum->debet_kredit == "D" ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $jurnalUmum->total)) : '-') : 0; ?></td>
                    <td><?php echo $lastmonth == $jurnalUmum->nama_bulan ? ($jurnalUmum->debet_kredit == "K" ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $jurnalUmum->total)) : '-') : 0; ?></td>
                    <?php $lastmonth = $jurnalUmum->nama_bulan; ?>
                </tr>		
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="large-12 columns">
            <table>
                <thead>
                    <tr>
                        <th>Months</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td>January</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>February</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>March</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>April</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>May</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>June</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>July</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>August</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>September</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>October</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>November</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>December</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<br/>

<div>
    <?php if ((int) $model->is_approved === 0): ?>
        <div style="float: left; margin-left: 20px;">
            <?php echo CHtml::beginForm(); ?>
            <?php echo CHtml::submitButton('APPROVE', array('name' => 'Approve', 'class' => 'button success')); ?>
            <?php echo CHtml::submitButton('REJECT', array('name' => 'Reject', 'class' => 'button warning')); ?>
            <?php echo CHtml::endForm(); ?>
        </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>

<div>
    <?php if (Yii::app()->user->checkAccess("director")): ?>
        <div style="float: left; margin-left: 20px;">
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/accounting/' . $ccontroller . '/log', array('coaId' => $model->id)); ?>">
                <span class="fa fa-info"></span>Data Log
            </a>
        </div>
    <?php endif; ?>
</div>