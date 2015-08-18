<?php

/**
 * This is the model class for table "tbp_output_log".
 *
 * The followings are the available columns in table 'tbp_output_log':
 * @property string $id
 * @property string $pdate
 * @property string $storecode
 * @property string $storename
 * @property string $itemid
 * @property string $itemname
 * @property string $mainid
 * @property string $subid
 * @property string $type
 * @property string $feeno
 * @property string $account
 * @property string $num
 * @property string $price
 * @property string $dates
 * @property string $datee
 * @property string $temp1
 * @property string $temp2
 * @property string $temp3
 * @property string $memo
 * @property string $opt1
 * @property string $cemp
 * @property string $uemp
 * @property string $ctime
 * @property string $utime
 * @property string $ip
 */
class TbpOutputLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbp_output_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemid, itemname, mainid, subid, type', 'required'),
			array('pdate, dates, datee, cemp, uemp', 'length', 'max'=>8),
			array('storecode', 'length', 'max'=>6),
			array('storename, temp1, temp2, temp3', 'length', 'max'=>10),
			array('itemid, mainid, subid, num, price', 'length', 'max'=>5),
			array('itemname, feeno, account', 'length', 'max'=>20),
			array('type, opt1', 'length', 'max'=>1),
			array('memo', 'length', 'max'=>255),
			array('ip', 'length', 'max'=>15),
			array('ctime, utime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pdate, storecode, storename, itemid, itemname, mainid, subid, type, feeno, account, num, price, dates, datee, temp1, temp2, temp3, memo, opt1, cemp, uemp, ctime, utime, ip', 'safe', 'on'=>'search'),
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
			'pdate' => '日期',
			'storecode' => '門市編碼',
			'storename' => '門市名稱',
			'itemid' => '細項id',
			'itemname' => '細項名稱',
			'mainid' => '主項id',
			'subid' => '次項id',
			'type' => '類別',
			'feeno' => '費用編號',
			'account' => '會計科目',
			'num' => '數量',
			'price' => '金額',
			'dates' => '日期開始',
			'datee' => '日期結束',
			'temp1' => '暫存1',
			'temp2' => '暫存2',
			'temp3' => '暫存3',
			'memo' => '備註',
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
		$criteria->compare('pdate',$this->pdate,true);
		$criteria->compare('storecode',$this->storecode,true);
		$criteria->compare('storename',$this->storename,true);
		$criteria->compare('itemid',$this->itemid,true);
		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('mainid',$this->mainid,true);
		$criteria->compare('subid',$this->subid,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('feeno',$this->feeno,true);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('num',$this->num,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('dates',$this->dates,true);
		$criteria->compare('datee',$this->datee,true);
		$criteria->compare('temp1',$this->temp1,true);
		$criteria->compare('temp2',$this->temp2,true);
		$criteria->compare('temp3',$this->temp3,true);
		$criteria->compare('memo',$this->memo,true);
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
	 * @return TbpOutputLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        

        public function compare($log) {

          $valid = TRUE;

          if($this->id != $log->id) $valid = FALSE;
          if($valid) if($this->pdate != $log->pdate) $valid = FALSE;
          if($valid) if($this->itemid != $log->itemid) $valid = FALSE;
          if($valid) if($this->num != $log->num) $valid = FALSE;
          if($valid) if($this->price != $log->price) $valid = FALSE;
          if($valid) if($this->dates != $log->dates) $valid = FALSE;
          if($valid) if($this->datee != $log->datee) $valid = FALSE;
          if($valid) if($this->temp1 != $log->temp1) $valid = FALSE;
          if($valid) if($this->temp2 != $log->temp2) $valid = FALSE;
          if($valid) if($this->temp3 != $log->temp3) $valid = FALSE;
          if($valid) if($this->memo != $log->memo) $valid = FALSE;
          
          return $valid;
        }        
        
}
