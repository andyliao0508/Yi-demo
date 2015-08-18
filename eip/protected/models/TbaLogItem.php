<?php

/**
 * This is the model class for table "tba_log_item".
 *
 * The followings are the available columns in table 'tba_log_item':
 * @property string $id
 * @property string $logname
 * @property string $cname
 * @property string $ename
 * @property string $logtype
 * @property string $seqno
 * @property string $days
 * @property string $baseday
 * @property string $unit
 * @property string $sex
 * @property string $position
 * @property string $salaryitem
 * @property string $basewage
 * @property string $overtime
 * @property string $optshow
 * @property string $weight
 * @property string $memo
 * @property string $opt1
 * @property string $opt2
 * @property string $opt3
 * @property string $opt4
 * @property string $opt5
 * @property string $cemp
 * @property string $uemp
 * @property string $ctime
 * @property string $utime
 * @property string $ip
 */
class TbaLogItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tba_log_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('logname, cname', 'required'),
			array('logname, cname, ename', 'length', 'max'=>20),
			array('logtype', 'length', 'max'=>2),
                                                          array('baseday', 'length', 'max'=>3),
                                                          array('seqno', 'length', 'max'=>4),
			array('days', 'length', 'max'=>6),
			array('unit, sex, basewage, overtime, optshow, weight, opt1, opt2, opt3, opt4, opt5', 'length', 'max'=>1),
			array('position, memo', 'length', 'max'=>255),
			array('salaryitem', 'length', 'max'=>3),
			array('cemp, uemp', 'length', 'max'=>8),
			array('ip', 'length', 'max'=>15),
			array('ctime, utime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, logname, cname, ename, logtype, seqno, days, baseday, unit, sex, position, salaryitem, basewage, overtime, optshow, weight, memo, opt1, opt2, opt3, opt4, opt5, cemp, uemp, ctime, utime, ip', 'safe', 'on'=>'search'),
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
			'id' => 'id',
			'logname' => '項目',
			'cname' => '中文名',
			'ename' => '英文名',
			'logtype' => '差勤類別',
			'seqno' => '順序',
			'days' => '日數',
			'baseday' => '申請基數',
			'unit' => '申請單位',
			'sex' => '申請性別',
			'position' => '申請職務',
			'salaryitem' => '薪資項目',
			'basewage' => '基本工資',
			'overtime' => '加班費',
			'optshow' => '是否顯示',
			'weight' => '權重',
			'memo' => '備註',
			'opt1' => '是否使用',
			'opt2' => '遲到',
			'opt3' => '不換算',
			'opt4' => '備用4',
			'opt5' => '備用5',
			'cemp' => '建立人員',
			'uemp' => '修改人員',
			'ctime' => '建立時間',
			'utime' => '修改時間',
			'ip' => '異動IP',
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
		$criteria->compare('logname',$this->logname,true);
		$criteria->compare('cname',$this->cname,true);
		$criteria->compare('ename',$this->ename,true);
		$criteria->compare('logtype',$this->logtype,true);
		$criteria->compare('seqno',$this->seqno,true);
		$criteria->compare('days',$this->days,true);
		$criteria->compare('baseday',$this->baseday,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('salaryitem',$this->salaryitem,true);
		$criteria->compare('basewage',$this->basewage,true);
		$criteria->compare('overtime',$this->overtime,true);
		$criteria->compare('optshow',$this->optshow,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('opt1',$this->opt1,true);
		$criteria->compare('opt2',$this->opt2,true);
		$criteria->compare('opt3',$this->opt3,true);
		$criteria->compare('opt4',$this->opt4,true);
		$criteria->compare('opt5',$this->opt5,true);
		$criteria->compare('cemp',$this->cemp,true);
		$criteria->compare('uemp',$this->uemp,true);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('utime',$this->utime,true);
		$criteria->compare('ip',$this->ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                                        'pagination'=>array('pageSize'=>40),                
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TbaLogItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
