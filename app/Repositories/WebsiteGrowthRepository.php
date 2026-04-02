<?php

namespace App\Repositories;

use App\Models\AuthContentLanguage;
use App\Models\WebsiteGrowth;
use App\Models\WebsiteGrowthLanguage;
use App\Traits\ImageTrait;

class WebsiteGrowthRepository
{
    use ImageTrait;

    public function all()
    {
        return WebsiteGrowth::with('language')->latest()->get();
    }

    public function activeGrowthList()
    {
        return WebsiteGrowth::where('status', '1')->with('language')->latest()->get();
    }

    public function find($id)
    {
        return WebsiteGrowth::find($id);
    }

    public function getByLang($id, $lang)
    {
        if (! $lang) {
            $authContent = WebsiteGrowthLanguage::where('lang', 'en')->where('website_growth_id', $id)->first();
        } else {
            $authContent = WebsiteGrowthLanguage::where('lang', $lang)->where('website_growth_id', $id)->first();
            if (! $authContent) {
                $authContent                     = AuthContentLanguage::where('lang', 'en')->where('website_growth_id', $id)->first();
                $authContent['translation_null'] = 'not-found';
            }
        }

        return $authContent;
    }

    public function store($request)
    {
        $websiteGrowth              = new WebsiteGrowth;
        $websiteGrowth->title       = $request->title;
        $websiteGrowth->description = $request->description;
        $websiteGrowth->status      = $request->status;
        $websiteGrowth->save();
        $this->langStore($request, $websiteGrowth);

        return $websiteGrowth;
    }

    public function update($request, $id)
    {
//		dd($request);
        $websiteGrowth              = WebsiteGrowth::findOrfail($id);
        $websiteGrowth->title       = $request->title;
        $websiteGrowth->description = $request->description;
        $websiteGrowth->status      = $request->status;
        $websiteGrowth->save();

        if (arrayCheck('lang', $request) && $request->lang != 'en') {
            $request->name = $websiteGrowth->name;
        }
        if ($request->translate_id) {
            $request->lang = $request->lang ?: 'en';
            $this->langUpdate($request);
        } else {
            $this->langStore($request, $websiteGrowth);
        }

        return $websiteGrowth;
    }

    public function destroy($id): int
    {
        return WebsiteGrowth::destroy($id);
    }

    public function status($data)
    {
        $key         = WebsiteGrowth::findOrfail($data['id']);
        $key->status = $data['status'];

        return $key->save();
    }

    public function langStore($request, $websiteGrowth)
    {
        return WebsiteGrowthLanguage::create([
            'website_growth_id' => $websiteGrowth->id,
            'title'             => $request->title,
            'description'       => $request->description,
            'lang'              => isset($request->lang) ? $request->lang : 'en',
        ]);
    }

    public function langUpdate($request)
    {
        return WebsiteGrowthLanguage::where('id', $request->translate_id)->update([
            'lang'        => $request->lang,
            'title'       => $request->title,
            'description' => $request->description,
        ]);
    }
}
