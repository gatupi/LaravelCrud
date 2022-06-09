create procedure select_customers(
	name varchar(102),
	age_min int,
	age_max int,
	sex_ char(1),
	year_ int,
	month_ int,
	day_ int,
	active_ bool)
begin
	select * from (
		select
			id,
			mask_cpf(cpf) as cpf,
			get_customer_fullname(id) as full_name,
			get_customer_age(id) as age,
			date_format(date_of_birth, '%d/%m/%Y') as date_of_birth,
			upper(sex) as sex,
			active,
			if(inactive_since is null, '-', cast(inactive_since as date)) as inactive_since
		from customers
		where
            deleted_at is null
			and (year_ is null or year(date_of_birth) = year_)
			and (month_ is null or month(date_of_birth) = month_)
			and (day_ is null or day(date_of_birth) = day_)
			and (active_ is null or active_ = active)
	) as q
	where
        (name is null or q.full_name like concat('%', name, '%'))
		and (age_min is null or q.age >= age_min)
		and (age_max is null or q.age <= age_max)
		and (sex_ is null or sex_ = q.sex)
    limit 15;
end