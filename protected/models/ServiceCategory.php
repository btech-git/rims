<?php

/**
 * This is the model class for table "{{service_category}}".
 *
 * The followings are the available columns in table '{{service_category}}':
 * @property integer $id
 * @property string $code
 * @property integer $service_number
 * @property string $name
 * @property string $status
 * @property integer $service_type_id
 * @property integer $coa_id
 * @property integer $is_deleted
 * @property string $deleted_at
 * @property integer $deleted_by
 * @property integer $coa_diskon_service
 *
 * The followings are the available model relations:
 * @property CustomerServiceRate[] $customerServiceRates
 * @property Service[] $services
 * @property ServiceType $serviceType
 * @property Coa $coa
 * @property Coa $coaDiskonService
 */
class ServiceCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServiceCategory the static model class
	 */
	public $service_type_name;
	public $service_type_code;
	public $coa_name;
	public $coa_code;
	public $coa_diskon_service_name;
	public $coa_diskon_service_code;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{service_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, service_number, name, status, service_type_id', 'required'),
			array('service_number, service_type_id, coa_id, is_deleted, deleted_by, coa_diskon_service', 'numerical', 'integerOnly'=>true),
			array('code','unique'),
			array('code', 'length', 'max'=>20),
			array('name', 'length', 'max'=>30),
			array('status', 'length', 'max'=>10),
			array('deleted_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, service_number, name, status, service_type_id,service_type_name,service_type_code, coa_id, is_deleted, deleted_at, deleted_by, coa_name, coa_code, coa_diskon_service,coa_diskon_service_name,coa_diskon_service_code', 'safe', 'on'=>'search'),
		);
	}
	/**
     * @return array
     */
    public function behaviors()
    {
    	// if (Yii::app()->controller->uniqueId != 'delete') {
	    //     return parent::behaviors();
	    // }
        return array(
            'SoftDelete'=>array('class'=>'application.components.behaviors.SoftDeleteBehavior'),
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
			'customerServiceRates' => array(self::HAS_MANY, 'CustomerServiceRate', 'service_category_id'),
			'services' => array(self::HAS_MANY, 'Service', 'service_category_id'),
			'serviceType' => array(self::BELONGS_TO, 'ServiceType', 'service_type_id'),
			'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
			'coaDiskonService' => array(self::BELONGS_TO, 'Coa', 'coa_diskon_service'),
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
			'service_number' => 'Service Number',
			'name' => 'Name',
			'status' => 'Status',
			'service_type_id' => 'Service Type',
			'coa_id'=>'Coa',
			'coa_diskon_service' => 'Coa Diskon Service',
			'service_type_name' => 'Service Type',
			'service_type_code' => 'Service Type Code',
			'is_deleted' => 'Is Deleted',
			'deleted_at' => 'Deleted At',
			'deleted_by' => 'Deleted By',
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.code',$this->code,true);
		$criteria->compare('service_number',$this->service_number);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);
		$criteria->compare('service_type_id',$this->service_type_id);
		$criteria->compare('coa_id',$this->coa_id);
		$criteria->compare('coa_diskon_service',$this->coa_diskon_service);
		// $criteria->compare('t.is_deleted',($this->is_deleted == 1) ? (0,1) : 0, TRUE);
		$tampilkan = ($this->is_deleted == 1) ? array(0,1) : array(0);
		$criteria->addInCondition('t.is_deleted', $tampilkan);


		$criteria->together = 'true';
		$criteria->with = array('serviceType','coa','coaDiskonService');
		$criteria->compare('serviceType.name', $this->service_type_name, true);
		$criteria->compare('serviceType.code', $this->service_type_code, true);
		$criteria->compare('coa.name',$this->coa_name, true);
		$criteria->compare('coa.code',$this->coa_code, true);
		$criteria->compare('coaDiskonService.name',$this->coa_diskon_service_name, true);
		$criteria->compare('coaDiskonService.code',$this->coa_diskon_service_code, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
            'defaultOrder' => 't.name',
            'attributes' => array(
	                'service_type_name' => array(
	                    'asc' => 'serviceType.name ASC',
	                    'desc' => 'serviceType.name DESC',
	                ),
	                'service_type_code' => array(
	                    'asc' => 'serviceType.code ASC',
	                    'desc' => 'serviceType.code DESC',
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