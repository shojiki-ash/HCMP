<script type="text/javascript" charset="utf-8">
			
			$(document).ready(function() {
		 $( "#dialog" ).dialog({

         	autoOpen: false,
			height: 650,
			width:900,
			modal: true
		});	
				
				$(".ajax_call_1").click(function(){
			
		var url = "<?php echo base_url().'report_management/get_district_drill_down_detail'?>";	
		var id  = $(this).attr("id"); 				
        var option=$(this).attr("option"); 
        var date1=$(this).attr("date"); 
        var  date=encodeURI(date1);
      
	    ajax_request_special_(url+"/"+id+"/"+option+"/"+date,'district_div', date1);	
	    
	    });

    function ajax_request_special_(url,checker,date){
	var url =url;
	var checker=checker;
	
	var loading_icon="<?php echo base_url().'Images/loader.gif' ?>";
	 $.ajax({
          type: "POST",
          url: url,
          beforeSend: function() {
          	
          	if(checker=="main_div"){
          	 $("#test_a").html("<img style='margin-left:20%;' src="+loading_icon+">");	
          	}else{
          	 $('#dialog').html("");	
          	}
          	
           
          },
          success: function(msg) {
          	if(checker=="main_div"){	
          		
          $("#test_a").html(""); 	
          $("#test_a").html(msg); 
          
          }else{
          	
         $('#dialog').html(msg);
         $('#dialog').dialog({
         	title: 'HCMP Monthly roll out activity '+date,
         })
         $('#dialog').dialog('open');
    
          	
          }
          }
        }); 
}

   $('#container').highcharts({
            title: {
                text: 'Monthly User Access log for <?php echo date("F");?>',
                x: -20 //center
            },
            credits: { enabled:false},
            xAxis: {
                categories: <?php echo $category_data; ?>
            },
            yAxis: {
                title: {
                    text: '# of people who loggin'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [
            
            <?php  
                  foreach($series_data as $key=>$raw_data):
					 $temp_array=array();
					 echo "{ name: '$key', data:";
					 
					  foreach($raw_data as $key_data):
						$temp_array=array_merge($temp_array,array((int)$key_data));
						  endforeach;
					  echo json_encode($temp_array)."},";
					  
				   endforeach;
            
              ?>
          ]
        });
				
});
	</script>
	<div id="dialog"></div> 
	<?php echo $data ?>
	<div id="container"  style="height:80%; width: 100%; margin: 0 auto"></div>