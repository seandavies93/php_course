<?php
include("../../config.php");

if(isset($_POST['playlistId'])) {
  $playlistId = $_POST['playlistId'];

  $playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE ID='$playlistId'");
  $songsQuery = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistId='$playlistId'");
} else {
  echo "Playlist ID was not passed to the server";
}

 ?>
