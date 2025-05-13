<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function storeProvideContent(Request $request){
        $user = Auth::user();
        $token = $user->unique_token;
        //dd("A");
        $request->validate([
            'type' => 'string|in:provide_content',
            'language' => '|string',
            'special_instruction' => 'string',
            'website_id' => 'integer',
            'attachment' => 'min:1',
        ]);

        $fileName = 'sample.docx'; 
        $filePath = public_path($fileName);
        //dd($filePath);
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found on server'], 404);
        }
    
        $cart = Cart::where('website_id', $request->website_id)
                    ->first();

        if($cart){
            Cart::where('website_id', $request->website_id)
                ->update([
                            'type' => $request->type,
                            'language' => $request->language,
                            'special_instruction' => $request->special_instruction,
                            'attachment' => $fileName,
                        ]);
                    
            return response()->json([
                'message' => 'Content updated to cart successfully',
                'cart_id' => $cart->id
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
        $token = $user->unique_token;

        $request->validate([
          
            'website_id' => ['integer'],
        ]);
        
        $data = [
            'type' => 'link_insertion',
            'language' => 'English',
            'existing_post_url' => 'https://example.com/existing-post',
            'target_url' => 'https://example.com/target-url',
            'anchor_text' => 'Click here',
            'special_note' => 'Please avoid emails or phone numbers.',
            'website_id' => $request->website_id,
            
        ];
        
        $cart = Cart::where('advertiser_id', $request->user()->id)->where('website_id', $request->website_id)->first();
        if($cart){
            Cart::where('advertiser_id', $request->user()->id)
                ->where('website_id', $request->website_id)
                ->update($data);
            return response()->json([
                'message' => 'Content updated to cart successfully',
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
        $token = $user->unique_token;
        $request->validate([
            'website_id' => ['integer'],
        ]);
        //dd($token);
        //dd($request->all());
        $data = [
            'type' => 'expert_writer',
            'language' => 'English',
            'title_suggestion' => 'Sample Title',
            'keywords' => 'keyword1',
            'anchor_text' => 'click here',
            'country' => 'USA', 
            'word_count' => '1000 words',
            'category' => 'Technology',
            'reference_link' => 'https://example.com/reference',
            'target_url' => 'https://example.com/target-url',
            'special_note' => 'Please avoid emails or phone numbers.',
            'website_id' => $request->website_id,
        ];
        
        $cart = Cart::where('user_id', $request->user()->id)->where('website_id', $request->website_id)->first();
        if($cart){
            Cart::where('user_id', $request->user()->id)
                ->where('website_id', $request->website_id)
                ->update($data);
            return response()->json([
                'message' => 'Content updated to cart successfully',
                'cart_id' => $cart->id
            ]);
        }else {
            return response()->json([
                'message' => 'Cart item not found',
                'cart_id' => null
            ], 404);
        }
    }
}
