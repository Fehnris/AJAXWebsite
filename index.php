<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Require https
if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}

//PHP library and PHP global settings files to include
include '../Settings/Settings.php';
include './AM/Server/AJAXManagerServer.php';

//Database Authentication and database selection variables
$DB_HOST = $mysqlDataBaseDetails['DB_HOST'];
$DB_USER = $mysqlDataBaseDetails['DB_USER'];
$DB_PASSWORD = $mysqlDataBaseDetails['DB_PASS'];
$DB_NAME = $mysqlDataBaseDetails['DB_NAME'];

$authObj = new AJAXManagerServer($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, "PHPScriptAuth", $_SERVER['PHP_SELF']);

?>
<html>
	<head>
		<title>AJAX components examples</title>
		<link href="./CSS/wheretobuy.css" rel="stylesheet" type="text/css" />
		<link href="./CSS/customRadioButton.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="./AM/Client/AJAXManagerClient.js"></script>
		<script type="text/javascript" src="./AWC/InteractiveTextBox.js"></script>
		<script type="text/javascript" src="./AWC/InteractiveSearchButton.js"></script>
		<script type="text/javascript" src="./AWC/InteractiveLink.js"></script>
		<script>
		
			function mrgObj(obj1, obj2) {
				for (var attrname in obj2) { obj1[attrname] = obj2[attrname]; }
				return obj1;
			}
		
			//Defining function to run when the page has loaded for interactive javascript of text box
			document.addEventListener("DOMContentLoaded", () => {
				// Runs as soon as the HTML structure is ready
				
				AJAX = new AJAXManagerClient();
				AJAX.Authorise("./AM/Client/AJAXInitialisation.php", <?php echo $authObj->Initialise(); ?>);

				var optTB = { 'dataSource' : "AJAX", 'AMCREF' : AJAX, 'AMCAPI' : AJAX.addToQueue, 'searchDelay' : 350 };
				
				var dealerNameTB = new InteractiveTextBox("dealerSearchDealerNameID", "dealerSearchDealerNameAutoCompleteID", mrgObj(optTB,
						{ 'defaultValue' : "Enter Value", 'AJAXURL' : "./APIs/fetchDealerNames.php" }));

				
			});
		
		</script>
	</head>
	<body>
		<div id='UKDealerNameComponent' class='searchComponentUK'>
          <div class='searchElement'>
              <h1 class='formHeadingH3'>Find a Dealer by Name</h1>
              <div class='searchElementColumn'>
                <div class='searchFieldRelativeContainer'>
                  <input type='text' name='dealerSearchDealerNameID' id='dealerSearchDealerNameID'
			   class='searchField' value='Dealer Name' autocomplete='off'/>
                  </div>
                <div class='searchFieldRelativeContainer'>
                  <div class='searchFieldAbsoluteContainer'>
                    <div id='dealerSearchDealerNameAutoCompleteID'></div>
                    </div>
                  </div>
                </div>
              <div class='searchElementColumn'>
                <input type='button' name='dealerSearchName' id='dealerSearchDealerNameButtonID' class='searchButton' value='search' />
                </div>
              <div class='clearFloat'></div>
              </div>
            </div>
		
	
	</body>
</html>