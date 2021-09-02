-- Generation time: Thu, 02 Sep 2021 12:31:52 +0200
-- Host: 127.0.0.1
-- DB name: unism
/*!40030 SET NAMES UTF8 */;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `demo_tasks`;
CREATE TABLE `demo_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assignee` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `milestone_id` int(11) DEFAULT NULL,
  `is_complete_yn` varchar(1) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `demo_tasks_uk` (`project_id`,`name`),
  KEY `demo_tasks_team_member_idx` (`assignee`),
  KEY `demo_tasks_project_idx` (`project_id`),
  KEY `demo_tasks_milestone_idx` (`milestone_id`),
  CONSTRAINT `demo_tasks_milestone_fk` FOREIGN KEY (`milestone_id`) REFERENCES `demo_milestones` (`id`) ON DELETE SET NULL,
  CONSTRAINT `demo_tasks_project_fk` FOREIGN KEY (`project_id`) REFERENCES `demo_projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `demo_tasks_team_member_fk` FOREIGN KEY (`assignee`) REFERENCES `demo_team_members` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

INSERT INTO `demo_tasks` VALUES ('8','6','\"Prepare Course Outline\"','\"Creation of the training syllabus\"','2','1','Y','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','','0000-00-00 00:00:00',''),
('9','6','\"Write Training Guide\"','\"Produce the powerpoint deck (with notes) for the training instructor.\"','2','1','N','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','','0000-00-00 00:00:00',''),
('10','6','\"Develop Training Exercises\"','\"Create scripts for sample data and problem statements with solutions.\"','2','1','Y','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','','0000-00-00 00:00:00',''),
('11','6','\"Conduct Train-the-Trainer session\"','\"Give the training material to the selected developers.\"','2','1','Y','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','','0000-00-00 00:00:00',''),
('13','3','test1','test','2','1','Y','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','','0000-00-00 00:00:00',''); 




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

