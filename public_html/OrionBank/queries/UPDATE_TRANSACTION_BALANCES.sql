UPDATE Accounts SET balance = :new_balance_src WHERE :account_number_src = account_number_src;
UPDATE Accounts SET balance = :new_balance_dest WHERE :account_number_dest = account_number_dest;