<template>


    <div class="authentication-wrapper authentication-cover logindd">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-6 align-items-center">
                <div class="flex-row text-center mx-auto">
                    <div class="mx-auto">
                        <h3>{{ setting.title }}</h3>
                        <p>
                            <b></b>تلفن همراه وارد شده می بایست به نام فرد احراز هویت کننده باشد.
                            <br>
                            در زمان ورود حتما شماره تلفن همراهی را وارد کنید که به نام شما است.
                        </p>
                    </div>
                </div>
            </div>

            <div class="d-flex col-12 col-lg-6 align-items-center authentication-bg p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-4">
                        <a :href="base_url" class="app-brand-link gap-2 mb-2">
                <span class="app-brand-logo demo">
                 <img :src="setting.logo_src" style="width:160px;">
                </span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">به {{ setting.title }} خوش آمدید</h4>
                    <p class="mb-4">اولین سایت جامع خدمات</p>
                    <div class="alert alert-success" role="alert" v-show="code_sent">
                        کد یکبار مصرف به شماره موبایل شما ارسال شد !
                    </div>

                    <div v-if="error" class="alert alert-danger">
                        <ul>
                            <li>{{ error }}</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label for="mobile" class="form-label">تلفن همراه</label>
                        <div class="input-group input-group-merge">
                            <input type="text" class="form-control text-start" dir="ltr" id="mobile" v-model="mobile"
                                   placeholder="تلفن همراه خود را وارد کنید" maxlength=11
                                   minlength=11>
                        </div>
                    </div>
                    <div class="mb-3 form-password-toggle">

                        <div class="row">
                            <div class="col-lg-4 mg-b-10">
                                <a class="btn btn-info d-grid w-100 submit_form_OTP" @click="send_otp()">ارسال کد</a>
                            </div>
                            <div class="col-lg-8">
                                <div class="input-group input-group-merge" :class="code_sent==0 ? 'half_clear' : ''">
                                    <input type="text" id="code" class="form-control text-start" dir="ltr"
                                           placeholder="کد یکبار مصرف"
                                           :disabled="code_sent==0 ? true : false"
                                           v-model="code" maxlength=6>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3 form-password-toggle">

                        <div class="row">
                            <div class="col-lg-6">
                                <input class="form-check-input" type="checkbox"
                                       id="remember" v-model="remember"
                                       name="remember">
                                <label class="form-check-label"
                                       for="remember">
                                    <span class="margin-right-10"> مرا به خاطر بسپار؟ </span>
                                </label>
                            </div>

                        </div>
                    </div>

                    <button class="btn btn-primary text-white d-grid w-100" @click="login()">ورود</button>


                </div>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    props: ['trs', 'base_url', 'setting', 'csrf', 'send_otp_url', 'login_url'],
    name: 'login',
    methods: {
        send_otp() {

            const headers = {
                'X-CSRF-TOKEN': this.csrf
            };
            const data = {
                'mobile': this.mobile,
            };

            axios.post(this.send_otp_url, data, {headers})
                .then(response => {
                    if (response.data.status === 0) {
                        this.code_sent = 1;
                        this.error = null;
                        this.code = response.data.code; //should delete i last version
                    } else {
                        this.code_sent = 0;
                        this.error = response.data.error;
                    }
                });

        },
        login() {
            const headers = {
                'X-CSRF-TOKEN': this.csrf
            };
            const data = {
                'mobile': this.mobile,
                'code': this.code,
                'remember': this.remember,
            };

            axios.post(this.login_url, data, {headers})
                .then(response => {
                    if (response.data.status === 0) {
                        window.location.href = response.data.url;
                    } else {
                        this.code_sent = 0;
                        this.error = response.data.error;
                    }
                });

        }
    },
    data() {
        return {
            'code_sent': 0,
            'error': null,
            'mobile': null,
            'code': null,
            'remember': null,
        }
    },
}

</script>
