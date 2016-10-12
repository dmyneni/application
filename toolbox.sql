-- MySQL dump 10.16  Distrib 10.1.13-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: toolbox
-- ------------------------------------------------------
-- Server version	10.1.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions` (
  `action_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(120) DEFAULT NULL,
  `equality` varchar(6) DEFAULT NULL,
  `fontcolor` varchar(16) DEFAULT NULL,
  `bgcolor` varchar(16) DEFAULT NULL,
  `shortdesc` varchar(400) DEFAULT NULL,
  `lookup_name` varchar(60) DEFAULT NULL,
  `cell_row_flag` varchar(10) DEFAULT NULL,
  `comparison_type` varchar(10) DEFAULT NULL,
  `label` varchar(20) DEFAULT NULL,
  `class` varchar(20) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `priority` smallint(6) DEFAULT NULL,
  `link_id` int(11) DEFAULT NULL,
  `button` int(11) DEFAULT NULL,
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions`
--

LOCK TABLES `actions` WRITE;
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` VALUES (15,'0','gt',NULL,NULL,NULL,NULL,NULL,'numeric',NULL,NULL,'a',10,13,NULL);
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit`
--

DROP TABLE IF EXISTS `audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `uri` varchar(128) DEFAULT NULL,
  `errmsg` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`audit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit`
--

