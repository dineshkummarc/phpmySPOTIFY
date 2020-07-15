<?php
    class Song{
        public $artist_name;
        public $song_name;
        public $duraton;
        public $preview_img;
        public $audio;
        
        public function __construct($artist_name,$song_name,$duraton,$preview_img,$audio){
            $this->$artist_name = $artist_name;
            $this->$song_name = $song_name;
            $this->$duraton = $duraton;
            $this->$preview_img = $preview_img;
            $this->$audio = $audio;
        }
        
    }
?>