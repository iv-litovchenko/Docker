<?php
unction execPrint($command) {
    $result = array();
    exec($command, $result);
    print("<pre>");
    foreach ($result as $line) {
        print($line . "\n");
    }
    print("</pre>");
}
// Print the exec output inside of a pre element
execPrint("git pull https://user:password@bitbucket.org/user/repo.git master");
execPrint("git status");
?>
