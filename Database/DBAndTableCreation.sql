DROP DATABASE IF EXISTS syspaiement ;
CREATE DATABASE syspaiement;
USE syspaiement;

CREATE TABLE Clients(
	id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(255),
    email varchar(190) UNIQUE
);

CREATE TABLE Commandes(
	id int AUTO_INCREMENT PRIMARY KEY,
    montantTotal float,
    status ENUM('Pending','Out for Delivery','Delivered'),
    client_id int,
    FOREIGN KEY (client_id) REFERENCES Clients(id)
);
CREATE TABLE Paiements(
	id int AUTO_INCREMENT PRIMARY KEY,
    montant float,
    status ENUM('Paid','Unpaid'),
    datePaiment Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    commande_id int,
    FOREIGN KEY (commande_id) REFERENCES Commandes(id)
);

CREATE TABLE Virements(
    paiment_id int,
    FOREIGN KEY(paiment_id) REFERENCES Paiements(id),
	rib varchar(24)
);

CREATE TABLE Paypals(
    paiment_id int,
    FOREIGN KEY(paiment_id) REFERENCES Paiements(id),
	paymentEmail varchar(255),
    paymentPassword varchar(255)
);

CREATE TABLE CarteBancaires(
    paiment_id int,
    FOREIGN KEY(paiment_id) REFERENCES Paiements(id),
	creditCardNumber varchar(19)
);


