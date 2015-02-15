<?php
/**
 *   This file is part of the "SARD"
 *
 *   @license   The MIT License (MIT) Included in this distribution
 *   @author    Zaher Dirkey <zaher at yahoo dot com>
 *
 */

//constants
define('S_NONE', 0);
define('S_SL_COMMENT', 1);
define('S_ML_COMMENT', 2);
define('S_STRING', 3);
define('S_DQ_STRING', 4);
define('S_KEYWORD', 5);
define('S_SYMBOL', 6);
define('S_NUMBER', 7);
define('S_DIRECTIVE', 8);
define('S_OBJECT', 9);
define('S_IDENTIFIER', 10);
define('S_VARIABLE', 11);
define('S_VALUE', 12);
define('S_DATATYPE', 13);

/**
 * return true if s is founded in text at index
 */
function cmp($text, $str, &$index)
{
    $r = (strlen($text) - $index) >= strlen($str);
    if ($r) {
        $w = substr($text, $index, strlen($str));
        $r = strcmp($w, $str) == 0; //case *in*sensitive
        if ($r)
            $index = $index + strlen($str);
    }
    return $r;
}

//function for fast find keywords

class echo_output
{
    function write(&$source)
    {
        echo $source;
    }
}

class variable_output
{
    var $result = '';
    function write(&$source)
    {
        $this->result = $this->result . $source;
    }
}

class file_output
{
    var $file;
    function write(&$source)
    {
    }
}

class keywords
{
    var $list = array();
    var $casesensitive = false;

    function keywords($casesensitive, $kw)
    {

        sort($kw);
        $this->casesensitive = $casesensitive;
        if ($this->casesensitive)
            foreach ($kw as $v) {
                $this->list[$v{0}][] = $v;
            } else
            foreach ($kw as $v) {
                $this->list[$v{0}][] = strtolower($v);
            }
    }

    function find($keyword)
    {
        if (empty($keyword))
          return false;
        if (!$this->casesensitive)
            $keyword = strtolower($keyword);

        if (array_key_exists($keyword{0}, $this->list)) {
            $a = $this->list[$keyword{0}];
            if (is_array($a))
                return array_search($keyword, $a);
            else
                return false;
        } else
            return false;
    }

    function found(&$keyword) //todo rename to exists
    {
        return $this->find($keyword) !== false;
    }
}

//common functions

function is_identifier_open($ch)
{
    if (($ch >= 'a' and $ch <= 'z') or ($ch >= 'A' and $ch <= 'Z') or ($ch == '_'))
        return true;
    else
        return false;
}

function is_identifier($ch)
{
    if (($ch >= 'a' and $ch <= 'z') or ($ch >= 'A' and $ch <= 'Z') or ($ch >= '0' and $ch <= '9') or ($ch == '_'))
        return true;
    else
        return false;
}

$cache_syn_objects = array();

//base class for all syn classes, or the plain class

class plain_source_syn
{
    var $output;
    var $styles;
    var $state = S_NONE;
    var $open_state = S_NONE;
    var $close_state = S_NONE;
    var $spaces = '  ';
    /*  not implemented yet
    var $gatter_show = true;
    var $gatter_with = 10;
    var $gatter_start = 1;*/

    function plain_source_syn()
    {
        $this->styles = array(
            S_KEYWORD => array(
                '<span class="syn_keyword">',
                '</span>'
            ),
            S_IDENTIFIER => array(
                '<span class="syn_identifier">',
                '</span>'
            ),
            S_NUMBER => array(
                '<span class="syn_number">',
                '</span>'
            ),
            S_STRING => array(
                '<span class="syn_sq_string">',
                '</span>'
            ),
            S_DQ_STRING => array(
                '<span class="syn_dq_string">',
                '</span>'
            ),
            S_SYMBOL => array(
                '<span class="syn_symbol">',
                '</span>'
            ),
            S_NUMBER => array(
                '<span class="syn_number">',
                '</span>'
            ),
            S_OBJECT => array(
                '<span class="syn_object">',
                '</span>'
            ),
            S_SL_COMMENT => array(
                '<span class="syn_sl_comment">',
                '</span>'
            ),
            S_ML_COMMENT => array(
                '<span class="syn_ml_comment">',
                '</span>'
            ),
            S_DIRECTIVE => array(
                '<span class="syn_directive">',
                '</span>'
            ),
            S_VARIABLE => array(
                '<span class="syn_variable">',
                '</span>'
            ),
            S_VALUE => array(
                '<span class="syn_value">',
                '</span>'
            ),
            S_DATATYPE => array(
                '<span class="syn_datatype">',
                '</span>'
            )
        );

        if (method_exists($this, 'initialize'))
            $this->initialize();
    }

