<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use DB;

class CartController extends Controller
{
    public function storeProvideContent(Request $request){
        $user = Auth::user();
        $token = $user->unique_token;
        $request->validate([
            'type' => 'string|in:provide_content',
            'language' => '|string',
            'special_instruction' => 'string',
            'website_id' => 'integer',
            'attachment' => 'min:1',
        ]);

        $fileName = 'sample.docx'; 
        $filePath = public_path($fileName);
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found on server'], 404);
        }
    
        $cart = DB::table('cart')->where('website_id', $request->website_id)
                    ->first();

        if($cart){
            DB::table('cart')->where('website_id', $request->website_id)
                ->update([
                            'type' => $request->type,
                            'language' => $request->language,
                            'special_instruction' => $request->special_instruction,
                            'attachment' => $fileName,
                        ]);
                 
            return response()->json([
                'message' => 'Content updated to cart successfully',
                'cart_id' => $cart->id,
                //'response' => $response->json(),
            ]);
        } else {
            return response()->json([
                'message' => 'Cart item not found',
                'cart_id' => null
            ], 404);
        }
    }

    public function linkInsertion(Request $request){
        $user = Auth::user();

        $request->validate([
          
            'website_id' => ['integer'],
        ]);

        $data = [
            'type' => 'link_insertion',
            'language' => 'English',
            'existing_post_url' => $request->existing_post_url,
            'target_url' => $request->target_url,
            'anchor_text' => $request->anchor_texts,
            'special_note' => $request->special_note,
            'website_id' => $request->website_id,
            
        ];

        $response = Http::withHeaders([
                        'Authorization' => 'Bearer B2tr8yxCoeN2sIASSfZq3bhdM4rpEP',   
                    ])->post('https://lp-latest.elsnerdev.com/api/cart/li-order-info', [
                        'type' => 'link_insertion',
                        'language' => $request->language ?? 'English',
                        'existing_post_url' => $request->existing_post_url,
                        'target_url' => $request->target_url,
                        'anchor_text' => $request->anchor_texts,
                        'special_note' =>  $request->special_note,
                        'website_id' => $request->website_id,
                        'client_token' => $user->client_token,
                    ]); 
        
        $cart = DB::table('cart')->where('advertiser_id', $user->id)->where('website_id', $request->website_id)->first();
        if($cart){
            DB::table('cart')->where('advertiser_id', $user->id)
                ->where('website_id', $request->website_id)
                ->update($data);
            return response()->json([
                'message' => 'Content updated to cart successfully',
                'response' => $response->json(),
            ]);
        
        }else {
            return response()->json([
                'message' => 'Cart item not found',
                'cart_id' => null
            ], 404);
        }
    }

    public function hireContent(Request $request){
        $user = Auth::user();
        $token = $user->client_token;
        $request->validate([
            'website_id' => ['integer'],
        ]);
        $data = [
            'type' => 'expert_writer',
            'language' => 'English',
            'title_suggestion' => 'Sample Title',
            'keywords' => $request->keyword,
            'anchor_text' => $request->anchor_text,
            'country' => $request->target_audience, 
            'word_count' => $request->word_count,
            'category' => $request->category,
            'reference_link' => $request->reference_url,
            'target_url' => $request->target_url,
            'special_note' => $request->special_note,
            'website_id' => $request->website_id,
        ];
        
        $cart = DB::table('cart')->where('advertiser_id', $user->id)->where('website_id', $request->website_id)->first();
        if($cart){
            DB::table('cart')->where('advertiser_id', $user->id)
                ->where('website_id', $request->website_id)
                ->update($data);
            $response = Http::withHeaders([
                        'Authorization' => 'Bearer B2tr8yxCoeN2sIASSfZq3bhdM4rpEP', 
                    ])->post('https://lp-latest.elsnerdev.com/api/cart/content-gp-order-info', [
                        'website_id' => $request->website_id,
                        'category' =>  $request->category,
                        'keywords' => $request->keyword,
                        'target_url' => $request->target_url,
                        'reference_link' => $request->reference_url,
                        'anchor_text' => $request->anchor_text,
                        'word_count' => $request->word_count,
                        'target_audience' => $request->target_audience, 
                        'brief_note' => $request->special_note,
                        'language' => "English",
                        'client_token' => $token,
                        'type' => 'expert_writter',
                    ]);
            return response()->json([
                'message' => 'Content updated to cart successfully',
                'cart_id' => $cart->id,
                'response' => $response->json(),
            ]);
        }else {
            return response()->json([
                'message' => 'Cart item not found',
                'cart_id' => null
            ], 404);
        }
    }

    public function priceUpdate(Request $request){
        return view('advertiser.cart.items');
    }
}
