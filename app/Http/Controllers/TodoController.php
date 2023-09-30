<?php

namespace App\Http\Controllers;

use App\Services\TodoService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function getTodoList()
    {
        try {
            $result = $this->todoService->getAll();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }

    public function createTodo(Request $request)
    {
        $data = $request->only([
            'title',
            'description',
        ]);

        $result = ['status' => 201];

        try {
            $result['data'] = $this->todoService->addTodo($data);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getTodoId($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->todoService->getById($id);
        } catch (ModelNotFoundException $e) {
            $result = [
                'status' => 404,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
