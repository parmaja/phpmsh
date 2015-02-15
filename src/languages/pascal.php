<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*
*/

  class pascal_syn extends plain_code_syn
  {
    var $keywords;
    function initialize(){
      $this->keywords = new keywords(false, array(
          'and',
          'array',
          'as',
          'asm',
          'at',
          'automated',
          'begin',
          'case',
          'class',
          'const',
          'constructor',
          'deprecated',
          'destructor',
          'dispinterface',
          'div',
          'do',
          'downto',
          'else',
          'end',
          'except',
          'exports',
          'file',
          'finalization',
          'finally',
          'for',
          'function',
          'goto',
          'if',
          'implementation',
          'in',
          'inherited',
          'initialization',
          'inline',
          'interface',
          'is',
          'label',
          'library',
          'mod',
          'nil',
          'not',
          'object',
          'of',
          'on',
          'or',
          'out',
          'override',
          'packed',
          'private',
          'procedure',
          'program',
          'property',
          'protected',
          'public',
          'published',
          'raise',
          'record',
          'repeat',
          'resourcestring',
          'stdcall',
          'set',
          'shl',
          'shr',
          'string',
          'then',
          'threadvar',
          'to',
          'try',
          'type',
          'unit',
          'until',
          'uses',
          'var',
          'while',
          'with',
          'xor')
        );
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
          if ($ch=='{' and $next_ch=='$')
          {
            $this->state=S_DIRECTIVE;
            $out=$ch.$next_ch;
            $i++;
            $i++;
          }
          else if ($ch=='{')
          {
            $this->state=S_SL_COMMENT;
            $out=$ch;
            $i++;
          }
          else if ($ch=='/' and $next_ch=='/')
          {
            $this->state=S_ML_COMMENT;
            $out=$ch.$next_ch;
            $i++;
            $i++;
          }
           else if ($ch=='(' and $next_ch=='*')
          {
            $this->state=S_COMMENT3;
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
          else if ($ch=='\'')
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
            case S_DIRECTIVE:
              $j = strpos($code,'}',$i);
              if ($j===false)
                $j = $l - 1;//keep if not close
              else
                $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i + 1);
              $i = $j;
              break;
            case S_SL_COMMENT:
              $j=strpos($code,'}',$i);
              if ($j===false)
                $j=$l-1;//keep if not close
              else
                $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i + 1);
              $i=$j;
              break;
            case S_ML_COMMENT:
              $j=strpos($code,"\n",$i);
              if ($j===false)
                $j=$l-1;
              else
                $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i + 1);
              $i=$j;
              break;
            case S_COMMENT3:
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
              $j=$i;
              while ($j < $l)
              {
                if (!is_identifier($code{$j}))
                  break;
                $j++;
              }
              $this->close_state=$this->state;//close if string breaked
              $out.=substr($code, $i, $j - $i);
              $i=$j - 1;
              if (!$this->keywords->found($out))
              {
                $this->state=S_NONE;
                $this->open_state=S_NONE;
                $this->close_state=S_NONE;
              }
              break;
            }
            case S_STRING:
            {
              $j = $i;
              while ($j < $l)
              {
                if ($code{$j}=='\'')
                  break;
                $j++;
              }
              $this->close_state=$this->state;  //pascal or delphi is not multi line string like php
              $out.=substr($code, $i, $j - $i + 1);
              $i = $j;
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