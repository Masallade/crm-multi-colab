<?php

declare(strict_types=1);

use App\Http\Controllers\Addon\SaasController;
// use App\Http\Controllers\Landlord\ClientAutoUpdateController;
// use App\Http\Controllers\Landlord\DeveloperSectionController;
use App\Http\Controllers\Landlord\AdminController;
use App\Http\Controllers\Landlord\BlogController;
use App\Http\Controllers\Landlord\LandingPageController;
use App\Http\Controllers\Landlord\DashboardController;
use App\Http\Controllers\Landlord\FaqController;
use App\Http\Controllers\Landlord\FeatureController;
use App\Http\Controllers\Landlord\NotificationController;
use App\Http\Controllers\Landlord\SettingController;
use App\Http\Controllers\Landlord\HeroController;
use App\Http\Controllers\Landlord\LanguageController;
use App\Http\Controllers\Landlord\ModuleController;
use App\Http\Controllers\Landlord\PackageController;
use App\Http\Controllers\Landlord\PageController;
use App\Http\Controllers\Landlord\PaymentController;
use App\Http\Controllers\Landlord\SocialController;
use App\Http\Controllers\Landlord\TenantSignupDescriptionController;
use App\Http\Controllers\Landlord\TestimonialController;
use App\Http\Controllers\Landlord\TranslationController;
use App\Http\Controllers\LanguageSettingController;
use App\Http\Controllers\Landlord\TenantController;
use App\Http\Controllers\RouteClosureHandlerController;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use IrfanChowdhury\VersionElevate\Http\Controllers\DeveloperSectionController;
use IrfanChowdhury\VersionElevate\Http\Controllers\ClientAutoUpdateController;
use IrfanChowdhury\VersionElevate\Http\Controllers\DashboardController AS VersionDashboardController;

