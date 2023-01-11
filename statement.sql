DROP DATABASE IF EXISTS Exmane_restaurant;
CREATE DATABASE Exmane_restaurant;

USE Exmane_restaurant;

CREATE TABLE gerechtcategorien(
    ID INT NOT NULL AUTO_INCREMENT,
    Code VARCHAR(255),
    Naam VARCHAR(255),
    PRIMARY KEY(ID)
);

CREATE TABLE gerechtsoorten(
    ID INT NOT NULL AUTO_INCREMENT,
    Code VARCHAR(255) ,
    Naam VARCHAR(255) ,
    Gerechtcategorie_ID INT NOT NULL,
    PRIMARY KEY(ID),
    FOREIGN KEY (Gerechtcategorie_ID) REFERENCES gerechtcategorien(ID)
);

CREATE TABLE menuitems(
    ID INT NOT NULL AUTO_INCREMENT,
    Code VARCHAR(255),
    Naam VARCHAR(255),
    Gerechtsoort_ID INT NOT NULL,
    Prijs DECIMAL(10,2);
    PRIMARY KEY(ID),
    FOREIGN KEY (Gerechtsoort_ID) REFERENCES gerechtsoorten(ID)
);

CREATE TABLE klanten (
	ID INT NOT NULL AUTO_INCREMENT,
    Naam VARCHAR(255) NOT NULL,
    Telefoon INT NOT NULL,
    Email VARCHAR(255) NOT NULL,
    PRIMARY KEY(ID)
);

CREATE TABLE reserveringen(
    ID INT NOT NULL AUTO_INCREMENT,
    Tafel INT NOT NULL,
    Klant_ID INT NOT NULL,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    Aantal INT NOT NULL,
    Status TINYINT NOT NULL DEFAULT 1,
    Datum_toegevoegd TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Aantal_k INT NOT NULL DEFAULT 0,
    Allergieen TEXT,
    Opmerkingen TEXT,
    PRIMARY KEY(ID),
    FOREIGN KEY (Klant_ID) REFERENCES klanten(ID)
);

CREATE TABLE bestellingen(
    ID INT NOT NULL AUTO_INCREMENT,
    Reservering_ID INT NOT NULL,
    Menuitems_ID INT NOT NULL,
    Aantal VARCHAR(255),
    Geserverd TINYINT DEFAULT 0,
    Gerechtsoort_ID INT NOT NULL,
    PRIMARY KEY(ID),
    FOREIGN KEY (Reservering_ID) REFERENCES reserveringen(ID),
    FOREIGN KEY (Menuitems_ID) REFERENCES menuitems(ID)
);