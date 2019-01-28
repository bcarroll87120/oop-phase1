<?php

namespace Bcarroll3\AuthorProject;
/**
 * PSR-4 Compliant Autoloader
 *
 * This file will dynamically load classes by resolving the prefix and class name. This is the method that frameworks
 * such as Laravel and Composer automatically resolve class names and load them. To use it, simply set the
 * configurable parameters inside the closure. This example is taken from PHP-FIG, referenced below.
 *
 * @param string $class fully qualified class name to load
 * @see http://www.php-fig.org/psr/psr-4/examples/ PSR-4 Example Autoloader
 **/
spl_autoload_register(function($class) {
	/*
	 * Configurable Parameters
	 * Prefix: The prefix for all the classes (i.e. the namespace)
	 * baseDir: The base directory for all classes (default = current directory)
	 *
	 **/
	$prefix = "Bcarroll33\\AuthorProject";
	$baseDir = __DIR__;

	//Does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !==0) {
		//If no, move to the next registered autoloader.
		return;
	}

	//Get the relative class name.
	$className = substr($class, $len);

	//Replace the namespace prefix with the base directory, replace the namespace
	//separators with directory separators in the relative class name, append with .php.
	$file = $baseDir . str_replace("\\", "/", $className) . ".php";

	//If the file exists, require it.
	if(file_exists($file)) {
		require_once($file);
	}
});