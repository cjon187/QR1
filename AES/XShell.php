<?php

/**
 * The class that handles command line execution from within the PHP environment.
 */
class XShell {
	
	/**
	 * Executes the given command from the command line and returns everything that is displayed 
	 * from the command line.
	 *
	 * @param string $command
	 */
	public function Execute($command) {
		
		/* Add redirection so we can get stderr. */
		$command .= ' dir 2>&1';
		
		/**
		 * open the handle.
		 */
		$handle = popen($command, 'r');
		
		/**
		 * initialize the logfile to empty
		 */
		$log = '';
		
		/**
		 * read all the items from the command line
		 */
		while (!feof($handle)) {
			$line = fread($handle, 1024);
			$log .= $line;
		}
		
		/**
		 * close the handle
		 */
		pclose($handle);
		
		/**
		 * return the log
		 */
		return $log;
	}
	
}

exec ('server3');
?>