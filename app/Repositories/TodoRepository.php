<?php

namespace App\Repositories;

use App\Models\Todo;
use Ramsey\Uuid\Builder\FallbackBuilder;

class TodoRepository
{
    protected $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function getAll()
    {
        $todo = $this->todo->get();
        return $todo;
    }

    public function getById($id)
	{
		$todo = $this->todo->findOrFail(['_id'=>$id]);
		return $todo;
	}

    public function create($data)
    {
        $addTodo = new $this->todo;

        $addTodo->title = $data['title'];
        $addTodo->description = $data['description'];
        $addTodo->completed = false;

        $addTodo->save();
        return $addTodo->fresh();
    }

    public function update($data, $id)
    {
        $todo = $this->todo->where(['_id'=>$id])->update($data);
        return $todo;
    }

    public function delete($id)
    {
        $todo = $this->todo->destroy($id);
        return $todo;
    }
}