    function format_out(&$token)
    {
        $result = htmlspecialchars($token);
        return str_replace("\t", $this->spaces, $result);
    }

    function internal_echo(&$token)
    {
        if (isset($this->output))
            $this->output->write($token);
        else
            echo $token;
    }

    function text_out(&$token)
    {
      $token = $this->format_out($token);

      if ($this->open_state != S_NONE)
        $token = $this->styles[$this->open_state][0] . $token;

      if ($this->close_state != S_NONE)
        $token = $token . $this->styles[$this->close_state][1];
 /*
        if ($this->open_state != S_NONE) {
            $token              = $this->styles[$this->open_state][0] . $token;
            $this->open_state = S_NONE;
        }

        if ($this->close_state != S_NONE) {
            $token              = $token . $this->styles[$this->close_state][1];
            $this->open_state = S_NONE;
            $this->state      = S_NONE;
        }
*/

        $this->internal_echo($token);
        $token = '';
    }

    function highlight(&$line) //virtual
    {
        $this->internal_echo($this->format_out($line)); //plain source
    }

    //functions for helping standard languages
    function do_SL_COMMENT(&$line, &$i)
    {
        $j = strpos($line, "\n", $i);
        if ($j === false)
            $j = strlen($line) - 1;
        else
            $this->close_state = $this->state;
        $i = $j;
    }

    function do_ML_COMMENT(&$line, &$i)
    {
        $j = strpos($line, '*/', $i);
        if ($j === false)
            $j = strlen($line) - 1;
        else
            $this->close_state = $this->state;
        $i = $j + 1;
    }

    function do_SQ_STRING(&$line, &$i)
    {
        while ($i < strlen($line)) {
            if (($line{$i} == "\\") and ($i + 1) < strlen($line) and (($line{$i + 1} == '"') or ($line{$i + 1} == '\'')))
                $i++;
            else if ($line{$i} == '\'') {
                $this->close_state = $this->state;
                $i++;//include close quotation
                break;
            }
            $i++;
        }
    }


    function do_DQ_STRING(&$line, &$i)
    {
      while ($i < strlen($line)) {
          if ($line{$i} == "\\") //escape \\
              $i++;
          else if ($line{$i} == '"') {
              $this->close_state = $this->state;
              $i++;//include close quotation
              break;
          }
          $i++;
      }
    }

    function do_IDENTIFIER(&$line, &$i)
    {
        while ($i < strlen($line)) {
            if (!is_identifier($line{$i}))
                break;
            $i++;
        }
        $this->close_state = $this->state;
    }

    function highlight_line(&$line)
    {
        $this->output = new variable_output;
        //because we can proceess the source as chunks so the hilighter wait a "\n" to end the line.
        //source must have EOL if not we add it
        if (substr($line, -1, 1) <> "\n")
            $line = $line . "\n";
        $this->highlight($line);
        $result = $this->output->result;
        unset($this->output);
        return $result;
    }

    function highlight_file($file)
    {
        set_time_limit(0);
        $f = fopen($file, 'r');
        while (!feof($f)) {
            $line = fgets($f);
            if (substr($line, -1, 1) <> "\n")
                $line = $line . "\n";
            $this->highlight($line);
            flush();
        }
        fclose($f);
    }
}

abstract class highlight_source_syn extends plain_source_syn
{
    var $keywords;

    abstract function do_open(&$source, &$i);
    abstract function do_scan(&$source, &$i);

    function highlight(&$source)
    {
        $l       = strlen($source);
        $index   = 0;
        while ($index < $l)
        {
            $i = $index;
            if ($this->state != S_NONE)
              $this->do_scan($source, $i);
            elseif ($this->do_open($source, $i)) {
                $this->open_state  = $this->state;
                $this->do_scan($source, $i);
            }
            else
              $i++;
            $token = substr($source, $index, $i - $index);

            if ($this->close_state == S_IDENTIFIER)
            {
                if (!$this->keywords->found($token)) {
                    $this->open_state  = S_KEYWORD;
                    $this->close_state = S_KEYWORD;
                }
            }

            $this->text_out($token);

            if ($this->close_state != S_NONE) {
              $this->state = S_NONE;
              $this->close_state = S_NONE;
            }
            $index = $i;
        }
    }
}
?>