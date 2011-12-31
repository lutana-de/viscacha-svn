<?php
/**
 * Implementation of the stack data structure.
 *
 * A stack is a LIFO (Last In First Out) data structure.
 *
 * @package		Core
 * @subpackage	Util
 * @author		Matthias Mohr
 * @since 		1.0
 * @static
 */
class Stack {
	/**
	 * The Stack data
	 * @var array
	 */
	private $stack;

	/**
	 * Constructs an Stack object.
	 *
	 * When a stack is first created, it contains no items.
	 */
	public function __construct() {
		$this->stack = array();
	}

	/**
	 * Pushs the element onto the stack.
	 *
	 * @param mixed The element to be pushed onto the stack.
	 */
	public function push($element) {
		array_push($this->stack, $element);
	}

	/**
	* Removes the element at the top of this stack and returns that element.
	*
	* Returns null if the stack is empty.
	*
	* @returns mixed The element at the top of this stack or null.
	*/
	public function pop() {
		if ($this->isEmpty() == true) {
			return null;
		}
		$element = $this->top();
		array_pop($this->stack);
		return $element;
	}

	/**
	* Returns the object at the top of this stack without removing it from the stack.
	*
	* Returns null if the stack is empty.
	*
	* @returns mixed The element at the top of this stack or null.
	*/
	function top() {
		if ($this->isEmpty() == true) {
			return null;
		}
		else {
			$count = count($this->stack);
			return $this->stack[$count-1];
		}
	}

	/**
	 * Tests if this stack is empty.
	 *
	 * @return boolean TRUE if and only if this stack contains no items, FALSE otherwise.
	 */
	public function isEmpty() {
		return (count($this->stack) == 0);
	}

	/**
	 * Returns the lenght of the Stack.
	 *
	 * @returns int The lenght of the Stack.
	 */
	public function getLength() {
		return count($this->stack);
	}

	/**
	 * Returns the stack as an enumerated array.
	 *
	 * The element at the top has the highest key and the element first added to the stack has the key 0.
	 * If the parameter is set to TRUE the whole array is reversed before it is returned.
	 * The array pointer is at the element with the key 0.
	 *
	 * @param boolean Set this to TRUE ro reverse the whole stack. Default is false.
	 * @returns array Stack representing the array
	 */
	public function getArray($reverse = false) {
		$stack = $this->stack;
		if ($reverse == true) {
			$stack = array_reverse($this->stack);
		}
		else {
			$stack = array_merge($this->stack);
		}
		reset($stack);
		return $stack;
	}
}
?>