<?php

function url_headers($url) {
	// Attempts to download the headers of $url and returns them as an assoc. array.
	// Header names are converted to lowercase
	// Returns FALSE if there is an error reading $url.

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_NOBODY, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$rawheaders = curl_exec($ch);
	$curl_errstr = curl_error($ch); 
	curl_close($ch);
	if ($curl_errstr == "") {
		// parse the headers
		// example: "Content-type: text/html" --> $headers['content-type'] = "text/html";
		$linebyline = explode("\r\n",$rawheaders);
		$headers = array();
		foreach($linebyline as $aheader) { 
			list($hname,$hcontent)=explode(':',$aheader,2);
			$headers[strtolower($hname)]=substr($hcontent,1);
		}
		return $headers;
	} else {
		// A cURL error occurred. We may want to set a global (aah!) variable here with the error text.
		//DEBUG die("cURL error: ".$curl_errstr);
		return false;
	}
}

function url_is_type($url, $types) {
	// Returns TRUE if the MIME type of $url is equal to one of the types in the $types array.
	// This assumes that the server (containing $url) will send a Content-Type header, which it should.
	// Returns FALSE if the type does not match or if there is an error reading $url.

	//get header array
	$url_headers = url_headers($url);
	if ($url_headers != false) {  // if cURL retrieved the headers
		$url_mime = $url_headers["content-type"];
		$foundtype = false;
		foreach ($types as $atype) {
			if ($url_mime == $atype) {
				$foundtype = true;
			}
		}
		return $foundtype;
	} else {
		return false; // there was an error reading $url
	}
}

function curl_copy($url, $to) {
	// Downloads remote file $url to local file $to.
	// If the local file exists, cannot be created, or the remote file can't be downloaded,
	//  this function returns FALSE. 
	// If the operation is successful, it returns TRUE.
	if (is_file($to)) {
		//DEBUG die("Local file $to exists");
		return false;
	} else {
		$fp = fopen($to, "w");
		if(!$fp) {
			//DEBUG die("Error opening local file $to");
			return false;
		} else {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);

			curl_exec($ch);

			$curl_error = curl_error($ch);
			curl_close($ch);
			fclose($fp);

			if ($curl_error != "") {
				//DEBUG die("cURL error: $curl_error");
				return false;
			} else {
				return true;  // finally!
			}
		}
	}
}

?>