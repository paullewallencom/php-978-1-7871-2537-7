<?php

class Controller
{
    function connect () {
        $db_con = mysql_pconnect (DB_SERVER,DB_USER,DB_PASS);
        if (!$db_con) return false;
        if (!mysql_select_db (DB_NAME, $db_con)) return false;
        return $db_con;
    }

    function getArticle($id)
    {
        $dbConn = $this->connect();

        $query = "SELECT articles.id, articles.title, articles.extract, articles.text, articles.updated_at, articles.category_id, users.username FROM `articles` 
INNER JOIN `users` ON users.id = articles.user_id 
WHERE articles.id = " . $id . " LIMIT 1;";

        $result = mysql_query ($query, $dbConn);

        $data = mysql_fetch_assoc ($result);
        $data['category'] = $this->getCategory($data['category_id']);
        $data['category'] = $data['category']['value'];
        return $data;
    }

    function getArticleComments($id)
    {
        $dbConn = $this->connect();

        $arrComments = array();
        $query = "SELECT comments.id, comments.comment, users.username  
FROM `comments` 
INNER JOIN `users` ON comments.user_id = users.id 
WHERE comments.status = 'valid' AND comments.article_id = " . $id . " 
ORDER BY comments.id DESC";

        $result = mysql_query ($query, $dbConn);
        while ( $row = mysql_fetch_assoc ($result)) {
            array_push( $arrComments,$row );
        }

        return $arrComments;
    }

    function postComment($comment,$user_id,$article_id)
    {
        $dbConn = $this->connect();

        $query  = "INSERT INTO `comments` (comment, user_id, article_id) VALUES ('$comment','$user_id','$article_id')";
        mysql_query($query, $dbConn);
    }


    function call($url, $method, $field = null)
    {
        $ch = curl_init();
        if(($method == 'DELETE') || ($method == 'PUT')) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST,true);
        }
        if($field) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, "value=".$field);

        }
        $result=curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}