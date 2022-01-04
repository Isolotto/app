<!DOCTYPE html>
<html>
<head>
  <title>UPD Isolotto</title>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon-precomposed" href="assets/icons/logo_32.png"/>
  <link rel="icon" href="assets/icons/logo_32.png" sizes="32x32" />
  <link rel="icon" href="assets/icons/logo_192.png" sizes="192x192" />
  <link rel="icon" href="assets/icons/logo_180.png" sizes="180x180" />

  <link rel="stylesheet" type='text/css' href="assets/iso-mobile.min.css" />
  <link rel="stylesheet" type='text/css' href="assets/jquery.mobile.icons.min.css" />
  <link rel="stylesheet" type='text/css' href="//code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> 
  <script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  <script type="text/javascript" charset="utf-8" src="cordova.js"></script>
</head>

<body>
<div data-role="page" data-theme="a">
  <div data-role="header" style="text-align:center">
    <img style="width:80%;margin:0 auto;" src="assets/mob-header.png" />
  </div>

  <div data-role="content">
    <a href="mob-programma1.html" data-role="button">Partite in programma</a>
    <a href="mob-programma3.html" data-role="button">Settimana seguente</a>

<?php
  require_once ('dbconnect.php');
  $sql="SELECT id,descrizione FROM categorie WHERE attiva ORDER BY id";
  $result=mysqli_query($conn,$sql) or die(mysql_error());

  echo "<div data-role='collapsible-set'>";
  while ($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $descr=$row['descrizione'];
    
    echo "<div data-role='collapsible' data-iconpos='right'><h3>" . utf8_encode($descr) . "</h3>";
    echo "<ul data-role='listview' data-theme='b' class='ui-alt-icon'>";

    $files=glob("mob-?" . $id . "*.html");
    foreach ($files as $file) {
      $h=fopen($file,"r");
      $line=stream_get_line($h,1024);
      $line=htmlentities($line,ENT_QUOTES);
      fclose($h);
      $ar=explode(",",$line);
      if (strtotime($ar[2]) + 24*3600 >= time()) {  
        $tipo=substr(basename($file),4,1);
        switch($tipo){
          case"A":
		        echo "<li><a href='" . $file  . "'>Calendario " . "</a></li>";
            break;
          case"B":
		        if ($id<400) echo "<li><a href='" . $file  . "'>Risultati" . "</a></li>";
            break;
          case"C":
		        if ($id<400) echo "<li><a href='" . $file  . "'>Classifica" . "</a></li>";
            break;
          case"D":
		        if ($id<400) echo "<li><a href='" . $file  . "'>Prossimo turno" . "</a></li>";
            break;
          case"E":
						echo "<li><a href='" . $file  . "'><span class='wrap-li'>Convocazione" . "</span></a></li>";
            break;
        }
      }
    }

    echo "</ul>";
    echo "</div>";    // collapsible
   }
    echo "</div>";    // collapsible-set

  if($result!=NULL) mysqli_free_result($result);
  mysqli_close($conn);
?>
  </div>      <!-- content -->
</div>      <!-- page -->
</body>
<html>
