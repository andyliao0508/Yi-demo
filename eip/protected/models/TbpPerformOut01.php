<?php

/**
 * This is the model class for table "tbp_perform_out01".
 *
 * The followings are the available columns in table 'tbp_perform_out01':
 * @property string $id
 * @property string $name
 * @property string $item
 * @property string $sequence
 * @property string $opt1
 * @property string $opt2
 * @property string $opt3
 * @property string $cemp
 * @property string $uemp
 * @property string $ctime
 * @property string $utime
 * @property string $ip
 */
class TbpPerformOut01 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbp_perform_out01';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cemp, ctime, ip', 'required'),
			array('name', 'length', 'max'=>64),
			array('item, sequence', 'length', 'max'=>255),
			array('opt1', 'length', 'max'=>1),
			array('opt2, opt3', 'length', 'max'=>20),
			array('cemp, uemp', 'length', 'max'=>8),
			array('ip', 'length', 'max'=>15),
			array('utime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, item, sequence, opt1, opt2, opt3, cemp, uemp, ctime, utime, ip', 'safe', 'on'=>'search'),
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
			'name' => '名稱',
			'item' => '項目',
			'sequence' => '順序',
			'opt1' => '是否使用',
			'opt2' => '備用2',
			'opt3' => '備用3',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('sequence',$this->sequence,true);
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
	 * @return TbpPerformOut01 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
         /**
        * 取得欄位
        * @return string
        */
        public function getRptCol(){

            $col = array();
            array_push($col, 'pdate');
            array_push($col, 'area');
            array_push($col, 'storename');
            array_push($col, 'empname');
            array_push($col, 'total');
            array_push($col, 'output');
            array_push($col, 'remit');
            array_push($col, 'realremit');
    //        array_push($col, 'realtype');
            array_push($col, 'realmemo');
            array_push($col, 'col1' );// 剪髮   
            array_push($col, 'col2' );// 染髮   
            array_push($col, 'col3' );// 助染   
            array_push($col, 'col4' );// 洗髮   
            array_push($col, 'col5' );// 優染   
            array_push($col, 'col6' );// 優助染 
            array_push($col, 'col7' );// 舒活SPA
            array_push($col, 'col8' );// 養護SPA
            array_push($col, 'col9' );// 洗髮棈 
            array_push($col, 'col10' );// 剪髮(促)
            array_push($col, 'col11' );// 洗髮(促)
            array_push($col, 'perform');
            array_push($col, 'assist');

            return $col;
        }

        /**
         * 取得標題
         * @return string
         */
        public function getRptTitle(){
            $title = array(
                'pdate'=>'日期',
                'area' => '營業區',
                'storename' => '門市',
                'empname' => '員工',
                'total' => '合計',
                'output' => '支出',
                'remit' => '匯款金額',
                'realremit' => '實際匯款金額',
    //            'realtype' => '實際匯款類別',
                'realmemo' => '實際匯款備註',
                'col1' => '剪髮',
                'col2' => '染髮',
                'col3' => '助染',
                'col4' => '洗髮',
                'col5' => '優染',
                'col6' => '優助染',
                'col7' => '舒活SPA',
                'col8' => '養護SPA',
                'col9' => '洗髮精',
                'col10' => '剪髮(促)',
                'col11' => '洗髮(促)',
                'perform' => '業績',
                'assist' => '洗助染'
            );

            return $title;
        }
        
        public function getRemitCol(){

            $col = array();
            array_push($col, 'receiptno');//單據號碼
            array_push($col, 'pdate');//銷貨日期
            array_push($col, 'personno');//客戶編號
            array_push($col, 'account');//帳款歸屬
            array_push($col, 'currency');//使用幣別
            array_push($col, 'rate');//匯率
            array_push($col, 'price');//產品單價
            array_push($col, 'taxclass'); //課稅類別 
            array_push($col, 'sales');//業務人員編號
            array_push($col, 'storecode' );  //所屬部門編號
            array_push($col, 'addressno' );// 客戶地址編號
            array_push($col, 'postno' );// 郵政編號
            array_push($col, 'address' );// 地址 
            array_push($col, 'person' );// 聯絡人員   
            array_push($col, 'position' );// 聯絡職稱   
            array_push($col, 'tel' );// 連絡電話   
            array_push($col, 'co16' );// 自訂欄位一 
            array_push($col, 'col7' );// 自訂欄位二
            array_push($col, 'note' );// 備註
            array_push($col, 'productno' );// 產品編號 
            array_push($col, 'co20' );// 品名規格
            array_push($col, 'warehouseno' );// 倉庫編號
            array_push($col, 'amount' );// 數量
            array_push($col, 'uprice' );// 單價
            array_push($col, 'total' );// 金額
            array_push($col, 'gift' );// 是否贈品
            array_push($col, 'co25' );// 細項描述
            array_push($col, 'co26' );// 分錄備註

            return $col;
        }

        /**
         * 取得標題
         * @return string
         */
        public function getRemitTitle(){
            $title = array(
                'receiptno'=>'單據號碼',
                'pdate' => '銷貨日期',
                'personno' => '客戶編號',
                'account' => '帳款歸屬',
                'currency' => '使用幣別',
                'rate' => '匯率',
                'price' => '產品單價',
                'taxclass' => '課稅類別',  
                'sales' => '業務人員編號',
                'storecode' => '所屬部門編號',
                'addressno' => '客戶地址編號',
                'postno' => '郵政編號',
                'address' => '地址',
                'person' => '聯絡人員',
                'position' => '聯絡職稱',
                'tel' => '連絡電話',
                'co16' => '自訂欄位一',
                'col7' => '自訂欄位二',
                'note' => '備註',
                'productno' => '產品編號',
                'co20' => '品名規格',
                'warehouseno' => '倉庫編號',
                'amount' => '數量',
                'uprice' => '單價',
                'total' => '金額',
                'gift'=>'是否贈品',
                'co25' => '細項描述',
                'co26' => '分錄備註'              
            );

            return $title;
        }
}
