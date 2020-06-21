CREATE TABLE Products(
    id int auto_increment,
    name varchar(20) NOT NULL unique,
    quantity int default 0,
    price decimal(10,2) default 0.00,
    description TEXT --Maybe supported by MySQL, generic text field
    modified datetime default current_timestamp on update current_timestamp,
    created datetime default current_timestamp,
    primary key (id)
)