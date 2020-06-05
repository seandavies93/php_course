<?php
include("includes/includedFiles.php");

if(isset($_GET['term'])) {
  $term = urldecode($_GET['term']);
} else {
  $term = "";
}
 ?>

<div class="searchContainer">
  <h4>Search for an artist, album or song</h4>
  <input type="text" class="searchInput" value="<?php echo $term; ?>" onfocus="this.value = this.value" placeholder="Start typing...">
</div>

<script>
$(function() {
  var timer;
  $(".searchInput").focus();
  $(".searchInput").keyup(function() {
    clearTimeout(timer);
    timer = setTimeout(function() {
      var val = $(".searchInput").val();
      openPage("search.php?term=" + val);
    }, 2000);
  });
});
</script>

<?php if($term == "") exit(); ?>

<div class="tracklistContainer borderBottom">
<h2>Songs</h2>
 <ul class="tracklist">

   <?php
   $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");
   if(mysqli_num_rows($songsQuery) == 0) {
     echo "<span class='noResults'>No songs found matching " . $term . "</span>";
   }
   $songIdArray = array();
   $i = 1;
   while($row = mysqli_fetch_array($songsQuery)) {
     if($i > 15) {
       break;
     }
     array_push($songIdArray, $row['id']);
     $albumSong = new Song($con, $row['id']);
     $albumArtist = $albumSong->getArtist();

     echo "<li class='tracklistRow'>
         <div class='trackCount'>
           <img class='play' src='assets/images/icons/play-white.png'>
           <span class='trackNumber'>$i</span>
         </div>


         <div class='trackInfo'>
           <span class='trackName'>" . $albumSong->getTitle() . "</span>
           <span class='artistName'>" . $albumArtist->getName() . "</span>
         </div>

         <div class='trackOptions'>
         <input type='hidden' class='songId' value='" . $albumSong->getId() . "'
           <p class='optionsButton'>...</p>
         </div>

         <div class='trackDuration'>
           <span class='duration'>" . $albumSong->getDuration() . "</span>
         </div>


       </li>";

     $i = $i + 1;
   }

   ?>



 </ul>
</div>

<div class="artistsContainer borderBottom">
  <h2>Artists</h2>

  <?php
    $artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");
    if(mysqli_num_rows($artistsQuery) == 0) {
      echo "<span class='noResults'>No artists found matching " . $term . "</span>";
    }
    while($row = mysqli_fetch_array($artistsQuery)) {
      $artistFound = new Artist($con, $row['id']);
      echo "<div class='searchResultRow'>
        <div class='artistName'>
          <span role='link' tabindex='0' onclick='openpage(\"artist.php?id=" . $artistFound->getId() . "\")'>
            " . $artistFound->getName() . "
          </span>
        </div>
      </div>";
    }

   ?>
</div>

<div class="gridViewContainer">
  <h2>Albums</h2>
  <?php
    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10;");
    if(mysqli_num_rows($albumQuery) == 0) {
      echo "<span class='noResults'>No albums found matching " . $term . "</span>";
    }
    while($row = mysqli_fetch_array($albumQuery)) {
      echo "<div class='gridViewItem'>
              <span role='link' tabindex='0' onclick='openPage(\"album.php?id=". $row['id'] . "\")'>
                <img src='" . $row['artworkPath'] . "'>
                <div class='gridViewInfo'>"
                . $row['title'] .
                "</div>
              </span>
            </div>";
    }
  ?>
</div>

<nav class="optionsMenu">
  <input type="hidden" class="songId">
  <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
