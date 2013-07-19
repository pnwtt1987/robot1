<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $user_name
 * @property string $user_tel
 * @property string $user_email
 * @property string $user_address
 * @property string $roles
 */
class User extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, user_name', 'length', 'max' => 50),
             array('password', 'length', 'max' => 150),
            array('user_tel', 'length', 'max' => 20),
            array('user_email', 'length', 'max' => 30),
            array('rules', 'length', 'max' => 1),
            array('user_address', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, username, password, user_name, user_tel, user_email, user_address, rules', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'User',
            'username' => 'Username',
            'password' => 'Password',
            'user_name' => 'User Name',
            'user_tel' => 'User Tel',
            'user_email' => 'User Email',
            'user_address' => 'User Address',
            'rules' => 'Rules',
        );
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
        $criteria->compare('password', $this->password, true);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('user_tel', $this->user_tel, true);
        $criteria->compare('user_email', $this->user_email, true);
        $criteria->compare('user_address', $this->user_address, true);
        $criteria->compare('rules', $this->rules, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

  
    public function validatePassword($password) {
        return $this->hashPassword($password) === $this->password;
    }

     public function hashPassword($phrase, $salt = null) {
        $key = 'Gf;B&yXL|beJUf-K*PPiU{wf|@9K9j5?d+YW}?VAZOS%e2c -:11ii<}ZM?PO!96';
        if ($salt == '') {
            $hasSha512 = hash('md5', $key);
            $salt = substr($hasSha512, 0, 10);
        } else {
            $salt = substr($salt, 0, 10);
        }
        return hash('md5', $salt . $key . $phrase);
    }

}