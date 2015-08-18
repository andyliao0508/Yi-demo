--
-- Table structure for table `user`
-- 紀錄員編及密碼
DROP TABLE IF EXISTS `tbs_user`;
CREATE TABLE `tbs_user` (
  `empno` varchar(8) NOT NULL COMMENT '員編',
  `username` varchar(20) NOT NULL COMMENT '暱稱',
  `pwd_hash` varchar(64) NOT NULL COMMENT '密碼',
  `emp_id` int(10) unsigned NOT NULL COMMENT 'emp_id',
  `memo` varchar(255) COMMENT '備註',
  `opt1` varchar(1) DEFAULT '1' COMMENT '是否使用',
  `opt2` varchar(1) COMMENT '備用2',
  `opt3` varchar(1) COMMENT '備用3',
  `cemp` varchar(8) NOT NULL COMMENT '建立人員',
  `ctime` DATETIME NOT NULL COMMENT '建立時間',
  `uemp` varchar(8) NOT NULL COMMENT '修改人員',  
  `utime` DATETIME NOT NULL COMMENT '修改時間',
  `ip` varchar(15) NOT NULL COMMENT '異動IP',
  PRIMARY KEY (`empno`),
  KEY `useremp_ibfk_2` (`emp_id`),
  CONSTRAINT `useremp_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `tbs_emp` (`id`) ON DELETE CASCADE
) ;

--
-- Table structure for table `tbs_emp`
-- 紀錄員工基本資料
DROP TABLE IF EXISTS `tbs_emp`;
CREATE TABLE `tbs_emp` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `empno` varchar(8) NOT NULL COMMENT '員編',
  `sex` varchar(1) NOT NULL COMMENT '性別',
  `idno` varchar(10) COMMENT '身分證',
  `empname` varchar(64) NOT NULL COMMENT '姓名',
  `bankname` varchar(64) COMMENT '匯款姓名',
  `bankidno` varchar(10) COMMENT '匯款身分證',
  `bankcode` varchar(3) COMMENT '匯款銀行',
  `bankacc` varchar(14) COMMENT '匯款帳戶',
  `famname1` varchar(64) COMMENT '家屬1',
  `famidno1` varchar(10) COMMENT '家屬身分證1',
  `famname2` varchar(64) COMMENT '家屬2',
  `famidno2` varchar(10) COMMENT '家屬身分證2',
  `famname3` varchar(64) COMMENT '家屬3',
  `famidno3` varchar(10) COMMENT '家屬身分證3',
  `famname4` varchar(64) COMMENT '家屬4',
  `famidno4` varchar(10) COMMENT '家屬身分證4',
  `tel` varchar(10) COMMENT '電話',
  `mobile` varchar(10) COMMENT '行動電話',
  `emername` varchar(64) COMMENT '緊急聯絡人',
  `emertel` varchar(10) COMMENT '緊急聯絡電話',
  `addrhouse` varchar(255) COMMENT '戶籍地址',
  `addrcomm` varchar(255) COMMENT '通訊地址',
  `birthday` DATE COMMENT '生日',
  `email` varchar(255) COMMENT '電子信箱',
  `picurl` varchar(255) COMMENT '個人照片',
  `resumeurl` varchar(255) COMMENT '履歷圖檔',
  `file1url` varchar(255) COMMENT '附件1',
  `file2url` varchar(255) COMMENT '附件2',
  `sign` varchar(1) DEFAULT '0' COMMENT '是否簽約',
  `signtype` varchar(2) COMMENT '簽約類別', 
  `signstart` DATE COMMENT '簽約日期(起)',
  `signend`  DATE COMMENT '簽約日期(迄)',
  `signmemo` varchar(255) COMMENT '簽約備註',
  `memo` varchar(255) COMMENT '備註',
  `opt1` varchar(1) DEFAULT '1' COMMENT '是否使用',
  `opt2` varchar(1) COMMENT '備用2',
  `opt3` varchar(1) COMMENT '備用3',
  `cemp` varchar(8) NOT NULL COMMENT '建立人員',
  `ctime` DATETIME NOT NULL COMMENT '建立時間',
  `uemp` varchar(8) NOT NULL COMMENT '修改人員',  
  `utime` DATETIME NOT NULL COMMENT '修改時間',
  `ip` varchar(15) NOT NULL COMMENT '異動IP',
  PRIMARY KEY (`id`)
) ;

--
-- Table structure for table `tbs_emp_month`
-- 每月薪資異動
DROP TABLE IF EXISTS `tbs_emp_month`;
CREATE TABLE `tbs_emp_month` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `empno`     varchar(8) NOT NULL COMMENT '員工編號',
  `empname`     varchar(64) NOT NULL COMMENT '員工姓名',
  `daymonth` varchar(6) NOT NULL COMMENT '年月',
  `arrivedate` DATE COMMENT '到職日',
  `arriveins`  DATE COMMENT '加保日',
  `leavedate` DATE COMMENT '離職日',
  `leaveins`  DATE COMMENT '退保日',
  `insunit`    int(4) unsigned COMMENT '加保單位',   
  `inssalary`  int(4) unsigned COMMENT '投保薪資',   
  `position1` int(2) unsigned COMMENT '職位1',
  `position2` int(2) unsigned COMMENT '職位2',
  `position3` int(2) unsigned COMMENT '職位3',
  `hiretype` varchar(1) DEFAULT 'F' COMMENT '顧用性質',
  `depart`    int(4) unsigned COMMENT '部門',
  `area`       int(4) unsigned COMMENT '區域',
  `storecode` varchar(6) COMMENT '門市',
  `salary`      int(4) unsigned COMMENT '薪資福利',  
  `file1name`    varchar(64) COMMENT '附件1名稱',
  `file1url`        varchar(255) COMMENT '附件1位置',
  `file1memo`   varchar(255) COMMENT '附件1備註',
  `file2name`    varchar(64) COMMENT '附件2名稱',
  `file2url`        varchar(255) COMMENT '附件2位置',
  `file2memo`   varchar(255) COMMENT '附件2備註',
  `file3name`    varchar(64) COMMENT '附件3名稱',
  `file3url`        varchar(255) COMMENT '附件3位置',
  `file3memo`   varchar(255) COMMENT '附件3備註',
  `memo` varchar(255) COMMENT '備註',
  `opt1` varchar(1) DEFAULT '1' COMMENT '是否使用',
  `opt2` int(2) COMMENT '區店長門市數',
  `opt3` int(2) COMMENT '在職狀態',
  `cemp` varchar(8) NOT NULL COMMENT '建立人員',
  `ctime` DATETIME NOT NULL COMMENT '建立時間',
  `uemp` varchar(8) NOT NULL COMMENT '修改人員',  
  `utime` DATETIME NOT NULL COMMENT '修改時間',
  `ip` varchar(15) NOT NULL COMMENT '異動IP',
  PRIMARY KEY (`id`)  
) ;
--
-- Table structure for table `tbs_workstatus`
-- 在職狀態
DROP TABLE IF EXISTS `tbs_workstatus`;
CREATE TABLE tbs_workstatus(
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `status` VARCHAR(20) COMMENT '狀態',
    `pay` VARCHAR(1) COMMENT '給薪',
    `salary` INT(2) unsigned COMMENT '薪資條件',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP', 
    PRIMARY KEY (`id`)
);

-- Table structure for table `tbs_areaduty`
-- 區店長責任額
DROP TABLE IF EXISTS `tbs_areaduty`;
CREATE TABLE tbs_areaduty(
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `storenum` TINYINT COMMENT '門市數',
    `duty` INT(3) COMMENT '責任額',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP', 
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_bank`
-- 銀行帳戶
DROP TABLE IF EXISTS `tbs_bank`;
CREATE TABLE tbs_bank (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `bankcode` VARCHAR(3) NOT NULL COMMENT '銀行代碼',
   `bankname` VARCHAR(20) NOT NULL  COMMENT '銀行名稱',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_inscom`
-- 投保單位
DROP TABLE IF EXISTS `tbs_inscom`;
CREATE TABLE tbs_inscom (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `insname` VARCHAR(20) NOT NULL COMMENT '投保單位',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_inslabor`
-- 月投保薪資
DROP TABLE IF EXISTS `tbs_inslabor`;
CREATE TABLE tbs_inslabor (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `salary`          INT(4) unsigned NOT NULL COMMENT '月投保薪資',
   `laborins`       INT(4) unsigned NOT NULL COMMENT '普通事故保險費(個人)',
   `laborjob`       INT(4) unsigned NOT NULL COMMENT '就業保險費(個人)',
   `sumlabor`      INT(4) unsigned NOT NULL COMMENT '勞保費合計(個人)',
   `bossins`        INT(4) unsigned NOT NULL COMMENT '普通事故保險費(雇主)',
   `bossjob`        INT(4) unsigned NOT NULL COMMENT '就業保險費(雇主)',
   `bosshazards`  INT(4) unsigned NOT NULL COMMENT '職業災害保險費(雇主)',
   `bosslabor`     INT(4) unsigned NOT NULL COMMENT '勞保費合計(雇主)',
   `bossfund`      INT(4) unsigned NOT NULL COMMENT '職業災害保險費(雇主)',
   `bosslabor2`   INT(4) unsigned NOT NULL COMMENT '助理合計(雇主)',
   `laborretire`   INT(4) unsigned NOT NULL COMMENT '勞退提撥',
   `healthins`    INT(4) unsigned NOT NULL COMMENT '健保費本人',
   `healthins1`  INT(4) unsigned NOT NULL COMMENT '健保費本人+1眷口',
   `healthins2`  INT(4) unsigned NOT NULL COMMENT '健保費本人+2眷口',
   `healthins3`  INT(4) unsigned NOT NULL COMMENT '健保費本人+3眷口',
   `bosshealth`  INT(4) unsigned NOT NULL COMMENT '健保費雇主負擔',
   `govhealth`  INT(4) unsigned NOT NULL COMMENT '健保費政府負擔',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `opt2` varchar(1) COMMENT '備用2',
   `opt3` varchar(1) COMMENT '備用3',
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_basesalary`
-- 紀錄保底薪資
DROP TABLE IF EXISTS `tbs_basesalary`;
CREATE TABLE `tbs_basesalary` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `basevalue` varchar(20) NOT NULL COMMENT '保底',
  `salary` int(3) unsigned NOT NULL COMMENT '底薪',
  `duty`    int(3) unsigned     COMMENT '責任額',
  `rate`    DECIMAL(5,4)    COMMENT '抽成比率',
  `weight` int(3) unsigned      COMMENT '權重表',
  `type_MH`     varchar(1)      COMMENT '類別',
  `type_FP`       varchar(1)      COMMENT '全職兼職',
  `compute`      varchar(2)      COMMENT '算法',
  `month`         varchar(2)      COMMENT '未滿月',
  `holiday`       varchar(2)      COMMENT '公婚喪',
  `comtmp1`     varchar(2)      COMMENT '算法備用1',
  `comtmp2`     varchar(2)      COMMENT '算法備用2',
  `position`       int(2) unsigned      COMMENT '職位',
  `basewage`    int(3) unsigned      COMMENT '基本工資',
  `overtime`     int(3) unsigned      COMMENT '加班費',
  `ins_salary`   int(2) unsigned      COMMENT '投保金額',
  `ins_include`  varchar(1)      COMMENT '勞退',
  `duty_in`       int(3) unsigned      COMMENT '責任內業績抽成',
  `duty_rate`    DECIMAL(3,2)    COMMENT '過責任額抽成',
  `orderby`      int(4) unsigned      COMMENT '順序',
  `memo` varchar(255) COMMENT '備註',
  `opt1` varchar(1) DEFAULT '1' COMMENT '是否使用',
  `opt2` varchar(1) COMMENT '備用2',
  `opt3` varchar(1) COMMENT '備用3',
  `cemp` varchar(8) NOT NULL COMMENT '建立人員',
  `ctime` DATETIME NOT NULL COMMENT '建立時間',
  `uemp` varchar(8) NOT NULL COMMENT '修改人員',  
  `utime` DATETIME NOT NULL COMMENT '修改時間',
  `ip` varchar(15) NOT NULL COMMENT '異動IP',
  PRIMARY KEY (`id`)
) ;

--
-- Table structure for table `tbs_depart`
-- 紀錄部門基本資料
DROP TABLE IF EXISTS `tbs_depart`;
CREATE TABLE `tbs_depart` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `dname` varchar(20) NOT NULL COMMENT '英文名稱',
  `dcname` varchar(20) NOT NULL COMMENT '中文名稱',
  `parent` int(2) unsigned COMMENT '上一層',
  `memo` varchar(255) COMMENT '備註',
  `opt1` varchar(1) DEFAULT '1' COMMENT '是否使用',
  `opt2` varchar(1) COMMENT '備用2',
  `opt3` varchar(1) COMMENT '備用3',
  `cemp` varchar(8) NOT NULL COMMENT '建立人員',
  `ctime` DATETIME NOT NULL COMMENT '建立時間',
  `uemp` varchar(8) NOT NULL COMMENT '修改人員',  
  `utime` DATETIME NOT NULL COMMENT '修改時間',
  `ip` varchar(15) NOT NULL COMMENT '異動IP',
  PRIMARY KEY (`id`)
) ;

--
-- Table structure for table `tbs_area`
-- 記錄區域設定
DROP TABLE IF EXISTS `tbs_area`;
CREATE TABLE tbs_area (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `areanum` VARCHAR(2) NOT NULL DEFAULT '00' COMMENT '區域',
   `areaname` VARCHAR(20) NOT NULL COMMENT '區域名',
   `areatype_id` INT(2) unsigned COMMENT '區域類別',
   `areagroup_id` INT(2) unsigned COMMENT '區域群組',
   `empno1` VARCHAR(8) NOT NULL COMMENT '區店長員編',
   `empname1` VARCHAR(20) NOT NULL COMMENT '區店長姓名',
   `empno2` VARCHAR(8) COMMENT '代理區店長員編',
   `empname2` VARCHAR(20) COMMENT '代理區店長姓名',
  `memo` varchar(255) COMMENT '備註',
  `opt1` varchar(1) DEFAULT '1' COMMENT '是否使用',
  `opt2` varchar(1) COMMENT '備用2',
  `opt3` varchar(1) COMMENT '備用3',
  `cemp` varchar(8) NOT NULL COMMENT '建立人員',
  `ctime` DATETIME NOT NULL COMMENT '建立時間',
  `uemp` varchar(8) NOT NULL COMMENT '修改人員',  
  `utime` DATETIME NOT NULL COMMENT '修改時間',
  `ip` varchar(15) NOT NULL COMMENT '異動IP',
  PRIMARY KEY (`id`),
  KEY `areatype_ibfk_1` (`areatype_id`),
  KEY `areagroup_ibfk_2` (`areagroup_id`),
  CONSTRAINT `areatype_ibfk_1` FOREIGN KEY (`areatype_id`) REFERENCES `tbs_area_type` (`id`) ON DELETE CASCADE,
  CONSTRAINT `areagroup_ibfk_2` FOREIGN KEY (`areagroup_id`) REFERENCES `tbs_area_group` (`id`) ON DELETE CASCADE
);

--
-- Table structure for table `tbs_area_type`
-- 記錄區域類別
DROP TABLE IF EXISTS `tbs_area_type`;
CREATE TABLE tbs_area_type (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
   `ename` VARCHAR(20) COMMENT '英文名',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_area_group`
-- 記錄區域群組
DROP TABLE IF EXISTS `tbs_area_group`;
CREATE TABLE tbs_area_group (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
   `ename` VARCHAR(20) COMMENT '英文名',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_position`
-- 記錄職位表
DROP TABLE IF EXISTS `tbs_position`;
CREATE TABLE tbs_position (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `pname` VARCHAR(20) COMMENT '英文名字',
   `pcname` VARCHAR(20) NOT NULL COMMENT '中文名字',
   `level` int(2) unsigned NOT NULL COMMENT '階層',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `opt2` VARCHAR(1) COMMENT '備用2',    
   `opt3` VARCHAR(1) COMMENT '備用3',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_store`
-- 服務門市
DROP TABLE IF EXISTS `tbs_store`;
CREATE TABLE tbs_store (
   `id` INT(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `storecode`  VARCHAR(6) NOT NULL COMMENT '門市編號',
    `storename`  VARCHAR(10) NOT NULL COMMENT '門市名稱',
    `oldarea` VARCHAR(2) COMMENT '舊區域',
    `oldcity`  VARCHAR(2) COMMENT '舊縣市',
    `oldnum`  VARCHAR(3) COMMENT '舊編號',
    `oldcode`  VARCHAR(7) COMMENT '舊店代號',
    `oldname`  VARCHAR(10) COMMENT '舊店名',
    `depart_id` INT(11) NOT NULL COMMENT '部門ID',
    `area_id` INT(11) COMMENT '區域ID',
    `post`  VARCHAR(5) COMMENT '郵遞區號',
    `city` INT(2) unsigned  COMMENT '縣市',
    `region`  INT(4) unsigned COMMENT '鄉鎮區',
    `address`  VARCHAR(255) COMMENT '地址',
    `googlemap`  VARCHAR(255) COMMENT 'google',
    `tel1`  VARCHAR(10) COMMENT '電話1',
    `tel2`  VARCHAR(10) COMMENT '電話2',
    `tel3`  VARCHAR(10) COMMENT '電話3',
    `fax`  VARCHAR(10) COMMENT '傳真',
    `storeip1` VARCHAR(15) COMMENT '電腦IP',
    `storeip2` VARCHAR(15) COMMENT '售票IP',
    `storeip3` VARCHAR(15) COMMENT '監視器IP',
    `storeip4` VARCHAR(15) COMMENT '備用IP4',
    `storeip5` VARCHAR(15) COMMENT '備用IP5',
    `teamview1` VARCHAR(9) COMMENT '電腦TV',
    `teamview2` VARCHAR(9) COMMENT '售票機TV',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `opt2` VARCHAR(1) COMMENT '備用2',    
   `opt3` VARCHAR(1) COMMENT '備用3',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);


--
-- Table structure for table `tbs_store_agent`
-- 門市代理人
DROP TABLE IF EXISTS `tbs_store_agent`;
CREATE TABLE tbs_store_agent (
   `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `storecode`  VARCHAR(6) NOT NULL COMMENT '店代號',
   `storename`   VARCHAR(12) NOT NULL COMMENT '門市名稱',
   `daymonth`    VARCHAR(6) NOT NULL COMMENT '年月',
   `empno`        VARCHAR(8) NOT NULL COMMENT '門市名稱',
   `empname`    VARCHAR(64) NOT NULL COMMENT '門市名稱',
   `allowances`  int(3) unsigned NOT NULL COMMENT '門市名稱',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `opt2` VARCHAR(1) COMMENT '備用2',    
   `opt3` VARCHAR(1) COMMENT '備用3',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

-- Table structure for table `tbs_store_tel_equip`
-- 門市電話設備
DROP TABLE IF EXISTS `tbs_store_tel_equip`;
CREATE TABLE `tbs_store_tel_equip` (
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `storecode` VARCHAR(6) NOT NULL COMMENT '門市編碼',
    `storename` VARCHAR(10) COMMENT '門市名稱',
    `tel` VARCHAR(10) COMMENT '分店電話',
    `contractend` DATE COMMENT '租約到期日',
    `registrants` VARCHAR(20) COMMENT '登記人',
    `rid` VARCHAR(10) COMMENT '身分證字號',
    `adslno` VARCHAR(10) COMMENT 'ADSL用戶號碼',
    `modtel` VARCHAR(10) COMMENT 'MOD附卦電話',
    `modendday` DATE COMMENT 'MOD竣工日期',
    `modno` VARCHAR(10) COMMENT 'MOD維修編號',
    `gateway` VARCHAR(15) COMMENT '預設閘道',
    `installcomputer` VARCHAR(20) COMMENT '是否有安裝電腦',
    `adslend` DATE COMMENT 'ADSL租約到期日',
    `changestorecode` VARCHAR(20) COMMENT '移轉店名',
    `storecontractend` DATE COMMENT '分店租約到期日',
    `limit` VARCHAR(4) COMMENT '限制撥國際/長途(呼叫鎖碼)',
    `username` VARCHAR(8) COMMENT '使用者名稱(帳號)',
    `password` VARCHAR(20) COMMENT '密碼',
    `cable` VARCHAR(20) COMMENT '第四台',
    `cht` VARCHAR(20) COMMENT '中華電信區域服務人員',
    `changeuser` VARCHAR(20) COMMENT '改用戶名',
    `contractor` VARCHAR(20) COMMENT '水電',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(20) COMMENT '備用2',    
    `opt3` VARCHAR(20) COMMENT '備用3', 
    `opt4` VARCHAR(20) COMMENT '備用4',    
    `opt5` VARCHAR(20) COMMENT '備用5',    
    `opt6` VARCHAR(20) COMMENT '備用6',    
    `opt7` VARCHAR(20) COMMENT '備用7',    
    `opt8` VARCHAR(20) COMMENT '備用8',    
    `opt9` VARCHAR(20) COMMENT '備用9',    
    `opt10` VARCHAR(20) COMMENT '備用10',    
    `opt11` VARCHAR(20) COMMENT '備用11',    
    `opt12` VARCHAR(20) COMMENT '備用12',    
    `opt13` VARCHAR(20) COMMENT '備用13',    
    `opt14` VARCHAR(20) COMMENT '備用14',    
    `opt15` VARCHAR(20) COMMENT '備用15',    
    `opt16` VARCHAR(20) COMMENT '備用16',    
    `opt17` VARCHAR(20) COMMENT '備用17',    
    `opt18` VARCHAR(20) COMMENT '備用18',    
    `opt19` VARCHAR(20) COMMENT '備用19',    
    `opt20` VARCHAR(20) COMMENT '備用20',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_storetime`
-- 營業時間
DROP TABLE IF EXISTS `tbs_storetime`;
CREATE TABLE tbs_storetime (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `storecode`  VARCHAR(6) NOT NULL COMMENT '店代號',
   `day1s` TIME NOT NULL DEFAULT '10:00:00' COMMENT '星期一(開門)',
   `day1e` TIME NOT NULL DEFAULT '22:00:00' COMMENT '星期一(關門)',
   `day2s` TIME NOT NULL DEFAULT '10:00:00' COMMENT '星期二(開門)',
   `day2e` TIME NOT NULL DEFAULT '22:00:00' COMMENT '星期二(關門)',
   `day3s` TIME NOT NULL DEFAULT '10:00:00' COMMENT '星期三(開門)',
   `day3e` TIME NOT NULL DEFAULT '22:00:00' COMMENT '星期三(關門)',
   `day4s` TIME NOT NULL DEFAULT '10:00:00' COMMENT '星期四(開門)',
   `day4e` TIME NOT NULL DEFAULT '22:00:00' COMMENT '星期四(關門)',
   `day5s` TIME NOT NULL DEFAULT '10:00:00' COMMENT '星期五(開門)',
   `day5e` TIME NOT NULL DEFAULT '22:00:00' COMMENT '星期五(關門)',
   `day6s` TIME NOT NULL DEFAULT '10:00:00' COMMENT '星期六(開門)',
   `day6e` TIME NOT NULL DEFAULT '22:00:00' COMMENT '星期六(關門)',
   `day7s` TIME NOT NULL DEFAULT '10:00:00' COMMENT '星期日(開門)',
   `day7e` TIME NOT NULL DEFAULT '22:00:00' COMMENT '星期日(關門)',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `opt2` VARCHAR(1) COMMENT '備用2',    
   `opt3` VARCHAR(1) COMMENT '備用3',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_service`
-- 服務項目
DROP TABLE IF EXISTS `tbs_service`;
CREATE TABLE tbs_service (
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `serviceno` VARCHAR(4) NOT NULL COMMENT '服務編碼',
    `machineno` VARCHAR(2) COMMENT '售票編號',
    `ticketnum` TINYINT(1) COMMENT '一次出票數',
    `cname` VARCHAR(40) NOT NULL COMMENT '服務名稱',
    `ename` VARCHAR(40) COMMENT '英文名稱',
    `showname` VARCHAR(40) COMMENT '顯示名稱',
    `description` VARCHAR(255) COMMENT '說明',
    `group` VARCHAR(2) COMMENT '群組',
    `type1` INT(2) unsigned NOT NULL COMMENT '服務類別1',
    `type2` INT(2) unsigned COMMENT '服務類別2',
    `price` SMALLINT(4) unsigned DEFAULT 0 COMMENT '金額',
    `prodno` VARCHAR(20) COMMENT '物料編號',
    `mappingno` VARCHAR(20) COMMENT '對應編號',
    `perform`  DECIMAL(5,1) COMMENT '業績算法',
    `draw`      DECIMAL(5,1) COMMENT '抽成金額',
    `nomonth`  DECIMAL(5,1) COMMENT '不足月抽成',
    `noreceive`  VARCHAR(4) COMMENT '少收代碼',
    `chgprice` SMALLINT(4) COMMENT '匯款異動',
    `optshow`  VARCHAR(1) NOT NULL default '1' COMMENT '預設顯示',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_service_type1`
-- 服務類別1
DROP TABLE IF EXISTS `tbs_service_type1`;
CREATE TABLE tbs_service_type1 (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
   `ename` VARCHAR(20) COMMENT '英文名',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbs_service_type2`
-- 服務類別2

DROP TABLE IF EXISTS `tbs_service_type2`;
CREATE TABLE tbs_service_type2 (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
   `ename` VARCHAR(20) COMMENT '英文名',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

------------------------------------------------------------------------------------------------------------------------------------------------------------
-- 業績系統 資料庫
------------------------------------------------------------------------------------------------------------------------------------------------------------
--
-- Table structure for table `tbp_param`
-- 業績系統公用變數
DROP TABLE IF EXISTS `tbp_param`;
CREATE TABLE tbp_param (
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `param` VARCHAR(20) NOT NULL COMMENT '變數代碼',
    `cname` VARCHAR(64) COMMENT '變數名稱',
    `pvalue` VARCHAR(255) COMMENT '變數內容',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbp_st_service`
-- 門市對應服務表
DROP TABLE IF EXISTS `tbp_st_service`;
CREATE TABLE `tbp_st_service` (
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `storecode` VARCHAR(6) NOT NULL COMMENT '門市編碼',
    `storename` VARCHAR(10) COMMENT '門市名稱',
    `serviceno` VARCHAR(4) COMMENT '服務編碼',
    `machineno` VARCHAR(2) COMMENT '銷售編號',
    `queue` INT(2) unsigned COMMENT '排列順序',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否顯示',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbp_perform`
-- 門市業績主檔
-- 加入匯款異動功能
DROP TABLE IF EXISTS `tbp_perform`;
CREATE TABLE `tbp_perform` (
    `id` INT(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `pdate` VARCHAR(8) NOT NULL COMMENT '業績日期',
    `storecode` VARCHAR(6) NOT NULL COMMENT '門市編碼',
    `storename` VARCHAR(10) COMMENT '門市名稱',
    `total` DECIMAL(8,1) NOT NULL COMMENT '合計金額',
    `output` DECIMAL(8,1) COMMENT '支出金額',
    `remit` DECIMAL(8,1) NOT NULL COMMENT '匯款金額',    
    `realremit`  DECIMAL(8,1)  COMMENT '實匯金額',    
    `realtype`    VARCHAR(2)  COMMENT '實匯問題類別',    
    `realmemo` VARCHAR(255)  COMMENT '實匯備註',    
    `realuemp`  VARCHAR(8)  COMMENT '實匯異動人員',    
    `realutime` DATETIME  COMMENT '實匯異動時間',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbp_perform_log`
-- 門市業績明細檔
DROP TABLE IF EXISTS `tbp_perform_log`;
CREATE TABLE `tbp_perform_log` (
    `id` INT(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `pdate` VARCHAR(8) NOT NULL COMMENT '業績日期',
    `storecode` VARCHAR(6) NOT NULL COMMENT '門市編碼',
    `storename` VARCHAR(10) COMMENT '門市名稱',
    `serviceno` VARCHAR(4) NOT NULL COMMENT '服務項目',
    `showname` VARCHAR(40) COMMENT '顯示名稱',
    `type1` INT(2) unsigned NOT NULL COMMENT '服務類別1',
    `num` INT(2) unsigned COMMENT '數量',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) COMMENT '備用1',    
     PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbp_perform_emp`
-- 門市個人業績主檔
DROP TABLE IF EXISTS `tbp_perform_emp`;
CREATE TABLE `tbp_perform_emp` (
    `id` INT(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `pdate` VARCHAR(8) NOT NULL COMMENT '業績日期',
    `storecode` VARCHAR(6) NOT NULL COMMENT '門市編碼',
    `storename` VARCHAR(10) COMMENT '門市名稱',
    `queue` INT(2) unsigned NOT NULL COMMENT '排列順序',
    `empno` VARCHAR(8) NOT NULL  COMMENT '員工編號',
    `empname` VARCHAR(64) COMMENT '員工姓名',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) COMMENT '備用1',    
     PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbp_perform_emp_log`
-- 門市個人業績明細檔
DROP TABLE IF EXISTS `tbp_perform_emp_log`;
CREATE TABLE `tbp_perform_emp_log` (
    `id` INT(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `pdate` VARCHAR(8) NOT NULL COMMENT '業績日期',
    `storecode` VARCHAR(6) NOT NULL COMMENT '門市編碼',
    `storename` VARCHAR(10) COMMENT '門市名稱',
    `serviceno` VARCHAR(4) NOT NULL COMMENT '服務項目',
    `type1` INT(2) unsigned NOT NULL COMMENT '服務類別1',
    `empno` VARCHAR(8) COMMENT '員工編號',
    `empname` VARCHAR(64) COMMENT '員工姓名',
    `num` INT(4) unsigned COMMENT '數量',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) COMMENT '備用1',    
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbp_perform_param_rpt08`
-- 報表
DROP TABLE IF EXISTS `tbp_perform_param_rpt08`;
CREATE TABLE `tbp_perform_param_rpt08` (
    `id` INT(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `empno` VARCHAR(8)  COMMENT '員編',
    `rpttype` VARCHAR(8)  COMMENT '報表類型',
    `rptname` VARCHAR(8)  COMMENT '報表名稱',
    `check` VARCHAR(255)  COMMENT '選取項目',
    `sequence` VARCHAR(255)  COMMENT '順序',
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(20) COMMENT '備用2',    
    `opt3` VARCHAR(20) COMMENT '備用3', 
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbp_perform_param_rpt08_type`
-- 報表類型
DROP TABLE IF EXISTS `tbp_perform_param_rpt08_type`;
CREATE TABLE `tbp_perform_param_rpt08_type` (
    `id` INT(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `rpttype` VARCHAR(64) COMMENT '報表類型',
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(20) COMMENT '備用2',    
    `opt3` VARCHAR(20) COMMENT '備用3', 
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbp_perform_param_rpt08_name`
-- 報表名稱
DROP TABLE IF EXISTS `tbp_perform_param_rpt08_name`;
CREATE TABLE `tbp_perform_param_rpt08_name` (
    `id` INT(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `type_id` VARCHAR(8) COMMENT '報表類型_id',
    `rptname` VARCHAR(64) COMMENT '報表名稱',
    `rights` VARCHAR(255) COMMENT '報表權限',
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(20) COMMENT '備用2',    
    `opt3` VARCHAR(20) COMMENT '備用3', 
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

-- 以上為業績系統
------------------------------------------------------------------------------------------------------------------------------------------------------------
-- 薪資系統 資料庫
------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Table structure for table `tbm_param`
-- 薪資系統公用變數
DROP TABLE IF EXISTS `tbm_param`;
CREATE TABLE tbm_param (
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `param` VARCHAR(20) NOT NULL COMMENT '變數代碼',
    `cname` VARCHAR(64) COMMENT '變數名稱',
    `pvalue` VARCHAR(20) COMMENT '變數內容',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbm_weight`
-- 權重表
DROP TABLE IF EXISTS `tbm_weight`;
CREATE TABLE tbm_weight (
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `salary` INT(3) unsigned NOT NULL COMMENT '薪資福利',
    `duty` INT(3) unsigned COMMENT '責任業績',
    `dailywage` INT(2) unsigned COMMENT '理論日薪',
    `weight` INT(2) unsigned NOT NULL COMMENT '每一權重金額',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbm_item`
-- 薪資系統公用變數
DROP TABLE IF EXISTS `tbm_item`;
CREATE TABLE tbm_item (
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `itemno` VARCHAR(3) NOT NULL COMMENT '項目編號',
    `item` VARCHAR(20) NOT NULL COMMENT '項目',
    `group` INT(1) unsigned COMMENT '群組',
    `type` INT(2) unsigned COMMENT '類別',
    `default` VARCHAR(255) COMMENT '預設值',
    `unit` VARCHAR(10) COMMENT '單位',
    `formula` VARCHAR(255) COMMENT '公式 ',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbm_item_type`
-- 薪資類別表
DROP TABLE IF EXISTS `tbm_item_type`;
CREATE TABLE tbm_item_type (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
   `ename` VARCHAR(20) COMMENT '英文名',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

--
-- Table structure for table `tbm_item_group`
-- 薪資群組表
DROP TABLE IF EXISTS `tbm_item_group`;
CREATE TABLE tbm_item_group (
   `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
   `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
   `ename` VARCHAR(20) COMMENT '英文名',
   `memo` VARCHAR(255) COMMENT '備註',    
   `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
   `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
   `uemp` VARCHAR(8) COMMENT '修改人員',
   `ctime` DATETIME NOT NULL COMMENT '建立時間',
   `utime` DATETIME COMMENT '修改時間',
   `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
    PRIMARY KEY (`id`)
);

-- Table structure for table `tbm_emp_item`
-- 員工每月薪資項目資料表
DROP TABLE IF EXISTS `tbm_emp_item`;
CREATE TABLE tbm_emp_item (
    `id` INT(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `daymonth` VARCHAR(6) NOT NULL COMMENT '年月',
    `empno` VARCHAR(8) NOT NULL COMMENT '員工編號',
    `empname` VARCHAR(64) COMMENT '員工姓名',
    `itemno` VARCHAR(3) NOT NULL COMMENT '項目編號',
    `value` VARCHAR(255) COMMENT '內容',
    `eachmonth` VARCHAR(1) NOT NULL default '0'  COMMENT '每月都有',    
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);


-- Table structure for table `tbm_payroll`
-- 員工每月薪資項目資料表
DROP TABLE IF EXISTS `tbm_payroll`;
CREATE TABLE tbm_payroll (
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `payrollno` VARCHAR(3) NOT NULL COMMENT '項目編號',
    `payroll` VARCHAR(20) NOT NULL COMMENT '項目',
    `group` INT(1) unsigned COMMENT '群組',
    `type` INT(2) unsigned COMMENT '類別',
    `default` VARCHAR(255) COMMENT '預設值',
    `unit` VARCHAR(10) COMMENT '單位',
    `formula` VARCHAR(255) COMMENT '公式 ',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);


-- Table structure for table `tbm_history`
-- 員工歷史資料表
DROP TABLE IF EXISTS `tbm_history`;
CREATE TABLE tbm_history (
    `id` INT(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `daymonth` VARCHAR(6) NOT NULL COMMENT '年月',
    `empno` VARCHAR(8) NOT NULL COMMENT '員工編號',
    `empname` VARCHAR(64) COMMENT '員工姓名',
    `itemno` VARCHAR(3) NOT NULL COMMENT '項目編號',
    `value` VARCHAR(255) NOT NULL COMMENT '內容',
    `eachmonth` VARCHAR(1) NOT NULL default '0'  COMMENT '每月都有',    
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbm_apart`
-- 薪資拆算
DROP TABLE IF EXISTS `tbm_apart`;
CREATE TABLE tbm_apart (
    `id` INT(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `daymonth` VARCHAR(6) NOT NULL COMMENT '年月',
    `empno` VARCHAR(8) NOT NULL COMMENT '員工編號',
    `empname` VARCHAR(64) COMMENT '員工姓名',
    `storecode` VARCHAR(7) NOT NULL COMMENT '門市編號',
    `storeperform` INT(4) unsigned COMMENT '門市業績',
    `ratio` DECIMAL(5,4) default '0'  COMMENT '業績佔比',    
    `storesalary` INT(4) unsigned COMMENT '分配薪資',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(1) COMMENT '備用2',    
    `opt3` VARCHAR(1) COMMENT '備用3',    
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

-- View Structure for view `view_store_service`
-- CREATE view view_store_service as
-- select a.id, a.storecode, a.storename, a.serviceno, a.machineno, a.queue, a.memo, a.opt1, 
--          b.cname, b.showname, b.description, b.group, b.type1, b.price, b.perform, b.draw, b.nomonth, b.noreceive, b.chgprice
-- from tbp_st_service a, tbs_service b
-- where a.serviceno = b.serviceno
-- 門市服務VIEW檔
DROP TABLE IF EXISTS `view_store_service`;
CREATE TABLE `view_store_service` (
    `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `storecode` VARCHAR(6) NOT NULL COMMENT '門市編碼',
    `storename` VARCHAR(10) COMMENT '門市名稱',
    `serviceno` VARCHAR(4) COMMENT '服務編碼',
    `machineno` VARCHAR(2) COMMENT '銷售編號',    
    `queue` INT(2) unsigned COMMENT '排列順序',
    `memo` VARCHAR(255) COMMENT '備註',    
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否顯示',    
    `cname` VARCHAR(40) NOT NULL COMMENT '服務名稱',
    `showname` VARCHAR(40) COMMENT '顯示名稱',
    `description` VARCHAR(255) COMMENT '說明',
    `group` VARCHAR(2) COMMENT '群組',
    `type1` INT(2) unsigned NOT NULL COMMENT '服務類別1',
    `price` SMALLINT(4) unsigned DEFAULT 0 COMMENT '金額',
    `perform`  DECIMAL(5,1) COMMENT '業績算法',
    `draw`      DECIMAL(5,1) COMMENT '抽成金額',
    `nomonth`  DECIMAL(5,1) COMMENT '不足月抽成',
    `noreceive`  VARCHAR(4) COMMENT '少收代碼',
    `chgprice` SMALLINT(4) COMMENT '匯款異動',
     PRIMARY KEY (`id`)
);

    --公告系統
    DROP TABLE IF EXISTS `tba_board`;
    CREATE TABLE `tba_board` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
      `title`  varchar(255)  NOT NULL COMMENT '標題',
      `content`  varchar(255) NOT NULL COMMENT '內容',
      `imagename`  varchar(255)   COMMENT '圖片名稱',
      `imageurl`  varchar(255)   COMMENT '圖片網址',
      `imagetype`  varchar(255)   COMMENT '圖片型態',
      `boarddepart`  varchar(2)  COMMENT '公告部門',
      `type`  varchar(2)  COMMENT '公告類別',
      `priority`  varchar(2)  COMMENT '優先權',
      `depart`     varchar(2)  COMMENT '部門',
      `area`    varchar(2)  COMMENT '區位',
      `store`     varchar(6)      COMMENT '門市',
      `dates`       date       COMMENT '日期開始',
      `datee`       date       COMMENT '日期結束',
      `opt1` varchar(1) DEFAULT '1' COMMENT '是否使用', 
      `opt2` varchar(1) COMMENT '備用2',
      `opt3` varchar(1) COMMENT '備用3',
      `cemp` varchar(8)  COMMENT '建立人員',
      `ctime` DATETIME  COMMENT '建立時間',
      `uemp` varchar(8)  COMMENT '修改人員',  
      `utime` DATETIME  COMMENT '修改時間',
      `ip` varchar(15)  COMMENT '異動IP',
      PRIMARY KEY (`id`)
    );

    --公告系統-員工閱讀記錄
    DROP TABLE IF EXISTS `tba_board_emp_log`;
    CREATE TABLE `tba_board_emp_log` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
      `board_id`  int(11) unsigned  NOT NULL COMMENT '公告id',
      `board_title`  varchar(255) COMMENT '標題',
      `empno`  varchar(8)  NOT NULL COMMENT '員工編號',
      `empname`  varchar(20) COMMENT '員工姓名',
      `read` varchar(1)  NOT NULL DEFAULT '1' COMMENT '已讀',
      `opt1` varchar(1) DEFAULT '1' COMMENT '是否使用', 
      `opt2` varchar(1) COMMENT '備用2',
      `opt3` varchar(1) COMMENT '備用3',
      `cemp` varchar(8)  COMMENT '建立人員',
      `ctime` DATETIME  COMMENT '建立時間',
      `uemp` varchar(8)  COMMENT '修改人員',  
      `utime` DATETIME  COMMENT '修改時間',
      `ip` varchar(15)  COMMENT '異動IP',
      PRIMARY KEY (`id`)
    );

    -- 公布欄系統變數
    DROP TABLE IF EXISTS `tba_param`;
    CREATE TABLE tba_param (
        `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
        `param` VARCHAR(20) NOT NULL COMMENT '變數代碼',
        `cname` VARCHAR(64) COMMENT '變數名稱',
        `pvalue` VARCHAR(255) COMMENT '變數內容',
        `memo` VARCHAR(255) COMMENT '備註',    
        `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
        `opt2` VARCHAR(1) COMMENT '備用2',    
        `opt3` VARCHAR(1) COMMENT '備用3',    
        `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
        `uemp` VARCHAR(8) COMMENT '修改人員',
        `ctime` DATETIME NOT NULL COMMENT '建立時間',
        `utime` DATETIME COMMENT '修改時間',
        `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
         PRIMARY KEY (`id`)
    );

    -- 差勤獎懲公用變數變數
        DROP TABLE IF EXISTS `tba_param_crud`;
        CREATE TABLE tba_param_crud (
            `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
            `param` VARCHAR(20) NOT NULL COMMENT '變數代碼',
            `cname` VARCHAR(64) NOT NULL COMMENT '變數名稱',
            `pvalue` VARCHAR(255) NOT NULL COMMENT '變數內容',
            `memo` VARCHAR(255) COMMENT '備註',    
            `opt1` VARCHAR(1)  default '1' COMMENT '是否使用',    
            `opt2` VARCHAR(1) COMMENT '備用2',    
            `opt3` VARCHAR(1) COMMENT '備用3',    
            `cemp` VARCHAR(8) COMMENT '建立人員',
            `uemp` VARCHAR(8) COMMENT '修改人員',
            `ctime` DATETIME  COMMENT '建立時間',
            `utime` DATETIME  COMMENT '修改時間',
            `ip` VARCHAR(15)  COMMENT '異動IP',    
             PRIMARY KEY (`id`)
        );

    --差勤系統-JIT國定假日
    DROP TABLE IF EXISTS `tba_holiday`;
    CREATE TABLE tba_holiday (
        `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
        `holiday` VARCHAR(8) NOT NULL COMMENT '假日日期',
        `dayname` VARCHAR(64) COMMENT '假日名稱',
        `memo` VARCHAR(255) COMMENT '備註',    
        `opt1` VARCHAR(1)  default '1' COMMENT '是否使用',    
        `opt2` VARCHAR(1) COMMENT '備用2',    
        `opt3` VARCHAR(1) COMMENT '備用3',    
        `cemp` VARCHAR(8) COMMENT '建立人員',
        `uemp` VARCHAR(8) COMMENT '修改人員',
        `ctime` DATETIME  COMMENT '建立時間',
        `utime` DATETIME  COMMENT '修改時間',
        `ip` VARCHAR(15)  COMMENT '異動IP',    
         PRIMARY KEY (`id`)
    );

    --差勤系統-差勤獎懲類別
       DROP TABLE IF EXISTS `tba_log_type`;
       CREATE TABLE tba_log_type (
           `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
           `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
           `ename` VARCHAR(20) COMMENT '英文名',
           `memo` VARCHAR(255) COMMENT '備註',    
           `opt1` VARCHAR(1)  default '1' COMMENT '是否使用',      
           `cemp` VARCHAR(8) COMMENT '建立人員',
           `uemp` VARCHAR(8) COMMENT '修改人員',
           `ctime` DATETIME  COMMENT '建立時間',
           `utime` DATETIME  COMMENT '修改時間',
           `ip` VARCHAR(15)  COMMENT '異動IP',    
            PRIMARY KEY (`id`)
       );

    --差勤系統-差勤獎懲項目
       DROP TABLE IF EXISTS `tba_log_item`;
       CREATE TABLE tba_log_item (
           `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
           `logname` VARCHAR(20) NOT NULL COMMENT '項目',
           `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
           `ename` VARCHAR(20) COMMENT '英文名',
           `logtype` VARCHAR(2) COMMENT '差勤類別',
           `seqno` int(2) unsigned COMMENT '順序',
           `days`    DECIMAL(5,1)  COMMENT '日數',
           `baseday`    DECIMAL(2,1)  COMMENT '申請基數',
           `unit`    varchar(1)   COMMENT '申請單位',
           `sex`    varchar(1) default '0'  COMMENT '申請性別',
           `position`  varchar(255)     COMMENT '申請職務',
           `salaryitem` varchar(3)      COMMENT '薪資項目',
           `basewage`   varchar(1)      COMMENT '基本工資',
           `overtime`   varchar(1)      COMMENT '加班費',
           `show`   varchar(1)  default '1'    COMMENT '是否顯示',
           `weight` varchar(1)  default '0'    COMMENT '權重',
           `memo` VARCHAR(255) COMMENT '備註',    
           `opt1` VARCHAR(1)  default '1' COMMENT '備用1',  
           `opt2` VARCHAR(1)  COMMENT '備用2',
           `opt3` VARCHAR(1)  COMMENT '備用3',
           `opt4` VARCHAR(1)  COMMENT '備用4',
           `opt5` VARCHAR(1)  COMMENT '備用5',    
           `cemp` VARCHAR(8) COMMENT '建立人員',
           `uemp` VARCHAR(8) COMMENT '修改人員',
           `ctime` DATETIME  COMMENT '建立時間',
           `utime` DATETIME  COMMENT '修改時間',
           `ip` VARCHAR(15)  COMMENT '異動IP',    
            PRIMARY KEY (`id`)
       );

    --差勤系統-差勤獎懲權重表
       DROP TABLE IF EXISTS `tba_weight`;
       CREATE TABLE tba_weight (
           `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
           `logitem` int(2) unsigned COMMENT '差勤項目',
           `nweight`  DECIMAL(3,1) NOT NULL  COMMENT '平日權重',
           `hweight`  DECIMAL(3,1) NOT NULL  COMMENT '假日權重',
           `memo` VARCHAR(255) COMMENT '備註',    
           `opt1` VARCHAR(1)  default '1' COMMENT '是否使用',
           `opt2` VARCHAR(1)  COMMENT '備用2',  
           `opt3` VARCHAR(1)  COMMENT '備用3',        
           `cemp` VARCHAR(8) COMMENT '建立人員',
           `uemp` VARCHAR(8) COMMENT '修改人員',
           `ctime` DATETIME  COMMENT '建立時間',
           `utime` DATETIME  COMMENT '修改時間',
           `ip` VARCHAR(15)  COMMENT '異動IP',    
            PRIMARY KEY (`id`)
       );

    --差勤系統-差勤獎懲紀錄查詢
       DROP TABLE IF EXISTS `tba_log`;
       CREATE TABLE tba_log (
           `id` INT(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
           `logday` VARCHAR(8) NOT NULL COMMENT '日期',
           `storecode` VARCHAR(6) NOT NULL COMMENT '店編',
           `storename` VARCHAR(10) COMMENT '店名',
           `empno` VARCHAR(8) COMMENT '員工編號',
           `empname` VARCHAR(64) COMMENT '員工姓名',
           `logtype` VARCHAR(2) COMMENT'差勤類別',
           `logitem` INT(2) unsigned COMMENT '差勤項目',
           `logname` VARCHAR(20) NOT NULL COMMENT '項目',
           `num`  DECIMAL(4,1)  COMMENT '數量',
           `leavecheck` VARCHAR(1) default '0' COMMENT '請假單',
           `leavefile` VARCHAR(255) COMMENT '請假單據',
           `provecheck` VARCHAR(1) default '0' COMMENT '證明',
           `provefile` VARCHAR(255) COMMENT '證明單據',
           `classcheck` VARCHAR(1) default '0' COMMENT '輪值',
           `classfile` VARCHAR(255) COMMENT '輪值單據',       
           `memo` VARCHAR(255) COMMENT '備註',    
           `opt1` VARCHAR(1)  default '1' COMMENT '是否使用',
           `opt2` VARCHAR(1)  COMMENT '備用2',  
           `opt3` VARCHAR(1)  COMMENT '備用3',        
           `cemp` VARCHAR(8) COMMENT '建立人員',
           `uemp` VARCHAR(8) COMMENT '修改人員',
           `ctime` DATETIME  COMMENT '建立時間',
           `utime` DATETIME  COMMENT '修改時間',
           `ip` VARCHAR(15)  COMMENT '異動IP',    
            PRIMARY KEY (`id`)
       );

-- Table structure for table `tbp_perform_out01`
-- 報表
    DROP TABLE IF EXISTS `tbp_perform_out01`;
    CREATE TABLE `tbp_perform_out01` (
    `id` INT(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `name` VARCHAR(64) COMMENT '名稱',
    `item` VARCHAR(255)  COMMENT '項目',
    `sequence` VARCHAR(255)  COMMENT '順序',
    `opt1` VARCHAR(1) NOT NULL default '1' COMMENT '是否使用',    
    `opt2` VARCHAR(20) COMMENT '備用2',    
    `opt3` VARCHAR(20) COMMENT '備用3', 
    `cemp` VARCHAR(8) NOT NULL COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME NOT NULL COMMENT '建立時間',
    `utime` DATETIME COMMENT '修改時間',
    `ip` VARCHAR(15) NOT NULL COMMENT '異動IP',    
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbp_output_main`
-- 門市支出主項
    DROP TABLE IF EXISTS `tbp_output_main`;
    CREATE TABLE `tbp_output_main` (
    `id` INT(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
    `ename` VARCHAR(20) COMMENT '英文名',
    `feeno` VARCHAR(20) COMMENT '費用編號',
    `account` VARCHAR(20) COMMENT '會計科目',
    `memo` VARCHAR(255) COMMENT '備註',
    `opt1` VARCHAR(1)  default '1' COMMENT '是否使用',      
    `cemp` VARCHAR(8) COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME  COMMENT '建立時間',
    `utime` DATETIME  COMMENT '修改時間',
    `ip` VARCHAR(15)  COMMENT '異動IP',      
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbp_output_sub`
-- 門市支出次項
    DROP TABLE IF EXISTS `tbp_output_sub`;
    CREATE TABLE `tbp_output_sub` (
    `id` INT(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
    `ename` VARCHAR(20) COMMENT '英文名',
    `mainid` INT(4) unsigned  COMMENT '主項id',
    `nextlog` VARCHAR(1) NOT NULL COMMENT '是否有細項',
    `feeno` VARCHAR(20) COMMENT '費用編號',
    `account` VARCHAR(20) COMMENT '會計科目',
    `memo` VARCHAR(255) COMMENT '備註',
    `opt1` VARCHAR(1)  default '1' COMMENT '是否使用',      
    `cemp` VARCHAR(8) COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME  COMMENT '建立時間',
    `utime` DATETIME  COMMENT '修改時間',
    `ip` VARCHAR(15)  COMMENT '異動IP',      
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbp_output_item`
-- 門市支出細項
    DROP TABLE IF EXISTS `tbp_output_item`;
    CREATE TABLE `tbp_output_item` (
    `id` INT(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `cname` VARCHAR(20) NOT NULL COMMENT '中文名',
    `ename` VARCHAR(20) COMMENT '英文名',
    `mainid` INT(4) unsigned  COMMENT '主項id',
    `subid` INT(4) unsigned  COMMENT '次項id',
    `type` VARCHAR(1) NOT NULL COMMENT '類別',
    `feeno` VARCHAR(20) COMMENT '費用編號',
    `account` VARCHAR(20) COMMENT '會計科目',
    `summary` VARCHAR(255)  COMMENT '摘要',
    `memo` VARCHAR(255) COMMENT '備註',
    `opt1` VARCHAR(1)  default '1' COMMENT '是否使用',      
    `cemp` VARCHAR(8) COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME  COMMENT '建立時間',
    `utime` DATETIME  COMMENT '修改時間',
    `ip` VARCHAR(15)  COMMENT '異動IP',      
     PRIMARY KEY (`id`)
);

-- Table structure for table `tbp_output_log`
-- 門市支出紀錄
    DROP TABLE IF EXISTS `tbp_output_log`;
    CREATE TABLE `tbp_output_log` (
    `id` INT(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
    `pdate` VARCHAR(8)  COMMENT '日期',
    `storecode` VARCHAR(6) COMMENT '門市編碼',
    `storename` VARCHAR(10) COMMENT '門市名稱',
    `itemid` INT(4) unsigned NOT NULL  COMMENT '細項id',
    `itemname` VARCHAR(20) NOT NULL COMMENT '細項名稱',
    `mainid` INT(4) unsigned  NOT NULL  COMMENT '主項id',
    `subid` INT(4) unsigned  NOT NULL  COMMENT '次項id',
    `type` VARCHAR(1) NOT NULL COMMENT '類別',
    `feeno` VARCHAR(20) COMMENT '費用編號',
    `account` VARCHAR(20) COMMENT '會計科目',
    `num` INT(4) unsigned    COMMENT '數量',
    `price` INT(4) unsigned    COMMENT '金額',
    `dates` VARCHAR(8)  COMMENT '日期開始',
    `datee` VARCHAR(8)  COMMENT '日期結束',
    `temp1` VARCHAR(10) COMMENT '暫存1',
    `temp2` VARCHAR(10) COMMENT '暫存2',
    `temp3` VARCHAR(10) COMMENT '暫存3',
    `memo` VARCHAR(255) COMMENT '備註',
    `opt1` VARCHAR(1)  default '1' COMMENT '是否使用',      
    `cemp` VARCHAR(8) COMMENT '建立人員',
    `uemp` VARCHAR(8) COMMENT '修改人員',
    `ctime` DATETIME  COMMENT '建立時間',
    `utime` DATETIME  COMMENT '修改時間',
    `ip` VARCHAR(15)  COMMENT '異動IP',      
     PRIMARY KEY (`id`)
);





