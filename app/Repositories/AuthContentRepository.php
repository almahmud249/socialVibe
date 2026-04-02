<?php

namespace App\Repositories;

use App\Models\AuthContent;
use App\Models\AuthContentLanguage;
use App\Traits\ImageTrait;

class AuthContentRepository
{
    use ImageTrait;

    public function all()
    {
        return AuthContent::with('language')->latest()->get();
    }
    public function activeContent()
    {
        return AuthContent::where('status', '1')->with('language')->latest()->get();
    }

    public function find($id)
    {
        return AuthContent::find($id);
    }

    public function getByLang($id, $lang)
    {
        if (! $lang) {
            $authContent = AuthContentLanguage::where('lang', 'en')->where('auth_content_id', $id)->first();
        } else {
            $authContent = AuthContentLanguage::where('lang', $lang)->where('auth_content_id', $id)->first();
            if (! $authContent) {
                $authContent                     = AuthContentLanguage::where('lang', 'en')->where('auth_content_id', $id)->first();
                $authContent['translation_null'] = 'not-found';
            }
        }

        return $authContent;
    }

    public function store($request)
    {
        $authContent        = new AuthContent;
        if (isset($request->image)) {
            $response           = $this->saveImage($request->image);
            $images             = $response['images'];
            $authContent->image = $images;
        }
        $authContent->title = $request->title;
        $authContent->save();
        $this->langStore($request, $authContent);

        return $authContent;
    }

    public function update($request, $id)
    {
        $authContent         = AuthContent::findOrfail($id);
        if (isset($request->image)) {
            $response           = $this->saveImage($request->image);
            $images             = $response['images'];
            $authContent->image = $images;
        }
        $authContent->title  = $request->title;
        $authContent->status = $request->status;
        $authContent->save();

        if (arrayCheck('lang', $request) && $request->lang != 'en') {
            $request->name = $authContent->name;
        }
        if ($request->translate_id) {
            $request->lang = $request->lang ?: 'en';
            $this->langUpdate($request);
        } else {
            $this->langStore($request, $authContent);
        }

        return $authContent;
    }

    public function destroy($id): int
    {
        return AuthContent::destroy($id);
    }

    public function status($data)
    {
        $key         = AuthContent::findOrfail($data['id']);
        $key->status = $data['status'];

        return $key->save();
    }

    public function langStore($request, $advantage)
    {
        return AuthContentLanguage::create([
            'auth_content_id' => $advantage->id,
            'title'           => $request->title,
            'lang'            => isset($request->lang) ? $request->lang : 'en',
        ]);
    }

    public function langUpdate($request)
    {
        return AuthContentLanguage::where('id', $request->translate_id)->update([
            'lang'  => $request->lang,
            'title' => $request->title,
        ]);
    }
}
