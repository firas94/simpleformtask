<?php
if ($_GET["type"]=="validateusername"){

    $username = $_GET["username"];
    $ch = curl_init();
     
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/usercredentials/'.$username);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json',
        'Accept: */*'
    ));
     
    $response = curl_exec($ch);
    $responsedecoded = json_decode($response,true);
    $responsearray=array_keys($responsedecoded);
    if ($responsearray[0]=="error"){
        if ($responsedecoded["reason"]=="missing"){
            echo "Username is valid!";
        }
    }
    
    else {
        echo "Username already exists!";
    }

    curl_close($ch);

}
else if ($_GET["type"]=="signup") {

    $username = $_GET["username"];
    $password = $_GET["password"];
  
    $ch = curl_init();
    $usercredentials = array(
        'username' => $username,
        'password' => md5($password)
    );
     
    $payload = json_encode($usercredentials);
     
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/usercredentials/'.$usercredentials['username']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json',
        'Accept: */*'
    ));
    $response = curl_exec($ch);
    echo "Thank you for signing up!";
    curl_close($ch);
}
else {
    $enteredusername = $_GET["username"];
    $enteredpassword = $_GET["password"];
    $ch = curl_init();
     
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5984/usercredentials/'.$enteredusername);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json',
        'Accept: */*'
    ));
     
    $response = curl_exec($ch);
    $usercredentials = json_decode($response,true);
    if(array_keys($usercredentials)[0]=="error")
        echo "Either Username or Password entered was incorrect.";
    else if (md5($enteredpassword)==$usercredentials['password'])
        echo "You have logged in successfully!";
    
    else 
        echo "Either Username or Password entered was incorrect.";
    
    curl_close($ch);  
}
?>