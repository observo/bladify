<?php
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
    var_dump($Combined);
    foreach($Combined as $Individual){
        $Line="<script src=\"{{ asset('".$Code."/assets/".$Individual."') }}\"></script>";
        echo $Line."\n";
        //FILE WRITE
        file_put_contents($Source."/js.txt", $Line."\n", FILE_APPEND);
    }