<?php

class RedisSource extends DataSource
{

	private $redis = null;

	function __construct( $config, $autoConnect = true )
	{
		parent::__construct( $config );

		if( $autoConnect )
		{
			return $this->connect();
		}
		else
		{	
			return true;
		}

	}

	function connect()
	{

		$this->checkModule();

		$this->redis = new Redis();
		$is_connected = $this->redis->connect(
			$this->config[ 'host' ],
			$this->config[ 'port' ]
		);

		if( ! $is_connected  )
			throw RedisSourceException::failedConnect(
				$this->config[ 'host' ] . ':' . $this->config[ 'port' ]
			);

		return true;
	}

	function close(){
		$this->redis->close();
	}

	function listSources(){}

	function describe( &$model ){}

	function checkModule()
	{
		if( ! extension_loaded( 'redis' ) )
			throw RedisSourceException::disableModule();
	}

	public function __call( $name, $arguments )
	{
		if( method_exists( $this->redis, $name ) )
		{
			//$this->redis->{$name}( $arguments )
			call_user_func_array( array( $this->redis, $name ), $arguments );
		}
		else
		{
			throw RedisSourceException::failedCallFunction( $name );
		}
	}
}


class RedisSourceException extends Exception
{

	public static function disableModule( $code = 0 )
	{
		return new RedisSourceException( "Not load Redis module. Please check load modules ( \"php -m\" ).", $code );
	}

	public static function failedConnect( $host, $code = 1 )
	{
		return new RedisSourceException( "Can't connection to $host.", $code );
	}

	public static function failedCallFunction( $func_name, $code = 2 )
	{
		return new RedisSourceException( "called function/method( $func_name ) is not exists.", $code );
	}

}
