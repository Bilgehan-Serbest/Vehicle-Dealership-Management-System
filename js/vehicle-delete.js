function deletePrompt(){
	vehicle_to_delete_id = document.getElementById("vehicle_delete_option").getAttribute("value");		
	alert("Id to delete " + vehicle_to_delete_id);
	if(confirm('Sure To Remove This Record ?'))
	 {
	  window.location.href='delete_vehicle.php?id='+vehicle_to_delete_id;
	 }
};