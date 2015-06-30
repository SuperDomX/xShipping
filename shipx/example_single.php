<?php
/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
/* You must fill in the "Service Logins
/* values below for the example to work	
/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/

// Config
$config = array(
	// Weight
	'weight' => 2, // Default = 1
	'weight_units' => 'lb', // lb (default), oz, gram, kg
	// Size
	'size_length' => 5, // Default = 8
	'size_width' => 6, // Default = 4
	'size_height' => 3, // Default = 2
	'size_units' => 'in', // in (default), feet, cm
	// From
	'from_zip' => 97210, 
	'from_state' => "OR", // Only Required for FedEx
	'from_country' => "US",
	// To
	'to_zip' => 55455,
	'to_state' => "MN", // Only Required for FedEx
	'to_country' => "US",
	
	// Service Logins
	'ups_access' => '0C2D05F55AF310D0', // UPS Access License Key
	'ups_user' => 'dwstudios', // UPS Username  
	'ups_pass' => 'dwstudios', // UPS Password  
	'ups_account' => '81476R', // UPS Account Number
	'usps_user' => '229DARKW7858', // USPS User Name
	'fedex_account' => '510087020', // FedEX Account Number
	'fedex_meter' => '100005263' // FedEx Meter Number 
);

// Shipping Calculator Class
require_once "ShippingCalculator.php";
// Create Class (with config array)
$ship = new ShippingCalculator($config);
// Get Rate
$rates = $ship->calculate('ups','03'); // UPS Ground Shipping

// Print Array of Rates
print "
UPS Ground shipping rate for a ".$config[weight]." ".$config[weight_units].", ".$config[size_length]." x ".$config[size_width]." x ".$config[size_height]." ".$config[size_units]." package from ".$config[from_zip]." to ".$config[to_zip].":
<xmp>";
print_r($rates);
print "</xmp>";
?>