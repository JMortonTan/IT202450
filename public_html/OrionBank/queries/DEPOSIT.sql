INSERT INTO Transactions (`account_src`,`account_dest`,`amount`,`memo`) VALUES(:account_src, :account_dest, :amount, "Deposit IN");
INSERT INTO Transactions (`account_src`,`account_dest`,`amount`,`memo`) VALUES(:account_dest, :account_src, :negamount, "Deposit OUT");
UPDATE Accounts SET balance = balance + :amount WHERE :account_number_src = account_number;
UPDATE Accounts SET balance = balance - :amount WHERE :account_number_dest = account_number;