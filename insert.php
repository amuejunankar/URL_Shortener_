<?php 
session_start();


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

        // Generate Random String untill unique shortlink generated
        
        do {
            
            $randomString = '';
        
            $n = 1;
            function getRandomString($n)
            {
                $characters = 'XYZ';
                $randomString = 'shorty.io/';
            
                for ($i = 0; $i < $n; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $randomString .= $characters[$index];
                }
                return $randomString;
            }
            $shortLink = getRandomString($n);
            echo $shortLink;
            
            $result = mysqli_query($conn, "SELECT * FROM urlDBT WHERE shortLink='$shortLink'"); // execute this()
            $duplicateCount2 = mysqli_num_rows($result);  // will collect all the rows whose having the dupliactes.
    
            } while ($duplicateCount2 >= 1);

        // ---------------------------------------------------------------------
        
        
        
        +// ? Add Data to Database
        $stmt = $conn->prepare("insert into urlDBT(fullLink, shortLink) values(?,?)");
        // ? bind data with proper DataTypes
        $stmt->bind_param("ss", $fullLink,$shortLink);
        $stmt->execute();
       
        // ---------------------------------------------------------------------
        
        // ? Show success msg on Site.>>

        echo '<script> alert("Form Submitted")</script>';

        // header('location: short.html');

        // ? Terminate the DB connection
        $stmt->close();
        $conn->close();
        die();

    } else {
        
        $conn->close(); // To terminate Connection to DB
        echo '<script> alert("Duplicate Found") </script>';
        die();
    }
    
}

// urlDB > DB Name
// urlDBT > Table Name
?>