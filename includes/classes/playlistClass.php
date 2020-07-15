<?php 
    class Playlist{
        
        private $songs = array();
        
        public function __construct($id,$type){
            if($type == "song"){
                $this->set_single_songs($id);
            }
            else if ($type== "playlist"){
                $this->set_playlist_songs($id);
            }
            
        }
        
        public function set_single_songs($id){
            $array = $this->get_song_details_by_id($id);
            $temp_array = array($array[0],$array[1],$array[2],$array[3],$array[4]);
            array_push($this->songs,$temp_array);
            $this->get_random_songs(20);
            
        }
        
        public function set_playlist_songs($name){
            global $link;
            $sql = sprintf("
                            select artist,name,duration,img,preview_url from songs 
                            join %s
                                on songs.id = %s.song_id
                            "
                           ,$name,$name);
            $results = mysqli_query($link, $sql);
            while($row = mysqli_fetch_row($results)){
                array_push($this->songs,$row);
            }
            
        }
        
        private function get_random_songs($limit){
            while(sizeof($this->songs) != $limit){
                $id = rand(0,4500);
                $array = $this-> get_song_details_by_id($id);
                $temp_array = array($array[0],$array[1],$array[2],$array[3],$array[4]);
                if(in_array($temp_array,$this->songs)==false){
                    array_push($this->songs,$temp_array);
                }
            }
                
            
        }
        
        private function get_song_details_by_id($id){
             global $link;
            $sql = sprintf('select artist,name,duration,img,preview_url  
                     from songs
                     where id = %d 
                     limit 1
                    ',$id);
            $result = mysqli_query($link,$sql);
            $row = mysqli_fetch_array($result);
            return $row;
        }
        
        public function get_songs(){
            return $this->songs;
        }
    }
?>