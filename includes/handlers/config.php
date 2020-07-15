<?php
    $timezone = date_default_timezone_set("Europe/London");
    $link = mysqli_connect("localhost","root","ayomide7","spotify");
    if(mysqli_connect_error()){
        echo mysqli_error();
        die;
    }
?>