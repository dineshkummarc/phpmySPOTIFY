var audio = document.querySelector("audio");
var pause = document.querySelector(".pause");
var play = document.querySelector(".play");
var mainContent = document.querySelector("#main-content-main");
var repeat = false;
var shuffle=false;
var historyContents = [];
var historyIndex = -1;
var playlistSongs = [];
var playlistIndex = -1;
var progress = document.querySelector(".progress");
var canvas = document.querySelector(".progress-bar");

//Following event listener checks which part of the document has been clicked on and performs different operations for different elements on the document. All the elements in the if statements are dynamically created so an eventlistener cannot be added to them before the element is created 
document.addEventListener("click", function (e) {
    e.preventDefault();
    
    if (e.target.classList.contains("browse-preview_img")) {
        ajaxCall({
            passedFunctionName: 'insert_song_into_playlist',
            passedArguments : [e.target.parentElement.classList[1],"recently_searched"]
        });
        getSongFromPlaylist(e.target.parentElement.classList[1]);
        
    }else if(e.target.classList.contains("recently_played_preview_play")) { 
        getSongFromPlaylist(e.target.parentElement.classList[1].split("_").join(" ")); 
        
    }else if(e.target.classList.contains("table_play_btn")) {
        playlistIndex = parseInt(e.target.classList[1]) + 1;
        getPreviousSong();
        
    }else if(e.target.classList.contains("playlist_name")) {
        displayPlaylistSongsWithCancelButton(e.target.textContent,e.target.textContent);
        
    }else if(e.target.classList.contains("playlist_dropdown_item")) {
        insertSongIntoPlaylist(e);
        
    }else if(e.target.classList.contains("table_play_button")) {
        playlistIndex = 1
        getPreviousSong();
        
    }else if (e.target.classList.contains("recommended_playlist_preview_img")) {
        displayPlaylistSongs(e.target.classList[1],e.target.classList[1].split("_").join(" "));
        
    }else if (e.target.classList.contains("pauseImg")) {
        audio.pause();
        displayButton(play, pause);
        
    } else if (e.target.classList.contains("playImg")) {
        audio.play();
        displayButton(pause, play);
        
    } else if (e.target.id === "main-nav-logo") {
        displayHomepage();
        
    } else if (e.target.classList.contains("fa-arrow-left")) {
        directPage("backwards");
        
    }
    else if (e.target.classList.contains("table_cancel_btn")) {
        deleteSongFromPlaylist(e,e.target.classList[2]);
        
    }else if (e.target.classList.contains("fa-arrow-right")) {
        directPage("forward");
        
    }else if (e.target.classList.contains("main-like-btn")) {
        addSongToPlaylist(e.target.parentElement.classList[1],"liked_songs");
        alert("Added to liked songs");
        
    } else if (e.target.id === "footer-previous-btn") {
        getPreviousSong();
        
    }
    else if (e.target.id === "footer-next-btn") {
        getNextSong();
        
    }else if(e.target.id === "nav_item_liked_songs") {
        displayPlaylistSongsWithCancelButton("liked_songs","Liked songs");
        
    }else if (e.target.id === "repeat-active") {
        document.querySelector(".repeat").innerHTML = '<img id="repeat-not-active" alt="shuffle" src="assets/images/icons/repeat.png" alt="">';
        repeat = false;
        
    }else if (e.target.id === "repeat-not-active") {
        document.querySelector(".repeat").innerHTML = '<img id="repeat-active" alt="shuffle" src="assets/images/icons/repeat-active.png" alt="">';
        repeat = true;
        
    }else if (e.target.id === "shuffle-not-active") {
        document.querySelector(".shuffle").innerHTML = ' <img alt="shuffle" id="shuffle-active" src="assets/images/icons/shuffle-active.png" alt="">';
        shuffle = true;
        
    }else if (e.target.id === "shuffle-active") {
        document.querySelector(".shuffle").innerHTML = ' <img alt="shuffle" id="shuffle-not-active" src="assets/images/icons/shuffle.png" alt="">';
        shuffle = false;
    }

});

//Adds the selected song into the playlist the user has clicked on in the playlist dropdown menu
function insertSongIntoPlaylist(e) {
    let playlistName = e.target.textContent;
    let songId = e.target.classList[1];

    ajaxCall({
        passedFunctionName: 'insert_song_into_playlist',
        passedArguments : [songId,playlistName]
    });
    
    alert("Song added to " + playlistName);
    getPlaylistNames();
}

//Deletes song from playlist using the playlist name and the id of the song 
function deleteSongFromPlaylist(e, tableName) {
    let songId = e.target.classList[1];
    let PlaylistName = e.target.classList[2];
    
    ajaxCall({
        passedFunctionName: 'delete_song_from_playlist',
        passedArguments : [songId,tableName]
    });
    
    displayPlaylistSongsWithCancelButton(PlaylistName,PlaylistName);
}

// displays playlist songs in a table format with a cancel button 
function displayPlaylistSongsWithCancelButton(tableName, displayName) {
    getSongFromPlaylist(tableName,"playlist");
    
     ajaxCall({
         passedFunctionName: 'get_playlist_table_with_cancel_button',
         passedArguments:[tableName,displayName],
         successFunction : updateMainSectionHTML
    });
  
}

