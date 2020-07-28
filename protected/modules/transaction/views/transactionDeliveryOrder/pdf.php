<?php
date_default_timezone_set('Asia/Jakarta');
function tanggal($date){
    $bulan = array('Januari','Februari','Maret','April','Mei','Juni','July','Agustus','September','Oktober','November','Desember');
    $tahun = substr($date,0,4);
    $bulan2 = substr($date,5,2);
    $tanggal = substr($date,8,2);

    return $tanggal.' '.$bulan[(int)$bulan2 - 1]. ' '.$tahun;
}

if ($model->customer->customerPhones == NULL) {
    $phonenumber = '';
}else{
    foreach ($model->customer->customerPhones as $key => $value) {
        $phonenumber = $value->phone_no . ', ';
    }
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
    <td><p class="rapad" style="padding-top: 20px;">JL. Kalimalang, No. 8, Kampung Dua,<br />
        Bekasi City, West Java. <br />
        Tlp. (021) 8843656</p></td>
    </tr>
</table>
</div>
<div class="right">
    <h3>Surat Jalan</h3>
    <table>
        <tr>
            <td>Date</td>
            <td>:</td>
            <td><?php echo tanggal($model->delivery_date) ?></td>
        </tr>
        <tr>
            <td>No DO#</td>
            <td>:</td>
            <td><?php echo $model->delivery_order_no ?></td>
        </tr>
        <tr>
            <td>Invoice#</td>
            <td>:</td>
            <td><?php //echo $model->delivery_order_no ?></td>
        </tr>
    </table>
</div>
</div>
<div class="supplier">
    <div class="left">

        <table>
            <tr>
                <td colspan="3">Kepada Yth,</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>:</td>
                <td><?php echo $model->customer->name; ?></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>:</td>
                <td><?php echo $phonenumber; ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td>:</td>
                <td><?php echo !empty($model->customer->address)?$model->customer->address.", ": ""; ?><?php echo $model->customer->city->name; ?>  <?php echo $model->customer->province->name; ?> <?php echo $model->customer->zipcode; ?></td>
            </tr>
        </table>
    </div>

    <div class="right">
        <?php /*
        <?php if ($model->request_type =='Sales Order'): ?>
            <div class="row">
                <div class="small-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">SO no</label>
                            </div>
                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->salesOrder != "" ? $model->salesOrder->sale_order_no : ''; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif($model->request_type =='Sent Request'): ?>
            <div class="row">
                <div class="small-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Sent Request no</label>
                            </div>
                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->sentRequest != NULL ? $model->sentRequest->sent_request_no : ''; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Destination Branch</label>
                            </div>
                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->destination_branch == NULL?'-':$model->destinationBranch->name; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($model->request_type =='Consignment Out') : ?>
            <div class="row">
                <div class="small-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Consignment Out</label>
                            </div>
                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->consignmentOut != NULL ? $model->consignmentOut->consignment_out_no : ''; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($model->request_type =='Transfer Request') : ?>
            <div class="row">
                <div class="small-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Transfer Request</label>
                            </div>
                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->transferRequest != NULL ? $model->transferRequest->transfer_request_no : ''; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Destination Branch</label>
                            </div>
                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->destination_branch == NULL?'-':$model->destinationBranch->name; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>*/?>
    </div>
</div>
<div class="purchase-order">
    <div class="detail">
        <?php if (count($deliveryDetails)>0): ?>
            <table>
                <thead>
                    <tr>
                        <th width="30%">Product Name</th>
                        <th width="10%">Quantity</th>
                        <th width="60%">Notes</th>
                    </tr>
                </thead>
                <tbody style="height: 100px;">
                    <?php foreach ($deliveryDetails as $key => $deliveryDetail): ?>
                        <tr>
                            <td><?php echo $deliveryDetail->product->name == ''?'-':$deliveryDetail->product->name; ?></td>
                            <td><?php echo $deliveryDetail->quantity_request == ''?'-':$deliveryDetail->quantity_request; ?></td>
                            <td><?php echo $deliveryDetail->note== ''?'-':$deliveryDetail->note; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>    
        <?php else: ?>
            <?php echo 'No Details Available'; ?>
        <?php endif ?>
        <table>
            <tr>
                <td width="30%">Notes :</td>
                <td width="70%">
                    <ol>
                        <li>surat jalan ini merupakan bukti resmi penerimaan barang</li>
                        <li>surat jalan ini bukan bukti penjualan</li>
                        <li>surat jalan ini akan dilenkapi sebagai bukti penjualan</li>
                    </ol>
                </td>
            </tr>
        </table>

    </div>
</div>
<div class="detail-notes">
<table width="100%">
    <tr>
        <td class="tengah">Penerima/Customer</td>
        <td class="tengah">Bagian Pengiriman</td>
        <td class="tengah">Petugas Gudang</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="tengah h250"><div class="garisbawah">Penerima/Customer</div></td>
        <td class="tengah h250"><div class="garisbawah">Bagian Pengiriman</div></td>
        <td class="tengah h250"><div class="garisbawah">Petugas Gudang</div></td>
    </tr>
</table>
</div>
</div>
