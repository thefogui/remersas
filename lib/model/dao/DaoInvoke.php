<?php

/**
 * Class used to crud the bill class
 * @see Invoice.php
 */
class DaoInvoke {
    private $conn;

    /**
     * DaoInvoke constructor.
     * @param $conn
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setConn($conn) {
        $this->conn = $conn;
    }

    public function getConn() {
        return $this->conn;
    }

    public function getInvokeData($claimid) {
        $query = sprintf("SELECT ID AS id,
                    num_serial AS serialNumber,
                    id_Reclamacion AS claimId,
                    Cuantia_Factura AS invokeValue,
                    Comentarios AS comments,
                    Descripcion AS description,
                    Cobro_date AS receivedDay,
                    Pago_date AS sentDay,
                    Generacion_factura AS generatedDay,
                    Fecha_ingreso AS dateAdmission,
                    Via_factura AS viaInvoice
                FROM 
                    facturacion 
                WHERE 
                    Id_Reclamacion = %s;", $claimid);

        $result = mysqli_query($this->conn, $query);

        if (mysqli_errno($this->conn))
            throw new Exception('Error getting invokes: ' . mysqli_error($this->conn));
        else {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $row;
        }
        return null;
    }
}