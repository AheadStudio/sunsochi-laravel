<template>
    <div>
        <div v-if="params.pagination.current_page !== params.pagination.last_page && params.pagination.last_page > 1" :class="params.class">
            <a :href="params.page" :data-container="params.container"  @click.prevent="changePage($event)" :data-itemsselector="params.item" data-ajax="false" class="link button button--blue load-more">Показать еще</a>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                params: {
                    pagination: "",
                    class: "",
                    container: "",
                    item: "",
                    page: "",
                },
            }
        },
        props: ["pagination"],
        created: function () {
            var self = this;
            self.params.pagination = self.pagination.setting;
            self.params.class = self.pagination.paginationClass;
            self.params.container = self.pagination.paginationContainer;
            self.params.item = self.pagination.paginationItem;

            self.params.pagination.next = self.params.pagination.current_page + 1;

            self.params.page = location.href + "?page="+ Number(self.params.pagination.next);
        },
        methods: {
            changePage: function(event) {
                var self = this,
                    $el = $(event.target);

                self.params.pagination.next = self.params.pagination.next + 1;

                if (self.params.pagination.next <= self.params.pagination.last_page) {
                    self.params.page = location.href + "?page="+ Number(self.params.pagination.next);
                    self.params.link =  $el;
                    self.$root.$emit("nextPage",  self.params);
                }
                //self.params.pagination = location.href + self.params.pagination.current_page;
            }
        }
    }
</script>
