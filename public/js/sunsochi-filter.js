(function($) {
	var SUNSOCHI_FILTER = (function() {

		var $sel = {};
		$sel.window = $(window);
		$sel.html = $("html");
		$sel.body = $("body", $sel.html);

		return {
            filterCatalog: {

                $forms: null,

                $submit: null,

                $elements: null,

                init: function() {
                    var self = this;

                    self.$forms = $(".form-filter");
                    self.$forms.each(function() {
                        (function($form) {
                            self.$submit = $(".filter-submit", $form);
                            self.$submit.on("click", function(e) {
                                self.sendFilter($form);
                                e.preventDefault();
                            });
                        })($(this))
                    });

                },
                sendFilter: function($form) {
                    var self = this;
                    self.$elements = $(".form-item", $form);

                    self.$elements.each(function() {
                        var el = $(this),
                            nameEl = el.attr("name");
                            valEl = el.val();
                        console.log(nameEl);
                        console.log(valEl);
                    })
                }

            },

		};

	})();

	SUNSOCHI_FILTER.filterCatalog.init();

	window.SUNSOCHI_FILTER = SUNSOCHI_FILTER;

})(jQuery);
