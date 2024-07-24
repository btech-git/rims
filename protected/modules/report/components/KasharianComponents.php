<?php

class KasharianComponents extends CComponent {

    public function getListBank() {
        $bank = array(23, 43, 63, 93, 133, 163);
        return $bank;
    }

    public function getCashin($tanggal, $branch) {
        $total = 0;
        $cashin = PaymentIn::model()->findAllByAttributes(array(
            'payment_date' => $tanggal,
            'branch_id' => $branch,
            'payment_type' => 'Cash'
        ));

        foreach ($cashin as $key => $value) {
            $total = $total + $value->payment_amount;
        }

        return $total;
    }

    public function getCashout($tanggal, $branch) {
        $total = 0;
        $cashin = PaymentOut::model()->findAllByAttributes(array(
            'payment_date' => $tanggal,
            'branch_id' => $branch,
            'payment_type' => 'Cash'
        ));
        foreach ($cashin as $key => $value) {
            $total = $total + $value->payment_amount;
        }
        return $total;
    }

    public function getCredit($tanggal, $branch, $bank) {
        $total = 0;

        if ($bank == 3) {
            $cashin = PaymentIn::model()->findAllByAttributes(array(
                'payment_date' => $tanggal,
                'branch_id' => $branch,
                'payment_type' => 'Credit',
                'bank_id' => 3
            ));

            foreach ($cashin as $key => $value) {
                $total = $total + $value->payment_amount;
            }
        } elseif ($bank == 7) {
            $cashin = PaymentIn::model()->findAllByAttributes(array('payment_date' => $tanggal, 'branch_id' => $branch, 'payment_type' => 'Credit', 'bank_id' => 7));

            foreach ($cashin as $key => $value) {
                $total = $total + $value->payment_amount;
            }
        } else {
            return $total;
        }

        return $total;
    }

    public function getCreditCout($tanggal, $branch, $bank) {
        $total = 0;
        if ($bank == 3) {
            $cashin = PaymentOut::model()->findAllByAttributes(array('payment_date' => $tanggal, 'branch_id' => $branch, 'payment_type' => 'Credit', 'bank_id' => 3));
            foreach ($cashin as $key => $value) {
                $total = $total + $value->payment_amount;
            }
        } elseif ($bank == 7) {
            $cashin = PaymentOut::model()->findAllByAttributes(array('payment_date' => $tanggal, 'branch_id' => $branch, 'payment_type' => 'Credit', 'bank_id' => 7));
            foreach ($cashin as $key => $value) {
                $total = $total + $value->payment_amount;
            }
        } else {
            return $total;
        }
        return $total;
    }

    public function getDebit($tanggal, $branch, $bank) {
        $total = 0;
        if ($bank == 3) {
            $cashin = PaymentIn::model()->findAllByAttributes(array('payment_date' => $tanggal, 'branch_id' => $branch, 'payment_type' => 'Debit', 'bank_id' => 3));
            foreach ($cashin as $key => $value) {
                $total = $total + $value->payment_amount;
            }
        } elseif ($bank == 7) {
            $cashin = PaymentIn::model()->findAllByAttributes(array('payment_date' => $tanggal, 'branch_id' => $branch, 'payment_type' => 'Debit', 'bank_id' => 7));
            foreach ($cashin as $key => $value) {
                $total = $total + $value->payment_amount;
            }
        } else {
            return $total;
        }

        return $total;
    }

    public function getDebitCout($tanggal, $branch, $bank) {
        $total = 0;
        if ($bank == 3) {
            $cashin = PaymentOut::model()->findAllByAttributes(array('payment_date' => $tanggal, 'branch_id' => $branch, 'payment_type' => 'Debit', 'bank_id' => 3));
            foreach ($cashin as $key => $value) {
                $total = $total + $value->payment_amount;
            }
        } elseif ($bank == 7) {
            $cashin = PaymentOut::model()->findAllByAttributes(array('payment_date' => $tanggal, 'branch_id' => $branch, 'payment_type' => 'Debit', 'bank_id' => 7));
            foreach ($cashin as $key => $value) {
                $total = $total + $value->payment_amount;
            }
        } else {
            return $total;
        }

        return $total;
    }

