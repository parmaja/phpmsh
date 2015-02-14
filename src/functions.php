<?php
/**
*   This file is part of the "SARD"
*
*   @license   The MIT License (MIT) Included in this distribution
*   @author    Zaher Dirkey <zaher at yahoo dot com>
*
*/

function get_class_syn($ext)
{
  $syn_class=$ext.'_syn';
  if (!class_exists($syn_class))
  {
    include_once(__DIR__.'/classes.php');
    $ext_file=__DIR__.'/languages/'.$ext.'.php';
    if (file_exists($ext_file))
      include_once($ext_file);
    else
      $syn_class='plain_code_syn';
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