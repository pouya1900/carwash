<?php
return [
    'exception' => [
        'methodNotFound' => 'متد' . ":method" . 'یافت نشد.',
    ],
    'auth'      => [
        'appSecretRequiredMessage' => 'کلید دسترسی الزامی است.',
        'appSecretFailMessage'     => 'کلید دسترسی معتبر نمی باشد.',
        'apiTokenRequired'         => 'کد دسترسی کاربر الزامی می باشد.',
        'apiTokenExpired'          => 'کد دسترسی کاربر منقضی شده است.',
        'apiTokenInvalid'          => 'کد دسترسی کاربر معتبر نمی باشد.',
        'makeUserTokenFail'        => 'بروز خطا در ایجاد کد دسترسی کاربر.',

        'forceUpdateRequire' => 'نسخه نرم افزار مورد استفاده منسوخ شده است. لطفا نرم افزار را بروزرسانی کنید.',

        'logOutSuccess' => 'خروج کاربر از نرم افزار با موفقیت انجام شد.',

        'deviceDuplicated' => 'در حال حاضر کاربر با دستگاه دیگری وارد شده است.',

        'activationCodeSent'         => 'کد فعالسازی برای شما ارسال گردید.',
        'activationCodeInvalid'      => 'کد فعالسازی نامعتبر می باشد.',
        'activationCodeExpired'      => 'کد فعالسازی منقضی شده است.',
        'roleDuplicated'             => 'این کاربر در حال حاضر به عنوان  :role ثبت نام کرده است.',
        'activationCodeFail'         => 'بروز خطا در ایجاد کد فعالسازی',
        'activationCodeSendFail'     => 'بروز خطا در ارسال کد فعالسازی',
        'activationCodeWaitTimeFail' => 'محدودیت ' . ':time' . ' ثانیه ای برای ارسال کد فعالسازی',

        'otpBlock'           => 'درخواست کاربر بلاک شده است. لطفا دقایقی دیگر تلاش کنید',
        'login_type_invalid' => 'نوع کاربر نامعتبر است.',
        'existUsername'      => 'نام کاربری موجود می باشد',
        'notExistUsername'   => 'نام کاربری در دسترس می باشد',
        'alreadyLoggedIn'    => 'کاربر قبلا وارد شده است.',

        'notPermission' => 'برای دسترسی به این قسمت حساب خود را ارتقا دهید.',
    ],
    'response'  => [
        'success'       => 'عملیات با موفقیت انجام شد.',
        'failed'        => 'بروز خطا در انجام عملیات',
        'failedStatus'  => 'failed',
        'successStatus' => 'success',
    ],
    'push'      => [
        'success' => 'ارسال با موفقیت انجام شد.',
        'failed'  => 'بروز خطا در انجام عملیات',],

];
