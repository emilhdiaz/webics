<?php
class DatabaseSQL {

	static private $operators = array							// operator map
			(
				'=='	=> '= ?',
				'!='	=> '!= ?',
				'<='	=> '<= ?',
				'>='	=> '>= ?',
				'<<' 	=> '< ?',
				'>>'	=> '> ?',
//				'<%'	=> "LIKE '%'||?",
//				'>%' 	=> "LIKE ?||'%'",
//				'%%'	=> "LIKE '%'||?||'%'",
				'%%'	=> 'LIKE ?',
				'!%'	=> 'NOT LIKE ?',
				'__'  	=> 'IS NULL',
			);
	static private $junctions = array							// junction map
			(
				'&&'	=> 'AND',
				'||'	=> 'OR'
			);

	static private $directions = array
			(
				'^'		=>'ASC',
				'v'		=>'DESC'
			);

	final static public function build($type, array $options)
	{
		is_array($options) and extract($options);

		#- Assemble Main Clause -#
		switch ($type)
		{
			case 'select':
				$sql  	= 'SELECT '.self::DT('select', $args).' FROM '.$table;

				break;

			case 'insert':
				$sql 	= 'INSERT INTO '.$table.'('.self::DT('insert1', array_keys($args)).')'.' VALUES '.'('. self::DT('insert2', $args).')';
				break;

			case 'update':
				$sql  	= 'UPDATE '.$table.' SET '.self::DT('update', $args);
				break;

			case 'delete':
				$sql    = 'DELETE FROM '.$table;
				break;

			case 'all':
				$sql	= 'SELECT * FROM '.$table;
				break;

			case 'count':
				$sql	= 'SELECT COUNT(\'*\') FROM '.$table;
				break;

			case 'max':
				$sql	= 'SELECT '.self::DT('max', $args).' FROM '.$table;
				break;

			case 'min':
				$sql	= 'SELECT '.self::DT('min', $args).' FROM '.$table;
				break;

			case 'exist':
				$sql	= 'SELECT 1 FROM '.$table;
				break;

				default:
				throwError('QUERY_TYPE_NOT_SUPPORTED');
				break;
		}
		#- Add INNER JOIN Clause -#
		if(isset($inner))
		{
			$sql .= ' INNER JOIN ('.self::DT('join', $inner).')';
		}

		#- Add LEFT JOIN Clause -#
		if(isset($left))
		{
			$sql .= ' LEFT JOIN ('.self::DT('join', $left).')';
		}

		#- Add RIGHT JOIN Clause -#
		if(isset($right))
		{
			$sql .= ' RIGHT JOIN ('.self::DT('join', $right).')';
		}

		#- Add ON Clause -#
		if(isset($on))
		{
			$sql .= ' ON ('.self::DT('on', $on).')';
		}

		#- Add WHERE Clause -#
		if(isset($where))
		{
			$sql .= ' WHERE ('.self::DT('where', $where).')';
		}

		#- Add GROUP BY Clause -#
		if(isset($group))
		{
			$sql .= ' GROUP BY '.self::DT('group', $group);
		}

		#- Add ORDER Clause -#
		if(isset($order))
		{
			$sql .= ' ORDER BY '.self::DT('order', $order);
		}

		#- Add LIMIT Clause -#
		if(isset($limit))
		{
			$sql .= ' LIMIT '.$limit[0].' , '.$limit[1];
		}

		#- Add line end delimiter -#
		//$sql .= '; ';

		return $sql;
	}

	final static private function DT($type, array $data)
	{
		#- Assemble Query String -#
		$keys = array_keys($data);
		$end_key = array_pop($keys);

		$sql = '';

		foreach($data as $key => $value)
		{
			// convert String class
			$value = new String((string) $value);
			$func_indicator = new String(';');
			$is_function  = !$value->isEmpty() ? $value->ends($func_indicator)->bool() : false;
			if ( $is_function ) $function = $value->before($func_indicator);

			switch ($type)
			{
				case 'select':
					$sql .= $value;
					$sql .= ($key != $end_key) ? ', ' : '';
					break;

				case 'insert1':
					$sql .= $value;
					$sql .= ($key != $end_key) ? ', ' : '';
					break;

				case 'insert2':
					// check for function
					$sql .= ($is_function) ?  $function : '?';
					$sql .= ($key != $end_key) ? ', ' : '';
					break;

				case 'update':
					// check for function
					$sql .= $key.' = '. (($is_function) ? $function : '?');
					$sql .= ($key != $end_key) ? ', ' : '';
					break;

				case 'max':
					$sql .= ($key == $end_key) ? 'MAX('.$key.') ' : $key.', ';
					break;

				case 'min':
					$sql .= ($key == $end_key) ? 'MIN('.$key.') ' : $key.', ';
					break;

				case 'order':
					$direction = $value->pop(new Integer(1))->str();
					if( !array_key_exists($direction, self::$directions) ) throw new InvalidValueException("direction = $direction");

					$sql .= $field.' '.self::$directions[$direction];
					$sql .= ($key != $end_key) ? ', ' : '';
					break;

				case 'group':
					$sql .= $value;
					$sql .= ($key != $end_key) ? ', ' : '';
					break;

				case 'join':
					#$sql .= $value['table'];
					#$sql .= ($key != $end_key) ? ', ' : '';
					break;

				case 'on':
					#$sql .= $value['table1'].'.'.$value['field1'].' = '.$value['table2'].'.'.$value['field2'];
					#$sql .= ($key != $end_key) ? " AND " : "";
					break;

				case 'where':
					$operator = $value->shift(new Integer(2))->str();
					$junction = $value->pop(new Integer(2))->str();
					if( !array_key_exists($operator, self::$operators) ) throw new InvalidValueException("operator = $operator");
					if( !array_key_exists($junction, self::$junctions) ) throw new InvalidValueException("junction = $junction");

					$sql .= $key.' '.self::$operators[$operator];
					$sql .= ($key != $end_key) ?  ' '.self::$junctions[$junction].' ' : '';
					break;
			}
		}
		return $sql;
	}
}
?>