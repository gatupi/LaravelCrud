create function get_customer_age(customer_id INT) returns int
begin
	return calculate_age((select date_of_birth from customers where id = customer_id limit 1));
end