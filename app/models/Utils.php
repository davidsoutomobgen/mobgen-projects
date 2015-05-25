<?php

class Utils {

    /**
     *
     * @param type $val
     * @param type $options
     * @return type
     */
    public static function date($val, $options = array()) {

        $default = array(
            'time' => true,
            'year' => false,
            'dayAbbreviated' => true,
            'monthAbbreviated' => true
        );
        $options = array_merge($default, $options);

        $string = 'EEE';
        if (!$options['dayAbbreviated'])
            $string .= 'E';
        $string .= ', d MMM';
        if (!$options['monthAbbreviated'])
            $string .= 'M';
        if ($options['year'])
            $string .= ' y';
        if ($options['time'])
            $string .= ' HH:mm';

        return _app()->dateFormatter->format($string, $val);
    }

    /**
     *
     * @param type $val
     * @param type $leadingZeros
     * @param type $decimals
     * @return type
     */
    public static function number($val, $leadingZeros = false, $decimals = 1) {
        if ($leadingZeros) {
            if ($decimals == 1)
                return _app()->numberFormatter->format('#,###.0', $val);
            elseif ($decimals == 2)
                return _app()->numberFormatter->format('#,###.00', $val);
        } else
            return _app()->numberFormatter->format('#,###.##', $val);
    }

    /**
     *
     * @param type $p
     * @param type $showSign
     * @param type $round
     * @return type
     */
    public static function percent($p, $showSign = false, $round = true, $showDecimals = true) {
        if ($round)
            $p = round($p, 4);
        if ($showDecimals) {
            if ($showSign)
                return Yii::app()->numberFormatter->format('###.00 %', $p);
            else
                return Yii::app()->numberFormatter->format('###.00', $p) * 100;
        } else {
            if ($showSign)
                return Yii::app()->numberFormatter->format('### %', $p);
            else
                return Yii::app()->numberFormatter->format('###', $p) * 100;
        }
    }

    /**
     *
     * @param type $to
     * @param type $subject
     * @param type $body
     * @param type $from
     * @param type $name
     * @return type
     */
    public static function sendEmail($to, $subject, $body, $from = null) {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->Host = 'localhost';
        $mailer->IsSMTP();
        if ($form)
            $mailer->From = $from;
        $mailer->AddAddress($to);
        $mailer->CharSet = 'UTF-8';
        $mailer->ContentType = 'text/html;charset=utf8';
        $mailer->Subject = $subject;
        $mailer->Body = $body;
        return $mailer->Send();
    }

    /**
     *
     * @param type $date
     * @return type
     */
    public static function relativeDate($date) {
        $date = strtotime($date);
        $appDate = date('Y-m-d', $date);

        if ($appDate == date('Y-m-d')) {
            return _t('Today ') . date('H:i', $date);
        } else if ($appDate == date('Y-m-d', time() - (24 * 60 * 60))) {
            return _t('Yesterday ') . date('H:i', $date);
        }
        return Utils::date(date('Y-m-d H:i', $date));
    }

    /**
     *
     * @param type $date
     * @param type $showTime
     * @return type
     */
    public static function relativeDatetime($date, $showTime = false) {
        $dateObj = new DateTime($date);
        $appDate = new DateTime();
        $interval = $appDate->diff($dateObj);

        if ($interval->m != 0) {
            if ($showTime)
                return $interval->format(_t('%m months and %d days ago at %H:%i'));
            return $interval->format(_t('%m months and %d days ago'));
        }
        else if ($interval->d != 0) {
            if ($showTime) {
                if ($interval->d == 1)
                    return $interval->format(_t('%d day ago at %H:%i'));
                return $interval->format(_t('%d days ago at %H:%i'));
            }
            if ($interval->d == 1)
                return $interval->format(_t('%d day ago'));
            return $interval->format(_t('%d days ago'));
        }
        else if ($interval->h != 0) {
            if ($interval->h == 1)
                return $interval->format(_t('%h hour ago'));
            return $interval->format(_t('%h hours ago'));
        }
        else if ($interval->i != 0) {
            if ($interval->i == 1)
                return $interval->format(_t('%i minute ago'));
            return $interval->format(_t('%i minutes ago'));
        }
        if ($interval->s == 1)
            return $interval->format(_t('%s second ago'));
        return $interval->format(_t('%s seconds ago'));
    }

