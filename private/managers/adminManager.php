<?php
    class adminManager{
        public static function selectOnCode($code){
            global $con;

            $query = "SELECT * FROM admin WHERE code = ? ";
            $stmt=$con->prepare($query);
            $stmt->bindValue(1,$code);
            $stmt->execute();

            return $stmt->fetchObject();
        }
        public static function logout(){
            session_start();
            session_unset();
            session_destroy();
        
            return header("location:.");
        }
        public static function getColumns($tableName){
            global $con;

            $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?";
            $stmt=$con->prepare($query);
            $stmt->bindValue(1,$tableName);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public static function tableContent($tableName, $limit, $filter){
            global $con;

            $query = "SELECT * FROM $tableName $filter LIMIT $limit";
            $stmt=$con->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public static function tableContentOnId($tableName, $iId){
            global $con;

            $query = "SELECT * FROM $tableName WHERE id = ? ";
            $stmt=$con->prepare($query);
            $stmt->bindValue(1,$iId);
            $stmt->execute();

            return $stmt->fetchObject();
        }
        public static function columnDesc($iTableName){
            global $con;

            $query = "DESC $iTableName";
            $stmt=$con->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public static function insert($uTableName, $post){
            global $con;

            //QUERY BOUWEN
            $query = "INSERT INTO $uTableName (";
            foreach($post as $item => $item2){
                $query .= "$item,";
            }
            $query .= ") ";
            $query .= "VALUES (";
            foreach($post as $item => $item2){
                $query .= "?,";
            }
            $query .= ") ";
           //QUERY BOUWEN
            $goeieQuery = str_replace(",)", ")", $query);
            $stmt = $con->prepare($goeieQuery);

           //BINDVALUES OPBOUWEN
            $count = 1;
            foreach($post as $item => $item2){
                if($item2 != "on"){
                    $stmt->bindValue($count, $item2);
                }else{
                    $stmt->bindValue($count, "1");
                }
                $count++;
           }
            $stmt->execute();
        }
        public static function update($uTableName, $post, $iId){
            global $con;
            $count1 = 0;
            foreach($post as $item => $item2){
                if(str_ends_with($item,"_check")){
                    $check = str_replace("_check", "", $item);
                    $post[$check] = $post[$item];
                    unset($post[$item]);
                    
                }
                $count1++;  
            }
            //QUERY BOUWEN
            $query = "UPDATE $uTableName SET ";
            foreach($post as $item => $item2){
                $query .= "$item = ?, ";
            }
            $query .= "WHERE id = ? ";
            $goeieQuery = str_replace(", WHERE", " WHERE", $query);
            $stmt = $con->prepare($goeieQuery);
            //BINDVALUES OPBOUWEN
            $count = 1;
            foreach($post as $item => $item2){
                if($item2 != "on"){
                    $stmt->bindValue($count, $item2);
                }else{
                    $stmt->bindValue($count, "1");
                }
                $count++;
            }
            $stmt->bindValue($count, $iId);
            echo $stmt->execute();
        }
        public static function delete($dTableName, $iId){
            global $con;

            $query = "DELETE FROM $dTableName WHERE id = ? ";

            $stmt = $con->prepare($query);
            $stmt->bindValue(1,$iId);
            $stmt->execute();
        }
    }
?>