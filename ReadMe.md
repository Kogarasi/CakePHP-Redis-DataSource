#CakePHP-Redis-Datasource

Let's enjoy the KVS on CakePHP!

# How to use

#### setup

copy to /app dir.

and setting database.php file.

#### code

<pre>
class ExampleModel extends RedisModel {

	public $useDbConfig = "{yourconfig}";

	public function foo(){
		$this->getDataSource()->set( 'key', 'val' );
	}
}
</pre>


# TODO

divide the interface ( list, hash, … )
don't access via `getdataSource function.
