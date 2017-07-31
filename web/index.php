<?php
session_start();
//=========================  GLOBAL ==================================
class diyConfig
{
    static $confArray;

    public static function read($name)
    {
        return self::$confArray[$name];
    }

    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }

}

require 'indexconfig.php';
require $projectDir.'/vendor/PHPMailer-master/PHPMailerAutoload.php';
require $projectDir.'/restapi/file.php';
//$projectDir = '/var/www/aeitei';   //define the directory containing the project files

// db
$dbfile = $projectDir.'/db/sql.db';
diyConfig::write('db.file', sprintf($dbfile));
diyConfig::write('db.dsn',  sprintf('sqlite:%s', $dbfile));
diyConfig::write('db.port', '');
diyConfig::write('db.basename', '');
diyConfig::write('db.username', '');
diyConfig::write('db.password', '');

diyConfig::write('restapi', $base64Pass);
diyConfig::write('endpoint', $endpoint);
diyConfig::write('endpoint2', $endpoint2);

diyConfig::write('m_host', $M_HOST);
diyConfig::write('m_port', $M_PORT);
diyConfig::write('m_from', $M_FROM);
diyConfig::write('m_name', $M_NAME);
diyConfig::write('m_subject', $M_SUBJECT);
diyConfig::write('m_starttls', $M_STARTTLS);
diyConfig::write('m_bcc', $M_BCC);
//=========================  REQUIRE ==================================

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Slim\App;
use Slim\Exception\NotFoundException;
//use Slim\Http\Request;
//use Slim\Http\Response;    


require '../vendor/autoload.php';
require "$projectDir/includes/index.php";     //include the file which contains all the project related includes
//=========================  OBJ / DB FUNCTION ==================================
//$app = new \Slim\App;
//$app->config('debug', true);

$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,

        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => $projectDir.'/logs/app.log',
        ],
    ],
];

$app = new \Slim\App($config);



$diy_storage = function ()
{
        //global $conOptions;
        $_dbfile = diyConfig::read('db.file');
        $db = new PDO(sprintf('sqlite:%s', $_dbfile));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $db;
};

$diy_restapi = function()
{
	$restapi['restapi'] = diyConfig::read('restapi');
	$restapi['endpoint'] = diyConfig::read('endpoint');
	$restapi['endpoint2'] = diyConfig::read('endpoint2');
	$restapi['m_host'] = diyConfig::read('m_host');
	$restapi['m_port'] = diyConfig::read('m_port');
	$restapi['m_from'] = diyConfig::read('m_from');
	$restapi['m_name'] = diyConfig::read('m_name');
	$restapi['m_subject'] = diyConfig::read('m_subject');
	$restapi['m_starttls'] = diyConfig::read('m_starttls');
	$restapi['m_bcc'] = diyConfig::read('m_bcc');
	return $restapi;
};

//=========================  ROUTE ==================================
/*Directories that contain api POST/GET*/
$diy_classesDir = array (
    $projectDir.'/Routes/get/',
    $projectDir.'/Routes/post/'
);
foreach ($diy_classesDir as $directory) {
        foreach (glob("$directory*.php") as $__filename){
            require_once ($__filename);
        }
}


//=========================  HELPER ==================================
//function not found
 //   echo toGreek( json_encode( $result ) );

$middleware = function (Request $request, Response $response, $next) {

    if (!$request->getAttribute('route')) {
        $res = array("msg"=>"page not found");
        $response->getBody()->write(json_encode($res));
        return $response;
    }

    return $next($request, $response);
};
$app->add($middleware);

$app->run();                            //load the application

//=================================== ETC FUNCTIONS ======================================


function UrlParamstoArray($params)
{
    $items = array();
    foreach (explode('&', $params) as $chunk) {
        $param = explode("=", $chunk);
        $items = array_merge($items, array($param[0] => urldecode($param[1])));
    }
    return $items;

}

function loadParameters()
{
    global $app;

    return $params;
}

function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}

function toGreek($value)
{
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $value ? $value : array());
}


function diy_validate64($buffer)
{
  $VALID  = 1;
  $INVALID= 0;

  $p    = $buffer;
  $len  = strlen($p);

  for($i=0; $i<$len; $i++)
  {
     if( ($p[$i]>="A" && $p[$i]<="Z")||
         ($p[$i]>="a" && $p[$i]<="z")||
         ($p[$i]>="/" && $p[$i]<="9")||
         ($p[$i]=="+")||
         ($p[$i]=="=")||
         ($p[$i]=="\x0a")||
         ($p[$i]=="\x0d")
       )
       continue;
     else
       return $INVALID;
  }  //fall through if all ok
return $VALID;
};
