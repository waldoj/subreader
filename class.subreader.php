<?php

/**
 * Turn an SBV file into an object of times and text. Expects to receive raw SBV text, not a file
 * path. Provide it with the contents as $this->sbv, it returns a transcript as $this->transcript
 * and the SBV file broken up into time-based units as an object named $this->moments.
 *
 * PHP version 5
 *
 * @author		Waldo Jaquith <waldo at jaquith.org>
 * @copyright	2013 Waldo Jaquith
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		1.0
 * @since		1.0
*/
class SBV
{
	
	/*
	 * Pass the contents of the SBV file as $this->sbv.
	 */
	function parse()
	{
		if ( !isset($this->sbv) || empty($this->sbv) )
		{
			return false;
		}
	
		/*
		 * Intialize a variable to store our complete transcript.
		 */
		$this->complete = '';
		
		/*
		 * YouTube's SBVs quite frequently contain whitespace at the end.
		 */
		$this->sbv = trim($this->sbv);
	
		/*
		 * Set aside the raw SBV data.
		 */
		$this->raw_sbv = $this->sbv;
		
		/*
		 * Turn the raw data into an array.
		 */
		$this->sbv = explode('-----', $this->sbv);
		
		/*
		 * Step through every moment in the array.
		 */
		$i=0;
		foreach ($this->sbv as $moment)
		{
		
			/*
			 * Each moment is bracketed in newlines. Strip those out.
			 */
			$moment = trim($moment);
			
			/*
			 * Break the moment up into individual lines.
			 */
			$moment = explode(PHP_EOL, $moment);
			
			$this->moments->$i->time_start = implode(array_slice(explode(',', $moment[0]), 0, 1));
			$this->moments->$i->time_end = implode(array_slice(explode(',', $moment[0]), 1, 1));
			$this->moments->$i->text = implode(' ', array_slice($moment, 1));
			
			/*
			 * Append the text to our master transcript of text.
			 */
			$this->transcript .= $this->moments->$i->text.' ';
			
			$i++;
		}
		
		/*
		 * Restore the transcript to its original variable.
		 */
		$this->sbv = $this->sbv_raw;
		unset($this->sbv_raw);
		
		return true;
	}
}

?>