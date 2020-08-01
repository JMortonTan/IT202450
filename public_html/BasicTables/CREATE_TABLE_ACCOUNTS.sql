CREATE TABLE Accounts(
    id int auto_increment, --Internal (Primary Key)
    account_number varchar(12) NOT NULL, --World account is 12 '0's
    user_id int, --Joined with Users table (Foreign Key)
    account_type varchar(20),
    opened_date DATETIME default CURRENT_TIMESTAMP
    balance decimal(12,2) default 0.00
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES Users.id
)