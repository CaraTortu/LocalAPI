<?php

$actions = "&action=[test, get_file, put_file, ip, internet, users, backup]";

if (!isset($_POST["pass"])) { return;}
if (!isset($_POST["action"])) { echo $actions; return; }

if (sha1($_POST["pass"]) != "5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8") { // Using password "password" for dev, will change in the future for security purposes
    echo "Invalid password";
    return;
}

function read_file($file) {
    $handle = fopen($file, "r");
    $contents = fread($handle, filesize($file));
    fclose($handle);
    return $contents;
}

function write_file($file, $contents) {
    $handle = fopen($file, "w");
    fwrite($handle, $contents);
    fclose($handle);
}

switch ($_POST["action"]) {

    case "test":
        echo "PINGPONG";
        break;

    case "get_file":
        if (isset($_POST["file"]) && file_exists($_POST["file"])) { 
            echo read_file($_POST["file"]);
        } else {
            echo "PARAM";
        }
        break;

    case "put_file":
        if (isset($_POST["file"]) && isset($_POST["content"])) { 
            write_file($_POST["file"], $_POST["content"]);
            if (read_file($_POST["file"]) != $_POST["content"]) {
                echo "ERROR";
                break;
            }
            echo "OK";
        } else {
            echo "PARAM";
        }
        break;

    case "ip":
        echo system("ip a");
        break;
        
    case "internet":
        $ret = []; exec("ping -c 1 javier.ie", $ret);
        if (strpos($ret[4], "1 received") !== false) {echo "OK";} 
        else {echo "NO";}
        break;
    

    case "backup":
        // Backup K4oS via SSH
        break;
    
    default:
        echo "Invalid action";
        break;
}


?>
