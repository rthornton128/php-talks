<?php

/**
 * At some point in the history of PHP, array parameters were possibly
 * copied when a function was called and when passed to a function. Copying
 * involves allocating space in memory for the array and copying over the
 * values one by one.
 *
 * As you may have guessed, copying isn't exactly fast so if the interpreter
 * can cheat it will. In modern PHP, arrays are passed by reference whether
 * you request it or not. However, there exists a semantic whereby the copying
 * happens when you attempt to write to an array that has been passed by
 * value.
 *
 * A reference is an implicit pointer. Pointers are variables that contain
 * memory addresses. They 'point to' an address in memory. This makes
 * accessing an array much faster because rather than copying the array
 * you can access it directly. As long as you don't write to the array,
 * a copy operation never happens and things can speed right along.
 *
 * In this example, an array is passed into the function. Unknown to you,
 * the interpreter passes the array as a reference to avoid copying it.
 * However, when a new value is assigned to an array the interpreter is
 * forced to create a copy of the array.
 *
 * @param array $arr
 * @return array
 */
function pass_by_value(array $arr) {
  if (count($arr) == 0) {
    return $arr;
  }

  $arr[] = $arr[count($arr)-1] + 1; // array copied
    return $arr;
}

/**
 * Unlike in the first instance, the array parameter is passed by reference.
 * @param array $arr
 * @return array
 */
function pass_by_reference(array &$arr) {
  if (count($arr) == 0) {
    return $arr;
  }

  $arr[] = $arr[count($arr)-1] + 1; // no copy
  return $arr;
}

function create_array($sz) {
  $arr = [];
  for ($i = 0; $i < $sz; ++$i) {
    $arr[] = $i;
  }
  return $arr;
}

function bench(callable $f) {
  for ($i = 0; $i < 10000; ++$i) {
    $f(create_array(10000));
  }
}

bench('pass_by_value');
bench('pass_by_reference');
