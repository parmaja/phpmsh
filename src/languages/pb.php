<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    "REGIS SCHWARTZ"  <http://pbadonf.monforum.net>
*
*/

  class pb_syn extends highlight_source_syn
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

    function do_open(&$line, &$i)
    {
        if ($this->state == S_NONE) {
            if (cmp($line, '//', $i)) {
                $this->state = S_SL_COMMENT;
            } else if (cmp($line, '/*', $i)) {
                $this->flag = 1;
                $this->state = S_ML_COMMENT;
            } else if (cmp($line, "'", $i)) {
                $this->state = S_SQ_STRING;
            } else if (cmp($line, '"', $i)) {
                $this->state = S_DQ_STRING;
            } else if (is_identifier_open($line{$i})) {
                $this->state = S_IDENTIFIER;
                $i++;
            }
        }
        return $this->state != S_NONE;
    }

    function do_scan(&$line, &$i)
    {
        switch ($this->state)
        {
            case S_DIRECTIVE:
                $this->do_IDENTIFIER($line, $i);
                break;

            case S_SL_COMMENT:
                $this->do_SL_COMMENT($line, $i);
                break;

            case S_ML_COMMENT:
                $this->do_ML_COMMENT($line, $i);
                break;

            case S_IDENTIFIER:
                $this->do_IDENTIFIER($line, $i);
                break;

            case S_VARIABLE:
                $this->do_IDENTIFIER($line, $i);
                break;

            case S_SQ_STRING:
                $this->do_SQ_STRING($line, $i, false);
                break;

            case S_DQ_STRING:
              $this->do_DQ_STRING($line, $i, false);
              break;
        }
     }
  }
?>