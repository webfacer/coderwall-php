<?php
// Include the class
require("CoderwallApi.php");

// Make the request
$coderwallRequest = new Coderwall_Api("fredefl");

// Get the username
echo "<h2>Username is: {$coderwallRequest->username}</h2>";

// Print the result with print_r
echo "<pre>";
print_r($coderwallRequest);
echo "</pre>";
?>