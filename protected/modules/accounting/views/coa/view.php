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
            ),
        )); ?>
    </div>
</div>

<br />

<fieldset>
    <legend>COA DETAIL</legend>
    <table>
        <thead>
            <tr>
                <th>Transaksi</th>
                <th>Tanggal</th>
                <th>Type</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach (array_reverse($coaDetails) as $key => $coaDetail): ?>
                <?php if ($key <= 50): ?>
                    <tr>
                        <td><?php echo $coaDetail->kode_transaksi; ?></td>
                        <td><?php echo $coaDetail->tanggal_transaksi; ?></td>
                        <td><?php echo $coaDetail->transaction_type; ?></td>
                        <td><?php echo $coaDetail->debet_kredit == "D" ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $coaDetail->total)) : 0 ?></td>
                        <td><?php echo $coaDetail->debet_kredit == "K" ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $coaDetail->total)) : 0 ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
        
    </table>
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