<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';

//below - using the task from ajax to tell php which funtion to call depending on task
if(isset($_POST['task']) && !empty($_POST['task'])){
    switch ($_POST['task']){
        case 'SavePost':
            savePost($_POST['post'],$_POST['img'],$_POST['userid'],$_POST['username'],$_POST['postdate']);
            break;
        case 'loadPost':
            loadPost();
            break;
        case 'incrementLike':
            incrementLike($_POST['postid']);
            break;
        case 'deletePost':
            deletePost($_POST['postid']);
            break;
    }
}


//Functions below are all caled from te switch, which is taking orders from Ajax - > decides which functions to call
function savePost($post_text,$postimage,$user_id,$user_name,$dateposted){

    $query2 = "INSERT INTO newsfeed (user_id, user_name, posttext, postimage, dateposted) 
        VALUES (:user_id, :user_name, :posttext, :postimage, :dateposted)";
    $db= Connect::dbConnect();
    $pdostmt2 = $db->prepare($query2);
    $pdostmt2->bindValue(':user_id', $user_id);
    $pdostmt2->bindValue(':user_name', $user_name);
    $pdostmt2->bindValue(':user_name', $user_name);
    $pdostmt2->bindValue(':posttext', $post_text);
    $pdostmt2->bindValue(':postimage', $postimage);
    $pdostmt2->bindValue(':dateposted', $dateposted);
    $result=$pdostmt2->execute();
//        $insertedId = $db->lastInsertId();
    $pdostmt2->closeCursor();
    //var_dump($result);
    ///loadPost();
}

function loadPost(){
session_start();
    $query2 = "SELECT * FROM newsfeed ORDER BY id DESC";
    $himat= Connect::dbConnect();

    $pdostmt2 = $himat->prepare($query2);
    $pdostmt2->execute();
    $result =$pdostmt2->fetchAll(PDO::FETCH_ASSOC);
        $pdostmt2->closeCursor();
    echo "<table class='wholeTable'>";
    foreach ($result as $post){
        echo "<tr>";
        echo "<td class='usernameTable'>".$post['user_name']." posted:</td>";
        echo "<td class='dateTable'>Posted on: ".$post['dateposted']."</td>";
        echo "</tr>";
        echo"<tr class='postTable'><td colspan='2' >".$post['posttext']."</td></tr>";
        if($post['likes']>0){
            echo"<tr class='likesTable'><td colspan='2' >".$post['likes']. ' ' . 'Likes' ;"</td></tr>";
        }
        echo "<tr style='padding: 10px; border-bottom: 1px #000 solid; margin-bottom: 10px;'><td class='btnTable'><div id='btnLike' data-id='".$post['id']."' class='btn btn-primary'>Like</div></td>";
        if($post['user_id']==$_SESSION['user_id']){
            echo"<td class='btnTable'><div id='btnDelete' data-id='".$post['id']."' class='btn btn-danger'>Delete</div></td>";

        }
        else
        {
            echo "<td></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
//<!--<div id='btnEdit' data-id='".$post['id']."' class='btn btn-primary'>Edit</div>-->
function incrementLike($postid){
    $query2 = "Update newsfeed set likes=likes+1 where id=$postid";
    $himat= Connect::dbConnect();

    $pdostmt2 = $himat->prepare($query2);
    $pdostmt2->execute();
    $pdostmt2->closeCursor();
}

function deletePost($postid){
    $query2 = "Delete from newsfeed where id=$postid";
    $himat= Connect::dbConnect();

    $pdostmt2 = $himat->prepare($query2);
    $pdostmt2->execute();
    $pdostmt2->closeCursor();
}