<?php
/**
 *   This file is part of the "SARD"
 *
 *   @license   The MIT License (MIT) Included in this distribution
 *   @author    Zaher Dirkey <zaher at yahoo dot com>
 *
 */

class php_syn extends highlight_code_syn
{
    var $keywords;
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

    function do_open(&$code, &$i)
    {
        if ($this->state == S_NONE) {
            if (cmp($code, '#', $i)) {
                $this->state = S_SL_COMMENT;
            } else if (cmp($code, '//', $i)) {
                $this->state = S_SL_COMMENT;
            } else if (cmp($code, '/*', $i)) {
                $this->state = S_ML_COMMENT;
            } else if (cmp($code, '$', $i)) {
                $this->state = S_VARIABLE;
            } else if (cmp($code, '\'', $i)) {
                $this->state = S_STRING;
            } else if (cmp($code, '\"', $i)) {
                $this->state = S_DQ_STRING;
            } else if (is_identifier_open($code{$i})) {
                $this->state = S_IDENTIFIER;
                $i++;
            }
        }
        return $this->state != S_NONE;
    }

    function do_scan(&$code, &$i)
    {
        switch ($this->state)
        {
            case S_SL_COMMENT:
                $j = strpos($code, "\n", $i);
                if ($j === false)
                    $j = strlen($code) - 1;
                else
                    $this->close_state = $this->state;
                $i = $j;
                break;

            case S_ML_COMMENT:
                $j = strpos($code, '*/', $i);
                if ($j === false)
                    $j = strlen($code) - 1;
                else
                    $this->close_state = $this->state;
                $i = $j + 1;
                break;

            case S_IDENTIFIER: {
                while ($i < strlen($code)) {
                    if (!is_identifier($code{$i}))
                        break;
                    $i++;
                }
                $this->close_state = $this->state; //close if string breaked

                break;
            }
            case S_VARIABLE: {
                while ($i < strlen($code)) {
                    if ((!is_identifier($code{$i})))
                        break;
                    $i++;
                }
                $this->close_state = $this->state;
                break;
            }
            case S_STRING: {
                while ($i < strlen($code)) {
                    if (($code{$i} == "\\") and ($i + 1) < strlen($code) and (($code{$i + 1} == '"') or ($code{$i + 1} == '\'')))
                        $i++;
                    else if ($code{$i} == '\'') {
                        $this->close_state = $this->state;
                        $i++;//include close quotation
                        break;
                    }
                    $i++;
                }
                break;
            }
            case S_DQ_STRING:
              while ($i < strlen($code)) {
                  if ($code{$i} == "\\") //escape \\
                      $i++;
                  else if ($code{$i} == '"') {
                      $this->close_state = $this->state;
                      $i++;//include close quotation
                      break;
                  }
                  $i++;
              }
              break;
        }
    }
}
?>