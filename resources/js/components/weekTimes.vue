<template>
    <div class="week_times_container">
        <form :action="this.url" method="post">

            <input type="hidden" name="_token" :value="this.csrf" autocomplete="off">

            <div class="row full-width justify-content-center">
                <div class="col-8">
                    <div class="panel_top_description">
                        <i class="fa-regular fa-circle-question"></i>
                        <span> در این قسمت برنامه کاری هفتگی خود را وارد کنید. می توانید برای روز های مختلف هفته بازه های
                            مختلفی تعیین کنید. برای مثال از ساعت 8 الی 12 و از ساعت 14 الی 20. سیستم از این زمان بندی
                            برای نمایش نوبت به کاربر استفاده می کند. شما می توانید از بخش جدول زمانی برنامه روز های خود
                            را مشاهده کرده و در صورت نیاز ساعاتی از روزی خاص را تعطیل کنید بدون اینکه نیاز به تغییر
                             برنامه هفتگی باشد. اگر روزی از هفته را کار نمی کنید همه ی بازه های زمانی ان را حذف کنید.</span>
                    </div>
                    <div v-for="(n,i) in 7">
                        <div class="week_times_item">
                            <div class="row full-width">
                                <div class="col-2">
                                    <span>{{ week_day(i) }}</span>
                                </div>
                                <div class="col-10">
                                    <div v-for="(index,i2) in times[i]" class="row week_times_item_option">
                                        <div class="col-5">
                                            <label class="form-label">از</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control text-start number_format_input"
                                                       :name="'d['+i+']['+i2+'][start]'"
                                                       placeholder="" min="0" max="24" required
                                                       v-model="t_model[i][i2]['start']">
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <label class="form-label">تا</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control text-start number_format_input"
                                                       :name="'d['+i+']['+i2+'][end]'"
                                                       placeholder="" min="0" max="24" required
                                                       v-model="t_model[i][i2]['end']">
                                            </div>
                                        </div>
                                        <div v-if="index==times[i]" class="col-2">
                                            <span class="btn times_table_mines" @click="delete_time(i)"><i
                                                class="fa-solid fa-circle-minus"></i> حذف </span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="add_service_attribute">
                                                <span class="btn btn-primary" @click="add_new_time(i)">+ {{
                                                        trs.add_new_time
                                                    }}</span>
                                                <!--                                                <span data-bs-toggle="tooltip" data-bs-placement="top"-->
                                                <!--                                                      data-bs-title="Tooltip sas asa s on top">-->
                                                <!--                                                    <i class="fa-solid fa-circle-info"></i>-->
                                                <!--                                                </span>-->
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <button class="btn btn-secondary half-width">
                    {{ trs.submit }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: ['trs', 'url', 'csrf', 'schedule'],
    name: 'weekTimes',
    created() {
        let vm = this;
        for (let i = 0; i < 7; i++) {
            vm.t_model[i] = [];
            vm.t_model[i][0] = [];
            vm.t_model[i][0]['start'] = null;
            vm.t_model[i][0]['end'] = null;
            if (this.schedule) {
                let day_counter = i - 1 >= 0 ? i - 1 : 6;
                JSON.parse(this.schedule['day' + day_counter]).forEach(function (item, key) {
                    vm.t_model[i][key] = [];
                    vm.t_model[i][key]['start'] = item["0"];
                    vm.t_model[i][key]['end'] = item["1"];
                });
            }
        }

        console.log(this.t_model);
    },
    methods: {
        add_new_time(i) {
            this.t_model[i][this.times[i]] = [];
            this.t_model[i][this.times[i]]['start'] = null;
            this.t_model[i][this.times[i]]['end'] = null;
            this.times[i]++;

        },
        delete_time(i) {
            this.times[i]--;
        },
        week_day(i) {
            switch (i) {
                case 0:
                    return "شنبه";
                case 1:
                    return "یک شنبه";
                case 2:
                    return "دو شنبه";
                case 3:
                    return "سه شنبه";
                case 4:
                    return "چهار شنبه";
                case 5:
                    return "پنج شنبه";
                case 6:
                    return "جمعه";
            }
        },
    },
    data() {
        return {
            times: [
                Math.max(0, this.schedule ? JSON.parse(this.schedule['day6']).length : 0),
                Math.max(0, this.schedule ? JSON.parse(this.schedule['day0']).length : 0),
                Math.max(0, this.schedule ? JSON.parse(this.schedule['day1']).length : 0),
                Math.max(0, this.schedule ? JSON.parse(this.schedule['day2']).length : 0),
                Math.max(0, this.schedule ? JSON.parse(this.schedule['day3']).length : 0),
                Math.max(0, this.schedule ? JSON.parse(this.schedule['day4']).length : 0),
                Math.max(0, this.schedule ? JSON.parse(this.schedule['day5']).length : 0),
            ],
            t_model: []
        }
    },
}

</script>
