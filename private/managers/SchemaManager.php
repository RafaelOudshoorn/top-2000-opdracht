<?php

    class SchemaManager {
        public static function getRadioSchema(): array {
            global $con;

            $stmt = $con->prepare("SELECT `radiodj`.`firstname`, `radiodj`.`lastname`, `radioschema`.`beginTime`, `radioschema`.`endTime` FROM `radioschema`JOIN `radiodj` ON `radioschema`.`radioDj_id` = `radiodj`.`id` ORDER BY `beginTime`;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }