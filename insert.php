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

//check url/link , is link present in DB or not
$searchShort =mysqli_query($conn,"SELECT * FROM `urldbt` WHERE shortLink='YourLink/$l'");
$rowsCount = mysqli_num_rows($searchShort);

if ($l != NULL && $rowsCount >= 1) {

    $shortAdd = "YourLink/$l";
    echo $shortAdd;
    // Data present or not in DB
    $searchInDB ="";
    $searchInDB =mysqli_query($conn,"SELECT `fullLink` FROM `urldbt` WHERE shortLink='$shortAdd'");
    
    echo "<br>"; echo "<br>";
    
    $row = mysqli_fetch_assoc($searchInDB);
    $finalFullLink = $row['fullLink'];
    echo $finalFullLink;

    header('Location: '.$finalFullLink);
    exit();


} else {
    header('Location: index.html');

}

// from here paste

// urlDB > DB Name
// urlDBT > Table Name
?>