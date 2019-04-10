<?php
class User
{
	private $id;
	private $entity;
	
	public $name;
	public $mmr;
	public $rank;
	
	public function __construct($userId)
	{
		$moduleLoader = ModuleLoader::getInstance();
		$moduleLoader->load('db');
		$database = DataBase::getInstance();
		$this->entity = $database->getEntity('vcb_users');
		$user = $this->entity->getById($userId);
		
		$this->id = $userId;
		$this->name = $user['name'];
		$this->mmr = $user['mmr'];
		$this->rank = $user['rank'];
	}

	public function save()
	{
		$fields = array(
			'name' => $this->name,
			'mmr' => $this->mmr,
			'rank' => $this->rank
		);
		$id = $this->id;
		
		$this->entity->update($id, $fields);
	}
}