<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*
*/


  class apache_syn extends highlight_source_syn
  {
    function initialize()
    {
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
        'VirtualHost',
        'NameVirtualHost')
      );
    }

    function do_open(&$line, &$i)
    {
        if ($this->state == S_NONE) {
            if (cmp($line, '#', $i)) {
                $this->state = S_SL_COMMENT;
            } else if (cmp($line, '<', $i)) {
                $this->state = S_SYMBOL;
            } else if (cmp($line, '</', $i)) {
                $this->state = S_SYMBOL;
            } else if (cmp($line, '>', $i)) {
                $this->state = S_SYMBOL;
            } else if (cmp($line, "\'", $i)) {
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

            case S_VALUE:
                $this->do_TO_EOL($line, $i);
                break;

            case S_SYMBOL:
                $this->do_SYMBOL($line, $i);
                break;

            case S_OBJECT:
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