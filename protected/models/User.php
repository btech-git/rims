<?php

class User extends CActiveRecord {

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;
    //TODO: Delete for next version (backward compatibility)
    const STATUS_BANED = -1;

    public $roles = array();

    /**
     * The followings are the available columns in table 'users':
     * @var integer $id
     * @var string $username
     * @var string $password
     * @var string $email
     * @var string $activkey
     * @var integer $createtime
     * @var integer $lastvisit
     * @var integer $superuser
     * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
     */

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return Yii::app()->getModule('user')->tableUsers;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.CConsoleApplication
        return ((get_class(Yii::app()) == 'CConsoleApplication' || (get_class(Yii::app()) != 'CConsoleApplication' && Yii::app()->getModule('user')->isAdmin())) ? array(
            array('username', 'length', 'max' => 20, 'min' => 3, 'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
            array('password', 'length', 'max' => 128, 'min' => 4, 'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
            array('email', 'email'),
            array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
            array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
//			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
            array('status', 'in', 'range' => array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BANNED)),
            array('superuser', 'in', 'range' => array(0, 1)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
            array('username, email, superuser, status', 'required'),
            array('superuser, status, employee_id, branch_id', 'numerical', 'integerOnly' => true),
            array('roles, is_main_access, is_front_access', 'safe'),
            array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status,employee_id, branch_id', 'safe', 'on' => 'search'),
                ) : ((Yii::app()->user->id == $this->id) ? array(
            array('username, email', 'required'),
            array('username', 'length', 'max' => 20, 'min' => 3, 'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
            array('email', 'email'),
            array('roles, is_main_access, is_front_access', 'safe'),
            array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
//			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
            array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
                ) : array()));
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile'])) {
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
        }
        return $relations;

        return array(
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => UserModule::t("Id"),
            'username' => UserModule::t("Username"),
            'password' => UserModule::t("Password"),
            'verifyPassword' => UserModule::t("Retype Password"),
            'email' => UserModule::t("E-mail"),
            'verifyCode' => UserModule::t("Verification Code"),
            'activkey' => UserModule::t("Activation key"),
            'createtime' => UserModule::t("Registration date"),
            'create_at' => UserModule::t("Registration date"),
            'employee_id' => 'Employee',
            'branch_id' => 'Branch',
            'lastvisit_at' => UserModule::t("Last visit"),
            'superuser' => UserModule::t("Superuser"),
            'status' => UserModule::t("Status"),
        );
    }

    public function scopes() {
        return array(
            'active' => array(
                'condition' => 'status=' . self::STATUS_ACTIVE,
            ),
            'notactive' => array(
                'condition' => 'status=' . self::STATUS_NOACTIVE,
            ),
            'banned' => array(
                'condition' => 'status=' . self::STATUS_BANNED,
            ),
            'superuser' => array(
                'condition' => 'superuser=1',
            ),
            'notsafe' => array(
                'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status',
            ),
        );
    }

    public function defaultScope() {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope, array(
                    'alias' => 'user',
                    'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.employee_id, user.branch_id',
        ));
    }

    public static function itemAlias($type, $code = NULL) {
        $_items = array(
            'UserStatus' => array(
                self::STATUS_NOACTIVE => UserModule::t('Not active'),
                self::STATUS_ACTIVE => UserModule::t('Active'),
                self::STATUS_BANNED => UserModule::t('Banned'),
            ),
            'AdminStatus' => array(
                '0' => UserModule::t('No'),
                '1' => UserModule::t('Yes'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('activkey', $this->activkey);
        $criteria->compare('create_at', $this->create_at);
        $criteria->compare('lastvisit_at', $this->lastvisit_at);
        $criteria->compare('superuser', $this->superuser);
        $criteria->compare('status', $this->status);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('branch_id', $this->branch_id);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->getModule('user')->user_page_size,
            ),
            'sort' => array(
                'defaultOrder' => 'status DESC, username ASC',
            ),
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at = date('Y-m-d H:i:s', $value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at = date('Y-m-d H:i:s', $value);
    }

    public function afterFind() {
        parent::afterFind();

        $auth = Yii::app()->authManager;

        $authItems = array_keys($auth->getAuthItems(null, $this->id));
        $this->roles = empty($authItems) ? array() : array_combine($authItems, $authItems);
    }

    public function afterSave() {
        parent::afterSave();

        $auth = Yii::app()->authManager;

        if ($this->scenario === 'insert') {
            foreach ($this->roles as $role) {
                $auth->assign($role, $this->id);
            }
        } else {
            $authItems = array_keys($auth->getAuthItems(null, $this->id));
            $assignedRoles = empty($authItems) ? array() : array_combine($authItems, $authItems);

            foreach ($this->roles as $role) {
                if (!$auth->isAssigned($role, $this->id))
                    $auth->assign($role, $this->id);

                unset($assignedRoles[$role]);
            }

            foreach ($assignedRoles as $role) {
                $auth->revoke($role, $this->id);
            }
        }
    }

}