LOCK TABLES `audit` WRITE;
/*!40000 ALTER TABLE `audit` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `column_actions`
--

DROP TABLE IF EXISTS `column_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `column_actions` (
  `action_id` int(11) DEFAULT NULL,
  `column_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `column_actions`
--

LOCK TABLES `column_actions` WRITE;
/*!40000 ALTER TABLE `column_actions` DISABLE KEYS */;
INSERT INTO `column_actions` VALUES (15,530);
/*!40000 ALTER TABLE `column_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_account_roles`
--

DROP TABLE IF EXISTS `db_account_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_account_roles` (
  `account_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` varchar(8) NOT NULL,
  `approved` timestamp NULL DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`account_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_account_roles`
--

LOCK TABLES `db_account_roles` WRITE;
/*!40000 ALTER TABLE `db_account_roles` DISABLE KEYS */;
INSERT INTO `db_account_roles` VALUES (12,3,'active','2016-08-11 15:37:05',1),(13,3,'active','2016-08-14 20:27:02',1);
/*!40000 ALTER TABLE `db_account_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_accounts`
--

DROP TABLE IF EXISTS `db_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `db_id` int(11) NOT NULL,
  `account` varchar(30) NOT NULL,
  `short_desc` varchar(80) DEFAULT NULL,
  `status` varchar(8) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved` timestamp NULL DEFAULT NULL,
  `default_menu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `db_account_u1` (`db_id`,`account`),
  UNIQUE KEY `db_accounts_u1` (`db_id`,`account`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_accounts`
--

LOCK TABLES `db_accounts` WRITE;
/*!40000 ALTER TABLE `db_accounts` DISABLE KEYS */;
INSERT INTO `db_accounts` VALUES (12,11,'monitoring_readonly','test this','ACTIVE',1,'2016-10-07 22:58:38',NULL,NULL,NULL,NULL,5),(13,12,'tools','OpsStars repository and security','ACTIVE',1,'2016-08-29 04:05:58',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `db_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_details`
--

DROP TABLE IF EXISTS `db_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_details` (
  `db_id` int(11) NOT NULL AUTO_INCREMENT,
  `db_name` varchar(16) NOT NULL,
  `db_type` varchar(12) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `db_class` varchar(6) DEFAULT NULL,
  `hostname` varchar(30) DEFAULT NULL,
  `tns` varchar(1200) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved` timestamp NULL DEFAULT NULL,
  `db_role` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`db_id`),
  UNIQUE KEY `db_details_u1` (`db_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_details`
--

LOCK TABLES `db_details` WRITE;
/*!40000 ALTER TABLE `db_details` DISABLE KEYS */;
INSERT INTO `db_details` VALUES (11,'pdbdev1','oracle',NULL,'dev',NULL,'(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1522)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = pdbdev1.attlocal.net)))',1,'0000-00-00 00:00:00',NULL,NULL,NULL,NULL,NULL),(12,'toolbox','mysql',NULL,'dev','localhost',NULL,1,'0000-00-00 00:00:00',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `db_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `default_account`
--

DROP TABLE IF EXISTS `default_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `default_account` (
  `account_id` int(11) NOT NULL,
  `db_id` int(11) NOT NULL,
  UNIQUE KEY `default_account_u1` (`db_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `default_account`
--

LOCK TABLES `default_account` WRITE;
/*!40000 ALTER TABLE `default_account` DISABLE KEYS */;
INSERT INTO `default_account` VALUES (1,1);
/*!40000 ALTER TABLE `default_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `error_log`
--

DROP TABLE IF EXISTS `error_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error_log` (
  `script` varchar(120) DEFAULT NULL,
  `error` varchar(2000) DEFAULT NULL,
  `error_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `error_log`
--

LOCK TABLES `error_log` WRITE;
/*!40000 ALTER TABLE `error_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `error_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `key_pairs`
--

DROP TABLE IF EXISTS `key_pairs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `key_pairs` (
  `name` varchar(30) DEFAULT NULL,
  `type` varchar(12) DEFAULT NULL,
  `parameter` varchar(30) DEFAULT NULL,
  `literal_value` varchar(60) DEFAULT NULL,
  `description` varchar(60) DEFAULT NULL,
  `key_id` int(11) NOT NULL AUTO_INCREMENT,
  `column_name` varchar(30) DEFAULT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `key_pairs`
--

LOCK TABLES `key_pairs` WRITE;
/*!40000 ALTER TABLE `key_pairs` DISABLE KEYS */;
INSERT INTO `key_pairs` VALUES (NULL,'column',NULL,NULL,NULL,1,'node',2),(NULL,'column',NULL,NULL,NULL,2,'snap_id',1);
/*!40000 ALTER TABLE `key_pairs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link_keys`
--

DROP TABLE IF EXISTS `link_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link_keys` (
  `link_id` int(11) DEFAULT NULL,
  `key_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link_keys`
--

LOCK TABLES `link_keys` WRITE;
/*!40000 ALTER TABLE `link_keys` DISABLE KEYS */;
INSERT INTO `link_keys` VALUES (13,1),(13,2);
/*!40000 ALTER TABLE `link_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(30) DEFAULT NULL,
  `linkstr` varchar(30) DEFAULT NULL,
  `link_type` varchar(12) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `links`
--

LOCK TABLES `links` WRITE;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
INSERT INTO `links` VALUES (2,'AWR High I/O','scripts','query',99),(3,'News','news','system',NULL),(4,'Manage Queries','managequery','system',NULL),(5,'Manage Users','users','system',NULL),(6,'DB Connections','createdatabase','system',NULL),(7,'Manage Roles','roles','system',NULL),(13,'Top SQL For An AWR Snapshot','scripts','query',140),(19,'Busiest AWR Snapshots','scripts','query',121),(20,'Database Uptime','scripts','query',61),(22,'Logout','logout','system',NULL),(23,'Add a Query','createquery','system',NULL);
/*!40000 ALTER TABLE `links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lockbox`
--

DROP TABLE IF EXISTS `lockbox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lockbox` (
  `account_id` int(11) NOT NULL,
  `encrypted_pwd` varchar(256) DEFAULT NULL,
  `status` varchar(8) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `lockbox_u1` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lockbox`
--

LOCK TABLES `lockbox` WRITE;
/*!40000 ALTER TABLE `lockbox` DISABLE KEYS */;
INSERT INTO `lockbox` VALUES (11,'test db','ACTIVE','0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,'opsstars123','ACTIVE','2016-08-29 04:00:57','0000-00-00 00:00:00'),(13,'Tools1234567890!','ACTIVE','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `lockbox` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lookups`
--

DROP TABLE IF EXISTS `lookups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lookups` (
  `lookup_type` varchar(30) NOT NULL,
  `value` varchar(60) NOT NULL,
  PRIMARY KEY (`lookup_type`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lookups`
--

LOCK TABLES `lookups` WRITE;
/*!40000 ALTER TABLE `lookups` DISABLE KEYS */;
INSERT INTO `lookups` VALUES ('db_class','DEV'),('db_class','PERF'),('db_class','PROD'),('db_class','TEST'),('db_type','MYSQL'),('db_type','ORACLE');
/*!40000 ALTER TABLE `lookups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_roles`
--

DROP TABLE IF EXISTS `menu_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_roles` (
  `menu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` varchar(8) NOT NULL,
  `approved` timestamp NULL DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_roles`
--

LOCK TABLES `menu_roles` WRITE;
/*!40000 ALTER TABLE `menu_roles` DISABLE KEYS */;
INSERT INTO `menu_roles` VALUES (2,3,'active','2016-07-22 22:25:20',13),(8,2,'active','2016-07-22 22:26:03',13),(1,1,'active','2016-07-25 23:25:22',13),(5,4,'active','2016-07-27 15:21:27',13),(11,4,'active',NULL,NULL);
/*!40000 ALTER TABLE `menu_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus2`
--

DROP TABLE IF EXISTS `menus2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus2` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(12) NOT NULL,
  `parent_menu_id` int(11) DEFAULT NULL,
  `text` varchar(30) NOT NULL,
  `priority` int(11) NOT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `class` varchar(10) NOT NULL,
  `description` varchar(120) DEFAULT NULL,
  `link_id` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus2`
--

LOCK TABLES `menus2` WRITE;
/*!40000 ALTER TABLE `menus2` DISABLE KEYS */;
INSERT INTO `menus2` VALUES (1,'menu',NULL,'Home',5,'fa-home','system',NULL,NULL,1),(2,'menu',NULL,'Contributor (OpsStars)',10,'fa-puzzle-piece','system',NULL,NULL,1),(3,'menu',NULL,'Dashboard',15,'fa-dashboard','oracle',NULL,NULL,1),(4,'menu',NULL,'Past Performance',25,'fa-history','oracle',NULL,NULL,1),(5,'menu',NULL,'Compliance Check',30,'fa-book','oracle',NULL,NULL,1),(6,'menu',NULL,'Admin (OpsStars)',7,'fa-user','system',NULL,NULL,1),(7,'menu',NULL,'Health Check',55,'fa-check-circle-o','oracle',NULL,NULL,1),(8,'item',1,'News',1,NULL,'system','Show hot-issues from the team ',3,2),(9,'item',2,'Manage Queries',1,NULL,'system','Add new queries',4,2),(10,'item',6,'Manage Users',1,NULL,'system','Add or edit a new user',5,2),(11,'item',2,'DB Connections',1,NULL,'system','Add or edit target database ac',6,2),(12,'item',6,'Manage Roles',1,NULL,'system','View roles privileges and user',7,2),(13,'item',4,'Busiest AWR Snapshots',15,NULL,'oracle',NULL,2,2),(15,'item',1,'Logout',20,NULL,'system',NULL,22,2),(16,'item',2,'Add a Query',3,NULL,'system','Contributors can add new queries',23,2);
/*!40000 ALTER TABLE `menus2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `news_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `headline` varchar(60) DEFAULT NULL,
  `category` varchar(12) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `details` longtext,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `status` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`news_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queries`
--

DROP TABLE IF EXISTS `queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queries` (
  `query_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text,
  `query_title` varchar(60) DEFAULT NULL,
  `description` text,
  `version` varchar(12) DEFAULT NULL,
  `status` varchar(8) DEFAULT NULL,
  `format` varchar(6) DEFAULT NULL,
  `script` varchar(30) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `order_by` varchar(60) DEFAULT NULL,
  `query_type` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`query_id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queries`
--

LOCK TABLES `queries` WRITE;
/*!40000 ALTER TABLE `queries` DISABLE KEYS */;
INSERT INTO `queries` VALUES (61,'select inst_id node,to_char(startup_time,\'dd-Mon-yyyy hh24:mi\') startup_time, trunc(sysdate-startup_time,2) days,status from gv$instance order by 1','Database Uptime','test uptime','1','active','table',NULL,'2016-09-09 03:51:47',13,NULL,'mysql'),(63,'select count(*) tables, owner from dba_tables group by owner order by owner','Table Count by Owner','tables','1','active','table',NULL,'2016-09-09 03:51:47',13,NULL,'oracle'),(82,'select query_id, query_title,description,username,q.created from queries as q\r\nleft join users as u on q.created_by=u.user_id and query_type=\'mysql\'','Queries for MySQL Databases','All queries created by the contributor-user or that have been granted through a role.','1','active','table',NULL,'2016-09-09 03:51:47',13,NULL,'system'),(89,'select count(*) tables, owner from dba_tables group by owner order by owner','Table Count by Owner','tables','1','active','table',NULL,'2016-09-09 03:51:47',0,NULL,NULL),(99,'select a.snap_id,b.instance_number node,to_char(min(begin_interval_time),\'dd-Mon-yyyy hh24:mi\') start_time,\nto_char(min(end_interval_time-begin_interval_time),\'hh:mi:ss\') duration,\ntrunc(sum(buffer_gets_delta/greatest(executions_delta,1))) \"avg gets\",\ntrunc(sum(disk_reads_delta/greatest(executions_delta,1))) \"avg reads\",\ntrunc(sum(clwait_delta/greatest(executions_delta,1))) \"avg cl wait\",\ntrunc(sum(ccwait_delta/greatest(executions_delta,1))) \"avg cc wait\"\nfrom dba_hist_sqlstat a, dba_hist_snapshot b\nwhere a.snap_id=b.snap_id\nand a.instance_number=b.instance_number\nand begin_interval_time>sysdate-1\ngroup by a.snap_id,b.instance_number\norder by a.snap_id,b.instance_number','Busiest AWR Snapshots','AWR snapshots with high activity','1','active','table',NULL,'2016-09-09 03:51:47',0,NULL,'oracle'),(116,'select instance_number,sql_id,\r\nexecutions_delta executions, \r\ntrunc(buffer_gets_delta/greatest(executions_delta,1)) gets, \r\ntrunc(disk_reads_delta/greatest(executions_delta,1) )reads,\r\ntrunc(clwait_delta/greatest(executions_delta,1),2) avg_cl_wait,\r\ntrunc(ccwait_delta/greatest(executions_delta,1),2) avg_cc_wait \r\nfrom dba_hist_sqlstat where snap_id=:snap_id \r\nand instance_number=:instance_number \r\norder by 4 desc','Top SQL For An AWR Snapshot','This is a drill-down report that will show the SQL with the highest I/O avg per execution for a particular snapshot period.','1','active','table',NULL,'2016-09-12 14:56:59',0,NULL,'oracle'),(122,'select parsing_schema_name, substr(sql_text,1,200) partial_sql, plan_hash_value, optimizer_cost cost, fetches_delta fetches, sorts_delta sorts,elapsed_time_delta/1000000 seconds, sharable_mem mem from dba_hist_sqlstat a, dba_hist_sqltext b where a.sql_id=b.sql_id and a.snap_id=:snap_id and a.instance_number=:instance_number and a.sql_id=:sql_id','Past SQL Details','Drill-down query showing the SQL statement details','1','active','row',NULL,'2016-09-09 03:52:46',0,NULL,'oracle'),(129,'select  menu_id,menu_name,menu_type,\r\ndescription,status,default_menu_item \r\nfrom menus \r\nwhere created_by=:user_id  \r\norder by menu_type,menu_name','My Menus','Administration screen to allow a user do self service the menus they have created','1','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'mysql'),(136,'select sid, \r\na.inst_id,\r\nusername, \r\ntrunc(buffer_gets/greatest(executions,1)) buffer_gets, \r\ntrunc(disk_reads/greatest(executions,1)) disk_reads, \r\nsubstr(sql_text,1,60) partial_sql, \r\nblocking_session,\r\nblocking_instance, \r\nevent,seconds_in_wait \r\nfrom gv$session a, \r\ngv$sqlarea b\r\nwhere a.status=\'ACTIVE\' \r\nand a.inst_id=b.inst_id\r\nand a.sql_id=b.sql_id\r\nand a.username is not null\r\norder by buffer_gets desc','Currently Running','The current top activity based on buffer_gets.  The first few sessions are doing the most I/O and may be tuning opportunities.  Only tune queries that get executed frequently.  One time bad performance, contact the user to see if it can be killed or they can tune the query.  \r\nYou may want to sort on disk_reads because they have a greater impact on elapsed time.  \r\nI/O is the normal work of the database, so other wait events should be investigated, if they show up frequently.','1','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'oracle'),(140,'select instance_number,sql_id,\r\nexecutions_delta executions, \r\ntrunc(buffer_gets_delta/greatest(executions_delta,1)) gets, \r\ntrunc(disk_reads_delta/greatest(executions_delta,1) )reads,\r\ntrunc(clwait_delta/greatest(executions_delta,1),2) avg_cl_wait,\r\ntrunc(ccwait_delta/greatest(executions_delta,1),2) avg_cc_wait \r\nfrom dba_hist_sqlstat where snap_id=:snap_id \r\nand instance_number=:instance_number \r\norder by 4 desc','Top SQL For An AWR Snapshot','This is a drill-down report that will show the SQL with the highest I/O avg per execution for a particular snapshot period.','1.1','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'oracle'),(149,'select :name name , :company company from dual where :name = :name and :company in (select :company from dual where :company = :company )','test this','testing multiple binds used multiple times.','1','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'oracle'),(150,'select :name name , :company company from dual where :name = :name and :company in (select :company from dual where :company = :company )','test this','testing multiple binds used multiple times.','1','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'oracle'),(151,'select :name name , :company company from dual where :name = :name and :company in (select :company from dual where :company = :company )','test this','testing multiple binds used multiple times.','1.1','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'oracle'),(152,'select :name name , :company company from dual where :name = :name and :company in (select :company from dual where :company = :company )','test this','testing multiple binds used multiple times.','1.2','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'oracle'),(153,'select parsing_schema_name, substr(sql_text,1,200) partial_sql, plan_hash_value, optimizer_cost cost, fetches_delta fetches, sorts_delta sorts,elapsed_time_delta/1000000 seconds, sharable_mem mem from dba_hist_sqlstat a, dba_hist_sqltext b where a.sql_id=b.sql_id and a.snap_id=:snap_id and a.instance_number=:instance_number and a.sql_id=:sql_id','Past SQL Details','Drill-down query showing the SQL statement details','1.1','active','row',NULL,'2016-09-24 20:19:01',0,NULL,'oracle'),(154,'WITH \r\n    t1 AS (SELECT hsecs FROM v$timer),\r\n    samples AS (\r\n    SELECT /*+ ORDERED NO_MERGE USE_NL(sw.gv$session_wait.s) */\r\n        s.sid sw_sid,\r\n        CASE WHEN sw.state = \'WAITING\' THEN \'WAITING\' ELSE \'WORKING\' END AS state,\r\n        CASE WHEN sw.state = \'WAITING\' THEN event ELSE \'On CPU / runqueue\' END AS sw_event,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%1%\' THEN sw.p1text || \'= \' || CASE WHEN (LOWER(sw.p1text) LIKE \'%addr%\' OR sw.p1 >= 536870912) THEN RAWTOHEX(sw.p1raw) ELSE TO_CHAR(sw.p1) END ELSE NULL END swp_p1,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%2%\' THEN sw.p2text || \'= \' || CASE WHEN (LOWER(sw.p2text) LIKE \'%addr%\' OR sw.p2 >= 536870912) THEN RAWTOHEX(sw.p2raw) ELSE TO_CHAR(sw.p2) END ELSE NULL END swp_p2,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%3%\' THEN sw.p3text || \'= \' || CASE WHEN (LOWER(sw.p3text) LIKE \'%addr%\' OR sw.p3 >= 536870912) THEN RAWTOHEX(sw.p3raw) ELSE TO_CHAR(sw.p3) END ELSE NULL END swp_p3,\r\n        CASE WHEN LOWER(:group_by_list ) LIKE \'%s%\' THEN sw.seq# ELSE NULL END seq#,\r\n        COUNT(*) total_samples,\r\n        COUNT(DISTINCT seq#) dist_events,\r\n        TRUNC(COUNT(*)/COUNT(DISTINCT seq#)) average_samples\r\n    FROM\r\n        (	SELECT /*+ NO_MERGE */ TO_NUMBER(:session_id ) sid FROM \r\n        		(SELECT rownum r FROM dual CONNECT BY ROWNUM <= 1000) a,\r\n        		(SELECT rownum r FROM dual CONNECT BY ROWNUM <= 1000) b,\r\n        		(SELECT rownum r FROM dual CONNECT BY ROWNUM <= 1000) c\r\n	        WHERE ROWNUM <= :samples ) s,\r\n        v$session_wait sw\r\n    WHERE\r\n        s.sid = sw.sid\r\n    GROUP BY\r\n        s.sid,\r\n        CASE WHEN sw.state = \'WAITING\' THEN \'WAITING\' ELSE \'WORKING\' END,\r\n        CASE WHEN sw.state = \'WAITING\' THEN event ELSE \'On CPU / runqueue\' END,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%1%\' THEN sw.p1text || \'= \' || CASE WHEN (LOWER(sw.p1text) LIKE \'%addr%\' OR sw.p1 >= 536870912) THEN RAWTOHEX(sw.p1raw) ELSE TO_CHAR(sw.p1) END ELSE NULL END,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%2%\' THEN sw.p2text || \'= \' || CASE WHEN (LOWER(sw.p2text) LIKE \'%addr%\' OR sw.p2 >= 536870912) THEN RAWTOHEX(sw.p2raw) ELSE TO_CHAR(sw.p2) END ELSE NULL END,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%3%\' THEN sw.p3text || \'= \' || CASE WHEN (LOWER(sw.p3text) LIKE \'%addr%\' OR sw.p3 >= 536870912) THEN RAWTOHEX(sw.p3raw) ELSE TO_CHAR(sw.p3) END ELSE NULL END,\r\n        CASE WHEN LOWER(:group_by_list ) LIKE \'%s%\' THEN sw.seq# ELSE NULL END\r\n    ORDER BY\r\n        CASE WHEN LOWER(:group_by_list ) LIKE \'%s%\' THEN -seq# ELSE total_samples END DESC\r\n),\r\n    t2 AS (SELECT hsecs FROM v$timer)\r\nSELECT /*+ ORDERED */\r\n    s.sw_sid,\r\n    s.state,\r\n    s.sw_event,\r\n    s.swp_p1,\r\n    s.swp_p2,\r\n    s.swp_p3,\r\n    s.seq# swp_seq#,\r\n    s.total_samples / :samples * 100 pct_total_samples,\r\n    (t2.hsecs - t1.hsecs) * 10 * s.total_samples / :samples  waitprof_total_ms,\r\n    s.dist_events,\r\n    (t2.hsecs - t1.hsecs) * 10 * s.total_samples / dist_events / :samples waitprof_avg_ms\r\nFROM\r\n    t1,\r\n    samples s,\r\n    t2','Session Waits Profile','This is a complex query from the internet to prove the flexibility of OpsStars.\r\n\r\nThis query quickly samples the wait events associated with a long running session.  This gives visibility to a possible \"hang\" condition.\r\n\r\nGroup-by: The information can be grouped by event, p1,p2,p3 values.  The parameter meaning depends on the event type.\r\nSession ID: Provide a session ID that is long running.  This query will likely be used a drill-down query that passes in this session_id from a previous query.\r\nSamples: The number of times to sample determines how long and how thorough the wait profiling will be.  A sample of 100,000 will return quickly.','1','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'oracle'),(155,'WITH \r\n    t1 AS (SELECT hsecs FROM v$timer),\r\n    samples AS (\r\n    SELECT /*+ ORDERED NO_MERGE USE_NL(sw.gv$session_wait.s) */\r\n        s.sid sw_sid,\r\n        CASE WHEN sw.state = \'WAITING\' THEN \'WAITING\' ELSE \'WORKING\' END AS state,\r\n        CASE WHEN sw.state = \'WAITING\' THEN event ELSE \'On CPU / runqueue\' END AS sw_event,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%1%\' THEN sw.p1text || \'= \' || CASE WHEN (LOWER(sw.p1text) LIKE \'%addr%\' OR sw.p1 >= 536870912) THEN RAWTOHEX(sw.p1raw) ELSE TO_CHAR(sw.p1) END ELSE NULL END swp_p1,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%2%\' THEN sw.p2text || \'= \' || CASE WHEN (LOWER(sw.p2text) LIKE \'%addr%\' OR sw.p2 >= 536870912) THEN RAWTOHEX(sw.p2raw) ELSE TO_CHAR(sw.p2) END ELSE NULL END swp_p2,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%3%\' THEN sw.p3text || \'= \' || CASE WHEN (LOWER(sw.p3text) LIKE \'%addr%\' OR sw.p3 >= 536870912) THEN RAWTOHEX(sw.p3raw) ELSE TO_CHAR(sw.p3) END ELSE NULL END swp_p3,\r\n        CASE WHEN LOWER(:group_by_list ) LIKE \'%s%\' THEN sw.seq# ELSE NULL END seq#,\r\n        COUNT(*) total_samples,\r\n        COUNT(DISTINCT seq#) dist_events,\r\n        TRUNC(COUNT(*)/COUNT(DISTINCT seq#)) average_samples\r\n    FROM\r\n        (	SELECT /*+ NO_MERGE */ TO_NUMBER(:session_id ) sid FROM \r\n        		(SELECT rownum r FROM dual CONNECT BY ROWNUM <= 1000) a,\r\n        		(SELECT rownum r FROM dual CONNECT BY ROWNUM <= 1000) b,\r\n        		(SELECT rownum r FROM dual CONNECT BY ROWNUM <= 1000) c\r\n	        WHERE ROWNUM <= :samples ) s,\r\n        v$session_wait sw\r\n    WHERE\r\n        s.sid = sw.sid\r\n    GROUP BY\r\n        s.sid,\r\n        CASE WHEN sw.state = \'WAITING\' THEN \'WAITING\' ELSE \'WORKING\' END,\r\n        CASE WHEN sw.state = \'WAITING\' THEN event ELSE \'On CPU / runqueue\' END,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%1%\' THEN sw.p1text || \'= \' || CASE WHEN (LOWER(sw.p1text) LIKE \'%addr%\' OR sw.p1 >= 536870912) THEN RAWTOHEX(sw.p1raw) ELSE TO_CHAR(sw.p1) END ELSE NULL END,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%2%\' THEN sw.p2text || \'= \' || CASE WHEN (LOWER(sw.p2text) LIKE \'%addr%\' OR sw.p2 >= 536870912) THEN RAWTOHEX(sw.p2raw) ELSE TO_CHAR(sw.p2) END ELSE NULL END,\r\n        CASE WHEN sw.state = \'WAITING\' AND :group_by_list LIKE \'%3%\' THEN sw.p3text || \'= \' || CASE WHEN (LOWER(sw.p3text) LIKE \'%addr%\' OR sw.p3 >= 536870912) THEN RAWTOHEX(sw.p3raw) ELSE TO_CHAR(sw.p3) END ELSE NULL END,\r\n        CASE WHEN LOWER(:group_by_list ) LIKE \'%s%\' THEN sw.seq# ELSE NULL END\r\n    ORDER BY\r\n        CASE WHEN LOWER(:group_by_list ) LIKE \'%s%\' THEN -seq# ELSE total_samples END DESC\r\n),\r\n    t2 AS (SELECT hsecs FROM v$timer)\r\nSELECT /*+ ORDERED */\r\n    s.sw_sid,\r\n    s.state,\r\n    s.sw_event,\r\n    s.swp_p1,\r\n    s.swp_p2,\r\n    s.swp_p3,\r\n    s.seq# swp_seq#,\r\n    s.total_samples / :samples * 100 pct_total_samples,\r\n    (t2.hsecs - t1.hsecs) * 10 * s.total_samples / :samples  waitprof_total_ms,\r\n    s.dist_events,\r\n    (t2.hsecs - t1.hsecs) * 10 * s.total_samples / dist_events / :samples waitprof_avg_ms\r\nFROM\r\n    t1,\r\n    samples s,\r\n    t2','Session Waits Profile','This is a complex query from the internet to prove the flexibility of OpsStars.\r\n\r\nThis query quickly samples the wait events associated with a long running session.  This gives visibility to a possible \"hang\" condition.\r\n\r\nGroup-by: The information can be grouped by event, p1,p2,p3 values.  The parameter meaning depends on the event type.\r\nSession ID: Provide a session ID that is long running.  This query will likely be used a drill-down query that passes in this session_id from a previous query.\r\nSamples: The number of times to sample determines how long and how thorough the wait profiling will be.  A sample of 100,000 will return quickly.\r\n\r\nYou can find more information on this query at:\r\nhttp://blog.tanelpoder.com/2008/06/06/advanced-oracle-troubleshooting-guide-part-5-sampling-v-stuff-with-waitprof-really-fast-using-sql/\r\n','1.1','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'oracle'),(156,'select a.snap_id,b.instance_number node,to_char(min(begin_interval_time),\'dd-Mon-yyyy hh24:mi\') start_time,\r\nto_char(min(end_interval_time-begin_interval_time),\'hh:mi:ss\') duration,\r\ntrunc(sum(buffer_gets_delta/greatest(executions_delta,1))) \"avg gets\",\r\ntrunc(sum(disk_reads_delta/greatest(executions_delta,1))) \"avg reads\",\r\ntrunc(sum(clwait_delta/greatest(executions_delta,1))) \"avg cl wait\",\r\ntrunc(sum(ccwait_delta/greatest(executions_delta,1))) \"avg cc wait\"\r\nfrom dba_hist_sqlstat a, dba_hist_snapshot b\r\nwhere a.snap_id=b.snap_id\r\nand a.instance_number=b.instance_number\r\nand begin_interval_time>sysdate-1\r\ngroup by a.snap_id,b.instance_number\r\norder by a.snap_id,b.instance_number','Busiest AWR Snapshots','AWR snapshots with high activity','11.2','active',NULL,NULL,'0000-00-00 00:00:00',0,NULL,'oracle');
/*!40000 ALTER TABLE `queries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `query_binds`
--

DROP TABLE IF EXISTS `query_binds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `query_binds` (
  `query_id` int(11) NOT NULL,
  `bind_name` varchar(30) NOT NULL,
  `alias` varchar(40) DEFAULT NULL,
  `bind_id` int(11) NOT NULL AUTO_INCREMENT,
  `positions` varchar(60) NOT NULL,
  `bind_order` int(11) NOT NULL,
  `bind_type` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`bind_id`),
  UNIQUE KEY `pk_query_binds` (`query_id`,`bind_name`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `query_binds`
--

LOCK TABLES `query_binds` WRITE;
/*!40000 ALTER TABLE `query_binds` DISABLE KEYS */;
INSERT INTO `query_binds` VALUES (140,'snap_id','',1,'0',1,'number'),(140,'instance_number','',2,'1',2,'number'),(145,'me','',3,'0,1,2',1,'string'),(146,'me','',4,'0,1,2',1,'string'),(147,'me','',5,'0,1,2',1,'string'),(148,'me','',6,'0,1,2',1,'string'),(149,'name','',7,'0,2,3',1,'string'),(149,'company','',8,'1,4,5,6,7',2,'string'),(150,'name','',9,'0,2,3',1,'string'),(150,'company','',10,'1,4,5,6,7',2,'string'),(151,'name','What do they call you?',11,'0,2,3',1,'string'),(151,'company','What is your company name?',12,'1,4,5,6,7',2,'string'),(152,'name','What do they call you?',13,'0,2,3',1,'string'),(152,'company','What is your company name?',14,'1,4,5,6,7',2,'string'),(153,'snap_id','',15,'0',1,'number'),(153,'instance_number','',16,'1',2,'number'),(153,'sql_id','',17,'2',3,'string'),(154,'group_by_list','group by event, p1, p2, p3 (ex e123)',18,'0,1,2,3,6,7,8,9,10',1,'string'),(154,'session_id','Session ID',19,'4',2,'number'),(154,'samples','How many times to sample',20,'5,11,12,13',3,'number'),(155,'group_by_list','group by event, p1, p2, p3 (ex e123)',21,'0,1,2,3,6,7,8,9,10',1,'string'),(155,'session_id','Session ID',22,'4',2,'number'),(155,'samples','How many times to sample',23,'5,11,12,13',3,'number');
/*!40000 ALTER TABLE `query_binds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `query_chart_columns`
--

DROP TABLE IF EXISTS `query_chart_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `query_chart_columns` (
  `query_chart_id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL,
  `column_color` varchar(16) DEFAULT NULL,
  `column_label` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `query_chart_columns`
--

LOCK TABLES `query_chart_columns` WRITE;
/*!40000 ALTER TABLE `query_chart_columns` DISABLE KEYS */;
/*!40000 ALTER TABLE `query_chart_columns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `query_charts`
--

DROP TABLE IF EXISTS `query_charts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `query_charts` (
  `query_chart_id` int(11) NOT NULL AUTO_INCREMENT,
  `query_id` int(11) NOT NULL,
  `chart_type` varchar(30) NOT NULL,
  `chart_size` int(11) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `labels_column` int(11) DEFAULT NULL,
  `labels_color` varchar(16) DEFAULT NULL,
  `title_color` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`query_chart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `query_charts`
--

LOCK TABLES `query_charts` WRITE;
/*!40000 ALTER TABLE `query_charts` DISABLE KEYS */;
INSERT INTO `query_charts` VALUES (1,99,'line',4,'AWR Snapshots',1,NULL,NULL);
/*!40000 ALTER TABLE `query_charts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `query_columns`
--

DROP TABLE IF EXISTS `query_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `query_columns` (
  `column_id` int(11) NOT NULL AUTO_INCREMENT,
  `query_id` int(11) DEFAULT NULL,
  `column_name` varchar(30) NOT NULL,
  `status` varchar(8) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `sortable` varchar(5) NOT NULL DEFAULT 'true',
  `visible` varchar(5) NOT NULL DEFAULT 'true',
  `searchable` varchar(5) NOT NULL DEFAULT 'true',
  `chart_color` varchar(16) DEFAULT NULL,
  `datatype` varchar(12) NOT NULL,
  `max_length` int(11) DEFAULT NULL,
  `chart_label` varchar(16) DEFAULT NULL,
  `chart_labels_column` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`column_id`),
  UNIQUE KEY `query_column_u1` (`query_id`,`column_name`)
) ENGINE=InnoDB AUTO_INCREMENT=851 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `query_columns`
--

LOCK TABLES `query_columns` WRITE;
/*!40000 ALTER TABLE `query_columns` DISABLE KEYS */;
INSERT INTO `query_columns` VALUES (410,61,'NODE','active',1,'1','1','1',NULL,'',NULL,NULL,NULL),(411,61,'STARTUP_TIME','active',2,'1','1','1',NULL,'',NULL,NULL,NULL),(412,61,'DAYS','active',3,'1','1','1',NULL,'',NULL,NULL,NULL),(413,61,'STATUS','active',4,'1','1','1',NULL,'',NULL,NULL,NULL),(454,82,'query_id','active',1,'true','true','true',NULL,'',NULL,NULL,NULL),(455,82,'query_title','active',2,'true','true','true',NULL,'',NULL,NULL,NULL),(456,82,'description','active',3,'false','true','true',NULL,'',NULL,NULL,NULL),(457,82,'username','active',4,'true','true','true',NULL,'',NULL,NULL,NULL),(458,82,'created','active',5,'true','true','true',NULL,'',NULL,NULL,NULL),(465,89,'TABLES','active',1,'true','true','true',NULL,'',NULL,NULL,NULL),(466,89,'OWNER','active',2,'true','true','true',NULL,'',NULL,NULL,NULL),(530,99,'SNAP_ID','active',1,'true','true','true',NULL,'',NULL,NULL,NULL),(531,99,'START_TIME','active',3,'true','true','true',NULL,'',NULL,NULL,'true'),(532,99,'DURATION','active',4,'true','true','true',NULL,'',NULL,NULL,NULL),(533,99,'avg gets','active',5,'true','true','true','#0000ff','',NULL,'Gets',NULL),(534,99,'avg reads','active',6,'true','true','true','#00ffff','',NULL,'Reads',NULL),(535,99,'avg cl wait','active',7,'true','true','true','#000000','',NULL,'cluster',NULL),(536,99,'avg cc wait','active',8,'true','true','true','#ff0000','',NULL,'concurrency',NULL),(537,99,'node','active',2,'false','false','false',NULL,'',NULL,NULL,NULL),(650,116,'INSTANCE_NUMBER','active',1,'true','true','true',NULL,'',NULL,NULL,NULL),(651,116,'SQL_ID','active',2,'true','true','true',NULL,'',NULL,NULL,NULL),(652,116,'EXECUTIONS','active',3,'true','true','true',NULL,'',NULL,NULL,NULL),(653,116,'GETS','active',4,'true','true','true',NULL,'',NULL,NULL,NULL),(654,116,'READS','active',5,'true','true','true',NULL,'',NULL,NULL,NULL),(655,116,'AVG_CL_WAIT','active',6,'true','true','true',NULL,'',NULL,NULL,NULL),(656,116,'AVG_CC_WAIT','active',7,'true','true','true',NULL,'',NULL,NULL,NULL),(697,122,'PARSING_SCHEMA_NAME','active',1,'true','true','true',NULL,'',NULL,NULL,NULL),(698,122,'PARTIAL_SQL','active',2,'true','true','true',NULL,'',NULL,NULL,NULL),(699,122,'PLAN_HASH_VALUE','active',3,'true','true','true',NULL,'',NULL,NULL,NULL),(700,122,'COST','active',4,'true','true','true',NULL,'',NULL,NULL,NULL),(701,122,'FETCHES','active',5,'true','true','true',NULL,'',NULL,NULL,NULL),(702,122,'SORTS','active',6,'true','true','true',NULL,'',NULL,NULL,NULL),(703,122,'SECONDS','active',7,'true','true','true',NULL,'',NULL,NULL,NULL),(704,122,'MEM','active',8,'true','true','true',NULL,'',NULL,NULL,NULL),(717,129,'menu_id','active',1,'true','true','true',NULL,'3',2,NULL,NULL),(718,129,'menu_name','active',2,'true','true','true',NULL,'253',19,NULL,NULL),(719,129,'menu_type','active',3,'true','true','true',NULL,'253',6,NULL,NULL),(720,129,'description','active',4,'true','true','true',NULL,'253',35,NULL,NULL),(721,129,'status','active',5,'true','true','true',NULL,'253',6,NULL,NULL),(722,129,'default_menu_item','active',6,'true','true','true',NULL,'3',2,NULL,NULL),(759,136,'SID','active',1,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(760,136,'INST_ID','active',2,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(761,136,'USERNAME','active',3,'true','true','true',NULL,'VARCHAR2',30,NULL,NULL),(762,136,'BUFFER_GETS','active',4,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(763,136,'DISK_READS','active',5,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(764,136,'PARTIAL_SQL','active',6,'true','true','true',NULL,'VARCHAR2',60,NULL,NULL),(765,136,'BLOCKING_SESSION','active',7,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(766,136,'BLOCKING_INSTANCE','active',8,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(767,136,'EVENT','active',9,'true','true','true',NULL,'VARCHAR2',64,NULL,NULL),(768,136,'SECONDS_IN_WAIT','active',10,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(790,140,'INSTANCE_NUMBER','active',1,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(791,140,'SQL_ID','active',2,'true','true','true',NULL,'VARCHAR2',13,NULL,NULL),(792,140,'EXECUTIONS','active',3,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(793,140,'GETS','active',4,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(794,140,'READS','active',5,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(795,140,'AVG_CL_WAIT','active',6,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(796,140,'AVG_CC_WAIT','active',7,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(805,149,'NAME','active',1,'true','true','true',NULL,'CHAR',5,NULL,NULL),(806,149,'COMPANY','active',2,'true','true','true',NULL,'CHAR',8,NULL,NULL),(807,150,'NAME','active',1,'true','true','true',NULL,'CHAR',5,NULL,NULL),(808,150,'COMPANY','active',2,'true','true','true',NULL,'CHAR',8,NULL,NULL),(809,151,'NAME','active',1,'true','true','true',NULL,'CHAR',5,NULL,NULL),(810,151,'COMPANY','active',2,'true','true','true',NULL,'CHAR',8,NULL,NULL),(811,152,'NAME','active',1,'true','true','true',NULL,'CHAR',1,NULL,NULL),(812,152,'COMPANY','active',2,'true','true','true',NULL,'CHAR',1,NULL,NULL),(813,153,'PARSING_SCHEMA_NAME','active',1,'true','true','true',NULL,'VARCHAR2',128,NULL,NULL),(814,153,'PARTIAL_SQL','active',2,'true','true','true',NULL,'CLOB',4000,NULL,NULL),(815,153,'PLAN_HASH_VALUE','active',3,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(816,153,'COST','active',4,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(817,153,'FETCHES','active',5,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(818,153,'SORTS','active',6,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(819,153,'SECONDS','active',7,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(820,153,'MEM','active',8,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(821,154,'SW_SID','active',1,'true','true','true',NULL,'NUMBER',3,NULL,NULL),(822,154,'STATE','active',2,'true','true','true',NULL,'CHAR',7,NULL,NULL),(823,154,'SW_EVENT','active',3,'true','true','true',NULL,'VARCHAR2',64,NULL,NULL),(824,154,'SWP_P1','active',4,'true','true','true',NULL,'VARCHAR2',106,NULL,NULL),(825,154,'SWP_P2','active',5,'true','true','true',NULL,'VARCHAR2',106,NULL,NULL),(826,154,'SWP_P3','active',6,'true','true','true',NULL,'VARCHAR2',106,NULL,NULL),(827,154,'SWP_SEQ#','active',7,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(828,154,'PCT_TOTAL_SAMPLES','active',8,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(829,154,'WAITPROF_TOTAL_MS','active',9,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(830,154,'DIST_EVENTS','active',10,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(831,154,'WAITPROF_AVG_MS','active',11,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(832,155,'SW_SID','active',1,'true','true','true',NULL,'NUMBER',3,NULL,NULL),(833,155,'STATE','active',2,'true','true','true',NULL,'CHAR',7,NULL,NULL),(834,155,'SW_EVENT','active',3,'true','true','true',NULL,'VARCHAR2',64,NULL,NULL),(835,155,'SWP_P1','active',4,'true','true','true',NULL,'VARCHAR2',106,NULL,NULL),(836,155,'SWP_P2','active',5,'true','true','true',NULL,'VARCHAR2',106,NULL,NULL),(837,155,'SWP_P3','active',6,'true','true','true',NULL,'VARCHAR2',106,NULL,NULL),(838,155,'SWP_SEQ#','active',7,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(839,155,'PCT_TOTAL_SAMPLES','active',8,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(840,155,'WAITPROF_TOTAL_MS','active',9,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(841,155,'DIST_EVENTS','active',10,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(842,155,'WAITPROF_AVG_MS','active',11,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(843,156,'SNAP_ID','active',1,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(844,156,'NODE','active',2,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(845,156,'START_TIME','active',3,'true','true','true',NULL,'VARCHAR2',17,NULL,NULL),(846,156,'DURATION','active',4,'true','true','true',NULL,'VARCHAR2',24,NULL,NULL),(847,156,'avg gets','active',5,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(848,156,'avg reads','active',6,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(849,156,'avg cl wait','active',7,'true','true','true',NULL,'NUMBER',22,NULL,NULL),(850,156,'avg cc wait','active',8,'true','true','true',NULL,'NUMBER',22,NULL,NULL);
/*!40000 ALTER TABLE `query_columns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `query_performance`
--

DROP TABLE IF EXISTS `query_performance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `query_performance` (
  `query_id` int(11) NOT NULL,
  `log_ts` datetime DEFAULT NULL,
  `remote_addr` varchar(16) DEFAULT NULL,
  `refresh_time` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `query_performance`
--

LOCK TABLES `query_performance` WRITE;
/*!40000 ALTER TABLE `query_performance` DISABLE KEYS */;
/*!40000 ALTER TABLE `query_performance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `register` (
  `username` varchar(40) DEFAULT NULL,
  `status` varchar(12) DEFAULT NULL,
  `company` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `register`
--

LOCK TABLES `register` WRITE;
/*!40000 ALTER TABLE `register` DISABLE KEYS */;
/*!40000 ALTER TABLE `register` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_query`
--

DROP TABLE IF EXISTS `report_query`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_query` (
  `report_id` int(11) DEFAULT NULL,
  `query_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `align` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_query`
--

LOCK TABLES `report_query` WRITE;
/*!40000 ALTER TABLE `report_query` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_query` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_roles`
--

DROP TABLE IF EXISTS `report_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_roles` (
  `report_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` varchar(8) NOT NULL,
  `approved` timestamp NULL DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`report_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_roles`
--

LOCK TABLES `report_roles` WRITE;
/*!40000 ALTER TABLE `report_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_title` varchar(60) DEFAULT NULL,
  `report_name` varchar(30) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `promoted` timestamp NULL DEFAULT NULL,
  `promoted_by` int(11) DEFAULT NULL,
  `status` varchar(8) NOT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(30) NOT NULL,
  `short_desc` varchar(80) DEFAULT NULL,
  `status` varchar(8) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Active User','Default role','active',1,'2016-09-03 02:36:27',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(2,'Administrator','OpsStars tool administrator','active',1,'2016-09-03 02:36:27',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(3,'Contributor','Contributes new content to OpsStars','active',1,'2016-09-03 02:36:27',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(4,'DBA','Visibility to content of interest to a DBA','active',1,'2016-09-03 02:36:27',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(5,'Mfg Developer','Dev team for Acme manufacturing applications','approve',1,'2016-09-03 02:36:27',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_preferences`
--

DROP TABLE IF EXISTS `user_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_preferences` (
  `name` varchar(30) DEFAULT NULL,
  `value` varchar(12) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  UNIQUE KEY `user_preferences_u1` (`user_id`,`name`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_preferences`
--

LOCK TABLES `user_preferences` WRITE;
/*!40000 ALTER TABLE `user_preferences` DISABLE KEYS */;
INSERT INTO `user_preferences` VALUES ('account_id','12',13,NULL,NULL),('account_id','13',13,NULL,NULL),('default_account','12',13,NULL,NULL),('default_menu','5',13,12,NULL),('menu_id','1',13,NULL,NULL),('menu_id','10',13,NULL,NULL),('menu_id','2',13,NULL,NULL),('menu_id','3',13,NULL,NULL),('menu_id','5',13,NULL,NULL),('menu_id','6',13,NULL,NULL),('menu_id','7',13,NULL,NULL),('menu_id','8',13,NULL,NULL),('menu_id','9',13,NULL,NULL);
/*!40000 ALTER TABLE `user_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profiles` (
  `user_id` int(11) NOT NULL,
  `email_address` varchar(30) DEFAULT NULL,
  `text_number` varchar(30) DEFAULT NULL,
  `email_validated` varchar(3) DEFAULT NULL,
  `text_validated` varchar(3) DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `default_menu_id` int(11) DEFAULT NULL,
  `default_rpt_id` int(11) DEFAULT NULL,
  `img_id` int(11) DEFAULT NULL,
  `default_account_id` int(11) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `default_query_id` int(11) DEFAULT NULL,
  `default_bind_values` varchar(120) DEFAULT NULL,
  `default_menu_item_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES (1,'admin@mydomain.com',NULL,NULL,NULL,NULL,1,1,NULL,1,'0000-00-00 00:00:00',NULL,NULL,NULL,NULL),(17,'danknx@gmail.com',NULL,NULL,'','(512) 671-0900',1,NULL,NULL,12,NULL,NULL,NULL,NULL,0),(13,'danknx@gmail.com',NULL,NULL,'','(512) 671-0900',5,NULL,NULL,12,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` varchar(8) NOT NULL,
  `approved` timestamp NULL DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,1,'','2016-07-18 13:04:33',NULL),(1,2,'','2016-07-18 13:04:33',NULL),(1,3,'','2016-07-18 13:04:33',NULL),(4,1,'active',NULL,NULL),(4,3,'active',NULL,NULL),(17,1,'approve',NULL,NULL);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `encrypted_pwd` varchar(40) DEFAULT NULL,
  `status` varchar(12) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,NULL,'active','2016-07-19 00:00:55',0,'durga',NULL,NULL,NULL,'0000-00-00 00:00:00'),(6,NULL,'approve','2016-07-21 20:57:36',0,'sunil',NULL,NULL,NULL,'0000-00-00 00:00:00'),(13,'d4e17a9b560c652ba56e912bfb37cf87','active','2016-10-05 11:22:12',0,'danny',NULL,NULL,NULL,'0000-00-00 00:00:00'),(17,'d4e17a9b560c652ba56e912bfb37cf87','active','2016-09-23 22:39:56',0,'danny_knox',NULL,NULL,NULL,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-11 19:17:09
