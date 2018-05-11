(function($) {
	var SUNSOCHI_FILTER = (function() {

		var $sel = {};
		$sel.window = $(window);
		$sel.html = $("html");
		$sel.body = $("body", $sel.html);

		return {
            filterCatalog: {

                $forms: null,

                baseUrl: false,

				sectionCatalog: null,

                init: function() {
                    var self = this;

                    self.baseUrl = location.href + "filter/";

					var replacePath = window.location.pathname.split("/");
					self.sectionCatalog = replacePath[2];

                    self.$forms = $(".form-filter");
                    self.$forms.each(function() {
                        (function($form) {
                            $submit = $(".filter-submit", $form);
                            $submit.on("click", function(e) {
								self.createUrl($form, 0);
                                e.preventDefault();
                            });
                            $form.find(".form-item").on("change", function() {
                                self.createUrl($form, 1);
                            });
                            $form.find(".regions-container-list ul li").on("click", function() {
                                self.createUrl($form, 1);
                                $form.find(".filter-selected-regions-list .selected-regions-item-close").on("click", function() {
                                    self.createUrl($form, 1);
                                });
                            });
                            $form.find(".regions-container-list ul li .regions-close").on("click", function() {
                                self.createUrl($form, 1);
                            });
                        })($(this))
                    });

                },

                sendFilter: function($form, params, total) {
                    var self = this,
						$submit = $form.find(".filter-submit"),
                        url = $form.attr("action");

					if (total) {
						$submit.addClass("loading-ajax");
					}

                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {
                            "url"       	: location.href,
                            "params"    	: params,
							"main_section"	: self.sectionCatalog,
							"only_total"	: total,
                        },
                        dataType: "json",
                        success: function(data) {
							self.resultFilter($form, data);
                        }
                    })
                },

                createUrl: function($form, total) {
                    var self = this,
                        $filterItems = $form.find(".form-item"),
                        filterParams = "";
                        url = $form.attr("action");

                    $filterItems.each(function() {
                        var $el = $(this);
                        if($el.is(":checked")) {
                            filterParams += $el.attr("name") + "/";
                        }
                        if ($el.attr("type") == "range") {
                            var name = $el.data("nameInput");
                            var minValue = $form.find("[name='" + name + "_min']").val();
                            var maxValue = $form.find("[name='" + name + "_max']").val();
                            filterParams += $el.attr("name") + "__" + minValue.replace(/ /g, "") + "_" + maxValue.replace(/ /g, "") + "/";
                        }
                        if ($el.attr("type") == "text") {
                            if ($el.val()) {
                                filterParams += $el.attr("name") + "_" + $el.val() + "/";
                            }
                        }
                    });

                    history.pushState(null, null, self.baseUrl + filterParams);

                    self.sendFilter($form, filterParams, total);

                },

				resultFilter: function($form, data) {
					var self = this,
						$submit,
						templateSubmit,
						newTemplate;

					if (typeof(data) == "number") {
						$submit = $form.find(".filter-submit");
						templateSubmit = String($submit.attr("data-filter-button-tpl"));
						newTemplate = templateSubmit.replace("{number}", data);
						$submit.text(newTemplate);

						setTimeout(function() {
							if ($submit.hasClass("loading-ajax")) {
								$submit.removeClass("loading-ajax");
							}
						}, 300);

					} else {
						var $containerElements = $sel.body.find("#offers-list-load"),
							$element = $containerElements.find(".offers-item:first");

						$containerElements.empty();
						
						for (var key in data.data) {
							$element.find(".offers-container-more").attr("href", data.data[key].path);
							$element.find(".offers-container-img").attr("src", data.data[key].photo);
							$element.find(".offers-container-price").text(data.data[key].price_min);
							$element.find(".offers-name").text(data.data[key].name);
							$element.find(".offers-district").text(data.data[key].distric);
							$element.find(".offers-time").text(data.data[key].deadline);
							$element.find(".offers-container-price").append("<dl></dl>");
							var list = $element.find("dl");
							for (var apartments in data.data.apartments) {
								list.append("<dt>"+apartments+"</dt>");
								list.append("<dd>"+apartments+"</dd>");
							}
							$containerElements.append($element);
						}
						$containerElements.find(".load-more").attr("href", data.next_page_url);
					}

				}

            },

		};

	})();

	SUNSOCHI_FILTER.filterCatalog.init();

	window.SUNSOCHI_FILTER = SUNSOCHI_FILTER;

})(jQuery);
