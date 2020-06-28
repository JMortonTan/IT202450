CREATE TABLE Accounts(
    /*Internal (Primary Key)*/
    id int AUTO_INCREMENT,
    /*World account is 12 '0's*/
    account_number varchar(12) NOT NULL UNIQUE,
    /*Joined with Users table (Foreign Key)*/
    user_id int,
    /*Value 1: Checking, Value 2: Savings, Value 3: Loan*/
    account_type int(1) default 0,
    opened_date DATETIME default CURRENT_TIMESTAMP,
    balance decimal(12,2) default 0.00,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES Users(id)
)