<?php




$app->post('/mathima', function($request, $response) use ($diy_storage, $diy_restapi){


        function smtpmailer($to, $from, $from_name, $subject, $body, $M_HOST, $M_PORT, $M_STARTTLS, $M_BCC) {
                global $error;
                $mail = new PHPMailer(); // create a new object
                $mail->IsSMTP(); // enable SMTP
                $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
                $mail->Host = $M_HOST;
                $mail->Port = $M_PORT;
                $mail->SMTPAutoTLS = $M_STARTTLS; // if true phpmailer will try connect via STARTTLS
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom($from, $from_name);
                $mail->AddBCC($M_BCC);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to);
                if(!$mail->Send()) {
                        $error = 'Mail error: '.$mail->ErrorInfo;
                        return false;
                } else {
                        $error = 'Message sent!';
                        return true;
                }
        }


    global $app;
    $result["controller"] = __FUNCTION__;

	$headers = $request->getHeaders();
	foreach ($headers as $name => $values) {
	    //echo $name . ": " . implode(", ", $values);
	    //$dget[".$name."]=$values;
	}
	//GET
	$allGetVars = $request->getQueryParams();
	foreach($data as $key => $param){
	   //GET parameters list
	}

	//POST or PUT
	$allPostPutVars = $request->getParsedBody();
	foreach($allPostPutVars as $key => $param){
	   //POST or PUT parameters list
	    $dgettmp["$key"]=$param;
	}
   	$datatmp = $allPostPutVars['data'];
	$data = json_decode($datatmp, true);
	foreach($data as $key => $param){
	   //POST or PUT parameters list
	    $dget[$key]=$param;
	}
   $unisxolh = $allPostPutVars['unisxolh'];
   $department = $allPostPutVars['department'];
   $onoma = $allPostPutVars['onoma'];
   $epitheto = $allPostPutVars['epitheto'];
   $email = $allPostPutVars['email'];
   $etmimalession = $allPostPutVars['etmimalession'];
   $lesson = $etmimalession[0]["m"];
   $ellak = $etmimalession[0]["s"];
   $g='';

   $storage = $diy_storage();
   $restapi = $diy_restapi();
   $restapitmp = $restapi['restapi'];
   $restapipoint = $restapi['endpoint'];
   $restapipoint2 = $restapi['endpoint2'];

   $M_HOST= $restapi['m_host'];
   $M_PORT= $restapi['m_port'];
   $M_FROM = $restapi['m_from'];
   $M_NAME  = $restapi['m_name'];
   $M_SUBJECT = $restapi['m_subject'];
   $M_STARTTLS = $restapi['m_starttls'];
   $M_BCC = $restapi['m_bcc'];

   $POST_LOG_PATH = $restapi['post_log_path'];
   
    try {
 		$g = 'INSERT INTO dataellak ( "onoma", "epitheto", "email", "eidikotita", "ergastirio", "ergastirioonoma", "ergastiriodrastiriotita", "ergastirioperigrafi", "ergastirioypefthinos", "ergastiriourl", "meta", "metatitlos", "idrima", "sxolh" ) VALUES ( :onoma, :epitheto, :email, :eidikotita, :ergastirio, :ergastirioonoma, :ergastiriodrastiriotita, :ergastirioperigrafi, :ergastirioypefthinos, :ergastiriourl, :meta, :metatitlos, :idrima, :sxolh)';
		$tmp = $data['eidikotita'];
        	$stmt = $storage->prepare($g);
		$stmt->bindValue(':onoma', $dget["onoma"]);
		$stmt->bindValue(':epitheto', $dget["epitheto"]);
		$stmt->bindValue(':email', $dget["email"]);
		$stmt->bindValue(':eidikotita', $dget["eidikotita"]);
		$stmt->bindValue(':ergastirio', $dget["ergastirio"]);
		$stmt->bindValue(':ergastirioonoma', $dget["ergastirioonoma"]);
		$stmt->bindValue(':ergastiriodrastiriotita', $dget["ergastiriodrastiriotita"]);
		$stmt->bindValue(':ergastirioperigrafi', $dget["ergastirioperigrafi"]);
		$stmt->bindValue(':ergastirioypefthinos', $dget["ergastirioypefthinos"]);
		$stmt->bindValue(':ergastiriourl', $dget["ergastiriourl"]);
		$stmt->bindValue(':meta', $dget["meta"]);
		$stmt->bindValue(':metatitlos', $dget["metatitlos"]);
		$stmt->bindValue(':idrima', $dget["idrima"]);
		$stmt->bindValue(':sxolh', $dget["sxolh"]);

		$fields['edu_quest_applicant_name']= htmlspecialchars($dget["onoma"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_applicant_surname']= htmlspecialchars($dget["epitheto"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_applicant_email']= htmlspecialchars($dget["email"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_applicant_position']= htmlspecialchars($dget["eidikotita"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_lab_name']=htmlspecialchars($dget["ergastirioonoma"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_lab_activity']= htmlspecialchars($dget["ergastiriodrastiriotita"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_lab_activity_description']= htmlspecialchars($dget["ergastirioperigrafi"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_lab_head']= htmlspecialchars($dget["ergastirioypefthinos"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_lab_website']= htmlspecialchars($dget["ergastiriourl"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_institution']=htmlspecialchars($dget["idrima"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_department']=htmlspecialchars($dget["sxolh"], ENT_QUOTES, "UTF-8");
		$fields['edu_quest_graduate_title']=htmlspecialchars($dget["metatitlos"], ENT_QUOTES, "UTF-8");

		// Check and replace eidikotita vlaues with human friendly names
		if($data['eidikotita'] == 'didaktiko'){
			$mail_applicant_position = 'Διδακτικό Ερευνητικό Προσωπικό';
		}elseif($data['eidikotita'] == 'fititis'){
			$mail_applicant_position = 'Φοιτητής/τρια';
		}elseif($data['eidikotita'] == 'ergastiriako'){
			$mail_applicant_position = 'Εργαστηριακό Προσωπικό -Βοηθοί και Επιστημονικοί Συνεργάτες';
		}elseif($data['eidikotita'] == 'meta'){
			$mail_applicant_position = 'Μεταπτυχιακός φοιτητής';
		}elseif($data['eidikotita'] == 'dioikitiko'){
			$mail_applicant_position = 'Διοικητικό Προσωπικό';
		}

		// Create the body of the email before looping over the "ellak" array.
		$body = "
Σας ευχαριστούμε για τη συμμετοχή σας, στέλνουμε για ενημέρωση τα στοιχεία
που καταχωρίσατε στο ερωτηματολόγιο. Τα στοιχεία που καταχωρίσατε θα
δημοσιευτούν σύντομα στο
https://edu.ellak.gr/mitroo-anichton-technologion-stin-tritovathmia-ekpedefsi/.
Στην ίδια σελίδα μπορείτε να δείτε όλες τις καταχωρίσεις.

Στόχος του ερωτηματολογίου είναι να καταγραφούν όλα τα έργα ανοιχτού
λογισμικού, ανοιχτών τεχνολογιών και περιεχομένου που χρησιμοποιούνται ή
αναπτύσσονται στην τριτοβάθμια εκπαίδευση, για να δημιουργηθεί ένα μητρώο
ανοιχτότητας που θα λειτουργήσει ως πλατφόρμα συνεργασίας και δημοσιότητας
έργων και καλών πρακτικών στην ακαδημαϊκή-ερευνητική κοινότητα. Παράλληλα
θα εμπλουτίζεται ο πίνακας ισοδυνάμων λογισμικών
<https://mathe.ellak.gr/?page_id=135> ώστε να υπάρχει συνοπτική εικόνα για
όλα τα ανοιχτά λογισμικά που μπορούν να χρησιμοποιηθούν στην εκπαιδευτική
διαδικασία.

Για ότι επιπλέον πληροφορίες ή/και προτάσεις μπορείτε να στείλετε
ηλεκτρονικό ταχυδρομείο στο info@ellak.gr .


Σας ευχαριστούμε,
Η ομάδα υποστήριξης της ΕΕΛΛΑΚ.


======================== Τα στοιχεία που καταχωρίσατε ======================

Όνομα: ................... ".$dget["onoma"]."
Επώνυμο: ................. ".$dget["epitheto"]."
Email: ................... ".$dget["email"]."
Ειδικότητα: .............. $mail_applicant_position\n
Όνομα Εργαστηρίου: ....... ".$dget["ergastirioonoma"]."
Δραστηριότητα Εργαστηρίου: ".$dget["ergastiriodrastiriotita"]."
Περιγραφή Εργαστηρίου: ... ".$dget["ergastirioperigrafi"]."
Υπεύθυνος Εργαστηρίου: ... ".$dget["ergastirioypefthinos"]."
Ιστοσελίδα Εργαστηρίου: .. ".$dget["ergastiriourl"]."\n
Ίδρυμα: .................. ".$dget["idrima"]."
Τμήμα: ................... ".$dget["sxolh"]."
Τίτλος Μεταπτυχιακού: .... ".$dget["metatitlos"]."\n";

        	$stmt->execute();

        	$lastid = $storage->lastInsertId();
		if($data['eidikotita'] == 'didaktiko' || $data['eidikotita'] == 'fititis' || $data['eidikotita'] == 'ergastiriako'){
			$g1 = 'INSERT INTO datamathima ( "id", "mathima", "ellak", "ellakurl" ) VALUES ( :lastid, :mathima, :ellak, :ellakurl)';
		}elseif($data['eidikotita'] == 'meta'){
                        $g1 = 'INSERT INTO datameta ( "id", "metamathima", "ellak", "ellakurl" ) VALUES ( :lastid, :mathima, :ellak, :ellakurl)';
		}elseif($data['eidikotita'] == 'dioikitiko'){
                        $g1 = 'INSERT INTO datadioikitiko ( "id", "mathima", "ellak", "ellakurl" ) VALUES ( :lastid, :mathima, :ellak, :ellakurl)';
		}
			$arr_length = count($dget["ellak"]);
			$stmt1 = $storage->prepare($g1);
			$ii=1;
			for($i=0;$i<$arr_length;$i++) {
					$stmt1->bindValue(':lastid', $lastid);
					if($data['eidikotita'] == 'dioikitiko'){
						$stmt1->bindValue(':mathima', '');
					}else{
						$stmt1->bindValue(':mathima', $dget["ellak"][$i]["mathima"]);
						$contentellakm = $dget["ellak"][$i]["mathima"];
					}
					if($dget["ellak"][$i]["tech"] != ''){
						$stmt1->bindValue(':ellak', $dget["ellak"][$i]["tech"]);
						$contentellakt = $dget["ellak"][$i]["tech"];
					}
					elseif($dget["ellak"][$i]["url"] != ''){
						$stmt1->bindValue(':ellakurl', $dget["ellak"][$i]["url"]);
						$contentellaku = $dget["ellak"][$i]["url"];
					}
				if($i == $ii){
					$fields['edu_quest_course']= htmlspecialchars($contentellakm, ENT_QUOTES, "UTF-8");
					$fields['edu_quest_software']= htmlspecialchars($contentellakt, ENT_QUOTES, "UTF-8");
					$fields['edu_quest_software_url']= htmlspecialchars($contentellaku, ENT_QUOTES, "UTF-8");

					// Add to the email body the course, sotfware and the software_url, within the loop.
					$body .= "\nΜάθημα/Εργαστήριο: ....... $contentellakm\n";
					$body .=   "Ανοιχτή Τεχνολογία: ...... $contentellakt\n";
					$body .=   "Ιστοσελίδα Τεχνολογίας: .. $contentellaku\n";

					$TITLOS = $dget["email"];

					$data_json =  '{ "title": "'.$TITLOS.'", "status":"pending" }';
					$exec = 'curl -s -k --header "Authorization: Basic '.$restapitmp.'" -H "Content-Type: application/json" -X POST  '.$restapipoint.' -d '."'".$data_json."'";

					$exec .= " 2>&1";
					exec($exec, $output, $return_var);
					$obj = json_decode($output[0]);

					// Optional exit code check of curl command
					//if ($return_var != 0) {
					  error_log(date("F j, Y, g:i a e O").PHP_EOL, 3, $POST_LOG_PATH);
					  if (isset($obj->{'id'})) {
					    // Log the result of the POST request to file, if logging to webserver
					    // log file the json object gets truncated thus logging only a few lines
					    error_log(print_r($obj, TRUE), 3, $POST_LOG_PATH);
					  }else {
					    error_log(print_r($output, TRUE), 3, $POST_LOG_PATH);
					  }
					//}

					$fields1['fields']=$fields;
					$content1 = json_encode($fields1);
					$exec1 = 'curl -s -k --header "Authorization: Basic '.$restapitmp.'" -H "Content-Type: application/json" -X POST  '.$restapipoint2.'/'.$obj->{'id'}.' -d '."'".$content1."'";

					$exec1 .= " 2>&1";
					exec($exec1, $output1, $return_var1);

					//if ($return_var1 != 0) {
					  $obj1 = json_decode($output1[0]);
					  error_log(date("F j, Y, g:i a e O").PHP_EOL, 3, $POST_LOG_PATH);
					  if (isset($obj1->{'acf'}->{'edu_quest_applicant_email'})) {
					    error_log(print_r($obj1, TRUE), 3, $POST_LOG_PATH);
					  }else {
					    error_log(print_r($output1, TRUE), 3, $POST_LOG_PATH);
					  }
					//}

					$contentellakm='';
					$contentellakt='';
					$contentellaku='';
					$output='';
					$output1='';
					$stmt1->execute();
					$ii = $ii + 2;
				}
			}

	$to = $dget["email"];
	$from = $M_FROM;
	$from_name = $M_NAME;
	$subject = $M_SUBJECT;
	// Add the footer to the email body.
	$body .= "\n===================================================================";
	smtpmailer($to, $from, $from_name, $subject, $body, $M_HOST, $M_PORT, $M_STARTTLS, $M_BCC);

	//result_messages===============================================================      
        //$result["result"]=  $q;
        //$result["dget"]=  $dget;
        //$result["dgettmp"]=  $content1;
        //$result["dgettmp1"]=  $exec;
        //$result["dgettmp2"]=  $output;
        //$result["dgettmp3"]=  $return_var;
        //$result["g"]=  $g;
        $result["status"] = "200";
        $result["message"] = "NoErrors";
    } catch (Exception $e) {
        $result["status"] = $e->getCode();
        $result["message"] = $e->getMessage();
    }

     $response->withHeader('Content-Type', 'application/json;charset=utf-8');
     //$response->getBody()->write(json_encode($result));
     $response->getBody()->write( toGreek( json_encode( $result ) ) );
     //return $response->withJson();

     return $response;
});
