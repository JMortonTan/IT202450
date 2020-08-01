CREATE TABLE Customers (
    CustomerID int NOT NULL AUTO_INCREMENT,
    LastName varchar(255) NOT NULL,
    FirstName varchar(255) NOT NULL,
    Address varchar(255) NOT NULL,
    ZipCode int(5) NOT NULL,
    Email varchar(255) NOT NULL UNIQUE,
    PRIMARY KEY (CustomerID)
);

CREATE TABLE BankAccounts (
    AccountNumber int NOT NULL UNIQUE,
    CustomerID int,
    AccountType int NOT NULL,
    Balance float NOT NULL,
    PRIMARY KEY (AccountNumber),
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);