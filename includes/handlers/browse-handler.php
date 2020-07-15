 <?php
    require_once "config.php";
    require_once("../classes/playlistClass.php");
    require_once("../classes/songClass.php");
    require_once "useful_functions.php";
    require_once "home_handler.php";

    $aResult = array();

    if( !isset($aResult['error']) ) {

        switch($_POST['functionname']) {
            case 'get_search_bar_results_html':
                   $aResult['result'] = get_search_bar_results_html($_POST['arguments'][0]);
                break;
                
            case "add_song_to_recently_played":
                    add_song_to_recently_played($_POST['arguments'][0],$_POST['arguments'][1],$_POST['arguments'][2]);
                break;
                
            case "get_recently_played_songs_html":
                    if(array_key_exists("arguments",$_POST)){
                        $aResult['result'] = get_recently_played_songs_html($_POST['arguments'][0]);
                    }else{
                     $aResult['result'] = get_recently_played_songs_html();
  
                    }
                break;
                
            case "get_recommended_playlists_html":
                $aResult['result'] = get_recommended_playlists_html();
                break;
            
            case "get_song_from_playlist":
                    $aResult['result'] = get_song_from_playlist($_POST['arguments'][0],$_POST['arguments'][1]);
                break;
                
            case "add_song_to_playlist":
                    add_song_to_playlist($_POST['arguments'][0],$_POST['arguments'][1]);
                break;
                
            case "get_playlist_table_with_cancel_button":
                $aResult['result'] = get_playlist_table_with_cancel_button($_POST['arguments'][0],$_POST['arguments'][1]);
                break;
            
            case "delete_song_from_playlist":
                    delete_song_from_playlist($_POST['arguments'][0],$_POST["arguments"][1]);
                break;
                
            case "add_new_playlist":
                    add_new_playlist($_POST["arguments"][0]);
                break;
                
            case "display_playlist_songs":
                $aResult['result'] = display_playlist_songs($_POST['arguments'][0],$_POST['arguments'][1]);
            break;
            
            case "insert_song_into_playlist":
                insert_song_into_playlist($_POST['arguments'][0],$_POST['arguments'][1]);
            break;
            
            case "get_playlist_names":
                 $aResult['result'] = get_playlist_names();
            break;
                
            case "insert_song_into_recently_searched":
                insert_song_into_recently_searched($_POST["arguments"][0]);
            break;
                
            case "get_recently_searched_songs_html":
                 $aResult['result'] = get_recently_searched_songs_html();
            break;
                
            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }



    echo json_encode($aResult);


?>