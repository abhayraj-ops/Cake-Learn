<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         2.3.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use function Cake\Core\env;

/**
 * built-in Server command
 */
class ServerCommand extends \Cake\Command\ServerCommand
{
    /**
     * Execute.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $this->startup($args, $io);
        
        // Find the correct PHP executable
        $phpBinary = $this->findPhpExecutable();
        if (!$phpBinary) {
            $io->err('<error>Could not find PHP executable. Please ensure PHP is installed and accessible.</error>');
            return static::CODE_ERROR;
        }

        $command = sprintf(
            '%s -S %s:%d -t %s',
            $phpBinary,
            $this->_host,
            $this->_port,
            escapeshellarg($this->_documentRoot),
        );

        if ($this->_iniPath) {
            $command = sprintf('%s -c %s', $command, $this->_iniPath);
        }

        $command = sprintf('%s %s', $command, escapeshellarg($this->_documentRoot . '/index.php'));

        $port = ':' . $this->_port;
        $io->out(sprintf('built-in server is running in http://%s%s/', $this->_host, $port));
        $io->out('You can exit with <info>`CTRL-C`</info>');
        system($command);

        return static::CODE_SUCCESS;
    }

    /**
     * Find the correct PHP executable
     *
     * @return string|null The path to PHP executable or null if not found
     */
    protected function findPhpExecutable(): ?string
    {
        // First try to get PHP from environment
        $phpFromEnv = env('PHP');
        if ($phpFromEnv && $this->isValidPhpExecutable($phpFromEnv)) {
            return $phpFromEnv;
        }

        // Try common PHP paths on Windows
        $commonPaths = [
            'C:\xampp\php\php.exe',
            'C:\Users\aispl_admin\.config\herd-lite\bin\php.exe',
            'C:\Program Files\PHP\php.exe',
            'C:\php\php.exe',
        ];

        foreach ($commonPaths as $path) {
            if ($this->isValidPhpExecutable($path)) {
                return $path;
            }
        }

        // Try to find PHP using where command
        $output = [];
        $returnCode = 0;
        exec('where php', $output, $returnCode);
        
        if ($returnCode === 0 && !empty($output)) {
            foreach ($output as $path) {
                if ($this->isValidPhpExecutable($path)) {
                    return $path;
                }
            }
        }

        return null;
    }

    /**
     * Check if the given path is a valid PHP executable
     *
     * @param string $path The path to check
     * @return bool True if it's a valid PHP executable
     */
    protected function isValidPhpExecutable(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }

        // Try to run php -v to verify it's a valid PHP executable
        $output = [];
        $returnCode = 0;
        exec(sprintf('"%s" -v', $path), $output, $returnCode);
        
        return $returnCode === 0 && !empty($output);
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The option parser to update
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return parent::buildOptionParser($parser);
    }
}