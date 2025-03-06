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
            $headerStockData = self::getHeaderData($stockDifferenceData, $headerInfo);
            
            self::makeButton();
            var_dump($headerStockData);
            var_dump($stockDifferenceData);
            
            if (isset($_POST['Submit'])) {
                self::save($headerInfo[0], $headerStockData, $stockDifferenceData);
            }
        }
    }

    public static function save($warehouseId, $headerStockData, $stockDifferenceData) {
        $inventoryHeaders = array();
        foreach ($headerStockData as $productId => $totalStock) {
            $inventoryHeader = Inventory::model()->findByAttributes(array('product_id' => $productId, 'warehouse_id' => $warehouseId));
            if ($inventoryHeader === null) {
                $model = new Inventory();
                $model->product_id = $productId;
                $model->warehouse_id = $warehouseId;
                $model->total_stock = $totalStock;
                $model->minimal_stock = '0.00';
                $model->status = 'Active';
                $model->category = null;
                $model->inventory_result = null;
                $inventoryHeaders[] = $model;
            } else {
                $inventoryHeader->total_stock = $totalStock;
                $inventoryHeaders[] = $inventoryHeader;
            }
        }
        var_dump($inventoryHeaders);
    }

    public static function makeButton() {
        echo CHtml::beginForm();
        echo CHtml::submitButton('Execute', array('name' => 'Submit'));
        echo CHtml::endForm();
    }

    public static function getHeaderData($stockDifferenceData, $headerInfo) {
        $productIds = array_keys($stockDifferenceData);
        $productCurrentStockData = self::getProductCurrentStockData($headerInfo[0], $productIds);
        $headerStockData = array();
        foreach ($productCurrentStockData as $productCurrentStockItem) {
            $headerStockData[$productCurrentStockItem['product_id']] = $productCurrentStockItem['stock'];
        }

        return $headerStockData;
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