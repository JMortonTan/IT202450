SELECT * FROM Accounts WHERE user_id LIKE CONCAT('%', :search, '%');
