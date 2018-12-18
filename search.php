<?php

if (! isset($_POST["keyword"]))
{ exit("Access Denied"); }

// $ -> \$
$dict = array();

$keyword = $_POST["keyword"];
$mode = $_POST["mode"];
$length = strlen($keyword);
if ($length > 20)
{ exit("Your keyword is invalid."); }
$result = "";
$total = 0;

// $line = break|broke|broken|破碎 [breik] (n|v) 破碎
// $former = break|broke|broken|破碎
// $latter = [breik] (n|v) 破碎
// $list[0] = break
// $list[1] = broke
// $list[2] = broken
// $list[3] = 破碎

foreach ($dict as $line)
{ $pos = stripos($line, " [");
  $former = substr($line, 0, $pos);
  $latter = substr($line, $pos);
  $list = explode("|", $former);
  $lastdata = "";

  if ($mode == "smode")
  { foreach ($list as $word)
      if (strncasecmp($word, $keyword, $length) == 0)
      { $data = "<li>" . $list[0] . $latter . "</li>";
        if ($data != $lastdata)
        { $result .= $data;
          $lastdata = $data;
          $total++; } } }
  else
  { foreach ($list as $word)
      if (stripos($word, $keyword) > 0)
      { $data = "<li>" . $list[0] . $latter . "</li>";
        if ($data != $lastdata)
        { $result .= $data;
          $lastdata = $data;
          $total++; } } } }

if ($result != "")
{ echo $result;
  echo $total == 1 ? "<p>1 word found</p>" : "<p>$total words found</p>"; }
else
{ echo "<p>No word found</p>"; }

?>