<?php

/**
 * This is the model class for table "{{general_standard_value}}".
 *
 * The followings are the available columns in table '{{general_standard_value}}':
 * @property integer $id
 * @property string $difficulty
 * @property string $difficulty_value
 * @property string $regular
 * @property string $luxury
 * @property string $luxury_value
 * @property string $luxury_calc
 * @property string $flat_rate_hour
 */
class GeneralStandardValue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GeneralStandardValue the static model class
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
		return '{{general_standard_value}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('difficulty, difficulty_value, regular, luxury, luxury_value, luxury_calc, flat_rate_hour', 'required'),
			array('difficulty, difficulty_value, regular, luxury, luxury_value, luxury_calc, flat_rate_hour', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, difficulty, difficulty_value, regular, luxury, luxury_value, luxury_calc, flat_rate_hour', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'difficulty' => 'Difficulty',
			'difficulty_value' => 'Difficulty Value',
			'regular' => 'Regular',
			'luxury' => 'Luxury',
			'luxury_value' => 'Luxury Value',
			'luxury_calc' => 'Luxury Calc',
			'flat_rate_hour' => 'Flat Rate Hour',
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
		$criteria->compare('difficulty',$this->difficulty,true);
		$criteria->compare('difficulty_value',$this->difficulty_value,true);
		$criteria->compare('regular',$this->regular,true);
		$criteria->compare('luxury',$this->luxury,true);
		$criteria->compare('luxury_value',$this->luxury_value,true);
		$criteria->compare('luxury_calc',$this->luxury_calc,true);
		$criteria->compare('flat_rate_hour',$this->flat_rate_hour,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}