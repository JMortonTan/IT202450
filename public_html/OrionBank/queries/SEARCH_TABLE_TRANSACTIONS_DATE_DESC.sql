SELECT * FROM Transactions WHERE account_src = :account_number AND cast(date as date) BETWEEN :startdate AND :enddate;