    /**
     *
     * @param type $data
     */
    public static function jsonReturn($data) {
        header('Content-type: application/json');
        echo json_encode($data);
        _app()->end();
    }

    /**
     *
     * @param type $msg
     * @return type
     */
    public static function replaceSmileys($msg) {

        $smilies = array(':)', ':(', ':P', ';)', ':lol', ':thumbsup', ':laugh', ':ohmy', ':rolleyes', ':scared', ':sneaky', ':unsure', ':w00t', ':wub');
        $images = array('smile', 'sad', 'tongue', 'wink', 'lol', 'thumbsup', 'laugh', 'ohmy', 'rolleyes', 'scared', 'sneaky', 'unsure', 'w00t', 'wub');

        foreach ($images as &$image) {
            $image = CHtml::image(Utils::imageUrl("smileys/$image.gif"), $image);
        }

        return str_replace($smilies, $images, $msg);
    }

    /**
     * Registers a callback with an event using the event system application component.
     * @param string $event
     * @param mixed $subject
     * @param string $callback
     */
    public static function registerCallback($event, $subject, $callback) {
        _app()->eventSystem->$event = array($subject, $callback);
    }

    /**
     * Registers a callback with an event using the event system application component.
     * @param string $event
     * @param mixed $subject
     * @param string $callback
     */
    public static function registerNamedCallback($behavior, $event, $subject, $callback) {
        if (isset(_app()->eventSystem->$behavior)) {
            _app()->eventSystem->$behavior->$event = array($subject, $callback);
        }
    }

    /**
     * Triggers an event using the event system application component.
     * @param string $event
     * @param mixed $sender
     * @param array $params
     */
    public static function triggerEvent($event, $sender, $params = array()) {
        _app()->eventSystem->$event(new CEvent($sender, $params));
    }

    /**
     *
     * @param type $file
     * @param type $width
     * @param type $height
     * @param type $proportional
     * @param type $output
     * @param type $delete_original
     * @param type $use_linux_commands
     * @return type
     */
    public static function ImageResize($file, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false) {

        if ($height <= 0 && $width <= 0)
            return false;

        // Setting defaults and meta
        $info = getimagesize($file);
        $image = '';
        $final_width = 0;
        $final_height = 0;
        list($width_old, $height_old) = $info;

        // Calculating proportionality
        if ($proportional) {
            if ($width == 0)
                $factor = $height / $height_old;
            elseif ($height == 0)
                $factor = $width / $width_old;
            else
                $factor = min($width / $width_old, $height / $height_old);

            $final_width = round($width_old * $factor);
            $final_height = round($height_old * $factor);
        }
        else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
        }

        // Loading image to memory according to type
        switch ($info[2]) {
            case IMAGETYPE_GIF: $image = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG: $image = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG: $image = imagecreatefrompng($file);
                break;
            default: return false;
        }


        // This is the resizing/resampling/transparency-preserving magic
        $image_resized = imagecreatetruecolor($final_width, $final_height);
        if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
            $transparency = imagecolortransparent($image);

