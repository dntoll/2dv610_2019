<?php

class ArrayUtils {

	public function max(array $inputs) {
		$max = PHP_INT_MIN;
		foreach ($inputs as $number) {
			if ($max < $number) {
				$max = $number;
			}
		}
		return $max;
	}
}