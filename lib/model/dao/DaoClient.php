<?php

/**
 * Class to connect to the client table in the database
 * @package 
 * @see     
 */
class DaoClient {

    private $conn;

    public function setConn($conn) {
        $this->conn = $conn;
    }

    public function getConn() {
        return $this->conn;
    }

    /**
     * Function to get the client Amount Reviewed
     * @param $clientId the id used to identify the client
     */
    private function getClientAmountReviewed($clienld) {
        $amountReviewed = 400;
        //TODO: query to get the amount reviewed
        return $amountReviewed;
    }

    /**
     * Function to get the clients with the status 
     * 
     */
    public function getClients($conn, $ammount) {

    }
    
    /**
     * This function returns all the clients that has the state : 
     * 'solicitar datos pago'
     * 
     * @param amount the amount of money
     * @param conn the connection with the sql
     * @return array that contains the clients array the amount to pay to the vips clients and the amount left after pay clients.
     */
    public function getClientVip($conn, $amount) {
        $state = 'solicitar datos pago';
        $clients = array();
        $amountToPay = 0;
        $clientsVip = 0;
        $amountLeft = $amount;
    
        if($conn) {
            //TODO: orderby the amount of money the client gonna receive
            $query = "SELECT 
                         c.DocIdentidad AS nif
                        ,c.Nombre AS name
                        ,pfv.Id_Cliente AS id
                        ,c.Email AS email 
                        ,pfv.Cuantia_pasajero AS amountReviewed
                    FROM 
                        populetic_form_vuelos pfv
                    INNER JOIN 
                        clientes c ON c.ID = pfv.Id_Cliente
                    WHERE 
                        pfv.Id_Estado = 36 
                    ORDER BY 
                        amountReviewed";

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn)) {
                throw new Exception('Error getting users: ' . mysqli_error($conn));
            } else {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    
                    $client = new Client($row['nif'], $row['name'], $row['id'], $row['email']);
                    
                    //logical behind the amount
                    $clientAmount = $client->amountToPay($row['amountReviewed']);
                    
                    $amountToPay = $amountToPay + $clientAmount;

                    if ($amountToPay <= $amount) {
                        $amountLeft = $amountLeft - $clientAmount;
                        $clientValue = array($row['nif'], $row['name'], $row['id'], $row['email'], $clientAmount);
                        $clients[] = $clientValue;
                    }
                }
            }
            $clientsVip = count($clients);
        }
        return  array($clients, $amountLeft, $amountToPay, $clientsVip);
    }
}