<?php

class StockOpnameController extends Controller {
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {

        $filterChain->run();
    }

    public function actionRun($f) {
        $headerInfo = array();
        $csvData = array();
        $row = 1;
        if (($handle = fopen("/home/pmahendro/Documents/stock_opname/{$f}.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                if ($row > 1) {
                    $csvData[] = $data;
                } else {
                    $headerInfo = $data;
                }
                $row++;
            }
            fclose($handle);
            $stockDifferenceData = self::getStockDifferenceData($csvData, $headerInfo);
            list($headerStockData, $headerIdData) = self::getHeaderData($stockDifferenceData, $headerInfo[0]);
            
            self::makeButton();
            var_dump($headerIdData);
            var_dump($headerStockData);
            var_dump($stockDifferenceData);
            
            if (isset($_POST['Submit'])) {
                $this->save($headerInfo, $headerIdData, $headerStockData, $stockDifferenceData);
            }
        }
    }

    public function save($headerInfo, &$headerIdData, $headerStockData, $stockDifferenceData) {
        $dbTransaction = Yii::app()->db->beginTransaction();
        try {
            $warehouseId = $headerInfo[0];
            $transactionDate = $headerInfo[1];
            $valid = true;
            foreach ($stockDifferenceData as $productId => $stockDifference) {
                if (!isset($headerIdData[$productId])) {
                    $inventoryHeader = new Inventory();
                    $inventoryHeader->product_id = $productId;
                    $inventoryHeader->warehouse_id = $warehouseId;
                    $inventoryHeader->total_stock = '0.00';
                    $inventoryHeader->minimal_stock = '0.00';
                    $inventoryHeader->status = 'Active';
                    $inventoryHeader->category = null;
                    $inventoryHeader->inventory_result = null;
                    $valid = $valid && $inventoryHeader->save(false);
                    $headerIdData[$productId] = $inventoryHeader->id;
                }
                $inventoryDetail = new InventoryDetail();
                $inventoryDetail->inventory_id = $headerIdData[$productId];
                $inventoryDetail->product_id = $productId;
                $inventoryDetail->warehouse_id = $warehouseId;
                $inventoryDetail->transaction_type = 'Opname';
                $inventoryDetail->transaction_number = 'Stock Opname';
                $inventoryDetail->transaction_date = $transactionDate;
                $inventoryDetail->stock_in = $stockDifference > 0 ? $stockDifference : 0;
                $inventoryDetail->stock_out = $stockDifference < 0 ? $stockDifference : 0;
                $inventoryDetail->purchase_price = '0.00';
                $inventoryDetail->notes = '';
                $inventoryDetail->transaction_time = '00:00:01';
                $valid = $valid && $inventoryDetail->save(false);

                $inventoryDetail->inventory->total_stock = $headerStockData[$productId] + $stockDifference;
                $valid = $valid && $inventoryDetail->inventory->save();
            }
            if ($valid) {
                $dbTransaction->commit();
                echo 'Success!';
            } else {
                $dbTransaction->rollback();
                echo 'Failed!';
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            echo $e->getMessage();
        }
    }

    public static function makeButton() {
        echo CHtml::beginForm();
        echo CHtml::submitButton('Execute', array('name' => 'Submit'));
        echo CHtml::endForm();
    }

    public static function getHeaderData($stockDifferenceData, $warehouseId) {
        $productIds = array_keys($stockDifferenceData);
        $productCurrentStockData = self::getProductCurrentStockData($warehouseId, $productIds);
        $headerStockData = array();
        $headerIdData = array();
        foreach ($productCurrentStockData as $productCurrentStockItem) {
            $inventoryHeader = Inventory::model()->findByAttributes(array('product_id' => $productCurrentStockItem['product_id'], 'warehouse_id' => $warehouseId));
            $headerStockData[$productCurrentStockItem['product_id']] = $productCurrentStockItem['stock'];
            if ($inventoryHeader !== null) {
                $headerIdData[$productCurrentStockItem['product_id']] = $inventoryHeader->id;
            }
        }

        return array($headerStockData, $headerIdData);
    }

    public static function getStockDifferenceData($csvData, $headerInfo) {
        $stockDifferenceData = array();
        $stockData = self::getStockData($headerInfo[1], $headerInfo[0]);
        foreach ($csvData as $csvItem) {
            $csvStock = $csvItem[1];
            $dbStock = isset($stockData[$csvItem[0]]) ? $stockData[$csvItem[0]] : 0;
            $stockDifference = $csvStock - $dbStock;
            if ($stockDifference != 0) {
                $stockDifferenceData[$csvItem[0]] = $stockDifference;
            }
        }

        return $stockDifferenceData;
    }

    public static function getProductStockData($transactionDate, $warehouseId) {
        $sql = "SELECT product_id, SUM(stock_in + stock_out) AS stock
                FROM rims_inventory_detail 
                WHERE transaction_date <= :transaction_date AND warehouse_id = :warehouse_id
                GROUP BY product_id
                ORDER BY product_id ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':transaction_date' => $transactionDate, 
            ':warehouse_id' => $warehouseId,
        ));

        return $resultSet;
    }

    public static function getProductCurrentStockData($warehouseId, $productIds) {
        $sql = "SELECT product_id, SUM(stock_in + stock_out) AS stock
                FROM rims_inventory_detail 
                WHERE warehouse_id = :warehouse_id AND product_id IN (" . implode(',', $productIds) . ")
                GROUP BY product_id
                ORDER BY product_id ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':warehouse_id' => $warehouseId,
        ));

        return $resultSet;
    }

    public static function getStockData($transactionDate, $warehouseId) {
        $productCurrentStockData = self::getProductStockData($transactionDate, $warehouseId);
        $stockData = array();
        foreach ($productCurrentStockData as $productCurrentStockItem) {
            $stockData[$productCurrentStockItem['product_id']] = $productCurrentStockItem['stock'];
        }

        return $stockData;
    }
}