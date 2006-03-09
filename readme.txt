php Multi Syntax Highlighter will "beautify" PHP, Pascal, Delphi and
Applescript source code. It is not implemented like other beautifiers, as it
does not use pcre function or ereg functions , and allows  syntax code continually
line by line to reduce memory usage.  For example, to change highlight
colors, open "colors.php" and edit $this->settings array. You can also change
the font in function "highlight_code".

You can write your favorite code syntax, however keep in mind not use long
string variables to prevent large memory usage or crashing.  If you wish,
send me list of Keywords and string rules with samples and email them to me.
I will make a new class to support your favorite language and send add them
to the package.

zaher dirkey 
zaher@parmaja.com