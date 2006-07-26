<?php
class Base64Stream {
	function encode($src = null, $dest = null) {
		if (is_string($src)) {
			if ($dest === null) {
				if (!$src = fopen($src, 'r'))
					return false;
				while (!feof($src))
					echo base64_encode(fread($src, 3 * 1024));
				fclose($src);
				return true;
			} else if (is_a($dest, 'OutputWriter')) {
				if (!$src = fopen($src, 'r'))
					return false;
				while (!feof($src))
					$dest->write(base64_encode(fread($src, 3 * 1024)));
				fclose($src);
				return true;
			}
		}
		return false;
	}
	
	function decode($src = null, $dest = null) {
		if (is_resource($src) && (get_resource_type($src) == 'stream')) {
			if (is_string($dest)) {
				$dest = fopen($dest, 'w');
				fseek($src, 0);
				while (!feof($src))
					fwrite($dest, base64_decode(trim(fread($src, 3 * 1024))));
				fclose($dest);
				return true;
			}
		}
		return false;
	}
}
?>