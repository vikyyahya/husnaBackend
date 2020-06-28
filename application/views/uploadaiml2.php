<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/_partials/head.php") ?>
</head>

<body id="page-top">
    <?php
    require_once('config/global_config.php');
    // set up error logging and display
    ini_set('log_errors', true);
    ini_set('error_log', _LOG_PATH_ . 'admin.error.log');
    ini_set('html_errors', false);
    ini_set('display_errors', false);
    global $idA;
    $idA = $this->session->userdata('user_id');
    echo $idA;
    // global $var;
    // $var = "test";
    // function foo2()
    // {
    //     global $var;
    //     echo $var; // this print "test"
    // }
    // foo2();
    if (isset($_POST['action'])) {
        $bot_id = $_POST['bot_id'];
        echo " bot id = " . $bot_id;
    }

    function db_open()
    {


        global $dbh, $dbu, $dbp, $dbn, $dbPort, $a, $idA, $bot_id;
        echo "ok ===  " . $idA;


        try {
            $dbConn = new PDO("mysql:host=localhost;port=3360;dbname=dbChatbotApk;charset=utf8", "root", "");
            $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbConn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $dbConn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            // echo " ok db open = ".$a;
        } catch (Exception $e) {

            //exit('Program O has encountered a problem with connecting to the database. With any luck, the following information will help: ' . $e->getMessage());

            $errMsg = <<<endMsg
Program O000000 has encountered a problem with connecting to the database. With any luck, the following information will help:<br>
Error message: {$e->getMessage()}<br>
Host: {$dbh}<br>
Port: {$dbPort}<br>
User: {$dbu}<br>
Pass: {$dbp}<br>

endMsg;
            exit($errMsg);
        }

        return $dbConn;
    }

    /**
     * function db_close()
     * Close the connection to the database
     *
     * @link     http://blog.program-o.com/?p=1343
     * @internal param resource $dbConn - the open connection
     *
     * @return null
     */
    function db_close($inPGO = true)
    {
        if ($inPGO) runDebug(__FILE__, __FUNCTION__, __LINE__, 'This DB is now closed. You don\'t have to go home, but you can\'t stay here.', 2);
        return null;
    }

    /**
     * function db_fetch
     * Fetches a single row of data from the database
     *
     * @param string $sql - The SQL query to execute
     * @param mixed $params - either an array of placeholder/value pairs, or null, for no parameters
     * @param string $file - the path/filename of the file that the function call originated in
     * @param string $function - the name of the function that the function call originated in
     * @param string $line - the line number of the originating function call
     *
     * @return mixed $out - Either the row of data from the DB query, or false, if the query fails
     */
    function db_fetch($sql, $params = null, $file = 'unknown', $function = 'unknown', $line = 'unknown', $inPGO = true)
    {
        $fn = basename($file);
        global $dbConn;
        // echo " tes".$dbh;
        if (!isset($dbConn)) $dbConn = db_open();
        try {
            $sth = $dbConn->prepare($sql);
            if ($params === null) $sth->execute();
            else {
                foreach ($params as $label => $value) {
                    switch (gettype($value)) {
                        case 'boolean':
                            $paramType = PDO::PARAM_BOOL;
                            break;
                        case 'integer':
                            $paramType = PDO::PARAM_INT;
                            break;
                        case 'NULL':
                            $paramType = PDO::PARAM_NULL;
                            break;
                        default:
                            $paramType = PDO::PARAM_STR;
                    }
                    $sth->bindValue($label, $value, $paramType);
                }
                $sth->execute();
            }
            $out = $sth->fetch();
        } catch (Exception $e) {
            //error_log("bad SQL encountered in file $file, line #$line. SQL:\n$sql\n", 3, _LOG_PATH_ . 'badSQL.txt');
            $pdoError = print_r($dbConn->errorInfo(), true);

            /** @noinspection PhpUndefinedVariableInspection */
            $psError = print_r($sth->errorInfo(), true);
            if ($inPGO) {
                $errSQL = db_parseSQL($sql, $params);
                $errParams = print_r($params, true);
                $eMessage = $e->getMessage();
                $rdMsg = <<<endMsg
An error was generated while extracting a row of data from the database. Relevant info:
File: $file
Function: $function
Line #: $line
Error Message: $eMessage
SQL: $errSQL
Parameters: $errParams
PDO error: $pdoError
PDOStatement error: $psError

endMsg;
                runDebug(__FILE__, __FUNCTION__, __LINE__, $rdMsg, 4);
                $fn = basename($file);
                $errLogPath = "{$fn}.{$function}.error.log";
                error_log($rdMsg, 3, _LOG_PATH_ . $errLogPath);
            }
            $out = false;
        }
        return $out;
    }

    /**
     * function db_fetchAll
     * Fetches rows of data from the database
     *
     * @param string $sql - The SQL query to execute
     * @param mixed $params - either an array of placeholder/value pairs, or null, for no parameters
     * @param string $file - the path/filename of the file that the function call originated in
     * @param string $function - the name of the function that the function call originated in
     * @param string $line - the line number of the originating function call
     *
     * @return mixed $out - Either an array of data from the DB query, or false, if the query fails
     */
    function db_fetchAll($sql, $params = null, $file = 'unknown', $function = 'unknown', $line = 'unknown', $inPGO = true)
    {

        if (isset($_POST['action'])) {
            $bot_id = $_POST['bot_id'];
        }

        // echo "db_feAL ";
        global $dbConn;
        if (!isset($dbConn)) $dbConn = db_open();

        // echo"okk db fetall ";

        try {
            $sth = $dbConn->prepare($sql);
            if ($params === null) $sth->execute();
            else {
                foreach ($params as $label => $value) {
                    switch (gettype($value)) {
                        case 'boolean':
                            $paramType = PDO::PARAM_BOOL;
                            break;
                        case 'integer':
                            $paramType = PDO::PARAM_INT;
                            break;
                        case 'NULL':
                            $paramType = PDO::PARAM_NULL;
                            break;
                        default:
                            $paramType = PDO::PARAM_STR;
                    }
                    $sth->bindValue($label, $value, $paramType);
                }
                $sth->execute();
            }
            $out = $sth->fetchAll();
        } catch (Exception $e) {
            //error_log("bad SQL encountered in file $file, line #$line. SQL:\n$sql\n", 3, _LOG_PATH_ . 'badSQL.txt');
            $pdoError = print_r($dbConn->errorInfo(), true);

            /** @noinspection PhpUndefinedVariableInspection */
            $psError = print_r($sth->errorInfo(), true);
            $errSql = db_parseSQL($sql, $params);
            $dParams = (!is_null($params)) ? print_r($params, true) : 'null';
            $errMsg = <<<endMsg
An error was generated while extracting multiple rows of data from the database in file $file at line $line, in the function $function.
SQL: $errSql
Params: $dParams
PDO error: $pdoError
PDO_statement error: $psError

endMsg;
            if ($inPGO) runDebug(__FILE__, __FUNCTION__, __LINE__, $errMsg, 0);
            $out = false;
        }
        return $out;
    }

    /**
     * function db_write
     * write to the database
     *
     * @param string $sql - The SQL query to execute
     * @param mixed $params - either an array of placeholder/value pairs, or null, for no parameters
     * @param bool $multi - TODO add missing argument description
     * @param string $file - the path/filename of the file that the function call originated in
     * @param string $function - the name of the function that the function call originated in
     * @param string $line - the line number of the originating function call
     *
     * @return mixed $out - Either the number of rows affected by the DB query
     */
    function db_write($sql, $params = null, $multi = false, $file = 'unknown', $function = 'unknown', $line = 'unknown', $inPGO = true)
    {
        global $dbConn;
        if (!isset($dbConn)) $dbConn = db_open();
        $newLine = PHP_EOL;
        try {
            $sth = $dbConn->prepare($sql);

            switch (true) {
                case ($params === null):
                    $sth->execute();
                    break;

                case ($multi === true):
                    foreach ($params as $row) {
                        $sth->execute($row);
                    }
                    break;

                default:
                    $sth->execute($params);
            }

            return (!$multi) ?  $sth->rowCount() : count($params);
        } catch (Exception $e) {
            $errParams = ($multi) ? $row : $params;
            $paramsText = print_r($errParams, true);
            $pdoError = print_r($dbConn->errorInfo(), true);

            /** @noinspection PhpUndefinedVariableInspection */
            $psError = print_r($sth->errorInfo(), true);
            $eMessage = $e->getMessage();
            $errSQL = db_parseSQL($sql, $errParams);
            $errorMessage = <<<endMessage
Bad SQL encountered in file $file, line #$line. SQL:
$errSQL
PDO Error:
$pdoError
PDOStatement Error:
$psError
Exception Message:
$eMessage;
Parameters:
$paramsText
endMessage;

            $fn = basename($file);
            $errLogPath = "{$fn}.{$function}.error.log";
            error_log($errorMessage, 3, _LOG_PATH_ . $errLogPath);

            $rdMessage = <<<endMessage
An error was generated while writing to the database in file $file at line $line, in the function $function.
SQL: $errSQL
PDO error: $pdoError
PDOStatement error: $psError
endMessage;

            if ($inPGO) runDebug(__FILE__, __FUNCTION__, __LINE__, $rdMessage, 0);
            return false;
        }
    }


    /**
     * function db_parseSQL
     *
     * Converts a prepared statment query into a human readable version
     *
     * @param string $sql
     * @param array $params
     *
     * @return string $out
     */

    function db_parseSQL($sql, $params = null)
    {
        $out = $sql;
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                if (is_numeric($key)) // deal with unnamed placeholders (?)
                {
                    $limit = 1;
                    $search = '/\?/';
                    $value = (is_numeric($value)) ? $value : "'$value'"; // if $value is a string, encase it in quotes
                    $out = preg_replace($search, $value, $out, $limit);
                } else // handle named parameters
                {
                    $value = (is_numeric($value)) ? $value : "'$value'"; // if $value is a string, encase it in quotes
                    $out = str_replace($key, $value, $out);
                }
            }
        }
        return $out;
    }

    function db_quote($in)
    {
        global $dbConn;
        if (!isset($dbConn)) $dbConn = db_open();
        return $dbConn->quote($in);
    }

    function db_lastInsertId($name = null)
    {
        global $dbConn;
        if (!isset($dbConn)) $dbConn = db_open();
        return $dbConn->lastInsertId($name);
    }

    /* A custom function that automatically constructs a multi insert statement.
 *
 * @param string $tableName Name of the table we are inserting into.
 * @param array $data An "array of arrays" containing our row data.
 * @param PDO $pdoObject Our PDO object.
 * @return boolean TRUE on success. FALSE on failure.
 */
    function db_multi_insert($tableName, $data,  $file = 'unknown', $function = 'unknown', $line = 'unknown')
    {
        global $dbConn;
        if (!isset($dbConn)) $dbConn = db_open();
        //Will contain SQL snippets.
        $rowsSQL = array();

        //Will contain the values that we need to bind.
        $toBind = array();

        //Get a list of column names to use in the SQL statement.
        $columnNames = array_keys($data[0]);

        //Loop through our $data array.
        foreach ($data as $arrayIndex => $row) {
            $params = array();
            foreach ($row as $columnName => $columnValue) {
                $param = ":" . $columnName . $arrayIndex;
                $params[] = $param;
                $toBind[$param] = $columnValue;
            }
            $rowsSQL[] = "(" . implode(", ", $params) . ")";
        }
        //save_file(_LOG_PATH_ . 'pdo_functions.db_multi_insert.params.txt', print_r($params, true));
        //return false;

        //Construct our SQL statement
        $sql = "INSERT INTO `$tableName` (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);

        try {
            //Prepare our PDO statement.
            $sth = $dbConn->prepare($sql);

            //Bind our values.
            foreach ($toBind as $param => $val) {
                $sth->bindValue($param, $val);
            }
            //Execute our statement (i.e. insert the data).
            $out = ($sth->execute()) ? $sth->rowCount() : false;
        } catch (Exception $e) {
            //error_log("bad SQL encountered in file $file, line #$line. SQL:\n$sql\n", 3, _LOG_PATH_ . 'badSQL.txt');
            $pdoError = print_r($dbConn->errorInfo(), true);

            /** @noinspection PhpUndefinedVariableInspection */
            $psError = print_r($sth->errorInfo(), true);
            $errSql = db_parseSQL($sql, $params);
            $dParams = (!is_null($params)) ? print_r($params, true) : 'null';
            $errMsg = <<<endMsg
An error was generated while extracting multiple rows of data from the database in file $file at line $line, in the function $function.
SQL: $errSql
Params: $dParams
PDO error: $pdoError
PDO_statement error: $psError

endMsg;
            //if ($inPGO) runDebug(__FILE__, __FUNCTION__, __LINE__, $errMsg, 0);
            $out = false;
        }
        return $out;
    }
    /** @noinspection PhpIncludeInspection */
    require_once('library/error_functions.php');
    /** @noinspection PhpIncludeInspection */
    require_once('library/misc_functions.php');
    /** @noinspection PhpIncludeInspection */
    require_once('library/template.class.php');
    /** @noinspection PhpIncludeInspection */
    require_once('admin/allowedPages.php');

    set_error_handler('handle_errors', E_ALL | E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE);
    $branches = array(
        'master' => 'Master',
        'dev' => 'Development',
        'person' => 'Person Tag Testing',
    );
    /***************************************
     * http://www.program-o.com
     * PROGRAM O
     * Version: 2.6.11
     * FILE: upload.php
     * AUTHOR: Elizabeth Perreau and Dave Morton
     * DATE: FEB 01 2016
     * DETAILS: Provides functionality to upload AIML files to a chatbot's database
     ***************************************/
    ini_set('memory_limit', '128M');
    ini_set('max_execution_time', '0');
    ini_set('display_errors', false);
    ini_set('log_errors', true);
    chdir(_ADMIN_PATH_);
    // check max file upload size and max post size, see which is smaller, and limit upload size to that value
    $upload_max_filesize = ini_get('upload_max_filesize');
    $post_max_size = ini_get('post_max_size');
    $limit_search = '/(\d+)(\w)/';
    preg_match($limit_search, $upload_max_filesize, $umf_matches);
    preg_match($limit_search, $post_max_size, $pms_matches);
    $umf_value = $umf_matches[1];
    $umf_suffix = strtoupper($umf_matches[2]);

    switch ($umf_suffix) {
        case 'K':
            $umf_factor = 1000;
            break;
        case 'M':
            $umf_factor = 1000 * 1000;
            break;
        case 'G':
            $umf_factor = 1000 * 1000 * 1000;
            break;
        default:
            $umf_factor = 1;
    }
    $umf_limit = $umf_value * $umf_factor;

    $pms_value = $pms_matches[1];
    $pms_suffix = strtoupper($pms_matches[2]);
    switch ($pms_suffix) {
        case 'K':
            $pms_factor = 1000;
            break;
        case 'M':
            $pms_factor = 1000 * 1000;
            break;
        case 'G':
            $pms_factor = 1000 * 1000 * 1000;
            break;
        default:
            $pms_factor = 1;
    }
    $pms_limit = $pms_value * $pms_factor;
    $fs_limit = ($umf_limit >= $pms_limit) ? $pms_limit : $umf_limit;
    $fs_limit_title = ($umf_limit >= $pms_limit) ? $pms_matches[0] : $umf_matches[0];
    $fs_limit_title .= 'B';

    $validationStatus = '';
    $msg = '';

    $ZIPenabled = class_exists('ZipArchive');
    // $ZIPenabled = false; // debugging and testing - comment out when complete

    libxml_use_internal_errors(true);
    $_SESSION['failCount'] = 0;

    /** @noinspection PhpUndefinedVariableInspection */
    // echo "awal bot id".$bot_id."\n";



    $bot_id = ($bot_id == 'new') ? 0 : $bot_id;
    $msg = (array_key_exists('aimlfile', $_FILES)) ? processUpload() : '';
    //     $upperScripts = <<<endScript

    //     <script type="text/javascript">
    // <!--
    //       function showMe() {
    //         var sh = document.getElementById('showHelp');
    //         var tf = document.getElementById('uploadForm');
    //         sh.style.display = 'block';
    //         tf.style.display = 'none';
    //       }
    //       function hideMe() {
    //         var sh = document.getElementById('showHelp');
    //         var tf = document.getElementById('uploadForm');
    //         sh.style.display = 'none';
    //         tf.style.display = 'block';
    //       }
    //       function showHide() {
    //         var display = document.getElementById('showHelp').style.display;
    //         switch (display) {
    //           case '':
    //           case 'none':
    //             return showMe();
    //             break;
    //           case 'block':
    //             return hideMe();
    //             break;
    //           default:
    //             alert('display = ' + display);
    //         }
    //       }
    //       function checkSize(){
    //         var file_upload = document.getElementById('aimlfile');
    //         if (!file_upload.files) return false;
    //         var fileSize = file_upload.files[0].size;//.fileSize;
    //         var fileName = file_upload.files[0].name;//.fileSize;
    //         if (fileSize > {$fs_limit}){
    //           showError("The file " + fileName + " exceeds the file size limit of {$fs_limit_title}. Please choose a different file.")
    //           file_upload.value = null;
    //         }
    //         var fileType = file_upload.files[0].type;//.fileSize;
    //         //showError('The file type is ' + file_upload.files[0].type);
    //         if (fileType != 'text/aiml' && fileType != 'application/x-zip-compressed') {
    //           //showError("The file " + fileName + " is neither an AIML file, nor a zip archive. Please select another file.")
    //           //file_upload.value = null;
    //         }
    //       }
    //       function showError(msg){
    //         var errorDiv = document.getElementById("errMsg");
    //         var closeButton = '<div class="closeButton" id="closeButton" onclick="closeStatus(\'errMsg\')" title="Click to hide">&nbsp;</div>';
    //           errorDiv.innerHTML = closeButton + msg;
    //           errorDiv.style.display = 'block';

    //       }
    // //-->
    //     </script>
    // endScript;

    $post_vars = filter_input_array(INPUT_POST);
    $XmlEntities = array('&amp;' => '&', '&lt;' => '<', '&gt;' => '>', '&apos;' => '\'', '&quot;' => '"',);
    $g_tagName = null;

    $aiml_sql = "";
    $pattern_sql = "";
    $that_sql = "";
    $template_sql = "";
    $insert_sql = "";
    $file = "";
    $full_path = "";

    $cat_counter = 0;

    // $AIML_List = getAIML_List();

    $all_bots = getBotList();



    $errMsgClass = (!empty($msg)) ? "ShowError" : "HideError";
    // $errMsgStyle = $template->getSection($errMsgClass);
    $noLeftNav = '';
    $noTopNav = '';
    // $noRightNav = $template->getSection('NoRightNav');

    $headerTitle = 'Actions:';
    $pageTitle = 'Upload AIML';

    /**
     * Function parseAIML
     *
     * @param $fn
     * @param      $aimlContent
     * @param bool $from_zip
     * @return string
     */

    function parseAIML($fn, $aimlContent, $from_zip = false)
    {
        if (isset($_POST['action'])) {
            $bot_id = $_POST['bot_id'];
        }
        // echo "parse = ".$bot_id;

        global $msg, $debugmode, $bot_id, $charset, $bot_name, $idA;
        $duplicates = array();

        $post_vars = filter_input_array(INPUT_POST);

        if (empty($aimlContent)) {
            return "File $fn was empty!";
        }

        $skipVal = (isset($_POST['skipVal'])) ? true : false;
        //trigger_error(() ? "true" : 'false');
        $fileName = basename($fn);
        if (isset($bot_name)) {
            $fileName = str_replace("{$bot_name}.", '', $fileName);
        }
        $success = false;
        $topic = '';
        #Clear the database of the old entries

        $myBot_id = (isset($_POST['bot_id'])) ? $_POST['bot_id'] : $bot_id;

        if (isset($_POST['clearDB'])) {
            /** @noinspection SqlDialectInspection */
            $sql = "DELETE FROM `aiml`  WHERE `filename` = :filename AND bot_id = :bot_id";
            $params = array(':filename' => $fileName, ':bot_id' => $myBot_id);
            $affectedRows = db_write($sql, $params, false, __FILE__, __FUNCTION__, __LINE__);
        }

        # Read new file into the XML parser
        /** @noinspection SqlDialectInspection */
        $sql = 'INSERT INTO `aiml` (`id`, `bot_id`, `pattern`, `thatpattern`, `template`, `topic`, `filename`,`id_admin`) VALUES
    (NULL, :bot_id , :pattern, :that, :template, :topic, :fileName, :id_admin);';
        // echo "mybot id".$myBot_id."\n";

        # Validate the incoming document
        /*******************************************************/
        /*       Set up for validation from a common DTD       */
        /*       This will involve removing the XML and        */
        /*       AIML tags from the beginning of the file      */
        /*       and replacing them with our own tags          */
        /*******************************************************/
        $validAIMLHeader = '<?xml version="1.0" encoding="[charset]"?>
    <aiml version="1.0.1" xmlns="http://www.alicebot.org/TR/2001/WD-aiml">';
        $validAIMLHeader = str_replace('[charset]', $charset, $validAIMLHeader);
        $aimlTagStart = stripos($aimlContent, '<aiml', 0);
        $aimlTagEnd = strpos($aimlContent, '>', $aimlTagStart) + 1;
        $aimlFile = $validAIMLHeader . substr($aimlContent, $aimlTagEnd);
        //file_put_contents(_LOG_PATH_ . 'upload.aiml.txt', print_r($aimlFile, true));
        $tmpDir = _UPLOAD_PATH_ . 'tmp' . DIRECTORY_SEPARATOR;
        if (!file_exists($tmpDir)) mkdir($tmpDir, 0755);
        save_file(_UPLOAD_PATH_ . 'tmp/' . $fileName, $aimlFile);
        $status = '';


        try {
            libxml_clear_errors();
            libxml_use_internal_errors(true);
            $xml = new DOMDocument('1.0', 'utf-8');

            if (!$xml->loadXML(trim($aimlFile))) // $aimlContent
            {
                $msg = "File $fileName is <strong>NOT</strong> valid!<br />\n";
                // echo $msg;
                list($null, $status) = upload_libxml_display_errors($fileName);
                $msg .= "$status<br>\n<hr>\n";
                $msg = wordwrap($msg, 80, "<br>\n");
                $_SESSION['failCount']++;
            } elseif ($skipVal && $xml->schemaValidate(_ADMIN_PATH_ . 'aiml.xsd'))
            // validasi upload aiml
            {
                $msg = "<div class=\"center\"><b>A total of [count] error[plural] been found in the file $fileName.</b></div><br><br>\n";

                $xmlErrCount = 0;
                list($xmlErrCount, $status) = upload_libxml_display_errors($fileName);
                $plural = ($xmlErrCount !== 1) ? 's have' : ' has';
                $msg = str_replace('[count]', $xmlErrCount, $msg);
                $msg = str_replace('[plural]', $plural, $msg);
                $msg .= "$status\n<br>\n<hr>\n";
                $_SESSION['failCount']++;
            } else {
                $aiml = new SimpleXMLElement($xml->saveXML());
                $rowCount = 0;
                $params = array();

                if (!empty($aiml->topic)) {
                    foreach ($aiml->topic as $topicXML) {
                        # handle any topic tag(s) in the file
                        $topicAttributes = $topicXML->attributes();
                        $topic = $topicAttributes['name'];

                        foreach ($topicXML->category as $category) {
                            $fullCategory = $category->asXML();

                            $pattern = trim($category->pattern);
                            $pattern = str_replace("'", ' ', $pattern);
                            $pattern = _strtoupper($pattern);
                            $idAdmin = '2';

                            $that = $category->that;
                            $that = _strtoupper($that);

                            $template = $category->template->asXML();
                            $template = str_replace('<template>', '', $template);
                            $template = str_replace('</template>', '', $template);
                            $template = trim($template);
                            # Strip CRLF and LF from category (Windows/mac/*nix)
                            $aiml_add = str_replace(array("\r\n", "\n"), '', $fullCategory);
                            $duplicatesIndex = hash('sha1', "{$topic} {$aiml_add}"); // use a HASH for the duplicates array's indices to save memory
                            if (!in_array($duplicatesIndex, $duplicates)) {
                                // echo "cek bot id".$myBot_id;
                                $params[] = array(
                                    ':bot_id' => $myBot_id,
                                    ':pattern' => $pattern,
                                    ':that' => $that,
                                    ':template' => $template,
                                    ':topic' => $topic,
                                    ':fileName' => $fileName,
                                    ':id_admin' => $idA
                                );
                                $duplicates[] = $duplicatesIndex;
                            }
                        }
                    }
                }

                $topic = '';

                if (!empty($aiml->category)) {
                    foreach ($aiml->category as $category) {
                        $fullCategory = $category->asXML();

                        $pattern = trim($category->pattern);
                        $pattern = str_replace("'", ' ', $pattern);
                        $pattern = _strtoupper($pattern);
                        $idAdmin = '2';
                        $that = $category->that;
                        $template = $category->template->asXML();
                        //strip out the <template> tags, as they aren't needed
                        $template = substr($template, 10);
                        $tLen = strlen($template);
                        $template = substr($template, 0, $tLen - 11);
                        $template = trim($template);
                        # Strip CRLF and LF from category (Windows/mac/*nix)
                        $aiml_add = str_replace(array("\r\n", "\n"), '', $fullCategory);
                        $duplicatesIndex = hash('sha1', $aiml_add); // use a HASH for the duplicates array's indices to save memory
                        if (!in_array($duplicatesIndex, $duplicates)) {
                            $params[] = array(
                                ':bot_id' => $myBot_id,
                                ':pattern' => $pattern,
                                ':that' => $that,
                                ':template' => $template,
                                ':topic' => '',
                                ':fileName' => $fileName,
                                ':id_admin' => $idA
                            );
                            $duplicates[] = $duplicatesIndex;
                        }
                    }
                }

                if (!empty($params)) {
                    $rowCount = db_write($sql, $params, true, __FILE__, __FUNCTION__, __LINE__);
                    $success = ($rowCount !== false) ? true : false;
                }

                $msg = ($from_zip === true) ? '' : "Successfully added $fileName to the database.<br />\n";
            }
        } catch (Exception $e) {
            $trace = $e->getTraceAsString();
            //exit($e->getMessage() . ' at line ' . $e->getLine());
            $msg = $e->getMessage() . ' at line ' . $e->getLine() . "<br>\n";
            //trigger_error("Trace:\n$trace");
            error_log("Trace:\n$trace", 3, _LOG_PATH_ . "error.upload.$fileName.log");
            //file_put_contents(_LOG_PATH_ . 'error.trace.log', $trace . "\nEnd Trace\n\n", FILE_APPEND);
            $success = false;
            $_SESSION['failCount']++;
            $errMsg = "There was a problem adding file $fileName to the database. Please refer to the message below to correct the problem and try again.<br>\n" . $e->getMessage();
            list($null, $status) = upload_libxml_display_errors($fileName);
            $_SESSION['failCount']++;
            $msg .= $status;
        }
        return $msg;
    }

    /**
     * Function processUpload
     *
     * @return string
     */
    function processUpload()
    {
        if (isset($_POST['action'])) {
            $bot_id = $_POST['bot_id'];
        }
        global $msg, $ZIPenabled, $fs_limit, $bot_name;
        $fs_limit = 128000000;
        // Validate the uploaded file

        if ($_FILES['aimlfile']['size'] === 0 || empty($_FILES['aimlfile']['tmp_name'])) {
            $msg = 'No file was selected.';
        } elseif ($_FILES['aimlfile']['size'] > $fs_limit) {
            $msg = 'The file was too large.';
        } elseif ($_FILES['aimlfile']['error'] !== UPLOAD_ERR_OK) {
            // There was a PHP error
            $msg = 'There was an error uploading.';
        } else {
            // Move the file
            $file = _UPLOAD_PATH_ . $_FILES['aimlfile']['name'];

            if (move_uploaded_file($_FILES['aimlfile']['tmp_name'], $file)) {
                #file_put_contents(_LOG_PATH_ . 'upload.type.txt', 'Type = ' . $_FILES['aimlfile']['type']);
                if ($_FILES['aimlfile']['type'] == 'application/zip' or $_FILES['aimlfile']['type'] == 'application/x-zip-compressed') {
                    //check for ZipArchive class
                    if (!$ZIPenabled) {
                        $msg .= 'The PHP ZipArchive class is not available on this server, so Zip files cannot be uploaded. However, individual AIML files can be uploaded. We apologise for the inconvenience.';
                    } else {
                        return processZip($file);
                    }
                } else {
                    return parseAIML($file, file_get_contents($file));
                }
            } else {
                $msg = 'There was an error moving the file.';
            }
        }
        $_SESSION['errorMessage'] = $msg;

        return $msg;
    }

    /**
     * Function getAIML_List
     *
     * @return string
     */
    function getAIML_List()
    {
        global $bot_id;
        $out = "                  <!-- Start List of Currently Stored AIML files -->\n";
        /** @noinspection SqlDialectInspection */
        $sql = "SELECT DISTINCT filename FROM `aiml` WHERE `bot_id` = :bot_id ORDER BY `filename`;";
        $params = array(':bot_id' => $bot_id);
        $result = db_fetchAll($sql, $params, __FILE__, __FUNCTION__, __LINE__);

        foreach ($result as $row) {
            if (empty($row['filename'])) {
                $curOption = "                No Filename entry<br />\n";
            } else {
                $out .= $row['filename'] . "<br />\n";
            }
        }
        $out .= "                  <!-- End List of Currently Stored AIML files -->\n";

        return $out;
    }

    /**
     * Function getBotList
     *
     * @return string
     */
    function getBotList()
    {
        global $bot_id;

        $botOptions = '';

        /** @noinspection SqlDialectInspection */

        $sql = 'SELECT `bot_name`, `bot_id` FROM `bots` ORDER BY `bot_id`;';
        $result = db_fetchAll($sql, null, __FILE__, __FUNCTION__, __LINE__);
        // echo " get bottlis ok ".$bot_id;

        foreach ($result as $row) {
            $bn = $row['bot_name'];
            $bi = $row['bot_id'];
            $sel = ($bot_id == $bi) ? ' selected="selected"' : '';
            $botOptions .= "<option value= \"$bi\" > $bn</option>\n";
            // echo $sel;
        }

        return $botOptions;
    }

    /**
     * Function upload_libxml_display_errors
     *
     * @param $fileName
     * @return array
     */
    function upload_libxml_display_errors($fileName)
    {
        $out = '';
        $errors = libxml_get_errors();
        $xmlErrCount = count($errors);
        //file_put_contents(_LOG_PATH_ . "$fileName.$xmlErrCount.errors.txt", print_r($errors, true));

        foreach ($errors as $error) {
            $out .= upload_libxml_display_error($error);
        }
        libxml_clear_errors();

        return array($xmlErrCount, $out);
    }

    /**
     * Function upload_libxml_display_error
     *
     * @param $error
     * @return string
     */
    function upload_libxml_display_error($error)
    {
        $out = "\n";

        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $out .= "<b>Warning {$error->code}</b>: ";
                break;
            case LIBXML_ERR_ERROR:
                $out .= "<b>Error {$error->code}</b>: ";
                break;
            case LIBXML_ERR_FATAL:
                $out .= "<b>Fatal Error {$error->code}</b>: ";
                break;
        }

        $m = $error->message;
        $m = str_replace('{http://www.alicebot.org/TR/2001/WD-aiml}', '', $m);
        $m = preg_replace("/Element '(.*?)'/", 'Element \'&lt;$1>\'', $m);
        $m = wordwrap($m, 80, "<br>\n");
        $l = number_format($error->line);
        $out .= "$m on line $l.</strong><br>\n";

        return "$out\n";
    }

    /**
     * Function processZip
     *
     * @param $fileName
     * @return string
     */
    function processZip($fileName)
    {
        global $bot_name;
        $out = '';
        $_SESSION['failCount'] = 0;
        $zipName = basename($fileName);
        $zip = new ZipArchive;
        $res = $zip->open($fileName);

        if ($res === TRUE) {
            $numFiles = $zip->numFiles;

            for ($loop = 0; $loop < $numFiles; $loop++) {
                $curName = $zip->getNameIndex($loop);

                if (strstr($curName, '/') !== false) {
                    $endPos = strrpos($curName, '/') + 1;
                    $curName = substr($curName, $endPos);
                }

                if (empty($curName)) {
                    continue;
                }
                $fp = $zip->getStream($zip->getNameIndex($loop));

                if (!$fp) {
                    $out .= "Processing for $curName failed.<br />\n";
                    $bad_aiml_files = (!isset($bad_aiml_files)) ? array() : $bad_aiml_files;
                    $bad_aiml_files[] = $curName;
                    $_SESSION['bad_aiml_files'] = $curName;
                } else {
                    $curText = '';

                    while (!feof($fp)) {
                        $curText .= fread($fp, 8192);
                    }

                    fclose($fp);

                    if (!stristr($curName, '.aiml')) {
                        continue;
                    }
                    $out .= parseAIML($curName, $curText, true);
                }
            }

            $zip->close();
            $failCount = $_SESSION['failCount'];
            $out .= "<br />\nUpload complete. $numFiles files were processed, and $failCount files encountered errors.<br />\n";

            if (isset($_SESSION['bad_aiml_files'])) {
                $out .= "<br />\nThe following AIML files encountered errors:<br />\n";

                foreach ($_SESSION['bad_aiml_files'] as $fn) {
                    $out .= "$fn, ";
                }
                $out = rtrim($out, ', ') . "<br .>\nPlease test each of these files independently, to locate the errors within.";
                unset($_SESSION['bad_aiml_files']);
            }
        } else {
            $out = "Upload failed. $fileName was either corrupted, or not a zip file.";
        }

        return $out;
    }

    function validateAIML($xml)
    {
        file_put_contents(_LOG_PATH_ . 'upload.xml.txt', print_r($xml, true));
        global $validationStatus;
        $out = true;

        if (!$xml->schemaValidate(_ADMIN_PATH_ . 'aiml.xsd')) {
            get_errors();
            $out = false;
        }

        return $out;
    }

    /**
     * Function libxml_display_error
     *
     * @param $error
     * @return string
     */
    function libxml_display_error($error)
    {
        global $aimlArray;
        $errorLine = $error->line;
        $errorXML = htmlentities(@$aimlArray[$errorLine]);
        $return = "<hr>\n";

        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $return .= "<b>Warning {$error->code}</b>: ";
                break;
            case LIBXML_ERR_ERROR:
                $return .= "<b>Error {$error->code}</b>: ";
                break;
            case LIBXML_ERR_FATAL:
                $return .= "<b>Fatal Error {$error->code}</b>: ";
                break;
        }
        $return .= trim($error->message);

        if ($error->file) {
            $return .= " in <b>{$error->file}</b>";
        }
        $return .= " on line <a href=\"#line$errorLine\">$errorLine</a>, column {$error->column}\n";
        $return .= "<br>$errorXML\n";

        return $return;
    }

    function get_errors()
    {
        global $status;
        $errors = libxml_get_errors();
        $count = 0;

        foreach ($errors as $error) {
            $status .= libxml_display_error($error) . "<br />\n";
            $count++;
        }
        libxml_clear_errors();
        $plural = ($count > 1) ? 's have' : ' has';
        $status = str_replace('[count]', $count, $status);
        $status = str_replace('[plural]', $plural, $status);
    }

    $this->load->view("admin/_partials/navbar.php")


    ?>

                                <div id="wrapper">

                                    <!-- Sidebar -->
                                    <?php $this->load->view("admin/_partials/sidebar.php") ?>


                                    <div id="content-wrapper">

                                        <div class="container-fluid">

                                            <!-- Breadcrumbs-->
                                            <?php $this->load->view("admin/_partials/breadcrumb.php") ?>
                                            <?php if ($msg != null) : ?>
                                                <div class="alert alert-success" role="alert">
                                                    <?php echo $msg; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="card mb-3">
                                                <div class="card-body">

                                                    <form id="upload" enctype="multipart/form-data" action="" method="post">

                                                        <table class="formTable">
                                                            <tr>
                                                                <td>
                                                                    <label for="aimlfile">File:</label>
                                                                    <input type="file" id="aimlfile" name="aimlfile" />&nbsp; &nbsp;
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" id="clearDB" name="clearDB" checked="checked" />&nbsp; &nbsp;
                                                                    <label for="clearDB">Clear the database of entries from this file</label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <!-- <label for="bot_id">Apply this file to this bot: </label> -->
                                                                    <select hidden name="bot_id" id="bot_id" size="1">
                                                                        <?php echo $all_bots; ?>
                                                                    </select>&nbsp; &nbsp;
                                                                </td>
                                                                <!-- <td>
                                                                    <input type="checkbox" id="skipVal" name="skipVal" value="1"/>&nbsp; &nbsp;
                                                                     <label for="skipVal">Skip AIML Validation for this file</label>
                                                                       </td> -->
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <input type="submit" name="action" id="action" value="upload" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Icon Cards-->

                                            <!-- Sticky Footer -->
                                            <?php $this->load->view("admin/_partials/footer.php") ?>
                                        </div>

                                    </div>
                                    <!-- /.content-wrapper -->

                                    <!-- /#wrapper -->

                                    <!-- Scroll to Top Button-->
                                    <?php $this->load->view("admin/_partials/scrolltop.php") ?>


                                    <!-- Logout Modal-->
                                    <?php $this->load->view("admin/_partials/modal.php") ?>

                                    <!-- Javascript -->
                                    <?php $this->load->view("admin/_partials/js.php") ?>



</body>

</html>