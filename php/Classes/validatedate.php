<?php

namespace Jcallaway3\AuthorProject;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * Trait to validate a UUID
 *
 * This trait will validate a UUID in any of the following three formats
 *
 * 1. Human-readable string (36 bytes)
 * 2. Binary string (16 bytes)
 * 3. Ramsey\Uuid\Uuid object
 *
 * @author Brandon Carroll <bcarroll@live.com>
 **/

trait ValidateUuid {
	/**
	 * Validates a UUID irrespective of the format
	 *
	 * @param string|Uuid $newUuid to validate
	 * @return Uuid object with validated uuid
	 * @throws \InvalidArgumentException if $newUuid is not a valid uuid
	 * @throws \RangeException if $newUuid is not a valid uuid v4
	 **/
	private static function validateUuid($newUuid) {
		//Verify a string uuid
		if(gettype($newUuid) === "string") {
			// Sixteen characters is binary data from mySQL - convert to string and fall to next if block
			if(strlen($newUuid) === 16) {
				$newUuid = bin2hex($newUuid);
				$newUuid = substr($newUuid, 0, 8) . "-" . substr($newUuid, 8, 4) . "-" . substr($newUuid, 12, 4) . "-" . substr($newUuid, 16, 4) . "-" . substr($newUuid, 20, 12);
			}
			//Thirty-six characters is a human-readable uuid
			if(strlen($newUuid) === 36) {
				if(Uuid::isValid($newUuid) === false) {
					throw(new \InvalidArgumentException("Invalid UUID"));
				}
				$uuid = Uuid::fromString($newUuid);
			} else {
				throw(new \InvalidArgumentException("Invalid UUID"));
			}
		} else if(gettype($newUuid) === "object" && get_class($newUuid) === "Ramsey\\Uuid\\Uuid") {
			//If the misquote ID is already a valid UUID, continue.
			$uuid = $newUuid;
		} else {
			//Throw out any other trash.
			throw(new \InvalidArgumentException("Invalid UUID"));
		}
		//Verify the UUID is UUID v4.
		if($uuid->getVersion() !==4) {
			throw(new \RangeException("The UUID is not the correct version."));
		}
		return($uuid);
	}
}