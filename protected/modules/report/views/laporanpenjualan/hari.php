<?php 
$this->breadcrumbs= array(
    'Report',
    'Laporan Penjualan',
    'Harian',
    );
    ?>

    <?php  if ($type == 'ban') {
            if ($brand == NULL) {
                $brandname =  Brand::model()->findAllByAttributes(['id'=>$reportingComponets->getListBrandTire()]); 
            }else{
                $brandname =  Brand::model()->findAllByAttributes(['id'=>$brand]); //Brand::model()->findAllByAttributes(['brand_id'=>'']);
            }
            $branchs =  Branch::model()->findAll();
            $jumlah_branch = count($branchs);
        }else{
            if ($brand == NULL) {
                $brandname =  Brand::model()->findAllByAttributes(['id'=>$reportingComponets->getListBrandOil()]); 
            }else{
                $brandname =  Brand::model()->findAllByAttributes(['id'=>$brand]); //Brand::model()->findAllByAttributes(['brand_id'=>'']);
            }

            // $brandname =  Brand::model()->findAllByAttributes(['id'=>$reportingComponets->getListBrandOil()]); //Brand::model()->
            $branchs =  Branch::model()->findAll();
            $jumlah_branch = count($branchs);
        }?>
        <div id="maincontent">
            <div class="row">
                <div class="small-12 medium-12 columns">
                    <h1 class="report-title">Laporan Penjualan Harian</h1>
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

                            <div class="clear"></div>
                            <div class="row buttons">
                                <?php //echo CHtml::submitButton('Tampilkan', array('onclick'=>'$("#CurrentSort").val(""); return true;')); ?>

                                <!--  <button type="reset" value="Reset" id="reset">Reset</button> -->
                                <?php echo CHtml::submitButton('View Laporan Harian', array('name'=>'viewLapharian','id'=>'viewLapharian')); ?>
                                <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'ExportExcel')); ?>
                            </div>


                            <?php echo CHtml::endForm(); ?>
                            <div class="clear"></div>

                        </div>
                        <br/>

                        <div class="hide">
                            <div class="right">


                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['viewLapharian'])) { ?>
        <div class="small-12 medium-12 columns">
            <div style="padding: 10px;"></div>
            <strong>Laporan Penjualan Harian - <?= strtoupper($type);?></strong>
            <div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">

                <?php 
                foreach ($branchs as $key => $branch) { ?>
                <table style="width:2000px;">
                    <thead>
                        <tr>
                            <th colspan="3"><?=$branch->name?></th>
                            <?php 
                            // echo "<tr>";
                            for ($i=1; $i <= 32 ; $i++) {

                                if ($i == 32) {
                                    echo "<th rowspan='2'>Total</th>";
                                }else{
                                    echo "<th rowspan='2'>".$i."</th>";
                                }
                            }
                            ?>
                        </tr>
                        <tr>
                            <th width="5px;">NO</th>
                            <th width="150px;">Type</th>
                            <th width="150px;">CODE</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($brandname as $key => $value) {
                            echo "<tr><td></td>";
                            echo "<td colspan='2'>".$value->name."</td>";
                            echo "<td colspan='32'></td>";
                            echo "</tr>";
                            $nomor =1;
                                $products = Product::model()->findAllByAttributes(['brand_id'=>$value->id]); 
                                foreach ($products as $key => $product) {
                                    echo "<tr>";
                                    echo "<td>" .$nomor."</td>";
                                    echo "<td>".$product->name."</td>";
                                    echo "<td>".$product->manufacturer_code."</td>";

                                    for ($i=1; $i <= 32 ; $i++) {
                                        $tgl = date("m",strtotime($tanggal));
                                        $querytgl = date("Y-m-",strtotime($tanggal)).$i;

                                        if (date("d", strtotime($tanggal)) < $i ) {
                                            if ($i == 32) {
                                               echo '<td>$total</td>';
                                            }else{
                                                echo "<td>-</td>";
                                            }
                                        }else{
                                            if ($i == 32) {
                                               echo '<td>$total</td>';
                                            }else{
                                               echo "<td>".$reportingComponets->getRekapHarian($querytgl,$branch->id,$product->id)."</td>";
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                    $nomor ++;
                                }
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