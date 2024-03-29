<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\User;
use App\Search;
use App\Keyword;
use App\Campaign;
use App\Job;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Jobs\SearchAPI;
use App\Slack;
use App\Http\Repository\AdminUserTable;
use App\Queue;
use App\Subscription;
use DateTime;
use DatePeriod;
use DateInterval;
use LanguageDetection\Language;
use MichaelJWright\Comprehend\Comprehend;
use Stevebauman\Location\Location;


class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  protected $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

  public function __construct()
  {
    $this->middleware(['auth', 'verified']);


    $this->middleware(function ($request, $next) {

      $user = \Auth::user();
      if ($user) {
        $campaign_list = Campaign::where('user_id', $user->id)->get();
        $array = [];
        if($campaign_list->count() > 0){
          $flag = false;
          foreach ($campaign_list as $campaign)
          {
                $keyword_list = Keyword::where('campaign_id', $campaign->id)->get();
                if ($keyword_list->count() > 0 && $flag == false)
                {
                $flag = true;
                $keyword = $keyword_list->first();
                $campaign = $keyword->campaign;
                if (session('keyword_id') == null){
                    session(['keyword_id'=> $keyword->id]);
                }

                View::share('keyword_id', $keyword->id);
                View::share('campaign_active_id', $campaign->id);
                View::share('fb_new', $keyword->fb_new);
                View::share('tw_new', $keyword->tw_new);
                View::share('yt_new', $keyword->yt_new);
                View::share('web_new', $keyword->web_new);
            }
            array_push($array, [
                'campaign_id' => $campaign->id,
                'campaign' => $campaign->campaign,
                'keyword_list' => $keyword_list
            ]);
          }
        }
        $firstcharname = strtoupper(substr($user->name, 0, 1));
        View::share('namefirstchar', $firstcharname);
        View::share('campaign_list', $array);

      }

      return $next($request);
    });
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */




  public function index()
  {
    return view('home');
  }

  public function step(Request $request)
  {
    $user = $request->user();
    if($user->id < 2){
      return redirect()->route('adminboard');
    }
    if ($user->trial_ends_at <= date("Y-m-d H:i:s")){
        if(!$user->subscribed('main')){

            $user->active = 0;
            $user->save();
            return redirect()->route('plans.show')->withErrorMessage('Please upgrade your account!');
        }
    }

    if ($user->active == 0){
        return redirect()->route('trial');
    }

    return view('step');
  }
  /*
    Return dashboard page

  */
  public function dashboard(Request $request)
  {
    $user = $request->user();
    if($user->id < 2){
      return redirect()->route('adminboard');
    }
    if ($user->trial_ends_at <= date("Y-m-d H:i:s")){
        if(!$user->subscribed('main')){

            $user->active = 0;
            $user->save();
            return redirect()->route('plans.show')->withErrorMessage('Please upgrade your account!');
        }
    }

    if ($user->active == 0){
        return redirect()->route('trial');
    }

    $campaign_cnt = Campaign::where('user_id', $user->id)->selectRaw('count(id) AS cnt')->first()->cnt;
    if ($campaign_cnt == 0){
        return redirect()->route('step');
    }
    $job = $this->getJobStatus();
    if ($job['status'] == 'pending'){
        if(Search::all()->last()){
            $search_last = Search::all()->last()->id;
        }
        else {

            $search_last = 0;
        }
        $fb_cnt = Search::where('social_type', 'facebook')->count();
        $tw_cnt = Search::where('social_type', 'twitter')->count();
        $yt_cnt = Search::where('social_type', 'youtube')->count();
        $web_cnt = Search::where('social_type', 'web')->count();
        return view('dashboard', [
            'job' => $search_last,
            'fb_cnt' => $fb_cnt,
            'tw_cnt' => $tw_cnt,
            'yt_cnt' => $yt_cnt,
            'web_cnt' => $web_cnt,
        ]);
    }
    return view('dashboard');
  }

  public function adminBoard(Request $request)
  {
    if($request->user()->id > 1){
      return redirect()->route('dashboard');
    }
    return view('admindashboard')->with('countries', $this->countries);
  }

  public function addKeyword(Request $request)
  {
    $user_id = $request->user()->id;
    if($user_id < 2){
      return redirect()->route('adminboard');
    }
    $socialite_user = User::where('id',$user_id)->where('country','callback')->get();
    if($socialite_user->count() > 0)
    {
      $location = new Location();
      $position = $location->get($request->ip());
      if($position){
        $user = User::updateOrCreate(['id' => $user_id],['country' => $position->countryName]);
      }
    }


//    dump(auth()->user());
//    dump(\Auth::user());

    $campaign_type = $request->input('campaign-type', 'brand');
    $campaign_name = $request->input('campaign-name', 'campaign');
    $campaign = Campaign::updateOrCreate(['user_id' => $user_id, 'campaign' => $campaign_name, 'type' => $campaign_type]);
    $index = 0;
    $campaign_keyword = $request->input('campaign-keyword');
    while(1)
    {
      if($index >= 5)
        break;

      if($campaign_keyword[$index] == null)
        break;
      // $campaign_notification = $request->input('campaign-notification','slack');
      // $keyword_params = [
      //   'user_id' => $user_id,
      //   'keyword' => $campaign_keyword[$index],
      //   'type' => $campaign_type,
      //   'notification_type' => $campaign_notification
      // ];
      $keyword = Keyword::updateOrCreate(['campaign_id' => $campaign->id, 'keyword' => $campaign_keyword[$index]]);
      if($index == 0)
        $keyword_id = $keyword->id;
      $index++;
    }

    $queue = new Queue();
    $queue->campaign_id = $campaign->id;
    $queue->save();
    SearchAPI::dispatch($campaign->id);
    
    return redirect()->route('campaignPage', [
        'keyword_id' => $keyword_id
    ]);
    // return redirect()->route('campaignPage', ['keyword_id' => $keyword_id, 'job' => $search_last]);
  }

  public function showCampaignPage(Request $request, $keyword_id)
  {
    session(['keyword_id'=> $keyword_id]);
    $keyword = Keyword::where('id', $keyword_id)->first();
    $campaign = $keyword->campaign;
    View::share('campaign_active_id', $campaign->id);

    $job = $this->getJobStatus();
    if ($job['status'] == 'pending'){
        if(Search::all()->last()){
            $search_last = Search::all()->last()->id;
        }
        else {

            $search_last = 0;
        }
        $fb_cnt = Search::where('social_type', 'facebook')->count();
        $tw_cnt = Search::where('social_type', 'twitter')->count();
        $yt_cnt = Search::where('social_type', 'youtube')->count();
        $web_cnt = Search::where('social_type', 'web')->count();
        return view('dashboard', [
            'keyword_id' => $keyword_id,
            'job' => $search_last,
            'fb_cnt' => $fb_cnt,
            'tw_cnt' => $tw_cnt,
            'yt_cnt' => $yt_cnt,
            'web_cnt' => $web_cnt,
            'fb_new' => $keyword->fb_new,
            'tw_new' => $keyword->tw_new,
            'yt_new' => $keyword->yt_new,
            'web_new' => $keyword->web_new
        ]);
    }

    return view('dashboard', [
        'keyword_id' => $keyword_id,
        'fb_new' => $keyword->fb_new,
        'tw_new' => $keyword->tw_new,
        'yt_new' => $keyword->yt_new,
        'web_new' => $keyword->web_new
    ]);
  }

  public function getTableData(Request $request)
  {
    $keyword_id = $request->input('keyword_id');
    // $lang = $request->input('language', null);
    $search_list = Keyword::where('id', $keyword_id)->first()->searches;
    // if($lang){
    //     $tr = new GoogleTranslate();
    //     $tr->setTarget($lang);

    //     foreach ($search_list as $item) {
    //         $item->title = $tr->translate($item->title);
    //     }
    // }
    return $search_list->toJson();
  }

  public function getGraphData(Request $request)
  {
    $socialTypeArray = ['facebook', 'twitter', 'instagram', 'youtube', 'web'];
    $keyword_id = $request->input('keyword_id');
//    $keyword_id = Keyword::where('user_id', $request->user()->id)->where('keyword', $keyword)->first()->id;
    $search_list = Search::where('keyword_id', $keyword_id)->selectRaw('date, count(id)')->groupBy('date')->get();
    $searchArray=[];

    $dateOne = new DateTime('2019-11-11');

    $dateTwo = new DateTime( );

    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($dateOne, $interval ,$dateTwo);

    foreach($socialTypeArray as $type)
    {
       $typeArray = [];

      foreach($daterange as $dateIndex)
      {
        $item = Search::where('social_type', $type)->where('keyword_id', $keyword_id)->where('date', $dateIndex)->selectRaw('date, count(id) AS cnt')->groupBy('date')->first();
        if($item == null)
          $itemData = ['date'=> $dateIndex->format('Y-m-d'), 'value'=> 0];
        else
          $itemData = ['date'=> $dateIndex->format('Y-m-d'), 'value'=> $item->cnt];
//        dump($item);

        array_push($typeArray, $itemData);
      }

     array_push($searchArray, $typeArray);
   }
//   dd($searchArray);
    return $searchArray;
  }

  public function deleteRowTabledata(Request $request)
  {
    $rowId = $request->input('rowId',0);
    $row = Search::where('id', $rowId);
    $row->delete();
  }

  public function getAdminTableData(Request $request)
  {

    $tableInstance = new AdminUserTable;
    return $tableInstance->getTableData();
  }

  public function deleteAdminRowTabledata(Request $request)
  {
    $rowId = $request->input('rowId',0);
    $user = User::where('id', $rowId)->first();
    foreach ($user->campaigns as $campaign){
      foreach ($campaign->keywords as $keyword){
        foreach ($keyword->searches as $search){
          $search->delete();
        }
        $keyword->delete();
      }
      $campaign->delete();
    }
    $subscription = Subscription::where('user_id', $user->id)->first();
    if($subscription){
        $subscription->delete();
    }
    $user->delete();
  }

  public function saveAdminCommentChanges(Request $request)
  {
    $rowId = $request->input('rowId', 0);
    $comment = $request->input('comment', '');
    $user = User::where('id', $rowId)->update(['comment' => $comment]);
  }

  public function getSlackWebHookURL(Request $request)
  {
    $oauth_url = env('SLACK_API_OAUTH_URL');
    $client_id = env('SLACK_CLIENT_ID');
    $client_secret = env('SLACK_CLIENT_SECRET');
    $code = $request->get('code');

    $client = new \GuzzleHttp\Client();
    $response = $client->post(
        $oauth_url,
        array(
            'form_params' => array(
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'code' => $code
            )
        )
    );
    $webhook_json = $response->getBody()->getContents();
    $webhook = json_decode($webhook_json);

    $campaign_id = session('campaign_id');
    if(!isset($campaign_id)|| !isset($webhook->team->name))
    {
        return redirect()->route('dashboard')->withErrorMessage('Can not get campaign to add slack! Please choose correct campaign again.');
    }


    $slack = Slack::updateOrCreate([
        'campaign_id' => $campaign_id,
        'team_name' => $webhook->team->name,
        'channel_id' => $webhook->incoming_webhook->channel_id
        ],[
            'channel_name' => $webhook->incoming_webhook->channel,
            'webhook_url' => $webhook->incoming_webhook->url,
            'configuration_url' => $webhook->incoming_webhook->configuration_url
    ]);
    $campaign = Campaign::where('id', $campaign_id)->first();

    $response = $client->post(
        $webhook->incoming_webhook->url,
        array(
            'headers' => array('content-type' => 'application/json'),
            'json' => array(
                'text' => "Congratulations! , your campaign *$campaign->campaign* has been successfully added to Slack",
            )
        )
    );

    $queue = new Queue();
    $queue->campaign_id = $campaign_id;
    $queue->save();
    SearchAPI::dispatch($campaign_id);

    if(Search::all()->last()){
        $search_last = Search::all()->last()->id;
    }
    else {

        $search_last = 0;
    }
    $fb_cnt = Search::where('social_type', 'facebook')->count();
    $tw_cnt = Search::where('social_type', 'twitter')->count();
    $yt_cnt = Search::where('social_type', 'youtube')->count();
    $web_cnt = Search::where('social_type', 'web')->count();
    return redirect()->route('dashboard', [
        'job' => $search_last,
        'fb_cnt' => $fb_cnt,
        'tw_cnt' => $tw_cnt,
        'yt_cnt' => $yt_cnt,
        'web_cnt' => $web_cnt
    ]);
    // return redirect()->route('dashboard', ['job' => $search_last])->withSuccessMessage('Your campaign added to slack successfully!');

    }

  public function addToSlack(Request $request)
  {
    $campaign_id = $request->get('slack_campaign_id');

    if($campaign_id == null)
    {
        return redirect()->route('dashboard');
    }
    // if($campaign_id == '0' || $campaign_id == null)
    // {
    //     return redirect()->route('dashboard')->withErrorMessage('Please select campaign to add to slack');
    // }
    session(['campaign_id'=> $campaign_id]);

    $webhook_url = env('SLACK_WEBHOOK_URL');

    return redirect($webhook_url);
  }

  public function facebook()
  {

    $access_token = env('ACCESS_TOKEN_FB');
    $app_token = env('APP_TOKEN_FB');
    $app_secret = env('APP_SECRET_FB');
    //   dd($app_token);
    $appsecret_proof= hash_hmac('sha256', $access_token, $app_secret);

    // dump($access_token);
    // dump('EAAGpzQLPRlEBAMIFebLQYePjlJ3wF9Yg0gdAKjPHzWMfDJ0DPOpwQwmFbrLqf91Qa4eZBFsknfuQgvtEPZCI29zGE8dQFW3456ya8aya9bqikwrpFRv4pZBKISZBMS9jNex7OvU5ZBLgSvU2th7iamqdc90eOi3KrzaJPaIdpZCAF8pXbbb9HRmDAvjebvfrMbSbFoGZBZCFpzpahoPaFC0YMaxvMPziF5yIweU9bNAnGUPg5azZC4xIZB');
    // dump($app_token);
    // dump($app_secret);
     dd($appsecret_proof);
  }

  public function getJobStatus()
  {
    $job_table = Queue::all();
    if(Search::all()->last()){
        $search_last = Search::all()->last()->id;
    }
    else {
        $search_last = 0;
    }
    $fb_cnt = Search::where('social_type', 'facebook')->count();
    $tw_cnt = Search::where('social_type', 'twitter')->count();
    $yt_cnt = Search::where('social_type', 'youtube')->count();
    $web_cnt = Search::where('social_type', 'web')->count();
    foreach ($job_table as $job){
        // $jsonpayload = json_decode($job->payload);
        // $data = unserialize($jsonpayload->data->command);
        if(Campaign::find($job->campaign_id)->user_id == auth()->user()->id){

            return [
                'status' => 'pending',
                'last_index' => $search_last,
                'fb_cnt' => $fb_cnt,
                'tw_cnt' => $tw_cnt,
                'yt_cnt' => $yt_cnt,
                'web_cnt' => $web_cnt
            ];
        }
    }
    return ['status' => 'end',
        'last_index' => $search_last,
        'fb_cnt' => $fb_cnt,
        'tw_cnt' => $tw_cnt,
        'yt_cnt' => $yt_cnt,
        'web_cnt' => $web_cnt
    ];
  }

    public function saveNewcomments(Request $request)
    {
        $keyword_id = $request->input('keyword_id');
        $fb = $request->input('fb');
        $tw = $request->input('tw');
        $yt = $request->input('yt');
        $web = $request->input('web');
        Keyword::where('id', $keyword_id)->update(['fb_new' => $fb, 'tw_new' => $tw, 'yt_new' => $yt, 'web_new'=> $web]);
    }

    public function sentimentAnalysis($comments) {
        $config = [
            'LanguageCode' => 'en',
            'Text' => $comments,
        ];
        try {
            $jobSentiment = Comprehend::detectSentiment($config);
            // dump($jobSentiment['Sentiment']);
            return $jobSentiment['Sentiment'];
        } catch (\Exception $e) {
            return 'INVALID';
        }
    }

    public function phpinfo()
    {
        $text = "";
        // $detector = new \LanguageDetector\LanguageDetector();

        // dd($detector->evaluate($text));
 
        $ld = new Language;
        
        dd($ld->detect($text));
    }


}
