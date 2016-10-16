<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>studentInfo</title>

</head>
<div class="Student-Info">

<table id = "studinf" >

	<h1> Student Information </h1>
    <?php
	
		//Author:  Robert Parson
		//UTC ID:  wrb176
		
		$firstname = $_POST['firstName'];
		$lastname = $_POST['lastName'];
		$utcid = $_POST['utcid'];
		$currentgpa = $_POST['currentgpa'];
		
		$lastname = preg_replace("#[[:punct:][:digit:][:space:]]#","", $lastname);
		$firstname = preg_replace("#[[:punct:][:digit:][:space:]]#","", $firstname);
		$utcidMatch = preg_match("(^(\s*([a-zA-Z]\s*){3}\s*([0-9]\s*){3}\s*$))", $utcid);
		$gpamatch = preg_match("(^(\s*[0-3]\s*[.]\s*[0-9]\s*$)|(\s*[4]\s*[.]\s*[0]\s*))", $currentgpa);
		
		
	
		if($lastname == "" || $firstname == "")
		{
			die("Yep, that's an error.  Your first and/or last name is in the wrong 4mat.  Duh.");
		} 
		elseif($utcidMatch == 0 && $gpamatch == 0)
		{
			if($utcidMatch == 1)
			{
				die("Your GPA is in the wrong format."); 
				
			}
			else
			{
				die("Your UTC ID is in the wrong format.");
				
			}
		}
		
		
		$utcid = preg_replace("#[[:space:]]#","",$utcid);
		$currentgpa = preg_replace("#[[:space:]]#","",$currentgpa);
		
		
		$lastname = preg_replace_callback('/\b\p{Ll}/', 'fixName', $lastname);  //http://stackoverflow.com/questions/3450244/uppercasing-first-letters-of-words-using-preg-replace
		$firstname = preg_replace_callback('/\b\p{Ll}/', 'fixName', $firstname);  //http://stackoverflow.com/questions/3450244/uppercasing-first-letters-of-words-using-preg-replace
		
		$studInfo = ($lastname . ":" . $firstname . ":" . $utcid . ":" . $currentgpa . "\r\n");
		
				
		$StudentInFopen = fopen('studentInfo.txt' , 'a+');
				
		fwrite($StudentInFopen, $studInfo);
		
		fclose($StudentInFopen);
		
		$lines = file("studentInfo.txt");
		natsort($lines);
		file_put_contents("studentInfo.txt", implode("\n", $lines));
		
		$newlines = file("studentInfo.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
		
		foreach($newlines as $newline)
		{
			$arrayfp[] = explode(":", $newline);
		}
		
		print '<tr>';
		print '<th> Last Name </th>';
		print '<th> First Name </th>';
		print '<th> UTC ID </th>';
		print '<th> GPA </th>';
		print '<tr>';
		
		for($i=0; $i <= sizeof($arrayfp); $i++)
		{
			$groupfp = $arrayfp[$i];
			//print ('<table id="mytable">');
			print ('<tr>');
			print ('<td>' . $groupfp[0] . '</td>');
			print ('<td>' . $groupfp[1] . '</td>');
			print ('<td>' . $groupfp[2] . '</td>');
			print ('<td>' . $groupfp[3] . '</td>');
			//echo "<tr><td>".$groupfp[0]."</td><td>".$groupfp[1]."</td><td>".$groupfp[2]."</td><td>".$groupfp[3]."</td></tr>";
			print '</tr>';
			//print '</table>';
		}
			
		
		
		
		function fixName($letter) 
		{
			return mb_strtoupper($letter[0]);  http://stackoverflow.com/questions/3450244/uppercasing-first-letters-of-words-using-preg-replace
		}
		
		
		
		//exit();
	?>
	
		
</div>
</table>
<style type="text/css">
.Student-Info table#studinf{
    width: 100%;
    background-color: #b1ede8;
	border-collapse: collapse;
	border-spacing: 10px 50px;
	veritcal-align: middle;
	horizontal-align: middle;
}
.Student-Info{
    font-family: 'Raleway';
    margin: 30px auto;
	width: 900px;
    padding: 30px;
    -webkit-box-shadow:  0px 0px 15px rgba(0, 0, 0, 0.22);
}
	
.Student-Info td{
	font-size: 125%;
	padding: 15px;
	font-family: 'Raleway';
	veritcal-align: middle;
	text-align: center;
}

.Student-Info th{
	font-size: 140%;
	padding: 15px;
	background-color: #586f7c;
    color: white;
	text-align: center;
}

	<?php
		exit();
	?>
 
	
</style>
<body>
</body>
</html>