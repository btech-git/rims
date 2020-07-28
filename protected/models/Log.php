<?php

/**
 * This is the model class for table "log".
 *
 * The followings are the available columns in table 'log':
 * @property string $id
 * @property string $table_name
 * @property string $table_id
 * @property string $action
 * @property string $description
 * @property integer $user_id
 * @property string $date
 * @property string $trigger
 * @property string $url
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Log extends CActiveRecord
{


	/**
	 * Returns the static model of the specified AR class.
	 * @return Log the static model class
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
		return 'log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('table_name, table_id, action, description, user_id, date', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('table_id', 'length', 'max'=>50),
			array('table_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, table_name, table_id, action, description, user_id, date', 'safe', 'on'=>'search'),
			array('user_fullname', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'table_name' => 'Table Name',
			'table_id' => 'Primary Key',
			'action' => 'Action',
			'description' => 'Description',
			'user_id' => 'User',
			'date' => 'Date',
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

		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('table_id',$this->table_id,true);
		$criteria->compare('action',$this->action);
		$criteria->compare('description',$this->description,true);

		if(!($this->date == NULL || $this->date == '')){
			//$criteria->addCondition($criteria)
		}
		
		if(!($this->user_fullname == NULL || $this->user_fullname == '')){
			$criteria->addCondition("b.name ILIKE '%". $this->user_fullname ."%'");
		}
		
		$criteria->with = array(
			'user' => array('alias'=>'a'),
			'user.employee' => array('alias'=>'b'),
		);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['defaultPageSize'],
			),
			'sort'=>array(
				'attributes'=>array(
					'*',
					'user_fullname'=>array(
						'asc'=>'b.name',
						'desc'=>'b.name DESC',
					),
				),
				'defaultOrder'=>'t.id DESC',
			),
		));
	}
}