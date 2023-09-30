<?php

namespace App\Http\Controllers;

use App\Services\TodoService;
use Exception;
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
        $result = ['status' => 200];

        try {
            $result['data'] = $this->todoService->getAll();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
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
        } catch (Exception $e) {
            $result = [
                'status' => 404,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function updateTodo(Request $request, $id)
    {

        $data = $request->only([
            'title',
            'description',
            'completed'
        ]);
       
        $result = ['status' => 200];

        try {
            $this->todoService->updateTodoId($data, $id);
            $result['data'] = $this->todoService->getById($id);
        } catch (Exception $e) {
            $result = [
                'status' => 404,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function deleteTodo($id)
    {
        $result = [
            'status' => 200,
            'message' => 'Todo deleted successfully'
        ];

        try {
            $this->todoService->deleteTodoId($id);
        } catch (Exception $e) {
            $result = [
                'status'    => 404,
                'error'     => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}
