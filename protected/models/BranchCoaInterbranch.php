<?php

/**
 * This is the model class for table "{{branch_coa_interbranch}}".
 *
 * The followings are the available columns in table '{{branch_coa_interbranch}}':
 * @property integer $id
 * @property integer $branch_id_from
 * @property integer $branch_id_to
 * @property integer $coa_id
 *
 * The followings are the available model relations:
 * @property Branch $branchIdFrom
 * @property Branch $branchIdTo
 * @property Coa $coa
 */
class BranchCoaInterbranch extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BranchCoaInterbranch the static model class
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
		return '{{branch_coa_interbranch}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('branch_id_from, branch_id_to, coa_id', 'required'),
			array('branch_id_from, branch_id_to, coa_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, branch_id_from, branch_id_to, coa_id', 'safe', 'on'=>'search'),
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
			'branchIdFrom' => array(self::BELONGS_TO, 'Branch', 'branch_id_from'),
			'branchIdTo' => array(self::BELONGS_TO, 'Branch', 'branch_id_to'),
			'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'branch_id_from' => 'Branch Id From',
			'branch_id_to' => 'Branch Id To',
			'coa_id' => 'Coa',
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
		$criteria->compare('branch_id_from',$this->branch_id_from);
		$criteria->compare('branch_id_to',$this->branch_id_to);
		$criteria->compare('coa_id',$this->coa_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}