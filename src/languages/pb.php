<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    "REGIS SCHWARTZ"  <http://pbadonf.monforum.net>
*
*/

  class pb_syn extends plain_code_syn
  {
    var $datatypes;
    function initialize(){
    
     // V1 : dataypes = keywords 
    
    $this->datatypes = new keywords(false, array(
      'Blob',
      'Boolean',
      'Byte',
      'Char',
      'Character',
      'Date',
      'DateTime',
      'Dec',
      'Decimal',
      'Double',
      'Int',
      'Integer',
      'Long',
      'LongLong',
      'Real',
      'String',
      'Time',
      'UInt',
      'ULong',
      'UnsignedInt',
      'UnsignedInteger',
      'UnsignedLong'
          )
    );
*/
    $this->keywords = new keywords(false, array(
    
    // V1 : dataypes = keywords ------------------------------------------
      'blob',
      'boolean',
      'byte',
      'char',
      'character',
      'date',
      'datetime',
      'dec',
      'decimal',
      'double',
      'int',
      'integer',
      'long',
      'longlong',
      'real',
      'string',
      'time',
      'uint',
      'ulong',
      'unsignedint',
      'unsignedinteger',
      'unsignedlong',
     //------------------------------------------ 
      'alias',
      'and',
      'autoinstantiate',
      'call',
      'case',
      'catch',
      'choose',
      'close',
      'commit',
      'connect',
      'constant',
      'continue',
      'create',
      'cursor',
      'declare',
      'delete',
      'describe',
      'descriptor',
      'destroy',
      'disconnect',
      'do',
      'dynamic',
      'else',
      'elseif',
      'end',
      'enumerated',
      'event',
      'execute',
      'exit',
      'external',
      'false',
      'fetch',
      'finally',
      'first',
      'for',
      'forward',
      'from',
      'function',
      'global',
      'goto',
      'halt',
      'if',
      'immediate',
      'indirect',
      'insert',
      'into',
      'intrinsic',
      'is',
      'last',
      'library',
      'loop',
      'native',
      'next',
      'not',
      'of',
      'on',
      'open',
      'or',
      'parent',
      'post',
      'prepare',
      'prior',
      'private',
      'privateread',
      'privatewrite',
      'procedure',
      'protected',
      'protectedread',
      'protectedwrite',
      'prototypes',
      'public',
      'readonly',
      'ref',
      'return',
      'rollback',
      'rpcfunc',
      'select',
      'selectblob',
      'shared',
      'static',
      'step',
      'subroutine',
      'super',
      'system',
      'systemread',
      'systemwrite',
      'then',
      'this',
      'throw',
      'throws',
      'to',
      'trigger',
      'true',
      'try',
      'type',
      'until',
      'update',
      'updateblob',
      'using',
      'variables',
      'where',
      'while',
      'with',
      'within',
      '_debug'
      )
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

          if ($ch=='/' and $next_ch=='/')
          {
            $this->state=S_SL_COMMENT;
            $out=$ch.$next_ch;
            $i++;
            $i++;
          }
          else if ($ch=='/' and $next_ch=='*')
          {
            $this->state=S_ML_COMMENT;
            $out=$ch.$next_ch;
            $i++;
            $i++;
          }
          else if (is_identifier_open($ch))
          {
            $this->state = S_KEYWORD;
            $out = $ch;
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
          else
          {
            $out=$ch;
          }
          $this->open_state=$this->state;
          $this->close_state = S_NONE;
        }

        if ($this->state != S_NONE)
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
            case S_ML_COMMENT:
              $j=strpos($code,'*/',$i);
              if ($j===false)
                $j = $l - 1;
              else
                $this->close_state=$this->state;
              $out.=substr($code, $i, $j + 1 - $i + 1);
              $i=$j + 1;
              break;

            case S_KEYWORD:
            {
              $this->process_std_identifier($i, $l, $code, $this->keywords, $out);
              break;
            }
            
           case S_DATATYPE:
            {
              $this->process_std_identifier($i, $l, $code, $this->datatypes, $out);
              break;
            }
            
            case S_STRING:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}=="\\")
                  $j++;
                else if ($code{$j} == "\n") //break if eol
                  break;
                else if ($code{$j} == '\'')
                  break;
                $j++;
              }
              $this->close_state = $this->state;
              $out.=substr($code, $i, $j - $i + 1);
              $i=$j;
              break;
            }
            case S_DQ_STRING:
            {
              $j = $i;
              while ($j < $l)
              {
                if ($code{$j}=="\\" and !(($j + 1 < $l) and $code{$j} == "\n"))//escape but not multiline
                  $j++;
                else if ($code{$j} == "\n") //break if eol
                  break;
                else if ($code{$j}=='"')
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