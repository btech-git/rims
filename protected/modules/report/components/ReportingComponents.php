<?php
class ReportingComponents extends CComponent
{
    public function getListBrandOil()
    {
        /* id for oil */
        $brand = array(1,2,8); 
        return $brand;
    }

    public function getListBrandTire()
    {
        /* id for tire */
        $brand = array(2,3,4,5,6,7,8); 
        return $brand;
    }

    public function getListProduct($param = array()) {
		return $param;
    }

    public function getListSparepart() {
        $sparepart = [
            1=>"Oil",
            2=>"Tire - Rims",
            3=>"Tire - Bias",
            4=>"Accu - Battery",
            5=>"Accessories - Variation",
            6=>"Parts - General",
            7=>"A/C Material",
            8=>"Parts - B. Repair",
            9=>"Parts - Sperklpan",
            0=>"Other"
        ];
        return $sparepart;
    }

    public function getSparepartId ($id) {
        switch ($id) {
            case 1:
                return array(1,2,3,4,5,6,7,8);
                break;
            case 2:
                return array(1,2,8);
                break;
            case 3:
                return array(3);
                break;
            case 4:
                return array(1);
                break;
            case 5:
                return array(1);
                break;
            case 6:
                return array(1);
                break;
            case 7:
                return array(7);
                break;
            case 8:
                return array(1);
                break;
            case 9:
                return array(1);
                break;
            default:
                return array(1);
        }
    }

    public function getStock($productid,$branchid) {
        $getWarehouse = Warehouse::model()->findAllByAttributes(["branch_id"=>$branchid]);
        if ($getWarehouse == NULL) {
            $totalstok = 0;
        }else{
            $totalstok = 0;
            foreach ($getWarehouse as $key => $value) {
                $inventoryStock = Inventory::model()->findByAttributes(['product_id'=>$productid,'warehouse_id'=>$value->id]);
                if ($inventoryStock != NULL) {
                    $totalstok = $totalstok + $inventoryStock->total_stock;
                }else{
                    $totalstok =0;
                }
                
            }
        }
        return $totalstok;
    }

    public function getStockDate($productid,$branchid,$tanggal) {
        // return 999;
        $getWarehouse = Warehouse::model()->findAllByAttributes(["branch_id"=>$branchid]);
        if ($getWarehouse == NULL) {
            $totalstok = 0;
        }else{
            $totalstok = 0;
            foreach ($getWarehouse as $key => $value) {
                /*$inventoryStock = Inventory::model()->findByAttributes(['product_id'=>$productid,'warehouse_id'=>$value->id]);
                if ($inventoryStock != NULL) {
                    $totalstok = $totalstok + $inventoryStock->total_stock;
                }else{
                    $totalstok =0;
                }*/

                $inventoryStock = InventoryDetail::model()->findAllByAttributes(['product_id'=>$productid,'warehouse_id'=>$value->id,'transaction_date'=>$tanggal]);
                if ($inventoryStock != NULL) {
                    foreach ($inventoryStock as $keya => $valuea) {
                        # code...
                        $totalstok = $totalstok + $valuea->stock_in;
                    }
                }else{
                    $totalstok =0;
                }
            }
        }
        return $totalstok;
    }
    
    public function getRekapHarian($tgl = '2017-02-02',$branch = 1,$product =1) {
        // $salesorder = TransactionSalesOrder::model()->findAllByAttributes(['sale_order_date']=>$tgl);

        $totalPenjualan = 0;
        $criteria = new CDbCriteria();
        $criteria->with = array('registrationTransaction');
        $criteria->compare('registrationTransaction.branch_id', $branch, true);
        $criteria->compare('registrationTransaction.transaction_date', $tgl, true);
        $criteria->compare('t.product_id', $product, true);
        // find all posts
        $salesOrder = RegistrationProduct::model()->findAll($criteria);

        if ($salesOrder !=NULL) {
            foreach($salesOrder as $post)
            {
                $totalPenjualan += $post->quantity;
            }
            return $totalPenjualan;
        }else{
            return '0';
        }
    }

    public function getRekapBulanan($bulan ,$branch = 1,$product =1) {
        // $salesorder = TransactionSalesOrder::model()->findAllByAttributes(['sale_order_date']=>$tgl);

        $totalPenjualan = 0;
        $criteria = new CDbCriteria();
        $criteria->with = array('transactionSalesOrderDetails');
        $criteria->compare('t.requester_branch_id', $branch, true);
        // $criteria->compare('t.sale_order_date', $tgl, true);
        $criteria->addBetweenCondition('t.sale_order_date', date("Y-m-01", strtotime($bulan)), date("Y-m-t", strtotime($bulan)));
        
        $criteria->compare('transactionSalesOrderDetails.product_id', $product, true);
        // find all posts
        $salesOrder = TransactionSalesOrder::model()->findAll($criteria);

        if ($salesOrder !=NULL) {
            foreach($salesOrder as $post)
            {
                $totalPenjualan = $totalPenjualan + $post->total_quantity;
            }
            return $totalPenjualan;
        }else{
            return '0';
        }
        // return 0;
    }

    public function getRekapTahunan($tahun ,$product) {
        // $salesorder = TransactionSalesOrder::model()->findAllByAttributes(['sale_order_date']=>$tgl);

        $totalPenjualan = 0;
        $criteria = new CDbCriteria();
        $criteria->with = array('transactionSalesOrderDetails');
        // $criteria->compare('t.requester_branch_id', $branch, true);
        $criteria->addBetweenCondition('t.sale_order_date', date("Y-m-01", strtotime($tahun)), date("Y-m-t", strtotime($tahun)));
        
        $criteria->compare('transactionSalesOrderDetails.product_id', $product, true);
        // find all posts
        $salesOrder = TransactionSalesOrder::model()->findAll($criteria);

        if ($salesOrder !=NULL) {
            foreach($salesOrder as $post)
            {
                $totalPenjualan = $totalPenjualan + $post->total_quantity;
            }
            return (int) $totalPenjualan;
        }else{
            return '0';
        }
        // return 0;
    }
}