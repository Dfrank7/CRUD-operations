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

$app->post('/createTask', function() use($app){

    $response=[];
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('task', 'usr_tsk_id'), $r->task);
    $db = new DbHandler();
    $task = $db->purify($r->task->task);
    $usr_tsk_id = $db->purify($r->task->usr_tsk_id);
    $created_at=date("Y-m-d H:i:s");

    $isTaskExist = $db->getOneRecord("SELECT task FROM tasks WHERE task='$task'");

    if(!$isTaskExist){
        $result=$db->insertToTable(
            [ $task, $usr_tsk_id, $created_at],
            ['task', 'usr_tsk_id','created_at'], /*column names - array*/
            "tasks" /*table name - string*/
        );
        if($result>0){
        $response['status'] = 'success';
        $response['message'] = "Task Creation Successful";
        echoResponse(200, $response);
    }else{
        $response['status'] = "error";
        $response['message'] = 'Failed to create task';
        echoResponse(201, $response);
    }
    }else{
        $response['status'] = "error";
        $response['message'] = 'Task already Exist';
        echoResponse(201, $response);
    }
});

$app->get('/getUserList', function() use($app){
    $response = [];
    $db = new DbHandler();

    $users = $db->getRecordSet("SELECT * FROM users ORDER BY user_id");
    if($users){
        $response['users'] = $users;
        $response['status'] = "success";
        $response['message'] = Count($users)." User(s) where found";
        echoResponse(200, $response);
    }else{
        $response['status'] = "error";
        $response['message'] = 'No User was found';
        echoResponse(201, $response);
    }
});

$app->get('/getUserTasks', function() use($app){
    $response = [];
    $db = new DbHandler();

    $id = $db->purify($app->request->get('id'));


    $userTasks = $db->getRecordset("SELECT name, task FROM tasks LEFT JOIN users ON user_id=usr_tsk_id WHERE usr_tsk_id='$id' ");

    if($userTasks){
        $response['user_tasks'] = $userTasks;
        $response['status'] = 'success';
        $response['message'] = Count($userTasks)." User task(s) where found";
        echoResponse(200,$response);
    }else{
        $response['status'] = "error";
        $response['message'] = 'No User Task was found';
        echoResponse(201, $response);
    }
});

