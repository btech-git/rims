<?php

class AssetDepreciation extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function addAsset() {

        $assetPurchases = AssetPurchase::model()->findAll(array('condition' => 't.current_value > 0 AND t.status <> "Sold"'));

        if (!empty($assetPurchases)) {
            foreach ($assetPurchases as $assetPurchase) {
                $assetDepreciationDetail = AssetDepreciationDetail::model()->findByAttributes(array('asset_purchase_id' => $assetPurchase->id), array('order' => 'depreciation_date DESC'));
                
                if (empty($assetDepreciationDetail)) {
                    $transactionDate = $assetPurchase->transaction_date;
                } else {
                    $depreciationDate = strtotime($assetDepreciationDetail->depreciation_date);
                    $transactionDate = date('Y-m-d', strtotime('+ 1month', $depreciationDate));
                }
                
                list($year, $month, ) = explode('-', $transactionDate);
                $startDate = $year . '-' . $month . '-01';
                $endDate = date_create(date('Y-m-t'));

                for ($currentDate = date_create($startDate); $currentDate < $endDate; $currentDate->add(new DateInterval('P1M'))) {
                    $detail = new AssetDepreciationDetail;
                    $detail->asset_purchase_id = $assetPurchase->id;
                    $detail->amount = $assetPurchase->monthlyDepreciationAmount;
                    $detail->depreciation_date = $currentDate->format('Y-m-t');
                    $this->details[] = $detail;
                }
            }

        } else {
            $this->header->addError('error', 'Invoice tidak ada di dalam detail');
        }
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;

            foreach ($this->details as $detail) {
                $valid = $valid && $detail->delete();
            }

            $valid = $valid && $this->header->delete();

            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $this->validateDetailsCount() && $valid;
//        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('amount', 'asset_purchase_id');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = false;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        
        if (count($this->details) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j) {
                    continue;
                }

                if ($this->details[$i]->asset_purchase_id === $this->details[$j]->asset_purchase_id) {
                    $valid = false;
                    $this->header->addError('error', 'Asset tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function flush() {
        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $this->header->transaction_number,
        ));

        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->amount <= 0.00) {
                continue;
            }

            $detail->asset_depreciation_header_id = $this->header->id;
            $detail->save();

            $assetPurchase = AssetPurchase::model()->findByPk($detail->asset_purchase_id);
            $assetPurchase->accumulated_depreciation_value = $assetPurchase->totalDepreciationValue;
            $assetPurchase->current_value = $assetPurchase->purchase_value - $assetPurchase->totalDepreciationValue;
            $assetPurchase->status = 'Depresiasi';
            $assetPurchase->update(array('accumulated_depreciation_value', 'current_value', 'status'));

            $assetCategory = AssetCategory::model()->findByPk($assetPurchase->asset_category_id);
            $jurnalExpense = new JurnalUmum;
            $jurnalExpense->kode_transaksi = $this->header->transaction_number;
            $jurnalExpense->tanggal_transaksi = $detail->depreciation_date;
            $jurnalExpense->coa_id = $assetCategory->coa_expense_id;
            $jurnalExpense->branch_id = 6;
            $jurnalExpense->total = $detail->amount;
            $jurnalExpense->debet_kredit = 'D';
            $jurnalExpense->tanggal_posting = date('Y-m-d');
            $jurnalExpense->transaction_subject = $assetPurchase->transaction_number;
            $jurnalExpense->is_coa_category = 0;
            $jurnalExpense->transaction_type = 'DFA';
            $jurnalExpense->save();

            $jurnalAccumulation = new JurnalUmum;
            $jurnalAccumulation->kode_transaksi = $this->header->transaction_number;
            $jurnalAccumulation->tanggal_transaksi = $detail->depreciation_date;
            $jurnalAccumulation->coa_id = $assetCategory->coa_accumulation_id;
            $jurnalAccumulation->branch_id = 6;
            $jurnalAccumulation->total = $detail->amount;
            $jurnalAccumulation->debet_kredit = 'K';
            $jurnalAccumulation->tanggal_posting = date('Y-m-d');
            $jurnalAccumulation->transaction_subject = $assetPurchase->transaction_number;
            $jurnalAccumulation->is_coa_category = 0;
            $jurnalAccumulation->transaction_type = 'DFA';
            $jurnalAccumulation->save();
        }

        return $valid;
    }
    
    public function getTotalDetail() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }
}
