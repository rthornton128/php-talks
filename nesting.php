<?php

/**
 * There are two things wrong with this function.
 *
 * 1. When you exit early from a function based a conditional, you should omit
 * the the else block. Make it clear that a conditional isn't met and exit,
 * continuing with the body of the function after. This is important when
 * the else clause would be quite long.
 *
 * 2. Never return true/false based on a conditional. This can be simplified
 * by just returning the conditional check.
 *
 * @param int $a
 *   Some number;
 * @param int $b
 *   Some number other;
 * @return bool
 */
function unnecessary_else(int $a , int $b) : bool {
    if ($a === $b) {
        return false;
    } else {
        if ($a > $b) {
            return false;
        }
        return true;
    }
}

/**
 * What this function actually does becomes a lot more clear now. If the
 * condition `$a === $b`isn't met the function returns true. Otherwise, it will
 * continues until it reaches the second condition of `$a > $b`. Again,
 * it exits or continues. There is a stark contrast in clarity between
 * the original function and the revised one with less nesting.
 *
 * @param int $a
 *   Some number;
 * @param int $b
 *   Some number other;
 * @return bool
 */
function unnecessary_else_fix0(int $a , int $b) : bool {
    if ($a === $b) {
        return false;
    }

    if ($a > $b) {
        return false;
    }

    return true;
}

/**
 * This second solution demonstrates how you could just return from the function
 * using the conditional check. By recognising that the function could
 * be simplified, we can cut down the lines of code and improve clarity
 * even further.
 *
 * Often functions are much more complex and simplifications like this aren't
 * always possible but I've seen enough instances of the above logic in
 * produciton code that it makes it worth pointing out.
 *
 * @param int $a
 *   Some number;
 * @param int $b
 *   Some number other;
 * @return bool
 */
function unnecessary_else_fix1(int $a , int $b) : bool {
    return $a < $b;
}

echo "Unnecessary_else" . PHP_EOL;
echo (unnecessary_else(1, 2) ? "true" : "false") . PHP_EOL;
echo (unnecessary_else(2, 2) ? "true" : "false") . PHP_EOL;
echo (unnecessary_else(2, 1) ? "true" : "false") . PHP_EOL;

echo "Unnecessary_else_fix0" . PHP_EOL;
echo (unnecessary_else_fix0(1, 2) ? "true" : "false") . PHP_EOL;
echo (unnecessary_else_fix0(2, 2) ? "true" : "false") . PHP_EOL;
echo (unnecessary_else_fix0(2, 1) ? "true" : "false") . PHP_EOL;

echo "Unnecessary_else_fix1" . PHP_EOL;
echo (unnecessary_else_fix1(1, 2) ? "true" : "false") . PHP_EOL;
echo (unnecessary_else_fix1(2, 2) ? "true" : "false") . PHP_EOL;
echo (unnecessary_else_fix1(2, 1) ? "true" : "false") . PHP_EOL;

/**
 * Take a quick moment to familiarize yourself with this function. Despite
 * being quite trivial, do you know what it does?
 *
 * Ideally, functions should be nested no more than three levels. This
 * example meets that criteria but it is still difficult to understand.
 * While there are instances, like complex algorithms, where understanding
 * a function at a glance will be impossible, most code should be clear
 * enough to understand with a minimal amount of effort.
 *
 * The revised version of this function make that fact abundantly clear.
 * Suddenly, with a bit of abstraction, you can understand what the function
 * and its loop does in a fraction of a second. This goes a long way towards
 * producing clear, bug free, maintainable code.
 */
function nesting_depth() {
    $arr = [0, 1, 2, 3, 4];

    foreach ($arr as $i => $val) {
        if ($i > 0) {
            for ($j = $i; $j < count($arr); ++$j) {
                $arr[$j] ++;
            }
        }
    }

    foreach ($arr as $val) {
        echo $val . ' ';
    }
}

/**
 * Increment array elements by one, starting at the supplied index. If
 * the index is zero, the array is not modified.
 *
 * @param int $i
 *   Index of array to work from
 * @param array $arr
 *   The array to increment
 * @throws OutOfBoundsException
 */
function increment_array_if_index_not_zero(int $i, array &$arr) {
    if ($i > count($arr)) {
        throw new OutOfBoundsException("Index '$i' is larger than array");
    }
    if ($i == 0) {
        return;
    }

    for ($j = $i; $j < count($arr); ++$j) {
        $arr[$j] ++;
    }
}

/**
 * Again, with less nesting and more abstraction, the purpose of this
 * function becomes a lot clearer. Without looking at
 * `increment_array_if_index_not_zero()` it can likely be assumed the
 * function does what it says. You can also read its associated docblock
 * to confirm its behaviour.
 *
 * You now have fewer lines of code to read with more confidence that
 * its functionality is correct (less prone to bugs). Case in point, the
 * function throws and out of bounds error. The call to this function
 * could (should) be wrapped in a try-catch block and nesting it like
 * that is perfectly acceptable as there would only be two levels of
 * nesting.
 */
function nesting_depth_fix0() {
    $arr = [0, 1, 2, 3, 4];

    foreach ($arr as $i => $val) {
        increment_array_if_index_not_zero($i, $arr);
    }

    foreach ($arr as $val) {
        echo $val . ' ';
    }
}

echo "nesting_depth" . PHP_EOL;
nesting_depth();
echo PHP_EOL;
echo "nesting_depth_fix0" . PHP_EOL;
nesting_depth_fix0();
echo PHP_EOL;

/**
 * At first glance, it isn't very clear what this function does or what
 * result it will produce. You need to take a moment, read through all the
 * nested functions, think about what they do until you finally reason
 * out what it does.
 *
 * This particular example isn't very complex but it is based on a real
 * world function used in production.
 *
 * @return int
 */
function nesting_call_depth() : int {
    $arr = [0, 1, 2, 3, 4];
    return array_sum(array_slice(array_slice(array_slice($arr, 2), 1), 0));
}

/**
 * The fixed version of this function contains more lines but it becomes
 * much easier to read. Now it is clear that the first call to `array_slice()`
 * uses offset 2, trimming the array to `[2, 3, 4]`. The second call uses
 * offset 1, trimming the array to `[3, 4]`. The third call effectively does
 * nothing.
 *
 * At that point, you can probably figure out what result `array_sum()` will
 * print.
 *
 * The key here is: don't be clever. Always favour clarity over complexity.
 * Even though this function could be done on a single line it makes it
 * far more confusing to read and thereby becomes the opposite of clever.
 * Essentially, you are obfuscating the code and making it a nightmare for
 * anyone who has to maintain it after you're done writing it. Including
 * yourself.
 *
 * What if there was a bug in your code? Could you unravel the one-liner
 * version easily to find and fix the bug? Or would the multi-line version
 * be easier to debug?
 *
 * @return int
 */
function nesting_call_depth_fix0() : int {
    $arr = [0, 1, 2, 3, 4];
    $arr = array_slice($arr, 2);
    $arr = array_slice($arr, 1);
    $arr = array_slice($arr, 0);
    return array_sum($arr);
}

echo "nesting_call_depth" . PHP_EOL;
echo nesting_call_depth() . PHP_EOL;
echo nesting_call_depth_fix0() . PHP_EOL;
