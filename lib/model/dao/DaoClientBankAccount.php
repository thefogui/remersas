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
     * @param $conn
     * @param $account_number
     * @param $account_holder
     * @param $billing_address
     * @param $emailClaim
     * @param $phone_client
     * @param $id_claim
     * @param string $swift
     * @throws Exception
     */
    public function insert($conn, $account_number, $account_holder, $billing_address, 
                        $emailClaim, $phone_client ,$id_claim, $swift = "") {
        if($conn) {
            $query = sprintf("INSERT IGNORE INTO populetic_form.bank_account_info (account_number, swift, account_holder, billing_address, email_client, phone_client, id_claim)
            VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s');", $account_number, $swift, $account_holder, $billing_address, $emailClaim, $phone_client, $id_claim);

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn))
                throw new Exception('Error inserting bank account into mysql: ' . mysqli_error($conn));
        
            $this->updateToReadyToPayment($conn, $id_claim);
            $this->deletePendingBankAccount($conn, $emailClaim);
        }
    }

    //TODO: after test this change to private
    public function updateToReadyToPayment($conn, $id) {
        //-- cambiar de estado a 'LISTO PARA PAGO' si ya insertado los datos de pago y exit
        $query = "UPDATE populetic_form.populetic_form_vuelos pfv
                SET pfv.Id_Estado = 37
                WHERE pfv.ID = ". $id .";";

        $result = mysqli_query($conn, $query);
    }

    /**
     * Function to update an existent bank account
     * @param $conn
     * @param $id
     * @param $account_number
     * @param $swift
     * @param $account_holder
     * @param $billing_address
     * @param $email_client
     * @param $id_claim
     * @throws Exception
     */
    public function update($conn, $id, $account_number, $swift, $account_holder, $billing_address, $email_client, $id_claim) {
        if($conn) {
            $query = "UPDATE populetic_form.bank_account_info 
                    SET ";
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

    //TODO: after test this change to private
    public function insertIntoPendingBankAccount($conn, $emailClaim, $idClaim) {
        if($conn) {
            $query = "INSERT INTO 
                        populetic_form.pending_bank_account (id_claim, email_claim)
                    VALUES ("
                        . "'" . $idClaim . "'" . ", "
                        . "'" . $emailClaim . "'" ."
                    );";

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn))
                throw new Exception('Error inserting bank account into mysql: ' . mysqli_error($conn));
        }
    }

    //TODO: after test this change to private
    public function changeStateToWithoutBankAccount($conn, $id) {
        //-- si ya existe y es igual a 3 cambiar de estado 'SIN DATOS DE PAGO' y exit
        $query = "UPDATE populetic_form.populetic_form_vuelos pfv
                SET pfv.Id_Estado = 31
                WHERE pfv.ID = " . $id .";";

        $result = mysqli_query($conn, $query);

        if (mysqli_errno($conn))
            throw new Exception('Error changing the state of claim with id '. $id . ' ' . mysqli_error($conn));
    }

    //TODO: after test this change to private
    public function updateTimesSentTheEmail($conn, $email) {
        //-- si ya exist y es distinto a 3
        $query = "UPDATE populetic_form.pending_bank_account pba
                    SET pba.number_of_times_sent = pba.number_of_times_sent + 1
                    WHERE pba.email_claim = " . "'" . $email . "';";

        $result = mysqli_query($conn, $query);

        if (mysqli_errno($conn))
            throw new Exception('Error  ' . mysqli_error($conn));
    }

    public function updatePendingBankAccount($conn, $emailClaim, $idClaim) {
        if ($conn) {

            $timeLimit = strtotime("-1 year");

            $query = "SELECT 
                number_of_times_sent AS numberOfTimesSent
            FROM
                populetic_form.pending_bank_account pba
            WHERE
                pba.email_claim = " . "'" . $emailClaim . "';"; 

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn))
                throw new Exception('Error getting users: ' . mysqli_error($conn));
            else {
                $numberOfTimesSent = mysqli_fetch_assoc($result)["numberOfTimesSent"];
                
                if (!isset($numberOfTimesSent)){
                    //insert the information
                    try {
                        $this->insertIntoPendingBankAccount($conn, $emailClaim, $idClaim);
                    } catch (Exception $e) {
                    }
                }else if ($numberOfTimesSent == 3){
                    //update to 'SIN DATOS PAGO'
                    try {
                        $this->changeStateToWithoutBankAccount($conn, $idClaim);
                        $this->insertLogChange($conn, $idClaim, '31');
                    } catch (Exception $e) {
                    }
                } else {
                    //increment the time the email was sent
                    try {
                        $this->updateTimesSentTheEmail($conn, $emailClaim);
                    } catch (Exception $e) {
                    }
                }
            }
        }
    }

    //TODO: after test this change to private
    public function deletePendingBankAccount($conn, $emailClaim) {
        //delete this if we have the client
        $query = "DELETE FROM populetic_form.pending_bank_account 
                    WHERE populetic_form.pending_bank_account.email_claim = ". "'" . $emailClaim . "';";

        $result = mysqli_query($conn, $query);

        if (mysqli_errno($conn))
            throw new Exception('Error deleting the sql entry ' . mysqli_error($conn));
    }

    private function insertLogChange($conn, $reclamacionId, $estado) {
        if ($conn) {
            $query = sprintf("INSERT INTO 
                        halbrand.logs_estados (`Id_reclamacion`, `Data`, `Estado`, `Tipo`, `Id_Agente`, `Checked`) 
                        VALUES (%s, CURRENT_TIMESTAMP, '%s' , '1', '19', '0');", $reclamacionId, $estado);
            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn)) throw new Exception('Error getting users: ' . mysqli_error($conn));
        } else
            throw new Exception('Error connecting to the sql database!');
    }

    public function getAllAccounts($conn) {
        if($conn) {
            $query = "SELECT
                         pfv.ID AS id_reclamacion
                        , IFNULL(pfv.Ref, '') AS referencia 
                        , IFNULL(pfv.Codigo, '') AS codigo
                        ,c.DocIdentidad AS nif
                        , CONCAT(c.Nombre, ' ',c.Apellidos) AS name
                        ,pfv.Id_Cliente AS id
                        ,c.Email AS email 
                        ,pfv.langId AS lang
                        ,pfv.Cuantia_pasajero AS amountReviewed
                    FROM    
                        populetic_form_vuelos pfv
                    INNER JOIN 
                        clientes c ON c.ID = pfv.Id_Cliente
                    WHERE 
                        pfv.Id_Estado = 37";

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn))
                throw new Exception('Error getting users: ' . mysqli_error($conn));
            else {
                $bankAccountArray = array();

                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $bankAccount = array("idReclamacion" => $row['id_reclamacion'],
                                        "ref" => $row['referencia'],
                                        "nif" => $row['nif'],
                                        "id" => $row['id'],
                                        "email" => $row['email'],
                                        "lang" => $row['lang'],
                                        "amountReviewed" => $row['amountReviewed'],
                                        "name" => $row['name']
                                    );

                    array_push($bankAccountArray, $bankAccount);

                }
                return $bankAccountArray;
            }
        }
        return null;
    }
}