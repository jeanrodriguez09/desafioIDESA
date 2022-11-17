<?php 
header('Content-Type: application/json'); //Ayuda para darle mejor visibilidad al formato json.
require_once 'Database.php';

class DesafioDos {

    public static function retriveLotes(string $loteID):void { //Modificación del tipo de dato a string que sería el tipo correcto con relación a la base de datos.

        Database::setDB(); 

        echo json_encode(self::getLotes($loteID), JSON_PRETTY_PRINT);
    }

    private static function getLotes (string $loteID){ //Modificación del tipo de dato a string que sería el tipo correcto con relación a la base de datos.
        $lotes = [];
        $cnx = Database::getConnection();
        $stmt = $cnx->query("SELECT * FROM debts WHERE lote = '$loteID'"); //Se removió el LIMIT de la consulta a la base, debido a que deseamos que nos traiga todos los registros relacionado a ese Id de Lote.
        
        while($rows = $stmt->fetchArray(SQLITE3_ASSOC)){
            $lotes[] = (object) $rows;
        }
        return $lotes;
    }
}

DesafioDos::retriveLotes('00148');