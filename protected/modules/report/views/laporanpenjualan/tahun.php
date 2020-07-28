<?php 
$this->breadcrumbs= array(
    'Report',
    'Laporan Penjualan',
    'Tahunan',
    );
    ?>
    <?php  if ($type == 'ban') {
        if ($brand == NULL) {
            $brandname =  Brand::model()->findAllByAttributes(['id'=>$reportingComponets->getListBrandTire()]); 
        }else{
            $brandname =  Brand::model()->findAllByAttributes(['id'=>$brand]);
        }
        $branchs =  Branch::model()->findAll();
        $jumlah_branch = count($branchs);
    }else{
        if ($brand == NULL) {
            $brandname =  Brand::model()->findAllByAttributes(['id'=>$reportingComponets->getListBrandOil()]); 
        }else{
            $brandname =  Brand::model()->findAllByAttributes(['id'=>$brand]);
        }
        $branchs =  Branch::model()->findAll();
        $jumlah_branch = count($branchs);
    }?>

    <div id="maincontent">
        <div class="row">
            <div class="small-12 medium-12 columns">
                <h1 class="report-title">Laporan Penjualan Tahunan</h1>
            </div>
            <div class="small-12 medium-12 columns">

                <?php 
                $years = [];
                for ($i=date("Y"); $i >= 2016; $i--) { 
                    $years[$i] = $i; 
                }
                ?>
                <?php echo CHtml::beginForm(array(''), 'get'); ?>

                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Tipe Penjualan </span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('type', $type, 
                                    array('ban' => 'Ban', 'oli' => 'Oli'));?>
                                </div>
                                <div class="small-4 columns">
                                    <span class="prefix">Brand </span>
                                </div>
                                <div class="small-8 columns">

                                    <?php echo CHtml::dropDownlist('brand', $brand, CHtml::listData(Brand::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- Semua Brand --')); ?>
                                </div>
                                <div class="small-4 columns">
                                    <span class="prefix">Tahun </span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownlist('tahun', $tahun, $years, array('empty'=>'-- Pilih Tahun --')); ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="clear"></div>
                <div class="row buttons">

                    <?php echo CHtml::submitButton('Lihat Laporan Tahunan', array('name'=>'viewLaptahun','id'=>'viewLaptahun')); ?>
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'ExportExcel')); ?>
                </div>


                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>


            <?php if (isset($_GET['viewLaptahun'])) { ?>
            <div class="small-12 medium-12 columns">
                <div style="padding: 10px;"></div>
                <strong>Laporan Penjualan Tahunan <?= empty($tahun)?date("Y"):$tahun;?> - <?= strtoupper($type);?></strong>
                <div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">

                    <?php 
                    foreach ($brandname as $key => $value) { 
                        $products = Product::model()->findAllByAttributes(['brand_id'=>$value->id]);
                        ?>
                        <table style="width:100%;">
                            <thead>
                                <tr>
                                    <th width="5px;" rowspan="2">NO</th>
                                    <th width="150px;">Type</th>
                                    <th width="150px;">CODE</th>
                                    <th colspan="12"><?=empty($tahun)?date("Y"):$tahun;?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><?=$value->name?></th>
                                    <?php
                                    for ($i=1; $i <=12; $i++) { 
                                        $tgl = $tahun.'-'.sprintf("%02d", $i).'-01'; 
                                        ?>
                                        <th width="10px;"><?=strtoupper(date("M",strtotime($tgl)))?></th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $nomor =1;
                                    foreach ($products as $key => $product) {
                                        echo "<tr>";
                                        echo '<td width="5px;">'.$nomor.'</td>';
                                        echo '<td width="100px;">';
                                        echo empty($product->subBrandSeries)?"99":$product->subBrandSeries->name;
                                        echo '</td>';
                                        echo '<td width="150px;">'.$product->manufacturer_code.'</td>';
                                        for ($i=1; $i <=12; $i++) { 
                                            $tgl = $tahun.'-'.sprintf("%02d", $i).'-01'; 
                                            echo "<td>".$reportingComponets->getRekapTahunan($tgl,$product->id)."</td>";
                                        }
                                        echo "</tr>";
                                        $nomor++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php } ?>            

            </div>
        </div>
