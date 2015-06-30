<?php
/**
 * @author i@xtiv.net
 * @name Shipping
 * @desc Offer shipping rates on your site.
 * @version v0.0.1
 * @icon truck
 * @mini truck
 * @link shipments
 * @see market
 * @release beta
 * @alpha true
 * @todo
 */
class xShipping extends Xengine {
	function customindex($urlparam1, $urlparam2, $etc){
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