<?php
function get_Text( $tag, $langCode){
  
if(isset($_SERVER['SERVER_NAME'])){
  if($_SERVER['SERVER_NAME'] != 'localhost'){
    /* PRODUCTION SERVER */
  $servername = "populetic-datawarehouse.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";
  $username = "populetic";
  $password = "p0pprdfr0nt";
  $dbnameTS = "translation_system";
  } else {
    /* LOCALHOST*/
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbnameTS = "translation_system";
  }
} else {

  if (substr(php_uname(), 0, 7) == "Windows"){
    /* LOCALHOST*/
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbnameTS = "translation_system";
  }else{
    /* SERVER */
  $servername = "populetic-datawarehouse.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";
  $username = "populetic";
  $password = "p0pprdfr0nt";
  $dbnameTS = "translation_system";
  }

}

// Create connection
$langConn = new mysqli($servername, $username, $password, $dbnameTS);


// Check connection
if ($langConn->connect_error) {
    die("Connection failed: " . $langConn->connect_error);
}



  $text = "";
  $tag  = str_replace(")", "", str_replace("_(", "", $tag));
  $aTag = explode(".", $tag);

  $sqlTag = "SELECT * 
            FROM 
              halbrand_translations 
            WHERE 
              lang_code = '".$langCode."' AND
              tag_id    = '".$aTag[0]."'
              ".(isset($aTag[1]) && !empty($aTag[1]) && $aTag[1] != "" ? "AND subtag = '".$aTag[1]."'" : "")." 
            ";
  $qryTag = mysqli_query($langConn, $sqlTag);
  if( $qryTag )
  {
    if( mysqli_num_rows($qryTag) > 0 )
    {
      if( $resTag = mysqli_fetch_assoc($qryTag) )
      {
        if( isset($resTag['translation']) && !empty($resTag['translation']) )
        {
          $text = utf8_decode($resTag['translation']);
        }
        else
        {
          //Searching translation of default language
          $sqlTag = "SELECT * 
                    FROM 
                      halbrand_translations 
                    WHERE 
                      lang_code = (SELECT code FROM populetic_languages WHERE is_default = 1 ) AND 
                      tag_id    = '".$aTag[0]."'
                      ".(isset($aTag[1]) && !empty($aTag[1]) && $aTag[1] != "" ? "AND subtag = '".$aTag[1]."'" : "")." 
                    ";
          $qryTag = mysqli_query($langConn, $sqlTag);
          if( $qryTag )
          {
            if( mysqli_num_rows($qryTag) > 0 )
            {
              while( $resTag = mysqli_fetch_assoc($qryTag) )
              {
                if( isset($resTag['translation']) && !empty($resTag['translation']) )
                  $text = utf8_decode($resTag['translation']);
              }
            }
          }
        }
      }
    }
  }

 $langConn->close();

  return $text;
}
?>