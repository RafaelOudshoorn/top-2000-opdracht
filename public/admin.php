<?php
    include "../private/autoloader.php";
    $admin = isset($_SESSION["admin"]) ?? "admin";

    if(isset($_POST["login"])){
        $code = $_POST["code"];
        $codeCheck = adminManager::selectOnCode($code);
        if($codeCheck){
            $_SESSION["id"] = $codeCheck->id;   
            $_SESSION["code"] = $code;
            $_SESSION["admin"] = "admin";
            $_SESSION["table-limit"] = 25;
            header("location:admin");
        }else{
            $warning = "Code ongeldig!!";
        }
    }
    if(isset($_POST["logout"])){
        adminManager::logout();
        header("location:admin");
    }
?>
<!doctype html>
<html lang="en">
    <head>
<?php
    $webtitle = "admin";
    $stylesheets = array("admin");
    include "../private/includes/head.php";    
?>
    </head>
    <body>
    <?php
        include "../private/includes/header.php";
        if($admin != 1){
            echo "<main class='main-container' style='height:90vh;width:98vw'>";
                echo "<div class='loginform'>";
                    if(isset($warning)){echo "<h5 style='color:red;'>$warning<h5>";}
                    echo "<h5>Login met je code</h5>";
                    echo "<form method='POST'>";
                        echo "<input type='text' name='code' class='form-control' placeholder='Enter code...'>";
                        echo "<button type='submit' name='login' class='btn w-100' style='background:rgb(218,13,20);color:#FFF'>log in</button>";
                    echo "</form>";
                echo "</div>";
            echo "</main>";
        }
        if($admin == 1){
            $admin = adminManager::selectOnCode($_SESSION["code"]);
            // array met alle database tabellen.
            $dbTables = array(
                "song",
                "vote",
                "radiodj",
                "radioschema",
                "ticket",
                "user",
                "admin"
            );
            if(!isset($_GET["content"])){
                $tableContent = $dbTables[0];
            }else{
                if(in_array($_GET["content"],$dbTables)){
                    $tableContent = $_GET["content"];
                }else{
                    $tableContent = $dbTables[0];
                }
            }
            echo "<main class='main-container d-block'>";
                echo "<div class='p-2' style='height:40px;display:flex'>";
                    echo "<h5 class='w-75'><a href='admin' style='text-decoration:none;color:#000'>Ingelogt als: $admin->name</a></h5>";
                    echo "<form method='POST' class='w-25' style='margin-top:-2px;'>";
                        echo "<button type='submit' name='logout' class='btn w-50' style='min-width:80px;background:rgb(218,13,20);color:#FFF;float:right;'>log out</button>";
                    echo "</form>";
                echo "</div>";
                //
                echo "<div class='container'>";
                    echo "<div class='row justify-content-md-center text-center mt-4 w-75' style='margin-left:auto;margin-right:auto;'>";
                        echo "<h5 class='w-100'>Open tabel</h5>";
                        //
                        foreach($dbTables as $table){
                            echo "<div class='lijst-tables p-2 col-3' onclick=\"window.location.href = 'admin?content=$table'\" style='width:238px;'>";
                                echo "<div class='table-kaarten w-100 p-2'>";
                                    echo ucfirst($table);
                                echo "</div>";
                            echo "</div>";
                        }
                        echo "<button type=\"button\" class=\"btn btn-success w-50\" style='min-width:240px;max-height:40px' data-bs-toggle=\"modal\" data-bs-target=\"#add_to_db\">Voeg toe</button>";
                    echo "</div>";
                echo "</div>";
                
                if($_SESSION["table-limit"] <= 24){
                    $_SESSION["table-limit"] = 25;
                }

                $column = adminManager::getColumns($tableContent);
                $columnDesc = adminManager::columnDesc($tableContent);


                // modal toevoegen
                echo "<div class=\"modal fade\" id=\"add_to_db\" tabindex=\"-1\" aria-labelledby=\"add_to_dbLabel\" aria-hidden=\"true\">";
                    echo "<div class=\"modal-dialog\">";
                        echo "<div class=\"modal-content\">";
                            echo "<form method='POST'>";
                                echo "<div class=\"modal-header\">";
                                    echo "<h5 class=\"modal-title\" id=\"add_to_dbLabel\">Voeg toe bij ". ucfirst($tableContent) ."</h5>";
                                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>";
                                echo "</div>";
                                echo "<div class=\"modal-body\">";
                                    $i = 1;
                                    foreach($column as $col){
                                        if($col->COLUMN_NAME != "id"){
                                            switch($columnDesc[$i]->Type){
                                                default:
                                                    $inputType = "text";
                                                    $inputClass = "form-control";
                                                    break;
                                                case "datetime":
                                                    $inputType = "datetime-local";
                                                    $inputClass = "form-control";
                                                    break;
                                                case "date":
                                                    $inputType = "date";
                                                    $inputClass = "form-control";
                                                    break;
                                                case "tinyint(4)":
                                                    $inputType = "checkbox";
                                                    $inputClass = "form-check-input";
                                                    break;
                                                case "int(11)":
                                                    $inputType = "number";
                                                    $inputClass = "form-control";
                                            }
                                            echo "<label for='add{$col->COLUMN_NAME}'>".ucfirst($col->COLUMN_NAME)."&nbsp;</label>";
                                            echo "<input type='$inputType' class='$inputClass' name='{$col->COLUMN_NAME}' placeholder='{$col->COLUMN_NAME}'></input><br>";
                                            if($inputType == "checkbox"){echo "<br>";}
                                            $i ++;
                                        }
                                    }
                                echo "</div>";
                                echo "<div class=\"modal-footer\">";
                                    echo "<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Sluiten</button>";
                                    echo "<button type=\"submit\" name='addRow' class=\"btn btn-primary\">Voeg toe</button>";
                                echo "</div>";
                            echo "</form>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                if(isset(($_POST["addRow"]))){
                    $arrayAddRow = array();
                    foreach($column as $col){
                        if($col->COLUMN_NAME != "id"){
                            $arrayAddRow = $_POST;
                        }
                    }
                    array_pop($arrayAddRow);
                    adminManager::insert($tableContent, $arrayAddRow);
                    header("Location:admin?content=$tableContent");
                }
                if($tableContent == "song"){
                    if(!isset($_GET["filter"])){
                        header("location:admin?content=song&filter=1");
                    }else{
                        $filter = "WHERE inLijst = ";
                        if($_GET["filter"] != 1){
                            $filter .= "0";
                            $filterForLink = "&filter=0";
                        }else{
                            $filter .= "1";
                            $filterForLink = "&filter=1";
                        }
                        $content = adminManager::tableContent($tableContent, $_SESSION["table-limit"], $filter);
                        echo "<div class='container'>";
                            echo "<div class='row justify-content-md-center text-center w-75' style='margin-left:auto;margin-right:auto;'>";
                                echo "<div class='lijst-tables p-2 col-3' style='width:238px;' onclick=\"window.location.href = 'admin?content=song&filter=1'\">";
                                    echo "<div class='table-kaarten w-100 p-2'>";
                                        echo "Lijst van songs";
                                    echo "</div>";
                                echo "</div>";
                                echo "<div class='lijst-tables p-2 col-3' style='width:238px;' onclick=\"window.location.href = 'admin?content=song&filter=0'\">";
                                    echo "<div class='table-kaarten w-100 p-2'>";
                                        echo "Goedkeuring nodig";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    }
                }else{
                    $content = adminManager::tableContent($tableContent, $_SESSION["table-limit"], "");
                    $filterForLink = "";
                }
                echo "<table class='table'>";
                    echo "<thead>";
                        echo "<tr>";
                            foreach($column as $col){
                                    echo "<th>".ucfirst($col->COLUMN_NAME)."</th>";
                            }
                            echo "<th style='width:50px'></th>";
                            echo "<th style='width:50px'></th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                        foreach($content as $row){
                            echo "<tr>";
                                foreach($column as $col){
                                        $colName = $col->COLUMN_NAME;
                                        $rowName = $row->$colName;
                                        echo "<td>$rowName</td>";
                                }
                                echo "<td><button class='btn btn-success' data-bs-toggle=\"modal\" data-bs-target=\"#edit_to_db{$row->id}\">Edit</button></td>";
                                echo "<td><form method='POST'><button type='submit' name='delete{$tableContent}id{$row->id}' class='btn btn-danger'>Delete</button></form></td>";
                            echo "</tr>";
                            // modal bewerken
                            echo "<div class=\"modal fade\" id=\"edit_to_db{$row->id}\" tabindex=\"-1\" aria-labelledby=\"edit_to_db{$row->id}Label\" aria-hidden=\"true\">";
                                echo "<div class=\"modal-dialog\">";
                                    echo "<div class=\"modal-content\">";
                                        echo "<form method='POST'>";
                                            echo "<div class=\"modal-header\">";
                                                echo "<h5 class=\"modal-title\" id=\"edit_to_db{$row->id}Label\">Pas aan bij ". ucfirst($tableContent) ."</h5>";
                                                echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>";
                                            echo "</div>";
                                            echo "<div class=\"modal-body\">";
                                                $i = 1;
                                                foreach($column as $col){
                                                    if($col->COLUMN_NAME != "id"){
                                                        $colName1 = $col->COLUMN_NAME;
                                                        $rowName1 = $row->$colName1;
                                                        switch($columnDesc[$i]->Type){
                                                            default:
                                                                $inputType = "text";
                                                                $inputClass = "form-control";
                                                                break;
                                                            case "datetime":
                                                                $inputType = "datetime-local";
                                                                $inputClass = "form-control";
                                                                break;
                                                            case "date":
                                                                $inputType = "date";
                                                                $inputClass = "form-control";
                                                                break;
                                                            case "tinyint(4)":
                                                                $inputType = "checkbox";
                                                                $inputClass = "form-check-input";
                                                                if($rowName1 == 1){
                                                                    $inputClass = "form-check-input' checked id='";
                                                                }
                                                                break;
                                                            case "int(11)":
                                                                $inputType = "number";
                                                                $inputClass = "form-control";
                                                        }
                                                        echo "<label for='add{$col->COLUMN_NAME}'>".ucfirst($col->COLUMN_NAME)."&nbsp;</label>";
                                                        if($inputType == "checkbox"){
                                                            echo "<input type='hidden' class='$inputClass' name='{$col->COLUMN_NAME}' value='0'></input>";
                                                            echo "<input type='$inputType' class='$inputClass' name='{$col->COLUMN_NAME}_check' placeholder='{$col->COLUMN_NAME}' value='on'></input><br>";
                                                        }else{
                                                            echo "<input type='$inputType' class='$inputClass' name='{$col->COLUMN_NAME}' placeholder='{$col->COLUMN_NAME}' value='{$rowName1}'></input><br>";
                                                        }
                                                        if($inputType == "checkbox"){echo "<br>";}
                                                        $i ++;
                                                    }
                                                }
                                            echo "</div>";
                                            echo "<div class=\"modal-footer\">";
                                                echo "<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Sluiten</button>";
                                                echo "<button type=\"submit\" name='editRow{$tableContent}id{$row->id}' class=\"btn btn-primary\">Stuur veranderingen door</button>";
                                            echo "</div>";
                                        echo "</form>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            if(isset($_POST["editRow{$tableContent}id{$row->id}"])){
                                $arrayEditRow = array();
                                foreach($column as $col){
                                    if($col->COLUMN_NAME != "id"){
                                        $arrayEditRow = $_POST;
                                    }
                                }
                                array_pop($arrayEditRow);
                                adminManager::update($tableContent, $arrayEditRow, $row->id);
                                // die;
                                header("Location:admin?content={$tableContent}");
                            }
                            if(isset($_POST["delete{$tableContent}id{$row->id}"])){
                                adminManager::delete(
                                    $tableContent,
                                    $row->id
                                );
                                header("Location:admin?content={$tableContent}");
                            }
                        }
                    echo "</tbody>";
                echo "</table>";
            echo "</main>";
            echo "<form method='POST'>";
                echo "<div class='container justify-content-center' id='close'>";
                    echo "<div class='row'>";
                        echo "<div class='edit-rows-minus col'>";
                            echo "<button type='submit' onclick=\"window.location = 'admin?content={$tableContent}{$filterForLink}#close'\" name='tableLimitMinus100' class='btn phone_view'>-100 regels</button>";
                            echo "<button type='submit' onclick=\"window.location = 'admin?content={$tableContent}{$filterForLink}#close'\" name='tableLimitMinus50' class='btn'>-50 regels</button>";
                            echo "<button type='submit' onclick=\"window.location = 'admin?content={$tableContent}{$filterForLink}#close'\" name='tableLimitMinus25' class='btn phone_view'>-25 regels</button>";
                        echo "</div>";
                        echo "<div class='edit-rows-total col'>";
                            echo "Aantal zichtbare rijen: {$_SESSION["table-limit"]}";
                        echo "</div>";
                        echo "<div class='edit-rows-plus col'>";
                            echo "<button type='submit' onclick=\"window.location = 'admin?content={$tableContent}{$filterForLink}#close'\" name='tableLimitPlus25' class='btn phone_view'>+25 regels</button>";
                            echo "<button type='submit' onclick=\"window.location = 'admin?content={$tableContent}{$filterForLink}#close'\" name='tableLimitPlus50' class='btn'>+50 regels</button>";
                            echo "<button type='submit' onclick=\"window.location = 'admin?content={$tableContent}{$filterForLink}#close'\" name='tableLimitPlus100' class='btn phone_view'>+100 regels</button>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</form>";
            if(isset($_POST["tableLimitMinus100"])){
                $_SESSION["table-limit"] = $_SESSION["table-limit"] - 100;
                header("Location:admin?content={$tableContent}{$filterForLink}");
            }
            if(isset($_POST["tableLimitMinus50"])){
                $_SESSION["table-limit"] = $_SESSION["table-limit"] - 50;
                header("Location:admin?content={$tableContent}{$filterForLink}");
            }
            if(isset($_POST["tableLimitMinus25"])){
                $_SESSION["table-limit"] = $_SESSION["table-limit"] - 25;
                header("Location:admin?content={$tableContent}{$filterForLink}");
            }
            if(isset($_POST["tableLimitPlus100"])){
                $_SESSION["table-limit"] = $_SESSION["table-limit"] + 100;
                header("Location:admin?content={$tableContent}{$filterForLink}");
            }
            if(isset($_POST["tableLimitPlus50"])){
                $_SESSION["table-limit"] = $_SESSION["table-limit"] + 50;
                header("Location:admin?content={$tableContent}{$filterForLink}");
            }
            if(isset($_POST["tableLimitPlus25"])){
                $_SESSION["table-limit"] = $_SESSION["table-limit"] + 25;
                header("Location:admin?content={$tableContent}{$filterForLink}");
            }
            echo "<br>";
        }
    ?>
    </body>
</html>