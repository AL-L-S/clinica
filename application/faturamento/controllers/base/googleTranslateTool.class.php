<?php

/* * *****************************************************************************
 * * Class: googleTranslateTool
 * * Purpose: Translate text using Google language tools
 * * Filename: googleTranslateTool.class.php
 * * Author: Gabriel Solomon
 * * Author Email: solomongaby @ yahoo . com
 * * Date: 1 July 2008
 * ****************************************************************************** */

class googleTranslateTool {

    var $langFrom = false; //language converting from
    var $langTo = false;  //language conveting to
    var $error = false;

    function __construct($langFrom = 'auto', $langTo = 'en') {

        $this->set_langFrom($langFrom);
        $this->set_langTo($langTo);
    }

    // Sets the from language in case you want to modify it along the way
    function set_langFrom($langFrom) {
        $this->langFrom = $langFrom;
    }

    // Sets the to language in case you want to modify it along the way
    function set_langTo($langTo) {
        $this->langTo = $langTo;
    }

    function return_langTo() {
        return $this->langTo;
    }

    function return_langFrom() {
        return $this->langFrom;
    }

    function return_languages() {
        $languages = array();
        $languages['ar'] = 'Arabic';
        $languages['bg'] = 'Bulgarian';
        $languages['zh-CN'] = 'Chinese';
        $languages['hr'] = 'Croatian';
        $languages['cs'] = 'Czech';
        $languages['da'] = 'Danish';
        $languages['nl'] = 'Dutch';
        $languages['en'] = 'English';
        $languages['fi'] = 'Finnish';
        $languages['fr'] = 'French';
        $languages['de'] = 'German';
        $languages['el'] = 'Greek';
        $languages['hi'] = 'Hindi';
        $languages['it'] = 'Italian';
        $languages['ja'] = 'Japanese';
        $languages['ko'] = 'Korean';
        $languages['pl'] = 'Polish';
        $languages['pt'] = 'Portuguese';
        $languages['pt-br'] = 'Brazilian Portuguese';
        $languages['ro'] = 'Romanian';
        $languages['ru'] = 'Russian';
        $languages['es'] = 'Spanish';
        $languages['sv'] = 'Swedish';

        return $languages;
    }

    // validates that the 2 languages are in the allowed languages
    function validate_langPair() {

        $languages = $this->return_languages();
        $langFrom = $this->return_langFrom();
        $langTo = $this->return_langTo();

        if (is_array($languages)) {

            if (!empty($langFrom)) {
                if (!isset($languages[$langFrom]) && $langFrom != 'auto')
                    $this->through_error('langFrom [' . $langFrom . '] is not in the allowed languages');
            }
            else
                $this->through_error('langFrom not set');

            if (!empty($langTo)) {
                if (!isset($languages[$langTo]))
                    $this->through_error('langTo [' . $langTo . '] is not in the allowed languages');
            }
            else
                $this->through_error('langTo not set');
        }
        else
            $this->through_error('Constructor not triggered - Languages array empty');
    }

    function through_error($errorMsg) {
        if ($this->error === false) {
            $this->error = $errorMsg;
        }
    }

    function return_error() {
        return $this->error;
    }

    // return false if an errro has been set 
    function check_continue() {
        if ($this->error === false)
            return true;
        else
            return false;
    }

    // translate a given text from and to the selecting language
    function translate_Text($text) {

        if (empty($text)) {
            $this->through_error('No text specified.');
            return false;
        }

        $this->validate_langPair();
        if ($this->check_continue() === false)
            return false;


        $url = "http://translate.google.com/translate_t";

        $postData = array();
        $postData['text'] = $text;
        $postData['langpair'] = $this->langFrom . "|" . $this->langTo;

        $RawHTML = $this->getData_Curl($url, $postData);
        var_dump($RawHTML);
        die;
        $RawHTML = $this->l_cut($RawHTML, '<div id=result_box dir="ltr">');
        $RawHTML = $this->r_cut($RawHTML, '</div>');

        $output = str_replace("&nbsp;", " ", $RawHTML); //this gets rid of the HTML no break spaces



        return strip_tags($output);
    }

    // translate a given URL from and to the selecting language
    function translate_URL($url) {

        if (empty($url)) {
            $this->through_error('No URL specified.');
            return false;
        } elseif (!eregi("^(https?://)?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-z_!~*'()-]+\.)*([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\.[a-z]{2,6})(:[0-9]{1,4})?((/?)|(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$", $url)) {
            $this->through_error('Not a valid URL format.');
            return false;
        }

        $this->validate_langPair();
        if ($this->check_continue() === false)
            return false;

        $langpair = $this->langFrom . "|" . $this->langTo;

        $url = 'http://66.102.9.104/translate_c?hl=ro&safe=off&ie=UTF-8&oe=UTF-8&prev=%2Flanguage_tools&langpair=' . $langpair . '&u=' . urlencode($url);
        $RawHTML = $this->getData_Curl($url);

        return $RawHTML;
    }

    // Using Curl to fetch the data
    function getData_Curl($url, $postData = false) {

        if (!extension_loaded('curl')) {
            $this->through_error('You need to load/activate the cURL extension (http://www.php.net/cURL).');
            return false;
        }

        $curlHandle = curl_init(); // init curl
        // options

        curl_setopt($curlHandle, CURLOPT_COOKIEJAR, "cookie");
        curl_setopt($curlHandle, CURLOPT_COOKIEFILE, "cookie");
        curl_setopt($curlHandle, CURLOPT_URL, $url); // set the url to fetch
        curl_setopt($curlHandle, CURLOPT_HEADER, 0); // set headers (0 = no headers in result)
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1); // type of transfer (1 = to string)
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 10); // time to wait in 
        curl_setopt($curlHandle, CURLOPT_POST, 0);
        if ($postData !== false) {
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($postData));
        }

        $content = curl_exec($curlHandle); // make the call

        curl_close($curlHandle); // close the connection       

        return $content;
    }

    function l_cut($text, $search, $offset = 0) {
        $pos = strpos($text, $search);
        if ($pos === false) {
            $subtext = $text;
        } else {
            $pos1 = $pos + strlen($search) + $offset;
            $subtext = substr($text, $pos1);
        }
        return $subtext;
    }

    function r_cut($text, $search) {
        $pos = strpos($text, $search);
        if ($pos === false)
            return $text;
        else
            return substr($text, 0, $pos);
    }

}

?>