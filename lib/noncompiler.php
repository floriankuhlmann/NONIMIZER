<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17.09.16
 * Time: 22:12
 */

setlocale(LC_ALL, 'de_DE.utf8');


/**
* noncompiler
* @author     FLORIAN KUHLMANN <fk neuesignale com>
*/


class noncompiler
{

    private $inputtext = "non";
    private $a_input = array();
    private $a_compiledtext = array();
    private $NON = array('n','o','n');

    
    /**
    * 
    * Setting the input text
    *
    * @param string $text text which will be non compiled
    */
    
    public function setInputText($text) {

        // input as pure textstring
        $this->inputtext = htmlspecialchars_decode($text);

        // input as array, with new line separations
        $this->a_input = explode(PHP_EOL, $text);
    }

    
    /**
    * 
    * Setting the input text
    *
    * @return array() with compiled text
    */
        
    public function compileText()
    {
        $noncount = 0;

        // scanning the input line by line, to keep newlines in the compiled text
        foreach($this->a_input as $inputtext) {

            // if we have newline (arrayfield == "") the wn just fill in <br><br> and continue to next line.
            if (strlen($inputtext) == 1) {
                $this->a_compiledtext[] = "<br><br>";
                continue;
            }

            // before we can read the line we transfor html specialchars
            $_a_input = $this->str_split_unicode(htmlspecialchars_decode($inputtext));

            // now compile every single character into the corresponding NON-part
            foreach($_a_input as $letter) {

                if ($noncount > 2) {
                    $noncount = 0;
                }

                $_NON = $this->NON[$noncount];

                // ctype has problems with specialcharacters.
                // for this reason we handle the german Sonderzeichen first at this point
                if(preg_match('[ä|Ä|ü|Ü|ö|Ö|ß]', $letter)) {

                    if(preg_match('[Ä|Ü|Ö]', $letter)) {
                        $this->a_compiledtext[] = strtoupper($_NON);
                    } else {
                        $this->a_compiledtext[] = $_NON;
                    }
                    $noncount++;
                    continue;
                }

                // if we have an uppercase we directly can transform the current NON-part to uppercase
                if (ctype_upper($letter)) {
                    $_NON = strtoupper($_NON);
                }

                // do we have punctation? keep it!
                if (ctype_punct($letter)) {
                    $this->a_compiledtext[] = $letter;
                    continue;
                }

                // do we have a space? keep it!
                if (ctype_space($letter)) {
                    $this->a_compiledtext[] = " ";
                    continue;
                }

                // do we have letters, numbers? transform into non
                if (ctype_graph($letter)) {
                    $this->a_compiledtext[] = $_NON;
                    $noncount++;
                    continue;
                }

            }

            $this->a_compiledtext[] = "<br>";

        }

    }

    /**
    * 
    * getting the input text
    *
    * @return string input text
    */
    
    public function getInputText() {

        return $this->inputtext;

    }
    
    /**
    * 
    * getting the input text
    *
    * @return array() input text
    */
    public function getInputTextAsArray() {

        return $this->a_input;

    }

    /**
    * 
    * getting the compiled text as array
    *
    * @return array() compiled text
    */

    public function getCompiledTextAsArray() {

        return $this->a_compiledtext;

    }

    /**
    * 
    * getting the compiled text as string
    *
    * @return string compiled text
    */

    public function getCompiledText() {

        return implode($this->a_compiledtext);

    }

    /**
    * a helping hands 
    * to get a proper unicode string split;
    *
    * @param $str string
    * @param $l int 
    * @return array() 
    */

    function str_split_unicode($str, $l = 0) {
        if ($l > 0) {
            $ret = array();
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
            return $ret;
        }
        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }


}