<?php
    class musicManager{
        public static function getAll(){
            global $con;

            $stmt=$con->prepare("SELECT * FROM song WHERE inLijst = 1");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public static function addCustom($customs){
            global $con;

            foreach($customs as $custom){
                $stmt=$con->prepare("INSERT INTO song(name, artist) VALUES (?, ?)");
                $stmt->bindValue(1 ,$custom->t);
                $stmt->bindValue(2, $custom->a);
                $stmt->execute();
            }
        }
        public static function matchCustom($customs, $motivs){
            global $con;
            $updatedC = [];
            
            foreach($customs as $custom){
                $obj = new stdClass();
                foreach($motivs as $m){
                    if($m->id == $custom->id){
                        $obj = $m;
                    }
                }

                $stmt=$con->prepare("SELECT * FROM song WHERE name = ? AND artist = ? LIMIT 1");
                $stmt->bindValue(1 ,$custom->t);
                $stmt->bindValue(2, $custom->a);
                $stmt->execute();

                $new = $stmt->fetchObject();
                $obj->id = $new->id;
                array_push($updatedC, $obj);
            }

            return $updatedC;
        }
        public static function matchSongs($customs, $selected){
            global $con;
            $updatedS = $selected;
            
            foreach($customs as $custom){

                $stmt=$con->prepare("SELECT * FROM song WHERE name = ? AND artist = ? LIMIT 1");
                $stmt->bindValue(1 ,$custom->t);
                $stmt->bindValue(2, $custom->a);
                $stmt->execute();

                $new = $stmt->fetchObject();

                $key = array_search($custom->id, $selected);
                if($key !== false){
                    $rep = array($key => $new->id);
                    $updatedS = array_replace($selected, $rep);
                }
            }
                
            return $updatedS;
        }
        public static function pushVotes($votes, $motives, $user){
            global $con;

            foreach($votes as $vote){
                $m = "";
                foreach($motives as $motive){
                    if($motive->id == $vote){
                        $m = $motive->text;
                    }
                }

                $stmt=$con->prepare("INSERT INTO vote(motivation, song_id, user_id) VALUES (?, ?, ?)");
                $stmt->bindValue(1 ,$m);
                $stmt->bindValue(2, $vote);
                $stmt->bindValue(3, $user->id);
                $stmt->execute();
            }
        }
        public static function sendList($songs, $email){
            global $con;


            $msg = "<!DOCTYPE html>
                <html lang='nl'>
                    <body style='
                        background-color: #e0e0e0;
                    '>
                        <div style='
                            width: 450px;
                            height: auto;
                            margin-left: auto;
                            margin-right: auto;
                            background-color: #ffffff;
                            border: 4px solid #D9151B;                      
                            border-radius: 12px;
                        '>
                            <div style='
                                width: 80%;
                                height: auto;
                                margin-left: auto;
                                margin-right: auto;
                                padding: 5%; 
                            '>
                                <h1>Top2000 Stemlijst</h1>
                                <ul>";
                        foreach($songs as $song){

                            $stmt=$con->prepare("SELECT * FROM song WHERE id = ?");
                            $stmt->bindValue(1 ,$song);
                            $stmt->execute();

                            $info = $stmt->fetchObject();

                            $msg .= "<li>$info->name, $info->artist</li>";
                        }
            $msg .=
                            "</ul>
                        </div>
                    </div>
                </body>
            </html>";
            EmailManager::sendList($email, "Top2000 Stemlijst", $msg);
        }
    }
?>