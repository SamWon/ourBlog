<?php defined('BASE_PATH') or exit ('Access Denied');

abstract class fakeModel 
{
	// the mongoDB collection binded with the Model;
	protected static $collection;
	protected static $description;

	protected $managedObjectsCursor;
	protected $managedObjects = array();

	protected $length = 0;
	public $collectionCount;

	protected $_modified = false;
	protected $error = null;

	protected $limit;
	protected $skip;

	public $sort;

	public function __construct()
	{
		$this->init();
		$this->collectionCount = self::$collection->find()->count();
	}

	//set the $collection and $description by implementing func init;
	protected abstract function init();

	public function initWithData($objects = array())
	{

		if(count($objects) === 0)
		{
			throw new FakeException('model init error: objects can\'t be empty'. 0);
		}
		else{
			foreach($objects as $m)
			{
				$m = $this->_validate($m);
				
				$this->managedObjects[] = $m;
			}
		}
	}

	public function performFetch($condition = array(), $skip = 0, $limit = null)
	{
		$this->skip = $skip;
		$this->limit = $limit;
		$this->managedObjects = array();
		$this->managedObjectsCursor = self::$collection->find($condition);
		if(intval($skip) > 0)
			$this->managedObjectsCursor->skip($skip);
		if(! empty($limit))
			$this->managedObjectsCursor->limit($limit);
		if(is_array($this->sort))
			$this->managedObjectsCursor->sort($this->sort);
		foreach($this->managedObjectsCursor as $doc)
		{
			$this->managedObjects[] = $doc;
		}
		$this->length = $this->managedObjectsCursor->count(true);
		return $this->managedObjects;
	}

	// todo  this not work yet
	protected function validate()
	{
		foreach($managedObjects as $m)
		{

			$this->_validate($m);
		}
	}

	public function save()
	{
		foreach($this->managedObjects as $m)
		{
			$this->_saveItem($m);
		}
	}

	protected function _saveItem($m)
	{
		if(empty($m['_id']))
			self::$collection->insert($m);
		else
		{
			if(is_string($m['_id']))
				$m['_id'] = new MongoId($m['_id']);
			self::$collection->update(array(
					'_id' => $m['_id']), $m, array('upsert' => true));
		}
			
	}

	protected function _validate($m)
	{
		if(isset($m['_id']) && empty($m['_id']))
		{
			$m['_id'] = new MongoId();
		}

		return $m;
	}

	public function getError()
	{
		return $this->error;
	}

	public function length()
	{
		return $this->length;
	}

	public function objectAtIndex($i = 0)
	{
		if(isset($this->managedObjects[$i]))
			return $this->managedObjects[$i];
		else
			return null;
	}

	public function getManagedObjects()
	{
		return $this->managedObjects;
	}


}
