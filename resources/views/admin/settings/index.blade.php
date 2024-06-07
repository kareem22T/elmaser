@extends('admin.layouts.admin-layout')

@section('title', 'الاعدادات')
@section('settings_active', 'active')

@section('content')

<div class="admins_wrapper" id="admins_wrapper">
    <div class="switchs">
        <button :class="showAbout ? 'active' : ''" @click="showAbout=true;privacy= false;showContact=false;showAdsPage=false;showAds=false;showPrices = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round" >
                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                <path d="M12 9h.01" />
                <path d="M11 12h1v4h1" />
            </svg>
            من نحن
        </button>
        <button :class="showPrivacy ? 'active' : ''" @click="showAbout=false;showPrivacy= true;showContact=false;showAdsPage=false;showAds=false;showPrices = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shield-cog" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 21a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3a12 12 0 0 0 8.5 3c.568 1.933 .635 3.957 .223 5.89" />
                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M19.001 15.5v1.5" />
                <path d="M19.001 21v1.5" />
                <path d="M22.032 17.25l-1.299 .75" />
                <path d="M17.27 20l-1.3 .75" />
                <path d="M15.97 17.25l1.3 .75" />
                <path d="M20.733 20l1.3 .75" />
              </svg>
            سياسة الخصوصية
        </button>
        <button :class="showContact ? 'active' : ''" @click="showAbout=false;showPrivacy= false;showContact=true;showAdsPage=false;showAds=false;showPrices = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-address-book" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                <path d="M10 16h6" />
                <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M4 8h3" />
                <path d="M4 12h3" />
                <path d="M4 16h3" />
              </svg>
            اتصل بنا
        </button>
        <button :class="showAdsPage ? 'active' : ''" @click="showAbout=false;showPrivacy= false;showContact=false;showAdsPage=true;showAds=false;showPrices = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-speakerphone" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8a3 3 0 0 1 0 6" />
                <path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" />
                <path d="M12 8h0l4.524 -3.77a.9 .9 0 0 1 1.476 .692v12.156a.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" />
              </svg>
              الاعلانات
        </button>
        <button :class="showAds ? 'active' : ''" @click="showAbout=false;showPrivacy= false;showContact=false;showAdsPage=false;showAds =true;showPrices = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ad-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 4h-14a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3h14a3 3 0 0 0 3 -3v-10a3 3 0 0 0 -3 -3zm-10 4a3 3 0 0 1 2.995 2.824l.005 .176v4a1 1 0 0 1 -1.993 .117l-.007 -.117v-1h-2v1a1 1 0 0 1 -1.993 .117l-.007 -.117v-4a3 3 0 0 1 3 -3zm0 2a1 1 0 0 0 -.993 .883l-.007 .117v1h2v-1a1 1 0 0 0 -1 -1zm8 -2a1 1 0 0 1 .993 .883l.007 .117v6a1 1 0 0 1 -.883 .993l-.117 .007h-1.5a2.5 2.5 0 1 1 .326 -4.979l.174 .029v-2.05a1 1 0 0 1 .883 -.993l.117 -.007zm-1.41 5.008l-.09 -.008a.5 .5 0 0 0 -.09 .992l.09 .008h.5v-.5l-.008 -.09a.5 .5 0 0 0 -.318 -.379l-.084 -.023z" stroke-width="0" fill="currentColor" />
              </svg>
        </button>
        <button :class="showPrices ? 'active' : ''" @click="showAbout=false;showPrivacy= false;showContact=false;showAdsPage=false;showAds =false;showPrices = true">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coins" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z" />
                <path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" />
                <path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z" />
                <path d="M3 6v10c0 .888 .772 1.45 2 2" />
                <path d="M3 11c0 .888 .772 1.45 2 2" />
            </svg>
            الاسعار
        </button>
    </div>

    <div class="w-100 mb-5 mt-5" :class="!showAds ? 'd-none' : ''" style="margin-left: auto;margin-right: auto">
        <div class="form-group" style="width: max-content;">
            <label for="" class="mb-2">اعلان (header)</label>
            <div @click="this.showImages = true; this.current_article_id = null;this.current_ad = 'header_ad'" class="p-3 d-flex justify-content-center align-items-center form-control input" style="width: 400px;height: 57px;box-sizing: content-box">
                <img :src="header_ad ? header_ad : '/dashboard/images/add_image.svg'" id="preview" alt="img logo" style="width: 100%;object-fit: contain; height: 100%;">
            </div>
            <div class="w-100 mt-2">
                <input type="text" class="form-control" id="header_ad" v-model="header_ad_url" placeholder="رابط التوجه اختياري">
            </div>
        </div>
        <br>
        <div class="form-group" style="width: max-content;">
            <label for="" class="mb-2">اول اعلان عرضي</label>
            <div @click="this.showImages = true; this.current_article_id = null;this.current_ad = 'hero_first_ad'" class="p-3 d-flex justify-content-center align-items-center form-control input" style="width: 725px;height: 90px;box-sizing: content-box">
                <img :src="hero_first_ad ? hero_first_ad : '/dashboard/images/add_image.svg'" id="preview" alt="img logo" style="width: 100%;object-fit: contain; height: 100%;">
            </div>
            <div class="w-100 mt-2">
                <input type="text" class="form-control" id="hero_first_ad" v-model="hero_first_ad_url" placeholder="رابط التوجه اختياري">
            </div>
        </div>
        <div class="form-group mt-4" style="width: max-content;display: flex;gap: 12px">
            <div>
                <label for="" class="mb-2">اعلان يمين</label>
                <div @click="this.showImages = true; this.current_article_id = null;this.current_ad = 'main_right'" class="p-3 d-flex justify-content-center align-items-center form-control input" style="width: 130px;height: 595px;box-sizing: content-box">
                    <img :src="main_right ? main_right : '/dashboard/images/add_image.svg'" id="preview" alt="img logo" style="width: 100%;object-fit: contain; height: 100%;">
                </div>
                <div class="w-100 mt-2">
                    <input type="text" class="form-control" id="main_right" v-model="main_right_url" placeholder="رابط التوجه اختياري">
                </div>
            </div>
            <div>
                <label for="" class="mb-2">اعلان شمال</label>
                <div @click="this.showImages = true; this.current_article_id = null;this.current_ad = 'main_left'" class="p-3 d-flex justify-content-center align-items-center form-control input" style="width: 130px;height: 595px;box-sizing: content-box">
                    <img :src="main_left ? main_left : '/dashboard/images/add_image.svg'" id="preview" alt="img logo" style="width: 100%;object-fit: contain; height: 100%;">
                </div>
                <div class="w-100 mt-2">
                    <input type="text" class="form-control" id="" v-model="main_left_url" placeholder="رابط التوجه اختياري">
                </div>
            </div>
        </div>
        <div style="display: flex; gap: 16px;margin-top: 16px">
            <div class="form-group mb-4" style="width: max-content;">
                <label for="" class="mb-2">اعلان بجانب الاسلايدر</label>
                <div @click="this.showImages = true; this.current_article_id = null;this.current_ad = 'square_ad'" class="p-3 d-flex justify-content-center align-items-center form-control input" style="width: 305px;height: 305px;box-sizing: content-box">
                    <img :src="square_ad ? square_ad : '/dashboard/images/add_image.svg'" id="preview" alt="img logo" style="width: 100%;object-fit: contain; height: 100%;">
                </div>
                <div class="w-100 mt-2">
                    <input type="text" class="form-control" id="square_ad" v-model="square_ad_url" placeholder="رابط التوجه اختياري">
                </div>
            </div>
            <div class="form-group mb-4" style="width: max-content;">
                <label for="" class="mb-2">اعلان بجانب اسعار الذهب</label>
                <div @click="this.showImages = true; this.current_article_id = null;this.current_ad = 'square_sm_ad'" class="p-3 d-flex justify-content-center align-items-center form-control input" style="width: 305px;height: 305px;box-sizing: content-box">
                    <img :src="square_sm_ad ? square_sm_ad : '/dashboard/images/add_image.svg'" id="preview" alt="img logo" style="width: 100%;object-fit: contain; height: 100%;">
                </div>
                <div class="w-100 mt-2">
                    <input type="text" class="form-control" id="square_ad" v-model="square_sm_ad_url" placeholder="رابط التوجه اختياري">
                </div>
            </div>
        </div>
        <div class="form-group" style="width: max-content;">
            <label for="" class="mb-2">تاني اعلان عرضي</label>
            <div @click="this.showImages = true; this.current_article_id = null;this.current_ad = 'horizon_sec_ad'" class="p-3 d-flex justify-content-center align-items-center form-control input" style="width: 725px;height: 90px;box-sizing: content-box">
                <img :src="horizon_sec_ad ? horizon_sec_ad : '/dashboard/images/add_image.svg'" id="preview" alt="img logo" style="width: 100%;object-fit: contain; height: 100%;">
            </div>
            <div class="w-100 mt-2">
                <input type="text" class="form-control" id="horizon_sec_ad" v-model="horizon_sec_ad_url" placeholder="رابط التوجه اختياري">
            </div>
        </div>
        <div class="form-group" style="width: max-content;">
            <label for="" class="mb-2">ثالث اعلان عرضي</label>
            <div @click="this.showImages = true; this.current_article_id = null;this.current_ad = 'horizon_third_ad'" class="p-3 d-flex justify-content-center align-items-center form-control input" style="width: 725px;height: 90px;box-sizing: content-box">
                <img :src="horizon_third_ad ? horizon_third_ad : '/dashboard/images/add_image.svg'" id="preview" alt="img logo" style="width: 100%;object-fit: contain; height: 100%;">
            </div>
            <div class="w-100 mt-2">
                <input type="text" class="form-control" id="horizon_third_ad_url" v-model="horizon_third_ad_url" placeholder="رابط التوجه اختياري">
            </div>
        </div>
    </div>

    <div class="mt-4" :class="(!showAbout ? 'd-none' : '')">
        <!-- Swiper -->
        <div class="w-100  pb-3">
            <div class="w-100 p-3">
                <div>
                    <label for="lang_name" class="form-label">محتوى من نحن*</label>
                    <div class="card input">
                        <div class="pt-3">
                            <div class="toolbar d-flex gap-2 justify-content-center " style="flex-wrap: wrap">
                                <button @click="execCommand('bold')" class="btn btn-light"><b>B</b></button>
                                <button @click="execCommand('italic')" class="btn btn-light"><i>I</i></button>
                                <button @click="execCommand('underline')" class="btn btn-light"><u>U</u></button>
                                <button @click="execCommand('insertOrderedList')" class="btn btn-light"><i class="ti ti-list-numbers"></i></button>
                                <button @click="execCommand('insertUnorderedList')" class="btn btn-light"><i class="ti ti-list"></i></button>
                                <button @click="execCommand('justifyLeft')" class="btn btn-light"><i class="ti ti-align-left"></i></button>
                                <button @click="execCommand('justifyCenter')" class="btn btn-light"><i class="ti ti-align-center"></i></button>
                                <button @click="execCommand('justifyRight')" class="btn btn-light"><i class="ti ti-align-right"></i></button>
                                <button @click="insertHTML('<h2>عنوان</h2>', 'about')" class="btn btn-light"><i class="ti ti-h-2"></i></button>
                                <button @click="insertHTML('<h3>عنوان</h3>', 'about')" class="btn btn-light"><i class="ti ti-h-3"></i></button>
                                <button @click="insertHTML('<h4>عنوان</h4>', 'about')" class="btn btn-light"><i class="ti ti-h-4"></i></button>
                                <button @click="insertHTML('<h5>عنوان</h5>', 'about')" class="btn btn-light"><i class="ti ti-h-5"></i></button>
                                <button @click="insertHTML('<h6>عنوان</h6>', 'about')" class="btn btn-light"><i class="ti ti-h-6"></i></button>
                                <button @click="insertHTML('<p>نص</p>', 'about')" class="btn btn-light">P</button>
                                <button class="btn btn-light" @click="this.showImages = true; this.current_article_id = 'about'"><i class="ti ti-photo-plus"></i></button>
                                <button class="btn btn-light" @click="this.showCodePopUp = true; this.current_article_id = 'about'"><i class="ti ti-code"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div contenteditable="true" :id="'about'" class="form-control" style="min-height: 300px">{!!(isset($settingsArray['about']) && $settingsArray['about']["value"]) ? $settingsArray['about']["value"] : '' !!}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="mt-4" :class="(!showPrivacy ? 'd-none' : '')">
        <!-- Swiper -->
        <div class="w-100  pb-3">
            <div class="w-100 p-3">
                <div>
                    <label for="lang_name" class="form-label">محتوى سياسة الخصوصية *</label>
                    <div class="card input">
                        <div class="pt-3">
                            <div class="toolbar d-flex gap-2 justify-content-center " style="flex-wrap: wrap">
                                <button @click="execCommand('bold')" class="btn btn-light"><b>B</b></button>
                                <button @click="execCommand('italic')" class="btn btn-light"><i>I</i></button>
                                <button @click="execCommand('underline')" class="btn btn-light"><u>U</u></button>
                                <button @click="execCommand('insertOrderedList')" class="btn btn-light"><i class="ti ti-list-numbers"></i></button>
                                <button @click="execCommand('insertUnorderedList')" class="btn btn-light"><i class="ti ti-list"></i></button>
                                <button @click="execCommand('justifyLeft')" class="btn btn-light"><i class="ti ti-align-left"></i></button>
                                <button @click="execCommand('justifyCenter')" class="btn btn-light"><i class="ti ti-align-center"></i></button>
                                <button @click="execCommand('justifyRight')" class="btn btn-light"><i class="ti ti-align-right"></i></button>
                                <button @click="insertHTML('<h2>عنوان</h2>', 'privacy')" class="btn btn-light"><i class="ti ti-h-2"></i></button>
                                <button @click="insertHTML('<h3>عنوان</h3>', 'privacy')" class="btn btn-light"><i class="ti ti-h-3"></i></button>
                                <button @click="insertHTML('<h4>عنوان</h4>', 'privacy')" class="btn btn-light"><i class="ti ti-h-4"></i></button>
                                <button @click="insertHTML('<h5>عنوان</h5>', 'privacy')" class="btn btn-light"><i class="ti ti-h-5"></i></button>
                                <button @click="insertHTML('<h6>عنوان</h6>', 'privacy')" class="btn btn-light"><i class="ti ti-h-6"></i></button>
                                <button @click="insertHTML('<p>نص</p>', 'privacy')" class="btn btn-light">P</button>
                                <button class="btn btn-light" @click="this.showImages = true; this.current_article_id = 'privacy'"><i class="ti ti-photo-plus"></i></button>
                                <button class="btn btn-light" @click="this.showCodePopUp = true; this.current_article_id = 'privacy'"><i class="ti ti-code"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div contenteditable="true" :id="'privacy'" class="form-control" style="min-height: 300px">{!!(isset($settingsArray['privacy']) && $settingsArray['privacy']["value"]) ? $settingsArray['privacy']["value"] : '' !!}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="mt-4" :class="(!showAdsPage ? 'd-none' : '')">
        <!-- Swiper -->
        <div class="w-100  pb-3">
            <div class="w-100 p-3">
                <div>
                    <label for="lang_name" class="form-label">محتوى صفحة الاعلانات *</label>
                    <div class="card input">
                        <div class="pt-3">
                            <div class="toolbar d-flex gap-2 justify-content-center " style="flex-wrap: wrap">
                                <button @click="execCommand('bold')" class="btn btn-light"><b>B</b></button>
                                <button @click="execCommand('italic')" class="btn btn-light"><i>I</i></button>
                                <button @click="execCommand('underline')" class="btn btn-light"><u>U</u></button>
                                <button @click="execCommand('insertOrderedList')" class="btn btn-light"><i class="ti ti-list-numbers"></i></button>
                                <button @click="execCommand('insertUnorderedList')" class="btn btn-light"><i class="ti ti-list"></i></button>
                                <button @click="execCommand('justifyLeft')" class="btn btn-light"><i class="ti ti-align-left"></i></button>
                                <button @click="execCommand('justifyCenter')" class="btn btn-light"><i class="ti ti-align-center"></i></button>
                                <button @click="execCommand('justifyRight')" class="btn btn-light"><i class="ti ti-align-right"></i></button>
                                <button @click="insertHTML('<h2>عنوان</h2>', 'adsPage')" class="btn btn-light"><i class="ti ti-h-2"></i></button>
                                <button @click="insertHTML('<h3>عنوان</h3>', 'adsPage')" class="btn btn-light"><i class="ti ti-h-3"></i></button>
                                <button @click="insertHTML('<h4>عنوان</h4>', 'adsPage')" class="btn btn-light"><i class="ti ti-h-4"></i></button>
                                <button @click="insertHTML('<h5>عنوان</h5>', 'adsPage')" class="btn btn-light"><i class="ti ti-h-5"></i></button>
                                <button @click="insertHTML('<h6>عنوان</h6>', 'adsPage')" class="btn btn-light"><i class="ti ti-h-6"></i></button>
                                <button @click="insertHTML('<p>نص</p>', 'adsPage')" class="btn btn-light">P</button>
                                <button class="btn btn-light" @click="this.showImages = true; this.current_article_id = 'adsPage'"><i class="ti ti-photo-plus"></i></button>
                                <button class="btn btn-light" @click="this.showCodePopUp = true; this.current_article_id = 'adsPage'"><i class="ti ti-code"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div contenteditable="true" :id="'adsPage'" class="form-control" style="min-height: 300px">{!!(isset($settingsArray['adsPage']) && $settingsArray['adsPage']["value"]) ? $settingsArray['adsPage']["value"] : '' !!}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mb-4 mt-5"  :class="(!showContact ? 'd-none' : '')">
        <div>
            <div class="w-100 mb-4 gap-2" style="display: grid; grid-template-columns: 1fr 1fr;">
                <div class="w-100">
                    <div>
                        <label for="phone" class="form-label">رقم الهاتف </label>
                        <input type="text" class="form-control" id="phone" v-model="phone">
                    </div>
                </div>
                <div class="w-100">
                    <div>
                        <label for="email" class="form-label">البريد الالكتروني </label>
                        <input type="text" class="form-control" id="email" v-model="email">
                    </div>
                </div>
            </div>
            <div class="w-100 mb-4 gap-2" style="display: grid; grid-template-columns: 1fr 1fr;">
                <div class="w-100">
                    <div>
                        <label for="facebook" class="form-label">رابط فيسبوك </label>
                        <input type="text" class="form-control" id="facebook" v-model="facebook">
                    </div>
                </div>
                <div class="w-100">
                    <div>
                        <label for="instagram" class="form-label">رابط انستجرام </label>
                        <input type="text" class="form-control" id="instagram" v-model="instagram">
                    </div>
                </div>
            </div>
            <div class="w-100 mb-4 gap-2" style="display: grid; grid-template-columns: 1fr 1fr;">
                <div class="w-100">
                    <div>
                        <label for="tiktok" class="form-label">رابط تيك توك </label>
                        <input type="text" class="form-control" id="tiktok" v-model="tiktok">
                    </div>
                </div>
                <div class="w-100">
                    <div>
                        <label for="youtube" class="form-label">رابط يوتيوب </label>
                        <input type="text" class="form-control" id="youtube" v-model="youtube">
                    </div>
                </div>
            </div>

            <div class="w-100 mb-4 gap-2" style="display: grid; grid-template-columns: 1fr 1fr;">
                <div class="w-100">
                    <div>
                        <label for="x" class="form-label">رابط اكس </label>
                        <input type="text" class="form-control" id="x" v-model="x">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 mt-5"  :class="(!showPrices ? 'd-none' : '')">
        <div>
            <div class="w-100 mb-4 gap-2" style="display: grid; grid-template-columns: 1fr 1fr;">
                <div class="w-100">
                    <div>
                        <label for="gold_18" class="form-label">ذهب عيار 18</label>
                        <input type="text" class="form-control" id="gold_18" v-model="gold_18">
                    </div>
                </div>
                <div class="w-100">
                    <div>
                        <label for="gold_21" class="form-label">ذهب عيار 21</label>
                        <input type="text" class="form-control" id="gold_21" v-model="gold_21">
                    </div>
                </div>
                <div class="w-100">
                    <div>
                        <label for="gold_24" class="form-label">ذهب عيار 24</label>
                        <input type="text" class="form-control" id="gold_24" v-model="gold_24">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pop-up show-code-pop-up card" v-if="showCodePopUp" style="padding: 1rem;width: 730px;display: flex;flex-direction: column;justify-content: center;align-items: center;max-width: 90vw;gap: 20px;">
        <div class="form-group w-100 text-center">
            <label for="code"><h1>Enter Your Html code</h1></label>
            <textarea dir="ltr" name="code" id="code" rows="10" class="form-control" v-model="code" style="width: 100%;resize: none"></textarea>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-light"  @click="this.showCodePopUp = false">Cancel</button>
            <button class="btn btn-secondary" @click="insertHTML(this.code, current_article_id);this.showCodePopUp = false">insert</button>
        </div>
    </div>
    <div class="hide-content" v-if="showImages || showSliderPopUp || showCodePopUp"></div>
    <div class="pop-up show-images-pop-up card" v-if="showImages" style="  z-index: 999999999999999999999999999;min-width: 90vw;height: 90vh;padding: 20px;display: flex;flex-direction: column;justify-content: space-between;gap: 1rem;">
        <input type="text" name="search" id="search" class="form-control w-25 mb-2" placeholder="بحث" v-model="search" @input="getSearchImages(this.search)">
        <div class="imgs p-2 gap-3" v-if="images && images.length" style="display: flex;grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));flex-wrap: wrap;height: 100%;overflow: auto;">
            <div class="img" @click="this.choosed_img = '/images/uploads/' + img.path; this.choosed_img_title = img.title" v-for="(img, index) in images" :key="img.id" style="width: 260px;height: 230px;overflow: hidden;padding: 10px;border-radius: 1rem;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;position: relative">
                <img :src="'/images/uploads/' + img.path" id="preview" alt="img logo" style="width: 100%;height: 100%;object-fit: contain;">
            </div>
        </div>
        <div class="pagination w-100 d-flex gap-2 justify-content-center mt-3" v-if="last_page > 1">
            <div v-for="page_num in last_page" :key="page_num" >
                <label :for="`page_num_${page_num}`" class="btn btn-primary" :class="page_num == page ? 'active' : ''">@{{ page_num }}</label>
                <input type="radio" class="d-none" name="page_num" :id="`page_num_${page_num}`" v-model="page" :value="page_num" @change="!search ? getImages() : getSearchImages(this.search)">
            </div>
        </div>
        <h1 v-if="images && !images.length && !search">لا توجد صور</h1>
        <div class="hide-content" v-if="showSettingsPopUp"></div>
        <div class="pop-up card p-3" v-if="showSettingsPopUp">
            <h2 class="mb-3 text-center">Set Image Title</h2>
            <div class="img">
                <img :src="`/images/uploads/${img_for_seo.path}`" alt="" style="margin: auto;width: 100%;object-fit: contain;object-fit: cover;max-width: 340px;margin-bottom: 10px;border-radius: 10px;">
            </div>
            <div class="form-group mb-2">
                <label for="title" class="w-100" dir="ltr">Image Title</label>
                <input type="text" name="title" id="title" class="form-control" v-model="img_for_seo_title">
            </div>
            <div class="d-flex gap-2 justify-content-center mt-2">
                <button class="btn btn-light"  @click="this.showSettingsPopUp = false">Cancel</button>
                <button class="btn btn-secondary" @click="setTitle()">
                    Set Title
                </button>
            </div>
        </div>
        <div class="foot" style="display: flex;width: 100%;justify-content: space-between;gap: 1rem;">
            <button class="btn btn-primary" @click="this.showUploadPopUp = true">تحميل صورة</button>
            <div class="hide-content" v-if="showUploadPopUp"></div>
            <div class="pop-up card p-3" v-if="showUploadPopUp">
                <label for="image" class="mb-2">اختر ملف صورة</label>
                <input type="file" name="image" id="image" class="form-control mb-4" @change="imageChanges">
                <div class="d-flex gap-2 w-100 justify-content-center">
                    <button class="btn btn-light"  @click="this.showUploadPopUp = false">الغاء</button>
                    <button class="btn btn-secondary" @click="uploadImage(image)">
                        اضافة صورة
                    </button>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light"  @click="this.showImages = false; this.search = null; getSearch()">الغاء</button>
                <button class="btn btn-success"  @click="insertImgToArticle()">اختار</button>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-50 form-control button mb-4" style="height: fit-content;margin: auto; display: block" @click="save"> حفظ </button>
