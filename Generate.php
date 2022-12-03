<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <h1 style="margin-top: 11%;
                color: #11b337;
                text-decoration: none;
                font-family: 'Cairo',sans-serif;
                font-size:50px">
                <a
                style="margin-top: 11%;
                    color: #000000;"
                href="http://slin.in/">URL SHORTY</a>
                </h1>
                
    <!-- <div class="wrapper">  

        <form name="urlForm" >
            <input type="text" value="<?php echo $finalshortLink ?>" name="fullLink" required class="input" id="textPaste" readonly/>
            <button class="btn" value="submit" type="submit" id="submit" name="submit" onclick="submitForm()" 
                    >Copy</button>
    </div> -->

    <script src="script.js"></script>

</body>

</html>


<!-- ------------------------------------------------------------------------------------------------------------------------- -->


<?php
   
// *******************************************************************
// ? 2nd PART : Creating,Adding,Generating  > fullLink & shortLink

global $finalshortLink;
$fullLink = $_POST['fullLink'];
$shortLink = '';

// Database Connection

// $conn = new mysqli('localhost','root','','urlDB');
$conn = new mysqli('localhost','username','pass','dbname');

if($conn->connect_error) {
    die('Connection Failed from Site');

} else {
    
    // Collect Duplicate
    
    $result = mysqli_query($conn, "SELECT * FROM `urldbt` WHERE fullLink='$_POST[fullLink]'"); // execute this()
    $duplicateCount = mysqli_num_rows($result);  // will collect all the rows whose having the dupliactes.

    //check duplicate condition
    if ($duplicateCount == 0) {

        // Generate Random String untill unique shortlink generated
        
        function getRandomString($n)
            {
                
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = 'https://slin.in/';
            
                for ($i = 0; $i < $n; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $randomString .= $characters[$index];
                }
                return $randomString;
            }
        
        do {
        
            $n = 3;
            
            $shortLink = getRandomString($n);
            echo "<h2>$shortLink</h2>";
            
            $result = mysqli_query($conn, "SELECT * FROM `urldbt` WHERE shortLink='$shortLink'"); // execute this()
            $duplicateCount2 = mysqli_num_rows($result);  // will collect all the rows whose having the dupliactes.
    
            } while ($duplicateCount2 >= 1);

        // ---------------------------------------------------------------------
        
        // ? Add Data to Database
        
        if (!empty($fullLink)) {
            $sql = "INSERT INTO urldbt (fullLink, shortLink) values('$fullLink','$shortLink')";
            if(mysqli_query($conn, $sql)){
                // echo "Records inserted successfully.";
            } else{
                // echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
         // Close connection
        mysqli_close($conn);
            
        } // if() end
        
             
        // ---------------------------------------------------------------------
        
        // ? Show success msg on Site.>>

        // echo '<script> alert("Form Submitted")</script>';
        
        // ! NEED WORK HERE TOO


        $sql = mysqli_query($conn, "SELECT `shortLink` FROM `urldbt` where fullLink='$fullLink'");
        $row = mysqli_fetch_assoc($sql);
        $finalshortLink = $row['shortLink'];
        echo "<h2>$finalshortLink</h2>";


        // header('Location: short.html');

        // ? Terminate the DB connection
        $stmt->close();
        $conn->close();
        die();

    } else {
        
        // When same FullLink is added 
        // 1> Find ShortLink from DB and Return it.
        
        $sql = mysqli_query($conn, "SELECT `shortLink` FROM `urldbt` where fullLink='$fullLink'");
        $row = mysqli_fetch_assoc($sql);
        $finalshortLink = $row['shortLink'];
        echo "<h2>$finalshortLink</h2>";


        // header('Location: short.html');

        // ! Show it to that short.html /////NEED WORK HERE
        echo "<br>";
        // TEXTBOX n COPY BTN
        

        $conn->close();
        die();
    }
    
}


?>



