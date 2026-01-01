<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 1. Hiển thị danh sách sản phẩm (Tài khoản)
     */
    public function product_list()
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        // Lấy danh sách từ bảng accounts, sắp xếp mới nhất lên đầu và phân trang
        $products = DB::table('accounts')
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('admin.pages.product_list', compact('admin', 'products'));
    }

    /**
     * 2. Hiển thị form thêm sản phẩm
     */
    public function add_product()
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        // Lấy danh mục để hiển thị trong thẻ <select>
        $categories = DB::table('categories')->get();

        return view('admin.pages.add_product', compact('admin', 'categories'));
    }

    /**
     * 3. Xử lý lưu sản phẩm vào Database
     */
    public function store_product(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'acc_username' => 'required|string|max:255',
            'acc_password' => 'required|string', // Bắt buộc vì DB không có giá trị mặc định
            'category_id'  => 'required|exists:categories,id',
            'price'        => 'required|numeric|min:0',
            'xu_amount'    => 'required|numeric|min:0',
            'avatar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'acc_username.required' => 'Vui lòng nhập tên tài khoản',
            'acc_password.required' => 'Vui lòng nhập mật khẩu tài khoản',
            'category_id.required'  => 'Vui lòng chọn danh mục',
        ]);

        try {
            $data = [
                'acc_username' => $request->acc_username,
                'acc_password' => $request->acc_password,
                'category_id'  => $request->category_id,
                'price'        => $request->price,
                'xu_amount'    => $request->xu_amount,
                'status'       => (int) $request->status,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];

            // Xử lý upload ảnh nếu có file được chọn
            if ($request->hasFile('avatar')) {
                // Lưu vào thư mục storage/app/public/uploads/products
                $path = $request->file('avatar')->store('uploads/products', 'public');
                $data['avatar'] = $path;
            }

            // Thực hiện Insert
            DB::table('accounts')->insert($data);

            return redirect()->route('admin.products.product_list')->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            // Trả về trang trước kèm dữ liệu đã nhập nếu có lỗi SQL
            return back()->withInput()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    /**
     * 4. Xóa sản phẩm và ảnh liên quan
     */
    public function delete_product($id)
    {
        // Tìm sản phẩm trước khi xóa để lấy đường dẫn ảnh
        $product = DB::table('accounts')->where('id', $id)->first();

        if ($product) {
            // Nếu sản phẩm có ảnh, xóa file ảnh trong thư mục storage để tránh rác
            if ($product->avatar && Storage::disk('public')->exists($product->avatar)) {
                Storage::disk('public')->delete($product->avatar);
            }

            // Xóa dòng dữ liệu trong DB
            DB::table('accounts')->where('id', $id)->delete();

            return back()->with('success', 'Đã xóa sản phẩm và dữ liệu liên quan!');
        }

        return back()->with('error', 'Không tìm thấy sản phẩm cần xóa.');
    }
    // Hiển thị form edit (dùng lại giao diện add_product nhưng truyền thêm biến $product)
    public function edit_product($id)
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        $product = DB::table('accounts')->where('id', $id)->first();
        $categories = DB::table('categories')->get();

        if (!$product) {
            return redirect()->route('admin.products.product_list')->with('error', 'Sản phẩm không tồn tại!');
        }

        return view('admin.pages.edit_product', compact('admin', 'product', 'categories'));
    }

    // Xử lý cập nhật dữ liệu
    public function update_product(Request $request, $id)
    {
        $request->validate([
            'acc_username' => 'required|string|max:255',
            'acc_password' => 'required|string',
            'category_id'  => 'required|exists:categories,id',
            'price'        => 'required|numeric|min:0',
            'xu_amount'    => 'required|numeric|min:0',
        ]);

        $data = [
            'acc_username' => $request->acc_username,
            'acc_password' => $request->acc_password,
            'category_id'  => $request->category_id,
            'price'        => $request->price,
            'xu_amount'    => $request->xu_amount,
            'status'       => (int)$request->status,
            'updated_at'   => now(),
        ];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('uploads/products', 'public');
            $data['avatar'] = $path;
        }

        DB::table('accounts')->where('id', $id)->update($data);

        return redirect()->route('admin.products.product_list')->with('success', 'Cập nhật sản phẩm thành công!');
    }
}
