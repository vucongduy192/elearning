<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Repositories\BaseRepository;
use App\Transformers\UserTransformer;
use App\Traits\TransformPaginatorTrait;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
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
                [$searchColumn, 'like', '%' . $request->get($searchColumn) . '%'],
                // ['role_id', '=', User::ADMIN]
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
        $input = $request->only(['name', 'email', 'role_id']);
        // $input['role_id'] = User::ADMIN;
        $input['password'] = Hash::make($request->password);
        $input['email_verified_at'] = date("Y-m-d H:i:s");
        $input['avatar'] = $this->uploadImage($request, $image_name = 'avatar', $folder = 'avatar');
        $new_user = $this->store($input);

        if ($input['role_id'] == User::TEACHER) {
            Teacher::create([
                'workplace' => '',
                'expert' => '',
                'user_id' => $new_user->id,
            ]);
        } else if ($input['role_id'] == User::STUDENT) {
            Student::create([
                'school' => '',
                'major' => '',
                'user_id' => $new_user->id,
            ]);
        }
    }

    /**
     * Update a new category.
     *
     * @param  $input
     * @return
     */
    public function customUpdate(UserRequest $request, $id)
    {
        $input = $request->only(['name', 'email', 'role_id']);
        $input['password'] = Hash::make($request->password);
        $new_avatar = $this->uploadImage($request, $image_name = 'avatar', $folder = 'avatar');
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
