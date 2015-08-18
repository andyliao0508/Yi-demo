<?php

/**
 * This is the model class for table "tba_param".
 *
 * The followings are the available columns in table 'tba_param':
 * @property string $id
 * @property string $param
 * @property string $cname
 * @property string $pvalue
 * @property string $memo
 * @property string $opt1
 * @property string $opt2
 * @property string $opt3
 * @property string $cemp
 * @property string $uemp
 * @property string $ctime
 * @property string $utime
 * @property string $ip
 */
class TbaParam extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tba_param';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('param', 'required'),
			array('param', 'length', 'max'=>20),
			array('cname', 'length', 'max'=>64),
			array('pvalue, memo', 'length', 'max'=>255),
			array('opt1, opt2, opt3', 'length', 'max'=>1),
			array('cemp, uemp', 'length', 'max'=>8),
			array('ip', 'length', 'max'=>15),
			array('utime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, param, cname, pvalue, memo, opt1, opt2, opt3, cemp, uemp, ctime, utime, ip', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'param' => '變數代碼',
			'cname' => '變數名稱',
			'pvalue' => '變數內容',
			'memo' => '備註',
			'opt1' => '是否使用',
			'opt2' => '備用2',
			'opt3' => '備用3',
			'cemp' => '建立人員',
			'uemp' => '修改人員',
			'ctime' => '建立時間',
			'utime' => '修改時間',
			'ip' => 'Ip',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('cname',$this->cname,true);
		$criteria->compare('pvalue',$this->pvalue,true);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('opt1',$this->opt1,true);
		$criteria->compare('opt2',$this->opt2,true);
		$criteria->compare('opt3',$this->opt3,true);
		$criteria->compare('cemp',$this->cemp,true);
		$criteria->compare('uemp',$this->uemp,true);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('utime',$this->utime,true);
		$criteria->compare('ip',$this->ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TbaParam the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
