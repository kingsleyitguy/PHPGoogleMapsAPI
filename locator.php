<?php include('inc/header.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Store Locator</title>
</head>
<body>
<div class="container">
        <h1>Smart Homes | Store Locator</h1>
        <div class="card"> 
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Enter Zip code: <input type='text' name='pin'/> 
        <input type='submit' name="send" value='Get location'/>
</form>
    
</div>
</body>

</html>
<?php
if(isset($_POST['send']))
{
	if(!empty($_POST['pin']) && filter_var($_POST['pin'], FILTER_VALIDATE_INT) == true)
	{
		getLongLatt($_POST['pin']);
	}
	else
	{
		echo"Please Enter a valid zip code";
	}
}

function getLongLatt($address) {

	$actual = $address;
	$address = urlencode(trim(preg_replace("/\s*\n*\([^)]*\)+/", " ", $address)));
	$url = 'https://maps.google.com/maps/api/geocode/json?address=' . ($address) . '&key=API_KEY_HERE';
	$a=file_get_contents($url);
	$data=json_decode($a,true);
	if($data['status']=="OK")
	{
	$dist=$data['results'][0]['address_components'][1]['long_name'];
	$state=$data['results'][0]['address_components'][2]['long_name'];
	$country=$data['results'][0]['address_components'][3]['long_name'];
	$lat=$data['results'][0]['geometry']['location']['lat'];
	$lng=$data['results'][0]['geometry']['location']['lng'];
	echo "Zip Code: $_POST[pin] <br> District: $dist <br> State: $state <br> Country :$country <br>";
	$map_url = "https://maps.google.com/maps?q=".$lat.",".$lng."&hl=es;z=14&amp;output=embed";
	echo "<iframe frameborder='0' src='$map_url' width='50%' height='50%'> </iframe>";
	}
	else
	{
		echo"No result found";
	}
	
	
	

}

?>
<?php include('inc/footer.php'); ?>
