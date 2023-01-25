<?php 
$this->breadcrumbs= array(
    'Report',
    'Laporan Penjualan',
    'Bulanan',
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
                <h1 class="report-title">Laporan Penjualan Bulanan</h1>
            </div>
            <div class="small-12 medium-12 columns">
                <div class="tab reportTab">
                    <div class="tabHead">
                        <?php //$this->renderPartial('../../../admin/views/layouts/_menu_report');?>
                    </div>
                    <div class="tabBody">
                      <div id="detail_div">
                        <div class="myForm">

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

                                            <?php echo CHtml::dropDownlist('brand', $brand, CHtml::listData(Brand::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Brand --')); ?>
                                        </div>
                                        <div class="small-4 columns">
                                            <span class="prefix">Tanggal </span>
                                        </div>
                                        <div class="small-8 columns">
                                           <?php
                                           $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name'=>'tanggal',
                                            'value'=>$tanggal,
                                            'options'=>array(
                                                'dateFormat'=>'yy-mm-dd',
                                                'changeMonth'=>true,
                                                ),
                                            'htmlOptions'=>array(
                                                'readonly'=>true,
                                                'placeholder'=>'Pilih Tanggal',
                                                ),
                                            ));
                                            ?>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div><?php //echo $getCoa == "" ? '-' : $getCoa; ?></div>
                        <div><?php //print_r($allCoa); ?></div>

                        <div class="clear"></div>
                        <div class="row buttons">
                            <?php echo CHtml::submitButton('Lihat Laporan Bulanan', array('name'=>'viewLapbulan','id'=>'viewLapbulan')); ?>
                            <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'ExportExcel')); ?>
                        </div>


                        <?php echo CHtml::endForm(); ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>

            <?php if (isset($_GET['viewLapbulan'])) { ?>
            <div class="small-12 medium-12 columns">
                <div style="padding: 10px;"></div>
                <strong>Laporan Penjualan Bulan <?= date("F", strtotime($tanggal))?> - <?= strtoupper($type);?></strong>
                <div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">

                    
                    <?php 
                    foreach ($brandname as $key => $value) { 
                        $products = Product::model()->findAllByAttributes(['brand_id'=>$value->id]);
                        ?>
                        <table style="width:2000px;">
                            <thead>
                                <tr>
                                    <th width="5px;" rowspan="2">NO</th>
                                    <th width="150px;">Type</th>
                                    <th width="150px;">CODE</th>
                                    <?php
                                    foreach ($branchs as $key => $branch) { ?>
                                    <th rowspan="2" class="heading90"><?=$branch->name?></th>
                                    <?php }?>
                                </tr>
                                <tr>
                                    <th colspan="2"><?=$value->name?></th>
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
                                    foreach ($branchs as $key => $branch) { 
                                        echo "<td width='5px'>".$reportingComponets->getRekapBulanan($tanggal,$product->id,$branch->id)."</td>";
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
</div>
</div>