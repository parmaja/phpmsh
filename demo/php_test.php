<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr">
<head>
<meta http-equiv="Content-Language" content="en-us" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="../syn.css" />
<title>Multi Syntax Highlighter Sample</title>
</head>
<body>
	<div class="syn_code">
		<pre>
<?
	include '../functions.php';
  highlight_filename_syn('firebird', realpath('../samples/firebird.txt'));
//  highlight_filename_syn('apache', realpath('../samples/apache.txt'));
//  highlight_filename_syn('php', realpath('../samples/php.txt'));
?>
		</pre>
		Ok this must a test.
	</div>
</body>
</html>