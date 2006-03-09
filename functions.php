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

************************************************************************/

function get_class_syn($ext)
{
  $syn_class=$ext.'_syn';
  if (!class_exists($syn_class))
  {
    include_once(dirname(__FILE__).'/plan.php');
    $ext_file=dirname(__FILE__).'/codes/'.$ext.'.php';
    if (file_exists($ext_file))
      include_once($ext_file);
    else
      $syn_class='plan_code_syn';
  }
  return $syn_class;
}

function highlight_filename_syn($ext, $file)
{
  $syn_class=get_class_syn($ext);
  $syn=new $syn_class;
  $syn->highlight_file($file);
  unset($syn);
}

function highlight_code_syn($ext, $code)
{
  $syn_class = get_class_syn($ext);
  $syn = new $syn_class;
  return $syn->highlight_code($code);
}

?>