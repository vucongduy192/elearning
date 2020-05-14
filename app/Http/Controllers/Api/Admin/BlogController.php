<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Repositories\BlogRepository;
use App\Traits\UploadTrait;
use App\Transformers\BlogTransformer;

class BlogController extends Controller
{
    use UploadTrait;
    protected $entity;
    
    public function __construct(BlogRepository $blogRepository)
    {
        $this->entity = $blogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->response($this->entity->pageWithRequest($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $this->entity->customStore($request);
        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = $this->entity->getById($id);
        $transformer = new BlogTransformer();
        return $this->response($transformer->transform($blog));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, $id)
    {
        $this->entity->customUpdate($request, $id);
        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->entity->customDestroy($id);
        return $this->response();
    }
    
    public function uploadImagePost(Request $request)
    {
        $new_image = $this->uploadImage($request, $image_name = 'image_post', $folder = 'blog');
        return $this->response([
            'path' => $new_image
        ]);
    }

    public function removeImagePost(Request $request)
    {
        $this->removeFile($request->path);
        return $this->response();
    }
}
