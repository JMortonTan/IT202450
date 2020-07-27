UPDATE Accounts SET balance = :new_balance_src WHERE account_number = :account_number_src;
UPDATE Accounts SET balance = :new_balance_dest WHERE account_number = :account_number_dest;