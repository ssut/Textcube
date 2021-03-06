<?php
/* BlogAPI RSD automarker for Textcube 1.8
   ----------------------------------
   Version 1.8
   Needlworks development team.

   Creator          : coolengineer
   Maintainer       : coolengineer

   Created at       : 2006.8.6
   Last modified at : 2010.4.30
 
 This plugin adds RSD link into blog skin.
 For the detail, visit http://forum.tattersite.com/ko


 General Public License
 http://www.gnu.org/licenses/gpl.html

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

*/
function AddRSD($target)
{
	global $hostURL, $blogURL;
	$target .= '<link rel="EditURI" type="application/rsd+xml" title="RSD" href="'.$hostURL.$blogURL.'/api?rsd" />'.CRLF;
	return $target;
}
?>
