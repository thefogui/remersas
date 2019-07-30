<?php 

class DaoClientBankAccount {
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
    public function insert($conn, $account_number, $account_holder, $billing_address, 
                        $email_client, $phone_client ,$id_claim, $swift = "") {
        if($conn) {
            $query = "INSERT IGNORE INTO populetic_form.bank_account_info (account_number, swift, account_holder, billing_address, email_client, phone_client, id_claim)
            VALUES ("
            ."'". $account_number ."'" . ", " 
            ."'". $swift ."'" . ", " 
            ."'". $account_holder ."'".  ", " 
            ."'". $billing_address ."'". ", " 
            ."'". $email_client ."'".  ", " 
            ."'". $phone_client ."'".  ", " 
            ."'". $id_claim ."'" . ");"; 
            
            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn))
                throw new Exception('Error inserting bank account into mysql: ' . mysqli_error($conn));
        }
    }

    /**
     * Function to update an existent bank account
     * 
     */
    public function update($conn, $id, $account_number, $swift, $account_holder, $billing_address, $email_client, $id_claim) {
        if($conn) {
            $query = "UPDATE populetic_form.bank_account_info 
                    SET "; //TODO: finish this query
            if (isset($account_number))
                $query .= "account_number = " . $account_number;
            if (isset($swift))
                $query .= "swift = " . $swift;
            if (isset($account_holder))
                $query .= "account_holder = " . $account_holder;
            if (isset($billing_address))
                $query .= "billing_address = " . $billing_address;
            if (isset($email_client))
                $query .= "email_client = " . $email_client;

            if (isset($id_claim))
                $query .= "WHERE id_claim = " . $id_claim;
            else
                $query .= "WHERE id= " . $id;

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn))
                throw new Exception('Error updating user bank account: ' . mysqli_error($conn));
        }
    }
}