<?php
/**
 * @author i@xtiv.net
 * @name Parcel Service(s)
 * @desc Offer shipping rates on your site.
 * @version v0.0.1
 * @icon truck
 * @mini truck
 * @link shipping
 * @see market
 * @release beta
 * @alpha true
 * @todo
 */
class xShipping extends Xengine {
	protected function settings()
	{
		// We Don't need to update the core. But a Requisite does come required. 
		$r = $this->xSettings($flip);
		// Manipulate data if necessary. 
		return $r;
	}

	function calculator()
	{
		/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
		/* You must fill in the "Service Logins
		/* values below for the example to work	
		/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/

		/*********** Shipping Services ************/
		/* Here's an array of all the standard
		/* shipping rates. You'll probably want to
		/* comment out the ones you don't want 
		/******************************************/
		// UPS
		$services['ups']['14'] = 'Next Day Air Early AM';
		$services['ups']['01'] = 'Next Day Air';
		$services['ups']['65'] = 'Saver';
		$services['ups']['59'] = '2nd Day Air Early AM';
		$services['ups']['02'] = '2nd Day Air';
		$services['ups']['12'] = '3 Day Select';
		$services['ups']['03'] = 'Ground';
		$services['ups']['11'] = 'Standard';
		$services['ups']['07'] = 'Worldwide Express';
		$services['ups']['54'] = 'Worldwide Express Plus';
		$services['ups']['08'] = 'Worldwide Expedited';
		// USPS
		$services['usps']['3'] = 'Priority Express';
		$services['usps']['1'] = 'Priority';
		$services['usps']['4'] = 'Standard Post';
		$services['usps']['6 '] = 'Media';
		$services['usps']['7'] = 'Library';
		// FedEx
		$services['fedex']['PRIORITYOVERNIGHT'] = 'Priority Overnight';
		$services['fedex']['STANDARDOVERNIGHT'] = 'Standard Overnight';
		$services['fedex']['FIRSTOVERNIGHT'] = 'First Overnight';
		$services['fedex']['FEDEX2DAY'] = '2 Day';
		$services['fedex']['FEDEXEXPRESSSAVER'] = 'Express Saver';
		$services['fedex']['FEDEXGROUND'] = 'Ground';
		$services['fedex']['FEDEX1DAYFREIGHT'] = 'Overnight Day Freight';
		$services['fedex']['FEDEX2DAYFREIGHT'] = '2 Day Freight';
		$services['fedex']['FEDEX3DAYFREIGHT'] = '3 Day Freight';
		$services['fedex']['GROUNDHOMEDELIVERY'] = 'Home Delivery';
		$services['fedex']['INTERNATIONALECONOMY'] = 'International Economy';
		$services['fedex']['INTERNATIONALFIRST'] = 'International First';
		$services['fedex']['INTERNATIONALPRIORITY'] = 'International Priority';

		// Config
		$config = array(
			//'debug' => 'true',
			// Services
			'services'      => $services,
			// Weight
			'weight'        => 30, // Default = 1
			'weight_units'  => 'lb', // lb (default), oz, gram, kg
			// Size
			'size_length'   => 8, // Default = 8
			'size_width'    => 5, // Default = 4
			'size_height'   => 1, // Default = 2
			'size_units'    => 'in', // in (default), feet, cm
			// From
			'from_zip'      => 85751, 
			'from_state'    => "AZ", // Only Required for FedEx
			'from_country'  => "US",
			// To
			'to_zip'        => 70506,
			'to_state'      => "LA", // Only Required for FedEx
			'to_country'    => "US",
			
			// Service Logins
			'ups_access'    => '0BF1DE9D25D3B02A', // UPS Access License Key
			'ups_user'      => '0e6-774', // UPS Username  
			'ups_pass'      => 'upsanon', // UPS Password  
			'ups_account'   => '0e6774', // UPS Account Number
			'usps_user'     => '235CKDKI5791', // USPS User Name
			'usps_password' => 'upsanon', // USPS User Name
			'fedex_account' => '510087283', // FedEX Account Number
			'fedex_meter'   => '118647891' // FedEx Meter Number 
		);

		// Shipping Calculator Class
		require_once "ShippingCalculator.php";
		// Create Class (with config array)
		$ship = new ShippingCalculator($config);
		// Get Rates
		$rates = $ship->calculate();

		// Print Array of Rates
		// print "
		// Rates for sending a ".$config[weight]." ".$config[weight_units].", ".$config[size_length]." x ".$config[size_width]." x ".$config[size_height]." ".$config[size_units]." package from ".$config[from_zip]." to ".$config[to_zip].":
		// <xmp>";
		// print_r($rates);
		// print "</xmp>";

		$r = array(
			// 'data' => null,		
			'success' => true,
			'data'	  => array(
				'rates'  => $rates,
				'config' => $config
			),
			//'method'  => 'login' 
		);
		
		return $r;

		/******* Setting Options After Class Creation ********
		If you would rather not set all the config options 
		when you first create an instance of the class you can
		set them like this:

		$ship = new ShippingCalculator ();
		$ship->set_value('from_zip','12345');

		..where the first variable is the name of the value 
		and the second variable is the value
		/*****************************************************/


		/***************** Single Rate ***********************
		If you only want to get one rate you can pass the 
		company and service code via the 'calculate' method

		$ship = new ShippingCalculator ($config);
		$rates = $ship->calculate('usps','FIRST CLASS')

		..this would return a rates array like 
		$rates =>
			'usps' =>
				'FIRST CLASS' = rate;
		/*****************************************************/



		/***************** Printing Rates *********************
		.. and finally, if you wanted to loop through the 
		returned rates and print radio buttons so your user 
		could select a shipping method you can do something 
		like this:

		foreach($rates as $company => $codes) {
			foreach($codes as $code => $rate) print "
		<input type='checkbox' name='shipping' value='".$rate."' /> ".$services[$company][$code]."<br />";
		}

		which will print the radio buttons, each having the 
		value of the respective shipping code which displaying
		the more user friendly name of the shipping method.
		/*****************************************************/
	}

	function index($urlparam1, $urlparam2, $etc){
		// Also available through $this->Q;		
		$q = $this->q();

		// Example of Hard-Coded Admin or User Only privledges.
		$k = $this->Key['is']; 	
		if( true === $k['admin'] || true === $k['user'] ){
			$table = (true !== $k['admin']) ? 'users' : 'admins';
			$r = array(
			'data' 	=> $q->Select('portal', $table ,array(
				'id' => $_SESSION['user']['id']
			)),		
			'success' => (!$q->error) ? true : false,
			'error'	  => (!$q->error) ? null : $this->Q->error
			); 

			

		} else {		
			$r = array(
				// 'data' => null,		
				'success' => false,
				'error'	  => 'Not Logged In',
				'action'  => 'login',
				//'method'  => 'login' 
			);
		}
		
		return $r;
	}
}
?>