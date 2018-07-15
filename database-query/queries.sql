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

SELECT * FROM Students where stdNum='2012101218';


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
ALTER TABLE Faculties
ADD COLUMN isAdmin TINYINT DEFAULT 0;
ALTER TABLE Faculties
ADD COLUMN isDean TINYINT DEFAULT 0;

SELECT id, facultyIDNum, firstName, lastName, email, dateRegistered, addedByAdminFacultyNum, isAdmin, isDean
FROM Faculties WHERE facultyIDNum='99447846' AND pswd='';

SELECT * FROM Faculties;

INSERT INTO `Faculties` (`facultyIDNum`, `firstName`, `lastName`, `email`, `pswd`, `addedByAdminFacultyNum`) 
VALUES ('99447847', 'RANIEL', 'GARCIA', 'ranielgarcia101@gmial.com', 'b7177df6d79df49b0f9806294f0e7d616d9ff8a9fd87be3b9d0c996aa63e7d9760ad75f8a1a0e9190600ef636d62cec56e699f62ef76a376cc0c744cf8acb939', '99447846');


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

SELECT * FROM Admins;


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

SELECT * FROM Students;

CREATE TABLE IF NOT EXISTS Lessons(
	id INT NOT NULL AUTO_INCREMENT,
	chapterID INT NOT NULL,
	title VARCHAR(255),
	slug VARCHAR(255),
	content TEXT,
	isWithCoverPhoto TINYINT DEFAULT 0, -- default 0 = false 
	coverPhoto VARCHAR(255) DEFAULT 'NA', -- default NA
	coverOrientation CHAR(2) DEFAULT '-', -- default 0 = none
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	dateModify DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	addedByFacultyNum CHAR(20),
	modifyByFacultyNum CHAR(20) DEFAULT 'NA',
	isDeleted TINYINT DEFAULT 0,
	FOREIGN KEY(chapterID) REFERENCES TopicChapters(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM Lessons;

SELECT Les.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, Chap.chapterTitle, Top.topic, Prin.principle
FROM Lessons As Les, TopicChapters As Chap, PrinciplesSubTopic As Top, AgriPrinciples As Prin
WHERE Les.isDeleted=0 AND Chap.isDeleted=0 AND Top.isDeleted=0 AND Prin.isDeleted=0 AND
	Les.chapterID=Chap.id AND Chap.topicID=Top.id AND Top.principleID=Prin.id AND Les.addedByFacultyNum='99447846';


SELECT `Les`.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, `Chap`.`chapterTitle`, `Top`.`topic`, `Prin`.`principle`, CONCAT(Fac.firstName, ' ', Fac.lastName) As AddedByUser
FROM `Lessons` As `Les`
JOIN `TopicChapters` As `Chap` ON `Les`.`chapterID` = `Chap`.`id`
JOIN `PrinciplesSubTopic` As `Top` ON `Chap`.`topicID` = `Top`.`id`
JOIN `AgriPrinciples` As `Prin` ON `Top`.`principleID` = `Prin`.`id`
JOIN `Faculties` As `Fac` ON `Fac`.`facultyIDNum`=`Les`.`addedByFacultyNum`
WHERE `Les`.`isDeleted` = 0
AND `Chap`.`isDeleted` = 0
AND `Top`.`isDeleted` = 0
AND `Prin`.`isDeleted` = 0
AND   (
`Prin`.`id` = '12'
AND `Top`.`id` = '12'
AND `Chap`.`id` = '6'
AND    (
`Les`.`title` LIKE '%one one %' ESCAPE '!'
  )
 )
ORDER BY `Les`.`id` DESC;