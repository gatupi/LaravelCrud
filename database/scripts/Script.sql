show tables;
select * from migrations;

insert into customers (cpf, first_name, middle_name, last_name, date_of_birth, sex) values
	('12345678900', 'Gabriel', null, 'Alonso', '1997-12-08', 'm'),
 	('12312312300', 'Mariana', null, 'Malaguti', '2002-05-30', 'f');

insert into products (description, price) values
	('Mouse', 50.0),
	('Teclado mecânico', 180.0),
	('Monitor', 970.0),
	('Placa de vídeo', 3200.0),
 	('M.2 500GB', 690.0),
	('SSD 240GB', 320.0),
	('Notebook', 4560.0);

select * from products;
select * from product_sale;
desc product_sale;

insert into sales(customer_id) values
	((select id from customers where cpf = '12345678900')),
	((select id from customers where cpf = '12312312300'));

insert into product_sales (sale_id, product_id, quantity) values
	(1, 1, 3),
	(1, 4, 2),
	(1, 5, 5),
	(1, 2, 1),
	(2, 1, 7),
	(2, 3, 3),
 	(2, 6, 2),
 	(2, 7, 4),
	(2, 5, 2);

insert into product_sales (sale_id, product_id, quantity) values (1, 1, 3);

select * from sales;
select * from customers;
delete from customers;
select * from product_sales;

select
	c.first_name as customer,
	s.id as sale_id,
	p.description as product,
	ps.quantity as quantity,
	p.price as price,
	ps.quantity * p.price as sub_total
	from
	customers c
	inner join sales s on s.customer_id = c.id
	inner join product_sales ps on ps.sale_id = s.id
	inner join products p on ps.product_id = p.id
	order by customer, sale_id, product;

drop table if exists product_sale;
	
select id, first_name + ' ' + last_name from customers;

create function if not exists get_customer_fullname(customer_id INT) returns varchar(102)
begin
	declare fname varchar(30);
	declare mname varchar(40);
	declare lname varchar(30);

	select first_name, middle_name, last_name
		into fname, mname, lname
		from customers where id = customer_id
		limit 1;

	return concat(fname, if(mname is not null, concat(' ', mname, ' '), ' '), lname);
end

create function if not exists calculate_age(date_ DATE) returns int
begin
	declare today date;
	declare year_diff int;
	declare month_diff int; 
	declare day_diff int;

	set today = now();
	set year_diff = year(today) - year(date_);
	set month_diff = month(today) - month(date_);
	set day_diff = day(today) - day(date_);

	return year_diff - (if(month_diff < 0 or (month_diff = 0 and day_diff< 0), 1, 0));
end

create function if not exists get_customer_age(customer_id INT) returns int
begin
	return calculate_age((select date_of_birth from customers where id = customer_id limit 1));
end



drop function if exists get_customer_fullname;
drop function if exists get_customer_age;
drop function calculate_age;

select
	get_customer_fullname(id) as full_name,
	get_customer_age(id) as age
	from customers;
select cast(now() as date);

select year(now()) - year('1997-12-08');

select * from customers;
delete from customers;
update customers set deleted_at = null;
