<?php

/**
 * This is the model class for table "tbp_output_item".
 *
 * The followings are the available columns in table 'tbp_output_item':
 * @property string $id
 * @property string $cname
 * @property string $ename
 * @property string $mainid
 * @property string $subid
 * @property string $type
 * @property string $feeno
 * @property string $account
 * @property string $memo
 * @property string $summary
 * @property string $opt1
 * @property string $cemp
 * @property string $uemp
 * @property string $ctime
 * @property string $utime
 * @property string $ip
 */
class TbpOutputItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbp_output_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cname, type', 'required'),
			array('cname, ename, feeno, account', 'length', 'max'=>20),
			array('mainid, subid', 'length', 'max'=>4),
			array('type, opt1', 'length', 'max'=>1),
			array('memo, summary', 'length', 'max'=>255),
			array('cemp, uemp', 'length', 'max'=>8),
			array('ip', 'length', 'max'=>15),
			array('ctime, utime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cname, ename, mainid, subid, type, feeno, account, memo,summary, opt1, cemp, uemp, ctime, utime, ip', 'safe', 'on'=>'search'),
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
			'cname' => '中文名',
			'ename' => '英文名',
			'mainid' => '主項id',
			'subid' => '次項id',
			'type' => '類別',
			'feeno' => '費用編號',
			'account' => '會計科目',
			'memo' => '備註',
                        'summary' => '摘要',
			'opt1' => '是否使用',
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
		$criteria->compare('cname',$this->cname,true);
		$criteria->compare('ename',$this->ename,true);
		$criteria->compare('mainid',$this->mainid,true);
		$criteria->compare('subid',$this->subid,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('feeno',$this->feeno,true);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('memo',$this->memo,true);
                $criteria->compare('summary',$this->summary,true);
		$criteria->compare('opt1',$this->opt1,true);
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
	 * @return TbpOutputItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
