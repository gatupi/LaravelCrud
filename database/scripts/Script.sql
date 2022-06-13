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
	
