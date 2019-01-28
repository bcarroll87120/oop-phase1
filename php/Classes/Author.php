<?php
namespace Bcarroll3\AuthorProject;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) ."/vendor/autoload.php");

use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class Author {
	use ValidateUuid;

	/*
	 * id for author entity. this is the primary key
	 * @var string $authorId
	 */

	private $authorId;
	/*
	 * comment
	 */

	private $authorAvatarUrl;
	/*
	 * comment
	 */

	private $authorActivationToken;
	/*
	 * comment
	 */

	private $authorEmail;
	/*
	 * comment
	*/

	private $authorHash;
	/*
	 * comment
	 */

	private $authorUsername;
	/*
	 * comment
	 */


	public function getAuthorId() {
		return ($this->authorId);
	}

	/*
	 * mutator method for authorId
	 *
	 * @param int $newAuthorId new value of author id
	 * @throws UnexpectedValueException if $newAuthorId is not an integer
	 */

	public function setAuthorId( $newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->authorId = $uuid;
	}

	public function getAuthorAvatarUrl(): string {
		return ($this->authorAvatarUrl);
	}

	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl) {
		if(empty($newAuthorAvatarUrl) ===true) {
			throw(new \InvalidArgumentException("This URL is empty."));
		}
	}
	//Verify that the URL is no longer than 255 characters
if(strlen($newAuthorAvatarUrl) > 255 ) {
throw(new \RangeException( message: "This URL is too long. It must be no longer than 244 characters."));
	//Store the author avatar URL
$this->authorAvatarUrl = $newAuthorAvatarUrl;
}
/**
 *Accessor method for the author activation token
 *
 *@return string value of the author activation token
 **/

public function getAuthorActivationToken(): string {
	return($this->authorActivationToken);
}

/**
 * Mutator function for the author activation token
 *
 * @param string $newAuthorActivationToken new value author activation token
 * @throws \InvalidArgumentException if the author activation token isn't a string or is insecure
 * @throws \RangeException if the token is not exactly 32 characters
 **/

public function setAuthorActivationToken(string $newAuthorActivationToken): void {
	if($newAuthorActivationToken === null) {
		$this->authorActivationToken = null;
		return;
	}
	//$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
	//if(ctype_xdigit($newAuthorActivationToken) ===false) {
	//throw(new \RangeExceptio ("User activation is not valid."));
	//}
	//Verify the activation token is only 32 characters long
	if(strlen($newAuthorActivationToken) !== 32) {
		throw(new \RangeException("The user activation token must be 32 characters long."));
	}
	//Store the author activation token
	$this->authorActivationToken = $newAuthorActivationToken;
}

/**
 *Accessor method for the author email
 * @return string value of the author email
 */

public function getAuthorEmail(): string {
	return ($this->authorEmail);
}

/**
 * mutator method for the author email
 * @param string $newAuthorEmail new value author email
 * @throws \InvalidArgumentException if the author email address is invalid or insecure
 * @throws \RangeException if the author email address is longer than 128 characters
 */
public function setAuthorEmail(string $newAuthorEmail): void {
	$newAuthorEmail = trim($newAuthorEmail);
	$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
	If(empty($newAuthorEmail) === true) {
		throw(new \InvalidArgumentException("The author email address is invalid or insecure"));
	}
	//Store the author email
	$this->authorEmail = $newAuthorEmail;
}

/**
 * Accessor method for the authorHash
 * @return string value of the author hash
 */

public function getAuthorHash(): string {
	return $this->authorHash;
}

/**
 * Mutator method for the authorHash
 * @param string $newAuthorHash new value for the authorHash
 * @throws ]InvalidArgumentException if the hash is insecure or not invalid
 * @throws \RangeException
 */* @throws \RangeException if the hash is longer than 97 characters
**/

	public function setAuthorHash(string $newAuthorHash): void {
	//Ensure that the hash is formatted correctly
	$newAuthorHash = trim($newAuthorHash);
	if(empty($newAuthorHash) === true) {
		throw (new \InvalidArgumentException("The hash is empty or insecure."));
	}
	//Ensure the hash is an Argon hash
	//$authorHashInfo = password_get_info($newAuthorHash);
	//if($authorHashInfo["algoName"] !== "argon2i") {
	//throw (new \InvalidArgumentException("This is not a valid hash."));
	//}
	if(strlen($newAuthorHash) > 97) {
		throw (new \RangeException("The hash must be no longer than 97 characters."));
	}
	//Store the hash
	$this->authorHash = $newAuthorHash;
}

	/**
	 * Accessor method for the authorUsername
	 *
	 * @return string value or the author username
	 **/

	public function getAuthorUsername(): string {
	return $this->authorUsername;
}

	/**
	 * Mutator method for the author username
	 *
	 * @param string $newAuthorUsername new value for the author username
	 * @throws \InvalidArgumentException if $newAuthorUsername is not a string or is insecure
	 * @throws \RangeException if $newAuthorUsername is longer than 32 characters
	 **/

	public function setAuthorUsername(string $newAuthorUsername): void {
	//Ensure the username is formatted correctly
	$newAuthorUsername = trim($newAuthorUsername);
	$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newAuthorUsername) === true) {
		throw (new \InvalidArgumentException("The user name is invalid or insecure."));
	}
	//Verify the username is no longer than 32 characters.
	if(strlen($newAuthorUsername) > 32) {
		throw (new \RangeException("The username cannot be longer"));
	}
	//Store the username
	$this->authorUsername = $newAuthorUsername;
}

	/**
	 * constructor for this Author
	 *
	 * @param string|Uuid $newAuthorId id of this Author or null if a new Author
	 * @param string $newAuthorAvatarUrl string containing this Author's avatar URL
	 * @param $newAuthorActivationToken string for the Author activation token
	 * @param $newAuthorEmail string containing this Author's e-mail
	 * @param $newAuthorHash string containing the hash of this Author
	 * @param $newAuthorUsername string containing this Author's username
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($newAuthorId, $newAuthorAvatarUrl, $newAuthorActivationToken, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
	try {
		$this->setAuthorId($newAuthorId);
		$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
		$this->setAuthorActivationToken($newAuthorActivationToken);
		$this->setAuthorEmail($newAuthorEmail);
		$this->setAuthorHash($newAuthorHash);
		$this->setAuthorUsername($newAuthorUsername);
	} //Determine what exception type was thrown.
	catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw (new $exceptionType($exception->getMessage(), 0, $exception));
	}
}
?>