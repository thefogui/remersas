<?php

class Translations
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return mixed
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @param mixed $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Función que busca en la base de datos el texto correspondiente a una tag con los parametros
     * insertados
     *
     * @param $languageCode String
     * @param $tagId String
     * @return string el texto
     * @throws Exception SQL query exceptions
     */
    public function getTranslationsFromDB($languageCode, $tagId)
    {
        $query = sprintf("SELECT 
                    * 
                FROM 
                    populetic_translations
                WHERE 
                    lang_code = '%s'
                    tag_id = '%s'", $languageCode, $tagId);

        $result = mysqli_query($this->conn, $query);

        if (mysqli_errno($this->conn))
            throw new Exception('Error getting translations: ' . mysqli_error($this->conn));
        else {
            $row = mysqli_fetch_assoc($result['translation']);
            return utf8_decode($row);
        }
    }

    /**
     * Función que se usa para buscar en la base de datos la traducción por defecto de un tag
     *
     * @param $tagId
     * @return string
     * @throws Exception
     */
    public function getDefaultTranslations($tagId)
    {
        $query = sprintf("SELECT 
            *
        FROM
            populetic_translations
        WHERE
            lang_code = (SELECT code FROM populetic_languages WHERE is_default = 1 )
            AND 
                tag_id = '%s'", $tagId);

        $result = mysqli_query($this->conn, $query);

        if (mysqli_errno($this->conn)) {
            throw new Exception('Error getting default translations: ' . mysqli_error($this->conn));
        } else {
            $row = mysqli_fetch_assoc($result['translation']);
            return utf8_decode($row);
        }
    }
}