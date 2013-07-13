<?php
$host="localhost";
		$user="root";
		$pass="";
		$db="cd4";
		//connect
		$con=mysql_connect($host,$user,$pass);
		$dbcon=mysql_select_db($db,$con);
		
		function countysequip($county,$cat){
		$sql="SELECT COUNT( ID ) FROM  `equipmentdetails` WHERE  county ='$county' AND  `category` ='$cat' ";
		$query=mysql_query($sql);	
		$rs=mysql_fetch_row($query);
		return $rs[0];
		}
		
//facilities per county
function facilityspercounty($county){
	$sql="SELECT COUNT( f.AutoID ) FROM facility f, districts d WHERE d.ID = f.district AND d.county ='$county'";
	$q=mysql_query($sql) or die();
	$rw=mysql_fetch_row($q);
	return $rw[0];
}

//art facilities per county
function artpercounty($county){
	$sql="SELECT COUNT( f.AutoID ) FROM facility f, districts d,facilitys fs WHERE d.ID = f.district AND d.county ='$county' AND f.AutoID=fs.autofacility AND fs.ANC='Y'";
	$q=mysql_query($sql) or die();
	$rw=mysql_fetch_row($q);
	return $rw[0];
}

//pmct facilities per county
function pmctpercounty($county){
	$sql="SELECT COUNT( f.AutoID ) FROM facility f, districts d,facilitys fs WHERE d.ID = f.district AND d.county ='$county' AND f.AutoID=fs.autofacility AND fs.PMTCT='Y'";
	$q=mysql_query($sql) or die();
	$rw=mysql_fetch_row($q);
	return $rw[0];
}


//central Sites per county
function centralfacilityspercounty($county){
	$sql="SELECT COUNT( f.AutoID ) FROM facility f, districts d WHERE d.ID = f.district AND d.county ='$county' AND f.level=0";
	$q=mysql_query($sql) or die();
	$rw=mysql_fetch_row($q);
	return $rw[0];
}

//total patients in county
function patientspercounty($county){
		
	$sql="SELECT sum((f.oncare+f.ontreatment)) FROM facilitypatients f, districts d, facility fa WHERE fa.AutoID=f.facility AND d.ID = fa.district AND d.county ='$county'";
	$q=mysql_query($sql) or die();
	$rw=mysql_fetch_row($q);
	return $rw[0];	
}
			
		
?>


<map showBevel='0' showMarkerLabels='1' fillColor='F1f1f1' borderColor='000000' hoverColor='efeaef' canvasBorderColor='FFFFFF' baseFont='Verdana' baseFontSize='10' markerBorderColor='000000' markerBgColor='FF5904' markerRadius='6' legendPosition='bottom' useHoverColor='1' showMarkerToolTip='1'  showExportDataMenuItem='1' >

	<data>
	  <?php 
   $sql="select ID,name from countys ";
   $result=mysql_query($sql)or die(mysql_error());

$colors=array("FFFFCC"=>"1","E2E2C7"=>"2","FFCCFF"=>"3","F7F7F7"=>"5","FFCC99"=>"6","B3D7FF"=>"7","CBCB96"=>"8","FFCCCC"=>"9");

   while($row=mysql_fetch_array($result))
  {
  	 $countyid=$row['ID'];
   	 $countyname=trim($row['name']);
	 $sql=mysql_query("select province as provid from  countys where ID='$countyid'") or die(mysql_error());
	 $sqlarray=mysql_fetch_array($sql);
	 $provid=$sqlarray['provid'];
   ?>
		<entity  link='../cd4/homeprogram.php?id=<?php echo $countyid;?>' id='<?php echo $countyid;?>' displayValue ='<?php $countyname ?>' 
		toolText='<?php echo $countyname . " County";?> &lt;BR&gt;<?php echo "CD4 Equipment: ". countysequip($countyid,1); ?>
		&lt;BR&gt;<?php echo "Haematology Equipment: ". countysequip($countyid,3); ?>&lt;BR&gt;<?php echo "Chemistry Equipment: ". countysequip($countyid,5); ?>
		&lt;BR&gt;<?php echo "Central Sites: ". centralfacilityspercounty($countyid); ?>&lt;BR&gt;<?php echo "Total ART Sites: ". artpercounty($countyid); ?>
		&lt;BR&gt;<?php echo "Total PMTCT Sites: ". pmctpercounty($countyid); ?>&lt;BR&gt;<?php echo "Total Patients: ". patientspercounty($countyid); ?>'	color='<?php  echo array_rand($colors,1); ?>'  />
		
		facilityspercounty();
		
<?php
		}
?>		
		
	</data>
	
	
 
	
		<styles> 
  <definition>
   <style name='TTipFont' type='font' isHTML='1'  color='FFFFFF' bgColor='666666' size='11'/>
   <style name='HTMLFont' type='font' color='333333' borderColor='CCCCCC' bgColor='FFFFFF'/>
   <style name='myShadow' type='Shadow' distance='1'/>
  </definition>
  <application>
   <apply toObject='MARKERS' styles='myShadow' /> 
   <apply toObject='MARKERLABELS' styles='HTMLFont,myShadow' />
   <apply toObject='TOOLTIP' styles='TTipFont' />
  </application>
 </styles>
</map>