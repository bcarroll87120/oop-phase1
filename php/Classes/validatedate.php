<?php

namespace Bcarroll3\AuthorProject;
require_once(dirname(__DIR__, 2) . "/Classes/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * Trait to Validate a mySQL Date
 *
 * This trait will inject a private method to validate a mySQL style date (e.g., 2016-01-15 15:32:48.643216). It will
 * convert a string representation to a DateTime object or throw an exception.
 *
 * @author Brandon Carroll <jcallaway3@cnm.edu>
 **/

trait ValidateDate {
	/**
	 * custom filter for mySQL date
	 *
	 * Converts a string to a DateTime object. This is designed to be used within a mutator method.
	 *
	 * @param \DateTime | string $newDate date to validate
	 * @return \DateTime DateTime object containing the validated date
	 * @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 * @throws \TypeError when type hints fail
	 **/

	private static function validateDate($newDate): \DateTime {
		//Base case: if the date is a DateTime object, there is no work to be done.
		if(is_object($newDate) === true && get_class($newDate) === "DateTime") {
			return ($newDate);
		}
		//Treat the date as a mySQL date string: Y-m-d
		$newDate = trim($newDate);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $newDate, $matches)) !== 1) {
			throw(new \InvalidArgumentException("The date is not a valid date."));
		}
		//Verify the date is really a valid calendar date
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		if(checkdate($month, $day, $year) === false) {
			throw(new \RangeException("The date is not a Gregorian date."));
		}
		//If the date passes all of the previous tests, the date is clean.
		$newDate = \DateTime::createFromFormat("Y-m-d H:i:s", $newDate . " 00:00:00");
		return ($newDate);
	}

	/**
	 * Custom filter for mySQL style dates
	 *
	 * Converts a string to a DateTime object. This is designed to be used within a mutator method.
	 *
	 * @param mixed $newDateTime date to validate
	 * @return \DateTime DateTime object containing the validated name
	 * @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 * @throws \TypeError when the type hints fail
	 * @throws \Exception if some other error occurs
	 **/


	private static function validateDateTime($newDateTime) : \DateTime {
		//Base case: if the date is a DateTime object, there is no work to be done.
		if(is_object($newDateTime) === true && get_class($newDateTime) === "DateTime") {
			return ($newDateTime);
		}
		try {
			list($date, $time) = explode(" ", $newDateTime);
			$date = self::validateDate($date);
			$time = self::validateDate($time);
			list($hour, $minute, $second) = explode(":", $time);
			list($second, $microseconds) = explode(".", $second);
			$date->setTime($hour, $minute, $second, $microseconds);
			return ($date);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * Custom filter for mySQL style times
	 *
	 * Validates a time string. This is designed to be used within a mutator method.
	 *
	 * @param string $newTime time to validate
	 * @return string validate time as a string H:i:s[.u]
	 * @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 **/


	private static function validateTime(string $newTime) : string {
		//Treat the date as a mySQL date string: H:i:s[.u]
		$newTime = trim($newTime);
		if((preg_match("/^(\d{2}):(\d{2}):(\d{2})(?(?=\.)\.(\d{1,6}))$/", $newTime, $matches)) !== 1) {
			throw(new \InvalidArgumentException("The time is not a valid time."));
		}
		//Verify the date is really a valid calendar time
		$hour = intval($matches[1]);
		$minute = intval($matches[2]);
		$second = intval($matches[3]);
		//Verify the time is really a valid wall clock time
		if($hour < 0 || $hour >=24 || $minute < 0 || $minute >=60 || $second < 0 || $second >= 60) {
			throw(new \RangeException("The date is not a valid wall clock time."));
		}
		//Put a placeholder for microseconds if they do not exist
		$microseconds = $matches[4] ?? "0";
		$newTime = "$hour:$minute:$second.$microseconds";
		//If the time passes all of the previous tests, the time is clean.
		return($newTime);
	}
}