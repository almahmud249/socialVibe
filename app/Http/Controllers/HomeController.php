<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Plan;
use App\Repositories\BlogRepository;
use App\Repositories\PageRepository;
use App\Repositories\PlanRepository;
use App\Repositories\WebsiteAdvantageRepository;
use App\Repositories\WebsiteCustomerRepository;
use App\Repositories\WebsiteFaqRepository;
use App\Repositories\WebsiteFeatureRepository;
use App\Repositories\WebsiteGrowthRepository;
use App\Repositories\WebsiteIntegrateRepository;
use App\Repositories\WebsiteTestimonialRepository;
use App\Repositories\WebsiteUniqueFeatureRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    protected $planRepository;

    protected $uniqueFeatureRepository;

    protected $featureRepository;

    protected $advantageRepository;

    protected $faqRepository;

    protected $testimonialRepository;

    protected $customerRepository;

    protected $blogRepository;

    protected $growthRepository;

    protected $integrateRepository;

    public function __construct(
        PlanRepository $planRepository,
        WebsiteUniqueFeatureRepository $uniqueFeatureRepository,
        WebsiteFeatureRepository $featureRepository,
        WebsiteAdvantageRepository $advantageRepository,
        WebsiteFaqRepository $faqRepository,
        WebsiteTestimonialRepository $testimonialRepository,
        WebsiteCustomerRepository $customerRepository,
        BlogRepository $blogRepository,
        WebsiteGrowthRepository $growthRepository,
        WebsiteIntegrateRepository $integrateRepository)
    {
        $this->planRepository          = $planRepository;
        $this->uniqueFeatureRepository = $uniqueFeatureRepository;
        $this->featureRepository       = $featureRepository;
        $this->advantageRepository     = $advantageRepository;
        $this->faqRepository           = $faqRepository;
        $this->testimonialRepository   = $testimonialRepository;
        $this->customerRepository      = $customerRepository;
        $this->blogRepository          = $blogRepository;
        $this->growthRepository        = $growthRepository;
        $this->integrateRepository     = $integrateRepository;

    }

    public function index(Request $request)
    {

        $languages        = app('languages');
        $lang             = $request->site_lang ? $request->site_lang : App::getLocale();
        $menu_quick_link  = headerFooterMenu('footer_quick_link_menu', $lang);
        $menu_useful_link = headerFooterMenu('footer_useful_link_menu');

        $data             = [
            'monthlyPlans'      => Plan::active()->orderBy('price')->where('billing_period', 'monthly')->get(),
            'yearlyPlans'       => Plan::active()->orderBy('price')->where('billing_period', 'yearly')->get(),
            'plans2'            => [
                'daily'       => $this->planRepository->activePlans([], 'daily'),
                'weekly'      => $this->planRepository->activePlans([], 'weekly'),
                'monthly'     => $this->planRepository->activePlans([], 'monthly'),
                'quarterly'   => $this->planRepository->activePlans([], 'quarterly'),
                'half_yearly' => $this->planRepository->activePlans([], 'half_yearly'),
                'yearly'      => $this->planRepository->activePlans([], 'yearly'),
            ],
            'unique_features'   => $this->uniqueFeatureRepository->all(),
            'features'          => $this->featureRepository->all(),
            'advantages'        => $this->advantageRepository->all(),
            'faqs'              => $this->faqRepository->all(),
            'testimonials'      => $this->testimonialRepository->all(),
            'menu_quick_links'  => $menu_quick_link,
            'menu_useful_links' => $menu_useful_link,
            'lang'              => $request->lang ?? app()->getLocale(),
            'menu_language'     => headerFooterMenu('header_menu', $lang),
            'blogs'             => $this->blogRepository->homePageBlogs(),
            'ourClients'        => $this->customerRepository->activeCustomer(),
            'growth_list'       => $this->growthRepository->activeGrowthList(),
            'integrate_list'    => $this->integrateRepository->activeIntegrate(),
        ];

        return view('website.themes.'.active_theme().'.home', $data);
    }

    public function page(Request $request, $link, PageRepository $pageRepository)
    {
        $page              = $pageRepository->findByLink($link);
        if (! $page) {
            abort(404);
        }
        $lang              = $request->lang ?? app()->getLocale();
        $menu_quick_link   = headerFooterMenu('footer_quick_link_menu', $lang);
        $menu_useful_link  = headerFooterMenu('footer_useful_link_menu');
        $data['page_info'] = $pageRepository->getByLang($page->id, $lang);

        $data              = [
            'menu_quick_links'  => $menu_quick_link,
            'menu_useful_links' => $menu_useful_link,
            'lang'              => $request->lang ?? app()->getLocale(),
            'menu_language'     => headerFooterMenu('header_menu', $lang),
            'page_info'         => $pageRepository->getByLang($page->id, $lang),
        ];

        return view('website.themes.'.active_theme().'.page', $data);
    }

    public function cacheClear()
    {
        try {
            Artisan::call('all:clear');
            Toastr::success(__('cache_cleared_successfully'));

            return back();
        } catch (\Exception $e) {
            Toastr::error('something_went_wrong_please_try_again', 'Error!');

            return back();
        }
    }

    public function blogs(Request $request)
    {

        if ($request->ajax()) {
            $blogs = Blog::latest()->skip($request->limit)->where('status', 'published')->with('category', 'user', 'language')->take(6)->get();

            return response()->json($blogs);
        }

        $lang  = $request->site_lang ? $request->site_lang : App::getLocale();
        $blogs = $this->blogRepository->activeBlogs();
        $data  = [
            'menu_quick_links'  => headerFooterMenu('footer_quick_link_menu', $lang),
            'menu_useful_links' => headerFooterMenu('footer_useful_link_menu'),
            'lang'              => $request->lang ?? app()->getLocale(),
            'menu_language'     => headerFooterMenu('header_menu', $lang),
            'blogs'             => $blogs,
        ];

        return view('website.themes.'.active_theme().'.blog.all_blog', $data);
    }

    public function blogsDetails(Request $request, $slug)
    {
        $lang               = $request->site_lang ? $request->site_lang : App::getLocale();
        $blog_details       = $this->blogRepository->findBySlug($slug);
        $related_blogs_list = Blog::where('status', 'published')->where('id', '!=', $blog_details->id)->paginate(setting('paginate'));
        $previousBlog       = Blog::where('status', 'published')->where('id', '<', $blog_details->id)->orderBy('id', 'desc')->first();
        $nextBlog           = Blog::where('status', 'published')->where('id', '>', $blog_details->id)->orderBy('id', 'asc')->first();
        $data               = [
            'menu_quick_links'  => headerFooterMenu('footer_quick_link_menu', $lang),
            'menu_useful_links' => headerFooterMenu('footer_useful_link_menu'),
            'lang'              => $request->lang ?? app()->getLocale(),
            'menu_language'     => headerFooterMenu('header_menu', $lang),
            'blog'              => $blog_details,
            'related_blogs'     => $related_blogs_list,
            'previous_blogs'    => $previousBlog,
            'next_blogs'        => $nextBlog,
        ];

        return view('website.themes.'.active_theme().'.blog.blog_details', $data);
    }

    public function filterBlogs(Request $request)
    {
        $searchQuery = $request->input('search');
        $sortBy      = $request->input('sort');

        $blogs       = $this->blogRepository->activeBlogs(['q' => $searchQuery])->load(['user', 'category']);
        if ($sortBy == '1') {
            $blogs = $blogs->sortByDesc('published_date');
        } elseif ($sortBy == '2') {
            $blogs = $blogs->sortBy('published_date');
        }

        return response()->json($blogs->values());
    }

    public function changeLanguage($locale): \Illuminate\Http\RedirectResponse
    {
        cache()->get('locale');
        app()->setLocale($locale);

        return redirect()->back();
    }
}
