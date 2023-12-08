/*
SQLyog Enterprise Trial - MySQL GUI v8.05 
MySQL - 5.5.5-10.4.28-MariaDB : Database - project_s
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`project_s` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `project_s`;

/*Table structure for table `budget` */

DROP TABLE IF EXISTS `budget`;

CREATE TABLE `budget` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Amount` int(11) unsigned DEFAULT NULL,
  `Start_dt` date DEFAULT NULL,
  `End_dt` date DEFAULT NULL,
  `Updated_dt` datetime DEFAULT NULL,
  `Created_dt` datetime DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL,
  `Category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_user` (`User_id`),
  KEY `FK_budgett` (`Category_id`),
  CONSTRAINT `FK_budgett` FOREIGN KEY (`Category_id`) REFERENCES `category` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `FK_user` FOREIGN KEY (`User_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `start_end_date_check` CHECK (`Start_dt` < `End_dt`),
  CONSTRAINT `check_amount_non_negative` CHECK (`Amount` >= 0)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `budget` */

insert  into `budget`(`Id`,`Amount`,`Start_dt`,`End_dt`,`Updated_dt`,`Created_dt`,`User_id`,`Category_id`) values (1,10,'2023-12-31','2024-01-05','2023-12-07 02:56:41','2023-12-07 01:52:58',2,2),(2,0,'2023-12-07','2023-12-23','2023-12-07 03:01:09','2023-12-07 03:01:09',2,4),(25,123,'2023-12-15','2023-12-23','2023-12-06 20:22:23','2023-12-06 20:22:23',2,4),(26,2400,'2023-12-08','2023-12-16','2023-12-06 20:40:01','2023-12-06 20:40:01',2,2),(27,2000,'2023-12-05','2024-01-06','2023-12-07 01:58:43','2023-12-06 21:54:15',2,6),(29,100,'2023-12-09','2023-12-23','2023-12-06 21:58:23','2023-12-06 21:58:23',2,5);

/*Table structure for table `budgets` */

DROP TABLE IF EXISTS `budgets`;

