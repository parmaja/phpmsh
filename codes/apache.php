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

  class apache_syn extends plain_code_syn
  {
    var $keywords;
    function initialize(){
      $this->keywords = new keywords(false, array(
        'ServerRoot',
        'ScoreBoardFile',
        'PidFile',
        'Timeout',
        'KeepAlive',
        'MaxKeepAliveRequests',
        'KeepAliveTimeout',
        'LoadModule',
        'ExtendedStatus',
        'ServerAdmin',
        'ServerName',
        'UseCanonicalName',
        'DocumentRoot',
        'Options',
        'AllowOverride',
        'FollowSymLinks',
        'All',
        'MultiViews',
        'Indexes',
        'None',
        'Allow',
        'Order',
        'Deny',
        'From',
        'Listen',
        'UserDir',
        'ReadmeName',
        'HeaderName',
        'IndexIgnore',
        'Limit',
        'Action',
        'AuthConfig',
        'FileInfo ',
        'DirectoryIndex',
        'AccessFileName',
        'TypesConfig',
        'DefaultType',
        'ErrorLog',
        'LogLevel',
        'LogFormat',
        'CustomLog',
        'ServerTokens',
        'ServerSignature',
        'Alias',
        'AliasMatch',
        'SetEnvIf',
        'ScriptAlias',
        'IndexOptions',
        'AddIconByType',
        'AddIcon',
        'AddIconByEncoding',
        'DefaultIcon',
        'AddDescription',
        'AddLanguage',
        'LanguagePriority',
        'ForceLanguagePriority',
        'AddDefaultCharset',
        'AddCharset',
        'AddType',
        'AddHandler',
        'HostnameLookups',
        'AddOutputFilter',
        'BrowserMatch',
        'SetHandler',
        'NameVirtualHost')
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
          if ($ch=='#')
          {
            $this->state=S_COMMENT1;
            $out=$ch;
            $i++;
          }
          else if (is_identifier_open($ch))
          {
            $this->state=S_KEYWORD;
            $out=$ch;
            $i++;
         }
          else if ($ch=='\'')
          {
            $this->state=S_STRING;
            $out=$ch;
            $i++;
          }
          else if ($ch=='"')
          {
            $this->state=S_STRING2;
            $out=$ch;
            $i++;
          }
         else if ($ch=='<')
        {
            $this->state=S_OBJECT;
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
            case S_KEYWORD:
            {
              $j=$i;
              while ($j < $l)
              {
                if (!is_identifier($code{$j}))
                  break;
                $j++;
              }
              $this->close_state=$this->state;//close if string breaked
              $out.=substr($code, $i, $j - $i);
              $i=$j - 1;
              if (!$this->keywords->found($out))
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
                if ($code{$j}=='>')
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
            case S_STRING:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}=='\'' or $code{$j}=="\n")
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
            case S_STRING2:
            {
              $j=$i;
              while ($j < $l)
              {
                if ($code{$j}=='"' or $code{$j}=="\n")
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
