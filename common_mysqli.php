<?php

// ====================  GENERAL DB access for odtphp
// here all SQL functions
// implementation using mysqli_xxxx 
//  license LGPL 
$dbconn = null;

function sql($statment) {
   // print($statment . '<BR>');
//====================================================    

    $result = null;
    // connection data
    include(dirname(__FILE__) . "/config.php");

    /*     * **** Connect to MySQL ***** */
    if (!extension_loaded('mysqli')) {
        echo "<div class=error>INTERNAL ERROR: PHP is not configured to connect to MySQL on this machine.
         Please see <a href=http://www.php.net/manual/en/ref.mysql.php>this page</a> for help 
         on how to configure MySQL.</div>";
        exit();
    }

    $dbconn = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbDatabase);
    if (mysqli_connect_errno()) {
        echo "<div class=error>";
        echo 'INTERNAL ERROR: Error in connection <br />' . mysqli_connect_error();
        ;
        echo "</div>";
        exit();
    }

    /*     * **** Connection Charset ******* */
    mysqli_set_charset($dbconn, "UTF8");

    if (!$result = mysqli_query($dbconn, $statment)) {
        echo "<div class=Error>";
        echo "INTERNAL ERROR: Query error in  '$statment' <br />" . mysqli_error($dbconn);
        echo "</div>";
        exit();
    }
    return $result;
}

// ================================== sql to arrays	 
// return only a  value
function sqlValue($query) {
    $result = sql($query);
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    return $row[0];
}

// return an array of values: array[]=row[0]
function sqlArray($query) {
    $result = sql($query);
    $dats = array();
    while ($row = mysqli_fetch_row($result)) {
        $dats[] = $row[0];
    }
    if ($result) {
        mysqli_free_result($result);
    }
    return $dats;
}

/*
 * 	low-level DB read using SQL.
 *  return a rows array: array[] = (row(0), row(1), row(2)...)
 *  note: in queries are allowed fields (#field#) replaced by actual values in $this->assigned_field
 */

function sqlArrayTot($query) {
    $r = sql($query);
    $arrayData = array();
    while ($sub = mysqli_fetch_array($r)) {
        array_push($arrayData, $sub);
    }
    mysqli_free_result($r);
    return $arrayData;
}

// return an array of values: array[key]=row[0]

function sqlRecord($query) {
    $result = sql($query);
    $dats = mysqli_fetch_array($result);
    mysqli_free_result($result);
    return $dats;
}
 // ================================== ENDS GENERAL MYSQL
 
 //=========== some mysql-HTML utilities:

// return an associative lookup: array[row[0]]=row[1]
function sqlLookup($query) {
    $result = sql($query);
    $dats = array();
    while ($row = mysqli_fetch_row($result)) {
        $dats[$row[0]] = $row[1];
    }
    mysqli_free_result($result);
    return $dats;
}

// for combo input, options from a query (id, value)
function optionsList($query, $selected = -1) {
    $options = '';
    $ops = sqlLookup($query);
    while (list($chiave, $valore) = each($ops)) {
        $options .= "<option value='$chiave' " . ($chiave == $selected ? ' selected = "selected"' : '') . " >$valore</option>\n";
    }
    return $options;
}

// per combo input, coppie numeriche
function optionsNList($from, $to, $selected) {
    $options = '';
    for ($i = $from; $i < $to; $i++) {
        $options .= "<option value='$i'" . ($i == $selected ? ' selected = "selected"' : '') . " >$i</option>\n";
    }
    return $options;
}

// per checklist, da una query (id, value, list di chiavi|true|false)                      
function checkList($query, $name, $checked) {
    $check = '';
    $ops = sqlLookup($query);
    $i = 1;
    while (list($chiave, $valore) = each($ops)) {
        if (is_array($checked)) {
            $check .= "<input type='checkbox' name='$name" . $i++ . "' value='$chiave' " . (
                    array_search($chiave, $checked) !== false ? "checked='checked'" : '') . " />$valore<br />";
        } else {
            $check .= "<input type='checkbox' name='$name" . $i++ . "' value='$chiave' " . ($checked ? "checked='checked'" : '') . " />$valore<br />";
        }
    }
    return $check;
}

// per redirect ad una nuova pagina da php  
function movePage($num, $url) {
    static $http = array(
        100 => "HTTP/1.1 100 Continue",
        101 => "HTTP/1.1 101 Switching Protocols",
        200 => "HTTP/1.1 200 OK",
        201 => "HTTP/1.1 201 Created",
        202 => "HTTP/1.1 202 Accepted",
        203 => "HTTP/1.1 203 Non-Authoritative Information",
        204 => "HTTP/1.1 204 No Content",
        205 => "HTTP/1.1 205 Reset Content",
        206 => "HTTP/1.1 206 Partial Content",
        300 => "HTTP/1.1 300 Multiple Choices",
        301 => "HTTP/1.1 301 Moved Permanently",
        302 => "HTTP/1.1 302 Found",
        303 => "HTTP/1.1 303 See Other",
        304 => "HTTP/1.1 304 Not Modified",
        305 => "HTTP/1.1 305 Use Proxy",
        307 => "HTTP/1.1 307 Temporary Redirect",
        400 => "HTTP/1.1 400 Bad Request",
        401 => "HTTP/1.1 401 Unauthorized",
        402 => "HTTP/1.1 402 Payment Required",
        403 => "HTTP/1.1 403 Forbidden",
        404 => "HTTP/1.1 404 Not Found",
        405 => "HTTP/1.1 405 Method Not Allowed",
        406 => "HTTP/1.1 406 Not Acceptable",
        407 => "HTTP/1.1 407 Proxy Authentication Required",
        408 => "HTTP/1.1 408 Request Time-out",
        409 => "HTTP/1.1 409 Conflict",
        410 => "HTTP/1.1 410 Gone",
        411 => "HTTP/1.1 411 Length Required",
        412 => "HTTP/1.1 412 Precondition Failed",
        413 => "HTTP/1.1 413 Request Entity Too Large",
        414 => "HTTP/1.1 414 Request-URI Too Large",
        415 => "HTTP/1.1 415 Unsupported Media Type",
        416 => "HTTP/1.1 416 Requested range not satisfiable",
        417 => "HTTP/1.1 417 Expectation Failed",
        500 => "HTTP/1.1 500 Internal Server Error",
        501 => "HTTP/1.1 501 Not Implemented",
        502 => "HTTP/1.1 502 Bad Gateway",
        503 => "HTTP/1.1 503 Service Unavailable",
        504 => "HTTP/1.1 504 Gateway Time-out"
    );
    header($http[$num]);
    header("Location: $url");
    exit;
}
