<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*
*/

  class mssql_syn extends highlight_source_syn
  {
    function initialize(){
    $this->keywords = new keywords(false, array(
        'add',
        'all',
        'alter',
        'and',
        'any',
        'as',
        'asc',
        'authorization',
        'backup',
        'begin',
        'between',
        'break',
        'browse',
        'bulk',
        'by',
        'cascade',
        'case',
        'check',
        'checkpoint',
        'close',
        'clustered',
        'collate',
        'column',
        'commit',
        'compute',
        'constraint',
        'contains',
        'containstable',
        'continue',
        'create',
        'cross',
        'current',
        'cursor',
        'database',
        'dbcc',
        'deallocate',
        'declare',
        'default',
        'delete',
        'deny',
        'desc',
        'disk',
        'distinct',
        'distributed',
        'double',
        'drop',
        'dummy',
        'dump',
        'else',
        'end',
        'errlvl',
        'escape',
        'except',
        'exec',
        'execute',
        'exists',
        'exit',
        'fetch',
        'file',
        'fillfactor',
        'for',
        'foreign',
        'formsof',
        'freetext',
        'freetexttable',
        'from',
        'full',
        'function',
        'go',
        'goto',
        'grant',
        'group',
        'having',
        'holdlock',
        'identity',
        'identitycol',
        'identity_insert',
        'if',
        'in',
        'inflectional',
        'index',
        'inner',
        'insert',
        'intersect',
        'into',
        'is',
        'isabout',
        'join',
        'key',
        'kill',
        'left',
        'like',
        'lineno',
        'load',
        'national',
        'nocheck',
        'nonclustered',
        'not',
        'null',
        'nullif',
        'of',
        'off',
        'offsets',
        'on',
        'open',
        'opendatasource',
        'openquery',
        'openrowset',
        'openxml',
        'option',
        'or',
        'order',
        'outer',
        'over',
        'percent',
        'plan',
        'precision',
        'primary',
        'print',
        'proc',
        'procedure',
        'public',
        'raiserror',
        'read',
        'readtext',
        'reconfigure',
        'references',
        'replication',
        'restore',
        'restrict',
        'return',
        'revoke',
        'right',
        'rollback',
        'rowcount',
        'rowguidcol',
        'rule',
        'save',
        'schema',
        'select',
        'session_user',
        'set',
        'setuser',
        'shutdown',
        'some',
        'statistics',
        'table',
        'textsize',
        'then',
        'to',
        'top',
        'tran',
        'transaction',
        'trigger',
        'truncate',
        'tsequal',
        'union',
        'unique',
        'update',
        'updatetext',
        'use',
        'user',
        'values',
        'varying',
        'view',
        'waitfor',
        'weight',
        'when',
        'where',
        'while',
        'with',
        'writetext')
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
            } else if (cmp($line, '[', $i)) {
                $this->state = S_OBJECT;
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

            case S_OBJECT:
              $this->do_STRING($line, $i, "]");
              break;
        }
     }
  }
?>