<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*
*/

  class sql_syn extends highlight_source_syn
  {
    function initialize(){
    $this->keywords = new keywords(false, array(
    'active',
    'after',
    'all',
    'alter',
    'and',
    'any',
    'as',
    'asc',
    'ascending',
    'at',
    'auto',
    'base_name',
    'before',
    'begin',
    'between',
    'by',
    'cache',
    'cast',
    'check',
    'column',
    'commit',
    'committed',
    'computed',
    'conditional',
    'constraint',
    'containing',
    'count',
    'create',
    'current',
    'cursor',
    'database',
    'debug',
    'declare',
    'default',
    'delete',
    'desc',
    'descending',
    'distinct',
    'do',
    'domain',
    'drop',
    'else',
    'end',
    'entry_point',
    'escape',
    'exception',
    'execute',
    'exists',
    'exit',
    'external',
    'extract',
    'filter',
    'for',
    'foreign',
    'from',
    'full',
    'function',
    'generator',
    'grant',
    'group',
    'having',
    'if',
    'in',
    'inactive',
    'index',
    'inner',
    'insert',
    'into',
    'is',
    'isolation',
    'join',
    'key',
    'left',
    'level',
    'like',
    'merge',
    'names',
    'no',
    'not',
    'null',
    'of',
    'on',
    'only',
    'or',
    'order',
    'outer',
    'parameter',
    'password',
    'plan',
    'position',
    'primary',
    'privileges',
    'procedure',
    'protected',
    'read',
    'retain',
    'returns',
    'revoke',
    'right',
    'rollback',
    'schema',
    'select',
    'set',
    'shadow',
    'shared',
    'snapshot',
    'some',
    'suspend',
    'table',
    'then',
    'to',
    'transaction',
    'trigger',
    'uncommitted',
    'union',
    'unique',
    'update',
    'user',
    'using',
    'view',
    'wait',
    'when',
    'where',
    'while',
    'with',
    'work')
  );
}

    function do_open(&$line, &$i)
    {
        if ($this->state == S_NONE) {
            if (cmp($line, '#', $i)) {
                $this->state = S_DIRECTIVE;
            } else if (cmp($line, '--', $i)) {
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
                $this->do_TO_EOL($line, $i);
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