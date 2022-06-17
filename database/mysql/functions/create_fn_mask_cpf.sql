create function mask_cpf(cpf char(11)) returns char(14)
begin
	return concat('***.', substring(cpf, 4, 3), '.***-', substring(cpf, 10)); /* índice começa em 1 */
end