CREATE TABLE `budgets` (
  `Id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `Amount` int(11) DEFAULT NULL,
  `Start_dt` datetime DEFAULT NULL,
  `End_dt` datetime DEFAULT NULL,
  `Updated_dt` datetime DEFAULT NULL,
  `Created_dt` datetime DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL,
  `Category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_budget` (`Category_id`),
  KEY `FK_budget2` (`User_id`),
  CONSTRAINT `FK_budget` FOREIGN KEY (`Category_id`) REFERENCES `category` (`Id`),
  CONSTRAINT `FK_budget2` FOREIGN KEY (`User_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `check_date_range` CHECK (`Start_dt` < `End_dt`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `budgets` */

insert  into `budgets`(`Id`,`Amount`,`Start_dt`,`End_dt`,`Updated_dt`,`Created_dt`,`User_id`,`Category_id`) values (00000000005,20002,'2023-12-05 09:57:13','2023-12-29 00:00:00','2023-12-06 21:37:13','2023-12-05 09:57:13',2,4),(00000000006,200,'2023-12-05 09:58:48','2023-12-16 00:00:00','2023-12-05 09:58:48','2023-12-05 09:58:48',2,3),(00000000007,400,'2023-12-05 10:01:32','2023-12-16 00:00:00','2023-12-05 10:01:32','2023-12-05 10:01:32',2,5),(00000000008,300,'2023-12-05 10:02:23','2023-12-22 00:00:00','2023-12-05 10:02:23','2023-12-05 10:02:23',2,2),(00000000009,100,'2023-12-05 10:04:59','2023-12-09 00:00:00','2023-12-05 10:04:59','2023-12-05 10:04:59',2,94),(00000000010,45,'2023-12-06 18:53:12','2023-12-12 00:00:00','2023-12-06 18:53:12','2023-12-06 18:53:12',2,3);

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) DEFAULT NULL,
  `Created_dt` datetime DEFAULT NULL,
  `Updated_dt` datetime DEFAULT NULL,
  `User_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `unique_category_name_per_user` (`User_id`,`Name`),
  KEY `FK_category` (`User_id`),
  CONSTRAINT `FK_category` FOREIGN KEY (`User_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `category` */

insert  into `category`(`Id`,`Name`,`Created_dt`,`Updated_dt`,`User_id`) values (2,'Makeup','2023-12-05 00:37:44','2023-12-06 12:46:32',2),(3,'Shopping','2023-12-04 20:03:59','2023-12-04 20:03:59',2),(4,'Grocery','2023-12-04 20:04:18','2023-12-06 12:46:24',2),(5,'Medical','2023-12-04 20:04:52','2023-12-04 20:04:52',2),(6,'Saving','2023-12-04 20:10:55','2023-12-06 22:00:52',2),(94,'Dresses','2023-12-04 22:18:45','2023-12-06 12:46:12',2),(114,'kk','2023-12-06 21:09:02','2023-12-06 21:09:02',2),(126,'Dress','2023-12-06 21:09:19','2023-12-06 21:09:19',2);

/*Table structure for table `expense` */

DROP TABLE IF EXISTS `expense`;

CREATE TABLE `expense` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Amount` int(11) unsigned NOT NULL,
  `Description` varchar(30) DEFAULT NULL,
  `Received_dt` datetime DEFAULT NULL,
  `Created_dt` datetime DEFAULT NULL,
  `Updated_dt` datetime DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL,
  `Category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_transaction` (`Category_id`),
  KEY `FK_transactions` (`User_id`),
  CONSTRAINT `FK_transaction` FOREIGN KEY (`Category_id`) REFERENCES `category` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `FK_transactions` FOREIGN KEY (`User_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `check_amount_non_negative` CHECK (`Amount` >= 0)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `expense` */

insert  into `expense`(`Id`,`Amount`,`Description`,`Received_dt`,`Created_dt`,`Updated_dt`,`User_id`,`Category_id`) values (15,300,'kuch','2023-12-02 00:00:00','2023-12-06 23:36:26','2023-12-06 23:36:26',2,2);

/*Table structure for table `goals` */

DROP TABLE IF EXISTS `goals`;

CREATE TABLE `goals` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) DEFAULT NULL,
  `Target_amount` int(11) unsigned NOT NULL,
  `Target_dt` datetime DEFAULT NULL,
  `Current_amount` int(11) unsigned NOT NULL,
  `Created_dt` datetime DEFAULT NULL,
  `Updated_dt` datetime DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL,
  `Status` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `unique_goal_name_per_user` (`User_id`,`Name`),
  KEY `FK_goals` (`User_id`),
  CONSTRAINT `FK_goals` FOREIGN KEY (`User_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `check_amount_non_negative` CHECK (`Target_amount` >= 0)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `goals` */

insert  into `goals`(`Id`,`Name`,`Target_amount`,`Target_dt`,`Current_amount`,`Created_dt`,`Updated_dt`,`User_id`,`Status`) values (1,'Mobile Phone',8000,'2023-12-15 00:00:00',2000,'2023-11-29 20:42:14','2023-12-06 17:16:35',2,'Not Done'),(4,'Wallet',2000,'2023-12-04 00:00:00',500,'2023-11-29 21:12:03','2023-11-29 21:12:03',2,'not done'),(5,'University Fees',165000,'2024-03-15 00:00:00',0,'2023-11-29 21:14:11','2023-11-29 21:14:11',2,'not done'),(6,'Transport Fees',30000,'2024-05-01 00:00:00',0,'2023-11-29 21:25:02','2023-11-29 21:25:02',2,'not done'),(8,'Books',5500,'2023-12-23 00:00:00',0,'2023-12-05 05:15:26','2023-12-06 17:18:26',2,'Done'),(9,'Jacket',6000,'2023-12-15 00:00:00',0,'2023-12-06 16:48:55','2023-12-06 16:48:55',2,'Done'),(10,'Novel',1000,'2023-12-07 00:00:00',0,'2023-12-06 17:19:01','2023-12-06 17:19:01',2,'Done'),(11,'Novels',1600,'2023-12-07 01:50:36',0,'2023-12-07 01:50:36','2023-12-07 01:50:36',2,'Not done');

/*Table structure for table `income` */

DROP TABLE IF EXISTS `income`;

CREATE TABLE `income` (
  `Income_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Description` varchar(30) DEFAULT NULL,
  `Amount` int(11) unsigned NOT NULL,
  `Received_dt` datetime DEFAULT NULL,
  `Created_dt` datetime DEFAULT NULL,
  `Updated_dt` datetime DEFAULT NULL,
  `User_id` int(11) NOT NULL,
  `Category_Id` int(11) NOT NULL,
  PRIMARY KEY (`Income_id`),
  KEY `FK_income` (`User_id`),
  KEY `FK_2` (`Category_Id`),
  CONSTRAINT `FK_2` FOREIGN KEY (`Category_Id`) REFERENCES `category` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `FK_income` FOREIGN KEY (`User_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `check_amount_non_negative` CHECK (`Amount` >= 0)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `income` */

insert  into `income`(`Income_id`,`Description`,`Amount`,`Received_dt`,`Created_dt`,`Updated_dt`,`User_id`,`Category_Id`) values (8,'weekly',2500,'2023-12-02 00:00:00','2023-12-06 23:35:51','2023-12-06 23:35:51',2,4);

/*Table structure for table `reminder` */

DROP TABLE IF EXISTS `reminder`;

CREATE TABLE `reminder` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Description` varchar(30) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Created_dt` datetime DEFAULT NULL,
  `Updated_dt` datetime DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_reminder` (`User_id`),
  CONSTRAINT `FK_reminder` FOREIGN KEY (`User_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `reminder` */

insert  into `reminder`(`Id`,`Description`,`Date`,`Created_dt`,`Updated_dt`,`User_id`) values (2,'Gas Bill','2023-12-21 00:00:00','2023-12-06 19:20:41','2023-12-06 19:29:07',2),(3,'School fee','2024-01-01 00:00:00','2023-12-06 14:41:00','2023-12-06 19:42:32',2),(4,'Electricity Bill','2023-12-22 00:00:00','2023-12-06 14:42:15','2023-12-06 14:42:15',2);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(30) DEFAULT NULL,
  `Password` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreateDt` datetime DEFAULT NULL,
  `Balance` int(11) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `unique_email` (`Email`),
  UNIQUE KEY `unique_username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`Id`,`Username`,`Password`,`Email`,`Status`,`CreateDt`,`Balance`) values (1,'hassan','f04e1fd4cbfeecfdce8a','hassanmasood@gmail.com','Active','2023-10-21 14:13:05',0),(2,'sania','$2y$10$llI3.xnHKae7','sania@gmail.com','Active','2023-10-23 23:05:26',2200),(3,'aheed','amnshwgbd','aheedtahir@gmail.com','Active','2023-10-24 21:04:50',0),(4,'owais','ednuecf','owais@gmail.com','Active','2023-10-24 21:07:24',0),(5,'usman','akjsuwdn','usamn@gmail.com','Active','2023-10-24 21:07:40',0),(8,'ayesha','eyubfhefg','ayeshaowais@gmail.com','Active','2023-11-12 17:33:56',0),(11,'ayaz','$2y$10$HjTGsOoCH7Wxy','ayaz@gmail.com',NULL,NULL,0),(13,'zara','$2y$10$vtfMG4lP2uSnv','zarahasan@gmail.com',NULL,NULL,0),(17,'maaz','$2y$10$Lr6VHhswfd10g','maaz@gmail.com',NULL,NULL,0),(18,'maazmaria','$2y$10$freI2jmtfa01B','maazmaria@gmail.com',NULL,NULL,0),(19,'fatima','$2y$10$80EOnBALgjbjQ','fatima@gmail.com',NULL,NULL,0),(20,'afzal','$2y$10$300SPXVPbVcAY','afzal@yahoo.com',NULL,NULL,0),(21,'aina','$2y$10$cN398psix.Duy','aina@gmail.com',NULL,NULL,0);

/* Trigger structure for table `expense` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `check_expense_amount` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `check_expense_amount` BEFORE INSERT ON `expense` FOR EACH ROW BEGIN
    DECLARE user_balance DECIMAL(10, 2);

    -- Get the current balance of the user
    SELECT Balance INTO user_balance
    FROM users
    WHERE Id = NEW.User_id;

    -- Check if the expense amount is greater than the user's balance
    IF NEW.Amount > user_balance THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Expense amount cannot exceed user balance';
    END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `expense` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_balance_after_expense_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `update_balance_after_expense_insert` AFTER INSERT ON `expense` FOR EACH ROW BEGIN
    UPDATE users
    SET Balance = Balance - NEW.Amount
    WHERE Id = NEW.User_id;
END */$$


DELIMITER ;

/* Trigger structure for table `income` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_balance_after_income_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `update_balance_after_income_insert` AFTER INSERT ON `income` FOR EACH ROW BEGIN
    UPDATE users
    SET Balance = Balance + NEW.Amount
    WHERE Id = NEW.User_id;
END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
