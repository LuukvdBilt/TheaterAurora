DROP DATABASE IF EXISTS AuroraDB;
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

INSERT INTO Gebruiker (
    Voornaam,
    Tussenvoegsel,
    Achternaam,
    Gebruikersnaam,
    Wachtwoord,
    IsIngelogd,
    Isactief,
    Datumaangemaakt,
    Datumgewijzigd
)
VALUES
('Sophie', NULL, 'Jansen', 'sophiej', 'Tulpen98!', 0, 1, NOW(6), NOW(6)),
('Mark', 'de', 'Vries', 'markdevries', 'Storm21#', 0, 1, NOW(6), NOW(6)),
('Anna', NULL, 'Bakker', 'annab', 'Zomer2024$', 0, 1, NOW(6), NOW(6)),
('Tom', NULL, 'Smit', 'tommyboy', 'Fiets_73', 0, 1, NOW(6), NOW(6)),
('Lotte', 'van', 'Dijk', 'lotte.vdijk', 'Boswandeling55', 0, 1, NOW(6), NOW(6));

 
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

INSERT INTO Gebruiker (
    Voornaam,
    Tussenvoegsel,
    Achternaam,
    Gebruikersnaam,
    Wachtwoord,
    IsIngelogd,
    Isactief,
    Datumaangemaakt,
    Datumgewijzigd
)
VALUES (
    'Admin',
    NULL,
    'User',
    'adminuser',
    'securepasswordhash',
    0,
    1,
    NOW(6),
    NOW(6)
);

INSERT INTO Medewerker (
    GebruikerId,
    Nummer,
    Medewerkersoort,
    Isactief,
    Opmerking,
    Datumaangemaakt,
    Datumgewijzigd
)
VALUES (
    1,
    1001,
    'Manager',
    1,
    'Hoofd van het theater',
    NOW(6),
    NOW(6)
);
 
 

 
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

INSERT INTO Bezoeker (
    GebruikerId,
    Relatienummer,
    Isactief,
    Opmerking,
    Datumaangemaakt,
    Datumgewijzigd
)
VALUES
(2, 2001, 1, 'Standaard bezoeker', NOW(6), NOW(6)),
(3, 2002, 1, 'Trouwe bezoeker', NOW(6), NOW(6)),
(4, 2003, 1, 'Komt vaak met familie', NOW(6), NOW(6)),
(5, 2004, 1, 'Studententarief', NOW(6), NOW(6)),
(6, 2005, 1, 'Nieuw lid via nieuwsbrief', NOW(6), NOW(6));

 
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
    AfbeeldingUrl VARCHAR(255),
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
 
 INSERT INTO Voorstelling (
    MedewerkerId,
    Naam,
    Beschrijving,
    AfbeeldingUrl,
    Datum,
    Tijd,
    MaxAantalTickets,
    Beschikbaarheid,
    Isactief,
    Opmerking,
    Datumaangemaakt,
    Datumgewijzigd
)
VALUES 
(
    1,
    'Theatervoorstelling: De Avondval',
    'Een spannende theateravond over het mysterie van de Avondval.',
    '../images/avondval.png',
    '2025-06-20',
    '20:00:00',
    150,
    'Beschikbaar',
    1,
    'Première voorstelling',
    NOW(6),
    NOW(6)
),
(
    1,
    'Comedy Night: Lachstorm',
    'Een avond vol humor met top cabaretiers.',
    '../images/lachstorm.png',
    '2025-06-21',
    '21:00:00',
    120,
    'Beschikbaar',
    1,
    'Met gratis drankje',
    NOW(6),
    NOW(6)
),
(
    1,
    'Muziekavond: Jazz en Meer',
    'Live jazzoptredens van lokale artiesten.',
    '../images/jazz.png',
    '2025-06-22',
    '19:30:00',
    100,
    'Beschikbaar',
    1,
    'Intieme setting',
    NOW(6),
    NOW(6)
),
(
    1,
    'Kindervoorstelling: De Droomboom',
    'Een magisch verhaal voor kinderen van 4 tot 10 jaar.',
    '../images/droomboom.png',
    '2025-06-23',
    '14:00:00',
    80,
    'Beschikbaar',
    1,
    'Inclusief kleurplaat',
    NOW(6),
    NOW(6)
),
(
    1,
    'Dansshow: Ritmes van de Wereld',
    'Een kleurrijke dansvoorstelling met internationale invloeden.',
    '../images/ritmes.png',
    '2025-06-24',
    '20:30:00',
    200,
    'Beschikbaar',
    1,
    'Speciale gastoptreden',
    NOW(6),
    NOW(6)
),
(
    1,
    'Filmavond: Klassiekers in het Theater',
    'Vertoning van een filmklassieker op groot scherm.',
    '../images/filmklassieker.png',
    '2025-06-25',
    '19:00:00',
    130,
    'Beschikbaar',
    1,
    'Introductie door filmkenner',
    NOW(6),
    NOW(6)
);



 
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

INSERT INTO Melding (
    BezoekerId,
    MedewerkerId,
    Nummer,
    Type,
    Bericht,
    Isactief,
    Opmerking,
    Datumaangemaakt,
    Datumgewijzigd
)
VALUES
(2, NULL, 3001, 'Feedback', 'De voorstelling was prachtig! Mooie belichting en decor.', 1, 'Positieve feedback', NOW(6), NOW(6)),
(3, NULL, 3002, 'Ervaring', 'Heel gezellig, maar het geluid mocht wat harder.', 1, 'Geluid niet optimaal', NOW(6), NOW(6)),
(4, NULL, 3003, 'Feedback', 'Kindervoorstelling was erg leuk voor mijn dochter van 6.', 1, 'Ouders met kinderen', NOW(6), NOW(6)),
(5, NULL, 3004, 'Ervaring', 'Ik vond het lastig om parkeergelegenheid te vinden.', 1, 'Parkeerprobleem', NOW(6), NOW(6)),
(6, NULL, 3005, 'Feedback', 'Goede organisatie en fijne sfeer in het theater.', 1, 'Algemene tevredenheid', NOW(6), NOW(6));