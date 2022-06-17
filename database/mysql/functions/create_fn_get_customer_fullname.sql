create function get_customer_fullname(customer_id INT) returns varchar(102)
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