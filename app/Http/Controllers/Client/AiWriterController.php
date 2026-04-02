<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\ClientSettingRepository;
use Brian2694\Toastr\Facades\Toastr;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Orhanerday\OpenAi\OpenAi;

class AiWriterController extends Controller
{
    public function __construct()
    {
        $this->client = new Client;
    }

    public function useCases(): array
    {
        return [
            'whatsapp_campaign'    => 'Whatsapp Campaign',
            'telegram_campaign'    => 'Telegram Campaign',
            'product_description'  => 'Product Description',
            'brand_name'           => 'Brand Name',
            'email'                => 'Email',
            'email_reply'          => 'Email Reply',
            'review_feedback'      => 'Review Feedback',
            'blog_idea'            => 'Blog Idea & Outline',
            'blog_writing'         => 'Blog Section Writing',
            'business_idea'        => 'Business Ideas',
            'business_idea_pitch'  => 'Business Idea Pitch',
            'proposal_later'       => 'Proposal Later',
            'cover_letter'         => 'Cover Letter',
            'call-to_action'       => 'Call to Action',
            'job_description'      => 'Job Description',
            'legal_agreement'      => 'Legal Agreement',
            'social_ads'           => 'Facebook, Twitter, Linkedin Ads',
            'google_ads'           => 'Google Search Ads',
            'post_idea'            => 'Post & Caption Ideas',
            'police_general_dairy' => 'Police General Dairy',
            'comment_reply'        => 'Comment Reply',
            'birthday_wish'        => 'Birthday Wish',
            'seo_meta'             => 'SEO Meta Description',
            'seo_title'            => 'SEO Meta Title',
            'song_lyrics'          => 'Song Lyrics',
            'story_plot'           => 'Story Plot',
            'review'               => 'Review',
            'testimonial'          => 'Testimonial',
            'video_des'            => 'Video Description',
            'video_idea'           => 'Video Idea',
            'php_code'             => 'PHP Code',
            'python_code'          => 'Python Code',
            'java_code'            => 'Java Code',
            'javascript_code'      => 'Javascript Code',
            'dart_code'            => 'Dart Code',
            'swift_code'           => 'Swift Code',
            'c_code'               => 'C Code',
            'c#_code'              => 'C# Code',
            'mysql_query'          => 'MySQL Query',
            'about_us'             => 'About Us',
        ];
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $data = [
            'use_cases' => $this->useCases(),
        ];

        return view('backend.client.ai_writer.index', $data);
    }

    public function saveAiSetting(Request $request, ClientSettingRepository $setting): JsonResponse
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }
        $request->validate([
            'default_ai'       => 'required',
            'openai_api_key'   => 'required_if:default_ai,openai',
            'deepseek_api_key' => 'required_if:default_ai,deepseek',
        ]);
        try {
            $setting->aiCredentialUpdate($request);
            Toastr::success(__('update_successful'));
            $data = [
                'success' => __('update_successful'),
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            $data = [
                'error' => __('something_went_wrong_please_try_again'),
            ];

            return response()->json($data);
        }
    }

    public function generateContent(Request $request)
    {
        if (isDemoMode()) {
            return response()->json([
                'content' => '[DEMO MODE]
                The following is demonstration content. AiWriter will supply authentic content on your server. Kindly note that the preceding review of AiWriter is simulated and does not reflect genuine user feedback. This content was generated for illustrative purposes only and does not represent actual experiences with the AiWriter platform. Thank you for your comprehension.',
            ]);
        }
        $request->validate([
            'prompt' => 'required',
            'length' => 'required',
        ]);
        try {
            $prompt = $request->prompt;
            if (Auth::user()->client->default_ai == 'openai') {
                $open_ai_key = Auth::user()->client->openai_api_key;
                $open_ai     = new OpenAi($open_ai_key);
                $result      = $open_ai->completion([
                    'model'             => 'gpt-3.5-turbo-instruct',
                    'prompt'            => $prompt,
                    'temperature'       => 0.9,
                    'max_tokens'        => (int) $request->length,
                    'frequency_penalty' => 0,
                    'presence_penalty'  => 0.6,
                    'n'                 => (int) $request->variants,
                ]);
            } elseif (Auth::user()->client->default_ai == 'deepseek') {
                $deepseek_api_key = Auth::user()->client->deepseek_api_key;
                $result           = Http::withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer '.$deepseek_api_key,
                ])->post('https://api.deepseek.com/chat/completions', [
                    'model'    => 'deepseek-chat',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'stream'   => false,
                ]);
            }
            $result = json_decode($result);
            if (property_exists($result, 'error')) {
                return response()->json(['status' => false, 'error' => $result->error->message]);
            }

            if ($result->choices[0]) {
                $text = '';
                $i    = 0;
                foreach ($result->choices as $choice) {
                    $text .= $choice->text;
                    $i++;
                    if ($i > 0) {
                        $text .= '<br><br>';
                    }
                }

                return response()->json([
                    'content' => $text,
                    'success' => 1,
                ]);

            } else {
                return response()->json(['status' => false, 'error' => 'something_went_wrong']);
            }

        } catch (\Exception $e) {

            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }
}
