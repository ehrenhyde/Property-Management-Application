<?php

function ctrl_input_field($errors, $inputType,$isRequired,$name, $labelText,$className,$originalValue=null){

	$divClassName;
	if ('REQUIRED' == $isRequired){
		$divClassName = 'requiredField';
	}else{
		$divClassName = 'optionalField';
	}
	
	echo "<div class = '$divClassName'>";
	
	$value;
	if (sent_value($name)!=null){
		$value = sent_value($name);
	}else{
		$value = $originalValue;
	}
	
	
	if ('hidden' != $inputType){
		//checkboxes look better if the box is on the left
		if ('checkbox' != $inputType){
			label($name,$labelText);
			echo "<input type =\"$inputType\" id = \"$name\" name = \"$name\" value = \"$value\" class = \"$className\"/>";
		}else{
			echo "<input type =\"$inputType\" id = \"$name\" name = \"$name\" value = \"$value\" class = \"$className\"/>";
			label($name,$labelText);
		}
		error_label($errors,$name);
	}else{//hidden fields don't have labels or error labels
		echo "<input type =\"$inputType\" id = \"$name\" name = \"$name\" value = \"$value\" class = \"$className\"/>";
	}
	
	echo '</div>';
	
}

function ctrl_select($errors,$name,$values,$className,$useDisplayAsValue = false){
	echo "<select id = \"$name\" name = \"$name\">";
	
	foreach ($values as $value => $display){
		if ($useDisplayAsValue){
			$value = $display;
		}
		$selected;
		if (sent_value($name) == $value){
			$selected = 'selected = "selected"';
		}else{
			$selected = '';
		}
		echo "<option $selected value=\"$value\">$display</option>";
	}
	echo '</select>';
	
	error_label($errors,$name);
}

function ctrl_input_radio($errors,$name,$values,$labels,$className,$defaultValue){
	//check to see if any field values where posted

	$useDefault = true;
	$sent_value = sent_value($name);
	if (isset($sent_value)==true){
		$useDefault = false;
	}
	for($iV = 0;$iV<count($values);$iV++){
		$checked;
		if(sent_value($name) == $values[$iV] || ($useDefault ==true && $defaultValue == $values[$iV])){
			$checked = 'checked';
		}else{
			$checked = '';
		}
		echo "<input id=\"r-{values[$iV]}\" type=\"radio\" name=\"$name\" value=\"$values[$iV]\" $checked>";
        echo "<label for='r-{values[$iV]}'>$labels[$iV]</label>";
        echo '<br/>';
	}
}

function ctrl_submit($value = 'Submit',$id = 'btnSubmit'){
	echo "<input id = $id type = 'submit' name = 'submit' value = $value />";
	echo '<br>';
}

function label($name,$labelText){
	echo "<label for=\"$name\">$labelText</label>";
}

function error_label($errors,$name){
	if (isset($errors[$name])){
		echo "<span class = 'error'>$errors[$name]</span>";
	}
}

function sent_value($name){
	if (isset($_POST[$name])){
		return htmlspecialchars($_POST[$name]);
	}elseif(isset($_GET[$name])){
		return htmlspecialchars($_GET[$name]);
	}else{
		return null;
	}
}

?>