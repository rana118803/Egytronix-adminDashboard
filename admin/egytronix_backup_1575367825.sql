

CREATE TABLE `branches` (
  `Loc_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Branch_Name` varchar(255) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `Telephone` int(20) NOT NULL,
  PRIMARY KEY (`Loc_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `categories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `events` (
  `Event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Name` varchar(500) NOT NULL,
  `Event_Date` date NOT NULL DEFAULT current_timestamp(),
  `Event_Des` text NOT NULL,
  `Main_Image` varchar(255) NOT NULL,
  PRIMARY KEY (`Event_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `Avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`Item_ID`),
  KEY `cat_1` (`Cat_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `messages` (
  `MsgID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Message` mediumtext NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`MsgID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `news` (
  `News_ID` int(11) NOT NULL AUTO_INCREMENT,
  `News` text NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`News_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `ubout_us` (
  `AboutID` int(11) NOT NULL AUTO_INCREMENT,
  `about` text NOT NULL,
  `history` text NOT NULL,
  `missions` text NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`AboutID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO ubout_us VALUES("1","لشركة المصرية لتصميم و تصنيع النظم الإليكترونية و التحكم الالى هى إحدى شركات الهيئة العامة للإستثمار و المناطق الحرة و تعمل وفقا للقانون 8 لضمانات و حوافز الإستثمار .","تأسست الشركة عام 2004 بهدف تصميم و تصنيع النظم الإليكترونية لخدمة مجال المصاعد بأنواعها المختلفة ثم تتطور النشاط ليشمل تطبيقات أخرى فى مجال التحكم الالى و الإليكترونيات الصناعية كالتحكم فى سرعة المواتير و الماكينات و غيرها .","تعتبر الشركة المصرية من الشركات الرائدة فى مجال التحكم فى المصاعد و هى تعمل بإستمرار على تطوير منتجاتها لتتوافق مع متطلبات العملاء من خلال إستخدامها لأحدث تقنيات التصميم و التصنيع و من خلال وجود فريق من مهندسى التصميم و البحث و التطوير و الدعم الفنى و ضبط الجودة و الصيانة .  ","logo.jpg");



CREATE TABLE `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `Date` date NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserName` (`UserName`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO users VALUES("1","admin","123","rana@gmail.com","rana","1","2019-08-24");

