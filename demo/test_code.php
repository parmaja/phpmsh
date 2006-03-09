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
  $code='
program test;
var
        i:integer;
  x:integer;
begin
        for i:=0 to 10 do
  begin
           //do somthing here
  end;
end.';
  echo highlight_code_syn('pascal', $code);
?>
		</pre>
	</div>
</body>
</html>