<?php
namespace App\Filament\Admin\Resources\UserResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\UserResource;
use App\Filament\Admin\Resources\UserResource\Api\Requests\CreateUserRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = UserResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create User
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateUserRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}