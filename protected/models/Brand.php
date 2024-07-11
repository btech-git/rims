<?php

/**
 * This is the model class for table "{{brand}}".
 *
 * The followings are the available columns in table '{{brand}}':
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $user_id
 * @property string $date_posting
 * @property integer $user_id_edit
 * @property string $date_edit
 * @property integer $is_approved
 * @property integer $user_id_approval
 * @property string $date_approval
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property SubBrand[] $subBrands
 * @property User $user
 * @property UserIdApproval $userIdApproval
 * @property UserIdEdit $userIdEdit
 */
class Brand extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{brand}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, user_id', 'required'),
            array('user_id_approval, user_id_edit, user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 30),
            array('status', 'length', 'max' => 10),
            array('date_posting, date_approval, date_edit', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, status, user_id_approval, user_id_edit, user_id, date_posting, date_approval, date_edit', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products' => array(self::HAS_MANY, 'Product', 'brand_id'),
            'subBrands' => array(self::HAS_MANY, 'SubBrand', 'brand_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdApproval' => array(self::BELONGS_TO, 'Users', 'user_id_approval'),
            'userIdEdit' => array(self::BELONGS_TO, 'Users', 'user_id_edit'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'user_id' => 'User Input',
            'date_posting' => 'Tanggal Input',
            'is_approved' => 'Approval',
            'user_id_approval' => 'User Approval',
            'date_approval' => 'Tanggal Approval',
            'user_id_edit' => 'User Edit',
            'date_edit' => 'Tanggal Edit',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.date_posting', $this->date_posting);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.user_id_approval', $this->user_id_approval);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.status ASC, t.name',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Brand the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
