<?php
$databasehost = "localhost";
$databasename = "survey";
//$databasetable = "facilities";
$databaseusername ="root";
$databasepassword = "";
$fieldseparator = ",";
$lineseparator = "\n";
//$csvfile = "RHFs/rtk_cd4/zone_d.csv";

$connect = mysql_connect("$databasehost", "$databaseusername","$databasepassword") 
or die('Cannot connect: ' . mysql_error());


mysql_select_db("$databasename");

   $sql="select * from counties ";
   $result=mysql_query($sql)or die(mysql_error());



   while($row=mysql_fetch_array($result))
  {
  	
	 $sql_1='select * from  mnh_midterm where y like "%'.$result['county'].'%"  ';
     $result_1=mysql_query($sql_1)or die(mysql_error());

  while ($row_1=mysql_fetch_array($result_1)){
  	$sql_2="update survey set y='".$result['county']."' where a='".$row_1['a']."'";
  	 mysql_query($sql_2) or die($sql_2.mysql_error());
	 echo $sql_2."<br>";
  }
  
	

  }




?>