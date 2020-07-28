<?php

class ReportHelper extends CComponent
{
	public static function finalizeDataProvider($dataProvider, $page = array(), $sort = null, $date = array())
	{
		$pageSize = (empty($page['size'])) ? 10 : $page['size'];
		$pageSize = ($pageSize <= 0) ? 1 : $pageSize;
		$dataProvider->pagination->pageSize = $pageSize;

		$currentPage = (empty($page['current'])) ? 0 : $page['current'] - 1;
		$dataProvider->pagination->currentPage = $currentPage;

		if ($sort !== null)
			$dataProvider->criteria->order = $sort->orderBy;

		if (!empty($date['attribute']))
		{
			$startDate = (empty($date['start'])) ? date('Y-m-d') : $date['start'];
			$endDate = (empty($date['end'])) ? date('Y-m-d') : $date['end'];
			$dataProvider->criteria->addBetweenCondition($date['attribute'], $startDate, $endDate);
		}

		return $dataProvider;
	}

	public static function summaryText($dataProvider)
	{
		$start = $dataProvider->pagination->getCurrentPage(false) * $dataProvider->pagination->pageSize + 1;
		$end = $dataProvider->pagination->getCurrentPage(false) * $dataProvider->pagination->pageSize + $dataProvider->getItemCount(false);
		$total = $dataProvider->getTotalItemCount(false);

		$text = ($total > 0) ? "Displaying {$start}-{$end} of {$total} result(s)." : '';

		return $text;
	}

	public static function sortText($sort, $labels = array())
	{
		$text = 'Sort by: ';
		foreach ($sort->attributes as $i => $attribute)
		{
			$label = isset($labels[$i]) ? $labels[$i] : null;
			$text .= $sort->link($attribute, $label) . ' ';
		}

		return $text;
	}
}
