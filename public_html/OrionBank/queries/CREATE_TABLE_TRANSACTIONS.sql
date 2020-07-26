CREATE TABLE Transactions(
    id int AUTO_INCREMENT UNIQUE,
    account_src varchar(12) NOT NULL,
    account_dest varchar(12) NOT NULL,
    amount decimal(12,2) NOT NULL,
    memo varchar(9) NOT NULL,
    date timestamp default current_timestamp on update current_timestamp,
    PRIMARY KEY(id),
    FOREIGN KEY(account_src) REFERENCES Accounts(account_number)
)