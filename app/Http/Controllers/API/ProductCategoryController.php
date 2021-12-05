<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\Response;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function allCategories(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if ($id) {
            $category = ProductCategory::with(['products'])->find($id);

            if ($category) {
                return Response::success(
                    $category,
                    'Data Kategori berhasil diambil'
                );
            } else {
                return Response::error(
                    null,
                    'Data tidak ditemukan',
                    404,
                );
            }
        }

        $category = ProductCategory::query();
        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('products');
        }

        return Response::success(
            $category->paginate($limit),
            'Data Kategori berhasil diambil'
        );
    }
}
