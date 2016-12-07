<head>
<script src="JS/jquery.min.js"> </script>
</head>

<style>
.output_div{border:1px solid #000; background-color:#CCC; margin:20px; width:500px; height:300px; font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;}
</style>

<script>
function ajax_get_command_output(output_target, command){
	 initial_output = $(output_target).html();
	 xhr = new XMLHttpRequest();
	 xhr.open("GET", "AJAX/ajax_call_os_commands.php?command="+command, true);
	 xhr.onprogress = function(e) {
	   //alert(e.currentTarget.responseText);
	   $(output_target).html(initial_output+e.currentTarget.responseText)
	 }
	 xhr.onreadystatechange = function() {
	   if (xhr.readyState == 4) {
		 //console.log("Complete = " + xhr.responseText);
		 $(output_target).html($(output_target).html() + "<br> Done!");
	   }
	 }
	 xhr.send();
}
  
  
$( document ).ready(function() {
	$(".ajax_button").click(function(){
		$(".ajax_output").html($(".ajax_output").html()+"<br>AJAX call star");
		ajax_get_command_output('.ajax_output','ping')
	})
})
</script>

<?php
require_once('MOD/connect.php');

$result = $conn->query("use heating");

$sql = "SELECT * from valves_status_now";
$result = $conn->query($sql);

if ($result->num_rows > 0) {    // output data of each row
?>

<input type="button" value="AJAX get" class="ajax_button" />
<div class="ajax_output output_div">
Output:
</div>


<table border=1>
	<tr>
		<td>id</td>
		<td>address</td>
		<td>battery</td>
		<td>mode</td>
		<td>motor</td>
		<td>temp_current</td>
		<td>temp_target</td>
		<td>temp_low</td>
		<td>temp_high</td>
		<td>temp_ofset</td>
		<td>pin</td>
	</tr>
<?php
    while($row = $result->fetch_assoc()) {
	echo "<tr><td>".$row["id"]."</td>";
	echo "<td>".$row["bt_address"]."</td>";
	echo "<td>".$row["battery"]."</td>";
	echo "<td>".$row["status_mode"]."</td>";
	echo "<td>".$row["status_motor"]."</td>";
	echo "<td>".$row["temp_current"]."</td>";
	echo "<td>".$row["temp_target"]."</td>";
	echo "<td>".$row["temp_low"]."</td>";
	echo "<td>".$row["temp_high"]."</td>";
	echo "<td>".$row["temp_offset"]."</td>";
	echo "<td>".$row["pin"]."</td>";
	echo "</tr>";
    }
} else {
    echo "0 results";
}
$conn->close();


?>


