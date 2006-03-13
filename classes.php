<?
/***********************************************************************

  Copyright (C) 2004  zaher dirkey (zaher@parmaja.com)

  This file is part of phpMultiSyn.

  phpMultiSyn is free software; you can redistribute it and/or modify it
  under the terms of the GNU General Public License as published
  by the Free Software Foundation;

  phpMultiSyn is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston,
  MA  02111-1307  USA

************************************************************************/

//constants
  define('S_NONE',0);
  define('S_COMMENT1',1);
  define('S_COMMENT2',2);
  define('S_COMMENT3',3);
  define('S_STRING',4);
  define('S_STRING2',5);
  define('S_KEYWORD',6);
  define('S_SYMBOL',7);
  define('S_NUMBER',8);
  define('S_DIRECTIVE',9);
  define('S_OBJECT',10);
  define('S_IDENTIFIER',11);
  define('S_VARIABLE',12);
  define('S_VALUE',13);

//function for fast find keywords

class echo_output{
  function write(&$code)
  {
    echo $code;
  }
}

class variable_output{
  var $result = '';
  function write(&$code)
  {
    $this->result =  $this->result.$code;
  }
}

class file_output{
  var $file;
  function write(&$code)
  {
  }
}

class keywords{

  var $list = array();
  var $casesensitive = false;

  function keywords($casesensitive, $kw){

    sort($kw);
    $this->casesensitive = $casesensitive;
    if ($this->casesensitive)
      foreach ($kw as $v){
        $this->list[$v{0}][] = $v;
      }
    else
      foreach ($kw as $v){
        $this->list[$v{0}][] = strtolower($v);
      }
    }

    function find(&$keyword)
    {
      if (!$this->casesensitive)
        $keyword = strtolower($keyword);

      $a = $this->list[$keyword{0}];
      if (is_array($a))
        return array_search($keyword, $a);
      else
        return false;
    }

    function found(&$keyword){
      return $this->find($keyword)!==false;
    }
}

//common functions

function is_identifier_open($ch)
{
  if (($ch>='a' and $ch<='z') or ($ch>='A' and $ch<='Z') or ($ch=='_'))
    return true;
  else
    return false;
}
function is_identifier($ch)
{
  if (($ch>='a' and $ch<='z') or ($ch>='A' and $ch<='Z') or ($ch>='0' and $ch<='9') or ($ch=='_'))
    return true;
  else
    return false;
}

$cache_syn_objects = array();

//base class for all syn classes, or the plain class

  class plain_code_syn
  {
    var $output;
    var $styles;
    var $state=S_NONE;
    var $open_state=S_NONE;
    var $close_state=S_NONE;
    var $spaces = '  ';
/*  not implemented yet
    var $gatter_show = true;
    var $gatter_with = 10;
    var $gatter_start = 1;*/

    function plain_code_syn()
    {
      $this->styles = array(
        S_KEYWORD => array('<span class="syn_keyword">','</span>'),
        S_IDENTIFIER => array('<span class="syn_identifier">','</span>'),
        S_NUMBER => array('<span class="syn_number">','</span>'),
        S_STRING => array('<span class="syn_string">','</span>'),
        S_STRING2 => array('<span class="syn_string2">','</span>'),
        S_SYMBOL => array('<span class="syn_symbol">','</span>'),
        S_NUMBER => array('<span class="syn_number">','</span>'),
        S_OBJECT => array('<span class="syn_object">','</span>'),
        S_COMMENT1 => array('<span class="syn_comment1">','</span>'),
        S_COMMENT2 => array('<span class="syn_comment2">','</span>'),
        S_COMMENT3 => array('<span class="syn_comment3">','</span>'),
        S_DIRECTIVE => array('<span class="syn_directive">','</span>'),
        S_VARIABLE => array('<span class="syn_variable">','</span>'),
        S_VALUE => array('<span class="syn_value">','</span>')
      );

      if (method_exists($this, 'initialize'))
        $this->initialize();
    }

    function format_out(&$out)
    {
      $result = htmlspecialchars($out);
      return str_replace("\t", $this->spaces, $result);
    }

    function internal_echo(&$out)
    {
      if (isset($this->output))
        $this->output->write($out);
      else
        echo $out;
    }

    function text_out(&$out)
    {
        $out=$this->format_out($out);
        if ($this->open_state!=S_NONE)
        {
          $out=$this->styles[$this->open_state][0].$out;
          $this->open_state=S_NONE;
        }
        if ($this->close_state!=S_NONE)
        {
          $out=$out.$this->styles[$this->close_state][1];
          $this->open_state=S_NONE;
          $this->state=S_NONE;
        }
        $this->internal_echo($out);
        $out='';
    }

    function highlight(&$code) //virtual
    {
      $this->internal_echo($this->format_out($code));//plain code
    }

    //functions for helping standard languages
    function process_std_line_comment(&$i, &$l, &$code, &$out){
      $j = strpos($code,"\n",$i);
      if ($j === false)
        $j = $l - 1;
      else
        $this->close_state = $this->state;
        $out .= substr($code, $i, $j - $i + 1);
        $i = $j;
    }

    function process_std_double_quotes(&$i, &$l, &$code, &$out){
      $j = $i;
      while ($j < $l)
      {
        if ($code{$j} == '"')
          break;
        $j++;
      }
      $this->close_state = $this->state;
      $out .= substr($code, $i, $j - $i + 1);
      $i = $j;
    }

    function process_std_identifier(&$i, &$l, &$code, $keywords, &$out, $case_sensitive = true){
      $j = $i;
      while ($j < $l)
      {
        if (!is_identifier($code{$j}))
          break;
        $j++;
      }
      $this->close_state = $this->state;
      $out.=substr($code, $i, $j - $i);
      $i = $j - 1;
      if (!$this->keywords->found($out))
      {
        $this->state=S_NONE;
        $this->open_state=S_NONE;
        $this->close_state=S_NONE;
      }
    }

    function highlight_code(&$code)
    {
      $this->output = new variable_output;
      $this->highlight($code);
      $result = $this->output->result;
      unset($this->output);
      return $result;
    }

    function highlight_file($file)
    {
      set_time_limit(0);
      $f=fopen($file,'r');
      while (!feof($f))
      {
        $line=fgets($f);
        $this->highlight($line);
        flush();
      }
      fclose($f);
    }
  }
?>