<?php

    

// *******************************************************************
// ? 2nd PART : Creating,Adding,Generating  > fullLink & shortLink


$fullLink = $_POST['fullLink'];
$shortLink = '';

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
        
        function getRandomString($n)
            {
                
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = 'YourLink/';
            
                for ($i = 0; $i < $n; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $randomString .= $characters[$index];
                }
                return $randomString;
            }
        
        do {
        
            $n = 3;
            
            $shortLink = getRandomString($n);
            echo $shortLink;
            
            $result = mysqli_query($conn, "SELECT * FROM urlDBT WHERE shortLink='$shortLink'"); // execute this()
            $duplicateCount2 = mysqli_num_rows($result);  // will collect all the rows whose having the dupliactes.
    
            } while ($duplicateCount2 >= 1);

        // ---------------------------------------------------------------------
        
        // ? Add Data to Database
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
        
        // When same FullLink is added 
        // 1> Find ShortLink from DB and Return it.
        
        $sql = mysqli_query($conn, "SELECT `shortLink` FROM urlDBT where fullLink='$fullLink'");
        $row = mysqli_fetch_assoc($sql);
        $finalshortLink = $row['shortLink'];
        echo $finalshortLink;

        // ! Show it to that short.html /////NEED WORK HERE

        $conn->close();
        die();
    }
    
}


?>