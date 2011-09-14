<?php
class LADDDoor
{
	const DATABASE_HOST     = 'localhost';
	const DATABASE_USER     = 'root';
	const DATABASE_PASSWORD = '';
	const DATABASE_CATALOG  = 'LADD_Door';
	
	const DATE_FORMAT       = 'Y/m/d';
	const DATE_FORMAT_ROW   = 'Y-m-d H:i:s';
	
	public static function today()
	{
		static $value;
		
		if(!$value)
		{
			$value = date(LADDDoor::DATE_FORMAT);
		}
		
		return $value;
	}
	
	public static function database()
	{
		static $connection = null;
		
		if(empty($connection))
		{
			$connection =  new mysqli(LADDDoor::DATABASE_HOST,
				                      LADDDoor::DATABASE_USER,
				                      LADDDoor::DATABASE_PASSWORD,
				                      LADDDoor::DATABASE_CATALOG);
		
			if ($connection->connect_errno) 
			{
				// handle this error accordingly
				//echo 'Error', $connection->connect_errno;
			}
		}
		
		return $connection;
	}
	
	public static function application_root()
	{
		static $path;
	
		if(!$path)
		{
			$path = realpath('./');
			
			if(strpos($path, 'application/') !== false)
			{
				$path = substr($path, 0, strrpos($path, 'application/'));
			}
		}
		
		return $path;
	}
}
?>