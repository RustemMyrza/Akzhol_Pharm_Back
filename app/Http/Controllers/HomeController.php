<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\Translate;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const CACHE_TIME = 60 * 60 * 24;

    public function index()
    {
        try {
            $data['usersCount'] = cache()
                ->remember(authHasRole() ? 'forDeveloperUsersCount' : 'forAdminUsersCount', self::CACHE_TIME, function () {
                    return User::query()
                        ->with('roles')
                        ->whereHas("roles", function ($query) {
                            $query->whereIn("name", User::getRolesForUser());
                        })
                        ->count();
                });

            $data['applicationsCount'] = cache()->remember('applicationsCount', self::CACHE_TIME, function () {
                return Application::query()->isNew()->count();
            });

            $data['categoriesCount'] = cache()->remember('categoriesCount', self::CACHE_TIME, function () {
                return Category::query()->count();
            });

            $data['citiesCount'] = cache()->remember('citiesCount', self::CACHE_TIME, function () {
                return City::query()->count();
            });

            $data['productsCount'] = cache()->remember('productsCount', self::CACHE_TIME, function () {
                return Product::query()->count();
            });

            $data['ordersCount'] = cache()->remember('ordersCount', self::CACHE_TIME, function () {
                return Order::query()->count();
            });

            return view('admin.index', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function redirectAdminIndex()
    {
        return redirect()->route('admin.index');
    }

    public function languageSwitch(Request $request)
    {
        $language = $request->input('language', Translate::DEFAULT_LANG);

        if (!in_array($language, Translate::LANGUAGES)) {
            $language = Translate::DEFAULT_LANG;
        }

        session()->put('locale', $language);
        app()->setLocale(session('locale'));

        return redirect()->back();
    }
}
