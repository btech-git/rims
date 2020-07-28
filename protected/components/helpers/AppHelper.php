<?php

class AppHelper
{
	public static function dateDiff($start,$end = false, $type = 'day'){
		// work only at php 5.3 or better
		$diff = abs($start-$end);
		if($type=='day'){
			return floor($diff/(60*60*24));
		}
		else if($type=='week'){
			return floor($diff/(60*60*24*7));
		}
		else if($type == 'month'){
			return floor($diff/(60*60*24*30));
		}
		else{
			return floor($diff/(60*60*24*365));
		}
	}
	
    public static function convertNumberIntoStringDigit($number, $length = 3 , $start = true){
		/*  this function change numeric digit into string digits
		 *  $number is number to convert
		 * 	$length is string length to generate
		 *  example : 1 into 01 ->length = 2
		 *          : 1 into 001 ->length = 3
		 *          : 567 into 00567 ->length = 5
		 *  created by wendy
		*/
		
		
		$temp = '';
		if($start){
			$length --;
		}
		// check jika panjang bilangan > 0 dan number bilangan lebih besar 10 pangkat length
		if($length > 0 && $number < pow(10,$length)){	
			$temp.=AppHelper::convertNumberIntoStringDigit($number, $length-1 ,false);
		}
		
		// check jika number lebih kecil dari 10 pangkat length
		if($number < pow(10,$length)){
			//do nothing tambah angka 0 di depan
			$temp.= '0';
		}
		
		// check jika fungsi yg pertama kali dipanggil
		if($start){
			return $temp.=$number;
		}
		else{ 
			return $temp;
		}
	}
	
	public static function getCurrentUserId()
	{
		return Yii::app()->user->getState('user_id');
	}
	
	public static function getCurrentDate()
	{
		return date('Y-m-d H:i:s');
	}
	
	public static function formatDate($date, $format='d-M-Y')
	{
		if ($date == '')
			return '';
		
		return date($format, strtotime($date));
	}
	
	public static function formatDateTime($date)
	{		
		return self::formatDate($date, 'd-M-Y H:i:s');
	}
	
	public static function convertModelErrorsToString($errors, $glue='<br />')
	{
		$arrErrors = array();
		foreach ($errors as $attributeErrors)
		{
			foreach ($attributeErrors as $error)
			{
				array_push($arrErrors, $error);
			}
		}
		
		return implode($glue, $arrErrors);
	}
	
	public static function getPostValue($attribute, $default='')
	{
		$result = '';
		$post = '';
		preg_match('/\w+/', $attribute, $matches);
		if ($matches != null)
		{
			if (isset($_POST[$matches[0]]))
				$result = $_POST[$matches[0]];
			
			$arrays = array();
			$matches = null;
			preg_match_all('/(\[(\w+)\]*)/', $attribute, $matches);
			if ($matches != null)
			{
				$arrays = $matches[2];
			}
						
			if (!empty($arrays))
			{
				for ($i=0; $i<count($arrays); $i++)
				{
					if (isset($result[$arrays[$i]]))
						$result = $result[$arrays[$i]];
                    else
                        $result = '';
				}
			}
		}
		
		return $result == '' ? $default : $result;
	}

    public static function formatMoney($money, $curr = null)
    {
        if ($money != null){
            if($curr == null){
                return number_format($money, 0, ',', '.');
            }
            else if($curr == 'USD'){
                return "$" . number_format($money, 0, '.', ',');
            }
            else if($curr == 'IDR'){
                return number_format($money, 0, '.', ',') .' '.$curr;
            }
        }
        else
            return "";
    }
}