<?php

/**
 * Class used to crud the invoice class
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

    public function getInvokeData($claimId) {
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

    public function getClaim ($claimId) {
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
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $row;
        }
    }
}