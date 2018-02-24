<?php

$app->post('/signUp', function() use($app){
    $response = [];
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('name', 'email', 'password'),$r->user);

    $db = new DbHandler();
    $usr_name = $db->purify($r->user->name);
    $usr_email = $db->purify($r->user->email);
    $usr_password = $db->purify($r->user->password);
    $usr_time_created = date("Y-m-d H:i:s");

    $signup_check  = $db->getOneRecord("SELECT user_id, email FROM users WHERE email = '$usr_email'");

     if($signup_check)
    {
        //Email already used
        $response['status'] = "error";
        $response["message"] = "User with provided E-mail Already Exists! Please use another email";
        echoResponse(201, $response);
    } else {
        //create the new user
        $usr_id = $db->insertToTable(
            [ $usr_name, $usr_email, $usr_password, $usr_time_created], /*values - array*/
            ['name', 'email','password', 'created_at'], /*column names - array*/
            "users" /*table name - string*/
        );
        if($usr_id>0){
            $response['status'] = "success";
            $response["message"] = "Signup Successful!";
            echoResponse(200,$response);
        }else{
            $response['status'] = "error";
            $response["message"] = "Something went wrong while trying to create your account, please try again later or contact Support";
            echoResponse(201, $response);
        }
    }

});

$app->post('/verifyUser', function() use($app){
    $response = [];
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'), $r->user);
    $db = new DbHandler();
    $email = $db->purify($r->user->email);
    $password = $db->purify($r->user->password);

    $signin_check = $db->getOneRecord("SELECT user_id, name, email, password FROM users WHERE email='$email'");
    if($signin_check){
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully. Taking you in...';
        echoResponse(200,$response);
    }else{
         $response['status'] = "error";
         $response['message'] = 'Login failed! Incorrect Email or Password';
         echoResponse(201, $response);
    }
});

