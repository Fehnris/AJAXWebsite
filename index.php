<?php

session_start();

// Require https
if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}

//PHP library and PHP global settings files to include
include './Settings/Settings.php';
include './Components/AM/Server/AJAXManagerServer.php';

//Database Authentication and database selection variables
$DB_HOST = $mysqlDataBaseDetails['DB_HOST'];
$DB_USER = $mysqlDataBaseDetails['DB_USER'];
$DB_PASSWORD = $mysqlDataBaseDetails['DB_PASS'];
$DB_NAME = $mysqlDataBaseDetails['DB_NAME'];

$authObj = new AJAXManagerServer($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, "PHPScriptAuth", $_SERVER['PHP_SELF']);

?>
<html>
	<head>
		<script type="text/javascript" src="./Components/AM/Client/AJAXManagerClient.js"></script>
		<script type="text/javascript" src="./Components/AWC/InteractiveTextBox.js"></script>
		<script type="text/javascript" src="./Components/AWC/InteractiveSearchButton.js"></script>
		<script type="text/javascript" src="./Components/AWC/InteractiveLink.js"></script>
		<script>
			//Array containing choices that will show in the text field dropdown.  Relevant choices will show dependant on what is typed.
			var choicesArray = ["alpha", "beta", "bravo", "car", "carrot", "cannon"];
			
			//declaring a new InteractiveTextBox that is linked to the HTML input text field 'textFieldID'.
			//This example is working in ARRAY mode where the text field's autocomplete is populated from a local Array.
			var newTB = new InteractiveTextBox("textFieldID", "textFieldACID", { 'dataArray' : choicesArray, 'searchDelay' : 0 });
		</script>
	</head>
	<body>
		<script>
			AJAX = new AJAXManagerClient();
			AJAX.Authorise("./Components/AM/Client/AJAXInitialisation.php", <?php echo $authObj->Initialise(); ?>);

			var optTB = { 'dataSource' : "AJAX", 'AMCREF' : AJAX, 'AMCAPI' : AJAX.addToQueue, 'searchDelay' : 350 };
			var optSBL = { 'dataSource' : "AJAX", 'AMCREF' : AJAX, 'AMCAPI' : AJAX.addToQueue, 'DATAFORMATREF' : this, 'DATAFORMATAPI' : showResultsPanel,'searchDelay' : 150 };

			var dealerNameTB = new InteractiveTextBox("dealerSearchDealerNameID", "dealerSearchDealerNameAutoCompleteID", mrgObj(optTB,
						{ 'defaultValue' : "Dealer Name", 'AJAXURL' : "../PHP_Fetch/fetchDealerNames.php" }));

			var dealerNameSB = new InteractiveSearchButton("dealerSearchDealerNameButtonID", mrgObj(optSBL,
						{ 'associatedTextFieldID' : "dealerSearchDealerNameID", 'AJAXURL' : "../PHP_Fetch/fetchDealersByName.php" }));
		</script>
	
	</body>
</html>