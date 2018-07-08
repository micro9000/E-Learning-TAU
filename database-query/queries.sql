## E-Learning for Tarlac Agriculure University, Agriculture Department
## July 1 2018

CREATE DATABASE IF NOT EXISTS ELearning_db;
USE ELearning_db;

CREATE TABLE IF NOT EXISTS ValidStudentNumbers(
	id INT NOT NULL AUTO_INCREMENT,
	stdNum CHAR(20),
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM ValidStudentNumbers;

CREATE TABLE IF NOT EXISTS Students(
	id INT NOT NULL AUTO_INCREMENT,
	stdNum CHAR(20),
	firstName CHAR(60),
	lastName CHAR(60),
	email CHAR(60),
	pswd VARCHAR(255),
	dateRegistered DATETIME DEFAULT CURRENT_TIMESTAMP,
	isDeleted TINYINT DEFAULT 0,
	PRIMARY KEY(id)
)ENGINE=INNODB;


SELECT * FROM Students;

CREATE TABLE IF NOT EXISTS Faculties(
	id INT NOT NULL AUTO_INCREMENT,
	facultyIDNum CHAR(20),
	firstName CHAR(60),
	lastName CHAR(60),
	email CHAR(60),
	pswd VARCHAR(255),
	dateRegistered DATETIME DEFAULT CURRENT_TIMESTAMP,
	addedByAdminFacultyNum CHAR(20),
	isDeleted TINYINT DEFAULT 0,
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM Faculties;


CREATE TABLE IF NOT EXISTS Admins(
	id INT NOT NULL AUTO_INCREMENT,
	facultyID INT NOT NULL,
	pswd VARCHAR(255),
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	addedByFacultyNum CHAR(20),
	isDeleted TINYINT DEFAULT 0,
	FOREIGN KEY(facultyID) REFERENCES Faculties(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;

select DATE_FORMAT(dateAdded, '%M %d %Y %r') from Admins;


CREATE TABLE IF NOT EXISTS AgriPrinciples(
	id INT NOT NULL AUTO_INCREMENT,
	principle VARCHAR(255),
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	dateModify DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	addedByFacultyNum CHAR(20),
	modifyByFacultyNum CHAR(20) DEFAULT 'NA',
	isDeleted TINYINT DEFAULT 0,
	PRIMARY KEY(id)
)ENGINE=INNODB;



CREATE TABLE IF NOT EXISTS PrinciplesSubTopic(
	id INT NOT NULL AUTO_INCREMENT,
	principleID INT NOT NULL,
	topic VARCHAR(255),
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	dateModify DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	addedByFacultyNum CHAR(20),
	modifyByFacultyNum CHAR(20) DEFAULT 'NA',
	isDeleted TINYINT DEFAULT 0,
	FOREIGN KEY(principleID) REFERENCES AgriPrinciples(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;
;
SELECT * FROM PrinciplesSubTopic;


CREATE TABLE IF NOT EXISTS TopicChapters(
	id INT NOT NULL AUTO_INCREMENT,
	topicID INT NOT NULL,
	principleID INT NOT NULL,
	chapterTitle VARCHAR(255),
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	dateModify DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	addedByFacultyNum CHAR(20),
	modifyByFacultyNum CHAR(20) DEFAULT 'NA',
	isDeleted TINYINT DEFAULT 0,
	FOREIGN KEY(principleID) REFERENCES AgriPrinciples(id),
	FOREIGN KEY(topicID) REFERENCES PrinciplesSubTopic(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM TopicChapters;


SELECT `TC`.*, `AP`.`principle`, `PT`.`topic`, CONCAT(FT.firstName, ' ', FT.lastName) As facultyName
FROM `TopicChapters` As `TC`
JOIN `AgriPrinciples` As `AP` ON `TC`.`principleID` = `AP`.`id`
JOIN `PrinciplesSubTopic` As `PT` ON `TC`.`topicID` = `PT`.`id`
JOIN `Faculties` As `FT` ON `TC`.`addedByFacultyNum`=`FT`.`facultyIDNum`
WHERE   (
`TC`.`chapterTitle` LIKE '%update here%' ESCAPE '!'
OR  `AP`.`principle` LIKE '%update here%' ESCAPE '!'
OR  `PT`.`topic` LIKE '%update here%' ESCAPE '!'
 )
AND   (
`TC`.`isDeleted` = 0
AND `AP`.`isDeleted` = 0
AND `PT`.`isDeleted` = 0
 )
AND `PT`.`principleID` = `AP`.`id`
ORDER BY `TC`.`id` DESC;
