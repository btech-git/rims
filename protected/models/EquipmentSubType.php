<?php

/**
 * This is the model class for table "{{equipment_sub_type}}".
 *
 * The followings are the available columns in table '{{equipment_sub_type}}':
 * @property integer $id
 * @property integer $equipment_type_id
 * @property string $name
 * @property string $description
 * @property string $status
 *
 * The followings are the available model relations:
 * @property EquipmentType $equipmentType
 */
class EquipmentSubType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{equipment_sub_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equipment_type_id, name, description', 'required'),
			array('equipment_type_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, equipment_type_id, name, description, status, is_deleted', 'safe', 'on'=>'search'),
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
			'equipmentType' => array(self::BELONGS_TO, 'EquipmentType', 'equipment_type_id'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'equipment_type_id' => 'Equipment Type',
			'name' => 'Name',
			'description' => 'Description',
			'status' => 'Status',
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
		$criteria->compare('equipment_type_id',$this->equipment_type_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);
		$tampilkan = ($this->is_deleted == 1) ? array(0,1) : array(0);
		$criteria->addInCondition('t.is_deleted', $tampilkan);

		$criteria->together = 'true';
		$criteria->with = array('equipmentType');
		// $criteria->compare('branch.name', $this->branch_name, true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
            'defaultOrder' => 't.name',
            'attributes' => array(
	                'equipment_type_id' => array(
	                    'asc' => 'equipmentType.name ASC',
	                    'desc' => 'equipmentType.name DESC',
	                ),
	                '*',
	            ),
	        ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EquipmentSubType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
