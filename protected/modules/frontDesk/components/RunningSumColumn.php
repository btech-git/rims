<?php

class RunningSumColumn extends CGridColumn {
 
    private $_sum = 0;
    private $_attr = null;

    public function getSum()
    {
        $this->_sum;
    }
    public function setSum($sum)
    {
        $this->_sum = $sum;
    }
 
    public function getAttribute()
    {
        return $this->_attr;
    }
    public function setAttribute($value)
    {
        $this->_attr = $value;
    }
 
    public function renderDataCellContent($row, $data) {
        $this->_sum += $data->{$this->attribute};
 
        echo $this->_sum;
    }
}
