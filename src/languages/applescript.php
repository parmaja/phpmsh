<?php
/**
*   This file is part of the "phpMSH"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*/

  This syntax class writen by Zaher Dirkey zaher@parmaja.com
  thanks to Ray Barber for help

************************************************************************/

  class applescript_syn extends plain_code_syn
  {
    var $keywords;
    function initialize(){
      $this->keywords = new keywords(false, array(
        'if',
        'else',
        'of',
        'to',
        'every',
        'tell',
        'property',
        'set',
        'select',
        'on',
        'end'
        )
      );
    }

    function highlight(&$code)
    {
      $InPropertyName=false;
      $DoPropertyName=false;
      $ch = '';
      $next_ch = '';
      $l=strlen($code);
      $out='';
      $i=0;
      while ($i < $l)
      {
        if ($this->state==S_NONE)
        {
          $ch = $code{$i};
          if ($i+1 < $l)
            $next_ch = $code{$i+1};
          else
            $next_ch = '';
          if ($ch=='-' and $next_ch=='-')
          {
            $this->state=S_COMMENT1;
            $out=$ch.$next_ch;
            $i++;
            $i++;
          }
           else if ($ch=='(' and $next_ch=='*')
          {
            $this->state=S_COMMENT2;
            $out=$ch.$next_ch;
            $i++;
            $i++;
          }
          else if (is_identifier_open($ch))
          {
            $this->state=S_KEYWORD;
            $out=$ch;
            $i++;
          }
          else if ($ch=='"')
          {
            $this->state=S_STRING;
            $out=$ch;
            $i++;
          }
          else
          {
            $out=$ch;
          }
          $this->open_state=$this->state;
          $this->close_state=S_NONE;
        }

        if ($this->state!=S_NONE)
        {
          switch ($this->state)
          {
            case S_COMMENT1:
              $j=strpos($code,"\n",$i);
              if ($j===false)
                $j=$l-1;
              else
                $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i + 1);
              $i=$j;
              break;
            case S_COMMENT2:
              $j=strpos($code,'*)',$i);
              if ($j===false)
                $j = $l - 1;
              else
                $this->close_state=$this->state;
              $out.=substr($code, $i, $j + 1 - $i + 1);
              $i=$j + 1;
              break;
            case S_KEYWORD:
            {
              $j= $i;
              while ($j < $l)
              {
                if ((!is_identifier($code{$j})))
                  break;
                $j++;
              }
              $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i);
              $i=$j - 1;
              if (!$this->keywords->found($out))
              {
                if ($InPropertyName===true)
                {
                  $this->open_state=S_IDENTIFIER;
                  $this->close_state=S_IDENTIFIER;
                  $InPropertyName=false;
                 }
                  else
                {
                  $this->state=S_NONE;
                  $this->open_state=S_NONE;
                  $this->close_state=S_NONE;
                }
              }
              else
              {
                if ($out=='property')
                  $InPropertyName=true;
                else
                  $InPropertyName=false;
              }
              break;
            }
            case S_STRING:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}=='"')
                  break;
                $j++;
              }
              $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i + 1);
              $i=$j;
              break;
            }
          }
        }
        $this->text_out($out);
        $i++;
      }
    }
  }
?>