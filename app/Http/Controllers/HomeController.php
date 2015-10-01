<?php namespace App\Http\Controllers;
use Auth;
class HomeController extends Controller {

	public $api_token = null;
	public $api_url = null;

	public function __construct()
	{
		$this->middleware('auth');

		$this->api_token = config('constants.api_token');
		$this->api_url = config('constants.api_url');
	}

	//cURL
	function curl($url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$data = curl_exec($ch);

		curl_close($ch);

		return json_decode($data, true);
	}

	//Get Pipelines
	public function getPipelines()
	{
		$url_pipelines = $this->api_url."/pipelines?api_token=".$this->api_token;
		$pipelinesWithData = $this->curl($url_pipelines);
		$pipelines = $pipelinesWithData['data'];
		return $pipelines;
	}

	//Get Selected Pipeline
	public function getSelectedPipeline($pipelines)
	{
		foreach($pipelines as $item){
			if($item['selected'] == 'true'){
				$selectedPipeline = $item;
				break;
			}
		}
		return $selectedPipeline;
	}

	//Get Stages
	public function getStages($selectedPipeline)
	{
		$url_stage = $this->api_url."/stages?pipeline_id=".$selectedPipeline['id']."&api_token=".$this->api_token;
		$stagesWithData = $this->curl($url_stage);
		$stages = $stagesWithData['data'];
		return $stages;
	}

	//Get Deals
	public function getDeals($selectedPipeline)
	{
		$url_deals = $this->api_url."/pipelines/".$selectedPipeline['id']."/deals?everyone=0&start=0&api_token=".$this->api_token;
		$dealsWithData = $this->curl($url_deals);
		$deals = $dealsWithData['data'];
		return $deals;
	}

	//Get Users
	public function getUsers()
	{
		$url_users = $this->api_url."/users?&api_token=".$this->api_token;
		$usersWithData = $this->curl($url_users);
		$users = $usersWithData['data'];
		return $users;
	}

	//Get User Deals
	public function getUserDeals($id, $deals)
	{
		$userDeals = array();

		foreach($deals as $deal)
		{
			if($deal['user_id'] == $id)
			{
				$userDeals[] = $deal;
			}
		}

		return $userDeals;
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Dashboard
	 */
	public function index()
	{
		$pipelines = $this->getPipelines();

		$selectedPipeline = $this->getSelectedPipeline($pipelines);

		$stages = $this->getStages($selectedPipeline);

		$deals = $this->getDeals($selectedPipeline);

		return view('dashboard', compact('selectedPipeline', 'stages', 'deals'));
	}

	public function deskPerformance()
	{
		$users = $this->getUsers();

		$pipelines = $this->getPipelines();

		$selectedPipeline = $this->getSelectedPipeline($pipelines);

		$deals = $this->getDeals($selectedPipeline);

		return view('desk-performance', compact('selectedPipeline', 'users', 'deals'));
	}

	public function userDesk($user_id)
	{
		$users = $this->getUsers();

		$pipelines = $this->getPipelines();

		$selectedPipeline = $this->getSelectedPipeline($pipelines);

		$stages = $this->getStages($selectedPipeline);

		$deals = $this->getDeals($selectedPipeline);

		$userDeals = $this->getUserDeals($user_id, $deals);

		return view('user-desk', compact('users', 'user_id', 'selectedPipeline', 'stages', 'deals', 'userDeals'));
	}

}
