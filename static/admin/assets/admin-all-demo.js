

function progress(a, b) {
	var c = a * b.width() / 100;
	b.find(".progressbar-value").animate({
		width: c
	}, 1200)
}

function body_sizer() {
	var a = $(window).height(),
		b = $("#page-header").height(),
		c = a - b;
	$("#page-sidebar").css("height", a), $(".scroll-sidebar").css("height", c), $("#page-content").css("min-height", c)
}

function pageTransitions() {
	var a = [".pt-page-moveFromLeft", "pt-page-moveFromRight", "pt-page-moveFromTop", "pt-page-moveFromBottom", "pt-page-fade", "pt-page-moveFromLeftFade", "pt-page-moveFromRightFade", "pt-page-moveFromTopFade", "pt-page-moveFromBottomFade", "pt-page-scaleUp", "pt-page-scaleUpCenter", "pt-page-flipInLeft", "pt-page-flipInRight", "pt-page-flipInBottom", "pt-page-flipInTop", "pt-page-rotatePullRight", "pt-page-rotatePullLeft", "pt-page-rotatePullTop", "pt-page-rotatePullBottom", "pt-page-rotateUnfoldLeft", "pt-page-rotateUnfoldRight", "pt-page-rotateUnfoldTop", "pt-page-rotateUnfoldBottom"];
	for (var b in a) {
		var c = a[b];
		if ($(".add-transition").hasClass(c)) return $(".add-transition").addClass(c + "-init page-transition"), void setTimeout(function () {
			$(".add-transition").removeClass(c + " " + c + "-init page-transition")
		}, 1200)
	}
} + function (a) {
	"use strict";

	function b(b) {
		b && 3 === b.which || (a(e).remove(), a(f).each(function () {
			var d = a(this),
				e = c(d),
				f = {
					relatedTarget: this
				};
			e.hasClass("open") && (e.trigger(b = a.Event("hide.bs.dropdown", f)), b.isDefaultPrevented() || (d.attr("aria-expanded", "false"), e.removeClass("open").trigger("hidden.bs.dropdown", f)))
		}))
	}

	function c(b) {
		var c = b.attr("data-target");
		c || (c = b.attr("href"), c = c && /#[A-Za-z]/.test(c) && c.replace(/.*(?=#[^\s]*$)/, ""));
		var d = c && a(c);
		return d && d.length ? d : b.parent()
	}

	function d(b) {
		return this.each(function () {
			var c = a(this),
				d = c.data("bs.dropdown");
			d || c.data("bs.dropdown", d = new g(this)), "string" == typeof b && d[b].call(c)
		})
	}
	var e = ".dropdown-backdrop",
		f = '[data-toggle="dropdown"]',
		g = function (b) {
			a(b).on("click.bs.dropdown", this.toggle)
		};
	g.VERSION = "3.2.0", g.prototype.toggle = function (d) {
		var e = a(this);
		if (!e.is(".disabled, :disabled")) {
			var f = c(e),
				g = f.hasClass("open");
			if (b(), !g) {
				"ontouchstart" in document.documentElement && !f.closest(".navbar-nav").length && a('<div class="dropdown-backdrop"/>').insertAfter(a(this)).on("click", b);
				var h = {
					relatedTarget: this
				};
				if (f.trigger(d = a.Event("show.bs.dropdown", h)), d.isDefaultPrevented()) return;
				e.trigger("focus").attr("aria-expanded", "true"), f.toggleClass("open").trigger("shown.bs.dropdown", h)
			}
			return !1
		}
	}, g.prototype.keydown = function (b) {
		if (/(38|40|27)/.test(b.keyCode)) {
			var d = a(this);
			if (b.preventDefault(), b.stopPropagation(), !d.is(".disabled, :disabled")) {
				var e = c(d),
					g = e.hasClass("open");
				if (!g || g && 27 == b.keyCode) return 27 == b.which && e.find(f).trigger("focus"), d.trigger("click");
				var h = " li:not(.divider):visible a",
					i = e.find('[role="menu"]' + h + ', [role="listbox"]' + h);
				if (i.length) {
					var j = i.index(i.filter(":focus"));
					38 == b.keyCode && j > 0 && j--, 40 == b.keyCode && j < i.length - 1 && j++, ~j || (j = 0), i.eq(j).trigger("focus")
				}
			}
		}
	};
	var h = a.fn.dropdown;
	a.fn.dropdown = d, a.fn.dropdown.Constructor = g, a.fn.dropdown.noConflict = function () {
		return a.fn.dropdown = h, this
	}, a(document).on("click.bs.dropdown.data-api", b).on("click.bs.dropdown.data-api", ".dropdown form", function (a) {
		a.stopPropagation()
	}).on("click.bs.dropdown.data-api", f, g.prototype.toggle).on("keydown.bs.dropdown.data-api", f + ', [role="menu"], [role="listbox"]', g.prototype.keydown)
}(jQuery), + function (a) {
	"use strict";

	function b(b) {
		return this.each(function () {
			var d = a(this),
				e = d.data("bs.tooltip"),
				f = "object" == typeof b && b;
			(e || "destroy" != b) && (e || d.data("bs.tooltip", e = new c(this, f)), "string" == typeof b && e[b]())
		})
	}
	var c = function (a, b) {
		this.type = this.options = this.enabled = this.timeout = this.hoverState = this.$element = null, this.init("tooltip", a, b)
	};
	c.VERSION = "3.2.0", c.DEFAULTS = {
		animation: !0,
		placement: "top",
		selector: !1,
		template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
		trigger: "hover focus",
		title: "",
		delay: 0,
		html: !1,
		container: !1,
		viewport: {
			selector: "body",
			padding: 0
		}
	}, c.prototype.init = function (b, c, d) {
		this.enabled = !0, this.type = b, this.$element = a(c), this.options = this.getOptions(d), this.$viewport = this.options.viewport && a(this.options.viewport.selector || this.options.viewport);
		for (var e = this.options.trigger.split(" "), f = e.length; f--;) {
			var g = e[f];
			if ("click" == g) this.$element.on("click." + this.type, this.options.selector, a.proxy(this.toggle, this));
			else if ("manual" != g) {
				var h = "hover" == g ? "mouseenter" : "focusin",
					i = "hover" == g ? "mouseleave" : "focusout";
				this.$element.on(h + "." + this.type, this.options.selector, a.proxy(this.enter, this)), this.$element.on(i + "." + this.type, this.options.selector, a.proxy(this.leave, this))
			}
		}
		this.options.selector ? this._options = a.extend({}, this.options, {
			trigger: "manual",
			selector: ""
		}) : this.fixTitle()
	}, c.prototype.getDefaults = function () {
		return c.DEFAULTS
	}, c.prototype.getOptions = function (b) {
		return b = a.extend({}, this.getDefaults(), this.$element.data(), b), b.delay && "number" == typeof b.delay && (b.delay = {
			show: b.delay,
			hide: b.delay
		}), b
	}, c.prototype.getDelegateOptions = function () {
		var b = {},
			c = this.getDefaults();
		return this._options && a.each(this._options, function (a, d) {
			c[a] != d && (b[a] = d)
		}), b
	}, c.prototype.enter = function (b) {
		var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
		return c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), clearTimeout(c.timeout), c.hoverState = "in", c.options.delay && c.options.delay.show ? void(c.timeout = setTimeout(function () {
			"in" == c.hoverState && c.show()
		}, c.options.delay.show)) : c.show()
	}, c.prototype.leave = function (b) {
		var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
		return c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), clearTimeout(c.timeout), c.hoverState = "out", c.options.delay && c.options.delay.hide ? void(c.timeout = setTimeout(function () {
			"out" == c.hoverState && c.hide()
		}, c.options.delay.hide)) : c.hide()
	}, c.prototype.show = function () {
		var b = a.Event("show.bs." + this.type);
		if (this.hasContent() && this.enabled) {
			this.$element.trigger(b);
			var c = a.contains(document.documentElement, this.$element[0]);
			if (b.isDefaultPrevented() || !c) return;
			var d = this,
				e = this.tip(),
				f = this.getUID(this.type);
			this.setContent(), e.attr("id", f), this.$element.attr("aria-describedby", f), this.options.animation && e.addClass("fade");
			var g = "function" == typeof this.options.placement ? this.options.placement.call(this, e[0], this.$element[0]) : this.options.placement,
				h = /\s?auto?\s?/i,
				i = h.test(g);
			i && (g = g.replace(h, "") || "top"), e.detach().css({
				top: 0,
				left: 0,
				display: "block"
			}).addClass(g).data("bs." + this.type, this), this.options.container ? e.appendTo(this.options.container) : e.insertAfter(this.$element);
			var j = this.getPosition(),
				k = e[0].offsetWidth,
				l = e[0].offsetHeight;
			if (i) {
				var m = g,
					n = this.$element.parent(),
					o = this.getPosition(n);
				g = "bottom" == g && j.top + j.height + l - o.scroll > o.height ? "top" : "top" == g && j.top - o.scroll - l < 0 ? "bottom" : "right" == g && j.right + k > o.width ? "left" : "left" == g && j.left - k < o.left ? "right" : g, e.removeClass(m).addClass(g)
			}
			var p = this.getCalculatedOffset(g, j, k, l);
			this.applyPlacement(p, g);
			var q = function () {
				d.$element.trigger("shown.bs." + d.type), d.hoverState = null
			};
			a.support.transition && this.$tip.hasClass("fade") ? e.one("bsTransitionEnd", q).emulateTransitionEnd(150) : q()
		}
	}, c.prototype.applyPlacement = function (b, c) {
		var d = this.tip(),
			e = d[0].offsetWidth,
			f = d[0].offsetHeight,
			g = parseInt(d.css("margin-top"), 10),
			h = parseInt(d.css("margin-left"), 10);
		isNaN(g) && (g = 0), isNaN(h) && (h = 0), b.top = b.top + g, b.left = b.left + h, a.offset.setOffset(d[0], a.extend({
			using: function (a) {
				d.css({
					top: Math.round(a.top),
					left: Math.round(a.left)
				})
			}
		}, b), 0), d.addClass("in");
		var i = d[0].offsetWidth,
			j = d[0].offsetHeight;
		"top" == c && j != f && (b.top = b.top + f - j);
		var k = this.getViewportAdjustedDelta(c, b, i, j);
		k.left ? b.left += k.left : b.top += k.top;
		var l = k.left ? 2 * k.left - e + i : 2 * k.top - f + j,
			m = k.left ? "left" : "top",
			n = k.left ? "offsetWidth" : "offsetHeight";
		d.offset(b), this.replaceArrow(l, d[0][n], m)
	}, c.prototype.replaceArrow = function (a, b, c) {
		this.arrow().css(c, a ? 50 * (1 - a / b) + "%" : "")
	}, c.prototype.setContent = function () {
		var a = this.tip(),
			b = this.getTitle();
		a.find(".tooltip-inner")[this.options.html ? "html" : "text"](b), a.removeClass("fade in top bottom left right")
	}, c.prototype.hide = function () {
		function b() {
			"in" != c.hoverState && d.detach(), c.$element.trigger("hidden.bs." + c.type)
		}
		var c = this,
			d = this.tip(),
			e = a.Event("hide.bs." + this.type);
		return this.$element.removeAttr("aria-describedby"), this.$element.trigger(e), e.isDefaultPrevented() ? void 0 : (d.removeClass("in"), a.support.transition && this.$tip.hasClass("fade") ? d.one("bsTransitionEnd", b).emulateTransitionEnd(150) : b(), this.hoverState = null, this)
	}, c.prototype.fixTitle = function () {
		var a = this.$element;
		(a.attr("title") || "string" != typeof a.attr("data-original-title")) && a.attr("data-original-title", a.attr("title") || "").attr("title", "")
	}, c.prototype.hasContent = function () {
		return this.getTitle()
	}, c.prototype.getPosition = function (b) {
		b = b || this.$element;
		var c = b[0],
			d = "BODY" == c.tagName,
			e = window.SVGElement && c instanceof window.SVGElement,
			f = c.getBoundingClientRect ? c.getBoundingClientRect() : null,
			g = d ? {
				top: 0,
				left: 0
			} : b.offset(),
			h = {
				scroll: d ? document.documentElement.scrollTop || document.body.scrollTop : b.scrollTop()
			},
			i = e ? {} : {
				width: d ? a(window).width() : b.outerWidth(),
				height: d ? a(window).height() : b.outerHeight()
			};
		return a.extend({}, f, h, i, g)
	}, c.prototype.getCalculatedOffset = function (a, b, c, d) {
		return "bottom" == a ? {
			top: b.top + b.height,
			left: b.left + b.width / 2 - c / 2
		} : "top" == a ? {
			top: b.top - d,
			left: b.left + b.width / 2 - c / 2
		} : "left" == a ? {
			top: b.top + b.height / 2 - d / 2,
			left: b.left - c
		} : {
			top: b.top + b.height / 2 - d / 2,
			left: b.left + b.width
		}
	}, c.prototype.getViewportAdjustedDelta = function (a, b, c, d) {
		var e = {
			top: 0,
			left: 0
		};
		if (!this.$viewport) return e;
		var f = this.options.viewport && this.options.viewport.padding || 0,
			g = this.getPosition(this.$viewport);
		if (/right|left/.test(a)) {
			var h = b.top - f - g.scroll,
				i = b.top + f - g.scroll + d;
			h < g.top ? e.top = g.top - h : i > g.top + g.height && (e.top = g.top + g.height - i)
		} else {
			var j = b.left - f,
				k = b.left + f + c;
			j < g.left ? e.left = g.left - j : k > g.width && (e.left = g.left + g.width - k)
		}
		return e
	}, c.prototype.getTitle = function () {
		var a, b = this.$element,
			c = this.options;
		return a = b.attr("data-original-title") || ("function" == typeof c.title ? c.title.call(b[0]) : c.title)
	}, c.prototype.getUID = function (a) {
		do a += ~~(1e6 * Math.random()); while (document.getElementById(a));
		return a
	}, c.prototype.tip = function () {
		return this.$tip = this.$tip || a(this.options.template)
	}, c.prototype.arrow = function () {
		return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
	}, c.prototype.validate = function () {
		this.$element[0].parentNode || (this.hide(), this.$element = null, this.options = null)
	}, c.prototype.enable = function () {
		this.enabled = !0
	}, c.prototype.disable = function () {
		this.enabled = !1
	}, c.prototype.toggleEnabled = function () {
		this.enabled = !this.enabled
	}, c.prototype.toggle = function (b) {
		var c = this;
		b && (c = a(b.currentTarget).data("bs." + this.type), c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c))), c.tip().hasClass("in") ? c.leave(c) : c.enter(c)
	}, c.prototype.destroy = function () {
		clearTimeout(this.timeout), this.hide().$element.off("." + this.type).removeData("bs." + this.type)
	};
	var d = a.fn.tooltip;
	a.fn.tooltip = b, a.fn.tooltip.Constructor = c, a.fn.tooltip.noConflict = function () {
		return a.fn.tooltip = d, this
	}
}(jQuery), + function (a) {
	"use strict";

	function b(b) {
		return this.each(function () {
			var d = a(this),
				e = d.data("bs.popover"),
				f = "object" == typeof b && b;
			(e || "destroy" != b) && (e || d.data("bs.popover", e = new c(this, f)), "string" == typeof b && e[b]())
		})
	}
	var c = function (a, b) {
		this.init("popover", a, b)
	};
	if (!a.fn.tooltip) throw new Error("Popover requires tooltip.js");
	c.VERSION = "3.2.0", c.DEFAULTS = a.extend({}, a.fn.tooltip.Constructor.DEFAULTS, {
		placement: "right",
		trigger: "click",
		content: "",
		template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
	}), c.prototype = a.extend({}, a.fn.tooltip.Constructor.prototype), c.prototype.constructor = c, c.prototype.getDefaults = function () {
		return c.DEFAULTS
	}, c.prototype.setContent = function () {
		var a = this.tip(),
			b = this.getTitle(),
			c = this.getContent();
		a.find(".popover-title")[this.options.html ? "html" : "text"](b), a.find(".popover-content").empty()[this.options.html ? "string" == typeof c ? "html" : "append" : "text"](c), a.removeClass("fade top bottom left right in"), a.find(".popover-title").html() || a.find(".popover-title").hide()
	}, c.prototype.hasContent = function () {
		return this.getTitle() || this.getContent()
	}, c.prototype.getContent = function () {
		var a = this.$element,
			b = this.options;
		return a.attr("data-content") || ("function" == typeof b.content ? b.content.call(a[0]) : b.content)
	}, c.prototype.arrow = function () {
		return this.$arrow = this.$arrow || this.tip().find(".arrow")
	}, c.prototype.tip = function () {
		return this.$tip || (this.$tip = a(this.options.template)), this.$tip
	};
	var d = a.fn.popover;
	a.fn.popover = b, a.fn.popover.Constructor = c, a.fn.popover.noConflict = function () {
		return a.fn.popover = d, this
	}
}(jQuery), $(document).on("ready", function () {
		$(".progressbar").each(function () {
			var a = $(this),
				b = $(this).attr("data-value");
			progress(b, a)
		})
	}), $(function () {
		$("#header-right, .updateEasyPieChart, .complete-user-profile, #progress-dropdown, .progress-box").hover(function () {
			$(".progressbar").each(function () {
				var a = $(this),
					b = $(this).attr("data-value");
				progress(b, a)
			})
		})
	}), + function (a) {
		"use strict";

		function b(b) {
			return this.each(function () {
				var d = a(this),
					e = d.data("bs.button"),
					f = "object" == typeof b && b;
				e || d.data("bs.button", e = new c(this, f)), "toggle" == b ? e.toggle() : b && e.setState(b)
			})
		}
		var c = function (b, d) {
			this.$element = a(b), this.options = a.extend({}, c.DEFAULTS, d), this.isLoading = !1
		};
		c.VERSION = "3.2.0", c.DEFAULTS = {
			loadingText: "loading..."
		}, c.prototype.setState = function (b) {
			var c = "disabled",
				d = this.$element,
				e = d.is("input") ? "val" : "html",
				f = d.data();
			b += "Text", null == f.resetText && d.data("resetText", d[e]()), d[e](null == f[b] ? this.options[b] : f[b]), setTimeout(a.proxy(function () {
				"loadingText" == b ? (this.isLoading = !0, d.addClass(c).attr(c, c)) : this.isLoading && (this.isLoading = !1, d.removeClass(c).removeAttr(c))
			}, this), 0)
		}, c.prototype.toggle = function () {
			var a = !0,
				b = this.$element.closest('[data-toggle="buttons"]');
			if (b.length) {
				var c = this.$element.find("input");
				"radio" == c.prop("type") && (c.prop("checked") && this.$element.hasClass("active") ? a = !1 : b.find(".active").removeClass("active")), a && c.prop("checked", !this.$element.hasClass("active")).trigger("change")
			}
			a && this.$element.toggleClass("active")
		};
		var d = a.fn.button;
		a.fn.button = b, a.fn.button.Constructor = c, a.fn.button.noConflict = function () {
			return a.fn.button = d, this
		}, a(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function (c) {
			var d = a(c.target);
			d.hasClass("btn") || (d = d.closest(".btn")), b.call(d, "toggle"), c.preventDefault()
		}).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function (b) {
			a(b.target).closest(".btn").toggleClass("focus", "focus" == b.type)
		})
	}(jQuery), + function (a) {
		"use strict";

		function b(b) {
			return this.each(function () {
				var d = a(this),
					e = d.data("bs.collapse"),
					f = a.extend({}, c.DEFAULTS, d.data(), "object" == typeof b && b);
				!e && f.toggle && "show" == b && (b = !b), e || d.data("bs.collapse", e = new c(this, f)), "string" == typeof b && e[b]()
			})
		}
		var c = function (b, d) {
			this.$element = a(b), this.options = a.extend({}, c.DEFAULTS, d), this.transitioning = null, this.options.parent && (this.$parent = a(this.options.parent)), this.options.toggle && this.toggle()
		};
		c.VERSION = "3.2.0", c.DEFAULTS = {
			toggle: !0
		}, c.prototype.dimension = function () {
			var a = this.$element.hasClass("width");
			return a ? "width" : "height"
		}, c.prototype.show = function () {
			if (!this.transitioning && !this.$element.hasClass("in")) {
				var c = a.Event("show.bs.collapse");
				if (this.$element.trigger(c), !c.isDefaultPrevented()) {
					var d = this.$parent && this.$parent.find("> .panel > .in");
					if (d && d.length) {
						var e = d.data("bs.collapse");
						if (e && e.transitioning) return;
						b.call(d, "hide"), e || d.data("bs.collapse", null)
					}
					var f = this.dimension();
					this.$element.removeClass("collapse").addClass("collapsing")[f](0), this.transitioning = 1;
					var g = function () {
						this.$element.removeClass("collapsing").addClass("collapse in")[f](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse")
					};
					if (!a.support.transition) return g.call(this);
					var h = a.camelCase(["scroll", f].join("-"));
					this.$element.one("bsTransitionEnd", a.proxy(g, this)).emulateTransitionEnd(350)[f](this.$element[0][h])
				}
			}
		}, c.prototype.hide = function () {
			if (!this.transitioning && this.$element.hasClass("in")) {
				var b = a.Event("hide.bs.collapse");
				if (this.$element.trigger(b), !b.isDefaultPrevented()) {
					var c = this.dimension();
					this.$element[c](this.$element[c]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in"), this.transitioning = 1;
					var d = function () {
						this.transitioning = 0, this.$element.trigger("hidden.bs.collapse").removeClass("collapsing").addClass("collapse")
					};
					return a.support.transition ? void this.$element[c](0).one("bsTransitionEnd", a.proxy(d, this)).emulateTransitionEnd(350) : d.call(this)
				}
			}
		}, c.prototype.toggle = function () {
			this[this.$element.hasClass("in") ? "hide" : "show"]()
		};
		var d = a.fn.collapse;
		a.fn.collapse = b, a.fn.collapse.Constructor = c, a.fn.collapse.noConflict = function () {
			return a.fn.collapse = d, this
		}, a(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function (c) {
			var d, e = a(this),
				f = e.attr("data-target") || c.preventDefault() || (d = e.attr("href")) && d.replace(/.*(?=#[^\s]+$)/, ""),
				g = a(f),
				h = g.data("bs.collapse"),
				i = h ? "toggle" : e.data(),
				j = e.attr("data-parent"),
				k = j && a(j);
			h && h.transitioning || (k && k.find('[data-toggle="collapse"][data-parent="' + j + '"]').not(e).addClass("collapsed"), e.toggleClass("collapsed", g.hasClass("in"))), b.call(g, i)
		})
	}(jQuery),
	function (a) {
		var b = function () {
			var b = {
					bcClass: "sf-breadcrumb",
					menuClass: "sf-js-enabled",
					anchorClass: "sf-with-ul",
					menuArrowClass: "sf-arrows"
				},
				c = (function () {
					a(window).load(function () {
						a("body").children().on("click.superclick", function () {
							var b = a(".sf-js-enabled");
							b.superclick("reset")
						})
					})
				}(), function (a, c) {
					var d = b.menuClass;
					c.cssArrows && (d += " " + b.menuArrowClass), a.toggleClass(d)
				}),
				d = function (c, d) {
					return c.find("li." + d.pathClass).slice(0, d.pathLevels).addClass(d.activeClass + " " + b.bcClass).filter(function () {
						return a(this).children(".sidebar-submenu").hide().show().length
					}).removeClass(d.pathClass)
				},
				e = function (a) {
					a.children("a").toggleClass(b.anchorClass)
				},
				f = function (a) {
					var b = a.css("ms-touch-action");
					b = "pan-y" === b ? "auto" : "pan-y", a.css("ms-touch-action", b)
				},
				g = function () {
					var b, c = a(this),
						d = c.siblings(".sidebar-submenu");
					return d.length ? (b = d.is(":hidden") ? h : i, a.proxy(b, c.parent("li"))(), !1) : void 0
				},
				h = function () {
					{
						var b = a(this);
						l(b)
					}
					b.siblings().superclick("hide").end().superclick("show")
				},
				i = function () {
					var b = a(this),
						c = l(b);
					a.proxy(j, b, c)()
				},
				j = function (b) {
					b.retainPath = a.inArray(this[0], b.$path) > -1, this.superclick("hide"), this.parents("." + b.activeClass).length || (b.onIdle.call(k(this)), b.$path.length && a.proxy(h, b.$path)())
				},
				k = function (a) {
					return a.closest("." + b.menuClass)
				},
				l = function (a) {
					return k(a).data("sf-options")
				};
			return {
				hide: function (b) {
					if (this.length) {
						var c = this,
							d = l(c);
						if (!d) return this;
						var e = d.retainPath === !0 ? d.$path : "",
							f = c.find("li." + d.activeClass).add(this).not(e).removeClass(d.activeClass).children(".sidebar-submenu"),
							g = d.speedOut;
						b && (f.show(), g = 0), d.retainPath = !1, d.onBeforeHide.call(f), f.stop(!0, !0).animate(d.animationOut, g, function () {
							var b = a(this);
							d.onHide.call(b)
						})
					}
					return this
				},
				show: function () {
					var a = l(this);
					if (!a) return this;
					var b = this.addClass(a.activeClass),
						c = b.children(".sidebar-submenu");
					return a.onBeforeShow.call(c), c.stop(!0, !0).animate(a.animation, a.speed, function () {
						a.onShow.call(c)
					}), this
				},
				destroy: function () {
					return this.each(function () {
						var d = a(this),
							g = d.data("sf-options"),
							h = d.find("li:has(ul)");
						return g ? (c(d, g), e(h), f(d), d.off(".superclick"), h.children(".sidebar-submenu").attr("style", function (a, b) {
							return b.replace(/display[^;]+;?/g, "")
						}), g.$path.removeClass(g.activeClass + " " + b.bcClass).addClass(g.pathClass), d.find("." + g.activeClass).removeClass(g.activeClass), g.onDestroy.call(d), void d.removeData("sf-options")) : !1
					})
				},
				reset: function () {
					return this.each(function () {
						var b = a(this),
							c = l(b),
							d = a(b.find("." + c.activeClass).toArray().reverse());
						d.children("a").trigger("click")
					})
				},
				init: function (h) {
					return this.each(function () {
						var i = a(this);
						if (i.data("sf-options")) return !1;
						var j = a.extend({}, a.fn.superclick.defaults, h),
							k = i.find("li:has(ul)");
						j.$path = d(i, j), i.data("sf-options", j), c(i, j), e(k), f(i), i.on("click.superclick", "a", g), k.not("." + b.bcClass).superclick("hide", !0), j.onInit.call(this)
					})
				}
			}
		}();
		a.fn.superclick = function (c) {
			return b[c] ? b[c].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof c && c ? a.error("Method " + c + " does not exist on jQuery.fn.superclick") : b.init.apply(this, arguments)
		}, a.fn.superclick.defaults = {
			activeClass: "sfHover",
			pathClass: "overrideThisToUse",
			pathLevels: 1,
			animation: {
				opacity: "show"
			},
			animationOut: {
				opacity: "hide"
			},
			speed: "normal",
			speedOut: "fast",
			cssArrows: !0,
			onInit: a.noop,
			onBeforeShow: a.noop,
			onShow: a.noop,
			onBeforeHide: a.noop,
			onHide: a.noop,
			onIdle: a.noop,
			onDestroy: a.noop
		}
	}(jQuery),
	function (a) {
		a.fn.simpleCheckbox = function (b) {
			var c = {
					newElementClass: "switch-toggle",
					activeElementClass: "switch-on"
				},
				b = a.extend(c, b);
			this.each(function () {
				var c = a(this),
					d = a("<div/>", {
						id: "#" + c.attr("id"),
						"class": b.newElementClass,
						style: "display: block;"
					}).insertAfter(this);
				if (c.is(":checked") && d.addClass(b.activeElementClass), c.hide(), a("[for=" + c.attr("id") + "]").length) {
					var e = a("[for=" + c.attr("id") + "]");
					e.click(function () {
						return d.trigger("click"), !1
					})
				}
				d.click(function () {
					var c = a(this);
					return c.hasClass(b.activeElementClass) ? (c.removeClass(b.activeElementClass), a(c.attr("id")).attr("checked", !1)) : (c.addClass(b.activeElementClass), a(c.attr("id")).attr("checked", !0)), !1
				})
			})
		}
	}(jQuery),
	function (a) {
		jQuery.fn.extend({
			slimScroll: function (b) {
				var c = {
						width: "auto",
						height: "250px",
						size: "7px",
						color: "#000",
						position: "right",
						distance: "1px",
						start: "top",
						opacity: .4,
						alwaysVisible: !1,
						disableFadeOut: !1,
						railVisible: !1,
						railColor: "#333",
						railOpacity: .2,
						railDraggable: !0,
						railClass: "slimScrollRail",
						barClass: "slimScrollBar",
						wrapperClass: "slimScrollDiv",
						allowPageScroll: !1,
						wheelStep: 20,
						touchScrollStep: 200,
						borderRadius: "7px",
						railBorderRadius: "7px"
					},
					d = a.extend(c, b);
				return this.each(function () {
					function c(b) {
						if (j) {
							var b = b || window.event,
								c = 0;
							b.wheelDelta && (c = -b.wheelDelta / 120), b.detail && (c = b.detail / 3);
							var f = b.target || b.srcTarget || b.srcElement;
							a(f).closest("." + d.wrapperClass).is(v.parent()) && e(c, !0), b.preventDefault && !u && b.preventDefault(), u || (b.returnValue = !1)
						}
					}

					function e(a, b, c) {
						u = !1;
						var e = a,
							f = v.outerHeight() - A.outerHeight();
						if (b && (e = parseInt(A.css("top")) + a * parseInt(d.wheelStep) / 100 * A.outerHeight(), e = Math.min(Math.max(e, 0), f), e = a > 0 ? Math.ceil(e) : Math.floor(e), A.css({
								top: e + "px"
							})), p = parseInt(A.css("top")) / (v.outerHeight() - A.outerHeight()), e = p * (v[0].scrollHeight - v.outerHeight()), c) {
							e = a;
							var g = e / v[0].scrollHeight * v.outerHeight();
							g = Math.min(Math.max(g, 0), f), A.css({
								top: g + "px"
							})
						}
						v.scrollTop(e), v.trigger("slimscrolling", ~~e), h(), i()
					}

					function f() {
						window.addEventListener ? (this.addEventListener("DOMMouseScroll", c, !1), this.addEventListener("mousewheel", c, !1), this.addEventListener("MozMousePixelScroll", c, !1)) : document.attachEvent("onmousewheel", c)
					}

					function g() {
						o = Math.max(v.outerHeight() / v[0].scrollHeight * v.outerHeight(), s), A.css({
							height: o + "px"
						});
						var a = o == v.outerHeight() ? "none" : "block";
						A.css({
							display: a
						})
					}

					function h() {
						if (g(), clearTimeout(m), p == ~~p) {
							if (u = d.allowPageScroll, q != p) {
								var a = 0 == ~~p ? "top" : "bottom";
								v.trigger("slimscroll", a)
							}
						} else u = !1;
						return q = p, o >= v.outerHeight() ? void(u = !0) : (A.stop(!0, !0).fadeIn("fast"), void(d.railVisible && z.stop(!0, !0).fadeIn("fast")))
					}

					function i() {
						d.alwaysVisible || (m = setTimeout(function () {
							d.disableFadeOut && j || k || l || (A.fadeOut("slow"), z.fadeOut("slow"))
						}, 1e3))
					}
					var j, k, l, m, n, o, p, q, r = "<div></div>",
						s = 30,
						u = !1,
						v = a(this);
					if (v.parent().hasClass(d.wrapperClass)) {
						var w = v.scrollTop();
						if (A = v.parent().find("." + d.barClass), z = v.parent().find("." + d.railClass), g(), a.isPlainObject(b)) {
							if ("height" in b && "auto" == b.height) {
								v.parent().css("height", "auto"), v.css("height", "auto");
								var x = v.parent().parent().height();
								v.parent().css("height", x), v.css("height", x)
							}
							if ("scrollTo" in b) w = parseInt(d.scrollTo);
							else if ("scrollBy" in b) w += parseInt(d.scrollBy);
							else if ("destroy" in b) return A.remove(), z.remove(), void v.unwrap();
							e(w, !1, !0)
						}
					} else {
						d.height = "auto" == d.height ? v.parent().height() : d.height;
						var y = a(r).addClass(d.wrapperClass).css({
							position: "relative",
							overflow: "hidden",
							width: d.width,
							height: d.height
						});
						v.css({
							overflow: "hidden",
							width: d.width,
							height: d.height
						});
						var z = a(r).addClass(d.railClass).css({
								width: d.size,
								height: "100%",
								position: "absolute",
								top: 0,
								display: d.alwaysVisible && d.railVisible ? "block" : "none",
								"border-radius": d.railBorderRadius,
								background: d.railColor,
								opacity: d.railOpacity,
								zIndex: 90
							}),
							A = a(r).addClass(d.barClass).css({
								background: d.color,
								width: d.size,
								position: "absolute",
								top: 0,
								opacity: d.opacity,
								display: d.alwaysVisible ? "block" : "none",
								"border-radius": d.borderRadius,
								BorderRadius: d.borderRadius,
								MozBorderRadius: d.borderRadius,
								WebkitBorderRadius: d.borderRadius,
								zIndex: 99
							}),
							B = "right" == d.position ? {
								right: d.distance
							} : {
								left: d.distance
							};
						z.css(B), A.css(B), v.wrap(y), v.parent().append(A), v.parent().append(z), d.railDraggable && A.bind("mousedown", function (b) {
							var c = a(document);
							return l = !0, t = parseFloat(A.css("top")), pageY = b.pageY, c.bind("mousemove.slimscroll", function (a) {
								currTop = t + a.pageY - pageY, A.css("top", currTop), e(0, A.position().top, !1)
							}), c.bind("mouseup.slimscroll", function () {
								l = !1, i(), c.unbind(".slimscroll")
							}), !1
						}).bind("selectstart.slimscroll", function (a) {
							return a.stopPropagation(), a.preventDefault(), !1
						}), z.hover(function () {
							h()
						}, function () {
							i()
						}), A.hover(function () {
							k = !0
						}, function () {
							k = !1
						}), v.hover(function () {
							j = !0, h(), i()
						}, function () {
							j = !1, i()
						}), v.bind("touchstart", function (a) {
							a.originalEvent.touches.length && (n = a.originalEvent.touches[0].pageY)
						}), v.bind("touchmove", function (a) {
							if (u || a.originalEvent.preventDefault(), a.originalEvent.touches.length) {
								var b = (n - a.originalEvent.touches[0].pageY) / d.touchScrollStep;
								e(b, !0), n = a.originalEvent.touches[0].pageY
							}
						}), g(), "bottom" === d.start ? (A.css({
							top: v.outerHeight() - A.outerHeight()
						}), e(0, !0)) : "top" !== d.start && (e(a(d.start).position().top, null, !0), d.alwaysVisible || A.hide()), f()
					}
				}), this
			}
		}), jQuery.fn.extend({
			slimscroll: jQuery.fn.slimScroll
		})
	}(jQuery),
	function () {
		"use strict";
		var a = "undefined" != typeof module && module.exports,
			b = "undefined" != typeof Element && "ALLOW_KEYBOARD_INPUT" in Element,
			c = function () {
				for (var a, b, c = [
						["requestFullscreen", "exitFullscreen", "fullscreenElement", "fullscreenEnabled", "fullscreenchange", "fullscreenerror"],
						["webkitRequestFullscreen", "webkitExitFullscreen", "webkitFullscreenElement", "webkitFullscreenEnabled", "webkitfullscreenchange", "webkitfullscreenerror"],
						["webkitRequestFullScreen", "webkitCancelFullScreen", "webkitCurrentFullScreenElement", "webkitCancelFullScreen", "webkitfullscreenchange", "webkitfullscreenerror"],
						["mozRequestFullScreen", "mozCancelFullScreen", "mozFullScreenElement", "mozFullScreenEnabled", "mozfullscreenchange", "mozfullscreenerror"],
						["msRequestFullscreen", "msExitFullscreen", "msFullscreenElement", "msFullscreenEnabled", "MSFullscreenChange", "MSFullscreenError"]
					], d = 0, e = c.length, f = {}; e > d; d++)
					if (a = c[d], a && a[1] in document) {
						for (d = 0, b = a.length; b > d; d++) f[c[0][d]] = a[d];
						return f
					}
				return !1
			}(),
			d = {
				request: function (a) {
					var d = c.requestFullscreen;
					a = a || document.documentElement, /5\.1[\.\d]* Safari/.test(navigator.userAgent) ? a[d]() : a[d](b && Element.ALLOW_KEYBOARD_INPUT)
				},
				exit: function () {
					document[c.exitFullscreen]()
				},
				toggle: function (a) {
					this.isFullscreen ? this.exit() : this.request(a)
				},
				onchange: function () {},
				onerror: function () {},
				raw: c
			};
		return c ? (Object.defineProperties(d, {
			isFullscreen: {
				get: function () {
					return !!document[c.fullscreenElement]
				}
			},
			element: {
				enumerable: !0,
				get: function () {
					return document[c.fullscreenElement]
				}
			},
			enabled: {
				enumerable: !0,
				get: function () {
					return !!document[c.fullscreenEnabled]
				}
			}
		}), document.addEventListener(c.fullscreenchange, function (a) {
			d.onchange.call(d, a)
		}), document.addEventListener(c.fullscreenerror, function (a) {
			d.onerror.call(d, a)
		}), void(a ? module.exports = d : window.screenfull = d)) : void(a ? module.exports = !1 : window.screenfull = !1)
	}(),
	function (a) {
		return a.easyPieChart = function (b, c) {
			var d, e, f, g, h, i, j, k, l = this;
			return this.el = b, this.$el = a(b), this.$el.data("easyPieChart", this), this.init = function () {
				var b, d;
				return l.options = a.extend({}, a.easyPieChart.defaultOptions, c), b = parseInt(l.$el.data("percent"), 10), l.percentage = 0, l.canvas = a("<canvas width='" + l.options.size + "' height='" + l.options.size + "'></canvas>").get(0), l.$el.append(l.canvas), "undefined" != typeof G_vmlCanvasManager && null !== G_vmlCanvasManager && G_vmlCanvasManager.initElement(l.canvas), l.ctx = l.canvas.getContext("2d"), window.devicePixelRatio > 1 && (d = window.devicePixelRatio, a(l.canvas).css({
					width: l.options.size,
					height: l.options.size
				}), l.canvas.width *= d, l.canvas.height *= d, l.ctx.scale(d, d)), l.ctx.translate(l.options.size / 2, l.options.size / 2), l.ctx.rotate(l.options.rotate * Math.PI / 180), l.$el.addClass("easyPieChart"), l.$el.css({
					width: l.options.size,
					height: l.options.size,
					lineHeight: "" + l.options.size + "px"
				}), l.update(b), l
			}, this.update = function (a) {
				return a = parseFloat(a) || 0, l.options.animate === !1 ? f(a) : e(l.percentage, a), l
			}, j = function () {
				var a, b, c;
				for (l.ctx.fillStyle = l.options.scaleColor, l.ctx.lineWidth = 1, c = [], a = b = 0; 24 >= b; a = ++b) c.push(d(a));
				return c
			}, d = function (a) {
				var b;
				b = a % 6 === 0 ? 0 : .017 * l.options.size, l.ctx.save(), l.ctx.rotate(a * Math.PI / 12), l.ctx.fillRect(l.options.size / 2 - b, 0, .05 * -l.options.size + b, 1), l.ctx.restore()
			}, k = function () {
				var a;
				a = l.options.size / 2 - l.options.lineWidth / 2, l.options.scaleColor !== !1 && (a -= .08 * l.options.size), l.ctx.beginPath(), l.ctx.arc(0, 0, a, 0, 2 * Math.PI, !0), l.ctx.closePath(), l.ctx.strokeStyle = l.options.trackColor, l.ctx.lineWidth = l.options.lineWidth, l.ctx.stroke()
			}, i = function () {
				l.options.scaleColor !== !1 && j(), l.options.trackColor !== !1 && k()
			}, f = function (b) {
				var c;
				i(), l.ctx.strokeStyle = a.isFunction(l.options.barColor) ? l.options.barColor(b) : l.options.barColor, l.ctx.lineCap = l.options.lineCap, l.ctx.lineWidth = l.options.lineWidth, c = l.options.size / 2 - l.options.lineWidth / 2, l.options.scaleColor !== !1 && (c -= .08 * l.options.size), l.ctx.save(), l.ctx.rotate(-Math.PI / 2), l.ctx.beginPath(), l.ctx.arc(0, 0, c, 0, 2 * Math.PI * b / 100, !1), l.ctx.stroke(), l.ctx.restore()
			}, h = function () {
				return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function (a) {
					return window.setTimeout(a, 1e3 / 60)
				}
			}(), e = function (a, b) {
				var c, d;
				l.options.onStart.call(l), l.percentage = b, d = Date.now(), c = function () {
					var e, j;
					return j = Date.now() - d, j < l.options.animate && h(c), l.ctx.clearRect(-l.options.size / 2, -l.options.size / 2, l.options.size, l.options.size), i.call(l), e = [g(j, a, b - a, l.options.animate)], l.options.onStep.call(l, e), f.call(l, e), j >= l.options.animate ? l.options.onStop.call(l) : void 0
				}, h(c)
			}, g = function (a, b, c, d) {
				var e, f;
				return e = function (a) {
					return Math.pow(a, 2)
				}, f = function (a) {
					return 1 > a ? e(a) : 2 - e(a / 2 * -2 + 2)
				}, a /= d / 2, c / 2 * f(a) + b
			}, this.init()
		}, a.easyPieChart.defaultOptions = {
			barColor: "#ef1e25",
			trackColor: "#f2f2f2",
			scaleColor: "#dfe0e0",
			lineCap: "round",
			rotate: 0,
			size: 110,
			lineWidth: 3,
			animate: !1,
			onStart: a.noop,
			onStop: a.noop,
			onStep: a.noop
		}, void(a.fn.easyPieChart = function (b) {
			return a.each(this, function (c, d) {
				var e, f;
				return e = a(d), e.data("easyPieChart") ? void 0 : (f = a.extend({}, b, e.data()), e.data("easyPieChart", new a.easyPieChart(d, f)))
			})
		})
	}(jQuery);
var initPieChart = function () {
	$(".chart").easyPieChart({
		barColor: function (a) {
			return a /= 100, "rgb(" + Math.round(254 * (1 - a)) + ", " + Math.round(255 * a) + ", 0)"
		},
		animate: 1e3,
		scaleColor: "#ccc",
		lineWidth: 3,
		size: 100,
		lineCap: "cap",
		onStep: function (a) {
			this.$el.find("span").text(~~a)
		}
	}), $(".chart-home").easyPieChart({
		barColor: "rgba(255,255,255,0.5)",
		trackColor: "rgba(255,255,255,0.1)",
		animate: 1e3,
		scaleColor: "rgba(255,255,255,0.3)",
		lineWidth: 3,
		size: 100,
		lineCap: "cap",
		onStep: function (a) {
			this.$el.find("span").text(~~a)
		}
	}), $(".chart-alt").easyPieChart({
		barColor: function (a) {
			return a /= 100, "rgb(" + Math.round(255 * (1 - a)) + ", " + Math.round(255 * a) + ", 0)"
		},
		trackColor: "#333",
		scaleColor: !1,
		lineCap: "butt",
		rotate: -90,
		lineWidth: 20,
		animate: 1500,
		onStep: function (a) {
			this.$el.find("span").text(~~a)
		}
	}), $(".chart-alt-1").easyPieChart({
		barColor: function (a) {
			return a /= 100, "rgb(" + Math.round(255 * (1 - a)) + ", " + Math.round(255 * a) + ", 0)"
		},
		trackColor: "#e1ecf1",
		scaleColor: "#c4d7e0",
		lineCap: "cap",
		rotate: -90,
		lineWidth: 10,
		size: 80,
		animate: 2500,
		onStep: function (a) {
			this.$el.find("span").text(~~a)
		}
	}), $(".chart-alt-2").easyPieChart({
		barColor: function (a) {
			return a /= 100, "rgb(" + Math.round(255 * (1 - a)) + ", " + Math.round(255 * a) + ", 0)"
		},
		trackColor: "#fff",
		scaleColor: !1,
		lineCap: "butt",
		rotate: -90,
		lineWidth: 4,
		size: 50,
		animate: 1500,
		onStep: function (a) {
			this.$el.find("span").text(~~a)
		}
	}), $(".chart-alt-3").easyPieChart({
		barColor: function (a) {
			return a /= 100, "rgb(" + Math.round(255 * (1 - a)) + ", " + Math.round(255 * a) + ", 0)"
		},
		trackColor: "#333",
		scaleColor: !0,
		lineCap: "butt",
		rotate: -90,
		lineWidth: 4,
		size: 50,
		animate: 1500,
		onStep: function (a) {
			this.$el.find("span").text(~~a)
		}
	}), $(".chart-alt-10").easyPieChart({
		barColor: "rgba(255,255,255,255.4)",
		trackColor: "rgba(255,255,255,0.1)",
		scaleColor: "transparent",
		lineCap: "round",
		rotate: -90,
		lineWidth: 4,
		size: 100,
		animate: 2500,
		onStep: function (a) {
			this.$el.find("span").text(~~a)
		}
	}), $(".updateEasyPieChart").on("click", function (a) {
		a.preventDefault(), $(".chart-home, .chart, .chart-alt, .chart-alt-1, .chart-alt-2, .chart-alt-3, .chart-alt-10").each(function () {
			$(this).data("easyPieChart").update(Math.round(100 * Math.random()))
		})
	})
};
$(document).ready(function () {
		initPieChart()
	}),
	function (a) {
		a.slidebars = function (b) {
			function c() {
				!j.disableOver || "number" == typeof j.disableOver && j.disableOver >= w ? (v = !0, a("html").addClass("sb-init"), j.hideControlClasses && x.removeClass("sb-hide"), d()) : "number" == typeof j.disableOver && j.disableOver < w && (v = !1, a("html").removeClass("sb-init"), j.hideControlClasses && x.addClass("sb-hide"), q.css("minHeight", ""), (s || u) && g())
			}

			function d() {
				q.css("minHeight", ""), q.css("minHeight", a("html").height() + "px"), r && r.hasClass("sb-width-custom") && r.css("width", r.attr("data-sb-width")), t && t.hasClass("sb-width-custom") && t.css("width", t.attr("data-sb-width")), r && (r.hasClass("sb-style-push") || r.hasClass("sb-style-overlay")) && r.css("marginLeft", "-" + r.css("width")), t && (t.hasClass("sb-style-push") || t.hasClass("sb-style-overlay")) && t.css("marginRight", "-" + t.css("width")), j.scrollLock && a("html").addClass("sb-scroll-lock")
			}

			function e(a, b, c) {
				var e;
				if (e = a.hasClass("sb-style-push") ? q.add(a).add(y) : a.hasClass("sb-style-overlay") ? a : q.add(y), "translate" === z) e.css("transform", "translate(" + b + ")");
				else if ("side" === z) "-" === b[0] && (b = b.substr(1)), "0px" !== b && e.css(c, "0px"), setTimeout(function () {
					e.css(c, b)
				}, 1);
				else if ("jQuery" === z) {
					"-" === b[0] && (b = b.substr(1));
					var f = {};
					f[c] = b, e.stop().animate(f, 400)
				}
				setTimeout(function () {
					"0px" === b && (e.removeAttr("style"), d())
				}, 400)
			}

			function f(b, c) {
				function d() {
					v && "left" === b && r ? (a("html").addClass("sb-active sb-active-left"), r.addClass("sb-active"), e(r, r.css("width"), "left"), setTimeout(function () {
						s = !0, "function" == typeof c && c()
					}, 400)) : v && "right" === b && t && (a("html").addClass("sb-active sb-active-right"), t.addClass("sb-active"), e(t, "-" + t.css("width"), "right"), setTimeout(function () {
						u = !0, "function" == typeof c && c()
					}, 400))
				}
				"left" === b && r && u || "right" === b && t && s ? (g(), setTimeout(d, 400)) : d()
			}

			function g(b) {
				(s || u) && (s && (e(r, "0px", "left"), s = !1), u && (e(t, "0px", "right"), u = !1), setTimeout(function () {
					a("html").removeClass("sb-active sb-active-left sb-active-right"), r && r.removeClass("sb-active"), t && t.removeClass("sb-active"), "function" == typeof b && b()
				}, 400))
			}

			function h(a, b) {
				"left" === a && r && (s ? g(null, b) : f("left", b)), "right" === a && t && (u ? g(null, b) : f("right", b))
			}

			function i(a, b) {
				a.stopPropagation(), a.preventDefault(), "touchend" === a.type && b.off("click")
			}
			var j = a.extend({
					siteClose: !0,
					scrollLock: !1,
					disableOver: !1,
					hideControlClasses: !1
				}, b),
				k = document.createElement("div").style,
				l = !1,
				m = !1;
			("" === k.MozTransition || "" === k.WebkitTransition || "" === k.OTransition || "" === k.transition) && (l = !0), ("" === k.MozTransform || "" === k.WebkitTransform || "" === k.OTransform || "" === k.transform) && (m = !0);
			var n = navigator.userAgent,
				o = !1,
				p = !1;
			/Android/.test(n) ? o = n.substr(n.indexOf("Android") + 8, 3) : /(iPhone|iPod|iPad)/.test(n) && (p = n.substr(n.indexOf("OS ") + 3, 3).replace("_", ".")), (o && 3 > o || p && 5 > p) && a("html").addClass("sb-static");
			var q = a("#sb-site, .sb-site-container");
			if (a(".sb-left").length) var r = a(".sb-left"),
				s = !1;
			if (a(".sb-right").length) var t = a(".sb-right"),
				u = !1;
			var v = !1,
				w = a(window).width(),
				x = a(".sb-toggle-left, .sb-toggle-right, .sb-open-left, .sb-open-right, .sb-close"),
				y = a(".sb-slide");
			c(), a(window).resize(function () {
				var b = a(window).width();
				w !== b && (w = b, c(), s && f("left"), u && f("right"))
			});
			var z;
			l && m ? (z = "translate", o && 4.4 > o && (z = "side")) : z = "jQuery", this.slidebars = {
				open: f,
				close: g,
				toggle: h,
				init: function () {
					return v
				},
				reInit: c,
				resetCSS: d,
				active: function (a) {
					return "left" === a && r ? s : "right" === a && t ? u : void 0
				},
				destroy: function (a) {
					"left" === a && r && (s && g(), setTimeout(function () {
						r.remove(), r = !1
					}, 400)), "right" === a && t && (u && g(), setTimeout(function () {
						t.remove(), t = !1
					}, 400))
				}
			}, a(".sb-toggle-left").on("touchend click", function (b) {
				i(b, a(this)), h("left")
			}), a(".sb-toggle-right").on("touchend click", function (b) {
				i(b, a(this)), h("right")
			}), a(".sb-open-left").on("touchend click", function (b) {
				i(b, a(this)), f("left")
			}), a(".sb-open-right").on("touchend click", function (b) {
				i(b, a(this)), f("right")
			}), a(".sb-close").on("touchend click", function (b) {
				if (a(this).is("a") || a(this).children().is("a")) {
					if ("click" === b.type) {
						b.preventDefault();
						var c = a(this).is("a") ? a(this).attr("href") : a(this).find("a").attr("href");
						g(function () {
							window.location = c
						})
					}
				} else i(b, a(this)), g()
			}), q.on("touchend click", function (b) {
				j.siteClose && (s || u) && (i(b, a(this)), g())
			})
		}
	}(jQuery),
	function (a) {
		a(document).ready(function () {
			a.slidebars()
		})
	}(jQuery), $(document).ready(function () {
		$(".switch-button").click(function (a) {
			a.preventDefault();
			var b = $(this).attr("switch-parent"),
				c = $(this).attr("switch-target");
			$(b).slideToggle(), $(c).slideToggle()
		}), $(".hidden-button").hover(function () {
			$(".btn-hide", this).fadeIn("fast")
		}, function () {
			$(".btn-hide", this).fadeOut("normal")
		}), $(".toggle-button").click(function (a) {
			a.preventDefault(), $(".glyph-icon", this).toggleClass("icon-rotate-180"), $(this).parents(".content-box:first").find(".content-box-wrapper").slideToggle()
		}), $(".remove-button").click(function (a) {
			a.preventDefault();
			var b = $(this).attr("data-animation"),
				c = $(this).parents(".content-box:first");
			$(c).addClass("animated"), $(c).addClass(b);
			window.setTimeout(function () {
				$(c).slideUp()
			}, 500), window.setTimeout(function () {
				$(c).removeClass(b).fadeIn()
			}, 2500)
		}), $(function () {
			"use strict";
			$(".infobox-close").click(function (a) {
				a.preventDefault(), $(this).parent().fadeOut()
			})
		})
	}), $(document).ready(function () {
		$(".overlay-button").click(function () {
			var a = $(this).attr("data-theme"),
				b = $(this).attr("data-opacity"),
				c = $(this).attr("data-style"),
				d = '<div id="loader-overlay" class="ui-front loader ui-widget-overlay ' + a + " opacity-" + b + '"><img src="../../assets/images/spinner/loader-' + c + '.gif" alt="" /></div>';
			$("#loader-overlay").length && $("#loader-overlay").remove(), $("body").append(d), $("#loader-overlay").fadeIn("fast"), setTimeout(function () {
				$("#loader-overlay").fadeOut("fast")
			}, 3e3)
		}), $(".refresh-button").click(function (a) {
			$(".glyph-icon", this).addClass("icon-spin"), a.preventDefault();
			var b = $(this).parents(".content-box"),
				c = $(this).attr("data-theme"),
				d = $(this).attr("data-opacity"),
				e = $(this).attr("data-style"),
				f = '<div id="refresh-overlay" class="ui-front loader ui-widget-overlay ' + c + " opacity-" + d + '"><img src="../../assets/images/spinner/loader-' + e + '.gif" alt="" /></div>';
			$("#refresh-overlay").length && $("#refresh-overlay").remove(), $(b).append(f), $("#refresh-overlay").fadeIn("fast"), setTimeout(function () {
				$("#refresh-overlay").fadeOut("fast"), $(".glyph-icon", this).removeClass("icon-spin")
			}, 1500)
		})
	}),
	function (a) {
		function b(a) {
			return "undefined" == typeof a.which ? !0 : "number" == typeof a.which && a.which > 0 ? !a.ctrlKey && !a.metaKey && !a.altKey && 8 != a.which && 9 != a.which : !1
		}
		a.expr[":"].notmdproc = function (b) {
			return a(b).data("mdproc") ? !1 : !0
		}, a.material = {
			options: {
				input: !1,
				ripples: !0,
				checkbox: !1,
				togglebutton: !1,
				radio: !1,
				arrive: !1,
				autofill: !1,
				withRipples: [".btn:not(.btn-link)", ".card-image", ".navbar a:not(.withoutripple)", ".dropdown-menu a", ".nav-tabs a:not(.withoutripple)", ".withripple"].join(","),
				inputElements: "input.form-control, textarea.form-control, select.form-control",
				checkboxElements: ".checkbox > label > input[type=checkbox]",
				togglebuttonElements: ".togglebutton > label > input[type=checkbox]",
				radioElements: ".radio > label > input[type=radio]"
			},
			checkbox: function (b) {
				a(b ? b : this.options.checkboxElements).filter(":notmdproc").data("mdproc", !0).after("<span class=ripple></span><span class=check></span>")
			},
			togglebutton: function (b) {
				a(b ? b : this.options.togglebuttonElements).filter(":notmdproc").data("mdproc", !0).after("<span class=toggle></span>")
			},
			radio: function (b) {
				a(b ? b : this.options.radioElements).filter(":notmdproc").data("mdproc", !0).after("<span class=circle></span><span class=check></span>")
			},
			input: function (c) {
				a(c ? c : this.options.inputElements).filter(":notmdproc").data("mdproc", !0).each(function () {
					var b = a(this);
					if (a(this).attr("data-hint") || b.hasClass("floating-label")) {
						if (b.wrap("<div class=form-control-wrapper></div>"), b.after("<span class=material-input></span>"), b.hasClass("floating-label")) {
							var c = b.attr("placeholder");
							b.attr("placeholder", null).removeClass("floating-label"), b.after("<div class=floating-label>" + c + "</div>")
						}
						if (b.attr("data-hint") && b.after("<div class=hint>" + b.attr("data-hint") + "</div>"), (null === b.val() || "undefined" == b.val() || "" === b.val()) && b.addClass("empty"), b.parent().next().is("[type=file]")) {
							b.parent().addClass("fileinput");
							var d = b.parent().next().detach();
							b.after(d)
						}
					}
				}), a(document).on("change", ".checkbox input[type=checkbox]", function () {
					a(this).blur()
				}).on("keydown paste", ".form-control", function (c) {
					b(c) && a(this).removeClass("empty")
				}).on("keyup change", ".form-control", function () {
					var b = a(this);
					"" === b.val() && b[0].checkValidity() ? b.addClass("empty") : b.removeClass("empty")
				}).on("focus", ".form-control-wrapper.fileinput", function () {
					a(this).find("input").addClass("focus")
				}).on("blur", ".form-control-wrapper.fileinput", function () {
					a(this).find("input").removeClass("focus")
				}).on("change", ".form-control-wrapper.fileinput [type=file]", function () {
					var b = "";
					a.each(a(this)[0].files, function (a, c) {
						b += c.name + ", "
					}), b = b.substring(0, b.length - 2), b ? a(this).prev().removeClass("empty") : a(this).prev().addClass("empty"), a(this).prev().val(b)
				})
			},
			ripples: function (b) {
				a(b ? b : this.options.withRipples).ripples()
			},
			autofill: function () {
				var b = setInterval(function () {
					a("input[type!=checkbox]").each(function () {
						a(this).val() && a(this).val() !== a(this).attr("value") && a(this).trigger("change")
					})
				}, 100);
				setTimeout(function () {
					clearInterval(b)
				}, 1e4);
				var c;
				a(document).on("focus", "input", function () {
					var b = a(this).parents("form").find("input").not("[type=file]");
					c = setInterval(function () {
						b.each(function () {
							a(this).val() !== a(this).attr("value") && a(this).trigger("change")
						})
					}, 100)
				}).on("blur", "input", function () {
					clearInterval(c)
				})
			},
			init: function () {
				a.fn.ripples && this.options.ripples && this.ripples(), this.options.input && this.input(), this.options.checkbox && this.checkbox(), this.options.togglebutton && this.togglebutton(), this.options.radio && this.radio(), this.options.autofill && this.autofill(), document.arrive && this.options.arrive && (a.fn.ripples && this.options.ripples && a(document).arrive(this.options.withRipples, function () {
					a.material.ripples(a(this))
				}), this.options.input && a(document).arrive(this.options.inputElements, function () {
					a.material.input(a(this))
				}), this.options.checkbox && a(document).arrive(this.options.checkboxElements, function () {
					a.material.checkbox(a(this))
				}), this.options.radio && a(document).arrive(this.options.radioElements, function () {
					a.material.radio(a(this))
				}), this.options.togglebutton && a(document).arrive(this.options.togglebuttonElements, function () {
					a.material.togglebutton(a(this))
				}))
			}
		}
	}(jQuery),
	function (a, b, c, d) {
		"use strict";

		function e(b, c) {
			g = this, this.element = a(b), this.options = a.extend({}, h, c), this._defaults = h, this._name = f, this.init()
		}
		var f = "ripples",
			g = null,
			h = {};
		e.prototype.init = function () {
			var c = this.element;
			c.on("mousedown touchstart", function (d) {
				/**if (g.isTouch() && "mousedown" === d.type) return !1;
				c.find(".ripple-wrapper").length || c.append('<div class="ripple-wrapper"></div>');
				var e = c.children(".ripple-wrapper"),
					f = g.getRelY(e, d),
					h = g.getRelX(e, d);
				if (f || h) {
					var i = g.getRipplesColor(c),
						j = a("<div></div>");
					j.addClass("ripple").css({
							left: h,
							top: f,
							"background-color": i
						}), e.append(j),
						function () {
							return b.getComputedStyle(j[0]).opacity
						}(), g.rippleOn(c, j), setTimeout(function () {
							g.rippleEnd(j)
						}, 500), c.on("mouseup mouseleave touchend", function () {
							j.data("mousedown", "off"), "off" === j.data("animating") && g.rippleOut(j)
						})
				} */
			})
		}, e.prototype.getNewSize = function (a, b) {
			return Math.max(a.outerWidth(), a.outerHeight()) / b.outerWidth() * 2.5
		}, e.prototype.getRelX = function (a, b) {
			var c = a.offset();
			return g.isTouch() ? (b = b.originalEvent, 1 !== b.touches.length ? b.touches[0].pageX - c.left : !1) : b.pageX - c.left
		}, e.prototype.getRelY = function (a, b) {
			var c = a.offset();
			return g.isTouch() ? (b = b.originalEvent, 1 !== b.touches.length ? b.touches[0].pageY - c.top : !1) : b.pageY - c.top
		}, e.prototype.getRipplesColor = function (a) {
			var c = a.data("ripple-color") ? a.data("ripple-color") : b.getComputedStyle(a[0]).color;
			return c
		}, e.prototype.hasTransitionSupport = function () {
			var a = c.body || c.documentElement,
				b = a.style,
				e = b.transition !== d || b.WebkitTransition !== d || b.MozTransition !== d || b.MsTransition !== d || b.OTransition !== d;
			return e
		}, e.prototype.isTouch = function () {
			return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
		}, e.prototype.rippleEnd = function (a) {
			a.data("animating", "off"), "off" === a.data("mousedown") && g.rippleOut(a)
		}, e.prototype.rippleOut = function (a) {
			a.off(), g.hasTransitionSupport() ? a.addClass("ripple-out") : a.animate({
				opacity: 0
			}, 100, function () {
				a.trigger("transitionend")
			}), a.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function () {
				a.remove()
			})
		}, e.prototype.rippleOn = function (a, b) {
			var c = g.getNewSize(a, b);
			g.hasTransitionSupport() ? b.css({
				"-ms-transform": "scale(" + c + ")",
				"-moz-transform": "scale(" + c + ")",
				"-webkit-transform": "scale(" + c + ")",
				transform: "scale(" + c + ")"
			}).addClass("ripple-on").data("animating", "on").data("mousedown", "on") : b.animate({
				width: 2 * Math.max(a.outerWidth(), a.outerHeight()),
				height: 2 * Math.max(a.outerWidth(), a.outerHeight()),
				"margin-left": -1 * Math.max(a.outerWidth(), a.outerHeight()),
				"margin-top": -1 * Math.max(a.outerWidth(), a.outerHeight()),
				opacity: .2
			}, 500, function () {
				b.trigger("transitionend")
			})
		}, a.fn.ripples = function (b) {
			return this.each(function () {
				a.data(this, "plugin_" + f) || a.data(this, "plugin_" + f, new e(this, b))
			})
		}
	}(jQuery, window, document), $(function () {
		"use strict";
		$('a[href="#"]').click(function (a) {
			a.preventDefault()
		})
	}), $(function () {
		"use strict";
		$(".todo-box li input").on("click", function () {
			$(this).parent().toggleClass("todo-done")
		})
	}), $(function () {
		"use strict";
		var a = 0;
		$(".timeline-scroll .tl-row").each(function (b, c) {
			var d = $(c);
			a += d.outerWidth() + parseInt(d.css("margin-left"), 10) + parseInt(d.css("margin-right"), 10)
		}), $(".timeline-horizontal", this).width(a)
	}), $(function () {
		"use strict";
		$(".input-switch-alt").simpleCheckbox()
	}), $(function () {
		"use strict";
		$(".scrollable-slim").slimScroll({
			color: "#8da0aa",
			size: "10px",
			alwaysVisible: !0
		})
	}), $(function () {
		"use strict";
		$(".scrollable-slim-sidebar").slimScroll({
			color: "#8da0aa",
			size: "10px",
			height: "100%",
			alwaysVisible: !0
		})
	}), $(function () {
		"use strict";
		$(".scrollable-slim-box").slimScroll({
			color: "#8da0aa",
			size: "6px",
			alwaysVisible: !1
		})
	}), $(function () {
		"use strict";
		$(".loading-button").click(function () {
			var a = $(this);
			a.button("loading")
		})
	}), $(function () {
		"use strict";
		$(".tooltip-button").tooltip({
			container: "body"
		})
	}), $(function () {
		"use strict";
		$(".alert-close-btn").click(function () {
			$(this).parent().addClass("animated fadeOutDown")
		})
	}), $(function () {
		"use strict";
		$(".popover-button").popover({
			container: "body",
			html: !0,
			animation: !0,
			content: function () {
				var a = $(this).attr("data-id");
				return $(a).html()
			}
		}).click(function (a) {
			a.preventDefault()
		})
	}), $(document).ready(function () {
		$.material.init()
	}), $(function () {
		"use strict";
		$(".popover-button-default").popover({
			container: "body",
			html: !0,
			animation: !0
		}).click(function (a) {
			a.preventDefault()
		})
	});
var mUIColors = {
		"default": "#3498db",
		gray: "#d6dde2",
		primary: "#00bca4",
		success: "#2ecc71",
		warning: "#e67e22",
		danger: "#e74c3c",
		info: "#3498db"
	},
	getUIColor = function (a) {
		return mUIColors[a] ? mUIColors[a] : mUIColors["default"]
	};
document.getElementById("fullscreen-btn").addEventListener("click", function () {
	screenfull.enabled && screenfull.request()
}), $(document).ready(function () {
	body_sizer(), $(function () {
		$(".scroll-sidebar").slimscroll({
			height: "100%",
			color: "rgba(155, 164, 169, 0.68)",
			size: "6px"
		})
	}), $(function () {
		$("#sidebar-menu").hover(function () {
			$("#page-sidebar").toggleClass("sidebar-hover")
		})
	})
}), $(window).on("resize", function () {
	body_sizer()
}), $(document).ready(function () {
	pageTransitions(), $(function () {
		$("#sidebar-menu").superclick({
			animation: {
				height: "show"
			},
			animationOut: {
				height: "hide"
			}
		})
	}), $(function () {
		$("#close-sidebar").click(function () {
			$("body").toggleClass("closed-sidebar"), $(".glyph-icon", this).toggleClass("icon-outdent").toggleClass("icon-indent")
		})
	})
});

