<?php include("includes\handlers\\home_handler.php"); ?>

<body id="home-body">
    <div class="home-body-section">
       <h5>Recently played</h5>
        <?php echo get_recently_played() ?>
    </div>
      
    <div class="home-body-section">
       <h5>Recommended Playlists</h5>
        <?php  echo get_recommended_playlists() ?>
    </div>
    
    <div class="home-body-section home-body-sections-last-child">
       <h5>Recommended songs</h5>
        <?php  echo get_recommended_songs() ?>
    </div>   
      
    <div class="home-body-section home-body-sections-last-child">
       <h5>Recommended podcasts</h5>
        <?php  echo get_recommended_songs() ?>
    </div>
</body>
