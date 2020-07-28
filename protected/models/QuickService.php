<?php

/**
 * This is the model class for table "{{quick_service}}".
 *
 * The followings are the available columns in table '{{quick_service}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $status
 * @property string $rate
 * @property string $hour
 *
 * The followings are the available model relations:
 * @property QuickServiceDetail[] $quickServiceDetails
 */
class QuickService extends CActiveRecord
{
	// public $service_name;
	// public $service_code;
	// public $service_category_code;
	// public $service_type_code;
	// public $findkeyword;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QuickService the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{quick_service}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name, status', 'length', 'max'=>30),
			array('rate', 'length', 'max'=>18),
			array('hour', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, name, status, rate, hour', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'quickServiceDetails' => array(self::HAS_MANY, 'QuickServiceDetail', 'quick_service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'status' => 'Status',
			'rate' => 'Rate',
			'hour' => 'Hour',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('t.code',$this->code,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('LOWER(t.status)', strtolower($this->status),FALSE);
		$criteria->compare('t.rate',$this->rate,true);
		$criteria->compare('t.hour',$this->hour,true);

		/*$criteria->together = 'true';
		$criteria->with = array('quickServiceDetails'=>array('with'=>array('service'=>array('with'=>array('serviceCategory','serviceType')))));
		$criteria->compare('serviceCategory.name', $this->service_category_code, true);
		$criteria->compare('serviceType.name', $this->service_type_code, true);
		$criteria->compare('service.name', $this->service_name, true);
		$criteria->compare('service.code', $this->service_code, true);

        $explodeKeyword = explode(" ", $this->findkeyword);

        foreach ($explodeKeyword as $key) {

	        $criteria->compare('serviceCategory.name',$key,true,'OR');
	        $criteria->compare('serviceType.name',$key,true,'OR');
	        $criteria->compare('service.name',$key,true,'OR');
	        $criteria->compare('service.code',$key, true, 'OR');

			$criteria->compare('t.difficulty',$key,true,'OR');
			$criteria->compare('t.luxury',$key,true,'OR');
			$criteria->compare('t.price',$key,true,'OR');
			$criteria->compare('t.common_price',$key,true,'OR');
		}*/

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'sort' => array(
            'defaultOrder' => 'quickServiceDetails.service.name',
            'attributes' => array(
	                'service_category_code' => array(
	                    'asc' => 'serviceCategory.name ASC',
	                    'desc' => 'serviceCategory.name DESC',
	                ),
	                'service_type_code' => array(
	                    'asc' => 'serviceType.name ASC',
	                    'desc' => 'serviceType.name DESC',
	                ),
	                'service_name' => array(
	                    'asc' => 'service.name ASC',
	                    'desc' => 'service.name DESC',
	                ),
	                'service_code' => array(
	                    'asc' => 'service.code ASC',
	                    'desc' => 'service.code DESC',
	                ),
	                '*',
	            ),
	        ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),*/
	    ));
	}
}