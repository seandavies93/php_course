<?php include("includes/header.php");

if(isset($_GET['id'])) {
  $albumId = $_GET['id'];
} else {
  header("Location: index.php");
}

$album = new ALbum($con, $albumId);

$artist = $album->getArtist();
$artistId = $artist->getId();
?>

<div class="entityInfo">
  <div class="leftSection">
    <img src="<?php echo $album->getAlbumArtwork(); ?>">
  </div>
  <div class="rightSection">
    <h2><?php echo $album->getTitle(); ?></h2>
    <p role="link" tabindex="0" onclick="openPage('artist.php?id=$artistId')"> By <?php echo $artist->getName(); ?></p>
    <p><?php echo $album->getNumberOfSongs(); ?> songs</p>
  </div>
</div>

<div class="trackListContainer">
  <ul class="trackList">
    <?php $songIdArray = $album->getSongIds();
    $i = 1;
    forEach($songIdArray as $songId) {
      $albumSong = new Song($con, $songId);
      $albumArtist = $albumSong->getArtist();

      echo "<li class='trackListRow'>
              <div class='trackCount'>
              <img class='play' src='assets/images/icons/play-button.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                <span class='trackNumber'>$i</span>
              </div>
              <div class='trackInfo'>
              <span class='trackName'>" . $albumSong->getTitle() . "</span>
              <span class='artistName'>" . $albumArtist->getName() . "
              </div>

              <div class='trackOptions'>
                <p class='optionsButton'>...</p>
              </div>

              <div class='trackDuration'>
                <span class='duration'>" . $albumSong->getDuration() . "</span>
              </div>

              </li>";
      $i++;

    }
    ?>

    <script>
      var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
      tempPlaylist = JSON.parse(tempSongIds);
    </script>
  </ul>
</div>

<nav class="optionsMenu">
  <input type="hidden" class="songId">
  <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>

<?php include("includes/footer.php"); ?>
