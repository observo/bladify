<?php
    /*
    USAGE PATTERN:
    php GetCSS.php DirectoryWhereHTMLFilesReside CodeName
    THE css.txt FILE WILL BE CREATED IN CodeName DIRECTORY
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
                    if(strpos($Line, ".css")!==false){
                        $Line=str_replace("link", "", $Line);
                        $Line=str_replace("href", "", $Line);
                        $Line=str_replace("rel", "", $Line);
                        $Line=str_replace("stylesheet", "", $Line);
                        $Line=str_replace("<", "", $Line);
                        $Line=str_replace("/>", "", $Line);                
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
    $Source."/".$Code
    foreach($Combined as $Individual){
        $Line="<link rel=\"stylesheet\" href=\"{{ asset('".$Code."/assets/".$Individual."') }}\">";
        echo $Line."\n";
        //FILE WRITE
        file_put_contents($Source."/".$Code."/css.txt", $Line."\n", FILE_APPEND);
    }