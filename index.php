<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
       <meta charset="UTF-8">
       <title>Welcome to Spotify</title>
          <link rel="shortcut icon" type="image/png" href="data:image/png;base64,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"/>
            <meta name="author" content="Samuel Ajayi"/>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/solid.css">
            <script src="https://use.fontawesome.com/3bb6a6e72e.js"></script>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <link rel="stylesheet" href="assets/css/browse.css">
            <link rel="stylesheet" href="assets/css/home.css">
            <link rel="stylesheet" href="assets/css/index.css">
             <link rel="stylesheet" href="assets/css/footer.css">
            <link rel="stylesheet" href="assets/css/main-content.css">
            <link rel="stylesheet" href="assets/css/navigation.css">


    </head>
    
    <body>
        <div id="top-container">
           
            <div id="navigation">
                <?php include "navigation-bar.html"; ?>
            </div>

            <div id="main-section">
                <?php include("main-content.php"); ?>
            </div>
            
        </div>  
              
        <footer>
            <?php include("footer.php"); ?>   
        </footer>
        
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
          <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="spotify_extension.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="includes/javascript/main.js"></script>

    </body>
</html>


