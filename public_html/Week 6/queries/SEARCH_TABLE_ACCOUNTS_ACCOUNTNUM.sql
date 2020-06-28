/*SQL auto casted INT to string and back.... something to consider*/
SELECT * FROM Accounts where account_number like CONCAT('%', :search, '%')
