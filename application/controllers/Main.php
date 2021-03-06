<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->data['pagebody']='Homepage';
		$this->data['pagetitle']='Homepage';
		$this->data['PlayerInfo']=$this->PlayerModel->getAllPlayers();

		$this->data['stockInfoArray']=$this->getStockArray();
		$this->getGameStateData();




		$this->data['currentStocks']=$this->StockModel->getCurrentStocks();

//		print_r($this->StockModel->getCurrentStocks());

		$this->data['recentMovement']=$this->StockModel->getRecentStockMovements();
		$this->data['recentTransactions']=$this->StockModel->getRecentStockTransactions();

		$this->render();	
	}

	public function getStockArray(){
		//get the total number of queries
		$numQueries = $this->StockModel->getTotalStockNum();

		//divide the total number by 4 to get the number of rows
		$numRows = (int)($numQueries / 4);

		if($numQueries % 4 > 0){
			$numRows++;
		}

		//initialize the array to store all the data
		$rowData = [];

		//for loop that goes through and calls getStockInfoRange for each row
		//eg: getStockInfoRange(4,0); getStockInfoRange(4,4); getStockInfoRange(4,8);
		for ($x = 0; $x < $numRows; $x++){
			//put query result into the array
			$rowData[$x] = $this->StockModel->getStockInfoRange(4, $x*4);
		}

		return $rowData;
	}

	public function getGameStateData(){
		$gameData = $this->GameModel->getGameData();
		$this->data['round'] = $gameData["round"];
		$this->data['state'] = $gameData["state"];
		$this->data['countdown'] = $gameData["countdown"];
		$this->data['desc'] = $gameData["desc"];
	}

	public function buyStocks($stockName){
		//echo $stockName;
		$url = DATAPATH . 'buy/';
		$data = array('team' => 'o01',
					'token' => '6d22afe5483048ec4ea99fb6738cec6e',
					'player' => 'Donald',
					'stock' => $stockName,
					'quantity' => '1' );

		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($data)
		    )
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) { /* Handle error */ }

		var_dump($result);

/*

	public function register(){
		$url = 'http://bsx.jlparry.com/register';
		$data = array('team' => 'o01',
					'name' => 'commies',
					'password' => 'tuesday'
					 );

		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($data)
		    )
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) { /* Handle error  }

		var_dump($result);
	}
	*/
	}

	public function sellStocks($stockName){

		
		$url = DATAPATH . 'sell/';
		$data = array('team' => 'o01',
					'token' => '6d22afe5483048ec4ea99fb6738cec6e',
					'player' => 'Donald',
					'stock' => $stockName,
					'quantity' => '1',
					'certificate' => '3ccea' );

		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($data)
		    )
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) { /* Handle error*/ }

		var_dump($result);
	
	}
}