</div>
@endsection

@section('scripts')
<!-- Swiper JS -->
<script src="{{ asset('/libs/swiper.js') }}"></script>

<!-- Initialize Swiper -->
<script>
window.onload = function() {
    var swiper = new Swiper(".mySwiper", {
      pagination: {
        el: ".swiper-pagination",
        type: "fraction",
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
};
</script>

<script>
const { createApp, ref } = Vue;

createApp({
  data() {
    return {
        showAbout: true,
        showPrivacy: false,
        showContact: false,
        showPrices: false,
        showAds: false,
        images: null,
        showImages: false,
        showUploadPopUp: false,
        image: null,
        choosed_img: null,
        current_article_id: null,
        tagInput: '',
        showSliderPopUp: false,
        showCodePopUp: false,
        slider_imgs: [],
        code: '',
        phone: '{{(isset($settingsArray["phone"]) && $settingsArray["phone"]["value"]) ? $settingsArray["phone"]["value"] : ''}}',
        email: '{{(isset($settingsArray["email"]) && $settingsArray["email"]["value"]) ? $settingsArray["email"]["value"] : ''}}',
        facebook: '{{(isset($settingsArray["facebook"]) && $settingsArray["facebook"]["value"]) ? $settingsArray["facebook"]["value"] : ''}}',
        instagram: '{{(isset($settingsArray["instagram"]) && $settingsArray["instagram"]["value"]) ? $settingsArray["instagram"]["value"] : ''}}',
        tiktok: '{{(isset($settingsArray["tiktok"]) && $settingsArray["tiktok"]["value"]) ? $settingsArray["tiktok"]["value"] : ''}}',
        youtube: '{{(isset($settingsArray["youtube"]) && $settingsArray["youtube"]["value"]) ? $settingsArray["youtube"]["value"] : ''}}',
        x: '{{(isset($settingsArray["x"]) && $settingsArray["x"]["value"]) ? $settingsArray["x"]["value"] : ''}}',
        header_ad: '{{(isset($settingsArray["header_ad"]) && $settingsArray["header_ad"]["value"]) ? $settingsArray["header_ad"]["value"] : ''}}',
        header_ad_url: '{{(isset($settingsArray["header_ad_url"]) && $settingsArray["header_ad_url"]["value"]) ? $settingsArray["header_ad_url"]["value"] : ''}}',
        hero_first_ad: '{{(isset($settingsArray["hero_first_ad"]) && $settingsArray["hero_first_ad"]["value"]) ? $settingsArray["hero_first_ad"]["value"] : ''}}',
        hero_first_ad_url: '{{(isset($settingsArray["hero_first_ad_url"]) && $settingsArray["hero_first_ad_url"]["value"]) ? $settingsArray["hero_first_ad_url"]["value"] : ''}}',
        main_left: '{{(isset($settingsArray["main_left"]) && $settingsArray["main_left"]["value"]) ? $settingsArray["main_left"]["value"] : ''}}',
        main_left_url: '{{(isset($settingsArray["main_left_url"]) && $settingsArray["main_left_url"]["value"]) ? $settingsArray["main_left_url"]["value"] : ''}}',
        main_right: '{{(isset($settingsArray["main_right"]) && $settingsArray["main_right"]["value"]) ? $settingsArray["main_right"]["value"] : ''}}',
        main_right_url: '{{(isset($settingsArray["main_right_url"]) && $settingsArray["main_right_url"]["value"]) ? $settingsArray["main_right_url"]["value"] : ''}}',
        square_ad: '{{(isset($settingsArray["square_ad"]) && $settingsArray["square_ad"]["value"]) ? $settingsArray["square_ad"]["value"] : ''}}',
        square_ad_url: '{{(isset($settingsArray["square_ad_url"]) && $settingsArray["square_ad_url"]["value"]) ? $settingsArray["square_ad_url"]["value"] : ''}}',
        square_sm_ad: '{{(isset($settingsArray["square_sm_ad"]) && $settingsArray["square_sm_ad"]["value"]) ? $settingsArray["square_sm_ad"]["value"] : ''}}',
        square_sm_ad_url: '{{(isset($settingsArray["square_sm_ad_url"]) && $settingsArray["square_sm_ad_url"]["value"]) ? $settingsArray["square_sm_ad_url"]["value"] : ''}}',
        horizon_sec_ad: '{{(isset($settingsArray["horizon_sec_ad"]) && $settingsArray["horizon_sec_ad"]["value"]) ? $settingsArray["horizon_sec_ad"]["value"] : ''}}',
        horizon_sec_ad_url: '{{(isset($settingsArray["horizon_sec_ad_url"]) && $settingsArray["horizon_sec_ad_url"]["value"]) ? $settingsArray["horizon_sec_ad_url"]["value"] : ''}}',
        horizon_third_ad: '{{(isset($settingsArray["horizon_third_ad"]) && $settingsArray["horizon_third_ad"]["value"]) ? $settingsArray["horizon_third_ad"]["value"] : ''}}',
        horizon_third_ad_url: '{{(isset($settingsArray["horizon_third_ad_url"]) && $settingsArray["horizon_third_ad_url"]["value"]) ? $settingsArray["horizon_third_ad_url"]["value"] : ''}}',
        forSlider: false,
        search_tags: null,
        preview_img: null,
        current_ad: null,
        search: null,
        gold_24: '{{(isset($settingsArray["gold_24"]) && $settingsArray["gold_24"]["value"]) ? $settingsArray["gold_24"]["value"] : ''}}',
        gold_21: '{{(isset($settingsArray["gold_21"]) && $settingsArray["gold_21"]["value"]) ? $settingsArray["gold_21"]["value"] : ''}}',
        gold_18: '{{(isset($settingsArray["gold_18"]) && $settingsArray["gold_18"]["value"]) ? $settingsArray["gold_18"]["value"] : ''}}',
        page: 1,
        total: 0,
        last_page: 0,
    }
  },
  methods: {
    insertSliderContent(element) {
        if (this.slider_imgs.length > 3) {
            // Get the target element where you want to insert the content
            var targetElement = document.getElementById(element);

            // Get the content from the 'slider' element
            var sliderContent = document.getElementById('slider').innerHTML;
            document.getElementById(element).focus();
            document.execCommand('insertHTML', false, sliderContent);
            this.showSliderPopUp = false;
            this.slider_imgs = []
            this.setValuesToNull()
        } else {
            $("#errors").fadeIn("slow");
            document.getElementById("errors").innerHTML = "";
            let error = document.createElement("div");
            error.classList = "error";
            error.innerHTML =
                "يجب ان يحتوي الاسلايدر علي اربعة صور ع الاقل";
            document.getElementById("errors").append(error);
            setTimeout(() => {
                $("#errors").fadeOut("slow");
            }, 2000);
        }
    },
    async save() {
      $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`/admin/settings/store`, {
                about: document.getElementById('about').innerHTML,
                privacy: document.getElementById('privacy').innerHTML,
                adsPage: document.getElementById('adsPage').innerHTML,
                phone: this.phone,
                email: this.email,
                facebook: this.facebook,
                instagram: this.instagram,
                tiktok: this.tiktok,
                youtube: this.youtube,
                x: this.x,
                header_ad: this.header_ad,
                header_ad_url: this.header_ad_url,
                hero_first_ad: this.hero_first_ad,
                main_left: this.main_left,
                main_left_url: this.main_left_url,
                main_right: this.main_right,
                main_right_url: this.main_right_url,
                square_ad: this.square_ad,
                square_ad_url: this.square_ad_url,
                square_sm_ad: this.square_sm_ad,
                square_sm_ad_url: this.square_sm_ad_url,
                horizon_sec_ad: this.horizon_sec_ad,
                horizon_sec_ad_url: this.horizon_sec_ad_url,
                horizon_third_ad: this.horizon_third_ad,
                horizon_third_ad_url: this.horizon_third_ad_url,
                gold_24: this.gold_24,
                gold_21: this.gold_21,
                gold_18: this.gold_18,
            },
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            );
            if (response.data.status === true) {
            document.getElementById('errors').innerHTML = ''
            let error = document.createElement('div')
            error.classList = 'success'
            error.innerHTML = response.data.message
            document.getElementById('errors').append(error)
            $('#errors').fadeIn('slow')
            $('.loader').fadeOut()
            setTimeout(() => {
                $('#errors').fadeOut('slow')
                window.location.href = '{{ route("admin.dashboard") }}'
            }, 2000);
            } else {
            $('.loader').fadeOut()
            document.getElementById('errors').innerHTML = ''
            $.each(response.data.errors, function (key, value) {
                let error = document.createElement('div')
                error.classList = 'error'
                error.innerHTML = value
                document.getElementById('errors').append(error)
            });
            $('#errors').fadeIn('slow')
            setTimeout(() => {
                $('input').css('outline', 'none')
                $('#errors').fadeOut('slow')
            }, 5000);
            }

        } catch (error) {
            document.getElementById('errors').innerHTML = ''
            let err = document.createElement('div')
            err.classList = 'error'
            err.innerHTML = 'server error try again later'
            document.getElementById('errors').append(err)
            $('#errors').fadeIn('slow')
            $('.loader').fadeOut()

            setTimeout(() => {
            $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    addTag() {
      if (this.tagInput.trim() !== '') {
        this.tags.push(this.tagInput.trim());
        this.tagInput = '';
      }
    },
    removeTag(index) {
      this.tags.splice(index, 1);
    },
    async getTagSearch(search_words) {
        try {
            const response = await axios.post(`/admin/tags/search`, {
                search_words: search_words,
            },
            );
            if (response.data.status === true) {
                if (search_words != '')
                    this.search_tags = response.data.data.data
                else
                    this.search_tags = []
            } else {
                document.getElementById('errors').innerHTML = ''
                $.each(response.data.errors, function (key, value) {
                    let error = document.createElement('div')
                    error.classList = 'error'
                    error.innerHTML = value
                    document.getElementById('errors').append(error)
                });
                $('#errors').fadeIn('slow')
                setTimeout(() => {
                    $('input').css('outline', 'none')
                    $('#errors').fadeOut('slow')
                }, 5000);
            }

        } catch (error) {
            document.getElementById('errors').innerHTML = ''
            let err = document.createElement('div')
            err.classList = 'error'
            err.innerHTML = 'server error try again later'
            document.getElementById('errors').append(err)
            $('#errors').fadeIn('slow')
            $('.loader').fadeOut()
            this.Tags_data = false
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    async getSearchImages(search_words) {
        try {
            const response = await axios.post(`/admin/images/search?page=${this.page}`, {
                search_words: search_words,
            },
            );
            if (response.data.status === true) {
                this.images = response.data.data.data
                this.total = response.data.data.total
                this.last_page = response.data.data.last_page
            } else {
                document.getElementById('errors').innerHTML = ''
                $.each(response.data.errors, function (key, value) {
                    let error = document.createElement('div')
                    error.classList = 'error'
                    error.innerHTML = value
                    document.getElementById('errors').append(error)
                });
                $('#errors').fadeIn('slow')
                setTimeout(() => {
                    $('input').css('outline', 'none')
                    $('#errors').fadeOut('slow')
                }, 5000);
            }

        } catch (error) {
            document.getElementById('errors').innerHTML = ''
            let err = document.createElement('div')
            err.classList = 'error'
            err.innerHTML = 'server error try again later'
            document.getElementById('errors').append(err)
            $('#errors').fadeIn('slow')
            $('.loader').fadeOut()
            this.languages_data = false
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    async getImages() {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.get(`/admin/images/get_images?page=${this.page}`
            );
            if (response.data.status === true) {
                $('.loader').fadeOut()
                this.images = response.data.data.data
                this.total = response.data.data.total
                this.last_page = response.data.data.last_page
            } else {
                $('.loader').fadeOut()
                document.getElementById('errors').innerHTML = ''
                $.each(response.data.errors, function (key, value) {
                    let error = document.createElement('div')
                    error.classList = 'error'
                    error.innerHTML = value
                    document.getElementById('errors').append(error)
                });
                $('#errors').fadeIn('slow')
                setTimeout(() => {
                    $('input').css('outline', 'none')
                    $('#errors').fadeOut('slow')
                }, 5000);
            }

        } catch (error) {
            document.getElementById('errors').innerHTML = ''
            let err = document.createElement('div')
            err.classList = 'error'
            err.innerHTML = 'server error try again later'
            document.getElementById('errors').append(err)
            $('#errors').fadeIn('slow')
            $('.loader').fadeOut()
            this.languages_data = false
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    async uploadImage(image) {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`/admin/images/upload`, {
                img: image,
            },
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }

            );
            if (response.data.status === true) {
                document.getElementById('errors').innerHTML = ''
                let error = document.createElement('div')
                error.classList = 'success'
                error.innerHTML = response.data.message
                document.getElementById('errors').append(error)
                $('#errors').fadeIn('slow')
                $('.loader').fadeOut()
                this.showUploadPopUp = false;
                this.getImages()
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3000);
            } else {
                $('.loader').fadeOut()
                document.getElementById('errors').innerHTML = ''
                $.each(response.data.errors, function (key, value) {
                    let error = document.createElement('div')
                    error.classList = 'error'
                    error.innerHTML = value
                    document.getElementById('errors').append(error)
                });
                $('#errors').fadeIn('slow')
                setTimeout(() => {
                    $('input').css('outline', 'none')
                    $('#errors').fadeOut('slow')
                }, 5000);
            }

        } catch (error) {
            document.getElementById('errors').innerHTML = ''
            let err = document.createElement('div')
            err.classList = 'error'
            err.innerHTML = 'server error try again later'
            document.getElementById('errors').append(err)
            $('#errors').fadeIn('slow')
            $('.loader').fadeOut()
            this.languages_data = false
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    pushCatTranslation(id, name) {
        this.category_translations.push({
            lang_id: id,
            name: name
        })
    },
    prevSubCat() {
        this.getSubCategories().then(() => {
            if (this.sub_categories_data.length) {
                this.show_sub_categories = true
            }
        })
    },
    setValuesToNull () {
        this.chooseImage = null
        this.current_article_id = null
        this.showImages = null
        this.forAlbum = false
        this.forSlider = false
    },
    execCommand(command) {
        document.execCommand(command, false, null);
    },
    insertHTML(html, element, key) {
        document.getElementById(element).focus();
        document.execCommand('insertHTML', false, html);
    },
    photoChanges(event) {
        this.thumbnail = event.target.files[0];
    },
    imageChanges(event) {
        this.image = event.target.files[0];
    },
    async getContent () {
        if (document.getElementById('about') && document.getElementById('about').innerHTML != '')
            this.content = document.getElementById('about').innerHTML;
    },
    chooseImage(imagePath) {
        this.choosed_img = '/images/uploads/' + imagePath;
    },
    previewThumbnail () {
        this.preview_img = this.choosed_img
        if (this.current_ad == "header_ad")
            this.header_ad = this.choosed_img

        if (this.current_ad == "hero_first_ad")
            this.hero_first_ad = this.choosed_img

        if (this.current_ad == "main_right")
            this.main_right = this.choosed_img

        if (this.current_ad == "main_left")
            this.main_left = this.choosed_img

        if (this.current_ad == "square_ad")
            this.square_ad = this.choosed_img

        if (this.current_ad == "square_sm_ad")
            this.square_sm_ad = this.choosed_img

        if (this.current_ad == "horizon_third_ad")
            this.horizon_third_ad = this.choosed_img

        if (this.current_ad == "horizon_sec_ad")
            this.horizon_sec_ad = this.choosed_img

        this.showImages = false
    },
    insertImgToArticle () {
        if (this.current_article_id) {
            if (this.choosed_img) {
                this.insertHTML('<img src="' + this.choosed_img + '" />', this.current_article_id)
                this.chooseImage = null
                this.current_article_id = null
                this.showImages = null
            }else {
                document.getElementById('errors').innerHTML = ''
                let err = document.createElement('div')
                err.classList = 'error'
                err.innerHTML = 'Please Choose an image or uploade one'
                document.getElementById('errors').append(err)
                $('#errors').fadeIn('slow')
                $('.loader').fadeOut()
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

            }
        } else if (this.forSlider) {
            this.slider_imgs.push(this.choosed_img)
            this.chooseImage = null
            this.current_article_id = null
            this.showImages = null
        } else if (this.forAlbum) {
            this.album_imgs.push(this.choosed_img)
            this.chooseImage = null
            this.current_article_id = null
            this.showImages = null
        }
        else {
            this.previewThumbnail()
        }

    },
  },
  created() {
    this.getImages()
  },
  mounted() {
    $("#thumbnail").change(function () {
        // check if file is valid image
        var file = this.files[0];
        var fileType = file.type;
        var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            document.getElementById("errors").innerHTML = "";
            let error = document.createElement("div");
            error.classList = "error";
            error.innerHTML =
                "Invalid file type. Please choose a GIF, JPEG, or PNG image.";
            document.getElementById("errors").append(error);
            $("#errors").fadeIn("slow");
            setTimeout(() => {
                $("#errors").fadeOut("slow");
            }, 2000);

            $(this).val(null);
            $("#preview").attr(
                "src",
                this.thumbnail_path ? '/images/uploads/Articles_thumbnail/' + this.thumbnail_path : "/dashboard/images/add_image.svg"
            );
            $(".photo_group i").removeClass("fa-edit").addClass("fa-plus");
        } else {
            // display image preview
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#preview").attr("src", e.target.result);
                $(".photo_group  i")
                    .removeClass("fa-plus")
                    .addClass("fa-edit");
                $(".photo_group label >i").fadeOut("fast");
            };
            reader.readAsDataURL(file);
        }
    });
    $("#image").change(function () {
        // check if file is valid image
        var file = this.files[0];
        var fileType = file.type;
        var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            document.getElementById("errors").innerHTML = "";
            let error = document.createElement("div");
            error.classList = "error";
            error.innerHTML =
                "Invalid file type. Please choose a GIF, JPEG, or PNG image.";
            document.getElementById("errors").append(error);
            $("#errors").fadeIn("slow");
            setTimeout(() => {
                $("#errors").fadeOut("slow");
            }, 2000);

            $(this).val(null);
        } else {
            // display image preview
            var reader = new FileReader();
            reader.onload = function (e) {
            };
            reader.readAsDataURL(file);
        }
    });
    $(document).on('click', '.imgs .img', function () {
        $(this).css('border', '1px solid #13DEB9')
        $(this).siblings().css('border', 'none')
    })

  },
}).mount('#admins_wrapper')
</script>
@endsection
