INSERT INTO Transactions (`account_src`,`account_dest`,`amount`,`memo`) VALUES(:account_src, :account_destination, :amount, "Deposit");
INSERT INTO Transactions (`account_src`,`account_dest`,`amount`,`memo`) VALUES(:account_destination, :account_src, :amount, "Deposit");
UPDATE Accounts SET balance = :new_balance_src WHERE :account_number_src = account_number;
UPDATE Accounts SET balance = :new_balance_dest WHERE :account_number_dest = account_number;