/*
|--------------------------------------------------------------------------
| Landlord Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Auth::routes(['register' => false]);


// Route::get('/all_existing_tenant_db_migrate', function () {
//     DB::beginTransaction();
//     try {
//         $tenants = Tenant::all();
//         foreach ($tenants as $tenant) {
//             $tenant->run(function () {
//                 Artisan::call('migrate --path=database/migrations/tenant/primary');
//                 Artisan::call('migrate --path=database/migrations/tenant/modify');
//             });
//         }
//         DB::commit();
//     } catch (Exception $e) {
//         DB::rollback();
//         return $e->getMessage();
//     }
//     return 'ok';
// });


Route::prefix('addons')->group(function () {

    Route::get('/', function () {
        return view('addons.index');
    })->name('addons');

    Route::controller(SaasController::class)->group(function () {
        Route::prefix('saas')->group(function () {
            Route::get('install/step-1', 'saasInstallStep1')->name('saas-install-step-1');
            Route::get('install/step-2', 'saasInstallStep2')->name('saas-install-step-2');
            Route::get('install/step-3', 'saasInstallStep3')->name('saas-install-step-3');
            Route::post('install/process', 'saasInstallProcess')->name('saas-install-process');
            Route::get('install/step-4', 'saasInstallStep4')->name('saas-install-step-4');
        });
    });
});


Route::get('/paypaltest', function() {
    return view('landlord.public-section.pages.payment.paypal_new');
});

Route::get('/central-documentation', function() {
    return view('documentation-landlord.index');
});


Route::get('/get-host', function () {
    return request()->getHost();
});

Route::middleware(['setPublicLocale','XSS'])->group(function () {

    Route::controller(LandingPageController::class)->group(function () {
        Route::get('/', 'index')->name('landingPage.index');
        Route::get('/blogs', 'blog')->name('landingPage.blog');
        Route::get('/blogs/{slug}', 'blogDetail')->name('landingPage.blogDetail');
        Route::get('/pages/{slug}', 'pageDetails')->name('landingPage.pageDetail');
        Route::post('/contact-us', 'contactUsSubmit')->name('landingPage.contactUsSubmit');
    });

    Route::controller(TenantController::class)->group(function () {
        Route::post('/customer-signup', 'customerSignUp')->name('customer.signup')->middleware('demoCheck');
        Route::get('/contact-for-renewal', 'contactForRenewal')->name('contact_for_renewal');
        Route::post('/contact-for-renewal', 'renewSubscription')->name('renew_subscription')->middleware('demoCheck');
        Route::get('existing_tenant_db_migrate', 'existingTenantDbMigrate');
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::post('/payment/{paymentMethod}/pay', 'paymentPayPage')->name('payment.pay.page');
        Route::post('payment/{paymentMethod}/pay/process', 'paymentProcessWithTenantAndLandlord')->name('payment.pay.process');
        Route::post('payment/{paymentMethod}/pay/cancel', 'paymentPayCancel')->name('payment.pay.cancel');
        Route::get('payment-success/{domain}', 'paymentSuccess')->name('payment.success');
        Route::get('/payment/paystack/pay/callback', 'handleGatewayCallback')->name('payment.paystack.pay.callback');
    });
    Route::get('/language-switch-public/{locale}', [TranslationController::class, 'languageSwitchByPublic'])->name('lang.switch.byPublic');
});


Route::get('/super-admin', [AdminController::class, 'showLoginForm'])->name('landlord.login')->middleware('guest');
Route::post('/super-admin', [AdminController::class, 'login'])->name('landlord.login.proccess');
Route::post('/super-admin/logout', [AdminController::class, 'logout'])->name('landlord.logout');

Route::middleware(['web','auth','setSuperAdminLocale','XSS'])->group(function () {
    Route::prefix('super-admin')->group(function () {

        // Route::get('/all/notifications', [NotificationController::class, 'allNotifications'])->name('seeAllNotification');
        // Route::get('clearAll', [NotificationController::class, 'clearAll'])->name('clearAllNotification');
        // Route::get('markAsRead', [NotificationController::class, 'markAsReadNotification'])->name('markAsReadNotification');


        Route::controller(NotificationController::class)->group(function () {
            Route::get('all-notifications', 'allNotifications')->name('seeAllNotification');
            Route::get('clearAll', 'clearAll')->name('clearAllNotification');
            Route::get('markAsRead', 'markAsReadNotification')->name('markAsReadNotification');
        });

        Route::controller(AdminController::class)->group(function () {
            Route::prefix('profile')->group(function () {
                Route::get('/', 'profile')->name('admin.profile');
                Route::post('/{user}', 'profileUpdate')->name('admin.profile_update');
                Route::post('/{user}/password', 'passwordUpdate')->name('admin.password_update');
            });
        });


        Route::get('dashboard',[DashboardController::class, 'index'])->name('landlord.dashboard');

        Route::controller(TenantController::class)->group(function () {
            Route::prefix('customers')->group(function () {
                Route::get('/', 'index')->name('customer.index');
                Route::get('/datatable', 'datatable')->name('customer.datatable');
                Route::post('/update/{customer}', 'update')->name('customer.update')->middleware('demoCheck');
                Route::get('/tenant-info/{tenant}', 'tenantInfo')->name('customer.tenant_info');
                Route::post('/renew-subscription/{tenant}', 'renewExpiryUpdate')->name('customer.renew_subscription_update')->middleware('demoCheck');
                Route::post('/change-package/{tenant}', 'changePackageProcess')->name('customer.change_package')->middleware('demoCheck');
                Route::get('/destroy/{tenant}', 'destroy')->name('customer.destroy')->middleware('demoCheck');
            });
        });

        Route::controller(PaymentController::class)->group(function () {
            Route::prefix('payments')->group(function () {
                Route::get('/', 'index')->name('payment.index');
                Route::get('/datatable', 'datatable')->name('payment.datatable');
            });
        });

        Route::prefix('packages')->group(function () {
            Route::controller(PackageController::class)->group(function () {
                Route::get('/', 'index')->name('package.index');
                Route::get('/datatable', 'datatable')->name('package.datatable');
                Route::get('/create', 'create')->name('package.create');
                Route::post('/store', 'store')->name('package.store')->middleware('demoCheck');
                Route::get('/edit/{package}', 'edit')->name('package.edit');
                Route::post('/update/{packageId}', 'update')->name('package.update')->middleware('demoCheck');
                Route::get('/destroy/{packageId}', 'destroy')->name('package.destroy')->middleware('demoCheck');
            });
        });

        Route::prefix('languages')->group(function () {
            Route::controller(LanguageController::class)->group(function () {
                Route::get('/', 'index')->name('language.index');
                Route::get('/datatable', 'datatable')->name('language.datatable');
                Route::post('/store', 'store')->name('language.store')->middleware('demoCheck');
                Route::get('/edit/{language}', 'edit')->name('language.edit');
                Route::post('/update/{language}', 'update')->name('language.update')->middleware('demoCheck');
                Route::get('/destroy/{language}', 'destroy')->name('language.destroy')->middleware('demoCheck');
            });

            // Translation
            Route::controller(TranslationController::class)->group(function () {
                Route::get('/{language}/translations', 'index')->name('lang.translations.index');
                Route::get('/{language}/translations/create', 'create')->name('lang.translations.create');
                Route::post('/{language}/translations/store', 'store')->name('lang.translations.store');
                Route::post('/update', 'update')->name('lang.translations.update');
                Route::get('/switch/{lang}', 'languageSwitch')->name('lang.switch');
                Route::get('/delete', 'languageDelete')->name('lang.delete');
            });
        });

        Route::prefix('socials')->group(function () {
            Route::controller(SocialController::class)->group(function () {
                Route::get('/', 'index')->name('social.index');
                Route::post('/store', 'store')->name('social.store')->middleware('demoCheck');
                Route::get('/edit/{social}', 'edit')->name('social.edit');
                Route::post('/update/{social}', 'update')->name('social.update')->middleware('demoCheck');
                Route::get('/destroy/{social}', 'destroy')->name('social.destroy')->middleware('demoCheck');
                Route::post('/sort', 'sort')->name('social.sort')->middleware('demoCheck');
            });
        });

        Route::prefix('features')->group(function () {
            Route::controller(FeatureController::class)->group(function () {
                Route::get('/', 'index')->name('feature.index');
                Route::get('/datatable', 'datatable')->name('feature.datatable');
                Route::post('/store', 'store')->name('feature.store')->middleware('demoCheck');
                Route::get('/edit/{feature}', 'edit')->name('feature.edit');
                Route::post('/update/{feature}', 'update')->name('feature.update')->middleware('demoCheck');
                Route::get('/destroy/{feature}', 'destroy')->name('feature.destroy')->middleware('demoCheck');
                Route::post('/sort', 'sort')->name('feature.sort')->middleware('demoCheck');
            });
        });

        Route::prefix('heroes')->group(function () {
            Route::controller(HeroController::class)->group(function () {
                Route::get('/', 'index')->name('hero.index');
                Route::post('/', 'updateOrCreate')->name('hero.updateOrCreate')->middleware('demoCheck');
            });
        });

        Route::prefix('modules')->group(function () {
            Route::controller(ModuleController::class)->group(function () {
                Route::get('/', 'index')->name('module.index');
                Route::get('/datatable', 'datatable')->name('module.datatable');
                Route::post('/store', 'store')->name('module.store')->middleware('demoCheck');
                Route::get('/edit/{moduleDetail}', 'edit')->name('module.edit');
                Route::post('/update/{moduleDetail}', 'update')->name('module.update')->middleware('demoCheck');
                Route::get('/destroy/{moduleDetail}', 'destroy')->name('module.destroy')->middleware('demoCheck');
                Route::post('/sort', 'sort')->name('module.sort')->middleware('demoCheck');
            });
        });

        Route::prefix('faqs')->group(function () {
            Route::controller(FaqController::class)->group(function () {
                Route::get('/', 'index')->name('faq.index');
                Route::get('/datatable', 'datatable')->name('faq.datatable');
                Route::post('/store', 'store')->name('faq.store')->middleware('demoCheck');
                Route::get('/edit/{faqDetail}', 'edit')->name('faq.edit');
                Route::post('/update/{faqDetail}', 'update')->name('faq.update')->middleware('demoCheck');
                Route::get('/destroy/{faqDetail}', 'destroy')->name('faq.destroy')->middleware('demoCheck');
                Route::post('/sort', 'sort')->name('faq.sort')->middleware('demoCheck');
            });
        });

        Route::prefix('testimonials')->group(function () {
            Route::controller(TestimonialController::class)->group(function () {
                Route::get('/', 'index')->name('testimonial.index');
                Route::get('/datatable', 'datatable')->name('testimonial.datatable');
                Route::post('/store', 'store')->name('testimonial.store')->middleware('demoCheck');
                Route::get('/edit/{testimonial}', 'edit')->name('testimonial.edit');
                Route::post('/update/{testimonial}', 'update')->name('testimonial.update')->middleware('demoCheck');
                Route::get('/destroy/{testimonial}', 'destroy')->name('testimonial.destroy')->middleware('demoCheck');
                Route::post('/sort', 'sort')->name('testimonial.sort')->middleware('demoCheck');
            });
        });

        Route::prefix('tenant-signup-description')->group(function () {
            Route::controller(TenantSignupDescriptionController::class)->group(function () {
                Route::get('/', 'index')->name('tenantSignupDescription.index');
                Route::post('/update-or-create', 'updateOrCreate')->name('tenantSignupDescription.updateOrCreate')->middleware('demoCheck');
            });
        });

        Route::prefix('blogs')->group(function () {
            Route::controller(BlogController::class)->group(function () {
                Route::get('/', 'index')->name('blog.index');
                Route::get('/datatable', 'datatable')->name('blog.datatable');
                Route::post('/store', 'store')->name('blog.store')->middleware('demoCheck');
                Route::get('/edit/{blog}', 'edit')->name('blog.edit');
                Route::post('/update/{id}', 'update')->name('blog.update')->middleware('demoCheck');
                Route::get('/destroy/{id}', 'destroy')->name('blog.destroy')->middleware('demoCheck');
            });
        });

        Route::prefix('pages')->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('/', 'index')->name('page.index');
                Route::get('/datatable', 'datatable')->name('page.datatable');
                Route::post('/store', 'store')->name('page.store')->middleware('demoCheck');
                Route::get('/edit/{page}', 'edit')->name('page.edit');
                Route::post('/update/{id}', 'update')->name('page.update')->middleware('demoCheck');
                Route::get('/destroy/{id}', 'destroy')->name('page.destroy')->middleware('demoCheck');
            });
        });

        Route::prefix('settings')->group(function () {
            Route::controller(SettingController::class)->group(function () {
                Route::get('/', 'index')->name('setting.general.index');
                Route::post('/general', 'generalSettingManage')->name('setting.general.manage')->middleware('demoCheck');
                Route::post('/payment', 'paymentSettingManage')->name('setting.payment.manage')->middleware('demoCheck');
                Route::post('/mail', 'mailSettingManage')->name('setting.mail.manage')->middleware('demoCheck');
                Route::post('/analytic', 'analyticSettingManage')->name('setting.analytic.manage')->middleware('demoCheck');
                Route::post('/seo', 'seoSettingManage')->name('setting.seo.manage')->middleware('demoCheck');
            });
        });

        Route::get('/version-elevate-dashboard', [VersionDashboardController::class, 'index'])->name('dashboard');

        // Auto Update
        Route::controller(DeveloperSectionController::class)->group(function () {
            Route::prefix('developer-section')->group(function () {
                Route::get('/', 'index')->name('developer-section.index');
                Route::post('/', 'submit')->name('developer-section.submit');
                Route::post('/version-upgrade-setting', 'versionUpgradeSetting')->name('version-upgrade-setting.submit');
            });
        });

        Route::controller(ClientAutoUpdateController::class)->group(function () {
            Route::get('/new-release', 'newVersionReleasePage')->name('new-release');
            Route::post('version-upgrade', 'versionUpgradeProcees')->name('version-upgrade');
        });
    });
});







