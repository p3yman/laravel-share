<?php
namespace Peyman3d\Share;


class Share {
	
	/*
	 * Data variable for shared data
	 */
	public $data = [];
	
	/*
	 * Current key for add, edit or remove data
	 */
	public $key = '';
	
	/*
	 * Arg types for simpler manage data
	 */
	protected $args_types   = [
		'id', 'title', 'subtitle', 'label', 'icon',
		'link', 'route', 'route_attributes', 'href', 'fallback', 'callback',
		'order', 'class', 'desc', 'type',
		'default', 'options', 'name', 'placeholder', 'children', 'file', 'src', 'config',
		'active', 'format', 'permission', 'count', 'attributes', 'field', 'blade',
	];
	
	/*
	 * Key types for simpler manage data
	 */
	protected $keys_types   = [
		'menu', 'view', 'asset', 'js', 'css', 'script', 'style',
	];
	
	/**
	 * Share constructor.
	 */
	public function __construct() {
	
	}
	
	/**
	 * Filter call method
	 *
	 * @param $method
	 * @param $arguments
	 *
	 * @return $this
	 */
	public function __call($method, $arguments)
	{
		if(true === in_array($method, $this->args_types)) {
			
			$this->edit($method, $arguments[0]);
			
			return $this;
			
		} elseif(true === in_array($method, $this->keys_types)) {
			
			$this->key = array_first($arguments) ? "$method.$arguments[0]" : $method;
			
			return $this;
			
		}
	}
	
	/**
	 * Return $this for helper function
	 *
	 * @return $this
	 */
	public function this(){
		return $this;
	}
	
	public function done(){
		
		$this->key = '';
		
		return $this;
	}
	
	/**
	 * Set key
	 *
	 * @param $key
	 *
	 * @return $this
	 */
	public function key($key){
		
		$this->key = $key;
		
		return $this;
	}
	
	/**
	 * Add item to data array
	 *
	 * @param $key
	 * @param array $value
	 * @param bool $single
	 *
	 * @return mixed
	 */
	public function make($key, $value = [], $single = false){
		
		$this->key = $this->key && !$single ? "$this->key.$key" : $key;
		
		array_set($this->data, $this->key, $value);
		
		return $this;
		
	}
	
	/**
	 * Make item in key
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public function item($key){
	
		return $this->make($key);
		
	}
	
	/**
	 * Prepend value to array with key
	 *
	 * @param $key
	 * @param array $value
	 *
	 * @return $this
	 */
	public function prepend($key, $value = []){
		
		$this->key .= ".$key";
		
		array_prepend($this->data, $this->key, $value);
		
		return $this;
		
	}
	
	/**
	 * Add child to data array
	 *
	 * @param $id
	 * @param string $child_key
	 * @return $this
	 */
	public function child($id, $child_key = 'children'){
		
		return $this->item("$child_key.$id");
		
	}
	
	/**
	 * Add to data array
	 *
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public function add($key, $value){
		
		array_set($this->data, "$this->key.$key", $value);
		
		return $this;
	}
	
	/**
	 * Edit data array. Alias for add
	 *
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public function edit($key, $value){
		
		return $this->add($key, $value);
		
	}
	
	/**
	 * Check array has key
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public function has($key){
		
		if( $this->key != '' ){
			$key = "$this->key.$key";
		}
		
		return array_has($this->data, $key);
		
	}
	
	/**
	 * Get from array
	 *
	 * @param $key
	 * @param bool $single
	 *
	 * @return mixed
	 */
	public function get($key = null, $single = false){
		
		if( $this->key != '' && $key ){
			$key = "$this->key.$key";
		} elseif (!$key){
			$key = $this->key;
		}
		
		$result = array_get($this->data, $key, null);
		
		return $single ? $result : $this->makeOutput($result);
	}
	
	/**
	 * Get from array and delete from it
	 *
	 * @param null $key
	 * @param bool $single
	 *
	 * @return mixed
	 */
	public function pull($key = null, $single = false){
		
		if( $this->key != '' && $key ){
			$key = "$this->key.$key";
		} elseif (!$key){
			$key = $this->key;
		}
		
		$result = array_pull($this->data, $key, null);
		
		return $single ? $result : $this->makeOutput($result);
		
	}
	
	/**
	 * Get all data from data
	 *
	 * @param bool $order
	 *
	 * @return mixed
	 */
	public function all($order = true){
		
		return $this->makeOutput($this->data, $order);
		
	}
	
	/**
	 * Delete from data array
	 *
	 * @return mixed
	 */
	public function delete(){
		
		array_forget($this->data, $this->key);
		
		return $this;
	}
	
	/**
	 * Reset data and key
	 *
	 * @return $this
	 */
	public function reset(){
		
		$this->data = [];
		$this->key = '';
		
		return $this;
	}
	
	/*
     * Make output
     */
	public function makeOutput($items, $order = true){
		
		if( $order ) {
			$items = shared_data_sort( $items );
		}
		
		return collect($items);
		
	}
	
	/*-----------------------------------------------------------------
	- Helpers
	-----------------------------------------------------------------*/
	/**
	 * Make active key true
	 *
	 * @return mixed
	 */
	public function activate(){
		
		return $this->add('active', true);
	
	}
	
	/**
	 * Make active key false
	 *
	 * @return mixed
	 */
	public function deactivate(){
		
		return $this->add('active', false);
		
	}
}