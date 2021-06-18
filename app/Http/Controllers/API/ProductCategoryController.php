<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if ($id) {
            $categories = ProductCategory::with(['products'])->find($id);

            if ($categories) {
                return ResponseFormatter::success(
                    $categories,
                    'Data Categories berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    $categories,
                    'Data Categories tidak ada',
                    404
                );
            }
        }

        $categories = ProductCategory::query();

        if ($name) {
            $categories->where('name', 'like', '%' . $name . '%');
        }
        if ($show_product) {
            $categories->with('products');
        }
        return ResponseFormatter::success(
            $categories->paginate($limit),
            'Data categories berhasil diambil'
        );
    }
}
