<?php
require_once 'mandrill-api-php/src/Mandrill.php';

function getMandrillApiInfo($emailsInfoArray)
{
  $templateVars = []; $mergeVars = []; $toEmail = [];

  foreach ($emailsInfoArray as $emailInfoArray) 
  {
    $templateVarsObject = []; $varsArray = []; $toEmailObject = []; $toEmailArray = [];

    foreach ($emailInfoArray as $elem => $value) 
    {
      if($elem == "email")
      {
        $templateVarsObject["rcpt"] = $value;
        $toEmailObject["email"    ] = $value;
        $toEmailObject["type"     ] = 'to';
      } 
      else if ($elem == "name")
      {
        $toEmailObject["name"] = $value;
      } 
      else if ($elem == "attachment_content")
      {
        $templateVars["attachment_content"] = $value;
      } 
      else if ($elem == "attachment_name")
      {
        $templateVars["attachment_name"] = $value;
      } 
      else 
      {
        $varsArray[] = array("name" => $elem, "content" => $value);
      }
    }

    $templateVarsObject["vars"] = $varsArray;
    $toEmail[] = $toEmailObject;
  } 

  $templateVars["merge_vars"] = array($templateVarsObject);
  $templateVars["to"        ] = $toEmail;

  return $templateVars;
}

function addEmailtoDB($ref,$email,$templateName,$tipo,$mandrillId,$status,$logsID)
{  
  $halbrandConn = connect( "localhost" );
  $urlToFile    = $GLOBALS['urlToFile'];
  $templateName = utf8_decode($templateName);

  $sqlMail = "INSERT INTO 
                emails 
                (`Ref`,`Logs_Id`,`Send_date`,`Email`,`Template`,`Subject`,`Body`,`Attachments`,`Tipo`,`Status`,`Opens`,`Clicks`,`API_Id`) 
              VALUES 
                ('$ref','$logsID',CURRENT_TIMESTAMP,'$email','$templateName','','','','$tipo','$status',0,0,'$mandrillId')
              ";    
  $qryMail = mysqli_query($halbrandConn, $sqlMail);
  if( $qryMail )
    $mail_id = mysqli_insert_id($halbrandConn); 

  $halbrandConn->close();
}

function checkIfSendEmail($email, $template)
{
  $halbrandConn = connect( "localhost", "replica" );
  $urlToFile    = $GLOBALS['urlToFile'];

  $sql    = "SELECT ID FROM emails WHERE Email='$email' and Template='$template'";
  $result = $halbrandConn->query($sql)->num_rows;
  $halbrandConn->close();

  if ($result > 0) 
      return "false";

  return "true";
}

function getLangFromTemplateName($templateName){
  $rest = substr($templateName, 0, -2);
  return str_replace($rest,"",$templateName);
}

function sendMandrillBatchMail($mandrill, $ref, $email, $templateName, $subject, $emailsInfoArray, $logsID) 
{
  try
  {
    $mandrillApiInfo = getMandrillApiInfo($emailsInfoArray);
    
    $attachments = [];

    if(array_key_exists('attachment_content', $mandrillApiInfo))
      $attachments[] = ["type"=>"application/pdf","name"=>$mandrillApiInfo['attachment_name'],"content"=>$mandrillApiInfo['attachment_content']];

    $emailLang = getLangFromTemplateName($templateName);
    $emailLang = (!empty($emailLang)) ? (".".$emailLang) : "";
    $message = array(
        'subject'                     => $subject,
        'from_email'                  => 'info'.$emailLang.'@populetic.com',
        'from_name'                   => 'Populetic',
        'to'                          => $mandrillApiInfo["to"],
        'headers'                     => array('Reply-To' => 'info'.$emailLang.'@populetic.com'),
        'track_opens'                 => true,
        'track_clicks'                => true,
        'merge'                       => true,
        'merge_language'              => 'mailchimp',
        'merge_vars'                  => $mandrillApiInfo["merge_vars"],
        'attachments'                 => $attachments,
        'google_analytics_domains'    => array('populetic.com'),
        'google_analytics_campaign'   => 'info@populetic.com',
        'metadata' => array('website' => 'www.populetic.com')
    );

    $template_content = array();
    $async            = false;
    $ip_pool          = 'Main Pool';
    $send_at          = date("Y-m-d H:i:s");
    $result           = $mandrill->messages->sendTemplate($templateName, $template_content, $message, $async, $ip_pool, $send_at);
    
    //TODO: talk to Miriam about it
    //addEmailtoDB($ref,$email,$templateName,'2',$result[0]['_id'],$result[0]['status'], $logsID);
  }
  catch (Exception $e)
  {
    //addEmailtoDB($ref,$email,$templateName,'2',"0","api-error", $logsID);
  }
}
?>
