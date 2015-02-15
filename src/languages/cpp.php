<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*
*/

  class cpp_syn extends highlight_source_syn
  {
    function initialize()
    {
/*      $this->directives = new keywords(true, array(
        '#define',
        '#elif',
        '#else',
        '#endif',
        '#error',
        '#if',
        '#ifdef',
        '#ifndef',
        '#include',
        '#line',
        '#pragma',
        '#printf',
        '#undef')
      );*/

    $this->keywords = new keywords(false, array(
      'define',
      'elif',
      'endif',
      'error',
      'ifdef',
      'ifndef',
      'include',
      'line',
      'pragma',
      'undef',
      'and',
      'and_eq',
      'asm',
      'auto',
      'bitand',
      'bitor',
      'bool',
      'break',
      'case',
      'catch',
      'char',
      'class',
      'compl',
      'const',
      'const_cast',
      'continue',
      'default',
      'delete',
      'do',
      'double',
      'dynamic_cast',
      'else',
      'enum',
      'explicit',
      'export',
      'extern',
      'false',
      'float',
      'for',
      'friend',
      'goto',
      'if',
      'inline',
      'int',
      'long',
      'mutable',
      'namespace',
      'new',
      'not',
      'not_eq',
      'operator',
      'or',
      'or_eq',
      'private',
      'protected',
      'public',
      'register',
      'reinterpret_cast',
      'return',
      'short',
      'signed',
      'sizeof',
      'static',
      'static_cast',
      'struct',
      'switch',
      'template',
      'this',
      'throw',
      'true',
      'try',
      'typedef',
      'typeid',
      'typename',
      'union',
      'unsigned',
      'using',
      'virtual',
      'void',
      'volatile',
      'wchar_t',
      'while',
      'xor',
      'xor_eq')
      );
    }

    function do_open(&$line, &$i)
    {
        if ($this->state == S_NONE) {
            if (cmp($line, '#', $i)) {
                $this->state = S_DIRECTIVE;
            } else if (cmp($line, '//', $i)) {
                $this->state = S_SL_COMMENT;
            } else if (cmp($line, '/*', $i)) {
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

            case S_SQ_STRING:
                $this->do_SQ_STRING($line, $i, true);
                break;

            case S_DQ_STRING:
              $this->do_DQ_STRING($line, $i, true);
              break;
        }
    }
  }
?>