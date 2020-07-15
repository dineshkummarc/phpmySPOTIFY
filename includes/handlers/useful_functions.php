<?php 
require_once "config.php";

function get_playlist_img($name) {
    $sql = sprintf("select img
                from songs
                join %s
                    on songs.id = %s.song_id
                 ",$name,$name);
    $array = get_sql_array($sql);
    
    if(sizeof($array) == 0){
        return "";
    }
    
    return $array[rand(1,sizeof($array)-1)][0];
}

function get_random_numbers($array) {
    $num_array = array();
    
    while(sizeof($num_array) <4){
        $rand_num = rand(0,43);
        if(in_array($rand_num,$num_array) == false){
            array_push($num_array,$rand_num);
        }
            
    }
    
    return $num_array;
}

function remove_duplicate_songs($array, $size_of_array) {
    $new_array = array();
    $i = 0;
    
    while(sizeof($new_array) != $size_of_array ){
        if(in_array($array[$i],$new_array)==false){
            array_push($new_array,$array[$i]);
        }
        $i+=1;
    }
    
    return $new_array;
}

// This function makes sure there is no repeat in items returned by the name inputted in the search bar
function filter_results_of_search_bar_input($sql, $array) {
    global $link;
    $results =mysqli_query($link,$sql);
    
    while($row = mysqli_fetch_row($results)){
        if(in_array($row,$array) == false){
            array_push($array,$row);
        }
    }
    
    return $array;
}

//Function returns items based on the name inputted in the search bar
function get_search_bar_results($user_input){
    $array = array();
    $sql = 'select songs.id,songs.img,songs.artist,songs.name
            from songs
            where name = "'.$user_input.'" 
            group by name';
    $array = filter_results_of_search_bar_input($sql,$array);
    $sql = 'select songs.id,songs.img,songs.artist,songs.name
            from songs
            where artist like "%'.$user_input.'%"
            group by name';
     $array = filter_results_of_search_bar_input($sql,$array);
    $sql = 'select songs.id,songs.img,songs.artist,songs.name
            from songs
            where name like "%'.$user_input.'%"
            group by name';
    $array = filter_results_of_search_bar_input($sql,$array);
    return $array;
}

// Function adds song to recently played table
function add_song_to_recently_played($imgSrc, $previewTrackName, $previewArtistName) {
    global $link;
    $sql = sprintf("
             insert into recently_played(song_id)
             values(%d)
            ",get_song_id($imgSrc,$previewTrackName,$previewArtistName));
    mysqli_query($link,$sql);
}

// Function takes some of the song's attributes and returns its ID
function get_song_id($imgSrc, $previewTrackName, $previewArtistName) {
    global $link;
    $sql = sprintf('select id 
             from songs
             where img like "%%%s%%" and name like "%%%s%%" and artist like "%%%s%%"
             limit 1
            ',$imgSrc,$previewTrackName,$previewArtistName);
    
    $result = mysqli_query($link,$sql);
    $row = mysqli_fetch_array($result);
    return $row[0];
}

function delete_song_from_playlist($id, $table_name) {
    global $link;
    $sql = sprintf('delete 
            from %s
            where song_id = %d
            ',$table_name,$id);
    mysqli_query($link,$sql);
}

// Function takes and sql statement and returns the result of the sql statement in an array form 
function get_sql_array($sql) {
    global $link;
    $results =mysqli_query($link,$sql);
    $array = array();
    
    if($results){
        
        while($row = mysqli_fetch_row($results)){
            $array[] = $row;
        }
        
    }
    
    return $array;
}

function get_song_from_playlist($name, $type){
    $playlist = new Playlist($name,$type);
    return $playlist->get_songs();
}

function add_song_to_playlist($song_id, $playlist_name) {
    global $link;
    $sql = sprintf("select song_id 
                    from %s 
                    where song_id = %d ",$playlist_name,$song_id);
    
    if (sizeof(get_sql_array($sql))  <= 0){
        $sql = sprintf("insert into %s(song_id)
                        values(%d)",$playlist_name,$song_id);
        mysqli_query($link,$sql);
    }

}


function get_song_duration($duration) {
    return strval(number_format((float)$duration / 60000, 2, '.', ''));
}


function insert_song_into_playlist($song_id, $playlist_name) {
    global $link;
    $sql = sprintf("insert into %s(song_id)
            values(%d)",$playlist_name,$song_id);
    mysqli_query($link,$sql);
}

//Function returns all the playlist names in the database
function get_playlist_names() {
    $sql = "select * from playlist_names";
    $array = get_sql_array($sql);
    
    for($i = 0;$i <= sizeof($array)-1;$i++){
        $array[$i] = ucfirst($array[$i][1]);
    }
    
    return $array;
}

function add_new_playlist($playlist_name) {
    global $link;
    $playlist_name = strtolower($playlist_name);
    $sql = sprintf('
                select name 
                from playlist_names
                where like "%s"
            ',$playlist_name);
    $array = get_sql_array($sql);
    
    if(sizeof($array) <1){
        $sql = sprintf('
                insert into playlist_names(name)
                values("%s")
            ',$playlist_name);
        mysqli_query($link,$sql);
        $sql = sprintf('
            create table %s(
                id int primary key auto_increment,
                song_id int not null unique
            )
        ',$playlist_name);
        mysqli_query($link,$sql);
    }
    
}


?>