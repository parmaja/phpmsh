<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*
*/

  class ini_syn extends plain_code_syn
  {
    function initialize(){
    }

    function highlight(&$code)
    {
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

          if ($ch=='#' or $ch==';')
          {
            $this->state=S_SL_COMMENT;
            $out=$ch;
            $i++;
          }
          else if ($ch=='=')
          {
            $this->state=S_VALUE;
            $out=$ch;
            $i++;
         }
          else if ($ch=='\'')
          {
            $this->state=S_STRING;
            $out=$ch;
            $i++;
          }
          else if ($ch=='"')
          {
            $this->state=S_DQ_STRING;
            $out=$ch;
            $i++;
          }
         else if ($ch=='[')
        {
            $this->state=S_OBJECT;
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
            case S_SL_COMMENT:
              $j=strpos($code,"\n",$i);
              if ($j===false)
                $j=$l-1;
              else
                $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i + 1);
              $i=$j;
              break;
            case S_KEYWORD:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}=='=')
                  break;
                $j++;
              }
              $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i);
              $i=$j - 1;
              break;
            }
            case S_VALUE:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}=='#' or $code{$j}==';' or $code{$j}=="\n")
                  break;
                $j++;
              }
              $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i);
              $i=$j - 1;
              break;
            }
            case S_OBJECT:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}==']' or $code{$j}=="\n")
                {
                  $this->close_state=$this->state;
                  break;
                }
                $j++;
              }
              $out.=substr($code, $i, $j - $i + 1);
              $i=$j;
              break;
            }
            case S_STRING:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}=='\'' or $code{$j}=="\n")
                {
                  $this->close_state=$this->state;
                  break;
                }
                $j++;
              }
              $out.=substr($code, $i, $j - $i + 1);
              $i=$j;
              break;
            }
            case S_DQ_STRING:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}=='"' or $code{$j}=="\n")
                {
                  $this->close_state=$this->state;
                  break;
                 }
                $j++;
              }
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