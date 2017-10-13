<?php
if(!isset($_GET["srv"]) || !isset($_GET["tid"]) || !isset($_GET["port"]))
{
	echo "kthnxbai.";
	exit();
}
require("SampQueryAPI.php");
$srv = $_GET["srv"];
$port = $_GET["port"];
$t = $_GET["tid"];
$query = new SampQueryAPI($srv, $port);
if($query->isOnline())$s_info = $query->getInfo();
function imagettftextoutline(&$im,$size,$angle,$x,$y,&$col,
            &$outlinecol,$fontfile,$text,$width) {    
    for ($xc=$x-abs($width);$xc<=$x+abs($width);$xc++) {        
        for ($yc=$y-abs($width);$yc<=$y+abs($width);$yc++) {           
            $text1 = imagettftext($im,$size,$angle,$xc,$yc,$outlinecol,$fontfile,$text);
        }
    }
    $text2 = imagettftext($im,$size,$angle,$x,$y,$col,$fontfile,$text);
}
$file = fopen('templates/'.$t.'.json', "r") or die("Wrong template id!");
$info = fread($file, filesize('templates/'.$t.'.json'));
fclose($file);
$info = json_decode($info, true);
$im = imagecreatetruecolor($info[3]['width'], $info[3]['height']);
switch($info[2]['type'])
{
	case 0:
	{
		
		$black = imagecolorallocate($im, 0, 0, 0);
		imagecolortransparent($im, $black);
		break;
	}
	case 1:
	{
		
		$rgb = explode(',', $info[2]['back']);
		$col = imagecolorallocate($im, intval($rgb[0]), intval($rgb[1]), intval($rgb[2]));
		imagefill($im, 0, 0, $col);
		break;
	}
	case 2:
	{
		
		$bb = -1;
		$furl = str_replace("url(", "", $info[2]['back']);
		$furl = str_replace(")", "", $furl);
		$choice = explode('.', $furl);
		$choice = strtolower(array_pop($choice));
		switch ($choice) 
		{
			case 'jpeg':
			case 'jpg':
				$bb = imagecreatefromjpeg($furl);
				break;

			case 'png':
				$bb = imagecreatefrompng($furl);
				break;

			case 'gif':
				$bb = imagecreatefromgif($furl);
				break;
			default:die('Background Image type not supported');
		}
		imagecopyresampled($im, $bb, 0, 0, 0, 0, $info[3]['width'], $info[3]['height'], imagesx($bb), imagesy($bb));
		imagedestroy($bb);	
	}
}

for($i = 0; $i < sizeof($info[4]); $i++)
{
	$tmp = -1;
	$choice = explode('.', $info[4][$i]['url']);
	$choice = strtolower(array_pop($choice));
	switch ($choice) 
	{
		case 'jpeg':
		case 'jpg':
			$tmp = imagecreatefromjpeg($info[4][$i]['url']);
			break;

		case 'png':
			$tmp = imagecreatefrompng($info[4][$i]['url']);
			break;

		case 'gif':
			$tmp = imagecreatefromgif($info[4][$i]['url']);
			break;
		
		default:die('A image which was inserted is not supported');
	}
	imagecopyresampled($im, $tmp, $info[4][$i]['x'], $info[4][$i]['y'], 0, 0, $info[4][$i]['width'], $info[4][$i]['height'], imagesx($tmp), imagesy($tmp));
	imagedestroy($tmp);	
}

for($i = 0; $i < sizeof($info[0]); $i++)
{	
	$rgb = explode(',', $info[0][$i]['color']);	
	$fcol = imagecolorallocate($im, intval($rgb[0]), intval($rgb[1]), intval($rgb[2]));
	$bbox = imagettfbbox ( $info[0][$i]['size'], 0.0 , 'gd_fonts/'.$info[0][$i]['font'].'.ttf' , $info[0][$i]['text'] );
	$y_offset = abs($bbox[7] - $bbox[1]);
	if($info[0][$i]['outline'] == 'none')imagettftext($im, $info[0][$i]['size'], 0.0, $info[0][$i]['x'], $info[0][$i]['y']+$y_offset, $fcol, 'gd_fonts/'.$info[0][$i]['font'].'.ttf', $info[0][$i]['text']);
	else
	{
		$rgb = explode(',', $info[0][$i]['outline']);
		$ocol = imagecolorallocate($im, intval($rgb[0]), intval($rgb[1]), intval($rgb[2]));
		imagettftextoutline(
        $im,
        $info[0][$i]['size'],            // font size
        0.0,             // angle in °
        $info[0][$i]['x'],             // x
        $info[0][$i]['y']+$y_offset,            // y
        $fcol,//font color
        $ocol,//outline color
        'gd_fonts/'.$info[0][$i]['font'].'.ttf',
        $info[0][$i]['text'],       // pattern
        1              // outline width
		);
		
	}
}

//Stats :
for($i = 0; $i < sizeof($info[1]); $i++)
{	
	$txt = "";
	if($query->isOnline())
	{
		if($info[1][$i]['text'] == "status")$txt = "Online";
		else $txt = $s_info[$info[1][$i]['text']];		
	}
	else
	{
		if($info[1][$i]['text'] == "status")$txt = "Offline";
		else $txt = "---";
	}	
	$rgb = explode(',', $info[1][$i]['color']);	
	$fcol = imagecolorallocate($im, intval($rgb[0]), intval($rgb[1]), intval($rgb[2]));
	$bbox = imagettfbbox ( $info[1][$i]['size'], 0.0 , 'gd_fonts/'.$info[1][$i]['font'].'.ttf' , $txt );
	$y_offset = abs($bbox[7] - $bbox[1]) ;		
	if($info[1][$i]['outline'] == 'none')imagettftext($im, $info[1][$i]['size'], 0.0, $info[1][$i]['x'], $info[1][$i]['y']+$y_offset, $fcol, 'gd_fonts/'.$info[1][$i]['font'].'.ttf', $txt);
	else
	{
		$rgb = explode(',', $info[1][$i]['outline']);
		$ocol = imagecolorallocate($im, intval($rgb[0]), intval($rgb[1]), intval($rgb[2]));
		imagettftextoutline(
        $im,
        $info[1][$i]['size'],            // font size
        0.0,             // angle in °
        $info[1][$i]['x'],             // x
        $info[1][$i]['y']+$y_offset,            // y
        $fcol,//font color
        $ocol,//outline color
        'gd_fonts/'.$info[1][$i]['font'].'.ttf',
        $txt,		    // pattern
        1              // outline width
		);
		
	}
}

header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
?>

