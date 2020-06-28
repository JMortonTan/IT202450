SELECT * FROM Accounts WHERE account_type= (CAST(:search) AS INT);
