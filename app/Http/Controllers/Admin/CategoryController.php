<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục và đếm số lượng sản phẩm thực tế
     */
    public function category_list()
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        // Lấy danh mục và đếm số lượng bản ghi trong bảng 'accounts'
        $categories = DB::table('categories')
            ->select('categories.*')
            ->addSelect([
                'real_total' => DB::table('accounts')
                    ->whereColumn('category_id', 'categories.id')
                    ->selectRaw('count(*)')
            ])
            ->get();

        return view('admin.pages.category_list', compact('admin', 'categories'));
    }

    /**
     * Hiển thị form thêm danh mục mới
     */
    public function add_category()
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();
        return view('admin.pages.add_category', compact('admin'));
    }

    /**
     * Lưu danh mục mới vào Database
     */
    public function store_category(Request $request)
    {
        // 1. Validate dữ liệu gửi lên
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'status' => 'required|in:0,1', // 1: Hoạt động, 0: Bảo trì
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Xử lý upload ảnh (nếu người dùng tải ảnh thay vì dùng icon fontawesome)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        // 3. Thực hiện chèn vào bảng categories
        DB::table('categories')->insert([
            'name'        => $request->name,
            'description' => $request->description,
            'icon'        => $request->icon ?? 'fas fa-folder', // Mặc định nếu để trống
            'image'       => $imagePath,
            'status'      => $request->status,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.categories.category_list')
            ->with('success', 'Thêm danh mục mới thành công!');
    }

    /**
     * Xóa danh mục
     */
    public function delete_category($id)
    {
        // Kiểm tra xem có tài khoản nào thuộc danh mục này không trước khi xóa
        $hasAccounts = DB::table('accounts')->where('category_id', $id)->exists();

        if ($hasAccounts) {
            return back()->with('error', 'Không thể xóa danh mục đang có sản phẩm (tài khoản) bên trong!');
        }

        // Thực hiện xóa
        DB::table('categories')->where('id', $id)->delete();

        return back()->with('success', 'Đã xóa danh mục thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa
     */
    public function edit_category($id)
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            return redirect()->route('admin.categories.category_list')->with('error', 'Không tìm thấy danh mục!');
        }

        return view('admin.pages.edit_category', compact('admin', 'category'));
    }

    /**
     * Cập nhật dữ liệu vào Database
     */
    public function update_category(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'icon'        => $request->icon ?? 'fas fa-folder',
            'status'      => $request->status,
            'updated_at'  => now(),
        ];

        // Xử lý nếu có upload ảnh mới
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }

        DB::table('categories')->where('id', $id)->update($data);

        return redirect()->route('admin.categories.category_list')->with('success', 'Cập nhật danh mục thành công!');
    }
}
