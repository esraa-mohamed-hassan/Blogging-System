<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Posts;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();

        return view('categories.index')->with([
            'categories' => $categories,
        ]);
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
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|min:3|max:255|string',
        ]);

        Category::create($validatedData);

        return redirect()->route('category.index')->withSuccess('You have successfully created a Category!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, Category $category)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|min:3|max:255|string',
        ]);

        $category->update($validatedData);

        return redirect()->route('category.index')->withSuccess('You have successfully updated a Category!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        foreach ($category->posts as $post) {
            $post->update(['category_id' => null]);
        }

        $category->delete();

        return redirect()->route('category.index')->withSuccess('You have successfully deleted a Category!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        if (isset($search) && !empty($search)) {
            $categories = Category::Where('name', 'like', '%' . $search . '%')->get();
            $categoryIds = Category::Select('id')->where('name', 'like', '%' . $search . '%')->get();
            if (count($categoryIds) > 1) {
                $posts = Posts::whereBetween('category_id', $categoryIds->toArray())->orderBy('created_at', 'desc')->paginate(5);
            } else {
                $posts = Posts::where('category_id', $categoryIds->toArray())->paginate(5);
            }

            $title = 'Latest Posts';
            return view('home')->withPosts($posts)->withTitle($title)->withCategories($categories);
        } else {
            return redirect('/')->withSuccess("Search can't be empty");
        }

    }
}
