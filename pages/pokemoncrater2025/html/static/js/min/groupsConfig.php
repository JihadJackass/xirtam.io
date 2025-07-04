<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

return array(
    // 'js' => array('//js/file1.js', '//js/file2.js'),
    // 'css' => array('//css/file1.css', '//css/file2.css'),

	'js' => array(
		'//js/min/js/jquery-1.8.0.min.js',

		'//js/min/js/lib.BinaryHeap.js',
		'//js/min/js/lib.AStarSearch.js',
		'//js/min/js/lib.QueryString.js',

		'//js/min/js/pv.functions.js',
//		'//js/min/js/pv.map.js',

		'//js/min/js/data.Maps.js',
	),
);