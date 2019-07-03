<?php
    /*
    USAGE PATTERN:
    php RemoveAfterTag.php ViewsFolder TagName
    THE TAG NAME MUST BE LIKE <TagName>
    */
    $Source=$argv[1];
    $Tag=$argv[2];
    $Files = scandir($Source);
    foreach($Files as $File){
        $Remaining=array();
        $TagFound=false;
        $FilePath=$Source.'/'.$File;
        if(is_file($FilePath)){
            $FileParts = pathinfo($FilePath);
            if($FileParts['extension']=='php'){
                echo "===============\n";
                echo "FILE NAME: ".$File."\n";
                echo "===============\n";
                $Lines = file($FilePath);
                
                foreach($Lines as $Line){
                    //echo $Line."\n";
                    if(strpos($Line, "<".$Tag.">")!==false){
                        $TagFound=true;
                    }
                    if($TagFound){
                        break;
                       
                    }else{
                        $Remaining[]=$Line;
                    }                  
                }
                //var_dump($Remaining);
                
                if(!empty($Remaining)){
                    if(file_put_contents($FilePath, $Remaining)!==false){
                        echo "The ".$File." has been successfully modified\n";
                    }else{
                        echo "The ".$File." can not be modified\n";
                    }
                }
            }
        }
    }
