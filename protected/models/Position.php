<?php

/**
 * This is the model class for table "rims_position".
 *
 * The followings are the available columns in table 'rims_position':
 * @property integer $id
 * @property string $name
 * @property string $status
 *
 * The followings are the available model relations:
 * @property DivisionPosition[] $divisionPositions
 * @property EmployeeBranchDivisionPositionLevel[] $employeeBranchDivisionPositionLevels
 * @property PositionLevel[] $positionLevels
 */
class Position extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Position the static model class
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
		return 'rims_position';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
            array('name','unique', 'message'=>'This Position already exists.'),
			array('name', 'length', 'max'=>30),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, status, is_deleted', 'safe', 'on'=>'search'),
		);
	}

	/**
     * @return array
     */
    public function behaviors()
    {
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
			'divisionPositions' => array(self::HAS_MANY, 'DivisionPosition', 'position_id'),
			'employeeBranchDivisionPositionLevels' => array(self::HAS_MANY, 'EmployeeBranchDivisionPositionLevel', 'position_id'),
			'positionLevels' => array(self::HAS_MANY, 'PositionLevel', 'position_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'status' => 'Status',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		$tampilkan = ($this->is_deleted == 1) ? array(0,1) : array(0);
		$criteria->addInCondition('is_deleted', $tampilkan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}