<?php
/**
 *   This file is part of the "SARD"
 *
 *   @license   The MIT License (MIT) Included in this distribution
 *   @author    Zaher Dirkey <zaher at yahoo dot com>
 *
 */

class php_syn extends highlight_source_syn
{
    function initialize()
    {
        $this->keywords = new keywords(false, array(
            'and',
            'or',
            'xor',
            '__FILE__',
            'exception',
            'php_user_filter',
            '__LINE__',
            'array',
            'as',
            'break',
            'case',
            'cfunction',
            'class',
            'const',
            'continue',
            'declare',
            'default',
            'die()',
            'do',
            'echo',
            'else',
            'elseif',
            'empty',
            'enddeclare',
            'endfor',
            'endforeach',
            'endif',
            'endswitch',
            'endwhile',
            'eval',
            'exit',
            'extends',
            'for',
            'foreach',
            'function',
            'global',
            'if',
            'include',
            'include_once',
            'isset',
            'list',
            'new',
            'old_function',
            'print',
            'require',
            'require_once',
            'return',
            'static',
            'switch',
            'unset',
            'use',
            'var',
            'while',
            '__FUNCTION__',
            '__CLASS__',
            '__METHOD__'
        ));
    }

    function do_open(&$line, &$i)
    {
        if ($this->state == S_NONE) {
            if (cmp($line, '#', $i)) {
                $this->state = S_SL_COMMENT;
            } else if (cmp($line, '//', $i)) {
                $this->state = S_SL_COMMENT;
            } else if (cmp($line, '/*', $i)) {
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
                $this->do_SQ_STRING($line, $i);
                break;

            case S_DQ_STRING:
              $this->do_DQ_STRING($line, $i);
              break;
        }
    }
}
?>