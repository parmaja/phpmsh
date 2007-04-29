<?
  function get_microtime()
  {
          list($usec, $sec) = explode(' ', microtime());
          return ((float)$usec + (float)$sec);
  }

  $a = array(
      'as', 'err', 'boolean', 'and', 'or', 'recordset', 'unload', 'to',
      'integer','long','single','new','database','nothing','set','close',
      'open','print','split','line','field','querydef','instrrev',
      'abs','array','asc','ascb','ascw','atn','avg','me',
      'cbool','cbyte','ccur','cdate','cdbl','cdec','choose','chr','chrb','chrw','cint','clng',
      'command','cos','count','createobject','csng','cstr','curdir','cvar','cvdate','cverr',
      'date','dateadd','datediff','datepart','dateserial','datevalue','day','ddb','dir','doevents',
      'environ','eof','error','exp',
      'fileattr','filedatetime','filelen','fix','format','freefile','fv',
      'getallstrings','getattr','getautoserversettings','getobject','getsetting',
      'hex','hour','iif','imestatus','input','inputb','inputbox','instr','instb','int','ipmt',
      'isarray','isdate','isempty','iserror','ismissing','isnull','isnumeric','isobject',
      'lbound','lcase','left','leftb','len','lenb','loadpicture','loc','lof','log','ltrim',
      'max','mid','midb','min','minute','mirr','month','msgbox',
      'now','nper','npv','oct','partition','pmt','ppmt','pv','qbcolor',
      'rate','rgb','right','rightb','rnd','rtrim',
      'second','seek','sgn','shell','sin','sln','space','spc','sqr','stdev','stdevp','str',
      'strcomp','strconv','string','switch','sum','syd',
      'tab','tan','time','timer','timeserial','timevalue','trim','typename',
      'ubound','ucase','val','var','varp','vartype','weekday','year',
      'appactivate','base','beep','call','case','chdir','chdrive','const',
      'declare','defbool','defbyte','defcur','defdate','defdbl','defdec','defint',
      'deflng','defobj','defsng','defstr','deftype','defvar','deletesetting','dim','do',
      'else','elseif','end','enum','erase','event','exit','explicit',
      'false','filecopy','for','foreach','friend','function','get','gosub','goto',
      'if','implements','kill','let','lineinput','lock','loop','lset','mkdir','name','next','not',
      'onerror','on','option','private','property','public','put','raiseevent','randomize',
      'redim','rem','reset','resume','return','rmdir','rset',
      'savepicture','savesetting','sendkeys','setattr','static','sub',
      'then','true','type','unlock','wend','while','width','with','write',
      'vbabort','vbabortretryignore','vbapplicationmodal','vbarray',
      'vbbinarycompare','vbblack','vbblue','vbboolean','vbbyte','vbcancel',
      'vbcr','vbcritical','vbcrlf','vbcurrency','vbcyan','vbdataobject',
      'vbdate','vbdecimal','vbdefaultbutton1','vbdefaultbutton2',
      'vbdefaultbutton3','vbdefaultbutton4','vbdouble','vbempty',
      'vberror','vbexclamation','vbfirstfourdays','vbfirstfullweek',
      'vbfirstjan1','vbformfeed','vbfriday','vbgeneraldate','vbgreen',
      'vbignore','vbinformation','vbinteger','vblf','vblong','vblongdate',
      'vblongtime','vbmagenta','vbmonday','vbnewline','vbno','vbnull',
      'vbnullchar','vbnullstring','vbobject','vbobjecterror','vbok','vbokcancel',
      'vbokonly','vbquestion','vbred','vbretry','vbretrycancel','vbsaturday',
      'vbshortdate','vbshorttime','vbsingle','vbstring','vbsunday',
      'vbsystemmodal','vbtab','vbtextcompare','vbthursday','vbtuesday',
      'vbusesystem','vbusesystemdayofweek','vbvariant','vbverticaltab',
      'vbwednesday','vbwhite','vbyellow','vbyes','vbyesno','vbyesnocancel',
      'vbnormal','vbdirectory'
     );


    sort($a);

    foreach ($a as $v)
    {
      $b[$v{0}][] = $v;
    }

//    print_r($b);

  function fast_search(&$v, &$b)
  {
    return in_array($v, $b[$v{0}]);
  }

/*  $v = 'implements';

  if (fast_search($v, $b))
  {
    echo $v." founded\n";
  }*/

  $r=100;
  $t1 = get_microtime();
  for ($i = 0; $i < $r; $i++)
  {
    foreach ($a as $v)
    {
      //if (in_array($v, $a))
      if (fast_search($v, $b))
      {
//        echo $v." founded\n";
      }
    }
  }

  $t2 = get_microtime();
  $avg = ($t2 - $t1) / $r;
  echo "\n\ntime: ".sprintf('%.5f', $avg)
?>