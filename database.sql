/* Flush out and delete pre-existing tables */
DROP TABLE IF EXISTS [dbo].[Awards];
DROP TABLE IF EXISTS [dbo].[CertType];
DROP TABLE IF EXISTS [dbo].[Regions];
DROP TABLE IF EXISTS [dbo].[Employees];
DROP TABLE IF EXISTS [dbo].[Admins];

/*
IF OBJECT_ID ('dbo.Awards', 'U') IS NOT NULL
DROP TABLE dbo.Awards;
IF OBJECT_ID ('dbo.CertType', 'U') IS NOT NULL
DROP TABLE dbo.CertType;
IF OBJECT_ID ('dbo.Regions', 'U') IS NOT NULL
DROP TABLE dbo.Regions;
IF OBJECT_ID ('dbo.Employees', 'U') IS NOT NULL
DROP TABLE dbo.Employees;
IF OBJECT_ID ('dbo.Admins', 'U') IS NOT NULL
DROP TABLE dbo.Admins;
*/

/* Create database tables */
CREATE TABLE [dbo].[Employees] (
    [id]            INT			IDENTITY(1,1) PRIMARY KEY,
    [firstname]     NCHAR (40)	NOT NULL,
	[lastname]      NCHAR (40)	NOT NULL,
    [password]      NCHAR (40)	NOT NULL,
    [datetimestamp] DATETIME	NULL,
    [emailaddress]  NCHAR (75)	NOT NULL,
    [signature]     IMAGE		NULL
 /*   PRIMARY KEY CLUSTERED ([id] ASC)*/
);



CREATE TABLE [dbo].[CertType] (
    [ctid]          INT        IDENTITY(1,1) PRIMARY KEY,
    [type]		    NCHAR (30) NOT NULL,
	UNIQUE (type)
);
INSERT INTO [dbo].[CertType] (type) 
VALUES ('Employee of the Year'), ('Employee of the Month');



CREATE TABLE [dbo].[Regions] (
    [rid]           INT        IDENTITY(1,1) PRIMARY KEY,
    [sector]		NCHAR (30) NOT NULL,
	UNIQUE (sector)
);
INSERT INTO [dbo].[Regions] (sector) 
VALUES ('New York City'), ('Washington D.C.'), ('San Francisco'), ('London'), ('Cambridge'), ('Venice'), ('Florence'), ('Rome');



CREATE TABLE [dbo].[Awards] (
    [id]            INT        IDENTITY(1,1) PRIMARY KEY,
    [name]			INT		   NOT NULL,
    [date]			DATE	   NOT NULL,
    [time]			TIME	   NOT NULL,
    [awardee]		INT		   NOT NULL,
    [region]		INT		   NOT NULL,
	[type]          INT		   NOT NULL,
	CONSTRAINT fk_awards_type FOREIGN KEY (type) 
	REFERENCES [dbo].[CertType] (ctid),
	CONSTRAINT fk_awards_region FOREIGN KEY (region)
	REFERENCES [dbo].[Regions] (rid),
	CONSTRAINT fk_awards_presenter FOREIGN KEY (name)
	REFERENCES [dbo].[Employees] (id),
	CONSTRAINT fk_awards_awardee FOREIGN KEY (awardee)
	REFERENCES [dbo].[Employees] (id)
);



CREATE TABLE [dbo].[Admins] (
    [id]            INT			IDENTITY(1,1) PRIMARY KEY,
    [password]      NCHAR (40)	NOT NULL,
    [datetimestamp] DATETIME	NULL,
    [emailaddress]  NCHAR (75)	NOT NULL
);



