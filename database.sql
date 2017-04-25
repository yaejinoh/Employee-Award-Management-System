/* Flush out database */
DROP TABLE IF EXISTS Awards;
DROP TABLE IF EXISTS Admins;
DROP TABLE IF EXISTS Employees;
DROP TABLE IF EXISTS CertType;
DROP TABLE IF EXISTS Regions;



/* Create database tables */
CREATE TABLE Admins (
    id			INT		AUTO_INCREMENT PRIMARY KEY,
    password		VARCHAR (40)	NOT NULL,
    datetimestamp 	TIMESTAMP	NULL,
    emailaddress  	VARCHAR (75)	NOT NULL
);



CREATE TABLE Employees (
    id            	INT		AUTO_INCREMENT PRIMARY KEY,
    firstname     	VARCHAR (40)	NOT NULL,
    lastname		VARCHAR (40)	NOT NULL,
    password		VARCHAR (40)	NOT NULL,
    datetimestamp	TIMESTAMP	NULL,
    emailaddress	VARCHAR (75)	NOT NULL,
    signature		BLOB		NULL
);



CREATE TABLE CertType (
    ctid		INT        	AUTO_INCREMENT PRIMARY KEY,
    type		VARCHAR (30) 	NOT NULL,
    UNIQUE (type)
);
INSERT INTO CertType (type) 
VALUES ('Employee of the Year'), ('Employee of the Month');



CREATE TABLE Regions (
    rid           	INT        	AUTO_INCREMENT PRIMARY KEY,
    sector		VARCHAR (30) 	NOT NULL,
    UNIQUE (sector)
);
INSERT INTO Regions (sector) 
VALUES ('New York City'), ('Washington D.C.'), ('San Francisco'), ('London'), ('Cambridge'), ('Venice'), ('Florence'), ('Rome');



CREATE TABLE Awards (
    id            	INT      	AUTO_INCREMENT PRIMARY KEY,
    name		INT		NOT NULL,
    date		DATE		NOT NULL,
    time		TIME		NOT NULL,
    awardee		INT		NOT NULL,
    region		INT		NOT NULL,
    type		INT		NOT NULL,
	CONSTRAINT fk_awards_type FOREIGN KEY (type) 
	REFERENCES CertType (ctid)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk_awards_region FOREIGN KEY (region)
	REFERENCES Regions (rid)
    		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk_awards_presenter FOREIGN KEY (name)
	REFERENCES Employees (id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk_awards_awardee FOREIGN KEY (awardee)
	REFERENCES Employees (id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);



/* Populating database tables with sample entries */

/* Employees Table */
INSERT INTO Employees (firstname, lastname, password, emailaddress, datetimestamp) 
VALUES 
('John', 'Doe', 'hunter2', 'johndoe85@gmail.com', CURRENT_TIMESTAMP), 
('Jane', 'Doe', 'cestlavie', 'janedoe@gmail.com', CURRENT_TIMESTAMP),
('Megara', 'Creon', 'hjuQ767', 'mcreon@thebes.net', CURRENT_TIMESTAMP),
('Smith', 'Carlson', 'monalisa21', 'artisticman11@sbcglobal.net', CURRENT_TIMESTAMP),
('Hermione', 'Granger', 'wikrio32nklAdwa', 'hgranger@hogwarts.edu', CURRENT_TIMESTAMP),
('Ramsay', 'Bolton', 'iloved0gs', 'xxpupluvxx@yahoo.com', CURRENT_TIMESTAMP),
('Sarah', 'Smith', 'asdfasdf', 's231@gmail.com', CURRENT_TIMESTAMP),
('Michael', 'Scott', 'michaelscott', 'michaelscott@gmail.com', CURRENT_TIMESTAMP),
('Aaron', 'Smith', 'wqd3fsdjuy', 'smith39022@gmail.com', CURRENT_TIMESTAMP),
('Smith', 'Smith', 'smithsmith', 'sm9912@yahoo.com', CURRENT_TIMESTAMP);


/* Admins Table */
INSERT INTO Admins (emailaddress, password, datetimestamp) 
VALUES 
('johnson@oregonstate.edu', 'adminpw123', CURRENT_TIMESTAMP),
('smith@oregonstate.edu', 'wioad214', CURRENT_TIMESTAMP),
('ze231@gmail.com', '987654321', CURRENT_TIMESTAMP);


/* Awards Table */
INSERT INTO Awards (name, date, time, awardee, region, type) 
VALUES 
(1, CURDATE(), CURTIME(), 21, 11, 1),
(1, CURDATE(), CURTIME(), 21, 1, 11),
(21, CURDATE(), CURTIME(), 1, 31, 11),
(31, CURDATE(), CURTIME(), 31, 61, 11),
(1, CURDATE(), CURTIME(), 11, 71, 1),
(41, CURDATE(), CURTIME(), 51, 41, 1);



/* MySQL SELECT queries for testing */

/* Show all employees */
SELECT * FROM Employees;

/* Show all admins */
SELECT * FROM Admins;

/* Show all certificate types */
SELECT * FROM CertType;

/* Show all regions */
SELECT * FROM Regions;

/* Show all awards */
SELECT	A.id, A.date, A.time,
		PE.firstname AS PresenterFirstName, 
		PE.lastname AS PresenterLastName,  
		AE.firstname AS AwardeeFirstName, 
		AE.lastname AS AwardeeLastName,
		CT.type AS CertificateType,
		R.sector AS Region
FROM Awards A
JOIN Employees PE ON PE.id=A.name
JOIN Employees AE ON AE.id=A.awardee
JOIN CertType CT ON CT.ctid=A.type
JOIN Regions R ON R.rid=A.region;

/* Show all employees with the last name ____ */
SELECT * 
FROM Employees
WHERE lastname = 'Smith';

/* Show all employees with the first name ____ */
SELECT * 
FROM Employees
WHERE firstname = 'Ramsay';

/* Show all employees with a first or last name of ____ */
SELECT *
FROM Employees
WHERE lastname = 'Smith' OR firstname = 'Smith';

/* Show all awards created by ____, sorted by date */
SELECT	A.id, A.date, A.time,
		PE.firstname AS PresenterFirstName, 
		PE.lastname AS PresenterLastName,  
		AE.firstname AS AwardeeFirstName, 
		AE.lastname AS AwardeeLastName,
		CT.type AS CertificateType,
		R.sector AS Region
FROM Awards A
JOIN Employees PE ON PE.id=A.name
JOIN Employees AE ON AE.id=A.awardee
JOIN CertType CT ON CT.ctid=A.type
JOIN Regions R ON R.rid=A.region
WHERE PE.firstname = 'John' AND PE.lastname = 'Doe'
ORDER BY A.date, A.time;

/* Delete specific award created by ____ */
DELETE FROM Awards
WHERE id = 1
AND name = 1;

/* Delete all awards created by ____ */
DELETE FROM Awards
WHERE name = 1;

/* Delete specific employee */
DELETE FROM Employees
WHERE id = 1;

/* Delete all employees */
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE Employees;
SET FOREIGN_KEY_CHECKS = 1;