// display playlist songs in a table format 
function displayPlaylistSongs(playlistName,displayName){
    getSongFromPlaylist(playlistName,"playlist");
    
    ajaxCall({
        passedFunctionName: 'display_playlist_songs',
        passedArguments:[playlistName,displayName],
        successFunction : updateMainSectionHTML
    });
}

//Function takes the html passed to it and updates the main section of the page
let updateMainSectionHTML = function(html = ""){    
    mainContent.innerHTML = html;
    historyContents.push({
            html: mainContent.innerHTML,
            pageName: "main_content"
        })
        historyIndex++;
    
}

//Adds a song to a playlist 
function addSongToPlaylist(songId,playlistName) {
    ajaxCall({
        passedFunctionName: 'add_song_to_playlist',
        passedArguments: [songId,playlistName]
    });
}

// Plays the song to user using a audio element
function playSong({ audioSrc, imgSrc, previewTrackName, previewArtistName }) {
    let albumArtwork = document.querySelector(".album-artwork");
    let trackName = document.querySelector(".track-name");
    let artistName = document.querySelector(".footer-artist-name");
    
    trackName.innerText = previewTrackName;
    artistName.innerText = previewArtistName;
    albumArtwork.src = imgSrc;
    audio.src = audioSrc;
    
    if (audio.src === "http://localhost/sammyphp/spotify/null") {
        alert("Preview not available");
        displayButton(play, pause);
    } else {
        displayButton(pause, play);
    }
    
    updateRecentlyPlayedPlaylist(imgSrc, previewTrackName, previewArtistName);
}

//Shows and hide a button 
function displayButton(btnToShow,btnToHide){
    btnToShow.style.display = "inline-block";
    btnToHide.style.display = "none";
}

//When a song has been played, the function adds the song to the recently played table so it can appear in the "recently played" part of the page
function updateRecentlyPlayedPlaylist(imgSrc, previewTrackName, previewArtistName) {
    ajaxCall( {
        passedFunctionName: 'add_song_to_recently_played',
        passedArguments: [imgSrc, previewTrackName, previewArtistName]
    });
}

let createHeaderForHomepage =  function(results = [], sectionName="") {
    let html = `
        <div class="home-body-section">`;
    
    if (sectionName === "Recommended_playlists") {
        html += `<h5 > Recommended Playlists</h5>`;
    } else if (sectionName === "Recently_played") {
        html += `<h5 > Recently Played</h5>`;
    }

    html += results;
    html += `</div >`;
    html += `</div >`;
    mainContent.innerHTML += html;

}


let displayHomepage = function (direction = "") {
    mainContent.innerHTML = "";
    ajaxCall({
        passedFunctionName: 'get_recently_played_songs_html',
        successFunction: createHeaderForHomepage,
        header_title: "Recently_played"
    });

    ajaxCall({
        passedFunctionName: 'get_recommended_playlists_html',
        successFunction: createHeaderForHomepage,
        header_title: "Recommended_playlists"
    });
    
    if (direction === "") {
        historyContents.push({
            html: mainContent.innerHTML,
            pageName: "homepage"
        })
        historyIndex++;
    }
    
   getPlaylistNames()

};

//"directPage" is the function in charge of moving the user from one page to another when the arrow buttons are clicked.
//It used a array to keep track of the html in each page when the arrows are clicked.
//historyIndex keep track of where in the array the current page is stationed, this allows the user to move forward and backwards
let directPage = function (direction) {
    
    if (historyContents.length !== -1 && historyIndex > -1 && historyIndex < historyContents.length && historyIndex !== historyContents.length) {
        
        if (historyIndex > 0 && direction !== "forward") {
            
            if (historyIndex > 0) {
                historyIndex--;
            }

        } else if (historyIndex < historyContents.length && direction !== "backwards" && (historyIndex + 1) !== historyContents.length) {
                historyIndex++;
        }

        if (historyContents[historyIndex].pageName === "homepage") {
            displayHomepage(direction);
           
        } else {
            document.querySelector("#main-content-main").innerHTML = historyContents[historyIndex].html;
        }
        
    }
    
}

let getSongFromPlaylist = function (id,type="song") {
    ajaxCall({
        passedFunctionName: 'get_song_from_playlist',
        passedArguments:[id,type],
        successFunction: loadSong,
    });
   
}

//Passes song from the PHP post reqeuest to "playSong" function 
let loadSong = function (results = []) {
    playlistSongs = results;
    playlistIndex = 0;
    playSong({
        audioSrc: `${results[0][4]}`,
        imgSrc: `${results[0][3]}`,
        previewTrackName: results[0][1],
        previewArtistName: results[0][0]
    });
}

