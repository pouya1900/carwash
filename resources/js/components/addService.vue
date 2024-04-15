<template>

    <div class="row">
        <div class="col-12 col-lg-6 mg-b-10">
            <label class="form-label" for="base_service" style="margin-bottom: 10px;">سرویس</label>
            <div class="input-group">
                <select class="form-control boxaitradeselect" v-model="selected_base_id" name="base_service"
                        id="base_service"
                        @change="selectBase()">
                    <option value="">انتخاب سرویس...</option>
                    <option v-for="base_service in base_services" :value="base_service.id">{{ base_service.title }}
                    </option>
                </select>
            </div>
        </div>

        <div class="col-12 col-lg-6 mg-b-10">

            <div v-if="this.selected_base_service">
                <label class="form-label" for="description">توضیحات</label>
                <div class="input-group">
                    <textarea class="form-control" id="description" dir="rtl" rows="3" disabled readonly>{{this.selected_base_service.description_text}}</textarea>
                </div>
            </div>
        </div>

        <div class="col-12 mg-b-10">
            <label class="form-label">ایتم ها</label>

            <div class="row form_item_breaker">
                <div v-for="item in items" class="col-4 col-lg-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" :value="item.id" name="items[]"
                               id="items" :checked="this.selected_items.find(a => a.id==item.id) ? true : false">
                        <label class="form-check-label" for="items">
                            {{ item.title }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mg-b-10">
            <label class="form-label">انواع وسایل نقلیه</label>

            <div class="row form_item_breaker">
                <div v-for="type in types" class="col-4 col-lg-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" :value="type.id" name="types[]"
                               id="types" :checked="this.selected_types.find(a => a.id==type.id) ? true : false">
                        <label class="form-check-label" for="types">
                            {{ type.title }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mg-b-10">
            <label class="form-label" for="price">قیمت</label>
            <div class="input-group">
                <input type="text" class="form-control text-start number_format_input" id="price" name="price" dir="ltr"
                       placeholder="قیمت" v-model="price" required="">
            </div>
        </div>

        <div class="col-12 col-lg-6 mg-b-10">
            <label class="form-label" for="discount">تخفیف</label>
            <div class="input-group">
                <input type="text" class="form-control text-start number_format_input" id="discount" name="discount"
                       dir="ltr" v-model="discount"
                       placeholder="تخفیف">
            </div>
        </div>

        <div class="col-12 col-lg-6 mg-b-10">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_main" :checked="is_main ? true : false"
                       id="is_main">
                <label class="form-check-label" for="is_main">
                    ایا جزو خدمات اصلی است؟ (3 خدمت اصلی انتخاب شده در برنامه بالا تر از بقیه نشان داده می شود)
                </label>
            </div>
        </div>

        <div class="col-12 col-lg-6 mg-b-10">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"
                       id="status" name="status" :checked="status ? true : false">
                <label class="form-check-label"
                       for="status">وضعیت سرویس (فعال، غیر فعال)</label>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-secondary half-width">
                ثبت
            </button>
        </div>

    </div>


</template>

<script>
export default {
    props: ['base_services', 'items', 'service', 'types'],
    name: 'addService',
    mounted() {
        if (this.service) {
            this.selected_base_id = this.service.base_id;
            this.selected_items = this.service.items;
            this.selected_types = this.service.types;
            this.price = this.service.price;
            this.discount = this.service.discount;
            this.is_main = this.service.is_main;
            this.status = this.service.status;

            this.selectBase();
        }
    },
    methods: {
        selectBase() {
            this.selected_base_service = this.base_services.find(item => this.selected_base_id == item.id);
        }
    },
    data() {
        return {
            "selected_base_id": null,
            "selected_base_service": null,
            "selected_items": [],
            "selected_types": [],
            "price": 0,
            "discount": 0,
            "is_main": 0,
            "status": 1,
        }
    },
}

</script>
