<?php
    /*
    USAGE PATTERN:
    php GetLink.php DirectoryWhereHTMLFilesReside CodeName
    THE link.txt FILE WILL BE CREATED IN CodeName DIRECTORY
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
                    $PreviousLine=$Line;
                    if((strpos($Line, "link")!==false) && (strpos($Line, "rel")!==false) && (strpos($Line, ".css")===false) && (strpos($Line, "stylesheet")===false)){
                        $Line=substr($Line, strpos($Line, 'href'));
                        $Line=str_replace("href", "", $Line);
                        $Line=str_replace("/>", "", $Line);                
                        $Line=str_replace("=", "", $Line);
                        $Line=str_replace("\"", "", $Line);
                        $Line=trim($Line);
                        $Line=preg_replace("/<*>/", "", $Line);
                        echo $Line."\n";
                        $HRef="href=\"{{ asset('".$Code."/assets/".$Line."') }}\">";
                        $Line=preg_replace("/href=.*/", $HRef, $PreviousLine);
                        //echo $Line."\n";
                        in_array ($Line, $Combined) || $Combined[]=$Line;
                    }        
                }
            }
        }
    }
    if (!file_exists($Source."/".$Code)) {
        mkdir($Source."/".$Code, 0777, true);
    }
    
    foreach($Combined as $Line){
        echo $Line."\n";
        //FILE WRITE
        file_put_contents($Source."/".$Code."/link.txt", $Line."\n", FILE_APPEND);
    }