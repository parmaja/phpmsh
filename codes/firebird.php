<?
/***********************************************************************

  Copyright (C) 2004  zaher dirkey (zaher@parmaja.com)

  This file is part of phpMultiSyn.

  phpMultiSyn is free software; you can redistribute it and/or modify it
  under the terms of the GNU General Public License as published
  by the Free Software Foundation;

  phpMultiSyn is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston,
  MA  02111-1307  USA

************************************************************************

  This syntax class writen by Zaher Dirkey zaher@parmaja.com

************************************************************************/

  class firebird_syn extends plain_code_syn
  {
    var $keywords;
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

          if ($ch=='-' and $next_ch=='-')
          {
            $this->state=S_COMMENT1;
            $out=$ch.$next_ch;
            $i++;
            $i++;
          }
          else if ($ch=='/' and $next_ch=='*')
          {
            $this->state=S_COMMENT2;
            $out=$ch.$next_ch;
            $i++;
            $i++;
          }
          else if (is_identifier_open($ch))
          {
            $this->state=S_KEYWORD;
            $out=$ch;
            $i++;
          }
          else if ($ch=='"')
          {
            $this->state=S_OBJECT;
            $out=$ch;
            $i++;
          }
          else if ($ch=='\'')
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
            case S_COMMENT1:
              $j=strpos($code,"\n",$i);
              if ($j===false)
                $j=$l-1;
              else
                $this->close_state=$this->state;
              $out.=substr($code, $i, $j - $i + 1);
              $i=$j;
              break;
            case S_COMMENT2:
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
              $j= $i;
              while ($j < $l)
              {
                if ((!is_identifier($code{$j})))
                  break;
                $j++;
              }
              
              $this->close_state=$this->state;//close if string breaked
              
              $out.=substr($code, $i, $j - $i);
              $i=$j - 1;
              if ($this->datatypes->found($out))
              {
                $this->open_state=S_DATATYPE;
              }
              else if (!$this->keywords->found($out))
              {
                $this->state=S_NONE;
                $this->open_state=S_NONE;
                $this->close_state=S_NONE;
              }
              break;
            }
            case S_OBJECT:
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
            case S_STRING:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}=='\'')
                {
                  $this->close_state=$this->state;
                  break;
                }
                $j++;
              }
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