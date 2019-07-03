<?php
    /*
    USAGE PATTERN:
    php SectionComponent.php ViewsFolder CodeName
    WE ARE GIVING THE SECTION NAME AS component
    */
    $Source=$argv[1];
    $Code=$argv[2];
    $Files = scandir($Source);
    foreach($Files as $File){
        $Remaining=array();
        $FilePath=$Source.'/'.$File;
        if(is_file($FilePath)){
            $FileParts = pathinfo($FilePath);
            if($FileParts['extension']=='php'){
                echo "===============\n";
                echo "FILE NAME: ".$File."\n";
                echo "===============\n";
                $Remaining[]="@extends('".$Code.".layouts.landing')";
                $Remaining[]="@section('component')";
                $Lines = file($FilePath);
                foreach($Lines as $Line){
                    $Remaining[]=$Line;
                }             
                $Remaining[]="@endsection";
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
