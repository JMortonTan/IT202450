INSERT INTO Transactions (account_src, account_dest, amount, memo, total) VALUES(:account_dest, :account_src, :negamount, "WITHDRAW OUT", :new_world_balance);
INSERT INTO Transactions (account_src, account_dest, amount, memo, total) VALUES(:account_src, :account_dest, :amount, "WITHDRAW IN", :new_balance);
UPDATE Accounts SET balance = balance - :amount WHERE :account_src = account_number;
UPDATE Accounts SET balance = balance + :amount WHERE :account_dest = account_number;