/* Populate databases with sample entries */
/* Employees Table */
INSERT INTO [dbo].[Employees] (firstname, lastname, password, emailaddress, datetimestamp) 
VALUES 
('John', 'Doe', 'hunter2', 'johndoe85@gmail.com', CURRENT_TIMESTAMP), 
('Megara', 'Creon', 'hjuQ767', 'mcreon@thebes.net', CURRENT_TIMESTAMP),
('Smith', 'Carlson', 'monalisa21', 'artisticman11@sbcglobal.net', CURRENT_TIMESTAMP),
('Hermione', 'Granger', 'wikrio32nklAdwa', 'hgranger@hogwarts.edu', CURRENT_TIMESTAMP),
('Ramsay', 'Bolton', 'iloved0gs', 'xxpupluvxx@yahoo.com', CURRENT_TIMESTAMP),
('Sarah', 'Smith', 'asdfasdf', 's231@gmail.com', CURRENT_TIMESTAMP),
('Michael', 'Scott', 'michaelscott', 'michaelscott@gmail.com', CURRENT_TIMESTAMP),
('Aaron', 'Smith', 'wqd3fsdjuy', 'smith39022@gmail.com', CURRENT_TIMESTAMP),
('Smith', 'Smith', 'smithsmith', 'sm9912@yahoo.com', CURRENT_TIMESTAMP);

/* Admins Table */
INSERT INTO [dbo].[Admins] (emailaddress, password, datetimestamp) 
VALUES 
('johnson@oregonstate.edu', 'adminpw123', CURRENT_TIMESTAMP),
('smith@oregonstate.edu', 'wioad214', CURRENT_TIMESTAMP),
('ze231@gmail.com', '987654321', CURRENT_TIMESTAMP);

/* Awards Table */
INSERT INTO [dbo].[Awards] (name, date, time, awardee, region, type) 
VALUES 
(1, CAST(GETDATE() AS date), CAST(GETDATE() AS time), 3, 2, 1),
(1, CAST(GETDATE() AS date), CAST(GETDATE() AS time), 3, 1, 2),
(3, CAST(GETDATE() AS date), CAST(GETDATE() AS time), 1, 4, 2),
(4, CAST(GETDATE() AS date), CAST(GETDATE() AS time), 4, 7, 2),
(1, CAST(GETDATE() AS date), CAST(GETDATE() AS time), 2, 8, 1),
(5, CAST(GETDATE() AS date), CAST(GETDATE() AS time), 6, 5, 1);

/* Queries */

/* Show all employees */
SELECT * FROM [dbo].[Employees];

/* Show all admins */
SELECT * FROM [dbo].[Admins];

/* Show all regions */
SELECT * FROM [dbo].[Regions];

/* Show all certificate types */
SELECT * FROM [dbo].[CertType];

/* Show all awards */
SELECT	A.id, A.date, A.time,
		PE.firstname AS PresenterFirstName, 
		PE.lastname AS PresenterLastName,  
		AE.firstname AS AwardeeFirstName, 
		AE.lastname AS AwardeeLastName,
		CT.type AS CertificateType,
		R.sector AS Region
FROM [dbo].[Awards] A
JOIN [dbo].[Employees] PE ON PE.id=A.name
JOIN [dbo].[Employees] AE ON AE.id=A.awardee
JOIN [dbo].[CertType] CT ON CT.ctid=A.type
JOIN [dbo].[Regions] R ON R.rid=A.region;

/* Show all employees with the last name ____ */
SELECT * 
FROM [dbo].[Employees] 
WHERE lastname = 'Smith';

/* Show all employees with the first name ____ */
SELECT * 
FROM [dbo].[Employees] 
WHERE firstname = 'Ramsay';

/* Show all employees with a first or last name of ____ */
SELECT *
FROM [dbo].[Employees]
WHERE lastname = 'Smith' OR firstname = 'Smith';

/* Show all awards created by ____, sorted by date */
SELECT	A.id, A.date, A.time,
		PE.firstname AS PresenterFirstName, 
		PE.lastname AS PresenterLastName,  
		AE.firstname AS AwardeeFirstName, 
		AE.lastname AS AwardeeLastName,
		CT.type AS CertificateType,
		R.sector AS Region
FROM [dbo].[Awards] A
JOIN [dbo].[Employees] PE ON PE.id=A.name
JOIN [dbo].[Employees] AE ON AE.id=A.awardee
JOIN [dbo].[CertType] CT ON CT.ctid=A.type
JOIN [dbo].[Regions] R ON R.rid=A.region
WHERE PE.firstname = 'John' AND PE.lastname = 'Doe'
ORDER BY convert(date, A.date, 103) DESC;

/* Delete specific award created by ____ */
DELETE FROM [dbo].[Awards]
WHERE id = 1
AND name = 1;

/* Delete all awards created by ____ */
DELETE FROM [dbo].[Awards]
WHERE name = 1;
