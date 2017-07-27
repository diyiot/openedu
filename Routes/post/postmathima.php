<?php




$app->post('/mathima', function($request, $response) use ($diy_storage, $diy_restapi){


        function smtpmailer($to, $from, $from_name, $subject, $body, $M_HOST, $M_PORT) {
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

		$fields['edu_quest_applicant_name']= $dget["onoma"];
		$fields['edu_quest_applicant_surname']= $dget["epitheto"];
		$fields['edu_quest_applicant_email']= $dget["email"];
		$fields['edu_quest_applicant_position']= $dget["eidikotita"];
		$fields['edu_quest_lab_name']=$dget["ergastirioonoma"];
		$fields['edu_quest_lab_activity']= $dget["ergastiriodrastiriotita"];
		$fields['edu_quest_lab_activity_description']= $dget["ergastirioperigrafi"];
		$fields['edu_quest_lab_head']= $dget["ergastirioypefthinos"];
		$fields['edu_quest_lab_website']= $dget["ergastiriourl"];
		$fields['edu_quest_institution']=$dget["idrima"];
		$fields['edu_quest_department']=$dget["sxolh"];
		$fields['edu_quest_graduate_title']=$dget["metatitlos"];

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

Όνομα: ................... {$fields['edu_quest_applicant_name']}
Επώνυμο: ................. {$fields['edu_quest_applicant_surname']}
Email: ................... {$fields['edu_quest_applicant_email']}
Ειδικότητα: .............. $mail_applicant_position\n
Όνομα Εργαστηρίου: ....... {$fields['edu_quest_lab_name']}
Δραστηριότητα Εργαστηρίου: {$fields['edu_quest_lab_activity']}
Περιγραφή Εργαστηρίου: ... {$fields['edu_quest_lab_activity_description']}
Υπεύθυνος Εργαστηρίου: ... {$fields['edu_quest_lab_head']}
Ιστοσελίδα Εργαστηρίου: .. {$fields['edu_quest_lab_website']}\n
Ίδρυμα: .................. {$fields['edu_quest_institution']}
Τμήμα: ................... {$fields['edu_quest_department']}
Τίτλος Μεταπτυχιακού: .... {$fields['edu_quest_graduate_title']}\n";

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
					$fields['edu_quest_course']= $contentellakm;
					$fields['edu_quest_software']= $contentellakt;
					$fields['edu_quest_software_url']= $contentellaku;

					// Add to the email body the course, sotfware and the software_url, within the loop.
					$body .= "\nΜάθημα/Εργαστήριο: ....... {$fields['edu_quest_course']}\n";
					$body .=   "Ανοιχτή Τεχνολογία: ...... {$fields['edu_quest_software']}\n";
					$body .=   "Ιστοσελίδα Τεχνολογίας: .. {$fields['edu_quest_software_url']}\n";

					$TITLOS = $dget["email"];

					$data_json =  '{ "title": "'.$TITLOS.'", "status":"pending" }';
					$exec = 'curl -k --header "Authorization: Basic '.$restapitmp.'" -H "Content-Type: application/json" -X POST  '.$restapipoint.' -d '."'".$data_json."'";

					$exec .= " | jq '.id' 2>&1";
					exec($exec, $output, $return_var);
					$fields1['fields']=$fields;
					$content1 = json_encode($fields1);
					$exec1 = 'curl -k --header "Authorization: Basic '.$restapitmp.'" -H "Content-Type: application/json" -X POST  '.$restapipoint2.'/'.$output[0].' -d '."'".$content1."'";

					$exec1 .= " 2>&1";
					exec($exec1, $output1, $return_var1);
					$contentellakm='';
					$contentellakt='';
					$contentellaku='';
					$output='';
					$stmt1->execute();
					$ii = $ii + 2;
				}
			}
	$content = json_encode($fields);
	$to = $dget["email"];
	$from = $M_FROM;
	$from_name = $M_NAME;
	$subject = $M_SUBJECT;
	// Add the footer to the email body.
	$body .= "\n===================================================================";
	smtpmailer($to, $from, $from_name, $subject, $body, $M_HOST, $M_PORT);

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
