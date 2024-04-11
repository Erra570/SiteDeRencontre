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

INSERT INTO Account (IdAccount, Pseudo, Password, Sexe, FirstName, Name, Mail, DateOfBirth, Country, City, LoveSituation) VALUES 
	(1, "Sifflet_Blanc", "mlkjhgfdsq", "M", "Florent", "Crahay--Boudou", "flo.crahay@gmail.com", "2003-11-19", "France", "Pau", "En couple");

INSERT INTO Account (IdAccount, Pseudo, Password, Sexe, FirstName, Name, Mail, DateOfBirth, Country, City, LoveSituation, ProfilPictureFile) VALUES 
	(3, "Neeko", "heyaaa", "F", "Neeko", "Oovi", "neeko@gmail.com", "2018-12-05", "Oovi-Kat Island", "City", "Celibataire", "wp4491879.webp"), 
	(4, "Hornet", "Silksong", "F", "Hornet", "Hollow", "Hornet@next.com", "2017-03-17", "Hallownest", "Vertchemin", "Celibataire", "wp4377292.webp");

INSERT INTO Account (IdAccount, Pseudo, Password, Sexe, FirstName, Name, Mail, DateOfBirth, Country, City, Street, AdressNumber, LoveSituation, Species, HumanoidGauge, WelcomeMessage) VALUES 
	(2, "Legolas64", "leffff", "M", "Legolas", "Elfe", "legolaslelfedu64@gmail.com", "103-07-09", "Terre du milieu", "Stilgard", "Avenue du Palais", 3, "Celibataire", "Elfe", 9, "Coucou, je suis Legolas :)");

INSERT INTO Admin (IdAccount) VALUES
	(1);

INSERT INTO Image (IdAccount, IdImg, ImgFile) VALUES
	(2, 1, "Legolas_greenleaf_orlando_bloom_lotr_by_push_pulse-d5vcniw.webp");

INSERT INTO Contact (IdAsker, IdAccount, Approval) VALUES
	(1,2,TRUE),
	(2,3,TRUE),
	(1,3,TRUE),
	(4,2,NULL);

INSERT INTO Message (IdSender, IdRecipient, DateSend, Content) VALUES
	(3, 2, "2024-04-11 17:42:27", "La beauté brille de l'intérieur, là où le cœur danse."),
	(3, 2, "2024-04-11 17:43:59", "Je suis normal ! Tout est normal. Rien n'est suspect.");

INSERT INTO ReportAccount (IdReporter, IdAccount) VALUES
	(2,3);

INSERT INTO ReportMsg (IdMessage) VALUES
	(2);
