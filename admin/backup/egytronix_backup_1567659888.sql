

CREATE TABLE `branches` (
  `Loc_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Branch_Name` varchar(255) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `Telephone` int(20) NOT NULL,
  PRIMARY KEY (`Loc_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;




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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO categories VALUES("1","lzwkqow","mwrwrr","0","1","0","0");
INSERT INTO categories VALUES("3","lkfhacfca","c;elwmr","0","0","0","0");
INSERT INTO categories VALUES("4","rwrwr","w3f","0","3","1","1");



CREATE TABLE `events` (
  `Event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Name` varchar(500) NOT NULL,
  `Event_Date` date NOT NULL DEFAULT current_timestamp(),
  `Event_Des` text NOT NULL,
  `Main_Image` varchar(255) NOT NULL,
  `Some_Images` varchar(3000) NOT NULL,
  PRIMARY KEY (`Event_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO events VALUES("4","dsfs","2019-09-03","ssfs","FB_IMG_1555515706976.jpg","FB_IMG_1564802199565.jpg,a.jpg");
INSERT INTO events VALUES("5","dsfs","2019-09-03","ssfs","FB_IMG_1555515706976.jpg","FB_IMG_1564802199565.jpg");
INSERT INTO events VALUES("7","dsfs","2019-09-03","ssfs","FB_IMG_1555515706976.jpg","Array");
INSERT INTO events VALUES("8","dsfs","2019-09-03","ssfs","FB_IMG_1555515706976.jpg",":zprove:zsomee:zsomeea.jpga.jpg,a.jpg,a.jpg");
INSERT INTO events VALUES("9","dsfs","2019-09-03","ssfs","FB_IMG_1555515706976.jpg","0,a.jpg");
INSERT INTO events VALUES("10","dsfs","2019-09-03","ssfs","FB_IMG_1555515706976.jpg","0");
INSERT INTO events VALUES("11","dsfs","2019-09-03","ssfs","FB_IMG_1555515706976.jpg","0");
INSERT INTO events VALUES("12","dsfs","2019-09-03","ssfs","FB_IMG_1555515706976.jpg","FB_IMG_1555515706976.jpg");
INSERT INTO events VALUES("13","","2019-09-03","","","FB_IMG_1546722881616.jpg");
INSERT INTO events VALUES("14","","2019-09-03","","","a.jpg");
INSERT INTO events VALUES("15","","2019-09-03","","","2");



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
  PRIMARY KEY (`Item_ID`),
  KEY `cat_1` (`Cat_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO items VALUES("2","pintrg","gioerhg","1","2019-08-28","","0","0","1","gergerg,ggrgtr");



CREATE TABLE `messages` (
  `MsgID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` int(255) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Message` mediumtext NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`MsgID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO messages VALUES("1","rana","rana@gmail.com","0","hi","ldhsd jdsfjdf fjpdfuwefpwe nfdofjmcffufdhvijxvzxnklzxnvlxvnvknznxvlzxi
ldhsd jdsfjdf fjpdfuwefpwe nfdofjmcffufdhvijxvzxnklzxnvlxvnvknznxvlzxi
ldhsd jdsfjdf fjpdfuwefpwe nfdofjmcffufdhvijxvzxnklzxnvlxvnvknznxvlzxi
ldhsd jdsfjdf fjpdfuwefpwe nfdofjmcffufdhvijxvzxnklzxnvlxvnvknznxvlzxi
ldhsd jdsfjdf fjpdfuwefpwe nfdofjmcffufdhvijxvzxnklzxnvlxvnvknznxvlzxi
ldhsd jdsfjdf fjpdfuwefpwe nfdofjmcffufdhvijxvzxnklzxnvlxvnvknznxvlzxi","0000-00-00");



CREATE TABLE `news` (
  `News_ID` int(11) NOT NULL AUTO_INCREMENT,
  `News` text NOT NULL,
  `Avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`News_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO news VALUES("2","fsd","FB_IMG_1564802199565.jpg");



CREATE TABLE `ubout_us` (
  `AboutID` int(11) NOT NULL AUTO_INCREMENT,
  `about` text NOT NULL,
  `history` text NOT NULL,
  `missions` text NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`AboutID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO ubout_us VALUES("1","xff","wefef","weffff","FB_IMG_1546722881616.jpg");



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

