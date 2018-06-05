<?php
/**
 * Helper function to load share service
 * @return mixed
 */
function share(){
	return Share::this();
}

/**
 * Sort array by key
 *
 * @param $items
 *
 * @return bool
 */
function shared_data_sort($items){
	
	if( is_array($items) ) {
		uasort($items, 'shared_data_compare_order');
		
		foreach ($items as &$value) {
			if (is_array($value)) {
				$value = shared_data_sort($value);
			}
		}
	}
	
	return $items;
}

/**
 * Compare function
 *
 * @param $a
 * @param $b
 * @return mixed
 */
function shared_data_compare_order($a, $b){
	return array_get($a, 'order', 20) - array_get($b, 'order', 20);
}