<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class TodoController extends Controller
{
    public function index(): JsonResponse {
        $todos = Todo::all();
        return response()->json([
            'todos' => $todos,
        ]);
    }

    public function store(TodoRequest $request): JsonResponse
    {
        $todo = Todo::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'todo' => $todo
        ]);
    }

    public function show($id): JsonResponse
    {
        try {
            $todo = Todo::query()->where('id', $id)->firstOrFail();

        } catch (Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'todo' => $todo
        ]);
    }

    public function update(TodoRequest $request, $id): JsonResponse
    {
        try {
            $todo = Todo::findOrFail($id);
            $todo->name = $request->get('name');
            $todo->description = $request->get('description');
            $todo->save();
        } catch (Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'todo' => $todo
        ]);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $todo = Todo::findOrFail($id);

            $todo->delete();

        } catch (Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Todo deleted successfully'
        ]);
    }
}
