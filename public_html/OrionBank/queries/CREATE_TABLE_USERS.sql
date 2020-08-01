CREATE TABLE Users(
    id int AUTO_INCREMENT,
    email varchar(100) NOT NULL UNIQUE,
    `first_name` varchar(100),
    `last_name` varchar(100),
    `password` varchar(60),
    `created` timestamp default current_timestamp,
    `modified` timestamp default current_timestamp on update current_timestamp,
    PRIMARY KEY(id),
)