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
	WelcomeMessage TEXT);


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
	DateSend DATETIME NOT NULL,
	Content TEXT,
	FOREIGN KEY (IdSender) REFERENCES Account(IdAccount) ON DELETE CASCADE,
	FOREIGN KEY (IdRecipient) REFERENCES Account(IdAccount) ON DELETE CASCADE);


CREATE TABLE IF NOT EXISTS Interest ( 
	IdInterest INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Interest VARCHAR(255) NOT NULL);


CREATE TABLE IF NOT EXISTS InterestLink ( 
	IdAccount INT NOT NULL,
	IdInterest INT NOT NULL,
	CONSTRAINT cle_pri PRIMARY KEY (IdAccount, IdInterest),
	FOREIGN KEY (IdAccount) REFERENCES Account(IdAccount) ON DELETE CASCADE,
	FOREIGN KEY (IdInterest) REFERENCES Interest(IdInterest) ON DELETE CASCADE);


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


CREATE TABLE IF NOT EXISTS Image ( 
	IdAccount INT NOT NULL,
	IdImg INT NOT NULL,
	ImgFile VARCHAR(255) NOT NULL,
	CONSTRAINT cle_pri PRIMARY KEY (IdAccount, IdImg),
	FOREIGN KEY (IdAccount) REFERENCES Account(IdAccount) ON DELETE CASCADE);


CREATE TABLE IF NOT EXISTS Report ( 
	IdMessage INT NOT NULL PRIMARY KEY,
	Why TEXT,
	FOREIGN KEY (IdMessage) REFERENCES Message(IdMessage) ON DELETE CASCADE);

INSERT INTO Account (IdAccount, Pseudo, Password, Sexe, FirstName, Name, Mail, DateOfBirth, Country, City) VALUES 
	(1, "Sifflet_Blanc", "mlkjhgfdsq", "M", "Florent", "Crahay--Boudou", "flo.crahay@gmail.com", "2003-11-19", "France", "Pau");

INSERT INTO Account (IdAccount, Pseudo, Password, Sexe, FirstName, Name, Mail, DateOfBirth, Country, City, Street, AdressNumber, LoveSituation, Species, HumanoidGauge, WelcomeMessage) VALUES 
	(2, "Legolas64", "leff", "M", "Legolas", "Elfe", "legolaslelfedu64@gmail.com", "103-07-09", "Terre du milieu", "Stilgard", "Avenue du Palais", 3, "Celib", "Elfe", 9, "Coucou, je suis Legolas :)");

INSERT INTO Admin (IdAccount) VALUES
	(1);

INSERT INTO Image (IdAccount, IdImg, ImgFile) VALUES
	(2, 1, "Legolas_greenleaf_orlando_bloom_lotr_by_push_pulse-d5vcniw.webp");

INSERT INTO Contact (IdAsker, IdAccount, Approval) VALUES
	(1,2,TRUE);