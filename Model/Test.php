<?php

App::uses( 'RedisModel', 'Model' );

class Test extends RedisModel
{
	public $useDbConfig = 'redis_local';

	public function _echo()
	{
		//echo get_class( $this->getDataSource() );
		//$this->getDataSource()->connect();
		echo $this->getDataSource()->keys( '*' );
	}


}
