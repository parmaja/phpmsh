<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html dir="ltr">
<head>
<meta http-equiv="Content-Language" content="en-us" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="../syn.css" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Multi Syntax Highlighter Samples</title>
</head>

<body>
<?
  include '../functions.php';
  $dir = "../samples/";
  if ($dh = opendir($dir)) {
    while (($file = readdir($dh)) !== false) {
      if (!is_dir($file)) {

?>
  <div class="language">
<?
echo basename($file, '.txt');

?>
</div>
<div class="syn_code">
        <pre>
<?
      highlight_filename_syn(basename($file, '.txt'), realpath($dir.$file));
?>
        </pre>
</div>
<?
      }
  }
       closedir($dh);
}
?>
 </body>
</html>