    public function getPiutang($tanggal, $branch) {
        $total = 0;
        $cashin = TransactionSalesOrder::model()->findAllByAttributes(array('sale_order_date' => $tanggal, 'requester_branch_id' => $branch));
        foreach ($cashin as $key => $value) {
            $total = $total + $value->total_price;
        }
        return $total;
    }

    public function getPiutangCout($tanggal, $branch) {
        $total = 0;
        $cashin = TransactionPurchaseOrder::model()->findAllByAttributes(array('purchase_order_date' => $tanggal, 'main_branch_id' => $branch));
        foreach ($cashin as $key => $value) {
            $total = $total + $value->total_price;
        }
        return $total;
    }

    public function getDp($tanggal, $branch) {
        return 0;
    }

    public function getSetorbank($tanggal, $bank_id) {
        $total = 0;
        $cashin = CashTransaction::model()->findAllByAttributes(array('transaction_date' => $tanggal, 'coa_id' => $bank_id, 'transaction_type' => 'In', 'status' => 'Approved'));
        foreach ($cashin as $key => $value) {
            $total = $total + $value->credit_amount;
        }
        return $total;
    }

    public function getSetorbankTotal($tanggal) {
        $total = 0;
        $bankid = $this->getListBank();

        $criteria = new CDbCriteria;
        $criteria->addInCondition('coa_id', $bankid);
        $criteria->compare('transaction_date', $tanggal);
        $criteria->compare('transaction_type', 'In');
        $criteria->compare('status', 'Approved');
        $cashin = CashTransaction::model()->findAll($criteria);

        foreach ($cashin as $key => $value) {
            $total = $total + $value->credit_amount;
        }
        return $total;
    }

    public function getSaldoAwalBank($tanggal, $bank_id, $type = 'In') {
        $startDate = date("Y-m-01", strtotime($tanggal));
        $endDate = date("Y-m-d", strtotime("-1 days", strtotime($tanggal)));

        $totalin = 0;
        $totalout = 0;

        $criteriain = new CDbCriteria;
        $criteriain->compare('coa_id', $bank_id);
        $criteriain->compare('transaction_type', $type);
        $criteriain->addBetweenCondition('transaction_date', $startDate, $endDate);

        $cashin = CashTransaction::model()->findAll($criteriain);
        foreach ($cashin as $key => $value) {
            if ($type == 'In') {
                $totalin = $totalin + $value->credit_amount;
            } else {
                $totalout = $totalout + $value->debit_amount;
            }
        }

        if ($type == 'In') {
            return $totalin;
        } else {
            return $totalout;
        }
    }

    public function getSaldoAkhirBank($tanggal, $bank_id) {
        $totalin = 0;
        $totalout = 0;

        $criteriain = new CDbCriteria;
        $criteriain->compare('coa_id', $bank_id);
        $criteriain->compare('transaction_date', $tanggal);
        $criteriain->compare('transaction_type', 'In');
        $cashin = CashTransaction::model()->findAll($criteriain);

        foreach ($cashin as $key => $value) {
            $totalin = $totalin + $value->credit_amount;
        }

        $criteriaout = new CDbCriteria;
        $criteriaout->compare('coa_id', $bank_id);
        $criteriaout->compare('transaction_date', $tanggal);
        $criteriaout->compare('transaction_type', 'Out');

        $cashout = CashTransaction::model()->findAll($criteriaout);

        // var_dump($cashin); die();
        foreach ($cashout as $key => $value) {
            $totalout = $totalout + $value->debit_amount;
        }
        $total = ($totalin - $totalout);

        return ($total < 0) ? 0 : $total;
    }

    public function getSaldoAwal($tanggal, $branchid, $type = 'In') {
        $startDate = date("Y-m-01", strtotime($tanggal));
        $endDate = date("Y-m-d", strtotime("-1 days", strtotime($tanggal)));

        $totalin = 0;
        $totalout = 0;

        $criteriain = new CDbCriteria;
        $criteriain->compare('branch_id', $branchid);
        $criteriain->compare('transaction_type', $type);
        $criteriain->addBetweenCondition('transaction_date', $startDate, $endDate);

        $cashin = CashTransaction::model()->findAll($criteriain);
        foreach ($cashin as $key => $value) {
            if ($type == 'In') {
                $totalin = $totalin + $value->credit_amount;
            } else {
                $totalout = $totalout + $value->debit_amount;
            }
        }

        if ($type == 'In') {
            return $totalin;
        } else {
            return $totalout;
        }
    }

