<?php

namespace App\Repositories;

use App\Models\WebsiteIntegrate;
use App\Models\WebsiteIntegrateLanguage;
use App\Traits\ImageTrait;

class WebsiteIntegrateRepository
{
    use ImageTrait;

    public function all()
    {
        return WebsiteIntegrate::with('language')->latest()->get();
    }

    public function activeIntegrate()
    {
        return WebsiteIntegrate::where('status', '1')->with('language')->latest()->get();
    }

    public function find($id)
    {
        return WebsiteIntegrate::find($id);
    }

    public function getByLang($id, $lang)
    {
        if (! $lang) {
            $authContent = WebsiteIntegrateLanguage::where('lang', 'en')->where('website_integrates_id', $id)->first();
        } else {
            $authContent = WebsiteIntegrateLanguage::where('lang', $lang)->where('website_integrates_id', $id)->first();
            if (! $authContent) {
                $authContent                     = WebsiteIntegrateLanguage::where('lang', 'en')->where('website_integrates_id', $id)->first();
                $authContent['translation_null'] = 'not-found';
            }
        }

        return $authContent;
    }

    public function store($request)
    {
        $websiteIntegrate         = new WebsiteIntegrate;
        if (isset($request->image)) {
            $response                = $this->saveImage($request->image);
            $images                  = $response['images'];
            $websiteIntegrate->image = $images;
        }
        $websiteIntegrate->title  = $request->title;
        $websiteIntegrate->status = $request->status;
        $websiteIntegrate->save();
        $this->langStore($request, $websiteIntegrate);

        return $websiteIntegrate;
    }

    public function update($request, $id)
    {
        $websiteIntegrate         = WebsiteIntegrate::findOrfail($id);
        if (isset($request->image)) {
            $response                = $this->saveImage($request->image);
            $images                  = $response['images'];
            $websiteIntegrate->image = $images;
        }
        $websiteIntegrate->title  = $request->title;
        $websiteIntegrate->status = $request->status;
        $websiteIntegrate->save();

        if (arrayCheck('lang', $request) && $request->lang != 'en') {
            $request->name = $websiteIntegrate->name;
        }
        if ($request->translate_id) {
            $request->lang = $request->lang ?: 'en';
            $this->langUpdate($request);
        } else {
            $this->langStore($request, $websiteIntegrate);
        }

        return $websiteIntegrate;
    }

    public function destroy($id): int
    {
        return WebsiteIntegrate::destroy($id);
    }

    public function status($data)
    {
        $key         = WebsiteIntegrate::findOrfail($data['id']);
        $key->status = $data['status'];

        return $key->save();
    }

    public function langStore($request, $websiteIntegrate)
    {
        return WebsiteIntegrateLanguage::create([
            'website_integrates_id' => $websiteIntegrate->id,
            'title'                 => $request->title,
            'lang'                  => isset($request->lang) ? $request->lang : 'en',
        ]);
    }

    public function langUpdate($request)
    {
        return WebsiteIntegrateLanguage::where('id', $request->translate_id)->update([
            'lang'        => $request->lang,
            'title'       => $request->title,
        ]);
    }
}
