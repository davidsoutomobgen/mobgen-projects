<?php

ini_set("max_execution_time", "30000");

class Waveform {

	function findValues($byte1, $byte2) {
		$byte1 = hexdec(bin2hex($byte1));
		$byte2 = hexdec(bin2hex($byte2));
		return ($byte1 + ($byte2 * 256));
	}

	/**
	 * Retreive peaks with a certain interval
	 *
	 * @param type $filename
	 * @param type $detail How many bytes/frames to skip processing
	 * @return type
	 */
	function getPeaks($filename, $detail = 25, $draw_flat = false, $delete = false) {

		$peaks = array();

		/**
		 * Below as posted by "zvoneM" on
		 * http://forums.devshed.com/php-development-5/reading-16-bit-wav-file-318740.html
		 * as findValues() defined above
		 */
		$handle = fopen($filename, "r");
		// wav file header retrieval
		$heading[] = fread($handle, 4);
		$heading[] = bin2hex(fread($handle, 4));
		$heading[] = fread($handle, 4);
		$heading[] = fread($handle, 4);
		$heading[] = bin2hex(fread($handle, 4));
		$heading[] = bin2hex(fread($handle, 2));
		$heading[] = bin2hex(fread($handle, 2));
		$heading[] = bin2hex(fread($handle, 4));
		$heading[] = bin2hex(fread($handle, 4));
		$heading[] = bin2hex(fread($handle, 2));
		$heading[] = bin2hex(fread($handle, 2));
		$heading[] = fread($handle, 4);
		$heading[] = bin2hex(fread($handle, 4));

		// wav bitrate
		$peek = hexdec(substr($heading[10], 0, 2));
		$byte = $peek / 8;

		// checking whether a mono or stereo wav
		$channel = hexdec(substr($heading[6], 0, 2));

		$ratio = ($channel == 2 ? 40 : 80);

		// start putting together the initial canvas
		// $data_size = (size_of_file - header_bytes_read) / skipped_bytes + 1
		$data_size = floor((filesize($filename) - 44) / ($ratio + $byte) + 1);
		$data_point = 0;

		while (!feof($handle) && $data_point < $data_size) {
			if ($data_point++ % $detail == 0) {
				$bytes = array();

				// get number of bytes depending on bitrate
				for ($i = 0; $i < $byte; $i++)
					$bytes[$i] = fgetc($handle);

				switch ($byte) {
					// get value for 8-bit wav
					case 1:
						$data = findValues($bytes[0], $bytes[1]);
						break;
					// get value for 16-bit wav
					case 2:
						if (ord($bytes[1]) & 128)
							$temp = 0;
						else
							$temp = 128;
						$temp = chr((ord($bytes[1]) & 127) + $temp);
						$data = floor($this->findValues($bytes[0], $temp) / 256);
						break;
				}

				// skip bytes for memory optimization
				fseek($handle, $ratio, SEEK_CUR);

				// data values can range between 0 and 255, normalized to 100
				$v = (int) ($data / 255 * 100);

				// don't record flat values on the canvas if not necessary
				if (!($v == 50 && !$draw_flat))
					$peaks[$data_point] = $v;
			} else {
				// skip this one
				fseek($handle, $ratio + $byte, SEEK_CUR);
			}
		}

		// close and cleanup
		fclose($handle);

		// delete the processed wav file
		if ($delete)
			unlink($filename);

		return array(
			'size' => $data_size,
			'peaks' => $peaks,
		);
	}

}