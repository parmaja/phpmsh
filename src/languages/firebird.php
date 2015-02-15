<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*
*/

  class firebird_syn extends highlight_source_syn
  {
    var $datatypes;

    function initialize(){
    $this->datatypes = new keywords(false, array(
      'integer',
      'varchar'
      )
    );
    
    $this->keywords = new keywords(false, array(
        'active',
        'add',
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
        'autoddl',
        'based',
        'basename',
        'base_name',
        'before',
        'begin',
        'between',
        'blobedit',
        'break',
        'buffer',
        'by',
        'cache',
        'case',
        'character_length',
        'char_length',
        'check',
        'check_point_len',
        'check_point_length',
        'coalesce',
        'collate',
        'collation',
        'column',
        'commit',
        'commited',
        'compiletime',
        'computed',
        'close',
        'conditional',
        'connect',
        'constraint',
        'containing',
        'continue',
        'create',
        'current',
        'current_date',
        'current_time',
        'current_connection',
        'current_timestamp',
        'current_transaction',
        'cursor',
        'database',
        'day',
        'db_key',
        'debug',
        'dec',
        'declare',
        'default',
        'delete',
        'desc',
        'descending',
        'describe',
        'descriptor',
        'disconnect',
        'distinct',
        'do',
        'domain',
        'drop',
        'echo',
        'edit',
        'else',
        'end',
        'entry_point',
        'escape',
        'event',
        'exception',
        'execute',
        'exists',
        'exit',
        'extern',
        'external',
        'extract',
        'fetch',
        'file',
        'filter',
        'first',
        'for',
        'foreign',
        'found',
        'from',
        'full',
        'function',
        'gdscode',
        'generator',
        'global',
        'goto',
        'grant',
        'group',
        'group_commit_wait',
        'group_commit_wait_time',
        'having',
        'help',
        'hour',
        'if',
        'immediate',
        'in',
        'inactive',
        'index',
        'indicator',
        'init',
        'inner',
        'input',
        'input_type',
        'insert',
        'int',
        'into',
        'is',
        'isolation',
        'isql',
        'join',
        'key',
        'last',
        'lc_messages',
        'lc_type',
        'leave',
        'left',
        'length',
        'lev',
        'level',
        'like',
        'logfile',
        'log_buffer_size',
        'log_buf_size',
        'longlockmanual',
        'maximum',
        'maximum_segment',
        'max_segment',
        'merge',
        'message',
        'minimum',
        'minute',
        'module_name',
        'month',
        'names',
        'national',
        'natural',
        'nchar',
        'new',
        'no',
        'noauto',
        'not',
        'null',
        'num_log_buffs',
        'num_log_buffers',
        'octet_length',
        'of',
        'old',
        'on',
        'only',
        'open',
        'option',
        'or',
        'order',
        'outer',
        'output',
        'output_type',
        'overflow',
        'page',
        'pagelength',
        'pages',
        'page_size',
        'parameter',
        'password',
        'plan',
        'position',
        'post_event',
        'precision',
        'prepare',
        'procedure',
        'protected',
        'primary',
        'privileges',
        'public',
        'quit',
        'raw_partitions',
        'read',
        'real',
        'record_version',
        'recreate',
        'references',
        'release',
        'reserv',
        'reserving',
        'retain',
        'return',
        'returning_values',
        'returns',
        'revoke',
        'right',
        'rollback',
        'rows_affected',
        'runtime',
        'savepoint',
        'schema',
        'second',
        'segment',
        'select',
        'set',
        'shadow',
        'shared',
        'shell',
        'show',
        'singular',
        'size',
        'snapshot',
        'some',
        'sort',
        'skip',
        'sql',
        'sqlcode',
        'sqlerror',
        'sqlwarning',
        'stability',
        'starting',
        'starts',
        'statement',
        'static',
        'statistics',
        'sub_type',
        'suspend',
        'table',
        'terminator',
        'then',
        'to',
        'transaction',
        'translate',
        'translation',
        'trigger',
        'trim',
        'type',
        'uncommitted',
        'union',
        'unique',
        'update',
        'updating',
        'user',
        'using',
        'value',
        'values',
        'variable',
        'varying',
        'version',
        'view',
        'wait',
        'weekday',
        'when',
        'whenever',
        'where',
        'while',
        'with',
        'work',
        'write',
        'year',
        'yearday')
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
              $this->do_IDENTIFIER($line, $i);
              break;
        }
     }
  }
?>