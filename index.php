<?php
function getYouTubeIdFromURL($url){
    $url_string = parse_url($url, PHP_URL_QUERY);
    parse_str($url_string, $args);
    return isset($args['v']) ? $args['v'] : NULL;
}
function getYouTubeThumbnailHqFromId($id){
    return "https://img.youtube.com/vi/$id/hqdefault.jpg";
}
function getYouTubeThumbnailMqFromId($id){
    return "https://img.youtube.com/vi/$id/mqdefault.jpg";
}
function getYouTubeThumbnailMaxFromId($id){
    return "https://img.youtube.com/vi/$id/maxresdefault.jpg";
}
$e = '';
$img = '';
$link = '';
if(isset($_GET['quality']) && $_GET['quality']){
    $quality = 'max';
    $link = isset($_GET['yt_link']) ? $_GET['yt_link'] : '';

    if(!$link) $e = 'Please enter youtube video link';
    else{
        $id = getYouTubeIdFromURL($link);
        if(!$id) $e = 'Invalid URL, could not find video id';
        else{
            switch ($_GET['quality']){
                case 'mq':
                    $img = getYouTubeThumbnailMqFromId($id);
                    break;
                case 'hq':
                    $img = getYouTubeThumbnailHqFromId($id);
                    break;
                default:
                    $img = getYouTubeThumbnailMaxFromId($id);
                    break;
            }

        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Get youtube thumbnail</title>
</head>
<body>

<div style="text-align: center">
    <h1>Enter Youtube video link</h1>
    <?php if($e): ?>
    <h3 style="color: red"><?php echo $e; ?></h3>
    <?php endif; ?>
    <form style="margin: 20px">
        <input required type="text" style="width: 350px" name="yt_link" value="<?php echo $link; ?>"><br /><br />
        <button type="submit" name="quality" value="max">Max Resolution</button>
        <button type="submit" name="quality" value="hq">High Resolution</button>
        <button type="submit" name="quality" value="mq">Medium Resolution</button>
    </form>
    <?php if($img):?>
    <h2 style="color: green" id="loading_img">Loading Image, please wait ...</h2>
    <img onload="document.getElementById('loading_img').style.visibility = 'hidden'" src="<?php echo $img; ?>" style="max-width: 100%" />
    <?php endif; ?>
</div>

</body>
</html>