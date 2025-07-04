<?php
include '/var/www/html/pv_connect_to_db.php';

if (!function_exists('json_encode')) {
    function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
}

$qu = isset($_GET['q']) ? $_GET['q'] : 'tt';
switch ($qu) {
	default:
	case 'tt':
		$q = mysql_query('select m.id, m.username, m.battle, m.btime, m.ip, o.server, p.exp as s1exp
			from members m
			join pokemon p on p.id = m.s1
			left join online o on m.id = o.id
			order by m.points desc
			limit 100');
		break;
	case 'mb':
		$q = mysql_query('select m.id, m.username, m.battle, m.btime, m.ip, o.server, p.exp as s1exp
			from members m
			join pokemon p on p.id = m.s1
			join online o on m.id = o.id
			where o.server = "mobile"
			order by m.points desc');
		break;
	case 'ab':
		$q = mysql_query('select m.id, m.username, m.battle, m.btime, m.ip, o.server, p.exp as s1exp
			from members m
			join pokemon p on p.id = m.s1
			left join online o on m.id = o.id
			where m.btime >= (UNIX_TIMESTAMP()-60)');
		break;
}

$rows = array();
while (($row = mysql_fetch_object($q)) !== false) {
 $rows[] = $row;
}

header('Content-Type: application/json');
print(json_encode($rows));
exit;