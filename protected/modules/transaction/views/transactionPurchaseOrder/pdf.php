<?php
date_default_timezone_set('Asia/Jakarta');
function tanggal($date){
  $bulan = array('Januari','Februari','Maret','April','Mei','Juni','July','Agustus','September','Oktober','November','Desember');
  $tahun = substr($date,0,4);
  $bulan2 = substr($date,5,2);
  $tanggal = substr($date,8,2);

  return $tanggal.' '.$bulan[(int)$bulan2 - 1]. ' '.$tahun;
}

?>
<div class="container">
  <div class="header">
    <div class="left">
      <img src="images/logo.png" alt="">
      <table>
<!--        <tr>
          <td class="rap"><p class="raperind">Raperind Motor</p></td>
        </tr>-->
        <tr>
          <td><p class="rapad">JL. Kalimalang, No. 8, Kampung Dua,<br />
            Bekasi City, West Java. <br />
            Tlp. (021) 8843656</p></td>
        </tr>
      </table>
    </div>
    <div class="right">
      <h3>Purchase Order</h3>
      <table>
        <tr>
          <td>Date</td>
          <td>:</td>
          <td><?php echo tanggal($po->purchase_order_date) ?></td>
        </tr>
        <tr>
          <td>PO#</td>
          <td>:</td>
          <td><?php echo $po->purchase_order_no ?></td>
        </tr>
      </table>
    </div>
  </div>

  <div class="supplier">
    <div class="left">

      <table>
        <tr>
          <td>To</td>
          <td>:</td>
          <td><?php echo $supplier->name ?></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td><?php echo $supplier->address ?></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td><?php echo $supplier->email_personal ?></td>
        </tr>
      </table>
    </div>
    <div class="right">
      <table>
        <tr>
          <td>Ordered By</td>
          <td>:</td>
          <td><?php echo $branch->name ?></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td><?php echo $branch->address ?></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td><?php echo $branch->phone ?></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td><?php echo $branch->email ?></td>
        </tr>

      </table>
    </div>
  </div>

  <div class="purchase-order">
    <table>
      <tr>
        <th class="no">No</th>
        <th class="item">Item</th>
        <th class="price">Price</th>
        <th class="qty">Qty</th>
        <th class="discount">Discount</th>
        <th class="subtotal">Sub Total</th>
      </tr>
      <?php
      $no = 1;
      foreach($po_detail as $x){
      ?>
      <tr class="isi">
        <td class="noo"><?php echo $no ?></td>
        <td>&nbsp;  <?php echo Product::model()->find('id=:id', array(':id'=>$x->product_id))->name ?></td>
        <td>&nbsp;  Rp. <?php echo number_format($x->unit_price,2,',','.') ?></td>
        <td style="text-align:center"><?php echo $x->quantity ?></td>
        <td>
          <?php if($x->discount_step == 1){ ?>
            <p>&nbsp; <?php echo (int)$x->discount1_nominal ?><?php echo ($x->discount1_type == 1)?"%":""; ?></p>
          <?php }elseif($x->discount_step == 2){ ?>
            <p>&nbsp; 1. <?php echo (int)$x->discount1_nominal ?><?php echo ($x->discount1_type == 1)?"%":""; ?></p>
            <p>&nbsp; 2. <?php echo (int)$x->discount2_nominal ?><?php echo ($x->discount2_type == 1)?"%":""; ?></p>
          <?php }elseif($x->discount_step == 3){ ?>
            <p>&nbsp; 1. <?php echo (int)$x->discount1_nominal ?><?php echo ($x->discount1_type == 1)?"%":""; ?></p>
            <p>&nbsp; 2. <?php echo (int)$x->discount2_nominal ?><?php echo ($x->discount2_type == 1)?"%":""; ?></p>
            <p>&nbsp; 3. <?php echo (int)$x->discount3_nominal ?><?php echo ($x->discount3_type == 1)?"%":""; ?></p>
          <?php }elseif($x->discount_step == 4){ ?>
            <p>&nbsp; 1. <?php echo (int)$x->discount1_nominal ?><?php echo ($x->discount1_type == 1)?"%":""; ?></p>
            <p>&nbsp; 2. <?php echo (int)$x->discount2_nominal ?><?php echo ($x->discount2_type == 1)?"%":""; ?></p>
            <p>&nbsp; 3. <?php echo (int)$x->discount3_nominal ?><?php echo ($x->discount3_type == 1)?"%":""; ?></p>
            <p>&nbsp; 4. <?php echo (int)$x->discount4_nominal ?><?php echo ($x->discount4_type == 1)?"%":""; ?></p>
          <?php }elseif($x->discount_step == 5){ ?>
            <p>&nbsp; 1. <?php echo (int)$x->discount1_nominal ?><?php echo ($x->discount1_type == 1)?"%":""; ?></p>
            <p>&nbsp; 2. <?php echo (int)$x->discount2_nominal ?><?php echo ($x->discount2_type == 1)?"%":""; ?></p>
            <p>&nbsp; 3. <?php echo (int)$x->discount3_nominal ?><?php echo ($x->discount3_type == 1)?"%":""; ?></p>
            <p>&nbsp; 4. <?php echo (int)$x->discount4_nominal ?><?php echo ($x->discount4_type == 1)?"%":""; ?></p>
            <p>&nbsp; 5. <?php echo (int)$x->discount5_nominal ?><?php echo ($x->discount5_type == 1)?"%":""; ?></p>
          <?php } ?>
        </td>
        <td style="text-align:right">Rp. <?php echo number_format($x->total_price,2,',','.') ?> &nbsp; </td>
      </tr>
      <?php $no++; } ?>
      <tr class="r">
        <td colspan="5" class="result">Sub Total</td>
        <td style="text-align:right">Rp. <?php echo number_format($po->subtotal,2,',','.') ?> &nbsp; </td>
      </tr>
      <tr class="r">
        <td colspan="5" class="result">PPN</td>
        <td style="text-align:right">Rp. <?php echo number_format($po->ppn_price,2,',','.') ?> &nbsp; </td>
      </tr>
      <tr class="r">
        <td colspan="5" class="result">Total</td>
        <td style="text-align:right">Rp. <?php echo number_format($po->total_price,2,',','.') ?> &nbsp; </td>
      </tr>
    </table>


    <p class="authorized"><?php echo tanggal(date('Y-m-d')); ?></p>
  </div>
</div>
