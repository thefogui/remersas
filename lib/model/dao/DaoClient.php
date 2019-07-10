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
     * This function returns all the clients that has the state : 
     * 'solicitar datos pago'
     * 
     * @param amount the amount of money
     * @param conn the connection with the sql
     * @return array that contains the clients array the amount to pay to the vips clients and the amount left after pay clients.
     */
    public function getClientVip($conn, $ammount) {
        $state = 'solicitar datos pago';
        $clients = array();
        $amountToPay = 0;
    
        if($conn) {
            //TODO: orderby the amount of money the client gonna receive
            $query = "SELECT c.DocIdentidad AS nif, c.Nombre AS name, pfv.Id_Cliente AS id, c.Email AS email
                            FROM populetic_form_vuelos pfv
                            INNER JOIN clientes c 
                            ON c.ID = pfv.Id_Cliente
                            WHERE pfv.Id_Estado = 36";

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn)) {
                throw new Exception('Error getting users: ' . mysqli_error($conn));
            } else {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo $row;
                    $clients[] = new Client($row['nif'], $row['name'], $row['id'], $row['email']);

                    //logical behind the amount

                    //TODO: get the amount of money the client got
                   /*$clientAmount = $client->amountToPay();
                    $amount = $amount - $clientAmount;
                    $amountToPay =  $amountToPay + $clientAmount;*/
                }
            }
        }
        return  array($clients, $amount, $amountToPay);
    }
}