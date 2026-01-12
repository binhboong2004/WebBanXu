<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Models\Account;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $userMessage = $request->input('message');
        if (!$userMessage) {
            return response()->json(['answer' => 'Chào bạn, mình có thể giúp gì cho bạn?']);
        }
        
        $loweredMsg = mb_strtolower($userMessage);

        // 1. Kiểm tra Database trước
        $dbAnswer = $this->searchDatabase($loweredMsg);
        
        if ($dbAnswer) {
            return response()->json(['answer' => $dbAnswer]);
        }

        // 2. Nếu không có trong DB thì gọi Gemini AI
        return $this->askGemini($userMessage);
    }

    private function searchDatabase($msg)
    {
        // Hỏi về danh sách dịch vụ
        if (str_contains($msg, 'danh mục') || str_contains($msg, 'có những loại nào') || str_contains($msg, 'dịch vụ')) {
            $categories = Category::where('status', 1)->pluck('name')->toArray();
            return "Hiện tại hệ thống đang cung cấp các loại dịch vụ: " . implode(', ', $categories) . ". Bạn quan tâm đến loại nào ạ?";
        }

        // Tìm kiếm theo tên Category trong database
        $categories = Category::where('status', 1)->get();
        foreach ($categories as $cat) {
            $catName = mb_strtolower($cat->name);
            // Nếu tin nhắn chứa tên loại sản phẩm (ví dụ: "giá tiktok", "fb còn ko")
            if (str_contains($msg, $catName)) {
                // Đếm số tài khoản còn trống (status = 0)
                $count = Account::where('category_id', $cat->id)->where('status', 0)->count();
                // Lấy giá thấp nhất
                $minPrice = Account::where('category_id', $cat->id)->where('status', 0)->min('price');
                
                if ($count > 0) {
                    return "Dịch vụ {$cat->name} hiện đang còn {$count} tài khoản, giá bán thấp nhất là " . number_format($minPrice, 0, ',', '.') . " VNĐ. Bạn có thể đặt mua ngay trên website!";
                } else {
                    return "Dịch vụ {$cat->name} hiện đang hết hàng. Bạn vui lòng quay lại sau hoặc tham khảo các dịch vụ khác nhé!";
                }
            }
        }

        return null;
    }

    private function askGemini($msg)
    {
        $apiKey = "AIzaSyBY0TDOqjQyPiWNcz1oQrbVJ4oheDSUALQ"; 
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

        try {
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($url, [
                "contents" => [["parts" => [["text" => $msg]]]]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // Kiểm tra cấu trúc dữ liệu trả về từ Gemini
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return response()->json([
                        'answer' => $data['candidates'][0]['content']['parts'][0]['text']
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['answer' => "Xin lỗi, mình gặp chút vấn đề khi kết nối với AI. Bạn thử hỏi câu khác liên quan đến dịch vụ của web nhé!"], 500);
        }

        return response()->json(['answer' => "Mình chưa rõ ý bạn. Bạn muốn hỏi về giá tài khoản hay dịch vụ nào bên mình không?"]);
    }
}