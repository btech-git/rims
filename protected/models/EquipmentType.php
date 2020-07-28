<?php

/**
 * This is the model class for table "{{equipment_type}}".
 *
 * The followings are the available columns in table '{{equipment_type}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $status
 */
class EquipmentType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{equipment_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description', 'required'),
			array('name', 'length', 'max'=>100),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, status, is_deleted', 'safe', 'on'=>'search'),
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
     * @return array
     */
    public function behaviors()
    {
        return array(
            'SoftDelete'=>array('class'=>'application.components.behaviors.SoftDeleteBehavior'),
        );
    }


	// public function beforeFind()
	// {
	// 	// if (($this->is_deleted != 1) OR ($this->is_deleted != "1")) {
	//         $criteria = new CDbCriteria;
	//         $criteria->condition = "is_deleted = 0";
	//     	$this->dbCriteria->mergeWith($criteria);
	// 	    parent::beforeFind();
	//     // }
	// }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'status' => 'Status',
			'is_deleted'=>'Show Deleted',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);
		
		// $tampilkan = (($this->is_deleted == 1) OR ($this->is_deleted == "1")) ? array(0,1) : array(0);
		// $criteria->addInCondition('is_deleted', $tampilkan);
		// add in condition not working.. :( fix with or condition.
		if (($this->is_deleted == 1) OR ($this->is_deleted == "1")) {
			$criteria->compare('is_deleted',0,true,'OR');
			$criteria->compare('is_deleted',1,true,'OR');
		}else{
			$criteria->compare('is_deleted',0, false, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EquipmentType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
