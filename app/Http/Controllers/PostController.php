<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Публикации",
 * )
 */

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Получить список всех публикаций",
     *     tags={"Публикации"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(PostResource::collection(Post::all()));
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Создать новую публикацию",
     *     tags={"Публикации"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Данные новой публикации",
     *         @OA\JsonContent(
     *             required={"title", "body"},
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="Заголовок публикации"
     *             ),
     *             @OA\Property(
     *                 property="body",
     *                 type="string",
     *                 example="Текст публикации"
     *             ),
     *             @OA\Property(
     *                  property="user_id",
     *                  type="string",
     *                  example="1"
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Публикация успешно создана"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function store(PostRequest $request): JsonResponse
    {
        return response()->json(new PostResource(Post::create($request->all())));
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Получить публикацию по ID",
     *     tags={"Публикации"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID публикации",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о публикации"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Публикация не найдена"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        return response()->json(new PostResource(Post::find($id)));
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Обновить публикацию",
     *     tags={"Публикации"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID публикации",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Данные для обновления публикации",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="Новый заголовок"
     *             ),
     *             @OA\Property(
     *                 property="body",
     *                 type="string",
     *                 example="Новый текст"
     *             ),
     *             @OA\Property(
     *                  property="user_id",
     *                  type="string",
     *                  example="Новый ID автора"
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Публикация успешно обновлена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Публикация не найдена"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function update(PostRequest $request, string $id): JsonResponse
    {
        $post = Post::find($id);
        $post->update($request->all());
        return response()->json(new PostResource($post));
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Удалить публикацию",
     *     tags={"Публикации"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID публикации для удаления",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Публикация успешно удалена",
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
     *         description="Публикация не найдена"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        return response()->json(['result' => Post::find($id)->delete()]);
    }
}
