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
    status ENUM('Not Delivered','Delivered'),
    client_id int,
    FOREIGN KEY (client_id) REFERENCES Clients(id)
);
CREATE TABLE Paiements(
	id int AUTO_INCREMENT PRIMARY KEY,
    montant float,
    status ENUM('Paid','Unpaid'),
    datePaiment Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    commande_id int,
    type ENUM('Paypal','CarteBancaire','Virement'),
    FOREIGN KEY (commande_id) REFERENCES Commandes(id)
);

CREATE TABLE Virements(
    paiement_id int PRIMARY KEY,
    FOREIGN KEY(paiement_id) REFERENCES Paiements(id),
	rib varchar(24)
);

CREATE TABLE Paypals(
    paiement_id int PRIMARY KEY,
    FOREIGN KEY(paiement_id) REFERENCES Paiements(id),
	paymentEmail varchar(255),
    paymentPassword varchar(255)
);

CREATE TABLE CarteBancaires(
    paiement_id int PRIMARY KEY,
    FOREIGN KEY(paiement_id) REFERENCES Paiements(id),
	creditCardNumber varchar(19)
);


INSERT INTO Clients (name, email) VALUES 
('James Miller', 'james.miller@example.com'),
('Jennifer Lee', 'jennifer.lee@example.com'),
('Thomas Clark', 'thomas.clark@example.com');
/* =======================
   Commandes
   ======================= */
INSERT INTO Commandes (montantTotal, status, client_id) VALUES
(120.00, 'Delivered', 1),
(450.75, 'Not Delivered', 1),
(999.99, 'Delivered', 2),
(60.50, 'Delivered', 3),
(2100.00, 'Not Delivered', 3);

/* =======================
   Paiements
   ======================= */
INSERT INTO Paiements (montant, status, commande_id, type) VALUES
(120.00, 'Paid', 4, 'CarteBancaire'),
(450.75, 'Unpaid', 5, 'Paypal'),
(999.99, 'Paid', 6, 'Virement'),
(60.50, 'Paid', 7, 'Paypal'),
(2100.00, 'Unpaid', 8, 'CarteBancaire');

/* =======================
   Carte Bancaires
   ======================= */
INSERT INTO CarteBancaires (paiement_id, creditCardNumber) VALUES
(1, '4242424242424242'),
(3, '5555555555554444');

/* =======================
   Paypals
   ======================= */
INSERT INTO Paypals (paiement_id, paymentEmail, paymentPassword) VALUES
(2, 'paypal.james2@example.com', 'hashed_pwd_001'),
(5, 'paypal.thomas@example.com', 'hashed_pwd_002');

/* =======================
   Virements
   ======================= */
INSERT INTO Virements (paiement_id, rib) VALUES
(4, 'MA6401151900000987654321');
