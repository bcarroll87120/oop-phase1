<?php
namespace Bcarroll3\AuthorProject;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) ."/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Author {
	use ValidateUuid;

	/*
	 * id for author
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

@return int

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

	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl) {
		if(empty($newAuthorAvatarUrl)
	}
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
		if($newAuthorActivationToken ===null) {
			$this->authorActivationToken = null;
			return;
		}
		//$newAuthorActivationToken = starttolower(trim($newAuthorActivationToken));
		//if(ctype_xdigit($newAuthorActivationToken) ===false) {
			//throw(new \RangeExceptio ("User activation is not valid."));
	//}
	//Verify the activation token is only 32 characters long
	if(strlen($newAuthorActivationToken) !== 32)
	}

	public function setAuthorEmail(string $newAuthorEmail)

	public function__construct($newAuthorId, $newAuthorAvatorUrl, $newAuthorActivationToken, $newAuthorEmail, )
	$this->setAuthorId($newAuthorId);
	$this->setAuthorAvatorUrl($newAuthorAvatarUrl);
	$this->setAuthorActivationToken($newAuthorActivationToken);
	$this->setAuthorEmail($newAuthorEmail);
	$this->setAuthorHash($newAuthorHash);
	$this->setAuthorUsername($newAuthorUsername);
}
?>