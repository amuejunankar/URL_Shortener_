<?php 
session_start();
// *******************************************************************
// ? 1ST PART : Redirect User to FullLink using shortLink


// * When user will search with short link !!

$conn = new mysqli('localhost','root','','urlDB');

// after slash value store in "l"
$l = $_GET['q'];
echo "$l, ";

// ? if (true) > search,grab,redirect
// ? else (false) > redirect to HomePage

echo gettype($l)."\n";

if ($l != NULL) {

    $shortAdd = "YourLink/$l";
    echo $shortAdd;
    // Data present or not in DB
    $searchInDB ="";
    $searchInDB =mysqli_query($conn,"SELECT `fullLink` FROM `urldbt` WHERE shortLink='$shortAdd'");
    
    while($row = mysqli_fetch_assoc($searchInDB)) {
        $fromLink = $row['fullLink'];
    }
    

} else {
    
    

}

// from here paste















// urlDB > DB Name
// urlDBT > Table Name
?>