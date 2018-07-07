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

SELECT * FROM Admins;

SELECT A.id As adminID, F.id as facultyID, F.facultyIDNum, F.firstName, F.lastName, F.email, F.dateRegistered, F.addedByAdminFacultyNum
FROM Admins As A, Faculties As F
WHERE F.isDeleted=0 AND A.isDeleted=0 AND A.facultyID=F.id AND F.facultyIDNum='99447846' 
AND A.pswd='8450eca01665516d9aeb5317764902b78495502637c96192c81b1683d32d691a0965cf037feca8b9ed9ee6fc6ab8f27fce8f77c4fd9b4a442a00fc317b8237e6';

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


SELECT * FROM AgriPrinciples;


SELECT AP.*, CONCAT(F.firstName, ' ', F.lastName) As facultyName
FROM AgriPrinciples As AP, Faculties As F
WHERE AP.addedByFacultyNum=F.facultyIDNum;

SELECT * FROM `AgriPrinciples` As `AP` JOIN `Faculties` As `F` ON `AP`.`addedByFacultyNum` = `F`.`facultyIDNum;` ORDER BY `AP`.`id`;

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


SELECT * FROM PrinciplesSubTopic;

SELECT ST.*, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName
FROM PrinciplesSubTopic As ST, AgriPrinciples As AP, Faculties As F
WHERE ST.isDeleted=0 AND AP.isDeleted=0 AND 
	ST.principleID=AP.id AND ST.addedByFacultyNum=F.facultyIDNum;

CREATE TABLE IF NOT EXISTS TopicChapters(
	id INT NOT NULL AUTO_INCREMENT,
	topicID INT NOT NULL,
	chapterNum INT NOT NULL DEFAULT 1, -- auto increment in background based on topic
	chapterTitle VARCHAR(255),
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	dateModify DATETIME DEFAULT CURRENT_TIMESTAMP,
	adminID INT NOT NULL,
	isDeleted TINYINT DEFAULT 0,
	FOREIGN KEY(adminID) REFERENCES Admins(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;