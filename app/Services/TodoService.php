<?php

namespace App\Services;

use App\Repositories\TodoRepository;
use Illuminate\Support\Facades\Validator;
use MongoDB\Exception\InvalidArgumentException;

class TodoService
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getAll()
    {
        $todo = $this->todoRepository->getAll();
        return $todo;
    }

    public function getById($todoId)
	{
        $todo = $this->todoRepository->getById($todoId);
        return $todo;
        
	}

    public function addTodo($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $todoId = $this->todoRepository->create($data);
        return $todoId;
    }

    public function deleteTodoId($id)
    {
        $todoId = $this->todoRepository->getById($id);
        $todo = $this->todoRepository->delete($todoId);
        return $todo;
    }
}