    public function getSaldoAkhir($tanggal, $branchid) {
        $totalin = 0;
        $totalout = 0;

        $criteriain = new CDbCriteria;
        $criteriain->compare('branch_id', $branchid);
        $criteriain->compare('transaction_date', $tanggal);
        $criteriain->compare('transaction_type', 'In');
        $cashin = CashTransaction::model()->findAll($criteriain);

        foreach ($cashin as $key => $value) {
            $totalin = $totalin + $value->credit_amount;
        }

        $criteriaout = new CDbCriteria;
        $criteriaout->compare('branch_id', $branchid);
        $criteriaout->compare('transaction_date', $tanggal);
        $criteriaout->compare('transaction_type', 'Out');
        $cashout = CashTransaction::model()->findAll($criteriaout);

        foreach ($cashout as $key => $value) {
            $totalout = $totalout + $value->debit_amount;
        }

        $total = ($totalin - $totalout);

        return ($total < 0) ? 0 : $total;
    }

    public function getKas($date, $branch) {
        $saldo = 0;

        $date_start = date("Y-m-01", strtotime($date));

        if ($branch == '00') {
            $coaid = 3;
            $coaob = Coa::model()->findByPk($coaid);
            $ob = $coaob->opening_balance;

            $trips = Coa::model()->findAllByAttributes(array('coa_id' => 3));
            $arr = array();
            foreach ($trips as $t) {
                $arr[] = $t->id;
            }

            $criteria = new CDbCriteria;
            $criteria->addInCondition('coa_id', $arr);
            $criteria->addBetweenCondition("tanggal_transaksi", $date_start, $date);
        } else {
            $coa = Coa::model()->findByAttributes(array('code' => '0' . $branch . '.101.000'));
            $ob = empty($coa->opening_balance) ? 0 : $coa->opening_balance;
            $coaid = $coa->id;

            $criteria = new CDbCriteria;
            $criteria->compare('branch_id', $branch);
            $criteria->compare('coa_id', $coaid);
            $criteria->addBetweenCondition("tanggal_transaksi", $date_start, $date);
        }
        $kas = JurnalUmum::model()->findAll($criteria);

        $saldo = $saldo + $ob;
        foreach ($kas as $key => $value) {
            if ($value->debet_kredit == 'D') {
                $saldo = $saldo + $value->total;
            } else {
                $saldo = $saldo - $value->total;
            }
        }

        return $saldo;
    }

    public function getKasBank($date, $branch) {
        $saldo = 0;

        $date_start = date("Y-m-01", strtotime($date));

        if ($branch == '00') {
            $coaid = 13;
            $coaob = Coa::model()->findByPk($coaid);
            $ob = $coaob->opening_balance;

            $trips = Coa::model()->findAllByAttributes(array('coa_id' => 13));
            $arr = array();
            foreach ($trips as $t) {
                $arr[] = $t->id;
            }

            $criteria = new CDbCriteria;
            $criteria->addInCondition('coa_id', $arr);
            $criteria->addBetweenCondition("tanggal_transaksi", $date_start, $date);
        } else {
            $coa = Coa::model()->findByAttributes(array('code' => '0' . $branch . '.102.000'));
            $ob = empty($coa->opening_balance) ? 0 : $coa->opening_balance;
            $coaid = $coa->id;
            $criteria = new CDbCriteria;
            $criteria->compare('branch_id', $branch);
            $criteria->compare('coa_id', $coaid);
            $criteria->addBetweenCondition("tanggal_transaksi", $date_start, $date);
        }
        $kas = JurnalUmum::model()->findAll($criteria);

        $saldo = $saldo + $ob;
        foreach ($kas as $key => $value) {
            if ($value->debet_kredit == 'D') {
                $saldo = $saldo + $value->total;
            } else {
                $saldo = $saldo - $value->total;
            }
        }

        return $saldo;
    }

}
