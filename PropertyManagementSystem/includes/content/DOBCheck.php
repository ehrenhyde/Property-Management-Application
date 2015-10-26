<script>
	function checkDOB(){
		
		var age = 18;
		
		//get fields
		var dateField = document.getElementById('DOB');
		var warningField = document.getElementById('dateWarning');
		
		//get values
		var dateFieldVal = dateField.value;
		console.log('Date is ' + dateFieldVal);
		
		//cast entered date string to workable date object
		var myDate = new Date(dateFieldVal);

		//get the current date to compare to 
		var currdate = new Date();
		
		//calculate the date of the userss 18th birthday
		var setDate = new Date();        
		setDate.setFullYear(myDate.getFullYear() + age,myDate.getMonth()-1, myDate.getDate());

		//if current date is past their 18th birthday
		if ( currdate > setDate){
			//free up form
			warningField.style.visibility = 'hidden';
			btnSubmit.disabled=false;
		}else{
			//warn and restrict
			warningField.style.visibility = 'visible';
			btnSubmit.disabled=true;
		}
	}
	$(document).ready(function(){
		
		//get fields
		var dateField = document.getElementById('DOB');
		var btnSubmit = document.getElementById('btnSubmit');
		var warningField = document.getElementById('dateWarning');
		
		console.log(dateField);
		
		//start with disabled since they haven't selected a date yet
		btnSubmit.disabled=true;
		warningField.style.visibility = "hidden";
		
		//trigger the date checks when the datepicker is changed
		dateField.onpaste = checkDOB;
		dateField.oninput = checkDOB;
	});
</script>