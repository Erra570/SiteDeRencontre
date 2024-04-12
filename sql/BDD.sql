CREATE USER IF NOT EXISTS 'User'@'localhost' IDENTIFIED BY 'fv_7qJ6j2_VY_T5';
GRANT ALL PRIVILEGES ON * . * TO 'User'@'localhost';

DROP DATABASE IF EXISTS BddSiteDeRencontre;
CREATE DATABASE IF NOT EXISTS BddSiteDeRencontre;

USE BddSiteDeRencontre;


CREATE TABLE IF NOT EXISTS Account ( 
	IdAccount INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Pseudo VARCHAR(255) NOT NULL,
	Password VARCHAR(255) NOT NULL,
	Sexe VARCHAR(30),
	FirstName VARCHAR(127),
	Name VARCHAR(127),
	Mail VARCHAR(255) NOT NULL,
	DateOfCreation DATETIME NOT NULL DEFAULT current_timestamp(),
	DateOfBirth DATE NOT NULL,
	Country VARCHAR(127) NOT NULL,
	City VARCHAR(127) NOT NULL,
	Street VARCHAR(127),
	AdressNumber INT,
	LoveSituation VARCHAR(30),
	Species VARCHAR(35),
	HumanoidGauge FLOAT(10),
	Size DECIMAL(9,2),
	Weight DECIMAL(9,2),
	EyeColor VARCHAR(30),
	Smoker INT(1),
	ProfilPictureFile VARCHAR(255) NOT NULL DEFAULT "ProfilDefaultPicture.png",
	WelcomeMessage TEXT,
	CONSTRAINT Pseudo UNIQUE (Pseudo));


CREATE TABLE IF NOT EXISTS Admin (
	IdAccount INT NOT NULL PRIMARY KEY,
	FOREIGN KEY (IdAccount) REFERENCES Account(IdAccount) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS Contact ( 
	IdAsker INT NOT NULL,
	IdAccount INT NOT NULL,
	Approval BOOLEAN DEFAULT NULL,
	CONSTRAINT cle_pri PRIMARY KEY (IdAsker, IdAccount),
	FOREIGN KEY (IdAsker) REFERENCES Account(IdAccount) ON DELETE CASCADE,
	FOREIGN KEY (IdAccount) REFERENCES Account(IdAccount) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS Message ( 
	IdMessage INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	IdSender INT NOT NULL,
	IdRecipient INT NOT NULL,
	DateSend DATETIME NOT NULL DEFAULT current_timestamp(),
	Content TEXT,
	FOREIGN KEY (IdSender) REFERENCES Account(IdAccount) ON DELETE CASCADE,
	FOREIGN KEY (IdRecipient) REFERENCES Account(IdAccount) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS Subscription (
	IdAccount INT NOT NULL,
	Start DATETIME NOT NULL DEFAULT current_timestamp(),
	End DATETIME NOT NULL,
	CONSTRAINT cle_pri PRIMARY KEY (IdAccount, Start),
	FOREIGN KEY (IdAccount) REFERENCES Account(IdAccount) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS BlackList ( 
	IdAccount INT NOT NULL,
	IdBlocked INT NOT NULL,
	CONSTRAINT cle_pri PRIMARY KEY (IdAccount, IdBlocked),
	FOREIGN KEY (IdAccount) REFERENCES Account(IdAccount) ON DELETE CASCADE,
	FOREIGN KEY (IdBlocked) REFERENCES Account(IdAccount) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS Visite ( 
	IdAccount INT NOT NULL,
	IdVisiteur INT NOT NULL,
	CONSTRAINT cle_pri PRIMARY KEY (IdAccount, IdVisiteur),
	FOREIGN KEY (IdAccount) REFERENCES Account(IdAccount) ON DELETE CASCADE,
	FOREIGN KEY (IdVisiteur) REFERENCES Account(IdAccount) ON DELETE CASCADE);


CREATE TABLE IF NOT EXISTS Image ( 
	IdAccount INT NOT NULL,
	IdImg INT NOT NULL,
	ImgFile VARCHAR(255) NOT NULL,
	CONSTRAINT cle_pri PRIMARY KEY (IdAccount, IdImg),
	FOREIGN KEY (IdAccount) REFERENCES Account(IdAccount) ON DELETE CASCADE);


CREATE TABLE IF NOT EXISTS ReportAccount ( 
	IdReporter INT NOT NULL,
	IdAccount INT NOT NULL,
	CONSTRAINT cle_pri PRIMARY KEY (IdReporter, IdAccount),
	FOREIGN KEY (IdReporter) REFERENCES Account(IdAccount) ON DELETE CASCADE,
	FOREIGN KEY (IdAccount) REFERENCES Account(IdAccount) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS ReportMsg ( 
	IdMessage INT NOT NULL PRIMARY KEY,
	FOREIGN KEY (IdMessage) REFERENCES Message(IdMessage) ON DELETE CASCADE);

INSERT INTO Account (IdAccount, Pseudo, Password, Sexe, FirstName, Name, Mail, DateOfBirth, Country, City) VALUES 
	(1, "Admin", "azertyuiop", "M", "Admin", "Admin", "admin@gmail.com", "2003-11-19", "France", "Pau");

INSERT INTO Account (IdAccount, Pseudo, Password, Sexe, FirstName, Name, Mail, DateOfBirth, Country, City, Street, AdressNumber, LoveSituation, Species, HumanoidGauge, WelcomeMessage, ProfilPictureFile) VALUES 
	(2, "Legolas64", "leffff", "M", "Legolas", "Elfe", "legolaslelfedu64@gmail.com", "103-07-09", "Terre du milieu", "Stilgard", "Avenue du Palais", 3, "Celibataire", "Elfe", 9, "Coucou, je suis Legolas :)", "Legolas_greenleaf_orlando_bloom_lotr_by_push_pulse-d5vcniw.webp");

INSERT INTO Admin (IdAccount) VALUES
	(1);

INSERT INTO Image (IdAccount, IdImg, ImgFile) VALUES
	(2, 1, "Legolas_greenleaf_orlando_bloom_lotr_by_push_pulse-d5vcniw.webp");

INSERT INTO Contact (IdAsker, IdAccount, Approval) VALUES
	(1,2,TRUE);

INSERT INTO Subscription (IdAccount, Start, End) VALUES
	(2, current_timestamp(), DATE_ADD(current_timestamp(), INTERVAL 6 MONTH));