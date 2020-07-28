<?php
class ForecastingComponents extends CComponent
{
    public function getListbank()
    {
        /* id bank
            3   BCA HUFADHA | 5     BCA PD  | 7     BCA PT  | 10    CIMB NIAGA | 14     Mandiri KMK | 17    MANDIRI TBM
        */

        /* id bank [update 20170216]
            23   BCA HUFADHA | 43     BCA PD  | 63     BCA PT  | 93    CIMB NIAGA | 133     Mandiri KMK | 163    MANDIRI TBM
        */
        $bank = array(23,43,63,93,133,163); 
        return $bank;
    }

    public function getListbankValue() {
		$bankvalue = array(23=>0,43=>0,63=>0,93=>0,133=>0,163=>0);
		return $bankvalue;
    }
}