<?php
/**
 * Requisites
 * youtube-dl
 * ffmpeg
 * https://rg3.github.io/youtube-dl/download.html
 * https://github.com/ytdl-org/
 */

/*
  ┌─────────────────────┐
  | GLOBAL DIR SETTINGS |
  └─────────────────────┘
*/
// SET DOWNLOADER PATH [IN NEX VERSION THIS OPTION]
define("MAIN_DIR", "/var/www/html/"); // TEST
//exec("mkdir " . MAIN_DIR . "YT/YouTube_Downloader_LINUX > /dev/null 2>&1");
//exec("chmod -R 755 " . MAIN_DIR . "/"); // TEST
define("DOWNLOAD_DIR", MAIN_DIR . "downloads");
//chdir(DOWNLOAD_DIR . "/");

$app_name = "YouTube Downloader";
$site_title = $app_name;
$version = "v1.0";
$titulli = "Content:";

//error_reporting(E_ALL);
if(!empty($_POST['url']))
{
    $url = trim($_POST['url']);
// FOR MORE COMMANDS GO TO https://github.com/ytdl-org/youtube-dl#options
    $youtube_bin_command = "LC_ALL=en_US.UTF-8 youtube-dl -f best -g $url"; // MP3

    $file_name = exec(escapeshellcmd($youtube_bin_command));
    //echo $file_name.'<br />';

    $youtube_dl_get_command = "youtube-dl -f best -g $url";
    $response = exec(escapeshellcmd($youtube_dl_get_command));

// SINGLE
// $stream_source = str_replace('.m4a','.mp3',$file_name);
// ARRAY
$stream_source = str_replace(
    array(".m4a"),
    array(".mp4"),
    $file_name
);

// REMOVE IDS FROM DATA -> -6IrO01N9LqM
// $stream_source = 'DRS_-_Live_Life_Hard_Uptempo-6IrO01N9LqM.mp3';
// $pattern = '/(-\d\w{3}\d{2}\w\d\w{3}.\w{2}\d)/'; // DRS_-_Live_Life_Hard_Uptempo
$pattern = '/(-.{11}\.)/'; // DRS_-_Live_Life_Hard_Uptempo.mp3
//$pattern = '/(-\d\w{3}\d{2}\w\d\w{3})/'; // DRS_-_Live_Life_Hard_Uptempo.mp3
$replacement = '.';
$stream_source = preg_replace($pattern, $replacement, $stream_source);
// REMOVE IDS FROM DATA -> -6IrO01N9LqM

$ffmpeg_convert_command = "ffmpeg -i $file_name -f best -g $stream_source";

//echo  $ffmpeg_convert_command."<br />";
$response = exec($ffmpeg_convert_command);

//var_dump($response);
if(file_exists($file_name))
{
//delete .m4a file
unlink($file_name);
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php print "$app_name $version"; ?></title>
<link rel="shortcut icon" href="favicon.ico"/>
<link rel="icon" href="favicon.ico"/>
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="YouTube Video Downloader">
<meta name="author" content="Olsion Bakiaj">
<link rel="stylesheet" href="assets/css/bootstrap/3.3.7/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/bootstrap/font-awesome4.7.0/font-awesome.min.css">
<script src="assets/js/jquery/3.1.1/jquery.min.js"></script>
<script src="assets/js/bootstrap/3.3.7/bootstrap.min.js"></script>
</head>
<style>
.container {
width: 100%;
margin-left: auto;
margin-right: auto;
}
</style>
<style>
#checkbox label{
    display:block;
    padding:5px;
}
</style>
<style type="text/css">

body,td,th {
	color: #0F0;
	overflow: hidden;
}

body {
	background-color: #000000;
}
a:link {
	color: #00FF00;
}
a:visited {
	color: #00FF00;
}
a:hover {
	color: #00FF00;
}
a:active {
	color: #00FF00;
}

html {
  height: auto;
}
body {
  min-height: auto;
}

/* remove scrollbar space */
html {
overflow: scroll;
overflow-x: hidden;
}
::-webkit-scrollbar {
width: auto; /* remove scrollbar space */
background: transparent; /* optional: just make scrollbar invisible */
}
/*  optional: show position indicator in red */
::-webkit-scrollbar-thumb {
background: #000;
}
</style>
</head>
<body>
<div class="container text-center" style="padding-top: 2em;">
<div class="panel panel-default">
<div class="panel-header">
<h1><?php print "$app_name $version"; ?></h1>
</div>
<div class="panel-body">
<form class="form-download" method="post" id="download">
<form class="horizontal-form">
<!----/>
<strong>Enter Video URL or Video ID</strong>
<!---->
<div class="form-group">
</div>
<div class="form-group">
<input title="Enter Video ID or URL" name="url" type="url" class="form-control" placeholder="Enter Video URL or Video ID">

<label class="checkbox">
<strong>GET TYPE:</strong><br>

<input type="checkbox" name="download_mp3" id="download_mp3">Download MP3
<br>
<input type="checkbox" name="watch_direct" id="watch_direct">MP4 Direct

<br>
<input type="checkbox" name="clappr_player" id="clappr_player">Clappr Player
<br>
<input type="checkbox" name="jw_player" id="jw_player">JW Player
</div>

<div class="form-group">
<input class="btn btn-primary" type="submit" name="type" id="type" value="GET"/>
</div>
</form>

<?php
if (isset($_REQUEST['download_mp3'])) {
if(!empty($_POST['url']))
{
    $url = trim($_POST['url']);
	// FOR MORE COMMANDS GO TO https://github.com/ytdl-org/youtube-dl#options
    $youtube_bin_command = "youtube-dl $url -f 140 --get-filename";
    $file_name = exec(escapeshellcmd($youtube_bin_command));
    //echo $file_name.'<br />';
    $youtube_dl_get_command = "youtube-dl $url -f 140";
    $response = exec(escapeshellcmd($youtube_dl_get_command));

// SINGLE
//$stream_source = str_replace('.m4a','.mp3',$file_name);
// ARRAY
$stream_source = str_replace(
    array(".m4a"),
    array(".mp3"),
    $file_name
);

// REMOVE IDS FROM DATA -> -6IrO01N9LqM
//$stream_source = 'DRS_-_Live_Life_Hard_Uptempo-6IrO01N9LqM.mp3';
//$pattern = '/(-\d\w{3}\d{2}\w\d\w{3}.\w{2}\d)/'; // DRS_-_Live_Life_Hard_Uptempo
$pattern = '/(-.{11}\.)/'; // DRS_-_Live_Life_Hard_Uptempo.mp3
//$pattern = '/(-\d\w{3}\d{2}\w\d\w{3})/'; // DRS_-_Live_Life_Hard_Uptempo.mp3
$replacement = '.';
$stream_source = preg_replace($pattern, $replacement, $stream_source);
// REMOVE IDS FROM DATA -> -6IrO01N9LqM

    $ffmpeg_convert_command = "ffmpeg -i $file_name -f mp3 $stream_source";

    //echo  $ffmpeg_convert_command."<br />";
    $response = exec($ffmpeg_convert_command);

    //var_dump($response);
    if(file_exists($file_name))
    {
        //delete .m4a file
        unlink($file_name);
    }
}
////////////////////////////////
if(!empty($stream_source)) {
echo '<a href="'.$stream_source.'" target="_blank" class="btn btn-primary"><b>Watch in Browser</b></a>';
}

if(!empty($stream_source)) {
echo '<button type="button" class="btn btn-primary"><a href="'.$stream_source.'" download="'.$stream_source.'" href="javascript:"><b>Download</b></button></a>';
}
}
?>
<?php
if (isset($_REQUEST['watch_direct'])) {
if(!empty($stream_source)) {
echo '<a href="'.$stream_source.'" target="_blank" class="btn btn-primary"><b>Watch Direct</b></a>';
}
}
?>
<?php
/*
if(!empty($stream_source)) {
echo '
<button type="button" class="btn btn-primary"><a href="'.$stream_source.'" download="'.$stream_source.'" href="javascript:"><b>Download</b></button></a>';
}
*/
?>
</p>
</div>
<?php if (isset($_REQUEST['clappr_player'])) {
/// Clappr Player Function
if(!empty($stream_source)) {
echo '
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@clappr/player@latest/dist/clappr.min.js"></script>
<center>
<div id="player" style="width:100%; height:100%" border: 1px dotted lime; color: #0F0;" title="Player Proxy Streaming"></div>
<script>
var player = new Clappr.Player({
source: "'.urldecode($stream_source).'",
parentId: "#player",
//height: 360,
//width: 640,
mimeType: "video/mp4"
});
</script>
</center>';
}
?>
<?php } ?>
<?php if (isset($_REQUEST['jw_player'])) {
/// JW Player Function
if(!empty($stream_source)) {
echo '
<!----/>
<script src="//ssl.p.jwpcdn.com/player/v/7.11.2/jwplayer.js"></script>
<!---->
<script src="https://content.jwplatform.com/libraries/Jq6HIbgz.js"></script>
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<div id="player"></div>
<script>
jwplayer.key = "XsWyeNQ1jdztTqhiD5MXEpz37wrnHdV05j7Ocg==";
var player = jwplayer("player");
player.setup({
    controls: true,
    displaytitle: true,
    fullscreen: "true",
    width: "100%",
    height: "98%",
ratio: "100%",
responsive: true,
sources: [{
	\'file\':\''.urldecode($stream_source).'\',
	"title": "Masters Of Hardcore - The Voice Of Mayhem",
	"type": "video/mp4"
	}],
logo: {
		file: "https://png.kodi.al/tv/albdroid/smart_x1.png",
		logoBar: "https://png.kodi.al/tv/albdroid/smart_x1.png",
		position: "top-right",
		link: ""
	},
preload: \'auto\',
aspectratio: "16:9",
title: \'YouTube Streaming\',
primary: \'html5\',
width: $(window).width(),
height: $(window).height()
})
$(document).ready(function(){
$(window).resize(function(){
jwplayer().resize($(window).width(),$(window).height())
})
})
</script>
</center>';
}
?>

<?php
}
?>
</div>
<footer>
<center>Copyright &copy; <?php echo date("Y"); ?> <a href="http://www.kodi.al" target="_blank">TRC4</a>
<a href="https://github.com/SxtBox" target="_blank">
<span class="fa fa-fw fa-github"></span> Github
</a>
</footer>
</div>
</div>
</div> 
</body>
</html>