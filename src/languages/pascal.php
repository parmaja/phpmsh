<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*
*/

  class pascal_syn extends highlight_source_syn
  {
    function initialize()
    {
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

    function do_open(&$line, &$i)
    {
        if ($this->state == S_NONE) {
            if (cmp($line, '{$', $i)) {
                $this->state = S_DIRECTIVE;
            } else if (cmp($line, '//', $i)) {
                $this->state = S_SL_COMMENT;
            } else if (cmp($line, '{', $i)) {
                $this->flag = 0;
                $this->state = S_ML_COMMENT;
            } else if (cmp($line, '(*', $i)) {
                $this->flag = 1;
                $this->state = S_ML_COMMENT;
            } else if (cmp($line, '$', $i)) {
                $this->state = S_VARIABLE;
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
                if ($this->flag == 0)
                  $this->do_ML_COMMENT($line, $i, '}');
                else
                  $this->do_ML_COMMENT($line, $i, '*)');
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