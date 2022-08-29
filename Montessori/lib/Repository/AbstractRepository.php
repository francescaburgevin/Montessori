<?php

abstract class AbstractRepository
{

    private const DATABASE_NAME = "mysql:host=db.3wa.io;port=3306;dbname=francescanadel_montessori";
    private const DATABASE_USERNAME = "francescanadel";
    private const DATABASE_PASSWORD = "7550c59b4786b53c7a0cd9bce4830f2a";

    /* initialize connection */

    protected function connect(){
        return new PDO(self::DATABASE_NAME, self::DATABASE_USERNAME, self::DATABASE_PASSWORD);
    }

    /*  
        @param string $query > Request in SQL 
        @param string $class > 
        @param array $params > result of search in table
        @return query result
    */
    
    protected function executeQuery(string $query, string $class, array $params = []){
        
        //connect to database
        $conn = $this->connect();

        //prepare the sql demand
        $result = $conn->prepare($query);

        //binds a value to placeholder
        foreach($params as $key => $value) $result->bindValue($key, $value);

        //execute the request
        $result->execute();
        
        //declare result null
        $requete = null;
        
        //fetch result in a class
        $result->setFetchMode(PDO::FETCH_CLASS, $class);
        
        //fetch one, return object
        if($result->rowCount() === 1){
            $requete = $result->fetch();
        };
        
        //or fetch many, return table/array
        if($result->rowCount() > 1){
            $requete = $result->fetchAll();
        }
        
        //disconnect
        $conn = null;

        //return result
        return $requete;
    }
}