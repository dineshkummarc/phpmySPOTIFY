<?php
require_once "config.php";
require_once "useful_functions.php";

function get_recently_played_songs_html($page=false) {
    $sql = "select songs.img,songs.name,songs.artist,songs.preview_url,songs.id
            from recently_played
            join songs
                on recently_played.song_id = songs.id
            order by recently_played.id desc
            ";
    $array = get_sql_array($sql);
    
    if($page == true){
        $array= remove_duplicate_songs($array,20);
    }else{
        $array= remove_duplicate_songs($array,4);
    }
    
    $html =    '<div class="home-container">';
    
    if($page == true){
            $html .=    '<h1 id="recently_played_h1"> Recently Played </h1>';
            $html .= '<div class="row row_recently_played">';
    }else{
           $html .= '<div class="row">';
 
    }

    foreach($array as $item){
        $html_item = sprintf('
        <div class="col-3">
            <div class="pic">
                <img id="%s" src="%s" alt="song preview img"/>
                <div class="overlay"></div>
                <div class="img-info %d">
                <svg class="main-like-btn" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                    width="30" height="30"
                    viewBox="0 0 172 172"
                    style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M86,6.88c-43.65605,0 -79.12,35.46398 -79.12,79.12c0,43.65602 35.46395,79.12 79.12,79.12c43.65605,0 79.12,-35.46398 79.12,-79.12c0,-43.65602 -35.46395,-79.12 -79.12,-79.12zM86,13.76c39.93783,0 72.24,32.3022 72.24,72.24c0,39.9378 -32.30217,72.24 -72.24,72.24c-39.93783,0 -72.24,-32.3022 -72.24,-72.24c0,-39.9378 32.30217,-72.24 72.24,-72.24zM68.8,55.04c-14.23141,0 -24.08,11.84477 -24.08,25.45735c0,11.63867 9.2753,22.14966 18.1675,30.4225c4.4461,4.13642 8.91167,7.67675 12.36922,10.29312c1.72878,1.30819 3.2043,2.38618 4.28656,3.17797c1.08227,0.79179 2.11368,1.69041 1.61922,1.19594l0.1075,0.1075l4.38735,3.655l4.21265,-3.5139l0.0336,-0.02015l0.02015,-0.02016c-0.14799,0.12267 0.7282,-0.50533 1.81406,-1.26312c1.11884,-0.78081 2.62778,-1.8476 4.39406,-3.1511c3.53258,-2.60699 8.08361,-6.15508 12.61781,-10.31328c9.06816,-8.31612 18.53031,-18.89069 18.53031,-30.57031c0,-13.61257 -9.84859,-25.45735 -24.08,-25.45735c-9.20906,0 -14.38585,5.24354 -17.2,8.65375c-2.81415,-3.41021 -7.99094,-8.65375 -17.2,-8.65375zM68.8,61.92c8.02667,0 14.33781,8.78812 14.33781,8.78813l2.86219,4.29328l2.86219,-4.29328c0,0 6.31115,-8.78813 14.33781,-8.78813c10.53659,0 17.2,8.10991 17.2,18.57735c0,7.58438 -7.7381,17.64605 -16.29969,25.49765c-4.28079,3.9258 -8.65226,7.33967 -12.05344,9.84969c-1.70058,1.25501 -3.16134,2.2885 -4.25297,3.05031c-1.04529,0.72948 -1.51813,1.02336 -2.12984,1.505l0.12765,0.1075l0.23515,0.215c-0.14881,-0.14881 -0.26288,-0.18738 -0.38969,-0.30235c-0.01926,0.01514 -0.04758,0.03131 -0.06719,0.04703l0.06047,-0.05375c-0.65691,-0.59425 -1.11067,-0.9052 -2.02234,-1.57219c-1.09058,-0.79787 -2.52562,-1.84435 -4.19922,-3.11078c-3.3472,-2.53287 -7.63482,-5.93839 -11.83172,-9.84297c-8.3938,-7.80916 -15.97719,-17.76482 -15.97719,-25.39015c0,-10.46743 6.66341,-18.57735 17.2,-18.57735z"></path></g></g>
                </svg>


                <svg id="play" class="recently_played_preview_play"xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                    width="70" height="70"
                    viewBox="0 0 172 172"
                    style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M39.40211,24.10688c-3.51284,0.13253 -6.72211,2.99679 -6.72211,6.87664v110.03297c0,5.20301 5.77026,8.56639 10.29312,5.99648h0.00336l99.73312,-55.74547l0.00336,-0.00336c4.60481,-2.61811 4.56669,-9.46717 -0.06719,-12.03328l-0.00672,-0.00336l-99.72977,-54.27742h-0.00336c-1.13014,-0.62524 -2.33394,-0.88734 -3.50383,-0.8432zM39.44242,27.49648c0.59119,-0.00998 1.20486,0.13211 1.79726,0.46023l0.00672,0.00336l99.7432,54.2875c2.42396,1.35261 2.4394,4.65314 0.02352,6.02672l-99.73312,55.74547l-0.00672,0.00336c-2.37045,1.34837 -5.15328,-0.27473 -5.15328,-3.00664v-110.03297c0,-2.03609 1.54884,-3.45686 3.32242,-3.48703zM42.14,34.44031c-0.47495,0.00005 -0.85995,0.38505 -0.86,0.86v101.3389c-0.00066,0.30551 0.16081,0.58844 0.42417,0.74328c0.26337,0.15484 0.58911,0.15835 0.85575,0.00922l91.85875,-51.34469c0.27303,-0.15272 0.44161,-0.44164 0.44021,-0.75448c-0.0014,-0.31284 -0.17255,-0.60025 -0.44693,-0.75052l-55.74211,-30.33852c-0.27082,-0.15564 -0.60473,-0.15222 -0.8723,0.00893c-0.26757,0.16115 -0.42674,0.45471 -0.41581,0.76687c0.01093,0.31217 0.19024,0.59387 0.46843,0.73591l54.36812,29.58937l-89.21828,49.86992v-98.42633l14.21016,7.73328c0.27118,0.17054 0.61467,0.17624 0.89136,0.01479c0.27669,-0.16145 0.44072,-0.4633 0.42566,-0.78329c-0.01506,-0.31999 -0.20671,-0.6051 -0.49733,-0.73986l-15.48,-8.42867c-0.12582,-0.06828 -0.26669,-0.10407 -0.40984,-0.10414zM62.78,45.66734c-0.39835,-0.00559 -0.7484,0.26311 -0.84597,0.64937c-0.09756,0.38626 0.0829,0.78896 0.43612,0.97321l5.16,2.80844c0.27082,0.15564 0.60473,0.15222 0.8723,-0.00893c0.26757,-0.16115 0.42674,-0.45471 0.41581,-0.76687c-0.01093,-0.31217 -0.19024,-0.59387 -0.46843,-0.73591l-5.16,-2.80844c-0.1252,-0.07062 -0.26611,-0.10874 -0.40984,-0.11086zM71.38,50.35031c-0.3958,-0.00256 -0.74224,0.26532 -0.83936,0.64903c-0.09712,0.3837 0.08016,0.78415 0.42952,0.97019l3.44,1.87453c0.27082,0.15563 0.60472,0.1522 0.87229,-0.00896c0.26757,-0.16115 0.42673,-0.4547 0.41581,-0.76686c-0.01093,-0.31216 -0.19023,-0.59386 -0.46841,-0.73591l-3.44,-1.87453c-0.12551,-0.06945 -0.2664,-0.1064 -0.40984,-0.1075z"></path></g></g>
                </svg>



                <div class="dropdown">
                    <svg  class="dotted_options dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                        width="50" height="50"
                        viewBox="0 0 172 172"
                        style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M32.25,64.5c-11.8208,0 -21.5,9.6792 -21.5,21.5c0,11.8208 9.6792,21.5 21.5,21.5c11.8208,0 21.5,-9.6792 21.5,-21.5c0,-11.8208 -9.6792,-21.5 -21.5,-21.5zM86,64.5c-11.8208,0 -21.5,9.6792 -21.5,21.5c0,11.8208 9.6792,21.5 21.5,21.5c11.8208,0 21.5,-9.6792 21.5,-21.5c0,-11.8208 -9.6792,-21.5 -21.5,-21.5zM139.75,64.5c-11.8208,0 -21.5,9.6792 -21.5,21.5c0,11.8208 9.6792,21.5 21.5,21.5c11.8208,0 21.5,-9.6792 21.5,-21.5c0,-11.8208 -9.6792,-21.5 -21.5,-21.5zM32.25,75.25c6.00489,0 10.75,4.74512 10.75,10.75c0,6.00489 -4.74511,10.75 -10.75,10.75c-6.00488,0 -10.75,-4.74511 -10.75,-10.75c0,-6.00488 4.74512,-10.75 10.75,-10.75zM86,75.25c6.00489,0 10.75,4.74512 10.75,10.75c0,6.00489 -4.74511,10.75 -10.75,10.75c-6.00488,0 -10.75,-4.74511 -10.75,-10.75c0,-6.00488 4.74512,-10.75 10.75,-10.75zM139.75,75.25c6.00489,0 10.75,4.74512 10.75,10.75c0,6.00489 -4.74511,10.75 -10.75,10.75c-6.00488,0 -10.75,-4.74511 -10.75,-10.75c0,-6.00488 4.74512,-10.75 10.75,-10.75z"></path></g></g>
                    </svg>
                    <div class="dropdown-menu %d" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Add to Playlist</a>
                            %s
                    </div>
                </div>

            </div>
            </div>

           <h6 class="song-name">
               %s
           </h6>

           <span class="artist-name">
               %s
           </span>
        </div>',$item[3],$item[0],$item[4],$item[4],display_playlist_names(),$item[1],$item[2]);
                $html .= $html_item;
        }
        
        $html.=' </div>
        </div>';
        return $html;
}

function get_recommended_playlists_html() {
    $sql = "show tables";
    $array = get_sql_array($sql);
    $rand_nums = get_random_numbers($array);
    $playlists_names = array();
    
    foreach($rand_nums as $num){
        array_push($playlists_names,$array[$num][0]);
    }
    
    $html =    '<div class="home-container">
  <div class="row" style="margin-bottom:15vh;">';
    
    foreach($playlists_names as $name){
        $html_item = sprintf('<div class="col-3">
      <img src="%s
        " alt="song preview img" class="recommended_playlist_preview_img %s">
       <h6 class="playlist-name">
           %s
       </h6>
    </div>',get_playlist_img($name),$name,$name);
            $html .= $html_item;
    }
        
    $html.=' </div></div>';
    return $html;
}

function get_recommended_songs() {
    $sql = "select * from songs";
    $array = get_sql_array($sql);
    $rand_nums = get_random_numbers($array);
    $song_names = array();
    $song_images = array();
    $song_artist = array();
    
    foreach($rand_nums as $num){
            array_push($song_names,$array[$num][5]);
            array_push($song_images,$array[$num][3]);
            array_push($song_artist,$array[$num][1]);
    }
     $html = '<div class="home-container"> <div class="row">';
    for($i=0;$i<=sizeof($song_names)-1;$i++){
        $html_item = sprintf('<div class="col-3">
          <img src="%s" alt="song preview img" class="preview_img">
           <h6 class="song-name">
               %s
           </h6>
           <span class="artist-name">
               %s
           </span>
        </div>',$song_images[$i],$song_names[$i],$song_artist[$i]);
        $html .= $html_item;
    }
        
    $html.=' </div></div>';
    return $html;
}


function display_playlist_names() {
    global $link;
    $sql = "select name from playlist_names";
    $result = mysqli_query($link,$sql);
    $html = "";
    
    while($row = mysqli_fetch_row($result)){
        $html.=sprintf('
            <a class="dropdown-item playlist_dropdown_item" href="#">%s</a>
        ',ucfirst(implode("",$row)));
    }
    
    return $html;
}

function get_recently_searched_songs_html() {
    $sql = "select
            songs.img,songs.name,songs.artist,songs.preview_url,songs.id
            from recently_searched
            join songs
                on recently_searched.song_id = songs.id
            order by recently_searched.id desc
            ";
    $array = get_sql_array($sql);
    $html = '<div class="recent_searches"> <h1> Recent Searches </h1>';

    foreach($array as $song){
        $html.= sprintf('
                <div class="recent_searches_song">
                    <img src="%s"/> 
                    <div class="side_note">
                    <span class="recent_searches_song_name">
                            %s
                    </span>

                    <span class="recent_searches_song_artist">
                             %s
                    </span>
                    <span class="recent_song"> SONG </song>
                </div>
                </div>',$song[0],$song[1],$song[2]);
    }
    
    $html .= '</div>';
    return $html;
}

function get_search_bar_results_html($name) {
    $array = get_search_bar_results($name);
    
    if (sizeof($array) <= 0) {
        $html = '<h1 style="margin-left:30vw;margin-right:40vh"> No results found </h1>';
        return $html;
    }
    
    $html = '<div class="browse-container">';
    $i = 0;
    
    foreach($array as $item) {
        if ($i % 4 == 0) {
            $html .= '<div class="row"> ';
        }
        
        $i += 1;
        $html .= sprintf('<div class="col-3 %d"> 
                        <img id="" src= "%s" alt="song preview img" class="browse-preview_img">
                       <h6 class="browse-song-name">
                           %s
                       </h6>
                        <span class="browse-artist-name">
                            %s
                        </span>
                    </div>',$item[0],$item[1],$item[3],$item[2]);
        
        if ($i % 4 == 0) {
            $html .= '</div>';
        }
        
    }
    
    if ($i % 4 != 0) {
        $html .= '</div>';
    }
    
    $html .= ' </div>';
    return $html;
}


//Function returns the HTML of the songs in the desired playlist in a table format with a cancel button
function get_playlist_table_with_cancel_button($table_name, $page_header) {
     global $link;
    $html = sprintf('<div style="position:relative; top:-40px;padding:0 3vw"><h1 class="table_header table_h1">%s</h1>
    <button style="width:120px;border-radius:90px;margin-bottom:5vh"type="button" class="btn btn-success table_play_button">Play</button>
    
    <table class="table">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col">Title</th>
          <th scope="col">Artist</th>
          <th scope="col">Album</th>
          <th scope="col"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
    width="30" height="30"
    viewBox="0 0 172 172"
    style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M86,18.14063c-37.35625,0 -67.85937,30.50313 -67.85937,67.85938c0,37.35625 30.50313,67.85938 67.85938,67.85938c37.35625,0 67.85938,-30.50312 67.85938,-67.85937c0,-37.35625 -30.50312,-67.85937 -67.85937,-67.85937zM86,26.20313c32.92188,0 59.79688,26.875 59.79688,59.79688c0,32.92188 -26.875,59.79688 -59.79687,59.79688c-32.92187,0 -59.79687,-26.875 -59.79687,-59.79687c0,-32.92187 26.875,-59.79687 59.79688,-59.79687zM86,41.65625c-2.28437,0 -4.03125,1.74687 -4.03125,4.03125v33.32605c-2.41875,1.34375 -4.03125,4.0302 -4.03125,6.98645c0,4.43438 3.62812,8.0625 8.0625,8.0625c2.95625,0 5.6427,-1.6125 6.98645,-4.03125h19.88855c2.28437,0 4.03125,-1.74688 4.03125,-4.03125c0,-2.28437 -1.74688,-4.03125 -4.03125,-4.03125h-19.88855c-0.67187,-1.20937 -1.74583,-2.28333 -2.9552,-2.9552v-33.32605c0,-2.28438 -1.74688,-4.03125 -4.03125,-4.03125z"></path></g></g></svg></th>
        </tr>
      </thead>',$page_header);
    
    $sql = sprintf("select songs.img,songs.name,songs.artist,songs.preview_url,songs.album_name,songs.duration,songs.id
    from songs
    join %s
    on songs.id = %s.song_id ",$table_name,$table_name);
    $results = mysqli_query($link,$sql);
    $array = array();

    if($results){
            while($row = mysqli_fetch_row($results)){

                if(in_array($row,$array) == false){
                     $array[] = $row;
                }

            }
    }

    $index = -1;
    
    foreach($array as $item){

        $index += 1;
        $html.=sprintf('
            <tr>
                <th style="width:6vw" scope="row"><svg class="table_play_btn %d %s %s"xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
        width="30" height="30"
        viewBox="0 0 172 172"
        style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M39.40211,24.10688c-3.51284,0.13253 -6.72211,2.99679 -6.72211,6.87664v110.03297c0,5.20301 5.77026,8.56639 10.29312,5.99648h0.00336l99.73312,-55.74547l0.00336,-0.00336c4.60481,-2.61811 4.56669,-9.46717 -0.06719,-12.03328l-0.00672,-0.00336l-99.72977,-54.27742h-0.00336c-1.13014,-0.62524 -2.33394,-0.88734 -3.50383,-0.8432zM39.44242,27.49648c0.59119,-0.00998 1.20486,0.13211 1.79726,0.46023l0.00672,0.00336l99.7432,54.2875c2.42396,1.35261 2.4394,4.65314 0.02352,6.02672l-99.73312,55.74547l-0.00672,0.00336c-2.37045,1.34837 -5.15328,-0.27473 -5.15328,-3.00664v-110.03297c0,-2.03609 1.54884,-3.45686 3.32242,-3.48703zM42.14,34.44031c-0.47495,0.00005 -0.85995,0.38505 -0.86,0.86v101.3389c-0.00066,0.30551 0.16081,0.58844 0.42417,0.74328c0.26337,0.15484 0.58911,0.15835 0.85575,0.00922l91.85875,-51.34469c0.27303,-0.15272 0.44161,-0.44164 0.44021,-0.75448c-0.0014,-0.31284 -0.17255,-0.60025 -0.44693,-0.75052l-55.74211,-30.33852c-0.27082,-0.15564 -0.60473,-0.15222 -0.8723,0.00893c-0.26757,0.16115 -0.42674,0.45471 -0.41581,0.76687c0.01093,0.31217 0.19024,0.59387 0.46843,0.73591l54.36812,29.58937l-89.21828,49.86992v-98.42633l14.21016,7.73328c0.27118,0.17054 0.61467,0.17624 0.89136,0.01479c0.27669,-0.16145 0.44072,-0.4633 0.42566,-0.78329c-0.01506,-0.31999 -0.20671,-0.6051 -0.49733,-0.73986l-15.48,-8.42867c-0.12582,-0.06828 -0.26669,-0.10407 -0.40984,-0.10414zM62.78,45.66734c-0.39835,-0.00559 -0.7484,0.26311 -0.84597,0.64937c-0.09756,0.38626 0.0829,0.78896 0.43612,0.97321l5.16,2.80844c0.27082,0.15564 0.60473,0.15222 0.8723,-0.00893c0.26757,-0.16115 0.42674,-0.45471 0.41581,-0.76687c-0.01093,-0.31217 -0.19024,-0.59387 -0.46843,-0.73591l-5.16,-2.80844c-0.1252,-0.07062 -0.26611,-0.10874 -0.40984,-0.11086zM71.38,50.35031c-0.3958,-0.00256 -0.74224,0.26532 -0.83936,0.64903c-0.09712,0.3837 0.08016,0.78415 0.42952,0.97019l3.44,1.87453c0.27082,0.15563 0.60472,0.1522 0.87229,-0.00896c0.26757,-0.16115 0.42673,-0.4547 0.41581,-0.76686c-0.01093,-0.31216 -0.19023,-0.59386 -0.46841,-0.73591l-3.44,-1.87453c-0.12551,-0.06945 -0.2664,-0.1064 -0.40984,-0.1075z"></path></g></g></svg> </th>

        <th>
        <svg class="table_cancel_btn %d %s" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
        width="30" height="30"
        viewBox="0 0 172 172"
        style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M86,8.0625c-20.82812,0 -40.44687,8.0625 -55.09375,22.84375c-14.78125,14.64688 -22.84375,34.26563 -22.84375,55.09375c0,20.82813 8.0625,40.44687 22.84375,55.09375c14.78125,14.78125 34.26563,22.84375 55.09375,22.84375c20.82813,0 40.44687,-8.0625 55.09375,-22.84375c14.78125,-14.78125 22.84375,-34.26562 22.84375,-55.09375c0,-20.82812 -8.0625,-40.44687 -22.84375,-55.09375c-14.64688,-14.78125 -34.26562,-22.84375 -55.09375,-22.84375zM86,16.125c18.67813,0 36.14792,7.2552 49.45105,20.42395c13.30312,13.16875 20.42395,30.77292 20.42395,49.45105c0,18.67813 -7.2552,36.14792 -20.42395,49.45105c-13.30312,13.16875 -30.77292,20.42395 -49.45105,20.42395c-18.67812,0 -36.14792,-7.2552 -49.45105,-20.42395c-13.30312,-13.16875 -20.42395,-30.77292 -20.42395,-49.45105c0,-18.67812 7.2552,-36.14792 20.42395,-49.45105c13.16875,-13.30312 30.77292,-20.42395 49.45105,-20.42395zM67.94336,63.82813c-1.02461,0 -2.03242,0.40365 -2.77148,1.2099c-1.6125,1.6125 -1.6125,4.16457 0,5.6427l15.18542,15.31928l-15.31927,15.18542c-1.6125,1.6125 -1.6125,4.16458 0,5.6427c0.80625,0.80625 1.88072,1.2099 2.82135,1.2099c0.94062,0 2.0151,-0.40365 2.82135,-1.2099l15.31928,-15.18542l15.18542,15.18542c0.80625,0.80625 1.88073,1.2099 2.82135,1.2099c0.94062,0 2.0151,-0.40365 2.82135,-1.2099c1.6125,-1.6125 1.6125,-4.16458 0,-5.6427l-15.18542,-15.18542l15.18542,-15.18542c1.6125,-1.6125 1.61197,-4.16405 0.13385,-5.77655c-1.6125,-1.6125 -4.16457,-1.6125 -5.6427,0l-15.31928,15.31927l-15.18542,-15.31927c-0.80625,-0.80625 -1.84661,-1.2099 -2.87122,-1.2099z"></path></g></g></svg>

        </th>
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
            </tr>
              ',$index,str_replace(" ","_",$item[1]),str_replace(" ","_",$item[2]),$item[6],$table_name,$item[1],$item[2],$item[4],get_song_duration($item[5]));
    }

    $html .= '  </tbody>
    </table> </div>';
        return $html;
}


//Display songs in the playlist in a table form 
function display_playlist_songs($table_name, $page_header) {
    global $link;
    $page_header = ucfirst($page_header);
    $html = sprintf('<div style="position:relative; top:-40px;padding:0 3vw"><h1 class="table_header table_h1">%s</h1>
    <button style="width:120px;border-radius:90px;margin-bottom:5vh"type="button" class="btn btn-success table_play_button">Play</button>',$page_header);
    
    $html.='<table class="table">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Title</th>
          <th scope="col">Artist</th>
          <th scope="col">Album</th>
          <th scope="col"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
    width="30" height="30"
    viewBox="0 0 172 172"
    style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M86,18.14063c-37.35625,0 -67.85937,30.50313 -67.85937,67.85938c0,37.35625 30.50313,67.85938 67.85938,67.85938c37.35625,0 67.85938,-30.50312 67.85938,-67.85937c0,-37.35625 -30.50312,-67.85937 -67.85937,-67.85937zM86,26.20313c32.92188,0 59.79688,26.875 59.79688,59.79688c0,32.92188 -26.875,59.79688 -59.79687,59.79688c-32.92187,0 -59.79687,-26.875 -59.79687,-59.79687c0,-32.92187 26.875,-59.79687 59.79688,-59.79687zM86,41.65625c-2.28437,0 -4.03125,1.74687 -4.03125,4.03125v33.32605c-2.41875,1.34375 -4.03125,4.0302 -4.03125,6.98645c0,4.43438 3.62812,8.0625 8.0625,8.0625c2.95625,0 5.6427,-1.6125 6.98645,-4.03125h19.88855c2.28437,0 4.03125,-1.74688 4.03125,-4.03125c0,-2.28437 -1.74688,-4.03125 -4.03125,-4.03125h-19.88855c-0.67187,-1.20937 -1.74583,-2.28333 -2.9552,-2.9552v-33.32605c0,-2.28438 -1.74688,-4.03125 -4.03125,-4.03125z"></path></g></g></svg></th>
        </tr>
      </thead>';
    
    $sql = sprintf("select songs.img,songs.name,songs.artist,songs.preview_url,songs.album_name,songs.duration,songs.id
    from songs
    join %s
    on songs.id = %s.song_id ",$table_name,$table_name);
    $results = mysqli_query($link,$sql);
    $array = array();
    
    if($results){
        
        while($row = mysqli_fetch_row($results)){
            
            if(in_array($row,$array) == false){
                     $array[] = $row;
            }

        }
        
    }

    $index = -1;
    
    foreach($array as $item){
        $index += 1;
        $html.=sprintf('
            <tr>
                <th style="width:6vw" scope="row"><svg class="table_play_btn %d %s %s"xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
        width="30" height="30"
        viewBox="0 0 172 172"
        style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M39.40211,24.10688c-3.51284,0.13253 -6.72211,2.99679 -6.72211,6.87664v110.03297c0,5.20301 5.77026,8.56639 10.29312,5.99648h0.00336l99.73312,-55.74547l0.00336,-0.00336c4.60481,-2.61811 4.56669,-9.46717 -0.06719,-12.03328l-0.00672,-0.00336l-99.72977,-54.27742h-0.00336c-1.13014,-0.62524 -2.33394,-0.88734 -3.50383,-0.8432zM39.44242,27.49648c0.59119,-0.00998 1.20486,0.13211 1.79726,0.46023l0.00672,0.00336l99.7432,54.2875c2.42396,1.35261 2.4394,4.65314 0.02352,6.02672l-99.73312,55.74547l-0.00672,0.00336c-2.37045,1.34837 -5.15328,-0.27473 -5.15328,-3.00664v-110.03297c0,-2.03609 1.54884,-3.45686 3.32242,-3.48703zM42.14,34.44031c-0.47495,0.00005 -0.85995,0.38505 -0.86,0.86v101.3389c-0.00066,0.30551 0.16081,0.58844 0.42417,0.74328c0.26337,0.15484 0.58911,0.15835 0.85575,0.00922l91.85875,-51.34469c0.27303,-0.15272 0.44161,-0.44164 0.44021,-0.75448c-0.0014,-0.31284 -0.17255,-0.60025 -0.44693,-0.75052l-55.74211,-30.33852c-0.27082,-0.15564 -0.60473,-0.15222 -0.8723,0.00893c-0.26757,0.16115 -0.42674,0.45471 -0.41581,0.76687c0.01093,0.31217 0.19024,0.59387 0.46843,0.73591l54.36812,29.58937l-89.21828,49.86992v-98.42633l14.21016,7.73328c0.27118,0.17054 0.61467,0.17624 0.89136,0.01479c0.27669,-0.16145 0.44072,-0.4633 0.42566,-0.78329c-0.01506,-0.31999 -0.20671,-0.6051 -0.49733,-0.73986l-15.48,-8.42867c-0.12582,-0.06828 -0.26669,-0.10407 -0.40984,-0.10414zM62.78,45.66734c-0.39835,-0.00559 -0.7484,0.26311 -0.84597,0.64937c-0.09756,0.38626 0.0829,0.78896 0.43612,0.97321l5.16,2.80844c0.27082,0.15564 0.60473,0.15222 0.8723,-0.00893c0.26757,-0.16115 0.42674,-0.45471 0.41581,-0.76687c-0.01093,-0.31217 -0.19024,-0.59387 -0.46843,-0.73591l-5.16,-2.80844c-0.1252,-0.07062 -0.26611,-0.10874 -0.40984,-0.11086zM71.38,50.35031c-0.3958,-0.00256 -0.74224,0.26532 -0.83936,0.64903c-0.09712,0.3837 0.08016,0.78415 0.42952,0.97019l3.44,1.87453c0.27082,0.15563 0.60472,0.1522 0.87229,-0.00896c0.26757,-0.16115 0.42673,-0.4547 0.41581,-0.76686c-0.01093,-0.31216 -0.19023,-0.59386 -0.46841,-0.73591l-3.44,-1.87453c-0.12551,-0.06945 -0.2664,-0.1064 -0.40984,-0.1075z"></path></g></g></svg> </th>


              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
            </tr>
              ',$index,str_replace(" ","_",$item[1]),str_replace(" ","_",$item[2]),$item[1],$item[2],$item[4],get_song_duration($item[5]));
    }

    $html .= '  </tbody>
    </table> </div>';
     return $html;
}
?>