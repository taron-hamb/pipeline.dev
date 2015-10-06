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

		return view('auth.dashboard', compact('selectedPipeline', 'stages', 'deals'));
	}

	/**
	 * Show the application Desk Performance to the user.
	 * @param null $user_id
	 * @return desk-performance
	 */
	public function deskPerformance($user_id = null)
	{
		$users = $this->getUsers();

		$pipelines = $this->getPipelines();

		$selectedPipeline = $this->getSelectedPipeline($pipelines);

		$deals = $this->getDeals($selectedPipeline);

		if($user_id)
		{
			$selectedUser = $this->getUser($user_id);

			$stages = $this->getStages($selectedPipeline);

			$userDeals = $this->getUserDeals($user_id, $deals);

			return view('auth.desk-performance', compact('users', 'selectedUser', 'selectedPipeline', 'stages', 'deals', 'userDeals'));

		}else{
			return view('auth.desk-performance', compact('selectedPipeline', 'users', 'deals'));
		}
	}

	/**
	 * Show the application Details of Deal to the user.
	 * @param $id
	 * @return deal
	 */
	public function dealDetails($id)
	{
		$pipelines = $this->getPipelines();

		$selectedPipeline = $this->getSelectedPipeline($pipelines);

		$deal = $this->getDealDetails($id);

		$stages = $this->getStages($selectedPipeline);

		return view('auth.deal-details', compact('deal', 'stages'));
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

	//Get One User
	public function getUser($user_id)
	{
		$url_user = $this->api_url."/users/".$user_id."?&api_token=".$this->api_token;
		$userWithData = $this->curl($url_user);
		$user = $userWithData['data'];
		return $user;
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

	//Get Deal Details
	public function getDealDetails($id)
	{
		$url_deal = $this->api_url."/deals/".$id."?&api_token=".$this->api_token;
		$dealWithData = $this->curl($url_deal);
		$deal = $dealWithData['data'];
		return $deal;
	}

}
