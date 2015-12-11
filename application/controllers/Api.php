<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'libraries/REST_Controller.php';
class Api extends REST_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
    }

    private function get_site_data($site_url, $max_depth = 1, $current_depth = 0){

		$current_depth++;

		$this->load->library('crawler');

	    $site_data = array();

	    if($this->crawler->set_url($site_url) !== false){
	        $site_data['title'] = $this->crawler->get_title();
	        $site_data['description'] = $this->crawler->get_description();
	        $site_data['keywords'] = $this->crawler->get_keywords();
	        $site_data['text'] = $this->crawler->get_text();
	        $site_data['links'] = $this->crawler->get_links();

	        if($current_depth <= $max_depth){
	            foreach($site_data['links'] as $link_key => &$link){
	                $link['data'] = get_site_data($link, $max_depth, $current_depth);
	            }
	        }

	        return $site_data;
	    }
	    else{
	        
	        return false;
	    }
	}

	public function vehicleYears_get()
	{
		$years = range(date('Y')+1, 1985);

		if($years)
		{
			$this->response($years, 200); // 200 being the HTTP response code
		} else {
			$this->response([], 404);
		}

	}
	
    public function vehicleMakes_get()
    {

    	$useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
		$header[0] = "Accept=text/html,application/xhtml+xml,application/xml;q=0.9,​*/*​;q=0.8";
		$header[1] = "Accept-Charset=Big5,utf-8;q=0.7,*;q=0.7";
		$header[2] = "Connection: Keep-Alive";
		$header[3] = "Accept-Language: zh-tw";
		$header[4] = "Cache-Control: no-cache";
		$header[5] = "Content-Type: text/xml";

    	//$url = "http://www.discounttire.com/dtcs/dwr/call/plaincall/VehicleInfoDWR.vehicleMakes.dwr";
  //   	$c = curl_init();
  //   	$ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; MASP; rv:11.0) like Gecko';
		// $ch = curl_init();
		// curl_setopt($ch,CURLOPT_URL, $url);

		// curl_setopt($ch, CURLOPT_HEADER, true);

		// curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		// curl_setopt($ch, CURLOPT_USERAGENT, $ua);
		// curl_setopt($ch, CURLOPT_COOKIE, 'Lock_Desktop=true; DESKTOP.TIRERACK.COM-172.16.1.43-COOKIE=R3789646676; JSESSIONID=CAC015007A0BD558D838BDF22BD8B603');

		// curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
		// // curl_setopt($ch,CURLOPT_POST, true);
		// // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		// $result = curl_exec($ch);
		// $last = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		// curl_close($ch);
		// echo $result;

		// $response = '{}';
		// use GuzzleHttp\Client;
		// $client = new Client([
		// 	'base_uri' => 'http://ctcjs.carpronetwork.com/',
		// 	'timeout' => 2.0
		// ]);

		$client = new GuzzleHttp\Client();
    	$cookieJar = new GuzzleHttp\Cookie\CookieJar(true);

		if(! $this->get('Year'))
		{
			$vehicleMakes = array();

		} else {

			$url = "http://ctcjs.carpronetwork.com/tools.asmx/getMakes?Year=" . $this->get('Year') . "&Make=%22%22&isVehicleCrossOver=false&Username=%22ctc%22&Password=%22w3bs3rvic3s%22&format=json";

	    	$response = $client->request('GET', $url, [
			    'headers' => [
			        'User-Agent' => $useragent,
			    ],
			    'Cookies' => $cookieJar,
			    'connect_timeout' => 2,
			    //'debug' => true
			]);

			$bodyString = (string)$response->getBody();
			$bodyString = substr($bodyString, 1, -2);
			$obj = json_decode($bodyString);
			$vehicleMakes = $obj->{'d'};

		}

    	try
    	{

	    	if($vehicleMakes)
			{
				$this->response($vehicleMakes, 200); // 200 being the HTTP response code
			} else {
				$this->response([], 404);
			}

    	} catch (Exception $e) {
    		echo "AGH!" . $e->getMessage();
    	}

    	
    }

    public function vehicleModels_get()
    {

    	$useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
		$header[0] = "Accept=text/html,application/xhtml+xml,application/xml;q=0.9,​*/*​;q=0.8";
		$header[1] = "Accept-Charset=Big5,utf-8;q=0.7,*;q=0.7";
		$header[2] = "Connection: Keep-Alive";
		$header[3] = "Accept-Language: zh-tw";
		$header[4] = "Cache-Control: no-cache";
		$header[5] = "Content-Type: text/xml";

		$client = new GuzzleHttp\Client();
    	$cookieJar = new GuzzleHttp\Cookie\CookieJar(true);

		if(! $this->get('Year'))
		{
			$vehicleModels = array();

		} else {

			$url = "http://ctcjs.carpronetwork.com/tools.asmx/getModels?Year=" . $this->get('Year') . "&Make=%22" . $this->get('Make') . "%22&Model=%22%22&isVehicleCrossOver=false&Username=%22ctc%22&Password=%22w3bs3rvic3s%22&format=json";

	    	$response = $client->request('GET', $url, [
			    'headers' => [
			        'User-Agent' => $useragent,
			    ],
			    'Cookies' => $cookieJar,
			    'connect_timeout' => 2,
			    //'debug' => true
			]);

			$bodyString = (string)$response->getBody();
			$bodyString = substr($bodyString, 1, -2);
			$obj = json_decode($bodyString);
			$vehicleModels = $obj->{'d'};

		}

    	try
    	{

	    	if($vehicleModels)
			{
				$this->response($vehicleModels, 200); // 200 being the HTTP response code
			} else {
				$this->response([], 404);
			}

    	} catch (Exception $e) {
    		echo "AGH!" . $e->getMessage();
    	}

    	
    }

    public function vehicleBodies_get()
    {

    	$useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
		$header[0] = "Accept=text/html,application/xhtml+xml,application/xml;q=0.9,​*/*​;q=0.8";
		$header[1] = "Accept-Charset=Big5,utf-8;q=0.7,*;q=0.7";
		$header[2] = "Connection: Keep-Alive";
		$header[3] = "Accept-Language: zh-tw";
		$header[4] = "Cache-Control: no-cache";
		$header[5] = "Content-Type: text/xml";

		$client = new GuzzleHttp\Client();
    	$cookieJar = new GuzzleHttp\Cookie\CookieJar(true);

		if(! $this->get('Year'))
		{
			$vehicleBodies = array();

		} else {

			$url = "http://ctcjs.carpronetwork.com/tools.asmx/getChassis?Year=" . $this->get('Year') . "&Make=%22" . $this->get('Make') . "%22&Model=%22". $this->get('Model') ."%22&Username=%22ctc%22&Password=%22w3bs3rvic3s%22&format=json";

	    	$response = $client->request('GET', $url, [
			    'headers' => [
			        'User-Agent' => $useragent,
			    ],
			    'Cookies' => $cookieJar,
			    'connect_timeout' => 2,
			    //'debug' => true
			]);

			$bodyString = (string)$response->getBody();
			$bodyString = substr($bodyString, 1, -2);
			$obj = json_decode($bodyString);
			$vehicleBodies = $obj->{'d'};

		}

    	try
    	{

	    	if($vehicleBodies)
			{
				$this->response($vehicleBodies, 200); // 200 being the HTTP response code
			} else {
				$this->response([], 404);
			}

    	} catch (Exception $e) {
    		echo "AGH!" . $e->getMessage();
    	}

    	
    }


    public function vehicleOptions_get()
    {

    	$useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
		$header[0] = "Accept=text/html,application/xhtml+xml,application/xml;q=0.9,​*/*​;q=0.8";
		$header[1] = "Accept-Charset=Big5,utf-8;q=0.7,*;q=0.7";
		$header[2] = "Connection: Keep-Alive";
		$header[3] = "Accept-Language: zh-tw";
		$header[4] = "Cache-Control: no-cache";
		$header[5] = "Content-Type: text/xml";

		$client = new GuzzleHttp\Client();
    	$cookieJar = new GuzzleHttp\Cookie\CookieJar(true);

		if(! $this->get('Year'))
		{
			$vehicleOptions = array();

		} else {

			$url = "http://ctcjs.carpronetwork.com/tools.asmx/getOptions?Year=" . $this->get('Year') . "&Make=%22" . $this->get('Make') . "%22&Model=%22". $this->get('Model') ."%22&Chassis=%22" . $this->get('Body') . "%22&Username=%22ctc%22&Password=%22w3bs3rvic3s%22&format=json";

	    	$response = $client->request('GET', $url, [
			    'headers' => [
			        'User-Agent' => $useragent,
			    ],
			    'Cookies' => $cookieJar,
			    'connect_timeout' => 2,
			    //'debug' => true
			]);

			$bodyString = (string)$response->getBody();
			$bodyString = substr($bodyString, 1, -2);
			$obj = json_decode($bodyString);
			$vehicleOptions = $obj->{'d'};

		}

    	try
    	{

	    	if($vehicleOptions)
			{
				$this->response($vehicleOptions, 200); // 200 being the HTTP response code
			} else {
				$this->response([], 404);
			}

    	} catch (Exception $e) {
    		echo "AGH!" . $e->getMessage();
    	}

    	
    }

    public function vehicleTires_get()
    {

    	$useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
		$header[0] = "Accept=text/html,application/xhtml+xml,application/xml;q=0.9,​*/*​;q=0.8";
		$header[1] = "Accept-Charset=Big5,utf-8;q=0.7,*;q=0.7";
		$header[2] = "Connection: Keep-Alive";
		$header[3] = "Accept-Language: zh-tw";
		$header[4] = "Cache-Control: no-cache";
		$header[5] = "Content-Type: text/xml";

		$client = new GuzzleHttp\Client();
    	$cookieJar = new GuzzleHttp\Cookie\CookieJar(true);

		if(! $this->get('Year'))
		{
			$vehicleTires = array();

		} else {

			$url = "http://tires.canadiantire.ca/view/CtTiresSelectionResponseController?selVehicleYear=" . $this->get('Year') . "&selVehicleMake=" . $this->get('Make') . "&selVehicleModel=". $this->get('Model') ."&selVehicleBody=" . $this->get('Body') . "&selVehicleOption=" . $this->get('Option');

	    	$response = $client->request('GET', $url, [
			    'headers' => [
			        'User-Agent' => $useragent,
			    ],
			    'Cookies' => $cookieJar,
			    'connect_timeout' => 2,
			    //'debug' => true
			]);

			$bodyString = (string)$response->getBody();
			// $bodyString = substr($bodyString, 1, -2);
			// $obj = json_decode($bodyString);
			// $vehicleTires = $obj->{'d'};
			$doc = new DOMDocument();
			$previous_value = libxml_use_internal_errors(TRUE);
			$doc->loadHTML($bodyString);
			$savedVehicle = $doc->getElementById('savedVehicle')->getAttribute('value');
			$tireSize = $doc->getElementById('radSize1')->getAttribute('value');
			//echo $bodyString;
			//$vehicleId = $doc->getElementById('byVehicleStep2')->getElementsByTagName('id')->item(0)->getAttribute('value');
			$formStep2Inputs = $doc->getElementById('byVehicleStep2')->getElementsByTagName('input');
			foreach($formStep2Inputs as $node){
			    if ( $node->getAttribute('name') == 'id')
			    {
			    	$vehicleId = $node->getAttribute('value');
			    	//print $node->getAttribute('name') . "\n";
			    } 
			    else
			    {
			    	//print $node->getAttribute('name') . "\n";
			    }
			}

			$queryUrl = "http://tires.canadiantire.ca/en/tires/search/?vehicle=" . rawurlencode($savedVehicle) . "_" . rawurlencode($tireSize) . "&id=" . $vehicleId . "&runFlatAvailable=false"; 

			$response = $client->request('GET', $queryUrl, [
			    'headers' => [
			        'User-Agent' => $useragent,
			    ],
			    'Cookies' => $cookieJar,
			    'connect_timeout' => 2,
			    //'debug' => true
			]);

			$bodyString = (string)$response->getBody();

			$doc2 = new DOMDocument();

			$doc2->loadHTML($bodyString);

			//$productList = $doc2->getElementById('productList')->getElementSByClassName('productDetails');

			$finder = new DomXPath($doc2);

			$classname="productDetails";

			$nodes = $finder->query("//*[contains(@class, '$classname')]");

			$productList = array();

			foreach($nodes as $node)
			{
				//echo $node->nodeValue . "\n";
				$brand = trim($node->getElementsByTagName('a')->item(0)->nodeValue);
				$descriptionNodes = $node->getElementsByTagName('ul')->item(1)->getElementsByTagName('li');
				$description = "";
				foreach($descriptionNodes as $descriptionNode)
				{
					$description = $description . trim($descriptionNode->nodeValue) . "\n";
				}

				$priceNode = $finder->query("following-sibling::*[1]", $node)->item(0);

				$price = trim($priceNode->getElementsByTagName('strong')->item(0)->nodeValue) . "." . trim($priceNode->getElementsByTagName('sup')->item(0)->nodeValue);

				array_push($productList, array('brandModel' => $brand, 'description' => $description, 'price' => $price));

			}

			

			//echo $bodyString;
			//brand, model, description, and price

			libxml_clear_errors();
			libxml_use_internal_errors($previous_value);

		}

    	try
    	{

	    	if($productList)
			{
				$this->response($productList, 200); // 200 being the HTTP response code
			} else {
				$this->response([], 404);
			}

    	} catch (Exception $e) {
    		echo "AGH!" . $e->getMessage();
    	}

    	
    }

	// get all tasks if no parameter supplied
	public function tasks_get()
	{
		if(! $this->get('id'))
		{
			// get all record
			//$tasks = $this->task_model->get_all();
			$tasks = "{}";
		} else {
			// get a record based on ID
			$tasks = $this->task_model->get_task($this->get('id'));
		}
		
		if($tasks)
		{
			$this->response($tasks, 200); // 200 being the HTTP response code
		} else {
			$this->response([], 404);
		}
	}
	
	public function tasks_post()
	{
		if(! $this->post('title'))
		{
			$this->response(array('error' => 'Missing post data: title'), 400);
		}
		else{
			$data = array(
				'title' => $this->post('title')
			);
		}
		$this->db->insert('task',$data);
		if($this->db->insert_id() > 0)
		{
			$message = array('id' => $this->db->insert_id(), 'title' => $this->post('title'));
			$this->response($message, 200); // 200 being the HTTP response code
		}
	}
	
	public function tasks_delete($id=NULL)
	{
		if($id == NULL)
		{
			$message = array('error' => 'Missing delete data: id');
			$this->response($message, 400);
		} else {
			$this->task_model->delete_task($id);
			$message = array('id' => $id, 'message' => 'DELETED!');
			$this->response($message, 200); // 200 being the HTTP response code
		}
	}
	
	public function tasks_put()
	{
		//perform validation
		if(! $this->put('title'))
		{
			$this->response(array('error' => 'Task title is required'), 400);
		}
		
		$data = array(
			'title'		=> $this->put('title'),
			'status'	=> $this->put('status')
		);
		$this->task_model->update_task($this->put('id'), $data);
		$message = array('success' => $this->put('title').' Updated!');
		$this->response($message, 200);
	}
}