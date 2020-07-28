<?php

/**
 * This is the model class for table "rims_chasis_code".
 *
 * The followings are the available columns in table 'rims_chasis_code':
 * @property integer $id
 * @property string $name
 * @property integer $year_end
 * @property integer $year_start 
 * @property string $status
 * @property integer $car_make_id
 * @property integer $car_model_id
 *
 * The followings are the available model relations:
 * @property VehicleCarMake $carMake
 * @property VehicleCarModel $carModel
 */
class ChasisCode extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{chasis_code}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, car_make_id,car_model_id', 'required'),
			array('year_end, year_start, car_make_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, year_end, year_start, status, car_make_id,car_model_id', 'safe', 'on'=>'search'),
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
			'carMake' => array(self::BELONGS_TO, 'VehicleCarMake', 'car_make_id'),
			'carModel' => array(self::BELONGS_TO, 'VehicleCarModel', 'car_model_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Chasis code Name',
			'year_end' => 'Year End',
			'year_start' => 'Year Start',
			'status' => 'Status',
			'car_make_id' => 'Car Make',
			'car_model_id' => 'Car Model',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('year_end',$this->year_end);
		$criteria->compare('year_start',$this->year_start);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('car_make_id',$this->car_make_id);
		$criteria->compare('car_model_id',$this->car_model_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ChasisCode the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
