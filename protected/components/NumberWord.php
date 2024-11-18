<?php

class NumberWord extends CComponent
{

	public static function numberName($number)
	{
		$words = '';
		$counter = 1;

		if ($number < 0 || $number > PHP_INT_MAX)
			return '';
		if (intval($number) === 0)
			return 'nol';

		do
		{
			$quotient = intval($number / 1000);
			$remainder = intval($number) % 1000;

			$prefix = ($counter === 2 && $remainder === 1) ? 'se' : self::hundredsName($remainder);
			$words = $prefix . $words;
			if (intval($quotient) % 1000 > 0)
				$words = self::thousandSeparatorName($counter) . $words;

			$number = $quotient;
			$counter++;
		}
		while ($number > 0);

		return $words;
	}

	private static function hundredsName($hundreds)
	{
		$hundred = intval($hundreds / 100);
		$tens = intval($hundreds) % 100;
		$ten = intval($tens / 10);
		$unit = intval($hundreds) % 10;

		$words = self::unitName($hundred) . (($hundred !== 0) ? 'ratus ' : '');
		if ($tens > 10 && $tens < 20)
			$words .= self::unitName($unit) . 'belas ';
		else
		{
			$words .= self::unitName($ten) . (($ten !== 0) ? 'puluh ' : '');
			$words .= ($unit === 1) ? 'satu ' : self::unitName($unit);
		}

		return $words;
	}

	private static function thousandSeparatorName($ordinal)
	{
		switch ($ordinal)
		{
			case 1: return 'ribu ';
			case 2: return 'juta ';
			case 3: return 'milyar ';
			default: return '';
		}
	}

	private static function unitName($unit)
	{
		switch ($unit)
		{
			case 1: return 'se';
			case 2: return 'dua ';
			case 3: return 'tiga ';
			case 4: return 'empat ';
			case 5: return 'lima ';
			case 6: return 'enam ';
			case 7: return 'tujuh ';
			case 8: return 'delapan ';
			case 9: return 'sembilan ';
			default: return '';
		}
	}
}