<?php
	// Author: god (aka ropgod)
    $PAGE = "MFA";
    include("includes/db.php");
    include("includes/header.php");
    include("includes/Base2n.php");
    require_once 'includes/googleauth.php';
    if(isset($_POST["code"])){
        $ga = new PHPGangsta_GoogleAuthenticator();
        $base32 = new Base2n(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', FALSE, TRUE, TRUE);
        $secret  = $base32->encode($_SESSION["email"]."-".$_SESSION["id"]);
        $currentTimeSlice = floor((time() / 30);
        $result = $ga->verifyCode($secret, $_POST["code"], 2);
        if($result){
            // pass
            $_SESSION["login_stage"] = 3;
            header("Location: dashboard.php");
        } else {
            // fail
            $message = "Invalid code, please try again.";
        }
    }
?>
