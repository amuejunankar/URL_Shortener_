<?php 

// * When user will search with short link !!

$conn = new mysqli('localhost','root','','urlDB');

$l = $_GET['q'];
echo "$l, ";

// Data present or not in DB
$searchInDB =mysqli_query($conn,"SELECT * FROM `urlDBT` WHERE fullLink='$l'");
$duplicateCount1 = mysqli_num_rows($searchInDB);

// --------------------------------------------
// ? Need Work Here

if ($duplicateCount1 == 0) {
    echo "Not Found in DB";
} else {
    echo "Found";
}
// --------------------------------------------
// die();

$fullLink = $_POST['fullLink'];
$shortLink = $_POST['shortLink'];

// Database Connection

$conn = new mysqli('localhost','root','','urlDB');
if($conn->connect_error) {
    die('Connection Failed');

} else {
    
    // Collect Duplicates
    
    $result = mysqli_query($conn, "SELECT * FROM urlDBT WHERE fullLink='$_POST[fullLink]'"); // execute this()
    $duplicateCount = mysqli_num_rows($result);  // will collect all the rows whose having the dupliactes.

    //check duplicate condition
    if ($duplicateCount == 0) {
        // Add Data to Database
        $stmt = $conn->prepare("insert into urlDBT(fullLink) values(?)");
        // bind data with proper DataTypes
        $stmt->bind_param("s", $fullLink);
        $stmt->execute();
        echo "Registered successfully";
        $stmt->close();
        $conn->close();

    } else {
        echo "the URL Link is already Exits > $fullLink" ;
        $conn->close(); // To terminate Connection to DB

        
    }
    
}

// urlDB > DB Name
// urlDBT > Table Name
?>