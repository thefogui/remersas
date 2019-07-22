<?php 

class DaoClientBankAcccount {
    private $conn;

    public function setConn($conn) {
        $this->conn = $conn;
    }

    public function getConn() {
        return $this->conn;
    }

    /**
     * Function to insert the client bank account into the database
     * @param $clientId foreign key of the client
     * @param $bankAccount the client bank account
     * @throws error connecting with the database
     * 
     */
    public function insert($conn, $clientId, $bankAccount) {
        if($conn) {
            $query = "INSERT INTO ..."; //TODO: finish this query

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn)) {
                throw new Exception('Error inserting bank account into mysql: ' . mysqli_error($conn));
            }
        }
    }

    /**
     * Function to update an existent bank account
     * 
     */
    public function update($conn, $bankAccount) {
        if($conn) {
            $query = "UPDATE ..."; //TODO: finish this query

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn)) {
                throw new Exception('Error updating user bank account: ' . mysqli_error($conn));
            }
        }
    }

    /**
     * Function to update an existent bank account
     * 
     */
    public function updateUsingClientId($conn, $clientId, $bankAccount) {
        if($conn) {
            $query = "UPDATE ..."; //TODO: finish this query

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn)) {
                throw new Exception('Error updating user bank account: ' . mysqli_error($conn));
            }
        }
    }
}