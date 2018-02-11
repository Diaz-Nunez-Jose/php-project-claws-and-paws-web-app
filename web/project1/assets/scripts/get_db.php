<?php

	function get_db() 
	{
		$db = NULL;

		// default Heroku Postgres configuration URL
		$dbUrl = getenv('DATABASE_URL');

		if (empty($dbUrl)) 
		{
		 // example localhost configuration URL with postgres username and a database called cs313db
		 $dbUrl = 'postgres://postgres:password@localhost:5432/claws_and_paws';
		}

		$dbopts = parse_url($dbUrl);

		$dbHost = $dbopts["host"];
		$dbPort = $dbopts["port"];
		$dbUser = $dbopts["user"];
		$dbPassword = $dbopts["pass"];
		$dbName = ltrim($dbopts["path"],'/');

		try 
		{
		 $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
		 $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch (PDOException $ex) 
		{
		 die();
		}

		return $db;
	}

?>