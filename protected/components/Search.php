<?php

class Search extends CComponent
{
	public static function bind($model, $data)
	{
		$model->unsetAttributes();
		$model->attributes = $data;
		return $model;
	}
}