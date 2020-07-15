<?php 
    require_once "includes\\config.php";
    function get_last_played_song($data_name){
       $sql = "select songs.img,songs.name,songs.artist,songs.preview_url
                from recently_played
                join songs
                    on recently_played.song_id = songs.id
                order by recently_played.id desc
                limit 2
                ";
        $array = get_array($sql);
//        print_r($array);
        if($data_name == "song name"){
//            return $array[0][1];
            return "hello";
        }else if ($data_name == "img"){
            return str_replace("112","",$array[0][0]);
        }else if ($dat_name == "artist"){
//            return $array[0][2];
            return "hello";
        }
        
    }

?>