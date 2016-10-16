<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<pre>
<?php
    
	error_reporting(0);
    set_time_limit(0);
    ini_set('memory_limit', '1024M');

    $Alice = "alice30.txt";
    $Dictionary = "words.txt";
    
	$AliceContents = file($Alice);  //this contains all the words with the punctuation
	
	$fileContents1 = preg_replace("#[[:punct:]]#", "", $AliceContents);  //this is used specifically to strip away punctuation
    
    $DictContents = file($Dictionary);
    
    $DictContents1 = preg_replace("#[[:punct:]]#", "", $DictContents);

    $directoryName = "\results";

    $CurrentDir = getcwd();
    
    if(!is_dir(getcwd().$directoryName))
       {
            mkdir(getcwd().'\results', 0755, true);
       }
       else
       {
           continue;
       }

    $functions = array(
       'function1' => wordStats($fileContents1),
        'function2' => SpellCheck($fileContents1, $DictContents1),
        'function3' => AliceSpellCorrect($fileContents1, $DictContents1, $Alice),
        'function4' => Sound($fileContents1),
        );

    foreach($functions as $fkey => $fvalue)
    {
        $fvalue;
    }

    function SpellCheck($AliceStrings, $DictStrings)
    {
                
        $AliceList = array();
        $DictList = array();
        $misspelled = array();
                            
        foreach($AliceStrings as $AlString)
        {
            $thewords = explode(' ', $AlString);
            foreach($thewords as $theword)
            {
                $theword = strtolower($theword);
                $AliceList[] = $theword;
            }
        } 
        foreach($DictStrings as $Dic)
        {
            $thewords = explode(' ', $Dic);
            foreach($thewords as $theword)
            {
                $theword = strtolower($theword);
                $DictList[] = $theword;
            }
        }
        
        $AliceList = array_map('trim', $AliceList);
        $DictList = array_map('trim', $DictList);
        
        $AliceList = array_unique($AliceList);
                
        $flipped_haystack = array_flip($DictList);
        
        foreach($AliceList as $output)
        {
            $needle = $output;
            if(!isset($flipped_haystack[$needle]))
            {
               $misspelled[$needle]++;
               
            }
        }
        $misspelled = (array_keys($misspelled));
        asort($misspelled);
        
        $MisspelledSize = count($misspelled);
       
        foreach($misspelled as $msp)
        {
            file_put_contents(dirname(__FILE__)."\\results\\misspellings.txt", ($msp . " : " . numOccurences($AliceStrings, $msp) . " : " . ((numOccurences($AliceStrings, $msp) / $MisspelledSize) * 100) . "% " . "\r\n" ), FILE_APPEND | LOCK_EX);
        }
    }

    function AliceSpellCorrect($AliceStrings, $DictStrings, $Alice)
    {
  
        $AliceList = array();
        $DictList = array();
        
        $misspelled = array();
                            
        foreach($AliceStrings as $AlString)
        {
            $thewords = explode(' ', $AlString);
            foreach($thewords as $theword)
            {
                $theword = strtolower($theword);
                $AliceList[] = $theword;
            }
        }
 
        foreach($DictStrings as $Dic)
        {
            $thewords = explode(' ', $Dic);
            foreach($thewords as $theword)
            {
                $theword = strtolower($theword);
                $DictList[] = $theword;
            }
        }
        
        $AliceList = array_map('trim', $AliceList);
        $DictList = array_map('trim', $DictList);
        
        $AliceList = array_unique($AliceList);
                
        $flipped_haystack = array_flip($DictList);
        
        foreach($AliceList as $output)
        {
            $needle = $output;
            if(!isset($flipped_haystack[$needle]))
            {
               $misspelled[$needle]++;
            }
        }

        $MisspelledSize = count($misspelled);

                
        $misspellingsKeys = array_keys($misspelled);
        
        $AliceOriginal = file_get_contents($Alice);
	
        for ($i = 0; $i < sizeof($misspellingsKeys); $i++) 
        {
            $word = $misspellingsKeys[$i];

            $levenDistances[$word] = //$word is the misspelled word, $wordsArrayLower[0] -> dictionary word
                        array($DictList[0], levenshtein($word, $DictList[0]));
            for($j = 1; $j < sizeof($DictList); $j++) 
            {
                //if the new distance is smaller
                $word2 = $DictList[$j]; //grab next candidate word from dictionary
                $newDist = levenshtein($word, $word2); //misspelled word and dictionary word
                if( $newDist < $levenDistances[$word][1]) 
                {
                    //replace it in the array
                    $levenDistances[$word] = array($word2, $newDist);
                }
            }
        }

        foreach($levenDistances as $key => $value)
        {
               $AliceOriginal = str_ireplace($key, $value[0], $AliceOriginal);
        }
                    
        file_put_contents(dirname(__FILE__)."\\results\\Alice_spell_corrected.txt", $AliceOriginal, LOCK_EX);
   
    }
 
	function numOccurences($strings, $search)
	{
		$count = 0;
		foreach ($strings as $string)
		{
			$count += substr_count(strtolower($string), $search);	
		}
		
		return $count;
	}

	function wordStats($strings)
	{
		$masterWorddList = array();
		foreach($strings as $string)
		{
			$thewords = explode(' ', $string);
			foreach ($thewords as $theword)
			{
				$theword = strtolower($theword);
				$masterWorddList[] = $theword;	
			}
			
		}
        
        $masterWordList = array_map($masterWordList);
		
		$avg = count($masterWorddList);
		$masterWorddList = array_unique($masterWorddList);
		$items = array();		
		foreach($masterWorddList as $aword)
		{
			$items[] = $aword;
		}
		asort($items);
		
		foreach($items as $item)
		{

           file_put_contents(dirname(__FILE__)."\\results\\frequency.txt", ($item . " : " . numOccurences($strings, $item) . " : " . ((numOccurences($strings, $item) / $avg) * 100) . "% " . "\r\n" ), FILE_APPEND | LOCK_EX);
		}
 
	}


    function Sound($AliceStrings)
    {
       
        $AliceList = array();
                                  
        foreach($AliceStrings as $AlString)
        {
            $thewords = explode(' ', $AlString);
            foreach($thewords as $theword)
            {
                $theword = strtolower($theword);
                $AliceList[] = $theword;
            }
        } 
                
        $AliceList = array_map('trim', $AliceList);
         
        $AliceList = array_unique($AliceList);
        
        $flipped_list = array_flip($AliceList);
        
        $aliceUniqueWords = array_keys($flipped_list);

        for($i = 0; $i < sizeof($aliceUniqueWords); $i++) 
        {
            $word = $aliceUniqueWords[$i];
            $soundexKeys[$word] = soundex($word);
            $metaphoneKeys[$word] = metaphone($word);
        }
        
       
        
        $soundexWords = array_keys($soundexKeys);
        $soundexKeyValues = array_values($soundexKeys);
        while($key_value = each($soundexKeys))
        {
            $word = $key_value[0];
            $soundexKey = $key_value[1];
            for($j = 0; $j < sizeof($soundexWords); $j++) 
            {
                if($soundexKey === $soundexKeyValues[$j]) 
                { //match!!
                    $soundexSoundsLike[$word][] = $soundexWords[$j]; //add an element to matches
                }
            }

        }
        
        $metaphoneWords = array_keys($metaphoneKeys);
        $metaphoneKeyValues = array_values($metaphoneKeys);
        while($key_value = each($metaphoneKeys))
        {
            $word = $key_value[0];
            $metaphoneKey = $key_value[1];
            for($j = 0; $j < sizeof($metaphoneWords); $j++) 
            {
                if($metaphoneKey === $metaphoneKeyValues[$j]) 
                { //match!!
                    $metaphoneSoundsLike[$word][] = $metaphoneWords[$j]; //add an element to matches
                }
            }

        }
  
        foreach($soundexSoundsLike as $key => $values)
        {
             $tester[] = ($key . " : " . implode(" : ", $values));
        }

        foreach($metaphoneSoundsLike as $keyM => $valueM)
        {
             $tester2[] = ($keyM . " : " . implode(" : ", $valueM));
        }

        $flipper = array_flip($tester);
        
        $theKeyList = array_keys($flipper);

		for($j = 0; $j < sizeof($theKeyList); $j++) 
        {
			$NewArray[] = array($tester[$j], $tester2[$j]);                
        }
 
        foreach($NewArray as $key => $value)
		{
           file_put_contents(dirname(__FILE__)."\\results\\homophones.txt", ($value[0] . "\r\n" . $value[1] . "\r\n \r\n"), FILE_APPEND | LOCK_EX);
		}

    }
    
?>
</pre>
</body>
</html>