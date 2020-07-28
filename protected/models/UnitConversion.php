<?php

/**
 * This is the model class for table "{{unit_conversion}}".
 *
 * The followings are the available columns in table '{{unit_conversion}}':
 * @property integer $id
 * @property integer $unit_from_id
 * @property integer $unit_to_id
 * @property string $multiplier
 *
 * The followings are the available model relations:
 * @property Unit $unitFrom
 * @property Unit $unitTo
 */
class UnitConversion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{unit_conversion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unit_from_id, unit_to_id, multiplier', 'required'),
			array('unit_from_id, unit_to_id', 'numerical', 'integerOnly'=>true),
			array('multiplier', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, unit_from_id, unit_to_id, multiplier', 'safe', 'on'=>'search'),
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
			'unitFrom' => array(self::BELONGS_TO, 'Unit', 'unit_from_id'),
			'unitTo' => array(self::BELONGS_TO, 'Unit', 'unit_to_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'unit_from_id' => 'Unit From',
			'unit_to_id' => 'Unit To',
			'multiplier' => 'Multiplier',
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
		$criteria->compare('unit_from_id',$this->unit_from_id);
		$criteria->compare('unit_to_id',$this->unit_to_id);
		$criteria->compare('multiplier',$this->multiplier,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UnitConversion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
