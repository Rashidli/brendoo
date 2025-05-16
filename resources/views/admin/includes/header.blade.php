<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <title>Brendo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Brendoo" name="description"/>
    <meta content="Themesdesign" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    {{--    <link href="{{asset('assets/css/select2.css')}}" rel="stylesheet"/>--}}

    <!-- jquery.vectormap css -->
    <link href="{{asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet"
          type="text/css"/>

    <!-- Bootstrap Css -->
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/libs/dropzone/min/dropzone.min.css')}}" id="app-style" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    {{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        a {
            text-decoration: none;
        }
    </style>
</head>

<body data-topbar="dark">

<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    {{--                    <a href="{{route('home')}}" class="logo logo-dark">--}}
                    {{--                                <span class="logo-sm">--}}
                    {{--                                    <img src="{{asset('assets/images/logo-sm.png')}}" alt="logo-sm" height="22">--}}
                    {{--                                </span>--}}
                    {{--                        <span class="logo-lg">--}}
                    {{--                                    <img src="{{asset('assets/images/logo-dark.png')}}" alt="logo-dark" height="20">--}}
                    {{--                                </span>--}}
                    {{--                    </a>--}}

                    {{--                    <a href="{{route('home')}}" class="logo logo-light">--}}
                    {{--                                <span class="logo-sm">--}}
                    {{--                                    <img src="{{asset('assets/images/logo-sm.png')}}" alt="logo-sm-light" height="22">--}}
                    {{--                                </span>--}}
                    {{--                        <span class="logo-lg">--}}
                    {{--                                    <img src="{{asset('assets/images/logo-light.png')}}" alt="logo-light" height="20">--}}
                    {{--                                </span>--}}
                    {{--                    </a>--}}
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                    <i class="ri-menu-2-line align-middle"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="ri-search-line"></span>
                    </div>
                </form>
            </div>

            <div class="d-flex">

                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-search-line"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                         aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="mb-3 m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="ri-fullscreen-line"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block user-dropdown">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-xl-inline-block ms-1">{{Auth::user()->name}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="javascript: void(0)"><i
                                class="ri-user-line align-middle me-1"></i> Profile</a>
                        <a class="dropdown-item d-block" href="javascript: void(0)"><span
                                class="badge bg-success float-end mt-1">11</span><i
                                class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{route('logout')}}"><i
                                class="ri-shut-down-line align-middle me-1 text-danger"></i> Çıxış</a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>

                    <!-- Admin Panel -->
                    <li>
                        <a href="{{ route('home') }}" class="waves-effect">
                            <i class="ri-dashboard-line"></i>
                            <span>Admin Panel</span>
                        </a>
                    </li>

                    <!-- Users Management -->
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-user-settings-line"></i>
                            <span>İstifadəçilər</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('create-users')
                                <li><a href="{{ route('users.create') }}">İstifadəçi yarat</a></li>
                            @endcan
                            @can('list-users')
                                <li><a href="{{ route('users.index') }}">İstifadəçilər</a></li>
                            @endcan
                            @can('list-roles')
                                <li><a href="{{ route('roles.index') }}">Roles</a></li>
                            @endcan
                            @can('list-permissions')
                                <li><a href="{{ route('permissions.index') }}">Permissions</a></li>
                            @endcan
                        </ul>
                    </li>

                    <!-- FAQ -->
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-questionnaire-line"></i>
                            <span>Tez tez verilən suallar</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('list-faq_categories')
                                <li><a href="{{ route('faq_categories.index') }}">Kateqoriyalar</a></li>
                            @endcan
                            @can('list-faqs')
                                <li><a href="{{ route('faqs.index') }}">Tez tez verilən suallar</a></li>
                            @endcan
                        </ul>
                    </li>
                    @can('list-products')
                        <li>
                            <a href="{{ route('products.index') }}">
                                <i class="ri-shopping-cart-2-line"></i>
                                <span>Məhsullar</span>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ route('inspections.index') }}">
                            <i class="ri-shopping-cart-2-line"></i>
                            <span>Yoxlama</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders.index') }}">
                            <i class="ri-group-line"></i>
                            <span>Sifarişlər</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('offices.index') }}">
                            <i class="ri-shopping-cart-2-line"></i>
                            <span>Türk ofisi</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('packages.index') }}">
                            <i class="ri-shopping-cart-2-line"></i>
                            <span>Paketlər</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('boxes.index') }}">
                            <i class="ri-shopping-cart-2-line"></i>
                            <span>Qutular</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('banners.index') }}">
                            <i class="ri-group-line"></i>
                            <span>Banners</span>
                        </a>
                    </li>
                    <!-- Customers -->
                    @can('list-customers')
                        <li>
                            <a href="{{ route('customers.index') }}">
                                <i class="ri-group-line"></i>
                                <span>Müştərilər</span>
                            </a>
                        </li>
                    @endcan

                    @can('list-coupons')
                        <li>
                            <a href="{{ route('coupons.index') }}">
                                <i class="ri-group-line"></i>
                                <span>Kuponlar</span>
                            </a>
                        </li>
                    @endcan
                    <!-- Customers -->
                    @can('list-comments')
                        <li>
                            <a href="{{ route('comments.index') }}">
                                <i class="ri-group-line"></i>
                                <span>Rəylər</span>
                            </a>
                        </li>
                    @endcan

                    <!-- About Us -->
                    @can('list-abouts')
                        <li>
                            <a href="{{ route('abouts.index') }}">
                                <i class="ri-information-line"></i>
                                <span>Haqqımızda</span>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ route('regions.index') }}">
                            <i class="ri-price-tag-3-line"></i>
                            <span>Regionlar</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cities.index') }}">
                            <i class="ri-price-tag-3-line"></i>
                            <span>Şəhərlər</span>
                        </a>
                    </li>
{{--                    <li>--}}
{{--                        <a href="{{ route('districts.index') }}">--}}
{{--                            <i class="ri-price-tag-3-line"></i>--}}
{{--                            <span>Rayonlar</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('settlements.index') }}">--}}
{{--                            <i class="ri-price-tag-3-line"></i>--}}
{{--                            <span>Qəsəbələr</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <!-- Filters -->
                    @can('list-filters')
                        <li>
                            <a href="{{ route('filters.index') }}">
                                <i class="ri-filter-line"></i>
                                <span>Filterlər</span>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-questionnaire-line"></i>
                            <span>Məhsul kateqoriyaları</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('list-categories')
                                <li>
                                    <a href="{{ route('categories.index') }}">
                                        <span>Kateqoriyalar</span>
                                    </a>
                                </li>
                            @endcan
                            @can('list-sub_categories')
                                <li>
                                    <a href="{{ route('sub_categories.index') }}">
                                        <span>Alt kateqoriyalar</span>
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a href="{{ route('third_categories.index') }}">
                                    <span>Alt kateqoriyalar (3cü səviyə)</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @can('list-brands')
                        <li>
                            <a href="{{ route('brands.index') }}">
                                <i class="ri-price-tag-3-line"></i>
                                <span>Brendlər</span>
                            </a>
                        </li>
                    @endcan


                    <li>
                        <a href="{{ route('stock_notifications.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Stok bildirişləri</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('return_products.index') }}">
                            <i class="ri-shopping-cart-2-line"></i>
                            <span>İadələr</span>
                        </a>
                    </li>
                    @can('list-tiktoks')
                        <li>
                            <a href="{{ route('tiktoks.index') }}">
                                <i class="ri-video-line"></i>
                                <span>Tiktok hekayələri</span>
                            </a>
                        </li>
                    @endcan
                    @can('list-instagrams')
                        <li>
                            <a href="{{ route('instagrams.index') }}">
                                <i class="ri-instagram-line"></i>
                                <span>Instagram hekayələri</span>
                            </a>
                        </li>
                    @endcan
                    @can('list-specials')
                        <li>
                            <a href="{{ route('specials.index') }}">
                                <i class="ri-focus-line"></i>
                                <span>Xüsusi endirim banneri</span>
                            </a>
                        </li>
                    @endcan

                    {{--                    @can('list_login_banners')--}}
                    {{--                        <li>--}}
                    {{--                            <a href="{{ route('login_banners.index') }}">--}}
                    {{--                                <i class="ri-login-circle-line"></i>--}}
                    {{--                                <span>Login banner</span>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}
                    {{--                    @endcan--}}

                    {{--                    @can('list-holiday_banners')--}}
                    {{--                        <li>--}}
                    {{--                            <a href="{{ route('holiday_banners.index') }}">--}}
                    {{--                                <i class="ri-calendar-event-line"></i>--}}
                    {{--                                <span>Bayram banneri</span>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}
                    {{--                    @endcan--}}

                    @can('list-shops')
                        <li>
                            <a href="{{ route('shops.index') }}">
                                <i class="ri-login-circle-line"></i>
                                <span>Mağazalar (Ünvanlar)</span>
                            </a>
                        </li>
                    @endcan
                    <!-- Hero -->
                    @can('list-mains')
                        <li>
                            <a href="{{ route('mains.index') }}">
                                <i class="ri-star-line"></i>
                                <span>Hero</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Advantages -->
                    @can('list-advantages')
                        <li>
                            <a href="{{ route('advantages.index') }}">
                                <i class="ri-medal-line"></i>
                                <span>Üstünlüklərimiz</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Blogs -->
                    @can('list-blogs')
                        <li>
                            <a href="{{ route('blogs.index') }}">
                                <i class="ri-bookmark-line"></i>
                                <span>Xəbərlər</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Deliveries -->
{{--                    @can('list-deliveries')--}}
{{--                        <li>--}}
{{--                            <a href="{{ route('deliveries.index') }}">--}}
{{--                                <i class="ri-truck-line"></i>--}}
{{--                                <span>Çatdırılma haqqında məlumat</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}
                    <!-- Rules -->
                    @can('list-rules')
                        <li>
                            <a href="{{ route('rules.index') }}">
                                <i class="ri-file-list-line"></i>
                                <span>Səhifələr</span>
                            </a>
                        </li>
                    @endcan
{{--                    <li>--}}
{{--                        <a href="{{ route('refunds.index') }}">--}}
{{--                            <i class="ri-file-list-line"></i>--}}
{{--                            <span>Qaytarma şərtləri</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                    <!-- Socials -->
                    @can('list-socials')
                        <li>
                            <a href="{{ route('socials.index') }}">
                                <i class="ri-share-box-line"></i>
                                <span>Sosial şəbəkələr</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Contact Information -->
                    @can('list-contact_lists')
                        <li>
                            <a href="{{ route('contact_items.index') }}">
                                <i class="ri-contacts-line"></i>
                                <span>Əlaqə məlumatları</span>
                            </a>
                        </li>
                    @endcan

                    <!-- SEO -->
                    @can('list-singles')
                        <li>
                            <a href="{{ route('singles.index') }}">
                                <i class="ri-line-chart-line"></i>
                                <span>SEO</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Translations -->
                    @can('list-translates')
                        <li>
                            <a href="{{ route('words.index') }}">
                                <i class="ri-translate-2"></i>
                                <span>Tərcümələr</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Logo -->
                    @can('list-images')
                        <li>
                            <a href="{{ route('images.index') }}">
                                <i class="ri-image-line"></i>
                                <span>Logo / favicon</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Google Tags -->
                    @can('list-tags')
                        <li>
                            <a href="{{ route('tags.index') }}">
                                <i class="ri-price-tag-line"></i>
                                <span>Google tags</span>
                            </a>
                        </li>
                    @endcan
                    @can('list-contacts')
                        <li>
                            <a href="{{ route('contacts.index') }}">
                                <i class="ri-contacts-line"></i>
                                <span>Əlaqə mesajları</span>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ route('reasons.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Ləğv etmə səbəbləri</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('top_lines.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Üst hissə</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('delivery_prices.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Çatdırılma qiyməti</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product_mains.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Product Hero</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.logs.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Loglar</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register_images.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Register arxa fon şəkli</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('subscriptions.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Abunələr</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Hesabatlıq</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('translations.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>Mobildə  (mobilde)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('on_boardings.index') }}">
                            <i class="ri-contacts-line"></i>
                            <span>On boarding (mobil app)</span>
                        </a>
                    </li>
                </ul>


            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
