<?php

namespace App\Repositories\Client;

use App\Enums\TypeEnum;
use App\Models\Template;
use App\Services\TemplateService;
use App\Traits\CommonTrait;
use App\Traits\ImageTrait;
use App\Traits\RepoResponse;
use App\Traits\TemplateTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TemplateRepository
{
    use CommonTrait, ImageTrait, RepoResponse, TemplateTrait;

    const GRAPH_API_BASE_URL = 'https://graph.facebook.com/v19.0/';

    private $model;

    public function __construct(Template $model)
    {
        $this->model = $model;
    }

    public function combo()
    {
        return $this->model->withPermission()->active()->pluck('name', 'id');
    }

    public function all()
    {
        return $this->model->latest()->paginate(setting('pagination'));
    }

    public function activeSegments()
    {
        return $this->model->withPermission()->where('status', 1)->get();
    }

    public function find($id)
    {
        return $this->model->withPermission()->find($id);
    }

    public function get_size($file_path)
    {
        return Storage::size($file_path);
    }

    private function uploadMediaToFacebookStep1($fileUrl, $fileSize, $mimeType)
    {
        $accessToken   = getClientWhatsAppAccessToken(Auth::user()->client);
        // Upload the image to Facebook
        $appId         = getClientWhatsAppID(Auth::user()->client);
        $apiUrl        = self::GRAPH_API_BASE_URL."{$appId}/uploads?file_length={$fileSize}&file_type={$mimeType}&access_token={$accessToken}";
        $curl          = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => file_get_contents($fileUrl),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: '.$mimeType,
            ],
        ]);
        $response      = curl_exec($curl);
        curl_close($curl);
        // Parse the response to extract the session ID
        $responseArray = json_decode($response, true);
        if (isset($responseArray['id'])) {
            return $responseArray['id'];
        } else {
            return null; // Handle error condition
        }
    }

    private function uploadMediaToFacebookStep2($fileUrl, $session_id)
    {
        $accessToken   = getClientWhatsAppAccessToken(Auth::user()->client);
        // Upload the image to Facebook
        $apiUrl        = self::GRAPH_API_BASE_URL."{$session_id}";
        $curl          = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => file_get_contents($fileUrl), // Assuming $fileUrl contains the file contents
            CURLOPT_HTTPHEADER     => [
                'Authorization: OAuth '.$accessToken,
                'file_offset: 0',
                'Content-Type: text/plain',
            ],
        ]);
        $response      = curl_exec($curl);
        curl_close($curl);
        // Parse the response to extract the session ID
        $responseArray = json_decode($response, true);
        if (isset($responseArray['h'])) {
            return $responseArray['h'];
        } else {
            return null; // Handle error condition
        }
    }

    private function uploadMediaToFacebook($file)
    {
        $fileSize   = $file->getSize();
        $mimeType   = $file->getMimeType();
        $session_id = $this->uploadMediaToFacebookStep1($file, $fileSize, $mimeType);
        if (empty($session_id)) {
            return null;
        }
        // Handle different MIME types
        if (str_contains($mimeType, 'image')) {
            $response  = $this->saveImage($file);
            $media_url = $response['images'];
            $media_url = getFileLink('original_image', $media_url);
        } elseif (str_contains($mimeType, 'video')) {
            $response  = $this->saveFile($file, 'mp4', false);
            $media_url = asset('public/'.$response);
        } elseif (str_contains($mimeType, 'audio')) {
            $response  = $this->saveFile($file, 'mp3', false);
            $media_url = asset('public/'.$response);
        } elseif (str_contains($mimeType, 'pdf')) {
            $response  = $this->saveFile($file, 'pdf', false);
            $media_url = asset('public/'.$response);
        }
        $media      = $this->uploadMediaToFacebookStep2($media_url, $session_id);
        if (empty($media)) {
            return null;
        }

        return $media;
    }

    public function store($request)
    {
        $template = Template::create($request);

        return $template;
    }

    public function update($request, $id)
    {
        $template = Template::find($id);

        return $template->update($request);
    }

    public function destroy($id)
    {
        return Template::destroy($id);
    }

    public function syncTemplateByID($id)
    {
        try {
            $clientSetting  = Auth::user()->client->whatsappSetting;
            $template       = $this->model->withPermission()->find($id);
            $accessToken    = getClientWhatsAppAccessToken(Auth::user()->client);
            $apiUrl         = self::GRAPH_API_BASE_URL."/{$template->template_id}";
            $curl           = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL            => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'GET',
                CURLOPT_HTTPHEADER     => [
                    'Authorization: Bearer '.$accessToken,
                    'Content-Type: application/json',
                ],
            ]);
            $response       = curl_exec($curl);
            curl_close($curl);
            $templateObject = json_decode($response);
            if (isset($templateObject) && isset($templateObject->error)) {
                $error_message = isset($templateObject->error->error_user_msg) ?
                    $templateObject->error->error_user_msg :
                    $templateObject->error->message;

                return $this->formatResponse(
                    false,
                    $error_message,
                    'client.templates.index',
                    []
                );
            }
            $template       = $this->model->withPermission()->firstOrNew(['template_id' => $templateObject->id]);
            $template->fill([
                'name'              => $templateObject->name,
                'client_setting_id' => $clientSetting->id,
                'components'        => $templateObject->components ?? [],
                'category'          => $templateObject->category,
                'language'          => $templateObject->language,
                'client_id'         => Auth::user()->client->id,
                'status'            => $templateObject->status,
                'type'              => TypeEnum::WHATSAPP,
            ]);
            $template->save();

            return $this->formatResponse(
                true,
                __('template_sync_successfully'),
                'client.templates.index',
                []
            );
        } catch (\Throwable $e) {
            if (config('app.debug')) {
                dd($e->getMessage());
            }
            logError('Error: ', $e);

            return $this->formatResponse(
                false,
                $e->getMessage(),
                'client.templates.index',
                []
            );
        }
    }

    public function getTemplateByID($id)
    {
        $row  = $this->find($id);
        $data = app(TemplateService::class)->execute($row);

        return view('backend.client.whatsapp.campaigns.partials.__template', $data)->render();
    }

    public function statusChange($request)
    {
        $id = $request['id'];

        return $this->model->find($id)->update($request);
    }

    public function loadTemplate()
    {
        $clientSetting = Auth::user()->client->whatsappSetting;

        return $this->getLoadTemplate($clientSetting);
    }

    public function whatsappTemplate()
    {
        return $this->model->withPermission()->active()->where('type', TypeEnum::WHATSAPP)->latest()->paginate();
    }

    public function activeWhatsappTemplate()
    {
        return $this->model->withPermission()->active()->where('type', TypeEnum::WHATSAPP)->latest()->get();
    }
}
