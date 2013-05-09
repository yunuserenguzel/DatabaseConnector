<?php
class DatabaseConnector{

    public static $hostName='',$user='root',$password='',$database='';

    private static $isConnected = false;

    public static function checkError($sql=''){
        if(mysql_errno() > 0)
            die("$sql : <br/> error no: " . mysql_errno() . ' error: '. mysql_error());

    }

    public static function get_results( $sql,$ignoreError = false ){
        if(DatabaseConnector::$isConnected == false){
            DatabaseConnector::connect();
        }
        $resultset = mysql_query($sql);
        if(!$ignoreError)
            DatabaseConnector::checkError($sql);
        $results = array();
        while($row = mysql_fetch_object($resultset))
            $results[] = $row;
        return $results;
    }

    public static function get_single( $sql,$ignoreError = false ){
        if(DatabaseConnector::$isConnected == false){
            DatabaseConnector::connect();
        }
        $sql .= ' LIMIT 1';
        $resultset = mysql_query($sql);
        if(!$ignoreError)
            DatabaseConnector::checkError($sql);
        return mysql_fetch_object($resultset);
    }

    public static function get_value( $sql,$ignoreError = false ){
        if(DatabaseConnector::$isConnected == false){
            DatabaseConnector::connect();
        }
        $sql .= ' LIMIT 1';
        $resultset = mysql_query($sql);
        $row = mysql_fetch_array($resultset, MYSQL_NUM);
        if(!$ignoreError)
            DatabaseConnector::checkError($sql);
        return $row[0];
    }

    public static function query( $sql,$ignoreError = false ){
        if(DatabaseConnector::$isConnected == false){
            DatabaseConnector::connect();
        }
        mysql_query($sql);
        if(!$ignoreError)
            DatabaseConnector::checkError($sql);
    }

    private static  function connect(){
        mysql_connect(DatabaseConnector::$hostName,DatabaseConnector::$user,DatabaseConnector::$password);
        mysql_select_db(DatabaseConnector::$database);
        DatabaseConnector::$isConnected = true;
    }

}