<?php

if (!function_exists('formatCpf')) {
    function formatCpf(string $cpf): string
    {
        return substr($cpf, 0, 3)
            . '.' . substr($cpf, 3, 3)
            . '.' . substr($cpf, 6, 3)
            . '-' . substr($cpf, 9);
    }
}

if (!function_exists('hideCpf')) {
    function hideCpf(string $cpf): string
    {
        return '***.' . substr($cpf, 3, 3) . '.***-' . substr($cpf, 9);
    }
}

if (!function_exists('getDateParts')) {
    function getDateParts(string $date): array // Y-m-d format, returns ['year'=>, 'month'=>, 'day'=>]
    {
        $parts = explode('-', $date);
        return ['year' => (int)$parts[0], 'month' => (int)$parts[1], 'day' => (int)$parts[2]];
    }
}

if (!function_exists('calculateAge')) {
    function calculateAge(string $date): int // Y-m-d format
    {
        $birth = getDateParts($date);
        $current = getDateParts(date('Y-m-d'));
        $year_diff = $current['year'] - $birth['year'];
        $month_diff = $current['month'] - $birth['month'];
        $day_diff = $current['day'] - $birth['day'];

        return $year_diff - ($month_diff < 0 || ($month_diff == 0 && $day_diff < 0));
    }
}

if (!function_exists('cpfIsValid')) {
    function cpfIsValid(string $cpf): bool
    {
        return is_numeric($cpf) && strlen($cpf) == 11;
    }
}

if (!function_exists('columnOrder')) {
    function columnOrder(string $indexOrder, array $columns): string {
        $parts = explode(':', $indexOrder);
        $d = $parts[1] ?? 'a';
        $dir = null;
        if ($d == 'a')
            $dir = 'asc';
        else if ($d == 'd')
            $dir = 'desc';
        else
            throw new \Exception("Order indicator must be 'a' or 'd'! It was " . $d);
        return $columns[(int)$parts[0]] . " $dir";
    }
}

if (!function_exists('buildOrderBy')) {
    function buildOrderBy(string $order, array $columns): string // params ex: '0:a,1:d,4:a,3:d' e ['name', 'age', 'sex', 'email', 'phone']
    {
        $orderBy = 'order by ';
        $parts = explode(',', $order);
        $total = count($parts);
        for($i=0; $i<$total-1; $i++) {
            $colOrder = columnOrder($parts[$i], $columns);
            $orderBy .= "$colOrder, ";
        }
        $orderBy .= columnOrder($parts[$total-1], $columns);
        return $orderBy;
    }
}

if (!function_exists('adjustMonth')) {
    function adjustMonth(int $month) {
        return isset($month) ? ($month < 1 ? 1 : ($month > 12 ? 12 : $month)) : 1;
    }
}