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
     * This function returns all the clients that has the state : 
     * 'solicitar datos pago'
     */
    public function getClientVip($conn) {
        $state = 'solicitar datos pago';
        $clients = array();

        if($conn) {
            $query =   "SELECT c.DocIdentidad AS nif, c.Nombre AS name, pfv.Id_Cliente AS id, c.Email AS email
                        FROM populetic_form_vuelos pfv
                        LEFT JOIN clientes c 
                        ON c.ID = pfv.Id_Cliente
                        WHERE pfv.Id_Estado = 36";

            $result = mysqli_query($conn, $query) or die('Invalid query: ' . mysqli_error());

            if (mysqli_errno($conn)) {
                throw new Exception('Error getting users: ' . mysqli_error($conn));
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $client = new Client($row["nif"], $row["name"], $row["id"], $row["email"]);
                    $dateClient = array('id' => client->getId(), 'nif' => client->getNif(), 'name' => client->getName(), 'email' => client->getEmail());
                    $clients[] = $dateClient;
                }
            }
        }
        return $clients;
    }
}