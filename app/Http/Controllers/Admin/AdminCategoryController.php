<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Cocur\Slugify\Slugify;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    public function categories ():View {
        $categories=Category::orderBy("id","DESC")->get();
        return view("admin.categories",compact("categories"));
    }
    public function category_add ():View {
        $categories=Category::where("status",1)->orderBy("id","DESC")->get();
        return view("admin.category_add",compact("categories"));
    }
    public function category_edit ($category_id):View {
        $categories=Category::where("status",1)->orderBy("id","DESC")->get();
        $category=Category::find($category_id);
        return view("admin.category_edit",compact("category","categories"));
    }


    public function category_store (Request $request) {
        $request->validate([
            "parent_id"=>"nullable|integer|exists:categories,id",
            "name"=>"required|string|unique:categories,name",
            "type"=>"required|string|in:product,page,menu",
        ]);

        $slugify=new Slugify();
        $slug=$slugify->slugify($request->name);

        $category=new Category();

        if(filter_var($request->parent_id, FILTER_VALIDATE_INT)){
            $category=Category::find($request->parent_id);

            if(!$category)
                return redirect()->back()->with("error","Parent category not found.");

            $category->parent_id=$request->parent_id;
        }

        $category->name=$request->name;
        $category->slug=$slug;
        $category->type=$request->type;

        if(!$category->save())
            return redirect()->back()->with("error","Failed to save category.");

        return redirect()->route("admin.categories")->with("success","Category created successfully.");
    }
    public function category_update (Request $request) {
        $request->validate([
            "category_id" => "required|integer|exists:categories,id",
            "parent_id"=> "nullable|integer|exists:categories,id",
            "name"=> [
                "required",
                "string",
                Rule::unique("categories", "name")->ignore($request->category_id)
            ],
            "type"=> "required|string|in:product,page,menu",
        ]);
    
        // Güncellenmesi gereken kategori bulunuyor
        $category = Category::find($request->category_id);
        if (!$category) {
            return redirect()->back()->with("error", "Category not found.");
        }
    
        // Slug oluşturuluyor
        $slugify = new Slugify();
        $slug = $slugify->slugify($request->name);
    
        // Eğer `parent_id` varsa ve geçerliyse güncelle
        if ($request->parent_id) {
            $parentCategory = Category::find($request->parent_id);
            if (!$parentCategory) {
                return redirect()->back()->with("error", "Parent category not found.");
            }
            $category->parent_id = $request->parent_id;
        }
    
        // Kategori bilgileri güncelleniyor
        $category->name = $request->name;
        $category->slug = $slug;
    
        if (!$category->save()) {
            return redirect()->back()->with("error", "Failed to save category.");
        }
    
        return redirect()->route("admin.categories")->with("success", "Category updated successfully.");
    }
    public function category_status_update (Request $request) {
        $validator = \Validator::make($request->all(), [
            "category_id"=>"required|numeric|exists:categories,id",
            "status"=>"required|numeric|in:1,0"
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $category=Category::find($request->category_id);

        if(!$category)
            return response()->json(["error"=>["message"=>"Category not found."]]);

        $category->status=$request->status;

        if(!$category->save())
            return response()->json(["error"=>["message"=>"Failed to update category status."]]);

        return response()->json(["success"=>["message"=>"Category status updated successfully."]]);
    }
    public function category_home_update (Request $request) {
        $validator = \Validator::make($request->all(), [
            "category_id"=>"required|numeric|exists:categories,id",
            "show_on_homepage"=>"required|numeric|in:1,0"
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $category=Category::find($request->category_id);

        if(!$category)
            return response()->json(["error"=>["message"=>"Category not found."]]);

        $category->show_on_homepage=$request->show_on_homepage;

        if(!$category->save())
            return response()->json(["error"=>["message"=>"Failed to update category homepage status."]]);

        return response()->json(["success"=>["message"=>"Category homepage status updated successfully."]]);
    }
    public function category_delete (Request $request) {
        $validator = \Validator::make($request->all(), [
            "category_id"=>"required|numeric|exists:categories,id",
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $category=Category::find($request->category_id);

        if(!$category)
            return response()->json(["error"=>["message"=>"Category not found."]]);

        if(!$category->delete())
            return response()->json(["error"=>["message"=>"Failed to delete category status."]]);

        return response()->json(["success"=>["message"=>"Category deleted successfully."]]);
    }
}
