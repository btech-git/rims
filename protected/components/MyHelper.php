<?php

class MyHelper
{
	/**
	 * @var User|null
	 */
	private static $_user;

	/**
	 * @param $access
	 * @return bool
	 */
	public static function hasAccess ($access)
	{
		$authManager = Yii::app()->authManager;

		$sql = "SELECT name, type, description, t1.bizrule, t1.data, t2.bizrule AS bizrule2, t2.data AS data2 FROM {$authManager->itemTable} t1, {$authManager->assignmentTable} t2 WHERE name=itemname AND userid=:userid";
		$command = $authManager->db->createCommand($sql);
		$command->bindValue(':userid', Yii::app()->user->id.'');

		// check directly assigned items
		$names = array(); // roles

		foreach ($command->queryAll() as $row) {
			if (strtolower($row['name']) === strtolower($access)) {
				return true;
			}
			$names[] = $row['name'];
		}

		while ($names !== array()) {
			$items = $authManager->getItemChildren($names);
			$names = array();
			foreach ($items as $item) {
				if (strtolower($item->getName()) === strtolower($access)) {
					return true;
				}
				$names[] = $item->getName();
			}
		}

		return false;
	}

	/**
	 * Check additional access.
	 * If the access isn't assigned to the user, then the user can access it.
	 * If the access is assigned to the user, then check it normally.
	 * @param string $access
	 * @param array $params
	 * @return boolean
	 */
	public static function checkOptionalAccess($access, $params=array())
	{
		$params['isOptional'] = true;
		return Yii::app()->user->checkAccess($access, $params);
	}

	/**
	 * @param array $accesses
	 * @param array $params
	 * @return bool
	 */
	public static function checkOptionalAccesses($accesses, $params=array())
	{
		foreach ($accesses as $access) {
			if (!self::checkOptionalAccess($access, $params)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @param array $accesses
	 * @param array $params
	 * @return bool
	 */
	public static function checkAccesses ($accesses, $params=array())
	{
		foreach ($accesses as $access) {
			if (!Yii::app()->user->checkAccess($access, $params)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Get error notification from flash message
	 */
	public static function errorFlashNotification()
	{
		return NotificationHelper::error(FlashMessageHelper::getError());
	}

	/**
	 * Get success notification from flash message
	 */
	public static function successFlashNotification()
	{
		return NotificationHelper::success(FlashMessageHelper::getSuccess());
	}

	/**
	 * Create a Date in the view
	 * @param mixed $model
	 * @param string $field
	 * @param null|string $format
	 * @return array
	 */
	public static function detailViewDate($model, $field, $format=null)
	{
		return array(
			'name'=>$field,
			'value'=>DateHelper::formatDate($model->$field, $format),
		);
	}

	/**
	 * Create a Date Time in the view
	 *
	 * @param mixed $model
	 * @param string $field
	 * @param null|string $format
	 * @return array
	 */
	public static function detailViewDateTime($model, $field, $format=null)
	{
		return array(
			'name'=>$field,
			'value'=>DateHelper::formatDateTime($model->$field, $format),
		);
	}

	/**
	 * Create Username in the view
	 *
	 * @param mixed $model
	 * @param string $field
	 * @return array
	 */
	public static function detailViewUsername($model, $field)
	{
		$user = User::model()->findByPk($model->$field);

		return array(
			'name'=>$field,
			'value'=>$user !== null ? $user->username : null,
		);
	}

	/**
	 * @return User|null
	 */
	public static function getUser()
	{
		if (self::$_user === null) {
			if (!Yii::app()->user->isGuest) {
				self::$_user = User::model()->findByPk(Yii::app()->user->id);
			}
		}

		return self::$_user;
	}

	/**
	 * @param $context
	 * @param $message
	 * @param array $params
	 * @return string
	 */
	public static function t($context, $message, $params=array())
	{
		$message = Yii::t($context, $message);
		$newParams = array();
		foreach ($params as $i=>$param) {
			$newParams['{'.$i.'}'] = $param;
		}
		return strtr($message, $newParams);
	}

	/**
	 * @param string|integer $value1
	 * @param integer|null $value2
	 * @return mixed
	 */
	public static function getNominalOrPercentage($value1, $value2=0)
	{
		$isPercentage = false;
		if (strpos($value1, '%') === strlen($value1) - 1) {
			$isPercentage = true;
		}
		$value1 = str_replace('%', '', $value1);

		if ($isPercentage) {
			return ($value1 * $value2) / 100;
		} else {
			return $value1;
		}
	}
}
