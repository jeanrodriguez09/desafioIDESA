<?php 

header('Content-Type: application/json'); //Ayuda para darle mejor visibilidad al formato json.


require_once 'Database.php';

class DesafioUno {


    public static function getClientDebt (int $clientID)
    {
        Database::setDB();

        $lotes = self::getLotes();      
            
        $cobrar['status']            = true;
        $cobrar['message']           = 'No hay Lotes para cobrar';
        $cobrar['data']['total']     = 0;
        $cobrar['data']['detail']    = [];



        foreach($lotes as $lote){

        
            if($lote->vencimiento < date('Y-m-d')) continue; //Modificación de esta línea para realizar la lógica correcta. Esto servirá para traer los lotes a cobrar, debido a que traemos la fecha actual mayor a la fecha vencimiento de la base de datos.


            if($lote->client_ID == $clientID) continue; //Modificamos para que el ID del cliente se pueda relacionar.
                

            
            $cobrar['status']             = false;
            $cobrar['message']            = 'Tienes Lotes para cobrar';
            $cobrar['data']['total']     += $lote->precio; // Línea modificada para porque "monto" no era el nombre de la columna sino "precio".
            $cobrar['data']['detail'][]   = (array) $lote;
 
        }
        //echo json_encode($cobrar);
        echo json_encode($cobrar, JSON_PRETTY_PRINT); // Ajustamos esta línea para el formato .json.
    }

    

    private static function getLotes() : array 
    {
        $lotes = [];
        $cnx = Database::getConnection();
        $stmt = $cnx->query("SELECT * FROM debts");
        while($rows = $stmt->fetchArray(SQLITE3_ASSOC)){
            $rows['clientID'] = (string) $rows['clientID'];
            $lotes[] = (object) $rows;
        }
        return $lotes;
    }



}

DesafioUno::getClientDebt(123456);