<?php
    /*
    USAGE PATTERN:
    php MakeBladeExtension.php DirectoryWhereHTMLFilesReside CodeName
    THE .blade.php FILES WILL BE CREATED IN CodeName/views DIRECTORY
    */
    $Source=$argv[1];
    $Code=$argv[2];
    $ViewFolder=$Source."/".$Code."/"."views";
    if (!file_exists($ViewFolder)) {
        mkdir($ViewFolder, 0777, true);
    }
    $Files = scandir($Source);
    foreach($Files as $File){
        $FilePath=$Source.'/'.$File;
        if(is_file($FilePath)){
            $FileParts = pathinfo($FilePath);
            if($FileParts['extension']=='html'){
                echo "===============\n";
                echo "FILE NAME: ".$File."\n";
                echo "===============\n";
                if(!copy($FilePath, $ViewFolder."/".str_replace(".html", "", $File).".blade.php")){
                    echo "The ".$File." can not be copied\n";
                }else{
                    echo "The ".$File." has been successfully copied\n";
                }               
            }
        }
    }