<?php

namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $todo = $this->todo->get([]);
        return $todo;
    }

    public function getById($id)
	{
        try {   
            $todo = Todo::findOrFail($id);
            return $todo;
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('ID not found');
        }
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
}