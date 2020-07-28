<?php

/**
 * This is the model class for table "rims_division_branch".
 *
 * The followings are the available columns in table 'rims_division_branch':
 * @property integer $id
 * @property integer $division_id
 * @property integer $branch_id
 * @property string $email
 *
 * The followings are the available model relations:
 * @property Division $division
 * @property Branch $branch
 */
class DivisionBranch extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DivisionBranch the static model class
	 */

	public $division_name;
	public $branch_name;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rims_division_branch';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, division_id, branch_id', 'required'),
			array('email', 'length', 'max'=>60),
			array('id, division_id, branch_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, division_id, branch_id, division_name, branch_name', 'safe', 'on'=>'search'),
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
			'division' => array(self::BELONGS_TO, 'Division', 'division_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'division_id' => 'Division',
			'branch_id' => 'Branch',
			'email'=>'Email',
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
		$criteria->compare('division_id',$this->division_id);
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}