<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\AuthContentRepository;
use App\Repositories\EmailTemplateRepository;
use App\Repositories\LanguageRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    protected $language;

    protected $authContentRepository;

    public function __construct(EmailTemplateRepository $emailTemplate, AuthContentRepository $authContentRepository, LanguageRepository $language)
    {
        $this->emailTemplate         = $emailTemplate;
        $this->authContentRepository = $authContentRepository;
        $this->language              = $language;
    }

    public function create(): View
    {
        $data = [
            'contents' => $this->authContentRepository->activeContent(),
        ];

        return view('auth.forget_password',$data);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
