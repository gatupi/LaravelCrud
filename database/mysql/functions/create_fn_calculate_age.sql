create function calculate_age(date_ DATE) returns int
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