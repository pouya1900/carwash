<?php
return [
    'operationSuccess' => 'عملیات با موفقیت انجام شد',
    'operationFail'    => 'خطا در انجام عملیات',

    'crud' => [
        'createdModelSuccess'   => 'رکورد جدید با موفقیت اضافه شد.',
        'createdModelFail'      => 'افزودن رکورد ناموفق بود. لطفا مجددا تلاش نمایید یا با پشتیبانی سایت تماس بگیرید.',
        'updatedModelSuccess'   => 'رکورد موردنظر با موفقیت ویرایش شد.',
        'updatedModelFail'      => 'ویرایش رکورد ناموفق بود. لطفا مجددا تلاش نمایید یا با پشتیبانی سایت تماس بگیرید.',
        'deletedModelSuccess'   => 'رکورد موردنظر با موفقیت حذف شد.',
        'deletedModelFail'      => 'حذف رکورد ناموفق بود. لطفا مجددا تلاش نمایید یا با پشتیبانی سایت تماس بگیرید.',
        'trashedModelSuccess'   => 'رکورد موردنظر با موفقیت به سطل زباله منتقل شد.',
        'unTrashedModelSuccess' => 'رکورد موردنظر با موفقیت بازیابی شد.',
        "illegalAccess"         => "شما دسترسی برای تغییر این رکورد را ندارید.",
        "exist"                 => "رکورد مورد نظر قبلا ذخیره شده است.",
    ],
    'log'  => [
        'createdModelSuccessLog'      => 'success [create]',
        'createdModelFailLog'         => 'fail [create]',
        'updatedModelSuccessLog'      => 'success [update]',
        'updatedModelFailLog'         => 'fail [update]',
        'deletedModelSuccessLog'      => 'success [delete]',
        'deletedModelFailLog'         => 'fail [delete]',
        'activatedModelSuccessLog'    => 'success [active]',
        'activatedModelFailLog'       => 'fail [active]',
        'deletedModelRequiredFailLog' => 'fail [delete] required by another model',
    ],

    'jwt'      => [
        'required' => '.کد دسترسی کاربر الزامی است',
        'invalid'  => 'کد دسترسی کاربر معتبر نمی باشد.',
        'expired'  => 'کد دسترسی کاربر منقضی شده است.',
    ],
    'header'   => [
        'secreatKeyInvalid'  => 'کد دسترسی نرم افزار نامعتبر می باشد.',
        'buildNumberInvalid' => 'نسخه مورد استفاده منسوخ شده است.',
    ],
    'response' => [
        'failed'   => 'بروز خطا در اجرای عملیات.',
        'success'  => 'عملیات با موفقیت انجام شد.',
        'notFound' => 'متاسفانه داده ای پیدا نشد.',
    ],

    'profile' => [
        'createRequired' => 'لطفا ابتدا پروفایل کاربر را ایجاد کنید.',
        'userNotFound'   => 'کاربر مورد نطر موجود نمی باشد',
        'followNotFound' => 'درخواست مورد نطر موجود نمی باشد',
    ],
    'auth'    => [
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
    'payment' => [
        'verifyFailed'         => 'بروز خطا در اعتبار سنجی پرداخت. در صورت کسر وجه از شما تا 72 ساعت آینده وجه به حساب شما برگشت داده خواهد شد.',
        'verifyOrderNumFailed' => 'عدم تطبیق شماره سفارش',
        'makePaymentFail'      => 'بروز خطا در ایجاد پرداخت. ',
        'completed'            => 'پرداخت با موفقیت انجام شد.',
        'exists'               => 'بروز خطا - تراکنش تکراری',
        'amountInvalid'        => 'مبلغ نامعتبر است.',
        'alreadyVerified'      => 'قبلا اعتبار سنجی شده است.',
        'insufficientError'    => "موجودی ناکافی",
    ],

    'support' => [
        'success' => 'با تشکر! پیام شما با موفقیت ارسال شد',
        'failed'  => 'متاسفانه ارسال پیام شما ناموفق بود. لطفا مجددا تلاش کنید',
    ],

    'comment' => [
        'success' => 'دیدگاه شما با موفقیت ثبت و پس از بررسی منتشر خواهد شد',
        'failed'  => 'متاسفانه ارسال دیدگاه شما ناموفق بود. لطفا مجددا سعی کنید',
    ],

    'report' => [
        'success' => 'گزارش شما با موفقیت ثبت شد و بررسی خواهد گردید',
        'failed'  => 'متاسفانه ثبت گزارش شما ناموفق بود. لطفا با پشتیبانی سایت تماس بگیرید.',
    ],

    'deleteImage' => [
        'success' => 'تصویر با موفقیت حذف شد.',
        'failed'  => 'متاسفانه حذف عکس ناموفق بود.',
    ],
    'uploadImage' => [
        'success' => 'تصویر با موفقیت اپلود شد.',
        'failed'  => 'متاسفانه اپلود عکس ناموفق بود.',
    ],
    'region'      => [
        'failed' => 'نوع منطقه نامعتبر',
    ],
    'mobileType'  => [
        'mci'     => 'همراه اول',
        'mtn'     => 'ایرانسل',
        'rightel' => 'رایتل',
        'taliya'  => 'تالیا',
    ],
    'gift'        => [
        'success'         => 'هدیه به مبلغ :value تومان با موفقیت دریافت شد.',
        'notCompleted'    => 'مراحل جایزه هنوز کامل نشده است.',
        'alreadyReceived' => 'هدیه قبلا دریافت شده است.',
    ],
    'reservation' => [
        "car_or_plate_required" => "وسیله نقلیه یا شماره پلاک وارد نشده است.",
        "cantCancel"            => "سفارش قابل لغو شدن نیست.",
        "cantUpdate"            => "سفارش قابل اپدیت شدن نیست.",
        "canceledSuccessful"    => "سفارش با موفقیت لغو شد.",
        "updatedSuccessful"     => "سفارش با موفقیت اپدیت شد. لطفا شماره سفارش را به پذیرش کارواش نشان داده و پذیرش شوید.",
    ],
]
?>


