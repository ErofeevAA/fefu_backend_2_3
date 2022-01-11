<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    private const PAGE_SIZE = 5;

    /**
     * Display a listing of the resource.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function index(Post $post) : JsonResponse
    {
        return $post->comments()->with('user')->ordered()->paginate(self::PAGE_SIZE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Post $post
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Post $post, Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|max:150'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(['error' => $messages], 422);
        }

        $validated = $validator->validated();
        $comment = new Comment();
        $comment->text = $validated['text'];
        $comment->user_id = User::inRandomOrder()->first()->id;
        $comment->post_id = $post->id;
        $comment->save();

        return response()->json(new CommentResource($comment), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @param Comment $comment
     * @return JsonResponse
     */
    public function show(Post $post, Comment $comment) : JsonResponse
    {
        return response()->json(new CommentResource($comment));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Post $post
     * @param Request $request
     * @param Comment $comment
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Post $post, Request $request, Comment $comment) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|max:150'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(['error' => $messages], 422);
        }

        $validated = $validator->validated();
        $comment->text = $validated['title'];
        $comment->save();

        return response()->json(new CommentResource($comment));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Post $post, Comment $comment) : JsonResponse
    {
        $comment->delete();
        return response()->json(['message' => 'Comment removed successfully']);
    }
}
