<?php namespace App\Http\Controllers;
use Auth;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$api_token = config('constants.api_token');
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

		//Get Selected Pipeline
		$url_pipelines = "https://api.pipedrive.com/v1/pipelines?api_token=".$api_token;
		$pipelines = curl($url_pipelines);
		foreach($pipelines['data'] as $item){
			if($item['selected'] == 'true'){
				$selectedPipeline = $item;
				break;
			}
		}

		//Get Stages
		$url_stage = "https://api.pipedrive.com/v1/stages?pipeline_id=".$selectedPipeline['id']."&api_token=".$api_token;
		$stagesWithData = curl($url_stage);
		$stages = $stagesWithData['data'];

		//Deals
		$url_deals = "https://api.pipedrive.com/v1/pipelines/".$selectedPipeline['id']."/deals?everyone=0&start=0&api_token=".$api_token;
		$dealsWithData = curl($url_deals);
		$deals = $dealsWithData['data'];

		return view('dashboard', compact('selectedPipeline', 'stages', 'deals'));
	}

}