//Gets the next song to be played when the next song button is clicked. 
//It checks if the current song is at the end of the playlist array. If so it does not allow the user to play the next song 
//If the repeat button has been clicked it plays the same song again 
// If Shuffle button has been clicked it will get a random song next (within the same playlist)
let getNextSong = function () {
    
    if (playlistIndex < playlistSongs.length-1 && playlistIndex !== -1 || repeat) {
        
        if(repeat === false){
            if(shuffle){
                playlistIndex = Math.floor(Math.random() * (playlistSongs.length-1 - 0 + 1)) + 0;
            }else{
                playlistIndex++;
            }
        }
        
        playSong({
            audioSrc: `${playlistSongs[playlistIndex][4]}`,
            imgSrc: `${playlistSongs[playlistIndex][3]}`,
            previewTrackName: playlistSongs[playlistIndex][1],
            previewArtistName: playlistSongs[playlistIndex][0]
        });
    }
    
}

//Gets the previous song in playlist when the previous button is clicked.
// It checks if the current song is at the start of the array, if so the previous button is disabled 
let getPreviousSong = function () {
    
    if (playlistIndex > 0) {
        playlistIndex--;
    }
    
    playSong({
        audioSrc: `${playlistSongs[playlistIndex][4]}`,
        imgSrc: `${playlistSongs[playlistIndex][3]}`,
        previewTrackName: playlistSongs[playlistIndex][1],
        previewArtistName: playlistSongs[playlistIndex][0]
    });
    
}

//Pause button is replaced by play button when the song ends. It then gets the next song to be played 
$("audio").bind('ended', function () {
    displayButton(play, pause);
    
    if (playlistIndex !== -1) {
        getNextSong();
    }
    
});

canvas.addEventListener("click", function(e) {
    if (!e) {
        e = window.event;
    } //get the latest windows event if it isn't set
    try {
        //calculate the current time based on position of mouse cursor in canvas box
        audio.currentTime = audio.duration * (e.offsetX / canvas.clientWidth);
    }
    catch (err) {
    // Fail silently but show in F12 developer tools console
        if (window.console && console.error("Error:" + err));
    }
}, true);

//updates the time labels as the song is being played 
audio.addEventListener('timeupdate', function(){
    let remainingPlayingTime = document.querySelector(".remaining");
    let currentPlayingTime = document.querySelector(".current");
    let currentTime = audio.currentTime;
    let duration = audio.duration;
    
    remainingPlayingTime.innerText = "0."+Math.floor(30-audio.currentTime).toString();
    
    currentPlayingTime.innerText = "0." +audio.currentTime.toString().slice(0,audio.currentTime.toString().indexOf("."));
    $('.progress').stop(true,true).animate({'width':(currentTime +.25)/duration*100+'%'},250,'linear');
});


//Allows user to add a new playlist by using a model with a form in the model
document.querySelector(".modal-btn").addEventListener("click",function(){
    let enteredPlaylist = document.querySelector(".modal-body>input").value;
    
    if(enteredPlaylist.trim().length == 0){
        alert("Cannot enter empty playlist name");
    }else{
       ajaxCall({
            passedFunctionName: 'add_new_playlist',
           passedArguments:[enteredPlaylist],
            successFunction : getPlaylistNames
        }); 
        
        displayHomepage();
    }
    
})


//Displays playlist names in the side-navigation bar
let displaySideNavPlaylistNames = function (result) {
    let html = '<span class="sub-heading">PLAYLISTS</span>';
    
    for(let name of result){
        html += `<div class="nav-item">
                    <a href="" class="nav-item-link playlist_name">${name}</a>
                </div>`;
        document.querySelector(".playlist_names_group").innerHTML = html;
    }
    
}

let getPlaylistNames = function() {
    ajaxCall({
        passedFunctionName: 'get_playlist_names',
        successFunction : displaySideNavPlaylistNames
    });
}

document.querySelector("#recently_played").addEventListener("click",function() {
   ajaxCall({
        passedFunctionName: 'get_recently_played_songs_html',
        passedArguments :[true],
        successFunction: updateMainSectionHTML
    });
});


document.querySelector("#browse-nav-item").addEventListener("click",function() {
    ajaxCall({
        passedFunctionName: 'get_recently_searched_songs_html',
        passedArguments :[true],
        successFunction: updateMainSectionHTML
    });
});



function ajaxCall({passedFunctionName, passedArguments=[], successFunction = null,header_title = null }) {
    this.successFunction = successFunction;
    $.ajax({
        type: "POST",
        url:"includes/handlers/browse-handler.php",
        dataType: 'json',
        data: { functionname: passedFunctionName, arguments: passedArguments },

        success: function (obj, textstatus) {
            if (!('error' in obj)) {
                if (successFunction !== null) {
                    if (header_title != null) {
                        successFunction(obj.result, header_title);
                    } else {
                        successFunction(obj.result);
                    }
                }
                    
            }
            else {
                console.log(obj.error);
            }
        },
        error: function (err) {
            console.log(err);
        }
    })
}


$("#search_input").change(function () {
    setTimeout(function () {
        if ($("#search_input").val().trim() === "") {
           return;
        } else {
            ajaxCall({
                passedFunctionName: 'get_search_bar_results_html',
                passedArguments: [$("#search_input").val()],
                successFunction: updateMainSectionHTML
            });
        }
    }, 1000);
    
});

displayHomepage();