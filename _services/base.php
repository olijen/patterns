<?php

function load($path) {
	if (is_array($path)) {
		foreach ($path as $k => $p) {
			require $p . '.php';
		}
		return;
	}
	require $path . '.php';
}

function d($text, $key = false) {
	echo '<hr />';
	echo ($key) ? $key : '';
	var_dump($text);
	echo '<hr />';
}