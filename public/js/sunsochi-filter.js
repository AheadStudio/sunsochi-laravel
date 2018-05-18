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
				filterUrl: null,

				sectionCatalog: null,

				$elementTpl: null,

				$offersContainer: null,

                init: function() {
                    var self = this;

					var replacePath = window.location.pathname.split("/");
					self.sectionCatalog = replacePath[2];

					self.baseUrl = window.location.origin + "/" + replacePath[1] + "/" + replacePath[2] + "/filter/";

                    self.$forms = $(".form-filter");

					self.$offersContainer = $sel.body.find("#offers-list-load");

                    self.$forms.each(function() {
                        (function($form) {

                            $form.on("click", ".filter-submit", function(e) {
								self.createUrl($form, 0);
                                e.preventDefault();
                            });

							$buttonSubmit = $(".regions-show", $form);
							$buttonSubmit.on("click", function(e) {
								self.createUrl($form, 0);
								$.magnificPopup.close();
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

                createUrl: function($form, only_count) {
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
                                filterParams += $el.attr("name") + "__" + $el.val() + "/";
                            }
                        }
                    });

					self.filterUrl = self.baseUrl + filterParams;
                    history.pushState(null, null, self.filterUrl);

					if (only_count == 0) {
						SUNSOCHI.common.go($sel.body.find(".find-result").offset().top-120, 1000);
						/*
						self.$offersContainer.removeClass("preloader-remove");
						self.$offersContainer.addClass("hide");
						setTimeout(function() {
							self.$offersContainer.append('<div class="offers-preloader">' +
															'<div class="preloader-container">' +
																'<img src="/svg/logo-mini_preload.svg" class="preloader-img">' +
														 	'</div>'+
														'</div>');
						}, 200);*/
					}
                    self.sendFilter($form, filterParams, only_count);

                },

                sendFilter: function($form, params, only_count) {
                    var self = this,
						$submit = $form.find(".filter-submit"),
                        url = $form.attr("action");

					if (only_count && only_count == 1) {
						$submit.addClass("loading-ajax");
						url = url + "count/";
					}

					$.ajax({
                        url: url,
                        type: "GET",
                        data: {
                            "url"       	: location.href,
                            "params"    	: params,
							"main_section"	: self.sectionCatalog,
							"only_count"	: only_count,
                        },
                        success: function(data) {
							var $data = $('<div />').append(data);
							self.resultFilter($form, $data, only_count);
                        }
                    })

                },

				resultFilter: function($form, data, only_count) {
					var self = this,
						$submit,
						$offersContainer;

					if (only_count == 1) {
						$submit = $form.find(".filter-submit");
						$submit.remove();
						$form.append(data.find(".filter-submit"));
					} else {
						$offersContainer = $(".offers-block");
						$offersContainer.empty();
						$offersContainer.append(data.children());
						SUNSOCHI_FILTER.favorites.init();
						SUNSOCHI.forms.applyJcf();
					}
				},

            },

			favorites: {

				$favoriteItems: null,

				sectionCatalog: null,

				init: function() {
					var self = this;

					var replacePath = window.location.pathname.split("/");
					self.sectionCatalog = replacePath[2];

					self.$favoriteItems = $(".offers-container-favorites");
					self.$favoriteItems.each(function() {
						(function($el) {
							self.create($el);
						})($(this));
					});
				},

				create: function($element) {
					var self = this;

					if (!$element.hasClass("add")) {
						$element.on("click", function() {
							var el = $(this),
								datEl = el.data("favorite");

							$.ajax({
		                        url: "/catalog/favorites/add/",
		                        type: "GET",
		                        data: {
		                            "element_id" : datEl,
		                        },
		                        success: function(data) {
									if (data.count != 0) {
										$element.addClass("added");
										$element.find(".offers-container-favorites-text").text("Добавленно");
										$(".header-favorites-holder").addClass("active");
										$(".header-favorites-count").text(data.count);
									}
		                        }
		                    })
						})
					}
				},

			}

		};

	})();

	SUNSOCHI_FILTER.filterCatalog.init();
	SUNSOCHI_FILTER.favorites.init();

	window.SUNSOCHI_FILTER = SUNSOCHI_FILTER;

})(jQuery);
