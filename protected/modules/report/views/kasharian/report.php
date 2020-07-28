<?php $this->breadcrumbs= array(
    'Report',
    'Kas Harian',
); ?>
<div id="maincontent">
    <div class="row">
            <div class="small-12 medium-12 columns">
                <h1 class="report-title">Laporan Kas Harian</h1>
            </div>
            <div class="small-12 medium-12 columns">
                <div class="tab reportTab">
                    <div class="tabHead">
                        <?php //$this->renderPartial('../../../admin/views/layouts/_menu_report');?>
                    </div>
                    <div class="tabBody">
                        <div id="detail_div">
                            <div>
                                <div class="myForm">

                                    <?php echo CHtml::beginForm(array(''), 'get'); ?>

                                    <div class="row">
                                        <div class="medium-6 columns">
                                            <div class="field">
                                                <div class="row collapse">
                                                    <?php 
                                                    /*<div class="small-4 columns">
                                                    <span class="prefix">Type</span>
                                                    </div>
                                                    <div class="small-8 columns">
                                                    <?php echo CHtml::dropDownList('type', $type, 
                                                    array('cashin' => 'Kas Masuk', 'cashout' => 'Kas Keluar'));?>
                                                </div>*/
                                                ?>
                                                <div class="small-4 columns">
                                                    <span class="prefix">Tanggal </span>
                                                </div>
                                                <div class="small-8 columns">
                                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                        'name'=>'tanggal',
                                                        'value'=>date("Y-m-d"),
                                                        'options'=>array(
                                                            'dateFormat'=>'yy-mm-dd',
                                                        ),
                                                        'htmlOptions'=>array(
                                                            'readonly'=>true,
                                                            'placeholder'=>'Pilih Tanggal',
                                                        ),
                                                    )); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clear"></div>
                                <div class="buttons">
                                    <?php echo CHtml::submitButton('View Kas Harian', array('name'=>'viewKasharian','id'=>'viewKasharian')); ?>
                                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'ExportExcel')); ?>
                                </div>

                                <?php echo CHtml::endForm(); ?>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['viewKasharian'])) { ?>
        <div class="small-12 medium-12 columns">
            <div style="padding: 10px;"></div>
            <strong>Laporan Kas Masuk</strong>

            <table>
             <thead>
                <tr>
                    <th><?=$tanggal?></th>
                    <th rowspan="2">Cash</th>
                    <th colspan="2">Credit</th>
                    <th colspan="2">Debit</th>
                    <th rowspan="2">Hutang</th>
                    <th rowspan="2">DP</th>
                    <th rowspan="2">Total</th>
                </tr>
                <tr>
                    <th>Branch</th>
                    <th>BCA</th>
                    <th>Mandiri</th>
                    <th>BCA</th>
                    <th>Mandiri</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $branchs = Branch::model()->findAll();
                foreach ($branchs as $key => $branch) {
                    $cin1 = $kascomponent->getCashin($tanggal, $branch->id);
                    $cin2 = $kascomponent->getCredit($tanggal, $branch->id,7);
                    $cin3 = $kascomponent->getCredit($tanggal, $branch->id,3);
                    $cin4 = $kascomponent->getDebit($tanggal, $branch->id,7);
                    $cin5 = $kascomponent->getDebit($tanggal, $branch->id,3);
                    $cin6 = $kascomponent->getPiutang($tanggal, $branch->id);
                    $cin7 = $kascomponent->getDp($tanggal, $branch->id);

                    echo "<tr>";
                    echo "<td>".$branch->name."</td>";
                    echo "<td>".number_format($cin1)."</td>";
                    echo "<td>".number_format($cin2)."</td>";
                    echo "<td>".number_format($cin3)."</td>";
                    echo "<td>".number_format($cin4)."</td>";
                    echo "<td>".number_format($cin5)."</td>";
                    echo "<td>".number_format($cin6)."</td>";
                    echo "<td>".number_format($cin7)."</td>";
                    $totalin = $cin1 + $cin2 + $cin3 + $cin4 + $cin5 + $cin6 + $cin7;
                    echo "<td>". number_format($totalin) ."</td>";
                    echo "</tr>";
                } 
                ?>
            </tbody>
        </table>
    </div>
    <div class="small-12 medium-12 columns">
        <strong>Laporan Kas Keluar</strong>

        <table>
            <thead>
                <tr>
                    <th><?=$tanggal?></th>
                    <th rowspan="2">Cash</th>
                    <th colspan="2">Credit</th>
                    <th colspan="2">Debit</th>
                    <th rowspan="2">Hutang</th>
                    <th rowspan="2">DP</th>
                    <th rowspan="2">Total</th>
                </tr>
                <tr>
                    <th>Branch</th>
                    <th>BCA</th>
                    <th>Mandiri</th>
                    <th>BCA</th>
                    <th>Mandiri</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // $branchs = Branch::model()->findAll();
                foreach ($branchs as $key => $branch) {
                    $cout1 = $kascomponent->getCashout($tanggal, $branch->id);
                    $cout2 = $kascomponent->getCreditCout($tanggal, $branch->id,7);
                    $cout3 = $kascomponent->getCreditCout($tanggal, $branch->id,3);
                    $cout4 = $kascomponent->getDebitCout($tanggal, $branch->id,7);
                    $cout5 = $kascomponent->getDebitCout($tanggal, $branch->id,3);
                    $cout6 = $kascomponent->getPiutangCout($tanggal, $branch->id);
                    $cout7 = $kascomponent->getDp($tanggal, $branch->id);

                    echo "<tr>";
                    echo "<td>".$branch->name."</td>";
                    echo "<td>".number_format($cout1)."</td>";
                    echo "<td>".number_format($cout2)."</td>";
                    echo "<td>".number_format($cout3)."</td>";
                    echo "<td>".number_format($cout4)."</td>";
                    echo "<td>".number_format($cout5)."</td>";
                    echo "<td>".number_format($cout6)."</td>";
                    echo "<td>".number_format($cout7)."</td>";
                    $total = $cout1 + $cout2 + $cout3 + $cout4 + $cout5 + $cout6 + $cout7;
                    echo "<td>". number_format($total) ."</td>";
                    echo "</tr>";
                } 
                ?>
            </tbody>
        </table>
    </div>
    <div class="small-12 medium-12 columns">
        <strong>Setor Bank</strong>

        <table>
            <thead>
                <tr>
                    <th>BANK</th>
                    <th>SALDO</th>
                </tr>
            </thead>
            <tbody>
                <?php /*?>
                <tr>
                    <td>MANDIRI-KMK </td>
                    <td><?=$kascomponent->getSetorbank($tanggal,0);?></td>
                </tr>
                <tr>
                    <td>BCA PT </td>
                    <td><?=$kascomponent->getSetorbank($tanggal,0);?></td>
                </tr>      
                <tr>
                    <td>BCA PD </td>
                    <td><?=$kascomponent->getSetorbank($tanggal,0);?></td>
                </tr>      
                <tr>
                    <td>BCA HFD </td>
                    <td><?=$kascomponent->getSetorbank($tanggal,0);?></td>
                </tr>     
                <tr>
                    <td>BCA PRIVE </td>
                    <td><?=$kascomponent->getSetorbank($tanggal,0);?></td>
                </tr>       
                <tr>
                    <td>EKO.RPIJ </td>
                    <td><?=$kascomponent->getSetorbank($tanggal,0);?></td>
                </tr>        
                <tr>
                    <td>EKO.HFD </td>
                    <td><?=$kascomponent->getSetorbank($tanggal,0);?></td>
                </tr>     
                <tr>
                    <td>CIMB NIAGA </td>
                    <td><?=$kascomponent->getSetorbank($tanggal,0);?></td>
                </tr>      
                <tr>
                    <td>PANIN PRIVE </td>
                    <td><?=$kascomponent->getSetorbank($tanggal,0);?></td>
                </tr>
                */?>     
                <?php 
                foreach ($banks as $key => $bank) {
                    echo "<tr>";
                    echo "<td>".$bank->name."</td>";
                    echo "<td>".number_format($kascomponent->getSetorbank($tanggal, $bank->id))."</td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td>SALDO</td> <?php $idbank =  array(0); ?>
                    <td><?= number_format($kascomponent->getSetorbankTotal($tanggal));?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="small-12 medium-12 columns">
        <strong>Saldo Awal Saldo Akhir</strong>
        <table>
            <thead>
                <tr>
                    <th>CABANG / BANK</th>
                    <th>SALDO AWAL</th>
                    <th>SALDO AKHIR</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($branchs as $key => $branch) {
                    echo "<tr>";
                    echo "<td>".$branch->name."</td>";
                    echo "<td>".number_format($kascomponent->getSaldoAwal($tanggal, $branch->id))."</td>";
                    echo "<td>".number_format($kascomponent->getSaldoAkhir($tanggal, $branch->id))."</td>";
                    echo "</tr>";
                }
                ?>
                <?php 
                foreach ($banks as $key => $bank) {
                    echo "<tr>";
                    echo "<td>".$bank->name."</td>";
                    echo "<td>".number_format($kascomponent->getSaldoAwalBank($tanggal, $bank->id,'In'))."</td>";
                    echo "<td>".number_format($kascomponent->getSaldoAkhirBank($tanggal, $bank->id))."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php } ?>
</div>
</div>