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
                    read: this.rating.read,
                    value: Number(this.rating.value),
                    voted: Number(this.rating.voted),
                    summ: Number(this.rating.summ),
                    code: this.rating.code,
                },
                ratingValue: null,
                checkCookie: null,
    		}
    	},
        props: ["rating"],
        methods: {
            setEvent: function(componentTpl) {
                var self = this,
                    $ratingInput = componentTpl.find("img");

                $ratingInput.on("click", function() {
                    var $el = $(this);

                    if (self.params.read == false && !self.checkCookie) {
                        self.ratingValue = Number(componentTpl.find('[name=result-blog-rating]').val());

                        self.changeRating();
                    } else {
                        console.log("Вы уже проголосовали!");
                    }
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
                    }
                    console.log("Ваш голос учтен");
                    self.$cookie.set("sunsochi-rating", true, {expires: 365, domain: "/"});
                });

            }
        },
        mounted: function() {
            var self = this,
                componentTpl = $(this.$el);

            self.checkCookie = self.$cookie.get("sunsochi-rating");

            SUNSOCHI.forms.rating.init();

            self.$nextTick(function () {
                self.setEvent(componentTpl);
            });

        },
        updated: function() {
            var self = this,
                componentTpl = $(this.$el);

            SUNSOCHI.forms.rating.destroy();
            SUNSOCHI.forms.rating.init();

            self.$nextTick(function () {
                self.setEvent(componentTpl);
            });
        }
    }
</script>
