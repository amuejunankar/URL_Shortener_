<?php 
session_start();
// *******************************************************************
// ? 1ST PART : Redirect User to FullLink using shortLink

// * When user will search with short link !!

// $conn = new mysqli('localhost','root','','urlDB');
$conn = new mysqli('localhost','id19638164_urldbusername','i/&+hqZY{o_3-](d','id19638164_urldbname');


// after slash value store in "l"
$l = $_GET['q'];
// echo "$l, ";

// ? if (true) > search,grab,redirect
// ? else (false) > redirect to HomePage

// to check data typ
// echo gettype($l)."\n";

//check url/link , is link present in DB or not\


$preSiteName = "https://slin.in";
$searchShort =mysqli_query($conn,"SELECT * FROM `urldbt` WHERE shortLink='$preSiteName/$l'");
$rowsCount = mysqli_num_rows($searchShort);

if ($l != NULL && $rowsCount >= 1) {

    $shortAdd = "$preSiteName/$l";
    // echo $shortAdd;
    
    // Data present or not in DB
    $searchInDB ="";
    $searchInDB =mysqli_query($conn,"SELECT `fullLink` FROM `urldbt` WHERE shortLink='$shortAdd'");
    
    // echo "<br>"; echo "<br>";
    
    $row = mysqli_fetch_assoc($searchInDB);
    $finalFullLink = $row['fullLink'];
    // echo $finalFullLink;

    header("location: $finalFullLink");

} else {
    header("Location: index.html");

}

// from here paste

// urlDB > DB Name
// urlDBT > Table Name
?>
