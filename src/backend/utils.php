<?
	function generateRandomSequence( $init, $end )
	{
		$shuffleTime = ( $end - $init ) * 5;
		$vector = array();
		srand((double) microtime() * 1000000);
		
		for( $counter = 0; $init <= $end; $counter++, $init++ )
			$vector[$counter] = $init;
		for( $index = 0; $index < $shuffleTime; $index++ )
		{
			$index1 = rand( 0, $counter - 1 );
			$index2 = rand( 0, $counter - 1 );
			
			$tmp = $vector[$index1];
			$vector[$index1] = $vector[$index2];
			$vector[$index2] = $tmp;	
		}	
		return $vector;
	}
	
	function generatePassword( $username )
	{
		$passwordLength = 10;
		srand((double) microtime() * 1000000);
		
		$password = sha1("polygame".$username + rand());
		$init = rand( 0, strlen( password ) - $passwordLenght );
		$password = substr( $password, $init, $passwordLength );
		
		return $password;
	}
?>