            if ($transparency >= 0) {
                $trnprt_indx = imagecolorat($image, 0, 0);
                $trnprt_color = imagecolorsforindex($image, $trnprt_indx);
                $transparency = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            } elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);

        // Taking care of original, if needed
        if ($delete_original) {
            if ($use_linux_commands)
                exec('rm ' . $file);
            else
                @unlink($file);
        }

        // Preparing a method of providing result
        switch (strtolower($output)) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }

        // Writing image according to type to the output destination
        switch ($info[2]) {
            case IMAGETYPE_GIF: imagegif($image_resized, $output);
                break;
            case IMAGETYPE_JPEG: imagejpeg($image_resized, $output, 100);
                break;
            case IMAGETYPE_PNG: imagepng($image_resized, $output);
                break;
            default: return false;
        }

        return true;
    }

    /**
     * Shorthand for Yii is ajax request code.
     */
    public static function isAjax() {
        return Yii::app()->request->isAjaxRequest;
    }

    /**
     * @return boolean Whether a user is logged in or not.
     */
    public static function isLoggedIn() {
        return !_user()->isGuest;
    }

    /**
     * Return the formatted value as a currency.
     * @param string $value
     * @return string the formatted value
     */
    public static function currency($value) {
        return Yii::app()->numberFormatter->format('¤ #,###,###.00', $value, 'EUR');
    }

    /**
     * Add days to a date
     * @param DateTime $date
     * @param int $days
     * @return string The formatted date
     */
    public static function daysAdd($date, $days) {
        $date = new DateTime($date);
        $date->add(new DateInterval('P' . $days . 'D'));

        return self::date($date->format('Y-m-d H:i:s'));
    }

    /**
     * 
     * @param type $str
     * @param type $start
     * @param type $length
     * @param type $append
     */
    public static function substrFromStart($str, $length, $append = '') {
        if (isset($str[$length])) {
            $str = mb_substr($str, 0, $length) . $append;
        }
        return $str;
    }

    public function isValidLang($language) {
        return in_array($language, array('en', 'nl'));
    }

    public static function getFileInfo($filepath) {
        preg_match('/[^?]*/', $filepath, $matches);
        $string = $matches[0];

        $pattern = preg_split('/\./', $string, -1, PREG_SPLIT_OFFSET_CAPTURE);

        $lastdot = $pattern[count($pattern) - 1][1];
        #now extract the filename using the basename function
        $filename = basename(substr($string, 0, $lastdot - 1));

        if (count($pattern) > 1) {
            $filenamepart = $pattern[count($pattern) - 1][0];
            preg_match('/[^?]*/', $filenamepart, $matches);
            $filename .= '.' . $matches[0];
        }

//        return array($filename, $matches[0]);
        return $filename;
    }

    public static function logArErrors($errors) {
        $output = '';
        foreach ($errors as $error) {
            $output .= $error . "\n";
        }
        return $output;
    }

    public static function fileList($dir, $ext) {
        $list = array();
        foreach (array_diff(scandir($dir), array('.', '..')) as $file) {
            if (is_file($dir . '/' . $file) && (($ext) ? ereg($ext . '$', $file) : 1))
                $list[] = $file;
        }
        return $list;
    }

    /**
     * Helpful function to include a css file in your application.
     * @param string $file
     */
    public static function registerCssFile($file) {
        _cs()->registerCSSFile(_tbu("css/{$file}.css"));
    }

    /**
     * Helpful function to include a module css file in your application.
     * @param string $module
     * @param string $file
     */
    public static function registerModuleCssFile($module, $file) {
        _cs()->registerCSSFile(self::moduleAssetUrl($module, "css/{$file}.css"));
    }

    /**
     * Helpful function to include a javascript file in your application.
     * @param string $file
     */
    public static function registerJsFile($file, $position = CClientScript::POS_END) {
        _cs()->registerScriptFile(_bu("js/{$file}.js"), $position);
    }

    /**
     * Helpful function to include a module javascript file in your application.
     * @param string $module
     * @param string $file
     */
    public static function registerModuleJsFile($module, $file, $position = CClientScript::POS_END) {
        _cs()->registerScriptFile(self::moduleAssetUrl($module, "js/{$file}.js"), $position);
    }

    /**
     * The function returns the url of an asset taking in consideration whether there is a theme active or not. Also, it force publishes
     * the assets when debug is on.
     * @param string $module Module name
     * @param string $asset Asset name
     * @return string Complete asset url
     */
    public static function moduleAssetUrl($module, $asset = '') {
        if (_app()->hasModule($module)) {
            return self::_assetUrl($module, $asset);
        }
        return '';
    }

    /**
     * @param string $module Module name
     * @param string $asset Asset name
     * @return string Complete asset url
     */
    private static function _assetUrl($module, $asset = '') {
        $alias = "$module.assets";
        if (_app()->theme) {
            $alias .= '.' . _app()->theme->name;
        }
        $assetUrl = _app()->assetManager->publish(Yii::getPathOfAlias($alias)) . '/' . $asset;
        return $assetUrl;
    }

    /**
     * @param string $image The image name/relative path
     * @return string The complete image url
     */
    public static function imageUrl($image) {
        return _bu("images/$image");
    }

    public static function videoUrl($video) {
        return _bu("videos/$video");
    }

    public static function inArrayRecursive($needle, $haystack) {

        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($haystack));

        foreach ($it AS $element) {
            if ($element == $needle) {
                return true;
            }
        }

        return false;
    }

    public static function isAssoc($array) {
        return (is_array($array) && count(array_filter(array_keys($array), 'is_string')) == count($array));
    }

    public static function moduleExists($module) {
        return array_key_exists($module, _app()->modules);
    }

    public static function parseVideoEntry($videoLink) {
        preg_match('/[\w-]{11}/', $videoLink, $matches);

        $feed = "http://gdata.youtube.com/feeds/api/videos/" . $matches[0];
        $entry = simplexml_load_file($feed);

        $obj = new stdClass;

        // get nodes in media: namespace for media information
        $media = $entry->children('http://search.yahoo.com/mrss/');
        $obj->title = $media->group->title;
        $obj->description = $media->group->description;

        // get video player URL
        $attrs = $media->group->player->attributes();
        $obj->watchURL = $attrs['url'];

        // get video thumbnail
        $attrs = $media->group->thumbnail[0]->attributes();
        $obj->thumbnailURL = $attrs['url'];

        // get <yt:duration> node for video length
        $yt = $media->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->duration->attributes();
        $obj->length = $attrs['seconds'];

        // get <yt:stats> node for viewer statistics
        $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->statistics->attributes();
        $obj->viewCount = $attrs['viewCount'];

        // get <gd:rating> node for video ratings
        $gd = $entry->children('http://schemas.google.com/g/2005');
        if ($gd->rating) {
            $attrs = $gd->rating->attributes();
            $obj->rating = $attrs['average'];
        } else {
            $obj->rating = 0;
        }

        // get <gd:comments> node for video comments
        $gd = $entry->children('http://schemas.google.com/g/2005');
        if ($gd->comments->feedLink) {
            $attrs = $gd->comments->feedLink->attributes();
            $obj->commentsURL = $attrs['href'];
            $obj->commentsCount = $attrs['countHint'];
        }

        //Get the author
        $obj->author = $entry->author->name;
        $obj->authorURL = $entry->author->uri;


        // get feed URL for video responses
        $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
        $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/
      2007#video.responses']");
        if (count($nodeset) > 0) {
            $obj->responsesURL = $nodeset[0]['href'];
        }

        // get feed URL for related videos
        $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
        $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/
      2007#video.related']");
        if (count($nodeset) > 0) {
            $obj->relatedURL = $nodeset[0]['href'];
        }

        // return object to caller  
        return $obj;
    }

    public static function xmlDecode($string) {
        $string = html_entity_decode($string);
        $string = str_replace("&apos;", "'", $string);
        return $string;
    }

    public static function bitly($link) {
        $res = Yii::app()->bitly->shorten($link)->getResponseData();
        $res = json_decode($res);
        if ($res->status_code == 200)
            return $res->data->url;
        return null;
    }

    public function toArray($data) {
        if (is_object($data))
            $data = get_object_vars($data);
        return $data;
    }

    public function getExtension($filename) {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    public function prettyJson($json, $options = array()) {
        $tokens = preg_split('|([\{\}\]\[,])|', $json, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = '';
        $indent = 0;

        $format = 'html';
        $ind = "    ";

        if (isset($options['format'])) {
            $format = $options['format'];
        }

        switch ($format) {
            case 'txt':
                $lineBreak = "\n";
                //$ind = "\t";
                $ind = "    ";
                break;
            default:
            case 'html':
                $lineBreak = '<br />';
                $ind = '&nbsp;&nbsp;&nbsp;&nbsp;';
                break;
        }

        // override the defined indent setting with the supplied option
        if (isset($options['indent'])) {
            $ind = $options['indent'];
        }

        $inLiteral = false;
        foreach ($tokens as $token) {
            if ($token == '') {
                continue;
            }

            $prefix = str_repeat($ind, $indent);
            if (!$inLiteral && ($token == '{' || $token == '[')) {
                $indent++;
                if (($result != '') && ($result[(strlen($result) - 1)] == $lineBreak)) {
                    $result .= $prefix;
                }
                $result .= $token . $lineBreak;
            } elseif (!$inLiteral && ($token == '}' || $token == ']')) {
                $indent--;
                $prefix = str_repeat($ind, $indent);
                $result .= $lineBreak . $prefix . $token;
            } elseif (!$inLiteral && $token == ',') {
                $result .= $token . $lineBreak;
            } else {
                $token = strip_tags($token);
                $result .= ( $inLiteral ? '' : $prefix ) . $token;

                // Count # of unescaped double-quotes in token, subtract # of
                // escaped double-quotes and if the result is odd then we are 
                // inside a string literal
                if ((substr_count($token, "\"") - substr_count($token, "\\\"")) % 2 != 0) {
                    $inLiteral = !$inLiteral;
                }
            }
        }
        return $result;
    }

}

?>
