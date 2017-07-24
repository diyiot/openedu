# openedu-quest

Open Technologies questionnaire for the Greek research and academic community  

Scripts related to the implementation of the questionnaire for the use of Open
Technologies in the Greek Universities.

Τα scripts δημιουργήθηκαν για την κατασκευή ερωτηματολογίου για την καταγραφή
της χρήσης ανοιχτών τεχνολογιών και ανοιχτού περιεχομένου στα ιδρύματα της
τριτοβάθμιας εκπαίδευσης στην Ελλάδα.

<dl>
  <dt> Επιλογές που προσφέρουν τα scripts </dt>

1. Συμπλήρωση στοιχείων συμμετέχοντα
2. Επιλογή Εκπαιδευτικού Ιδρύματος ή Ερευνητικού Κέντρου
3. Επιλογή για συμμετοχή σε εργαστήριο ή ερευνητική ομάδα
4. Επιλογή Τμήματος από το ίδρυμα
5. Πολλαπλή επιλογή μαθημάτων ανάλογα με το τμήμα που έχει επιλέξει ο
συμμετέχοντας και εισαγωγή από τον χρήστη της ανοιχτής τεχνολογίας - λογισμικού

<dl>
  <dt>Δυνατότητες </dt>
  
1. Αποστολή ειδοποίησης συμπλήρωσης ερωτηματολγίου με email 
2. Αποστολή mail στο mail του συμμετέχοντα με τα στοιχεία που συμπλήρωσε
3. Δυνατότητα συγκέντρωσης στοιχείων σε csv
4. Αυτόματη δημοσίευση σε html ανώνυμων στοιχείων (χωρίς όνομα & mail) ανά ίδρυμα

## Installation

There is an htaccess file **web/.htaccess** which should be taken under
consideration. The root direcroty defined in the webserver should be **./web**
where the *index.php* file resides.

### Dependencies

#### OS

1. curl
2. jq
3. php5-sqlite

#### Wordpress plugins

1. acf-to-rest-api
2. advanced-custom-fields
3. application-passwords

### Configuration

Example configuration files are included. Copy the examples and edit them to
apply to your infrastructure.

1. **cp restapi/file.example.php restapi/file.php**</br>
This configuration file includes the base64 "username:password" from the
"application-passwords" plugin, and the 2 api endpoints for the wp-api and the
acf-api.


2. **cp web/indexconfig.example.php web/indexconfig.php**</br>
The root directory of the application files must be defined here.


3. **cp web/view/indexconfig.example.js web/view/indexconfig.js**</br>
In this file 2 url must be defined. The "API" url which is located at url where
the application itself runs and the link to the opendata file where the results
of the questionnaire will be hosted.

4. **cp db/sql.default.db db/sql.db**</br>
This is the local database the application uses. In this file there is by
default data about institutions, departments and lessons. The results of the
questionnaire are also stored here.
