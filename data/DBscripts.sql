DataBase name:  UnderSet


CREATE TABLE Users (
	fName VARCHAR(30) NOT NULL,
    lName VARCHAR(30) NOT NULL,
    username VARCHAR(50) NOT NULL PRIMARY KEY,
    passwrd VARCHAR(50) NOT NULL,
    eMail VARCHAR(50) NOT NULL,
    gender VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL
);



INSERT INTO Users (fName, lName, username, passwrd, eMail, gender, country) VALUES
('Administrador', 'Molinar', 'admin', 'RABUDurd/uQVbtm49UCDUk2E2APVdOkLO/XwJg74jXM=', 'admin@itesm.mx', 'Male', 'Australia'),
('Mario', 'Molinar', 'molinar7', 'CgjhpZVbUzQGiwm+P+y5brlw5a3EwiGj72FDo+iu0Lc=', 'a01186155@itesm.mx', 'Male', 'Mexico');




CREATE TABLE Events (
  ID int(30) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  eName varchar(30) NOT NULL,
  eDate varchar(30) NOT NULL,
  eLocation varchar(30) NOT NULL
) ;


INSERT INTO Events (ID, eName, eDate, eLocation) VALUES
(7, 'Tame Impala', '09/10/2016 ', 'Monterrey'),
(36, 'Solomun', '06/23/2016', 'Los Angeles'),
(37, 'Acid Pauli', '06/08/2016', 'Tulum');

CREATE TABLE Requests (
  ID int(30) NOT NULL,
  eName varchar(30) NOT NULL,
  username varchar(50) NOT NULL,
  cNumber varchar(30) NOT NULL,
  reason text(100) NOT NULL,
  AD tinyint(1) NOT NULL,
  primary key (ID, username)
) 

INSERT INTO Requests (ID, eName, username, cNumber, reason, AD) VALUES
(36, 'Solomun', 'molinar7', '614 103 6060', 'Solomun is one of my favorites underground artists , if my request is accepted i would be the happier person on earth', 0);

