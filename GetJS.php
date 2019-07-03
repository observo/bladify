<?php
    /*
    USAGE PATTERN:
    php GetJS.php DirectoryWhereHTMLFilesReside CodeName
    THE js.txt FILE WILL BE CREATED IN CodeName DIRECTORY
    */
    $Source=$argv[1];
    $Code=$argv[2];
    $Files = scandir($Source);
    foreach($Files as $File){
        $FilePath=$Source.'/'.$File;
        if(is_file($FilePath)){
            $FileParts = pathinfo($FilePath);
            if($FileParts['extension']=='html'){
                echo "===============\n";
                echo "FILE NAME: ".$File."\n";
                echo "===============\n";
                $Lines = file($FilePath);
                foreach ($Lines as $Line) {
                    $Line=trim($Line);
                    if(strpos($Line, ".js")!==false){
                        $Line=str_replace("script", "", $Line);
                        $Line=str_replace("src", "", $Line);
                        $Line=str_replace("</", "", $Line);
                        $Line=str_replace("<", "", $Line);
                        $Line=str_replace(">", "", $Line);
                        $Line=str_replace("=", "", $Line);
                        $Line=str_replace("\"", "", $Line);
                        $Line=trim($Line);
                        echo $Line."\n";
                        in_array ($Line, $Combined) || $Combined[]=$Line;
                    }
                }
            }   
        }
    }
    if (!file_exists($Source."/".$Code)) {
        mkdir($Source."/".$Code, 0777, true);
    }
    
    foreach($Combined as $Individual){
        $Line="<script src=\"{{ asset('".$Code."/assets/".$Individual."') }}\"></script>";
        echo $Line."\n";
        //FILE WRITE
        file_put_contents($Source."/".$Code."/js.txt", $Line."\n", FILE_APPEND);
    }