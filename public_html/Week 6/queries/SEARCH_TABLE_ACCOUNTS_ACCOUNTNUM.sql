SELECT * FROM Accounts WHERE account_number LIKE CONCAT('%', :search, '%');
