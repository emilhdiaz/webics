<?php
class Filter extends Object {

	/**
	 * Filter an array based the
	 * @param array $data
	 * @param array $filter
	 * @return unknown_type
	 */
	static public function filterArray( array &$data, $filters ) {
		foreach( a($filters) as $filter ) {
			if( array_key_exists($filter, $data) ) unset($data[$filter]);
		}
	}

	/**
	 * Filter an array based on the keys or the values of nested arrays.
	 *
	 * @param array $data
	 * @param unknown_type $filter
	 * @return unknown_type
	 */
	static public function filterNested( array &$data, $filter ) {
		foreach( $data as $field=>$value ) {
			if( array_key_exists($filter, $value) || in_array($filter, $value) ) {
				unset($data[$field]);
			}
		}
	}

	/**
	 * Collapse an array based a single filter on the keys of nested arrays.
	 *
	 * @param array $data
	 * @param unknown_type $filter
	 * @return unknown_type
	 */
	static public function filterCollapse( array &$data, $filter ) {
		foreach( $data as $field=>$value ) {
			$data[$field] = $value[$filter];
		}
	}

	/**
	 * Merge the nested values of the filter array with the keys of the data array.
	 * @param array $data
	 * @param array $filter
	 * @return unknown_type
	 */
	static public function filterMerge( array &$data, array $filter ) {
		foreach( $data as $field=>$value ) {
			$data[$field] = $filter[$field];
		}
	}
}
?>