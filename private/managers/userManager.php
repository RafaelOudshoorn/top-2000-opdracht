<?php
    class userManager{
        public static function checkExist($email){
            global $con;

            $query = "SELECT * FROM user WHERE email = ?";
            $stmt=$con->prepare($query);
            $stmt->bindValue(1,$email);
            $stmt->execute();

            return $stmt->fetchObject();
        }
        public static function addUser($user){
            global $con;

            $stmt=$con->prepare("INSERT INTO user(name, email, zipcode, residence, country, birthdate, gender, phone, broadcast, newsletter, eula) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindValue(1,$user["name"]);
            $stmt->bindValue(2,$user["email"]);
            if($user["zip"] != ""){
                $stmt->bindValue(3,$user["zip"]);
            }else{
                $stmt->bindValue(3, null, PDO::PARAM_NULL);
            }
            if($user["city"] != ""){
                $stmt->bindValue(4, $user["city"]);
            }else{
                $stmt->bindValue(4, null, PDO::PARAM_NULL);
            }
            if(isset($user["country"])){
                $stmt->bindValue(5, $user["country"]);
            }else{
                $stmt->bindValue(5, null, PDO::PARAM_NULL);
            }
            if($user["birthyear"] != ""){
                $stmt->bindValue(6, $user["birthyear"]);
            }else{
                $stmt->bindValue(6, null, PDO::PARAM_NULL);
            }
            if(isset($user["sex"])){
                $stmt->bindValue(7, $user["sex"]);
            }else{
                $stmt->bindValue(7, null, PDO::PARAM_NULL);
            }
            if($user["phone"] != ""){
                $stmt->bindValue(8, $user["phone"]);
            }else{
                $stmt->bindValue(8, null, PDO::PARAM_NULL);
            }
            if(isset($user["contact"])){
                $stmt->bindValue(9, "1");
            }else{
                $stmt->bindValue(9, "0");
            }
            if(isset($user["newsletter"])){
                $stmt->bindValue(10, "1");
            }else{
                $stmt->bindValue(10, "0");
            }
            if(isset($user["EULA"])){
                $stmt->bindValue(11, "1");
            }else{
                $stmt->bindValue(11, "0");
            }
            $stmt->execute();
        }
        public static function getUser($user){
            global $con;

            $query = "SELECT * FROM user WHERE name = ? AND email = ?";
            $stmt=$con->prepare($query);
            $stmt->bindValue(1,$user["name"]);
            $stmt->bindValue(2,$user["email"]);
            $stmt->execute();

            return $stmt->fetchObject();
        }
    }
?>