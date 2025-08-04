<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="PROfashion-Test API",
 *     version="1.0.0"
 * )
 * @OA\Tag(
 *     name="Пользователи",
 * )
 **/

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Получить список пользователей",
     *     tags={"Пользователи"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(UserResource::collection(User::all()));
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Создать нового пользователя",
     *     tags={"Пользователи"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Данные нового пользователя",
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Василий Васильев"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 example="ivan@example.com"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Пользователь успешно создан"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function store(UserRequest $request): JsonResponse
    {
        return response()->json(new UserResource(User::create($request->all())));
    }


    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Получить пользователя по ID",
     *     tags={"Пользователи"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID пользователя",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о пользователе"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Пользователь не найден"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        return response()->json(new UserResource(User::find($id)));
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Обновить пользователя",
     *     tags={"Пользователи"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID пользователя",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Данные для обновления пользователя",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Сидор Сидоров"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 example="sidor@example.com"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Пользователь успешно обновлён"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Пользователь не найден"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function update(UserRequest $request, string $id): JsonResponse
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json(new UserResource($user));
    }


    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Удалить пользователя",
     *     tags={"Пользователи"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID пользователя для удаления",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Пользователь успешно удалён",
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
     *         description="Пользователь не найден"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        return response()->json(['result' => User::find($id)->delete()]);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}/posts",
     *     summary="Получить список публикаций пользователя",
     *     tags={"Пользователи"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID пользователя",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список публикаций пользователя",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Моя первая публикация"),
     *                 @OA\Property(property="content", type="string", example="Текст публикации..."),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Пользователь не найден"
     *     )
     * )
     */
    public function posts(string $id): JsonResponse
    {
        return response()->json(PostResource::collection(User::find($id)->posts));
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}/comments",
     *     summary="Получить список комментариев пользователя",
     *     tags={"Пользователи"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID пользователя",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список комментариев пользователя",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="text", type="string", example="Отличная статья!"),
     *                 @OA\Property(property="post_id", type="integer", example=5),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Пользователь не найден"
     *     )
     * )
     */
    public function comments(string $id): JsonResponse
    {
        return response()->json(CommentResource::collection(User::find($id)->comments));
    }
}
