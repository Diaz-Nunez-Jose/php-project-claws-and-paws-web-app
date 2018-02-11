<?php
	function phpToPostgresArray($phpArray)
	{
		if(sizeof($phpArray) <= 0)
		{
			return NULL;
		}
		else if(sizeof($phpArray) > 0)
		{
			$firstTerm = strtoupper($phpArray[0]);
			if($firstTerm[strlen($firstTerm) - 1] == 'S')
				$firstTerm = substr($firstTerm, 0, strlen($firstTerm) - 1);

	  		$postgresArray = "ARRAY['%" . $firstTerm . "%'";

			for($i = 1; $i < sizeof($phpArray); $i++)
			{
				$nextTerm = strtoupper($phpArray[$i]);
				if($nextTerm[strlen($nextTerm) - 1] == 'S')
					$nextTerm = substr($nextTerm, 0, strlen($nextTerm) - 1);

				$postgresArray .= ", " . "'%" . $nextTerm . "%'";
			}
	  	}
	  
		$postgresArray .= "]";

		return $postgresArray;
	}
?>