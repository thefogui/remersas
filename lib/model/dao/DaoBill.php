<?php

/**
 * Class used to crud the bill class
 * @see Bill.php
 */
class DaoBill {
    private $conn;

    public function setConn($conn) {
        $this->conn = $conn;
    }

    public function getConn() {
        return $this->conn;
    }

    /**
     * Function to get the oldest month that contains a possible bill
     * @param conn
     * @return month
     * @throws exception error connecting to the sql database
     */
    public function getTheOldestMonth($conn) {
        $month = "";
        if ($conn) {
            $query = ""; //TODO: get the oldest month;

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn)) {
                throw new Exception('Error getting users: ' . mysqli_error($conn));
            } else {
                $month = $result["month"]; //TODO: get the month table
            }
        }
        return $month;
    }

    /**
     * Function to get the bills order by the month inserted
     * @param $conn
     * @param $month
     * @return 
     * @throws 
     */
    public function getBillsByMonth($conn, $month) {
        $bills = array();
        if ($conn) {
            $query = ""; //TODO: get the oldest month;

            $result = mysqli_query($conn, $query);

            if (mysqli_errno($conn)) {
                throw new Exception('Error getting users: ' . mysqli_error($conn));
            } else {
                while ($bill = mysqli_fetch_object($result, 'Bill')) {
                    $bills[] = $bill;
                }
            }
        }
        return $bills;
    }
}