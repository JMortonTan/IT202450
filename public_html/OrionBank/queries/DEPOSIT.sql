INSERT INTO Transactions (account_src, account_dest, amount, memo) VALUES(:account_src, :account_dest, :amount, "DEPOSIT IN");
INSERT INTO Transactions (account_src, account_dest, amount, memo) VALUES(:account_dest, :account_src, :negamount, "DEPOSIT OUT");
UPDATE Accounts SET balance = balance + :amount WHERE :account_src = account_number;
UPDATE Accounts SET balance = balance - :amount WHERE :account_dest = account_number;