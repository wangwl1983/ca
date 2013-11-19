<?php

/**
 * This is the model class for table "{{record}}".
 *
 * The followings are the available columns in table '{{record}}':
 * @property integer $record_id
 * @property string $record_envsn
 * @property integer $record_type
 * @property integer $record_unit_id
 * @property integer $record_operator_requester
 * @property integer $record_operator_auditor
 * @property string $record_date
 * @property integer $record_timestamp
 * @property string $record_public_keyfile
 */
class Record extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{record}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('record_envsn, record_type, record_unit_id, record_operator_requester, record_operator_auditor, record_date, record_timestamp', 'required'),
			array('record_type, record_unit_id, record_operator_requester, record_operator_auditor, record_timestamp', 'numerical', 'integerOnly'=>true),
			array('record_envsn', 'length', 'max'=>15),
			array('record_public_keyfile', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('record_id, record_envsn, record_type, record_unit_id, record_operator_requester, record_operator_auditor, record_date, record_timestamp, record_public_keyfile', 'safe', 'on'=>'search'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'record_id' => 'Record',
			'record_envsn' => 'Record Envsn',
			'record_type' => 'Record Type',
			'record_unit_id' => 'Record Unit',
			'record_operator_requester' => 'Record Operator Requester',
			'record_operator_auditor' => 'Record Operator Auditor',
			'record_date' => 'Record Date',
			'record_timestamp' => 'Record Timestamp',
			'record_public_keyfile' => 'Record Public Keyfile',
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

		$criteria->compare('record_id',$this->record_id);
		$criteria->compare('record_envsn',$this->record_envsn,true);
		$criteria->compare('record_type',$this->record_type);
		$criteria->compare('record_unit_id',$this->record_unit_id);
		$criteria->compare('record_operator_requester',$this->record_operator_requester);
		$criteria->compare('record_operator_auditor',$this->record_operator_auditor);
		$criteria->compare('record_date',$this->record_date,true);
		$criteria->compare('record_timestamp',$this->record_timestamp);
		$criteria->compare('record_public_keyfile',$this->record_public_keyfile,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Record the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
