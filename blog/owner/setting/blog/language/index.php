<?php
define('ROOT', '../../../../..');
require ROOT . '/lib/includeForOwner.php';
if (!empty($_GET['language']) && setBlogLanguage($owner, $_GET['language'], $_GET['blogLanguage'])) {
	respondResultPage(0);
}
respondResultPage( - 1);
?>
