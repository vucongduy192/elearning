<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\BaseRepository;
use App\Transformers\UserTransformer;
use App\Traits\TransformPaginatorTrait;
use App\Traits\UploadTrait;

class UserRepository {
    use BaseRepository, UploadTrait, TransformPaginatorTrait;
    protected $model;

    /**
     * Constructor
     *
     * @param User $category
     */
    public function __construct(User $user, UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
        $this->model = $user;
    }

    /**
     * Get list category
     */
    public function pageWithRequest(Request $request, $number = 5, $searchColumn = 'name')
    {
        $sortType = $request->get('sortType') ? $request->get('sortType') : 'desc';
        $sortColumn = $request->get('sortColumn') ? $request->get('sortColumn') : 'id';

        $usersPaginator = $this->model
            ->where([
                [$searchColumn, 'like', '%'.$request->get($searchColumn).'%'],
                ['role', '=', User::ADMIN]
            ])
            ->orderBy($sortColumn, $sortType)
            ->paginate($number);
        
        return $this->buildTransformPaginator(
            $usersPaginator, 
            $this->userTransformer
        );
    }

    /**
     * Store a new category.
     *
     * @param  $input
     * @return 
     */
    public function customStore(UserRequest $request)
    {
        $input = $request->only(['name', 'email', 'password', 'password_confirmation']);
        $input['role'] = User::ADMIN;
        $input['avatar'] = $this->uploadImage($request, $image_name = 'avatar', $folder='avatar');
        $this->store($input);
    }

        /**
     * Update a new category.
     *
     * @param  $input
     * @return 
     */
    public function customUpdate(UserRequest $request, $id)
    {
        $input = $request->only(['name', 'email', 'password', 'password_confirmation']);
        $new_avatar = $this->uploadImage($request, $image_name = 'avatar', $folder='avatar');
        if ($new_avatar != '') {
            $input['avatar'] = $new_avatar;
            $this->removeFile($this->getById($id)->avatar);
        }

        $this->update($id, $input);
    }

    /**
     * Destroy a new category.
     *
     * @param  $input
     * @return 
     */
    public function customDestroy($id)
    {
        $this->removeFile($this->getById($id)->avatar);
        $this->destroy($id);
    }
}