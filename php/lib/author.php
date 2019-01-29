<?php

namespace Bcarroll3\AuthorProject;

require_once(dirname(__DIR__, 1) . "/Classes/Author.php");

use Ramsey\Uuid\Uuid;

$myAuthor = new Author("7555b1e4-d564-4ff5-9ced-f833da3135cc", "www.test.com", "hehehehehehehehehehehehehehehehe", "huntercallaway@hotmail.com", "nanananananananananananananananananananananananananananananananananananananananananananananananan", "Brandon Carroll");
var_dump($myAuthor);
