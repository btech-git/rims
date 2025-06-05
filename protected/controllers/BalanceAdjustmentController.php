<?php

class BalanceAdjustmentController extends Controller {
    
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
        if (($handle = fopen("/home/pmahendro/Documents/balance_adjustment/{$f}.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                if ($row > 1) {
                    $csvData[] = $data;
                } else {
                    $headerInfo = $data;
                }
                $row++;
            }
            fclose($handle);
            $balanceDifferenceData = self::getBalanceDifferenceData($csvData, $headerInfo);
            
            self::makeButton();
            var_dump($balanceDifferenceData);
            
            if (isset($_POST['Submit'])) {
                $this->save($headerInfo, $balanceDifferenceData);
            }
        }
    }

    public function save($headerInfo, $balanceDifferenceData) {
        $dbTransaction = Yii::app()->db->beginTransaction();
        try {
            $branchId = $headerInfo[0];
            $transactionDate = $headerInfo[1];
            $valid = true;
            foreach ($balanceDifferenceData as $coaId => $balanceDifference) {
                $normalBalance = Coa::model()->findByPk($coaId)->normal_balance;
                $jurnalUmum = new JurnalUmum();
                $jurnalUmum->kode_transaksi = 'Balance Adjustment';
                $jurnalUmum->tanggal_transaksi = $transactionDate;
                $jurnalUmum->coa_id = $coaId;
                $jurnalUmum->branch_id = $branchId;
                $jurnalUmum->total = $balanceDifference;
                $jurnalUmum->debet_kredit = $normalBalance == 'DEBIT' ? 'D' : 'K';
                $jurnalUmum->tanggal_posting = date('Y-m-d');
                $jurnalUmum->transaction_subject = 'Balance Adjustment';
                $jurnalUmum->transaction_type = 'ADJ';
                $jurnalUmum->is_coa_category = 0;
                $jurnalUmum->remark = 'Balance Adjustment';
                $valid = $valid && $jurnalUmum->save(false);
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

    public static function getBalanceDifferenceData($csvData, $headerInfo) {
        $balanceDifferenceData = array();
        $balanceData = self::getBalanceData($headerInfo[1], $headerInfo[0]);
        foreach ($csvData as $csvItem) {
            $csvBalance = $csvItem[1];
            $dbBalance = isset($balanceData[$csvItem[0]]) ? $balanceData[$csvItem[0]] : 0;
            $balanceDifference = $csvBalance - $dbBalance;
            if ($balanceDifference != 0) {
                $balanceDifferenceData[$csvItem[0]] = $balanceDifference;
            }
        }

        return $balanceDifferenceData;
    }

    public static function getCoaBalanceData($transactionDate, $branchId) {
        $sql = "SELECT j.coa_id, COALESCE(SUM(
                    CASE c.normal_balance
                        WHEN 'DEBIT' THEN CASE j.debet_kredit WHEN 'D' THEN +j.total WHEN 'K' THEN -j.total ELSE 0 END
                        WHEN 'KREDIT' THEN CASE j.debet_kredit WHEN 'K' THEN +j.total WHEN 'D' THEN -j.total ELSE 0 END
                        ELSE 0
                    END
                ), 0) AS balance
                FROM rims_jurnal_umum j
                INNER JOIN rims_coa c ON c.id = j.coa_id
                WHERE j.tanggal_transaksi < :tanggal_transaksi AND j.branch_id = :branch_id
                GROUP BY j.coa_id
                ORDER BY j.coa_id ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':tanggal_transaksi' => $transactionDate, 
            ':branch_id' => $branchId,
        ));

        return $resultSet;
    }

    public static function getBalanceData($transactionDate, $branchId) {
        $coaCurrentBalanceData = self::getCoaBalanceData($transactionDate, $branchId);
        $balanceData = array();
        foreach ($coaCurrentBalanceData as $coaCurrentBalanceItem) {
            $balanceData[$coaCurrentBalanceItem['coa_id']] = $coaCurrentBalanceItem['balance'];
        }

        return $balanceData;
    }
}