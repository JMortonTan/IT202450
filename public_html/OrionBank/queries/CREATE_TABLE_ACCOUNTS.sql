CREATE TABLE Accounts(
    id int AUTO_INCREMENT,
    account_number varchar(12) NOT NULL UNIQUE,
    user_id int,
    account_type int(1) default 0,
    opened_date DATETIME default CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES Users(id)
)