<template>
    <div class="alert alert-success" role="alert" v-show="code_sent">
        کد یکبار مصرف به شماره موبایل شما ارسال شد !
    </div>
    <div v-if="error" class="alert alert-danger">
        <ul>
            <li>{{ error }}</li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="input-group mg-b-10">
                <input type="text" class="form-control text-start"
                       id="mobile"
                       name="mobile" dir="ltr"
                       v-model="mobile"
                       :placeholder="trs.mobile" required="">
            </div>
            <div class="row" v-if="this.mobile != model.mobile">
                <div class="col-12">
                    <p>برای تغییر شماره موبایل نیاز به تایید آن دارید.</p>
                </div>
                <div class="col-6">
                    <span @click="send_otp" class="btn btn-secondary full-width">
                        دریافت کد تایید
                    </span>
                </div>
                <div class="col-6">
                    <div class="input-group mg-b-10">
                        <input type="text" class="form-control text-start"
                               id="code"
                               name="code" dir="ltr"
                               :placeholder="trs.verify_code" required="">
                    </div>
                </div>

            </div>

        </div>
    </div>

</template>

<script>
export default {
    props: ["trs", "model", 'send_otp_url', 'csrf'],
    name: 'changeMobile',
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
                        this.code = response.data.code; //should delete in last version
                    } else {
                        this.code_sent = 0;
                        this.error = response.data.error;
                    }
                });

        },
    },
    data() {
        return {
            mobile: this.model.mobile,
            code_sent: 0,
            error: null,
        }
    },
}

</script>
