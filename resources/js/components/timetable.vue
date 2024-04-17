<template>
    <div class="">
        <span>زمان های کاری هفتگی</span><span class="time_table_helper time_table_helper_work"></span>
        <span>زمان های رزرو شده</span><span class="time_table_helper time_table_helper_service"></span>
        <span>زمان های تعطیلی شخصی</span><span class="time_table_helper time_table_helper_servant"></span>
        <div class="panel_top_description">
            <span class=""><i class="fa-regular fa-circle-question"></i>
                شما می توانید با انتخاب و کشیدن یک بازه زمانی را در روز انتخاب کرده و ان را
                برای خود برچسب گذاری کنید. بازه
                های زمانی انتخاب شده که با رنگ <span class="time_table_helper time_table_helper_servant"></span> نشان
                داده
                می شوند به عنوان زمان تعطیلی شما محسوب شده و قابل رزرو برای کاربر نمی باشد.</span>
        </div>
    </div>
    <div class="time_table_container">

        <div class="time_table_body">
            <table class="table-responsive table table-bordered">
                <thead class="time_table_header">
                <tr>
                    <th>روز</th>
                    <th v-for="(time,i) in 24" :id="'time'+i">
                        {{ i }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(day, index) in 60" :key="index" @mouseleave.prevent="outSelection(index)">
                    <td :id="'day'+index">
                        <div>
                            <span>{{
                                    new Intl.DateTimeFormat('fa-IR', {weekday: 'long'}).format(getDay(index))
                                }}
                        </span>
                        </div>
                        <div>
                            <span>
                            {{
                                    new Intl.DateTimeFormat('fa-IR', {
                                        day: "numeric",
                                        month: 'long'
                                    }).format(getDay(index))
                                }}
                        </span>
                        </div>
                    </td>
                    <td v-for="(time,i) in 24" class="time_span col"
                        :class="this.isWorkTime(index,i) ? 'work_day_background' : ''"
                        @mousedown.left.prevent="startSelection(i,index)"
                        @mouseup.left.prevent="endSelection(i,index)"
                        @mouseover.prevent="slideSelection(i,index)">
                        <span v-show="this.isWorkTime(index,i)">.</span>
                    </td>
                </tr>
                </tbody>
            </table>

            <div v-if="this.selectedRange" v-for="(item,index) in this.selectedRange"
                 class="selected_div_container">
                <div v-if="item" v-for="(item2,i) in item" class="selected_div" @click="openTime(index,i)"
                     :class="item2.f ? 'selected_div_f' : '' , item2.type=='s' ? 'selected_div_user' : '' "
                     :style="'width: '+getWidth(item2)[1]+'px; right: '+getWidth(item2)[0]+'px; top: '+getHeight(index)+'px;'">
                    <div class="time_selected_label_title">
                        <span>{{ item2.start }} تا {{ item2.end + 1 }}</span>
                    </div>
                    <div v-if="item2.users?.length" class="time_selected_label_description">
                        <span>{{ item2.users.length }} رزرو</span>
                    </div>
                    <div v-else-if="item2.label" class="time_selected_label_description">
                        <span>{{ item2.label }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="label_modal" tabindex="-1"
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

    <div class="modal fade" id="time_modal" tabindex="-1"
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
            this.selecting = true;
            if (!this.selectedRange[index]) {
                this.selectedRange[index] = [];
            }
            this.selectedRange[index].push({start: time, end: time, 'type': 's'});
        },
        slideSelection(time, index) {
            if (this.selecting) {
                this.selectedRange[index][this.selectedRange[index].length - 1].end = time;
            }
        },
        endSelection(time, index) {
            if (this.selecting) {
                this.selectedRange[index][this.selectedRange[index].length - 1].end = time;
                this.selectedIndex = index;
                $("#label_modal").modal('show');
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
        getWidth(item2) {
            let time = "#time" + item2.start;

            let right = $(".time_table_body").width() - ($(time).offset().left + $(time).width());
            let width = 0;
            for (let i = item2.start; i <= item2.end; i++) {
                let time = "#time" + i;
                width += $(time).outerWidth();
            }
            return [right, width];
        },
        getHeight(index) {
            let day = "#day" + index;
            return $(day).offset().top - $(".time_table_body").offset().top;
        },
        openTime(index, i) {
            this.selectedTimeModal[0] = index;
            this.selectedTimeModal[1] = i;
            $("#time_modal").modal('show');
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
<style>
.time_span {
    cursor: pointer;
    text-align: center;
}

.time_container {
    width: fit-content;
    position: relative;
}


.time_table_body table td {
    z-index: 9;
    background: transparent;
    position: relative;
}

.selected_div_container {
}

.selected_div {
    height: 65px;
    background: #497ee4a6;
    position: absolute;
    border: 1px solid #aaaaaa;
    padding: 5px;
    cursor: grab;
}

.selected_div_f {
    z-index: 10;
}

.time_table_container {
    max-height: 400px;
    overflow-y: auto;
}

.time_table_body {
    position: relative;
}

.time_table_container::-webkit-scrollbar {
    width: 3px;
    height: 3px;
}

.time_table_container::-webkit-scrollbar-thumb {
    background: var(--color1);
}

.time_table_header {
    position: sticky;
    top: 0;
    z-index: 11;
}

.time_selected_label_title {
    font-size: 11px;
}

.time_selected_label_description {
    overflow: hidden;
    font-size: 11px;
    position: relative;
    height: 25px;

}


.time_selected_label_description span {
    -webkit-transition: all 4s;
    -moz-transition: all 4s;
    -ms-transition: all 4s;
    -o-transition: all 4s;
    transition: all 4s;
    -webkit-transition-timing-function: linear;
    -moz-transition-timing-function: linear;
    transition-timing-function: linear;
    position: absolute;
    white-space: nowrap;
    transform: translateX(0);
}

.time_selected_label_description span:hover {
    transform: translateX(calc(100% - 50px));
}

.work_day_background {
    background: #327dd222 !important;
}

.selected_div_user {
    background: #75797fbd !important;
}

.time_table_helper {
    width: 15px;
    height: 15px;
    display: inline-block;
    margin: 0 10px;
    border-radius: 3px
}

.time_table_helper_service {
    background: #497ee4a6;
}

.time_table_helper_servant {
    background: #75797fbd;
}

.time_table_helper_work {
    background: #327dd222;
}


</style>
