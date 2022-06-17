

create function mask_cpf(cpf char(11)) returns char(14)
begin
	return concat('***.', substring(cpf, 3, 3), '.***-', substring(cpf, 10));
end
drop function mask_cpf;

create function validate_interval(interval_ varchar(100)) returns bool
begin
	set @pattern = '^(\\[|\\])-?[0-9]+(\\.[0-9]+)?,-?[0-9]+(\\.[0-9]+)?(\\[|\\])$';
	return (select interval_ regexp @pattern);
end

drop function validate_interval;

create function is_in_interval(interval_ varchar(100), number_ double) returns bool
begin
	if validate_interval(interval_) then
		set @part1 = substring_index(interval_, ',', 1);
		set @part2 = substring_index(interval_, ',', -1);
		set @min_ = cast(substring(@part1, 2) as double);
		set @max_ = cast(substring(@part2, 1, length(@part2) - 1) as double);
		set @op = concat(substring(interval_, 1, 1), substring(interval_, length(interval_)));
	
		set @ret = (case @op
			when '[[' then
				number_ >= @min_ and number_ < @max_
			when ']]' then
				number_ > @min_ and number_ <= @max_
			when '[]' then
				number_ >= @min_ and number_ <= @max_
			when '][' then
				number_ > @min_ and number_ < @max_
			else
				false
		end);
	
		return @ret;
	end if;
	return false;
end;

drop function is_in_interval;
select is_in_interval (']10,19.99]', 19.99);
	
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
			if(active = 1, 'true', 'false') as active,
			if(inactive_since is null, '-', cast(inactive_since as date)) as inactive_since
		from customers
		where
			(year_ is null or year(date_of_birth) = year_)
			and (month_ is null or month(date_of_birth) = month_)
			and (day_ is null or day(date_of_birth) = day_)
			and (active_ is null or active_ = active)
	) as q
	where
		(name is null or q.full_name like concat('%', name, '%'))
		and (age_min is null or q.age >= age_min)
		and (age_max is null or q.age <= age_max)
		and (sex_ is null or sex_ = q.sex);
end
drop procedure if exists select_customers;

call select_customers(null, null, null, null, null, null, null, null);

select validate_interval(']-0.123,-9.123123123[');
select cast(substring(substring_index('[-0.123,9.123123123[', ',', 1), 2) as double),
	cast(substring(substring_index('[-0.123,9.123123123[', ',', -1), 1, length('9.123123123[') - 1) as double);

select cast('-0.123' as double), length('[-0.123,9.123123123[');

select 0.123 > -1;

desc customers;
select * from customers;
update customers set active = false, inactive_since = now() where id > 10;
