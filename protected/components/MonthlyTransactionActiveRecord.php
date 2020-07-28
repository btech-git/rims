<?php

class MonthlyTransactionActiveRecord extends CActiveRecord {

    public function setCodeNumberByNext($codeNumberColumnName, $currentBranchCode, $currentConstant, $currentMonth, $currentYear) {
        if (empty($this->$codeNumberColumnName)) {
            $branchCode = $currentBranchCode;
            $constant = $currentConstant;
            $ordinal = 0;
        } else {
            list($leftCode, , $rightCode) = explode('/', $this->$codeNumberColumnName);
            list($branchCode, $constant) = explode('.', $leftCode);
            list($ordinal, ) = explode('.', $rightCode);
        }
        $year = $currentYear;
        $month = $currentMonth;
        
        if ($currentMonth > $month || $currentYear > $year) {
            $ordinal = 0;
        }
        
        $arr = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $month = $month ? $month - 1 : 0;
        $revisionOrdinal = ord('a');
        $this->$codeNumberColumnName = sprintf('%s.%s/%04d.%s/%04d.%c', $branchCode, $constant, $year, $arr[$month], $ordinal + 1, $revisionOrdinal);
    }
    
    public function setCodeNumberByRevision($codeNumberColumnName) {
        list($leftCode, $middleCode, $rightCode) = explode('/', $this->$codeNumberColumnName);
        list($branchCode, $constant) = explode('.', $leftCode);
        list($year, $month) = explode('.', $middleCode);
        list($ordinal, $revisionCode) = explode('.', $rightCode);
        $month = $this->normalizeCnMonthBy($month);
        
        $arr = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $month = $month ? $month - 1 : 0;
        $revisionOrdinal = ord($revisionCode) + 1;
        $this->$codeNumberColumnName = sprintf('%s.%s/%04d.%s/%04d.%c', $branchCode, $constant, $year, $arr[$month], $ordinal, $revisionOrdinal);
    }

    public function normalizeCnMonthBy($romanNum) {
        $arr = array_flip(array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'));

        if ($romanNum === '')
            return '';
        else {
            $romanNum = strtoupper($romanNum);
            return isset($arr[$romanNum]) ? $arr[$romanNum] + 1 : 0;
        }
    }
}