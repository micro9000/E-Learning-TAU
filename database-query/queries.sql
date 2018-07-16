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

SELECT * FROM Lessons WHERE isDeleted=0;

SELECT Les.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, Chap.chapterTitle, Top.topic, Prin.principle
FROM Lessons As Les, TopicChapters As Chap, PrinciplesSubTopic As Top, AgriPrinciples As Prin
WHERE Les.isDeleted=0 AND Chap.isDeleted=0 AND Top.isDeleted=0 AND Prin.isDeleted=0 AND
	Les.chapterID=Chap.id AND Chap.topicID=Top.id AND Top.principleID=Prin.id AND Les.addedByFacultyNum='99447846';


UPDATE `Lessons` SET `chapterID` = '6', `title` = 'Title one two three', `slug` = 'title_one_two_three', `content` = '<p><img class=\"content-img\" src=\"//192.168.1.7/ELearning/uploads/lessons/content/a446a41361a96cf42989fcad0e5982aa.png\"></p>\r\n<div>\r\n<h2>Where does it come from?</h2>\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\r\n</div>', `modifyByFacultyNum` = '99447846'
WHERE `id` = '17';