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
ALTER TABLE students
ADD COLUMN stdSubject VARCHAR(255) DEFAULT '';

SELECT * FROM Students;

CREATE TABLE IF NOT EXISTS StdRegTempStorage(
	id INT NOT NULL AUTO_INCREMENT,
	stdNum CHAR(20),
	firstName CHAR(60),
	lastName CHAR(60),
	email CHAR(60),
	pswd VARCHAR(255),
	dateRegistration DATETIME DEFAULT CURRENT_TIMESTAMP,
	expDate DATETIME NOT NULL,
	randomCode CHAR(10),
	isConfirm TINYINT DEFAULT 0,
	PRIMARY KEY(id)
)ENGINE=INNODB;


SELECT * FROM StdRegTempStorage;


CREATE TABLE IF NOT EXISTS StdPswdRecoveryTempStorage(
	id INT NOT NULL AUTO_INCREMENT,
	stdNum CHAR(20),
	email CHAR(60),
	dateTry DATETIME DEFAULT CURRENT_TIMESTAMP,
	expDate DATETIME NOT NULL,
	randomCode CHAR(10),
	isConfirm TINYINT DEFAULT 0,
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM StdPswdRecoveryTempStorage;


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

select * from Faculties;

SELECT COUNT(*) As count FROM Faculties WHERE isDeleted=0 AND isDean=1;


-- CREATE TABLE IF NOT EXISTS Admins(
-- 	id INT NOT NULL AUTO_INCREMENT,
-- 	facultyID INT NOT NULL,
-- 	pswd VARCHAR(255),
-- 	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
-- 	addedByFacultyNum CHAR(20),
-- 	isDeleted TINYINT DEFAULT 0,
-- 	FOREIGN KEY(facultyID) REFERENCES Faculties(id),
-- 	PRIMARY KEY(id)
-- )ENGINE=INNODB;

SELECT * FROM Admins;-- @@@@@@@@@@@@@@@@@

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


CREATE TABLE IF NOT EXISTS Quizzes(
	id INT NOT NULL AUTO_INCREMENT,
	chapterID INT NOT NULL,
	quizTitle VARCHAR(255),
	quizTitleSlug VARCHAR(255),
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	isDeleted TINYINT DEFAULT 0,
	addedByFacultyNum CHAR(20),
	FOREIGN KEY(chapterID) REFERENCES TopicChapters(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM Quizzes;

	-- numOfChoices INT, -- select if from choices
	-- numOfRightAns INT,-- select if from choices
CREATE TABLE IF NOT EXISTS QuizQuestions(
	id INT NOT NULL AUTO_INCREMENT,
	quizID INT NOT NULL,
	question VARCHAR(255),
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	isDeleted TINYINT DEFAULT 0,
	addedByFacultyNum CHAR(20),
	FOREIGN KEY(quizID) REFERENCES Quizzes(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM QuizQuestions;

SELECT id, quizID, question, DATE_FORMAT(dateAdded, '%M %d, %Y %r') As dateAddedFormatted, addedByFacultyNum
FROM QuizQuestions WHERE quizID=1;

CREATE TABLE IF NOT EXISTS QuestionChoices(
	id INT NOT NULL AUTO_INCREMENT,
	questionID INT NOT NULL,
	choiceStr VARCHAR(255),
	isRightAns INT DEFAULT 0,
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	isDeleted TINYINT DEFAULT 0,
	addedByFacultyNum CHAR(20),
	FOREIGN KEY(questionID) REFERENCES QuizQuestions(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM QuestionChoices WHERE isDeleted=0;

SELECT COUNT(QC.id) As count
FROM QuestionChoices As QC, QuizQuestions As QQ 
WHERE QC.isDeleted=0 AND QQ.isDeleted=0 AND QC.isRightAns=1 AND QC.questionID=QQ.id AND QQ.quizID=14;

CREATE TABLE IF NOT EXISTS StudentQuizResults(
	id INT NOT NULL AUTO_INCREMENT,
	chapterID INT NOT NULL,
	quizID INT NOT NULL,
	score INT DEFAULT 0,
	stdNum CHAR(20),
	dateTaken DATETIME DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY(chapterID) REFERENCES TopicChapters(id),
	FOREIGN KEY(quizID) REFERENCES Quizzes(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM Quizzes;
SELECT * FROM TopicChapters;

SELECT * FROM StudentQuizResults WHERE chapterID=14 and quizID=1 AND stdNum='2012101218' ORDER BY id DESC LIMIT 1;
-- 
-- 
SELECT R.*, C.chapterTitle, Q.quizTitle, DATE_FORMAT(dateTaken, '%M %d, %Y') As dateTakenFormat, CONCAT(S.firstName,' ', S.lastName) As stdName
FROM TopicChapters As C, Quizzes As Q, StudentQuizResults As R, Students As S
WHERE R.chapterID=C.id AND R.quizID=Q.id AND R.stdNum='2012101218' AND S.stdNum=R.stdNum ORDER BY R.id DESC;

SELECT R.*, C.chapterTitle, Q.quizTitle, DATE_FORMAT(dateTaken, '%M %d, %Y') As dateTakenFormat, CONCAT(S.firstName,' ', S.lastName) As stdName
FROM TopicChapters As C, Quizzes As Q, StudentQuizResults As R, Students As S
WHERE R.chapterID=C.id AND R.quizID=Q.id AND S.stdNum=R.stdNum ORDER BY R.id DESC LIMIT 200;

SELECT * FROM Students;

CREATE TABLE IF NOT EXISTS StudentQuizAnswers(
	id INT NOT NULL AUTO_INCREMENT,
	resultsID INT NOT NULL,
	questionID INT NOT NULL,
	choiceID INT NOT NULL,
	stdNum CHAR(20),
	dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	isDeleted TINYINT DEFAULT 0,
	FOREIGN KEY(resultsID) REFERENCES StudentQuizResults(id),
	FOREIGN KEY(questionID) REFERENCES QuizQuestions(id),
	FOREIGN KEY(choiceID) REFERENCES QuestionChoices(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;


SELECT * FROM StudentQuizAnswers;



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


CREATE TABLE IF NOT EXISTS Lesson_update_summary(
	id INT NOT NULL AUTO_INCREMENT,
	lessonID INT NOT NULL,
	updateSummary TEXT,
	updatedByFacultyNum CHAR(20),
	dateUpdated DATETIME DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY(lessonID) REFERENCES Lessons(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;

select * from Lesson_update_summary;

SELECT TIMESTAMPDIFF(MINUTE, '2018-07-22 17:55:38', CURRENT_TIMESTAMP ) as timeDiff;

SELECT DATE_FORMAT('2018-07-22 17:55:38', '%M %d, %Y %r');

CREATE TABLE IF NOT EXISTS Lesson_comments(
	id INT NOT NULL AUTO_INCREMENT,
	lessonID INT NOT NULL,
	comments TEXT,
	stdNum_facNum CHAR(20),
	userType CHAR(3), -- STD - students , FAC - faculties
	dateCommented DATETIME DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY(lessonID) REFERENCES Lessons(id),
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM Lesson_comments;

select * from Lesson_update_summary;

SELECT LUS.id, LUS.lessonID, LUS.updateSummary, LUS.updatedByFacultyNum, DATE_FORMAT(LUS.dateUpdated, '%M %d, %Y %r') As dateUpdatedFormatted, CONCAT(FAC.firstName,' ', FAC.lastName) As UpdatedBy
FROM Lesson_update_summary As LUS, Faculties As FAC
WHERE FAC.facultyIDNum=LUS.updatedByFacultyNum;


-- Affected Module Legend
-- 1 - Principle - PRPL
-- 2 - Sub Topic - SBTP
-- 3 - Chapters - CHAP
-- 4 - Lessons - LESS
-- 5 - Faculties - FACU
-- 6 - Students - STUD

CREATE TABLE IF NOT EXISTS AuditTrail(
	id INT NOT NULL AUTO_INCREMENT,
	actionDone VARCHAR(255) DEFAULT '',
	affectedModule CHAR(10),
	responsibleFacultyNum CHAR(20),
	actionDate DATETIME DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
)ENGINE=INNODB;

SELECT * FROM AuditTrail;

