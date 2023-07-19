<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
     // set index page view
     public function index()
     {
         return view('admin.pages.categories.index');
     }
 
     // handle fetch all eamployees ajax request
     public function fetchAll()
     {
         try {
             $Categorys = Category::all();
             $output = '';
             if ($Categorys->count() > 0) {
                 $output .= '<table class="table table-striped table-sm text-center align-middle">
             <thead>
               <tr>
                 <th>ID</th>
                 <th>Name</th>
                 <th>Action</th>
               </tr>
             </thead>
             <tbody>';
                 foreach ($Categorys as $category) {
                     $output .= '<tr>
                 <td>' . $category->id . '</td>
                 <td>' . $category->name . '</td>
                 <td>
                   <a href="#" id="' . $category->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editCategoryModal"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>
 
                   <a href="#" id="' . $category->id . '" class="text-danger mx-1 deleteIcon"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                 </td>
               </tr>';
                 }
                 $output .= '</tbody></table>';
                 echo $output;
             } else {
                 echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
             }
         } catch (\Exception $e) {
             // Return Json Response
             return response()->json([
                 'message' => $e
             ], 500);
         }
     }
 
     // handle insert a new Category ajax request
     public function store(Request $request)
     {
         try {
             $this->validate(request(), [
                 'name' => 'required',
             ]);
             $categoryData = [
                 'name' => $request->name,
             ];
             Category::create($categoryData);
             return response()->json([
                 'status' => 200,
             ]);
         } catch (\Exception $e) {
             // Return Json Response
             return response()->json([
                 'message' => $e
             ], 500);
         }
     }
 
     // handle edit an Category ajax request
     public function edit(Request $request)
     {
         $id = $request->id;
         $category = Category::find($id);
         return response()->json($category);
     }
 
     // handle update an employee ajax request
 
     public function update(Request $request)
     {
         try {
             $category = Category::find($request->id);
             $this->validate($request, [
                 'name' => 'required',
             ]);
 
             $newData = [
                 'name' => $request->name,
             ];
 
             $category->update($newData);
             return response()->json([
                 'status' => 200,
             ]);
         } catch (\Exception $e) {
             // Return Json Response
             return response()->json([
                 'message' => $e
             ], 500);
         }
     }
 
 
     // handle delete an Category ajax request
     public function delete(Request $request)
     {
         try {
             $id = $request->id;
             Category::destroy($id);
         } catch (\Exception $e) {
             // Return Json Response
             return response()->json([
                 'message' => $e
             ], 500);
         }
     }
}
