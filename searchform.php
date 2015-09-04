<form method="get" action="">
	<fieldset>
		Address<br><input type="text" id="searchinput" name="searchinput">
		<input type="submit" value="Search" action="" method="get"/><br>
		<table>
			<tr><td>Property Type</td><td>Min Bed</td><td>Max Bed</td><td>Min Price</td><td>Max Price</td></tr>
		</table>
		<select id="propertytype" name="propertytype">
			<option value="any">Any</option>
			<option value="wholehouse">Whole House</option>
			<option value="sharehouse">Share House</option>
		</select>
		<select name="Min Bed">
			<option value="Any">Any</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<select name="Max Bed">
			<option value="Any">Any</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<select name="Min Price">
			<option value="Any">Any</option>
			<option value="50000">50000</option>
			<option value="100000">100000</option>
			<option value="200000">200000</option>
			<option value="300000">300000</option>
			<option value="400000">400000</option>
			<option value="500000">500000</option>
			<option value="1000000">1000000</option>
		</select>
		<select name="Max Price">
			<option value="Any">Any</option>
			<option value="50000">50000</option>
			<option value="100000">100000</option>
			<option value="200000">200000</option>
			<option value="300000">300000</option>
			<option value="400000">400000</option>
			<option value="500000">500000</option>
			<option value="1000000">1000000</option>
		</select>
	</fieldset>
</form>