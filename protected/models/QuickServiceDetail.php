<?php

/**
 * This is the model class for table "{{quick_service_detail}}".
 *
 * The followings are the available columns in table '{{quick_service_detail}}':
 * @property integer $id
 * @property integer $quick_service_id
 * @property integer $service_id
 * @property string $price
 * @property string $hour
 * @property string $discount_price
 * @property string $final_price
 *
 * The followings are the available model relations:
 * @property QuickService $quickService
 * @property Service $service

 */
class QuickServiceDetail extends CActiveRecord
{
	public $service_name;
	public $service_code;
	public $service_category_code;
	public $service_type_code;
	public $findkeyword;
	public $qs_code;
	public $qs_name;
	public $qs_status;
	public $qs_rate;
	public $qs_hour;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QuickServiceDetail the static model class
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
		return '{{quick_service_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quick_service_id, service_id', 'numerical', 'integerOnly'=>true),
			array('price, discount_price, final_price', 'length', 'max'=>18),
			array('hour', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quick_service_id, service_id, price, hour, discount_price, final_price, service_name, service_category_code, service_type_code, service_code, findkeyword, qs_code,qs_name,qs_status,qs_rate,qs_hour', 'safe', 'on'=>'search'),
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
			'quickService' => array(self::BELONGS_TO, 'QuickService', 'quick_service_id'),
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quick_service_id' => 'Quick Service',
			'service_id' => 'Service',
			'price' => 'Price',
			'hour' => 'Hour',
			'discount_price' => 'Discount Price',
			'final_price' => 'Final Price',
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
		$criteria->compare('quick_service_id',$this->quick_service_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('hour',$this->hour,true);
		$criteria->compare('discount_price',$this->discount_price,true);
		$criteria->compare('final_price',$this->final_price,true);

		$criteria->together = 'true';
		$criteria->with = array('quickService','service'=>array('with'=>array('serviceCategory','serviceType')));
		$criteria->compare('serviceCategory.name', $this->service_category_code, true);
		$criteria->compare('serviceType.name', $this->service_type_code, true);
		$criteria->compare('service.name', $this->service_name, true);
		$criteria->compare('service.code', $this->service_code, true);

		$criteria->compare('quickService.code', $this->qs_code, true);
		$criteria->compare('quickService.name', $this->qs_name, true);
		$criteria->compare('quickService.status', $this->qs_status, true);
		$criteria->compare('quickService.rate', $this->qs_rate, true);
		$criteria->compare('quickService.hour', $this->qs_hour, true);

        $explodeKeyword = explode(" ", $this->findkeyword);

        foreach ($explodeKeyword as $key) {

	        $criteria->compare('serviceCategory.name',$key,true,'OR');
	        $criteria->compare('serviceType.name',$key,true,'OR');
	        $criteria->compare('service.name',$key,true,'OR');
	        $criteria->compare('service.code',$key, true, 'OR');

			$criteria->compare('quickService.code', $key, true, 'OR');
			$criteria->compare('quickService.name', $key, true, 'OR');
			$criteria->compare('quickService.rate', $key, true, 'OR');
			$criteria->compare('quickService.hour', $key, true, 'OR');

		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
            'defaultOrder' => 'service.name',
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
	                'qs_name' => array(
	                    'asc' => 'quickService.name ASC',
	                    'desc' => 'quickService.name DESC',
	                ),
	                'qs_code' => array(
	                    'asc' => 'quickService.code ASC',
	                    'desc' => 'quickService.code DESC',
	                ),
	                'qs_rate' => array(
	                    'asc' => 'quickService.rate ASC',
	                    'desc' => 'quickService.rate DESC',
	                ),
	                'qs_hour' => array(
	                    'asc' => 'quickService.hour ASC',
	                    'desc' => 'quickService.hour DESC',
	                ),
	                'qs_status' => array(
	                    'asc' => 'quickService.status ASC',
	                    'desc' => 'quickService.status DESC',
	                ),
	                '*',
	            ),
	        ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),
	    ));
	}
}