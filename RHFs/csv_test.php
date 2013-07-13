<?php
$databasehost = "localhost";
$databasename = "kemsa";
$databasetable = "facilities";
$databaseusername ="root";
$databasepassword = "";
$fieldseparator = ",";
$lineseparator = "\n";
$csvfile = "RHFs/Book1.csv";
$connect = mysql_connect("$databasehost", "$databaseusername","$databasepassword") 
or die('Cannot connect: ' . mysql_error());
mysql_select_db("$databasename");
$addauto = 1;

$save = 1;
$outputfile = "output.sql";
/********************************/


if(!file_exists($csvfile)) {
echo "File not found. Make sure you specified the correct path.\n";
exit;
}

$file = fopen($csvfile,"r");

if(!$file) {
echo "Error opening data file.\n";
exit;
}

$size = filesize($csvfile);

if(!$size) {
echo "File is empty.\n";
exit;
}

$csvcontent = fread($file,$size);

fclose($file);

//include("db.php");

$lines = 0;
$queries = "";
$linearray = array();
$count=1;
foreach(explode($lineseparator,$csvcontent) as $line) {


$lines++;
$line = trim($line," \t");

$line = str_replace("\r","",$line);


$linearray = explode($fieldseparator,$line);
//sql for inserting to facilities
if(isset($linearray[6]) && $linearray[6]=="Baringo Central"){
$slq ='insert into facilities set `facility_code`="'.$linearray[0].'", `facility_name`="'.$linearray[1].'"
,`district` ="32",`owner`="'.$linearray[3].'",`level`="'.$linearray[12].'",`type`="'.$linearray[2].'"';
	
	//@mysql_query($slq,$connect) or die(mysql_error());
	echo $count.$slq."<br>";
}
//	if(isset($linearray[6]) && $count !=1){
//$slq ='update facilities set `drawing_rights`="'.$linearray[6].'" where `facility_code`="'.$linearray[2].'"';
	
//	@mysql_query($slq,$connect) or die(mysql_error());
//	echo $count.$slq."<br>";		
//} 
$count++;
//$linemysql = implode("','",$linearray);
//echo ($linemysql."<br>");

//exit("iko poa");

}
@mysql_close($connect);
/*if($addauto)
$query = "insert into $databasetable values('','$linemysql');";
else
$query = "insert into $databasetable values('$linemysql');";

$queries .= $query . "\n";

@mysql_query($query);
}

@mysql_close($con);

/*if($save) {

if(!is_writable($outputfile)) {
echo "File is not writable, check permissions.\n";
}

else {
$file2 = fopen($outputfile,"w");

if(!$file2) {
echo "Error writing to the output file.\n";
}
else {
fwrite($file2,$queries);
fclose($file2);
}
}

}*/

echo "Found a total of $lines records in this csv file.\n";


?>