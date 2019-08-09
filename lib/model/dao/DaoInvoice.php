<?php

/**
 * Class used to crud the invoice class
 * @see Invoice.php
 */
class DaoInvoice {
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

    public function getInvoiceData($claimId) {
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
                    Id_Reclamacion = %s;", $claimId);

        $result = mysqli_query($this->conn, $query);

        if (mysqli_errno($this->conn))
            throw new Exception('Error getting invokes: ' . mysqli_error($this->conn));
        else {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $row;
        }
    }

    //TODO: check this query wehn Xavi comeback
    public function getClaim($claimId) {
        $query = sprintf("SELECT populetic_form_vuelos.*
                                ,disrupted_flights.flight_number as fnumber
                                ,disrupted_flights.flight_date   as fdate
                                ,disrupted_flights.departure_iata as depiata
                                ,disrupted_flights.arrival_iata   as arriata
                                ,disrupted_flights.arrival_scheduled_time as estimatedtime
                                ,disrupted_flights.arrival_actual_time   as actualtime
                                ,disrupted_flights.airline_iata  as airiata
                                ,disrupted_flights.distance  as distance
                                ,airlineForm.Name       as NameForm
                                ,airlineForm.IATA       as IATAForm
                                ,airlineFormZero.Name       as NameFormZero
                                ,airlineFormZero.IATA       as IATAFormZero          
                                ,airlines_flightstats.ID       as air_id
                                ,airlines_flightstats.Name       as air_name
                                ,airlines_flightstats.IATA       as air_iata
                                ,airportDep.name      as nameairportDep
                                ,airportDep.country_id      as countryDep
                                ,airportArriv.name      as nameairportArr
                                ,airportArriv.country_id      as countryArr
                                ,countriesDepLang.name      as namecountriesDep
                                ,countriesArrivLang.name      as namecountriesArriv
                                from populetic_form_vuelos
                                LEFT JOIN
                                 disrupted_flights    ON disrupted_flights.id = populetic_form_vuelos.id_disrupted_flights 
                                LEFT JOIN
                                 airlines_flightstats ON disrupted_flights.airline_id = airlines_flightstats.ID
                                LEFT JOIN
                                 airlines_flightstats as airlineForm ON populetic_form_vuelos.Id_Aerolinea = airlineForm.ID
                                LEFT JOIN
                                  airlines_flightstats as airlineFormZero ON populetic_form_vuelos.Companyia = airlineFormZero.Name 
                                LEFT JOIN
                                 airports as airportDep ON disrupted_flights.departure_iata = airportDep.iata
                                LEFT JOIN
                                 airports as airportArriv ON disrupted_flights.arrival_iata = airportArriv.iata
                                LEFT JOIN
                                 countries as countriesDep ON airportDep.country_id = countriesDep.ID
                                LEFT JOIN
                                 countries as countriesArriv ON airportArriv.country_id = countriesArriv.ID
                                LEFT JOIN
                                 countries as countriesDepLang ON  countriesDepLang.lang = 'es' AND countriesDep.iso = countriesDepLang.iso
                                LEFT JOIN
                                 countries as countriesArrivLang ON  countriesArrivLang.lang = 'es' AND countriesArriv.iso = countriesArrivLang.iso
                                WHERE  populetic_form_vuelos.ID = %s;", $claimId);

        $result = mysqli_query($this->conn, $query);

        if (mysqli_errno($this->conn))
            throw new Exception('Error getting invokes: ' . mysqli_error($this->conn));
        else {
            $claimData = array();

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $claimData["ref"] = (isset($row['Ref']) && !empty($row['Ref']) ? $row['Ref'] : "");
            $claimData["stateId"] = (isset($row['Id_Estado']) && !empty($row['Id_Estado']) ? $row['Id_Estado'] : "");
            $claimData["langId"] = (isset($row['langId']) && !empty($row['langId']) ? $row['langId'] : "");
            $claimData["amountClient"] = (isset($row['Cuantia_pasajero']) && !empty($row['Cuantia_pasajero']) ? $row['Cuantia_pasajero'] : "");
            $claimData["clientId"] = (isset($row['Id_Cliente']) && !empty($row['Id_Cliente']) ? $row['Id_Cliente'] : "");

            return $claimData;
        }
    }

    public function getClient($clientId) {
        $query = sprintf("SELECT 
                        c.Nombre, 
                        c.Apellidos, 
                        c.Email, 
                        c.Localidad, 
                        c.Domicilio, 
                        c.DocIdentidad 
                    FROM 
                        clientes c 
                    WHERE
                        ID = %s", $clientId);

        $result = mysqli_query($this->conn, $query);

        if (mysqli_errno($this->conn))
            throw new Exception('Error getting client: ' . mysqli_error($this->conn));
        else {
            $clientData = array();
            
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $clientData["name"] = (isset($row['Nombre']) && !empty($row['Nombre']) ? utf8_encode($row['Nombre']) : "");
            $clientData["surname"] = (isset($row['Apellidos']) && !empty($row['Apellidos']) ? utf8_encode($row['Apellidos']) : "");
            $clientData["email"] = (isset($row['Email']) && !empty($row['Email']) ? utf8_encode($row['Email']) : "");
            $clientData["city"] = (isset($row['Localidad']) && !empty($row['Localidad']) ? $row['Localidad'] : "");
            $clientData["address"] = (isset($row['Domicilio']) && !empty($row['Domicilio']) ? $row['Domicilio'] : "");
            $clientData["dni"] = (isset($row['DocIdentidad']) && !empty($row['DocIdentidad']) ? $row['DocIdentidad'] : "");

            return $clientData;
        }
    }

    public function getBillingPreferences() {
        $query = "SELECT * FROM billing_preferences WHERE ID = 1";

        $result = mysqli_query($this->conn, $query);

        if (mysqli_errno($this->conn))
            throw new Exception('Error getting client: ' . mysqli_error($this->conn));
        else {
            $billingPreference = array();

            $billingPreference["fee"] = (isset($row['Fee']) && !empty($row['Fee']) ? ($row['Fee']) : "");
            $billingPreference["iva"] = (isset($row['IVA']) && !empty($row['IVA']) ? ($row['IVA']) : "");
            $billingPreference["ivaType"] = (isset($row['Type_IVA']) && !empty($row['Type_IVA']) ? ($row['Type_IVA']) : "");
            $billingPreference["cobradoCliente"] = (isset($row['Cobrado_cliente']) && !empty($row['Cobrado_cliente']) ? ($row['Cobrado_cliente']) : "");
            $billingPreference["cobradoPopuletic"] = (isset($row['Cobrado_populetic']) && !empty($row['Cobrado_populetic']) ? ($row['Cobrado_populetic']) : "");
            $billingPreference["cancelado_con_cargo"] = (isset($row['Cancelada_con_cargo']) && !empty($row['Cancelada_con_cargo']) ? ($row['Cancelada_con_cargo']) : "");
            $billingPreference["cuantidadFactura"] = (isset($row['Cant_factura']) && !empty($row['Cant_factura']) ? ($row['Cant_factura']) : "");

            return $billingPreference;
        }
    }

    public function getBankAccountInfo($claimId) {
        $query = "SELECT * FROM ";
        //TODO: finish this query
        $result = mysqli_query($this->conn, $query);

        if (mysqli_errno($this->conn))
            throw new Exception('Error getting client: ' . mysqli_error($this->conn));
        else {
            $billingPreference = array();

        }
    }
}
