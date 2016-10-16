<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>arrayDemo</title>
</head>
	<h1> Array Demo </h1>
    <?php
		$arraySize = $_POST['arraySize'];
		$minRandomValue = $_POST['minRandomValue'];
		$maxRandomValue = $_POST['maxRandomValue'];
		//$ranNumber = int rand(int $minRandomValue, int $maxRandomValue);
		
		
		$ArrayRan = array();
		
		for($i = 1; $i <= $arraySize; $i++)
		{
			$ArrayRan[] = rand($minRandomValue, $maxRandomValue);
		}
		foreach($ArrayRan as $item)
		{
			$absoluteValItem = abs($item);
			$squareRoot = sqrt($absoluteValItem);
			
			$squaredItem = pow($item, 2);
			
			$ranExponent = rand(0, 5);
			$randExpItem = pow($item, $ranExponent);
			
			if($item > 0)
			{
				echo nl2br(" \n\nThe element " . $item . " is POSITIVE. \n");	
			}
			elseif($item == 0)
			{
				echo nl2br(" \n\nThe element " . $item . " is ZERO. \n");	
			}
			else
			{
				print nl2br(" \n\nThe element " . $item . " is NEGATIVE. \n");	
			}
			
			$areaCircle = pow($absoluteValItem, 2) * M_PI;
			
			$absDiamToRadius = abs($absoluteValItem / 2);
			$areaSphere = pow($absDiamToRadius, 3) * M_PI * (4/3);
			
			echo" Square root of absolute value of " .  $item . " is: " .  $squareRoot ."<br>";
			echo" The element " . $item . " squared is:  " . $squaredItem . "<br>";
			echo"The element " . $item . " raised to the random exponent " .  $ranExponent . " is:  " . $randExpItem . "<br>"; 	
			echo"The area of a circle using the absolute value of " . $item . " is:  " . $areaCircle  . "<br>";
			echo "The volume of a sphere using the absolute value of " . $item . " is:  " .  $areaSphere . "<br>";
			

		}
		
		
	?>
<body>
</body>
</html>