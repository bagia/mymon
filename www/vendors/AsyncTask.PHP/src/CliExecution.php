<?php

require_once(realpath(__DIR__ . "/bootstrap.php"));

class CliExecution implements Execution {

    public function execute(AsyncTask $task) {
        $file_name = escapeshellarg(realpath(__FILE__));

        $dependencies = '';
        foreach($task->getDependencies() as $dependency) {
            $dependencies .= " " . escapeshellarg($dependency);
        }

        if ($this->isWindows()) {
            $startbg = realpath(__DIR__ . '/startbg/bin/startbg.exe');
            $command_line = "{$startbg} C:\\php\\php.exe {$file_name} at_exec {$task->getIdentifier()}{$dependencies} >NUL 2>NUL";
            //$command_line = "{$startbg} php C:/temp/sleep.php";
            system($command_line);
        } else {
            $command_line = "php {$file_name} at_exec {$task->getIdentifier()}{$dependencies} > /dev/null 2>&1 &";
            exec($command_line);
        }
    }

    protected function isWindows() {
        return stripos(PHP_OS, 'win') !== FALSE;
    }

}

if (php_sapi_name() == "cli" && isset($argv[1]) && $argv[1] == "at_exec") {
    set_time_limit(0);
    $identifier = $argv[2];
    // Import the dependencies
    for ($i = 3; $i < count($argv); $i++) {
        require_once($argv[$i]);
    }

    $task = AsyncTask::get($identifier);
    $task->syncExecute();
}