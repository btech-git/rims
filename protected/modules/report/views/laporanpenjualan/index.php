<?php 
$this->breadcrumbs= array(
    'Report',
    'Stock',
    );
    ?>
    <div id="maincontent">
        <div class="row">
            <div class="small-12 medium-12 columns">
                <h1 class="report-title">Recap Stock - Report</h1>
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
                                            <span class="prefix">Rekap Stok </span>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo CHtml::dropDownList('type', $type, $sparepart);?>
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
                                                    ),
                                                'htmlOptions'=>array(
                                                    'readonly'=>true,
                                                        // 'placeholder'=>'Tanggal',
                                                    ),
                                                ));
                                                ?>
                                                <p><em>jika tanggal tidak di pilih default total semua stok.</em></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="row buttons">
                                <?php //echo CHtml::submitButton('Tampilkan', array('onclick'=>'$("#CurrentSort").val(""); return true;')); ?>

                                <!--  <button type="reset" value="Reset" id="reset">Reset</button> -->
                                <?php echo CHtml::submitButton('View Recap Stock', array('name'=>'viewLapstok','id'=>'viewLapstok')); ?>
                                <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'ExportExcel')); ?>
                            </div>


                            <?php echo CHtml::endForm(); ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['viewLapstok'])) { ?>
        <div class="small-12 medium-12 columns">
            <div style="padding: 10px;"></div>

            <?php
            $typeName = $reportingComponets->getListSparepart()[$type];

            $brandname =  Brand::model()->findAllByAttributes(['id'=>$reportingComponets->getSparepartId($type)]); 
            $branch =  Branch::model()->findAll();
            $jumlah_branch = count($branch);
            ?>                
            <strong>Laporan Stok - <?php echo $typeName; ?></strong>

            <div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">
                <?php 
                foreach ($brandname as $key => $value) { ?>
                <table style="width: 2000px">
                    <thead>
                        <tr>
                            <th rowspan="2" width="5px">NO</th>
                            <th width="100px" style="padding-top: 20px;padding-bottom: 20px;">TYPE <?= strtoupper($typeName)?></th>
                            <th width="100px">KODE</th>
                            <?php 
                            foreach ($branch as $key => $bcan) {
                                echo '<th rowspan="2" width="5px" class="heading90">'.$bcan->name.'</th>';
                            }
                            ?>
                            <th width="100px" rowspan="2">Total</th>
                        </tr>
                        <tr>
                            <th colspan="2"><?= $value->name?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $products = Product::model()->findAllByAttributes(['brand_id'=>$value->id]);
                        $nomor = 1;
                        foreach ($products as $key => $product) {
                            echo "<tr>";
                            echo "<td>".$nomor."</td>";
                            echo "<td>".$product->name."</td>";
                            echo "<td>".$product->manufacturer_code."</td>";
                            foreach ($branch as $key => $bcan) {

                                $total = 0;
                                if ($tanggal !=NULL) {
                                    $vvalue = $reportingComponets->getStockDate($product->id,$bcan->id,$tanggal);
                                    $total = $total + $vvalue;
                                }else{
                                    $vvalue = $reportingComponets->getStock($product->id,$bcan->id);
                                    $total = $total + $vvalue;
                                }
                                echo '<td>'.$vvalue.'</td>';
                            }
                            echo "<td>$total</td>";
                            echo "</tr>";
                            $nomor ++;
                        }
                        ?>
                    </tbody>
                    <!--<tfoot>
                        <tr>
                            <td></td>
                            <?php
                                // foreach ($branch as $key => $bcan) {
                                //     # code...
                                // }
                            ?>
                        </tr>
                    </tfoot>-->
                </table>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

    </div>
</div>