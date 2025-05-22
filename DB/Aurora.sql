CREATE DATABASE IF NOT EXISTS AuroraDB;
USE AuroraDB;
 

CREATE TABLE Gebruiker (
    Id INT NOT NULL AUTO_INCREMENT,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(10),
    Achternaam VARCHAR(50) NOT NULL,
    Gebruikersnaam VARCHAR(100) NOT NULL,
    Wachtwoord VARCHAR(255) NOT NULL,
    IsIngelogd BIT NOT NULL DEFAULT 0,
    Ingelogd BIT,
    Uitgelogd DATETIME,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    PRIMARY KEY (Id)
) ENGINE=InnoDB;


CREATE TABLE Rol (
    Id INT NOT NULL AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;
 

CREATE TABLE Contact (
    Id INT NOT NULL AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Mobiel VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;
 

CREATE TABLE Medewerker (
    Id INT NOT NULL AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Medewerkersoort VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;


CREATE TABLE Bezoeker (
    Id INT NOT NULL AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Relatienummer MEDIUMINT NOT NULL UNIQUE,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;
 

CREATE TABLE Prijs (
    Id INT NOT NULL AUTO_INCREMENT,
    Tarief DECIMAL(5,2) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    PRIMARY KEY (Id)
) ENGINE=InnoDB;
 

CREATE TABLE Voorstelling (
    Id INT NOT NULL AUTO_INCREMENT,
    MedewerkerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Beschrijving TEXT,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    MaxAantalTickets INT NOT NULL,
    Beschikbaarheid VARCHAR(50) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
) ENGINE=InnoDB;
 

CREATE TABLE Ticket (
    Id INT NOT NULL AUTO_INCREMENT,
    BezoekerId INT NOT NULL,
    VoorstellingId INT NOT NULL,
    PrijsId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Barcode VARCHAR(20) NOT NULL UNIQUE,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    Status VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (VoorstellingId) REFERENCES Voorstelling(Id),
    FOREIGN KEY (PrijsId) REFERENCES Prijs(Id)
) ENGINE=InnoDB;
 

CREATE TABLE Melding (
    Id INT NOT NULL AUTO_INCREMENT,
    BezoekerId INT,
    MedewerkerId INT,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Type VARCHAR(20) NOT NULL,
    Bericht VARCHAR(250) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
) ENGINE=InnoDB;