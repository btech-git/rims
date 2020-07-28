<?php
class NeracaComponents extends CComponent
{

	public function getKas($date,$branch) {
		$saldo = 0;

		$date_start = date("Y-m-01", strtotime($date));

		if ($branch == '00') {
			$coaid = 3;
			$coaob = Coa::model()->findByPk($coaid);
			$ob = $coaob->opening_balance;

				$trips = Coa::model()->findAllByAttributes(array('coa_id'=>3));
				$arr = array();
				foreach($trips as $t)
				{
				    $arr[] = $t->id;
				}
			$criteria=new CDbCriteria;
			$criteria->addInCondition('coa_id',$arr); 
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}else{
			$coa = Coa::model()->findByAttributes(array('code'=>'0'.$branch.'.101.000'));
			$ob = empty($coa->opening_balance)?0:$coa->opening_balance;
			$coaid=$coa->id;
			// $date_start = '2015-10-15';
			$criteria=new CDbCriteria;
			$criteria->compare('branch_id',$branch);   
			$criteria->compare('coa_id',$coaid);   
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}
		$kas = JurnalUmum::model()->findAll($criteria);

		$saldo = $saldo + $ob;
		foreach ($kas as $key => $value) {
			if ($value->debet_kredit == 'D') {
				$saldo = $saldo + $value->total; 
			}else{
				$saldo = $saldo - $value->total; 
			}
		}

		return $saldo;
	}

	public function getKasBank($date,$branch) {
		$saldo = 0;

		$date_start = date("Y-m-01", strtotime($date));

		if ($branch == '00') {
			$coaid = 13;
			$coaob = Coa::model()->findByPk($coaid);
			$ob = $coaob->opening_balance;

				$trips = Coa::model()->findAllByAttributes(array('coa_id'=>13));
				$arr = array();
				foreach($trips as $t)
				{
				    $arr[] = $t->id;
				}
			$criteria=new CDbCriteria;
			$criteria->addInCondition('coa_id',$arr); 
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}else{
			$coa = Coa::model()->findByAttributes(array('code'=>'0'.$branch.'.102.000'));
			$ob = empty($coa->opening_balance)?0:$coa->opening_balance;
			$coaid=$coa->id;
			// $date_start = '2015-10-15';
			$criteria=new CDbCriteria;
			$criteria->compare('branch_id',$branch);   
			$criteria->compare('coa_id',$coaid);   
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}
		$kas = JurnalUmum::model()->findAll($criteria);

		$saldo = $saldo + $ob;
		foreach ($kas as $key => $value) {
			if ($value->debet_kredit == 'D') {
				$saldo = $saldo + $value->total; 
			}else{
				$saldo = $saldo - $value->total; 
			}
		}

		return $saldo;
	}

	public function getKasKecil($date,$branch) {
		$saldo = 0;

		$date_start = date("Y-m-01", strtotime($date));

		if ($branch == '00') {
			$coaid = 183;
			$coaob = Coa::model()->findByPk($coaid);
			$ob = $coaob->opening_balance;

				$trips = Coa::model()->findAllByAttributes(array('coa_id'=>183));
				$arr = array();
				foreach($trips as $t)
				{
				    $arr[] = $t->id;
				}
			$criteria=new CDbCriteria;
			$criteria->addInCondition('coa_id',$arr); 
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}else{
			$coa = Coa::model()->findByAttributes(array('code'=>'0'.$branch.'.102.000'));
			$ob = empty($coa->opening_balance)?0:$coa->opening_balance;
			$coaid=$coa->id;
			// $date_start = '2015-10-15';
			$criteria=new CDbCriteria;
			$criteria->compare('branch_id',$branch);   
			$criteria->compare('coa_id',$coaid);   
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}
		$kas = JurnalUmum::model()->findAll($criteria);

		$saldo = $saldo + $ob;
		foreach ($kas as $key => $value) {
			if ($value->debet_kredit == 'D') {
				$saldo = $saldo + $value->total; 
			}else{
				$saldo = $saldo - $value->total; 
			}
		}

		return $saldo;
	}

	public function getOtherCoa($date,$branch, $coaid, $coacode) {
		$saldo = 0;

		$date_start = date("Y-m-01", strtotime($date));

		if ($branch == '00') {
			$coaob = Coa::model()->findByPk($coaid);
			$ob = $coaob->opening_balance;

				$trips = Coa::model()->findAllByAttributes(array('coa_id'=>$coaid));
				$arr = array();
				foreach($trips as $t)
				{
				    $arr[] = $t->id;
				}
			$criteria=new CDbCriteria;
			$criteria->addInCondition('coa_id',$arr); 
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}else{
			$coa = Coa::model()->findByAttributes(array('code'=>'0'.$branch.'.'.$coacode));
			$ob = empty($coa->opening_balance)?0:$coa->opening_balance;
			$coaid=$coa->id;
			// $date_start = '2015-10-15';
			$criteria=new CDbCriteria;
			$criteria->compare('branch_id',$branch);   
			$criteria->compare('coa_id',$coaid);   
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}
		$kas = JurnalUmum::model()->findAll($criteria);

		$saldo = $saldo + $ob;
		foreach ($kas as $key => $value) {
			if ($value->debet_kredit == 'D') {
				$saldo = $saldo + $value->total; 
			}else{
				$saldo = $saldo - $value->total; 
			}
		}

		return $saldo;
	}

}