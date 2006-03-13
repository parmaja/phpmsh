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

  class vbscript_syn extends plain_code_syn
  {
    var $keywords;
    function initialize(){
    $this->keywords = new keywords(false, array(
      'abs',
      'add',
      'alias',
      'and',
      'archive',
      'array',
      'asc',
      'atendofline',
      'atendofstream',
      'atn',
      'attributes',
      'availablespace',
      'buildpath',
      'call',
      'case',
      'cbool',
      'cbyte',
      'ccur',
      'cdate',
      'cdbl',
      'cdrom',
      'chr',
      'cint',
      'clear',
      'clng',
      'close',
      'column',
      'comparemode',
      'compressed',
      'const',
      'copy',
      'copyfile',
      'copyfolder',
      'cos',
      'count',
      'createfolder',
      'createobject',
      'createtextfile',
      'csng',
      'cstr',
      'date',
      'dateaddfunction',
      'datecreated',
      'datediff',
      'datelastaccessed',
      'datelastmodified',
      'datepart',
      'dateserial',
      'datevalue',
      'day',
      'delete',
      'deletefile',
      'deletefolder',
      'description',
      'dictionary',
      'dim',
      'directory',
      'do',
      'drive',
      'drive',
      'driveexists',
      'driveletter',
      'drives',
      'drives',
      'drivetype',
      'else',
      'end',
      'eqv',
      'erase',
      'err',
      'exists',
      'exit',
      'exp',
      'file',
      'fileexists',
      'files',
      'files',
      'filesystem',
      'filesystemobject',
      'filter',
      'fix',
      'fixed',
      'folder',
      'folderexists',
      'folders',
      'for',
      'for each',
      'forappending',
      'formatcurrency',
      'formatdatetime',
      'formatnumber',
      'formatpercent',
      'forreading',
      'forwriting',
      'freespace',
      'function',
      'getabsolutepathname',
      'getbasename',
      'getdrive',
      'getdrivename',
      'getextensionname',
      'getfile',
      'getfilename',
      'getfolder',
      'getobject',
      'getparentfoldername',
      'getspecialfolder',
      'gettempname',
      'helpcontext',
      'helpfile',
      'hex',
      'hidden',
      'hour',
      'if',
      'imp',
      'inputbox',
      'instr',
      'instrrev',
      'int',
      'is',
      'isarray',
      'isdate',
      'isempty',
      'isnull',
      'isnumeric',
      'isobject',
      'isready',
      'isrootfolder',
      'item',
      'items',
      'join',
      'keys',
      'lbound',
      'lcase',
      'left',
      'len',
      'line',
      'loadpicture',
      'log',
      'loop',
      'ltrim',
      'mid',
      'minute',
      'mod',
      'month',
      'monthname',
      'move',
      'movefile',
      'movefolder',
      'msgbox',
      'name',
      'next',
      'normal',
      'not',
      'now',
      'number',
      'oct',
      'on error',
      'openastextstream',
      'opentextfile',
      'operator precedence',
      'option explicit',
      'or',
      'parentfolder',
      'path',
      'private',
      'public',
      'raise',
      'ramdisk',
      'randomize',
      'read',
      'readall',
      'readline',
      'readonly',
      'redim',
      'rem',
      'remote',
      'removable',
      'remove',
      'removeall',
      'replace',
      'rgb',
      'right',
      'rnd',
      'rootfolder',
      'round',
      'rtrim',
      'scriptengine',
      'scriptenginebuildversion',
      'scriptenginemajorversion',
      'scriptengineminorversion',
      'second',
      'select',
      'serialnumber',
      'set',
      'sgn',
      'sharename',
      'shortname',
      'shortpath',
      'sin',
      'size',
      'skip',
      'skipline',
      'source',
      'space',
      'split',
      'sqr',
      'strcomp',
      'string',
      'strreverse',
      'sub',
      'subfolders',
      'system',
      'systemfolder',
      'tan',
      'temporaryfolder',
      'textstream',
      'then',
      'time',
      'timeserial',
      'timevalue',
      'totalsize',
      'trim',
      'tristatefalse',
      'tristatetrue',
      'tristateusedefault',
      'type',
      'typename',
      'ubound',
      'ucase',
      'unknown',
      'vartype',
      'vbabort',
      'vbabortretryignore',
      'vbapplicationmodal',
      'vbarray',
      'vbbinarycompare',
      'vbblack',
      'vbblue',
      'vbboolean',
      'vbbyte',
      'vbcancel',
      'vbcr',
      'vbcritical',
      'vbcrlf',
      'vbcurrency',
      'vbcyan',
      'vbdataobject',
      'vbdate',
      'vbdecimal',
      'vbdefaultbutton1',
      'vbdefaultbutton2',
      'vbdefaultbutton3',
      'vbdefaultbutton4',
      'vbempty',
      'vberror',
      'vbexclamation',
      'vbfirstfourdays',
      'vbfirstfullweek',
      'vbfirstjan1',
      'vbformfeed',
      'vbfriday',
      'vbgeneraldate',
      'vbgreen',
      'vbignore',
      'vbinformation',
      'vbinteger',
      'vblf',
      'vblong',
      'vblongdate',
      'vblongtime',
      'vbmagenta',
      'vbmonday',
      'vbnewline',
      'vbno',
      'vbnull',
      'vbnullchar',
      'vbnullstring',
      'vbobject',
      'vbobjecterror',
      'vbok',
      'vbokcancel',
      'vbokonly',
      'vbquestion',
      'vbred',
      'vbretry',
      'vbretrycancel',
      'vbsaturday',
      'vbshortdate',
      'vbshorttime',
      'vbsingle',
      'vbsingle',
      'vbstring',
      'vbsunday',
      'vbsystemmodal',
      'vbtab',
      'vbtextcompare',
      'vbthursday',
      'vbtuesday',
      'vbusesystem',
      'vbusesystemdayofweek',
      'vbvariant',
      'vbverticaltab',
      'vbwednesday',
      'vbwhite',
      'vbyellow',
      'vbyes',
      'vbyesno',
      'vbyesnocancel',
      'volume',
      'volumename',
      'weekday',
      'weekdayname',
      'wend',
      'while',
      'windowsfolder',
      'write',
      'writeblanklines',
      'writeline',
      'xor',
      'year')
      );
    }

    function highlight(&$code)
    {
      $ch = '';
      $next_ch = '';
      $l = strlen($code);
      $out = '';
      $i = 0;
      while ($i < $l)
      {
        if ($this->state==S_NONE)
        {
          $ch = $code{$i};
          if ($i+1 < $l)
            $next_ch = $code{$i+1};
          else
            $next_ch = '';
          if ($ch=="'")
          {
            $this->state=S_COMMENT1;
            $out = $ch.$next_ch;
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
          else if ($ch=='"')
          {
            $this->state=S_STRING;
            $out=$ch;
            $i++;
          }
          else if (is_identifier_open($ch))
          {
            $this->state=S_KEYWORD;
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
            {
              $this->process_std_line_comment($i, $l, $code, $out);
              break;
            }
            case S_COMMENT2:
              $j=strpos($code,'*/',$i);
              if ($j===false)
                $j = $l - 1;
              else
                $this->close_state=$this->state;
              $out.=substr($code, $i, $j + 1 - $i + 1);
              $i=$j + 1;
              break;

            case S_STRING:
            {
              $this->process_std_double_quotes($i, $l, $code, $out);
              break;
            }

            case S_KEYWORD:
            {
              $this->process_std_identifier($i, $l, $code, $keywords, $out, false);
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