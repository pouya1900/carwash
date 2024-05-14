<template>

    <div class="res_times_tab_container">
        <div class="owl-carousel" role="tablist">
            <div v-for="(day, index) in 10"
                 class="res_time_tab" :class="index==0 ? 'active' : ''"
                 data-bs-toggle="tab" role="tab"
                 :aria-controls="'res_pane'+index"
                 :data-bs-target="'#res_pane'+index"
                 :id="'res_tab'+index">
                <div>
                        <span>{{
                                new Intl.DateTimeFormat('fa-IR', {weekday: 'long'}).format(new Date(getDay(index)))
                            }}
                        </span>
                </div>
                <div>
                        <span>
                            {{
                                new Intl.DateTimeFormat('fa-IR', {
                                    day: "numeric",
                                    month: 'long'
                                }).format(new Date(getDay(index)))
                            }}
                        </span>
                </div>
            </div>
        </div>
    </div>

    <div class="res_times_table_container">
        <div v-for="(day, index) in 10" :id="'res_pane'+index" class="res_times_table tab-pane fade"
             :class="index==0 ? 'show active' : ''"
             role="tabpanel" :aria-labelledby="'res_tab'+index">

            <div class="time_table_body" id="time_table_body_mobile">
                <table class="table table-bordered">
                    <thead class="time_table_header">

                    <tr>
                        <th>ساعت</th>
                        <th>برنامه</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(time,i) in 24">
                        <td class="time_table_td_mobile">{{ i }} <small> (از ساعت {{ i }} تا ساعت {{ i + 1 }})</small></td>
                        <td :id="'time'+i" class="time_span time_table_td_mobile"
                            @click.prevent="startSelection(i,index)"
                            :class="this.isWorkTime(index,i) ? 'work_day_background' : ''">
                            <span v-show="this.isWorkTime(index,i)">.</span>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div v-if="this.selectedRange && this.selectedRange[index]"
                     class="selected_div_container">
                    <div v-for="(item2,i) in this.selectedRange[index]" class="selected_div" @click="openTime(index,i)"
                         :class="item2.f ? 'selected_div_f' : '' , item2.type=='s' ? 'selected_div_user' : '' "
                         :style="'height: '+getHeight(item2)+'%;'+'top: '+getTop(item2.start)+'%;'">
                        <div>
                            <span class="time_selected_label_title">{{ item2.start }} تا {{ item2.end + 1 }}</span>

                            <span v-if="item2.users?.length"
                                  class="time_selected_label_description">{{ item2.users.length }} رزرو</span>

                            <span v-else-if="item2.label" class="time_selected_label_description">{{
                                    item2.label
                                }}</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="label_modal_mobile" tabindex="-1"
         aria-labelledby="label_modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            @click="cancelLabel()"
                            aria-label="Close"></button>
                    <div class="modal-title text-center mb-4"><h4
                        class="mb-4 secondary-font">برچسب</h4></div>

                    <div class="mg-b-10">
                        <label class="form-label" for="time_label">برچسب</label>
                        <div class="input-group">
                            <input type="text"
                                   class="form-control text-start"
                                   id="time_label" v-model="time_label">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button @click="submitLabel()" data-bs-dismiss="modal"
                                    class="btn btn-secondary full-width">
                                {{ trs.submit }}
                            </button>
                        </div>
                        <div class="col-6">
                            <button @click="cancelLabel()" data-bs-dismiss="modal"
                                    class="btn btn-alarm full-width">
                                {{ trs.cancel }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="time_modal_mobile" tabindex="-1"
         aria-labelledby="label_modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div v-if="selectedTimeModal.length">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>

                        <div class="mg-b-10">
                            <ul>
                                <li>
                                    زمان :
                                    {{
                                        new Intl.DateTimeFormat('fa-IR', {
                                            weekday: 'long',
                                            day: "numeric",
                                            month: 'long'
                                        }).format(getDay(selectedTimeModal[0]))
                                    }}
                                    ساعت
                                    {{
                                        this.selectedRange[selectedTimeModal[0]][selectedTimeModal[1]].start + " تا " + this.selectedRange[selectedTimeModal[0]][selectedTimeModal[1]].end
                                    }}
                                </li>
                                <li>نوع :
                                    {{
                                        this.selectedRange[selectedTimeModal[0]][selectedTimeModal[1]].users?.length ? "خدمت" : "شخصی"
                                    }}
                                </li>
                            </ul>
                            <ul v-if="this.selectedRange[selectedTimeModal[0]][selectedTimeModal[1]].users?.length">
                                <li>نوبت ها :</li>
                                <li v-for="(user,i) in this.selectedRange[selectedTimeModal[0]][selectedTimeModal[1]].users">
                                    کاربر {{ i + 1 }} : {{ user.car_type + " " + user.car_model }}
                                </li>
                            </ul>
                            <ul v-else>
                                <li>
                                    برچسب : {{ this.selectedRange[selectedTimeModal[0]][selectedTimeModal[1]].label }}
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-6"
                                 v-if="!this.selectedRange[selectedTimeModal[0]][selectedTimeModal[1]].reservation">
                                <button @click="removeLabel(selectedTimeModal[0],selectedTimeModal[1])"
                                        data-bs-dismiss="modal"
                                        class="btn btn-alarm half-width">
                                    {{ trs.remove }}
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ['trs', 'days', 'schedule', 'url', 'csrf'],
    mounted() {
        $('.owl-carousel').owlCarousel({
            items: 3,
            autoplay: false,
            rtl: true,
            rewind: false,
            nav: true,
        });

        this.setSelectRange();

    },
    data() {
        return {
            today: new Date(),
            selectedRange: [],
            selecting: false,
            selected: false,
            labelDialog: false,
            label: '',
            mouseOver: false,
            time_label: null,
            selectedIndex: null,
            selectedTimeModal: [],
        };
    },
    methods: {
        setSelectRange() {
            let vm = this;
            this.days.forEach(function (item, index) {
                vm.selectedRange[index] = [];
                if (item) {
                    let helper = -1;
                    let helper_index = -1;
                    item.forEach(function (item2, index2) {
                        if (helper != item2.start) {
                            helper = item2.start;
                            helper_index++;
                            vm.selectedRange[index][helper_index] = {
                                start: parseInt(item2.start),
                                end: parseInt(item2.end) - 1,
                                f: true,
                                users: item2.reservation ? [
                                    {
                                        car_type: item2.car_type,
                                        car_model: item2.car_model,
                                        reservation: item2.reservation,
                                    },
                                ] : [],
                                label: item2.label,
                                type: !item2.reservation ? "s" : "",
                                remove_url: item2.remove_url,
                            };
                        } else {
                            vm.selectedRange[index][helper_index].users.push({
                                car_type: item2.car_type,
                                car_model: item2.car_model,
                                reservation: item2.reservation,
                            });
                        }
                    });
                }
            });
        },
        isWorkTime(index, time) {
            let x = false;
            if (this.schedule) {
                let this_date = new Date(this.getDay(index));
                let day_of_week = this_date.getDay();
                let day = this.schedule['day' + day_of_week];
                day = JSON.parse(day);
                if (day && day.times) {
                    day.times.forEach(function (item) {
                        if (time >= parseInt(item[0]) && time < parseInt(item[1])) {
                            x = true;
                        }
                    });
                }
            }
            return x;
        },
        startSelection(time, index) {
            if (!this.selecting) {
                this.selecting = true;
                if (!this.selectedRange[index]) {
                    this.selectedRange[index] = [];
                }
                this.selectedRange[index].push({start: time, end: time, 'type': 's'});
            } else {
                this.endSelection(time, index);
            }
        },
        endSelection(time, index) {
            if (this.selecting) {
                this.selectedRange[index][this.selectedRange[index].length - 1].end = time;
                this.selectedIndex = index;
                $("#label_modal_mobile").modal('show');
            }

            this.selecting = false;
        },
        submitLabel(index) {
            let label = this.time_label

            let selected = this.selectedRange[this.selectedIndex][this.selectedRange[this.selectedIndex].length - 1];

            const headers = {
                'X-CSRF-TOKEN': this.csrf
            };
            const data = {
                'date': new Date(this.getDay(this.selectedIndex)),
                'start': selected.start,
                'end': selected.end + 1,
                'label': label,
            };
            axios.post(this.url, data, {headers})
                .then(response => {
                    if (response.data.status == 0) {
                        selected.f = true;
                        selected.label = label;
                        selected.remove_url = response.data.remove_url;
                        this.time_label = null;
                        this.selectedIndex = null;
                    } else {
                        this.selectedRange[this.selectedIndex].pop();
                        this.selectedIndex = null;
                    }
                });

        },
        cancelLabel() {
            if (this.selectedIndex) {
                this.selectedRange[this.selectedIndex].pop();
            }
            this.selectedIndex = null;
        },
        outSelection(index) {
            if (this.selecting) {
                this.selectedRange[index].pop();
            }
            this.selecting = false;
        },
        getDay(index) {
            const d = new Date();
            return d.setDate(d.getDate() + index);
        },
        getTop(i) {
            return (i + 1) * 4;
        },
        getHeight(item) {
            console.log(item);
            return (item.end - item.start + 1) * 4
        },
        openTime(index, i) {
            this.selectedTimeModal[0] = index;
            this.selectedTimeModal[1] = i;
            $("#time_modal_mobile").modal('show');
        },
        removeLabel(index, i) {
            let url = this.selectedRange[index][i].remove_url;

            axios.get(url)
                .then(response => {
                    if (response.data.status == 0) {
                        this.selectedRange[index].splice(i, 1);
                        this.selectedTimeModal = [];
                    } else {
                        this.selectedTimeModal = [];
                    }
                });


        },
    },
};
</script>
