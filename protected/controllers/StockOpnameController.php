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
            $stockDifferenceData = array();
            $stockData = self::getStockData($headerInfo[1], $headerInfo[0]);
            foreach ($csvData as $csvItem) {
                $csvStock = $csvItem[1];
                $dbStock = isset($stockData[$csvItem[0]]) ? $stockData[$csvItem[0]] : 0;
                $stockDifferenceData[$csvItem[0]] = $csvStock - $dbStock;
            }
            var_dump($stockDifferenceData);
//            var_dump($stockData);
        }
//        var_dump($headerInfo);
        var_dump($csvData);
    }

    public static function getProductCurrentStockData($transactionDate, $warehouseId) {
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

    public static function getStockData($transactionDate, $warehouseId) {
        $productCurrentStockData = self::getProductCurrentStockData($transactionDate, $warehouseId);
        $stockData = array();
        foreach ($productCurrentStockData as $productCurrentStockItem) {
            $stockData[$productCurrentStockItem['product_id']] = $productCurrentStockItem['stock'];
        }

        return $stockData;
    }
}