drop database inventory;
create database inventory;
use inventory;

create table item (
	ID int not null AUTO_INCREMENT,
	name varchar(50) not null,
	description varchar(300),
	size varchar(20),
	img_url varchar(100) not null,
	primary key (ID)
);


create table order_ (
	ID int not null AUTO_INCREMENT,
	dt datetime not null,
	primary key (ID)
);


create table includes (
	I_ID int not null,
	O_ID int not null,
	Quantity int not null,
	primary key (I_ID, O_ID),
	foreign key (I_ID) references item (ID) on delete cascade,
	foreign key (O_ID) references order_ (ID) on delete cascade
);


insert into item values 
	(null,"Hair spray 1","Spray for hair","300 mL","default-product.jpg"), 
	(null,"Hair spray 2","Spray for hair","400 mL","default-product.jpg"),
	(null,"Hair spray 3","Spray for hair","500 mL","default-product.jpg"), 
	(null,"Hair spray 4","Spray for hair","600 mL","default-product.jpg"), 
	(null,"Hair spray 5","Spray for hair","700 mL","default-product.jpg"), 
	(null,"Hair spray 6","Spray for hair","800 mL","default-product.jpg"); 

insert into order_ values 
	(null, NOW());

insert into includes values 
	(1,1,4);
