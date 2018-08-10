<?php
/**
 * SystemCLI Class
 * @package		SystemCLI Class
 * @link		http://zincksoft.com
 * @author		Zincksoft.com <info@zincksoft.com>
 * @copyright	2007 - 2014 Zincksoft.com <info@zincksoft.com>
 * @version		1.0.1
**/

class SystemCLI
{
    /**
     * Safely run an escaped system() command.
     */
    public function Command($command, $args)
    {
        $escapedCommand = escapeshellcmd($command);
        if (is_array($args)) {
            foreach ($args as $arg) {
                $escapedCommand .= ' ' . escapeshellarg($arg);
            }
        } else {
            $escapedCommand .= ' ' . escapeshellarg($args);
        }
        system($escapedCommand, $systemReturnValue);
		
        return $systemReturnValue;
    }
	
	
	public function ShellCommand($command)
	{
		$output = shell_exec($command);	
		
		return $output;
		
	}
	
	
	
}