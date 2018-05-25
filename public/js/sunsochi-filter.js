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

				$elementTpl: null,

				$offersContainer: null,

				stopChange: true,

                init: function() {
                    var self = this;

					var replacePath = window.location.pathname.split("/");

					if (replacePath[1] == "") {
						self.baseUrl = window.location.origin  + "/filter/";
					} else {
						self.baseUrl = window.location.origin + "/" + replacePath[1] + "/" + replacePath[2] + "/filter/";
					}

                    self.$forms = $(".form-filter");

					self.$offersContainer = $sel.body.find("#offers-list-load");

                    self.$forms.each(function() {
                        (function($form) {
							self.setFilterOptions($form);

                            $form.on("click", ".filter-submit", function(e) {
								self.createUrl($form, 0);
                                e.preventDefault();
                            });

							$buttonSubmit = $(".regions-show", $form);
							$buttonSubmit.on("click", function(e) {
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

					self.popular();

                },

                createUrl: function($form, only_count) {
                    var self = this,
                        $filterItems = $form.find(".form-item"),
                        filterParams = "",
						$homePage = $("input[name='home-page']", $form),
                        url = $form.attr("action");

					if (self.stopChange == false) {
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
						if ($homePage.length == 0) {
	                    	history.pushState(null, null, self.filterUrl);
						}

						self.sendFilter($form, filterParams, only_count);

						if ($sel.body.find(".find-result").length > 0) {
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
						}
					}

                },

                sendFilter: function($form, params, only_count) {
                    var self = this,
						$submit = $form.find(".filter-submit"),
						$sectionCatalog = $("input[name='section-name']", $form).val(),
						$homePage = $("input[name='home-page']", $form),
						buttonLinkRedirect = 0,
                        url = $form.attr("action");

					// check is only count(elements) or all elements
					if (only_count && only_count == 1) {
						// check if button from home page
						$submit.addClass("loading-ajax");
						url = url + "count/";
					} else {
						// this redirect for home page
						if ($homePage.length > 0) {
							buttonLinkRedirect = 1;
							location.href = window.location.origin + "/catalog/" + $sectionCatalog + "/filter/" + params;
						}
					}

					$.ajax({
                        url: url,
                        method: "GET",
                        data: {
                            "url"       			: location.href,
                            "params"    			: params,
							"main_section"			: $sectionCatalog,
							"only_count"			: only_count,
							"button_link_redirect"	: buttonLinkRedirect,
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

				popular: function () {
					var self = this;

					$popularItem = $(".popular-item-link");

					$popularItem.each(function() {
						(function($el) {
							$el.on("click", function(e) {
								var el = $(this),
									linkEl = $el.attr("href"),
									filterUrl;

								var filterUrl = self.baseUrl + linkEl;

			                    history.pushState(null, null, filterUrl);

								SUNSOCHI.common.go($sel.body.find(".find-result").offset().top-120, 1000);

								self.sendFilter($(".form-filter"), linkEl, 0);

								SUNSOCHI.filter.formFilter.resetFilter();
								e.preventDefault();
							});

						})($(this));
					});
				},

				setFilterOptions: function($form) {
					var self = this;

					if (window.location.pathname.indexOf("filter") != -1) {
						var replacePath = window.location.pathname.split("/");

						for (var i = 0; i < replacePath.length; i++) {
							if (replacePath[i] != "") {
								var $elementsForm = $form.find(".form-item");

								$elementsForm.each(function() {
			                        (function($el) {
										var type = $el.attr("type");

										if ($el.attr("type") == "range") {
											(function($el) {
												var name = $el.data("nameInput"),
													newValuesReplace;

												if (replacePath[i].indexOf(name) != -1) {
												  if (replacePath[i].indexOf("ap") != -1) {
													  var newValuesReplace = replacePath[i].replace(name+"_ap__",""),
													  	  newValues = newValuesReplace.split("_");

												  } else {
													  var newValues = replacePath[i].replace(name+"__","").split("_");
												  }

												  $form.find("[name='" + name + "_min']").val(newValues[0]);
												  $form.find("[name='" + name + "_max']").val(newValues[1]);

												  $el.attr("data-valfrom", newValues[0]);
												  $el.attr("data-valto", newValues[1]);

												  SUNSOCHI.filter.formFilter.replaceRangeText($el, $el.closest(".jcf-range"), newValues[0], newValues[1]);

												  var currentStateRange = jcf.getInstance($el);
												  currentStateRange.values = [newValues[0], newValues[1]];
												  currentStateRange.refresh();
												}

											})($el);

									   }
									   if ($el.attr("type") == "checkbox") {
										   var name = $el.attr("name");

										   if (replacePath[i].indexOf(name) != -1) {
											   $el.prop("checked", true);
											   jcf.refresh($el);
										   }
									   }
									})($(this))
								});

								if (replacePath[i].indexOf("district") != -1) {
									 var $regionsList = $(".regions-container-list ul li[name=" + replacePath[i] + "]", $form),
										 textCheckbox = $regionsList.find(".regions-text").text(),
										 $checkboxContainer = $form.find(".filter-selected-regions-list");
									 $regionsList.addClass("select");

									 $checkboxContainer.append(
										 '<div class="filter-selected-regions-item" data-regname="'+$regionsList.attr("name")+'">'+
											 '<input type="checkbox" name="'+$regionsList.attr("name")+'" data-jcfapply="off" checked="checked" class="form-item form-item--checkbox"><span class="selected-regions-item-text">'+textCheckbox+'</span>'+
											 '<div class="selected-regions-item-close">'+
												 '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44.8 44.8"><g id="Слой_2" data-name="Слой 2"><g id="Слой_1-2" data-name="Слой 1"><path d="M19.6,22.4,0,42l2.8,2.8L22.4,25.2,42,44.8,44.8,42,25.2,22.4,44.8,2.8,42,0,22.4,19.6,2.8,0,0,2.8Z" fill="#d0d0d0"></path></g></g></svg>'+
											 '</div>'+
										 '</div>');
										 
									SUNSOCHI.filter.formFilter.regions.removeCheckbox();

									$form.find(".filter-selected-regions-list .selected-regions-item-close").on("click", function() {
 	                                    self.createUrl($form, 1);
 	                                });

								}

							}
						}
					}

					self.stopChange = false;
				}

            },

			favorites: {

				$favoriteItems: null,

				init: function() {
					var self = this;

					self.$favoriteItems = $("[data-favorite]");
					self.$favoriteItems.each(function() {
						(function($el) {
							self.create($el);
						})($(this));
					});
				},

				create: function($element) {
					var self = this;

					if (!$element.hasClass("add")) {
						$element.on("click", function(e) {
							var el = $(this),
								datEl = el.data("favorite");

							if (!el.hasClass("added")) {
								$.ajax({
			                        url: "/catalog/favorites/add/",
			                        method: "GET",
			                        data: {
			                            "element_id" : datEl,
			                        },
			                        success: function(data) {
										if (data.count != 0) {
											el.addClass("added");
											el.find(".offers-container-favorites-text").text("Добавленно");
											$(".header-favorites-holder").addClass("active");
											$(".header-favorites-count").text(data.count);
										}
			                        }
			                    })
							}

							e.preventDefault();
						})
					}
				},

			},

		};

	})();

	SUNSOCHI_FILTER.filterCatalog.init();
	SUNSOCHI_FILTER.favorites.init();

	window.SUNSOCHI_FILTER = SUNSOCHI_FILTER;

})(jQuery);
