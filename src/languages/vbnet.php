<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Hussein Rida husseinonline@engineer.com
*
*/

  class vbnet_syn extends plain_code_syn
  {
    var $keywords;
    function initialize(){
    $this->keywords = new keywords(false, array(
        'addhandler',
        'adressof',
        'alias',
        'and',
        'andalso',
        'ansi',
        'as',
        'assemply',
        'auto',
        'boolean',
        'byref',
        'byte',
        'byval',
        'call',
        'case',
        'catch',
        'cbool',
        'cbyte',
        'cchar',
        'cdate',
        'cdec',
        'cdbl',
        'char',
        'cint',
        'class',
        'clng',
        'cobj',
        'const',
        'cshort',
        'csng',
        'cstr',
        'ctype',
        'date',
        'decimal',
        'declare',
        'default',
        'delegate',
        'dim',
        'directcast',
        'do',
        'double',
        'each',
        'else',
        'elseif',
        'end',
        'enum',
        'erase',
        'error',
        'event',
        'exit',
        'false',
        'finally',
        'for',
        'friend',
        'function',
        'get',
        'gettype',
        'goto',
        'handles',
        'if',
        'implements',
        'imports',
        'in',
        'inherits',
        'integer',
        'interface',
        'is',
        'let',
        'lib',
        'like',
        'long',
        'loop',
        'me',
        'mod',
        'module',
        'mustinherit',
        'mustoverride',
        'mybase',
        'myclass',
        'namespace',
        'new',
        'next',
        'not',
        'nothing',
        'notinheritable',
        'notoverridable',
        'object',
        'on',
        'option',
        'optional',
        'or',
        'orelse',
        'overloads',
        'overridable',
        'overrides',
        'paramarray',
        'preserve',
        'private',
        'property',
        'protected',
        'public',
        'raiseevent',
        'readonly',
        'redim',
        'region',
        'removehandler',
        'resume',
        'return',
        'select',
        'set',
        'shadows',
        'shared',
        'short',
        'single',
        'static',
        'step',
        'stop',
        'strict',
        'string',
        'structure',
        'sub',
        'synclock',
        'then',
        'throw',
        'to',
        'true',
        'try',
        'typeof',
        'unicode',
        'untile',
        'variant',
        'when',
        'while',
        'with',
        'withevents',
        'writeonly',
        'xor',
        '#region',
        '#end',
        '#if',
        '#end',
        '#const')
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
          if ($ch=="'")
          {
            $this->state=S_SL_COMMENT;
            $out=$ch.$next_ch;
            $i++;
            $i++;
          }
          else if (is_identifier_open($ch) or ($ch=='#'))
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
                $this->process_std_identifier($i, $l, $code, $this->keywords, $out, false);
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