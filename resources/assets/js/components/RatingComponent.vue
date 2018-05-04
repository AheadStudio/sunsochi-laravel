<template>
    <div>
        <div data-rating :data-rating-value="params.value" :data-rating-read="params.read" class="blog-rating"></div>
    </div>
</template>

<script>
    export default {
        data: function() {
    		return {
                params: {
                    read: "",
                    value: "",
                    voted: "",
                    summ: "",
                    code: "",
                },
                ratingValue: null,
                checkCookie: null,
    		}
    	},
        props: ["rating"],
        created: function () {
            var self = this;
            self.params.read = self.rating.read;
            self.params.value = Number(self.rating.value);
            self.params.voted = Number(self.rating.voted);
            self.params.summ = Number(self.rating.summ);
            self.params.code = self.rating.code;

            self.checkCookie = this.$cookie.get("sunsochi-rating");

            if (self.checkCookie) {
                self.params.read = true;
            }
        },
        methods: {
            setEvent: function(componentTpl) {
                var self = this,
                    $ratingInput = componentTpl.find("img");

                if (self.params.read) {
                    return;
                }

                $ratingInput.on("click", function() {
                    var $el = $(this);

                    self.ratingValue = Number(componentTpl.find('[name=result-blog-rating]').val());
                    self.changeRating();

                    self.$cookie.set("sunsochi-rating", true, {expires: 24*30*365, domain: "localhost"});
                });

            },
            changeRating: function() {
                var self = this;

                var newRating = (self.params.summ + self.ratingValue) / (self.params.voted + 1);

                axios.post("/blog/add-rating/", {
                    rating  : newRating,
                    summ    : self.params.summ + self.ratingValue,
                    voted   : self.params.voted + 1,
                    code    : self.params.code,
                })
                .then(function(response) {
                    var data = response.data;
                    if (data) {
                        self.params.summ = data.summ;
                        self.params.voted = data.voted;
                        self.params.value = data.rating;
                        self.params.read = true;
                    }
                });

            }
        },
        mounted: function() {
            var self = this,
                componentTpl = $(this.$el);

            SUNSOCHI.forms.rating.init();

            self.$nextTick(function () {
                self.setEvent(componentTpl);
            });

        },
        updated: function() {
            var self = this,
                componentTpl = $(this.$el);
                
            SUNSOCHI.forms.rating.destroy();

            self.$nextTick(function () {
                setTimeout(function() {
                    SUNSOCHI.forms.rating.init();
                }, 400);
                self.setEvent(componentTpl);
            });
        }
    }
</script>
