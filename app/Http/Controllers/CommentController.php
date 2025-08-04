<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Комментарии",
 * )
 */
class CommentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/comments",
     *     summary="Получить список комментариев",
     *     tags={"Комментарии"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(CommentResource::collection(Comment::all()));
    }

    /**
     * @OA\Post(
     *     path="/api/comments",
     *     summary="Создать новый комментарий",
     *     tags={"Комментарии"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Данные нового комментария",
     *         @OA\JsonContent(
     *             required={"body", "user_id", "post_id"},
     *             @OA\Property(
     *                 property="body",
     *                 type="string",
     *                 example="Новый комментарий"
     *             ),
     *             @OA\Property(
     *                 property="user_id",
     *                 type="string",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                  property="post_id",
     *                  type="string",
     *                  example="1"
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Комментарий успешно создан"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function store(CommentRequest $request): JsonResponse
    {
        return response()->json(new CommentResource(Comment::create($request->all())));
    }

    /**
     * @OA\Get(
     *     path="/api/comments/{id}",
     *     summary="Получить комментарий по ID",
     *     tags={"Комментарии"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID комментария",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о комментарии"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Комментарий не найден"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        return response()->json(new CommentResource(Comment::find($id)));
    }

    /**
     * @OA\Put(
     *     path="/api/comments/{id}",
     *     summary="Обновить комментарий",
     *     tags={"Комментарии"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID комментария",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Данные для обновления комментария",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="body",
     *                 type="string",
     *                 example="Обновленный комментарий"
     *             ),
     *             @OA\Property(
     *                 property="user_id",
     *                 type="integer",
     *                 example="2"
     *             ),
     *             @OA\Property(
     *                  property="post_id",
     *                  type="integer",
     *                  example="2"
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Комментарий успешно обновлён"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Комментарий не найден"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function update(CommentRequest $request, string $id): JsonResponse
    {
        $comment = Comment::find($id);
        $comment->update($request->all());
        return response()->json(new CommentResource($comment));
    }

    /**
     * @OA\Delete(
     *     path="/api/comments/{id}",
     *     summary="Удалить комментарий",
     *     tags={"Комментарии"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID комментария для удаления",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Комментарий успешно удалён",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="result",
     *                 type="boolean",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Комментарий не найден"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        return response()->json(['result' => Comment::find($id)->delete()]);
    }
}
