<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="AuThemes Templates">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="AuThemes Templates">

    <!-- Title Page-->
    <title>Adding campaign to Gohundred</title>
    <link rel="shortcut icon" href="/assets/media/logos/GoHundred-icon.png" />

    <!-- Icons font CSS-->
    <link href="/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="/css/creative.css" rel="stylesheet">



    <!-- Main CSS-->
    <link href="/css/dashboard/main.css" rel="stylesheet" media="all">
    <link href="/css/dashboard/custom.css" rel="stylesheet" media="all">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-img-1 ">
        <div class="wrapper ">
            <div class="card card-1">
                <div class="card-heading">
                    <h2 class="title">Let's get you started with monitoring campaigns</h2>
                </div>
                <div class="card-body">
                    <form class="wizard-container" method="POST" action="{{ route('stepResult') }}" id="step-form">
                        @csrf
                        <input type="hidden" id="campaign-type" name="campaign-type" value="brand"/>

                        <ul class="tab-list">
                            <li class="tab-list__item active">
                                <a class="tab-list__link" href="#tab1" id="link-tab1" data-toggle="tab">
                                    <span class="step">1</span>
                                    <span class="desc">step</span>
                                </a>
                            </li>
                            <li class="tab-list__item">
                                <a class="tab-list__link" href="#tab2" id="link-tab2" data-toggle="tab">
                                    <span class="step">2</span>
                                    <span class="desc">step</span>
                                </a>
                            </li>
                            <!-- <li class="tab-list__item">
                                <a class="tab-list__link" href="#tab3" id="link-tab3" data-toggle="tab">
                                    <span class="step">3</span>
                                    <span class="desc">step</span>
                                </a>
                            </li> -->
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form">
                                    <div class="text-center">
                                        <p class="h3 text-center">Choose your type of campaign (You can always add more later)</p>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button href="#" class="btn btn-light campaign-type" type="brand">
                                            <strong>Brand</strong>
                                        </button>

                                        <p>Find out who talks about your brand</p>
                                        <button href="#" class="btn btn-light campaign-type" type="competition">
                                            <strong>Competition</strong>
                                        </button>

                                        <p>Figure out what your competitors are up to</p>
                                        <button href="#" class="btn btn-light campaign-type" type="topic">
                                            <strong>Topic</strong>
                                        </button>
                                        <p>Get instant news on topics related to your business</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="form">
                                    <div class="text-center">
                                        <p class="h6">Type the name of campaign</p>
                                    </div>
                                    <div class="input-group mt-3">
                                        <div class="campaign-div">
                                            <div class="campaign-name-div" style="margin:auto; width:300px;">
                                                <input class="input_campaign" id="campaign_name" name="campaign-name" type="text" placeholder="Campaign" required>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="input-group">
                                        <p class="h6">Type the name of the brand,competitor or topic that you wish to keep your eyes on</p>
                                    </div>
                                    <div class="input-group mt-4">
                                        <button class="fas fa-plus plus-button" id="plus-button-id" type="button"></button>
                                        <div class="campaign-div">
                                            <input class="input--style-1" id="keyword" type="text" name="campaign-keyword[]" placeholder="Keyword" required>
                                            <button class="btn--next">Add campaigns</button>
                                        </div>
                                    </div>
                                    <div class="input-group mt-2">
                                        <button class="fas fa-minus plus-button" id="minus-button-id1" type="button" style="display:none;" ></button>
                                        <div class="campaign-div">
                                            <input class="input--style-1" id="keyword1" type="text" name="campaign-keyword[]" placeholder="Keyword" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="input-group mt-2">
                                        <button class="fas fa-minus plus-button" id="minus-button-id2" type="button" style="display:none;"></button>
                                        <div class="campaign-div">
                                            <input class="input--style-1" id="keyword2" type="text" name="campaign-keyword[]" placeholder="Keyword" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="input-group mt-2">
                                        <button class="fas fa-minus plus-button" id="minus-button-id3" type="button" style="display:none;"></button>
                                        <div class="campaign-div">
                                            <input class="input--style-1" id="keyword3" type="text" name="campaign-keyword[]" placeholder="Keyword" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="input-group mt-2">
                                        <button class="fas fa-minus plus-button" id="minus-button-id4" type="button" style="display:none;"></button>
                                        <div class="campaign-div">
                                            <input class="input--style-1" id="keyword4" type="text" name="campaign-keyword[]" placeholder="Keyword" style="display: none;">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="/js/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.bootstrap.wizard.min.js"></script>


    <!-- Main JS-->
    <script src="/js/dashboard/global.js"></script>

</body>

</html>
<!-- end document-->
