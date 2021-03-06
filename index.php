<?php
//error_reporting(E_ALL);
//ini_set('display_errors', true);
if($_POST['formSubmit'] == "Submit")
{
        $errorMessage = "";

        if(empty($_POST['formMovie']))
        {
                $errorMessage .= "<li>You forgot to enter the data!</li>";
        }

        $varMovie = $_POST['formMovie'];

        if(empty($errorMessage)) 
        {
		//FOR TWEETS
		require_once('TwitterAPIExchange.php');
		//TWITTER APP CONFIG
		$settings = array(
		    'oauth_access_token' => "ACCESS_TOKEN_HERE",
		    'oauth_access_token_secret' => "ACCESS_TOKEN_SECRET_HERE",
		    'consumer_key' => "CONSUMER_KEY_HERE",
		    'consumer_secret' => "CONSUMER_SECRET_HERE"
		);
		//TWITTER REQUEST PARAMS
		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$getfield = '?q='.$varMovie;
		$requestMethod = 'GET';
		//GET TWEETS
		$twitter = new TwitterAPIExchange($settings);
		$tweetData = json_decode($twitter->setGetfield($getfield)
			     ->buildOauth($url, $requestMethod)
			     ->performRequest(),$assoc = TRUE);
		$myFile = "article.txt";
		$fh = fopen($myFile, 'w') or die("can't open file");
		$dump = "";
		foreach($tweetData['statuses'] as $tweet)
		{
			$dump = $dump.$tweet['text']."\n";
		}
		//write tweet dump to file
		fwrite($fh,$dump);
		fclose($fh);
                $output = `python ArticleAnalysis.py`;
//print_r($output);
        }
}
?><!DOCTYPE HTML>
<html>
	<head>
		<title>Sentiment Analysis by Vipul Kumar</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,300italic" rel="stylesheet" type="text/css" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.poptrox-2.2.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>

		<!-- Header -->
			<section id="header">
				<header>
					<h1>Sentiment Analysis </h1>
					<p>by Vipul Kumar</p>
				</header>
				<footer>
					<a href="#banner1" class="button style2 scrolly">About the project</a>
				</footer>
			</section>
		
		<!-- Banner -->
			<section id="banner">
				<header id="banner1">
					<h2>Sentiment Analysis</h2>
				</header>
				<p>This is a simple word by word analysis tool to rate a piece of text.<br />
				I have used the the ANEW words and FINN lexicon as the lexicon base for analysis<br />
				You can get the whole code at <a href="https://github.com/vipulucky/Sentiment-Analysis">Github</a>.</p>
				<footer>
					<a href="#first" class="button style2 scrolly">Now let's analyze: </a>
				</footer>
			</section>
				
		<!-- Contact -->
	
<section>
			<article class="container box style3" >

				<header>
					<h2>Analysis</h2>
					<p>Just enter the text to be analyzed</p>
				</header>
				<form action="index.php#rating" method="post" >
					<div class="row half" id="first">
						<div class="12u">
		<textarea type="text" rows="4" cols="10" name="formMovie" value="" />
<?php if($_POST['formMovie']!=NULL) echo $_POST['formMovie'];
else echo "";?>
</textarea>
						</div>
					</div>
					<div class="row">
						<div class="12u">
							<ul class="actions">
								<li>
		<input type="submit" name="formSubmit"class="button form" value="Submit" />
</li>
							</ul>
						</div>
					</div>
				</form>
			</article>
</section>
<article class="container box style3" id="rating">
<section>
					<header>
						<h3>The ratings</h3>
					</header>
<p>
<b>Anew Rating: </b><p> This rates the given text on a scale of 10 and tells how happy (+10) or sad(0) the text is.
Valence, dominance and arousal are different rating levels and have different mathematical meaning in the analysis.
</p>
<p><b>Finn rating:</b></p>
<p>If u have a positive FINN rating, it means that the text had happy and positive feelings. While if it is below zero, it denotes sadness or
negativity. It has a scale of +5 to -5.
</p>
<?php
	echo $output;
?>
				</section></article>
		
		
		<section id="footer">
			<ul class="icons">
				<li><a href="http://twitter.com/vipul_aka_lucky" class="icon icon-twitter solo"><span>Twitter</span></a></li>
				<li><a href="http://fb.me/vipulucky" class="icon icon-facebook solo"><span>Facebook</span></a></li>
				<li><a href="https://plus.google.com/113309832382681748856/" class="icon icon-google-plus solo"><span>Google+</span></a></li>
				<li><a href="http://www.linkedin.com/in/vipulucky" class="icon icon-linkedin solo"><span>LinkedIn</span></a></li>
			</ul>
			<div class="copyright">
				<ul class="menu">
					<li>&copy; Sentiment Analysis. All rights reserved.</li>

				</ul>
			</div>
		</section>

	</body>
</html>
