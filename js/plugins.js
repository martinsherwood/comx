// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.
/**
 * Featherlight - ultra slim jQuery lightbox
 * Version 1.3.5 - http://noelboss.github.io/featherlight/
 *
 * Copyright 2015, Noël Raoul Bossart (http://www.noelboss.com)
 * MIT Licensed.
**/
! function (a) {
	"use strict";

	function b(a, c) {
		if (!(this instanceof b)) {
			var d = new b(a, c);
			return d.open(), d
		}
		this.id = b.id++, this.setup(a, c), this.chainCallbacks(b._callbackChain)
	}
	if ("undefined" == typeof a) return void("console" in window && window.console.info("Too much lightness, Featherlight needs jQuery."));
	var c = [],
		d = function (b) {
			return c = a.grep(c, function (a) {
				return a !== b && a.$instance.closest("body").length > 0
			})
		},
		e = function (a, b) {
			var c = {},
				d = new RegExp("^" + b + "([A-Z])(.*)");
			for (var e in a) {
				var f = e.match(d);
				if (f) {
					var g = (f[1] + f[2].replace(/([A-Z])/g, "-$1")).toLowerCase();
					c[g] = a[e]
				}
			}
			return c
		},
		f = {
			keyup: "onKeyUp",
			resize: "onResize"
		},
		g = function (c) {
			a.each(b.opened().reverse(), function () {
				return c.isDefaultPrevented() || !1 !== this[f[c.type]](c) ? void 0 : (c.preventDefault(), c.stopPropagation(), !1)
			})
		},
		h = function (c) {
			if (c !== b._globalHandlerInstalled) {
				b._globalHandlerInstalled = c;
				var d = a.map(f, function (a, c) {
					return c + "." + b.prototype.namespace
				}).join(" ");
				a(window)[c ? "on" : "off"](d, g)
			}
		};
	b.prototype = {
		constructor: b,
		namespace: "featherlight",
		targetAttr: "data-featherlight",
		variant: null,
		resetCss: !1,
		background: null,
		openTrigger: "click",
		closeTrigger: "click",
		filter: null,
		root: "body",
		openSpeed: 250,
		closeSpeed: 250,
		closeOnClick: "background",
		closeOnEsc: !0,
		closeIcon: "&#10005;",
		loading: "",
		persist: !1,
		otherClose: null,
		beforeOpen: a.noop,
		beforeContent: a.noop,
		beforeClose: a.noop,
		afterOpen: a.noop,
		afterContent: a.noop,
		afterClose: a.noop,
		onKeyUp: a.noop,
		onResize: a.noop,
		type: null,
		contentFilters: ["jquery", "image", "html", "ajax", "iframe", "text"],
		setup: function (b, c) {
			"object" != typeof b || b instanceof a != !1 || c || (c = b, b = void 0);
			var d = a.extend(this, c, {
					target: b
				}),
				e = d.resetCss ? d.namespace + "-reset" : d.namespace,
				f = a(d.background || ['<div class="' + e + "-loading " + e + '">', '<div class="' + e + '-content">', '<span class="' + e + "-close-icon " + d.namespace + '-close">', d.closeIcon, "</span>", '<div class="' + d.namespace + '-inner">' + d.loading + "</div>", "</div>", "</div>"].join("")),
				g = "." + d.namespace + "-close" + (d.otherClose ? "," + d.otherClose : "");
			return d.$instance = f.clone().addClass(d.variant), d.$instance.on(d.closeTrigger + "." + d.namespace, function (b) {
				var c = a(b.target);
				("background" === d.closeOnClick && c.is("." + d.namespace) || "anywhere" === d.closeOnClick || c.closest(g).length) && (d.close(b), b.preventDefault())
			}), this
		},
		getContent: function () {
			if (this.persist !== !1 && this.$content) return this.$content;
			var b = this,
				c = this.constructor.contentFilters,
				d = function (a) {
					return b.$currentTarget && b.$currentTarget.attr(a)
				},
				e = d(b.targetAttr),
				f = b.target || e || "",
				g = c[b.type];
			if (!g && f in c && (g = c[f], f = b.target && e), f = f || d("href") || "", !g)
				for (var h in c) b[h] && (g = c[h], f = b[h]);
			if (!g) {
				var i = f;
				if (f = null, a.each(b.contentFilters, function () {
						return g = c[this], g.test && (f = g.test(i)), !f && g.regex && i.match && i.match(g.regex) && (f = i), !f
					}), !f) return "console" in window && window.console.error("Featherlight: no content filter found " + (i ? ' for "' + i + '"' : " (no target specified)")), !1
			}
			return g.process.call(b, f)
		},
		setContent: function (b) {
			var c = this;
			return (b.is("iframe") || a("iframe", b).length > 0) && c.$instance.addClass(c.namespace + "-iframe"), c.$instance.removeClass(c.namespace + "-loading"), c.$instance.find("." + c.namespace + "-inner").not(b).slice(1).remove().end().replaceWith(a.contains(c.$instance[0], b[0]) ? "" : b), c.$content = b.addClass(c.namespace + "-inner"), c
		},
		open: function (b) {
			var d = this;
			if (d.$instance.hide().appendTo(d.root), !(b && b.isDefaultPrevented() || d.beforeOpen(b) === !1)) {
				b && b.preventDefault();
				var e = d.getContent();
				if (e) return c.push(d), h(!0), d.$instance.fadeIn(d.openSpeed), d.beforeContent(b), a.when(e).always(function (a) {
					d.setContent(a), d.afterContent(b)
				}).then(d.$instance.promise()).done(function () {
					d.afterOpen(b)
				})
			}
			return d.$instance.detach(), a.Deferred().reject().promise()
		},
		close: function (b) {
			var c = this,
				e = a.Deferred();
			return c.beforeClose(b) === !1 ? e.reject() : (0 === d(c).length && h(!1), c.$instance.fadeOut(c.closeSpeed, function () {
				c.$instance.detach(), c.afterClose(b), e.resolve()
			})), e.promise()
		},
		chainCallbacks: function (b) {
			for (var c in b) this[c] = a.proxy(b[c], this, a.proxy(this[c], this))
		}
	}, a.extend(b, {
		id: 0,
		autoBind: "[data-featherlight]",
		defaults: b.prototype,
		contentFilters: {
			jquery: {
				regex: /^[#.]\w/,
				test: function (b) {
					return b instanceof a && b
				},
				process: function (b) {
					return this.persist !== !1 ? a(b) : a(b).clone(!0)
				}
			},
			image: {
				regex: /\.(png|jpg|jpeg|gif|tiff|bmp|svg)(\?\S*)?$/i,
				process: function (b) {
					var c = this,
						d = a.Deferred(),
						e = new Image,
						f = a('<img src="' + b + '" alt="" class="' + c.namespace + '-image" />');
					return e.onload = function () {
						f.naturalWidth = e.width, f.naturalHeight = e.height, d.resolve(f)
					}, e.onerror = function () {
						d.reject(f)
					}, e.src = b, d.promise()
				}
			},
			html: {
				regex: /^\s*<[\w!][^<]*>/,
				process: function (b) {
					return a(b)
				}
			},
			ajax: {
				regex: /./,
				process: function (b) {
					var c = a.Deferred(),
						d = a("<div></div>").load(b, function (a, b) {
							"error" !== b && c.resolve(d.contents()), c.fail()
						});
					return c.promise()
				}
			},
			iframe: {
				process: function (b) {
					var c = new a.Deferred,
						d = a("<iframe/>").hide().attr("src", b).css(e(this, "iframe")).on("load", function () {
							c.resolve(d.show())
						}).appendTo(this.$instance.find("." + this.namespace + "-content"));
					return c.promise()
				}
			},
			text: {
				process: function (b) {
					return a("<div>", {
						text: b
					})
				}
			}
		},
		functionAttributes: ["beforeOpen", "afterOpen", "beforeContent", "afterContent", "beforeClose", "afterClose"],
		readElementConfig: function (b, c) {
			var d = this,
				e = new RegExp("^data-" + c + "-(.*)"),
				f = {};
			return b && b.attributes && a.each(b.attributes, function () {
				var b = this.name.match(e);
				if (b) {
					var c = this.value,
						g = a.camelCase(b[1]);
					if (a.inArray(g, d.functionAttributes) >= 0) c = new Function(c);
					else try {
						c = a.parseJSON(c)
					} catch (h) {}
					f[g] = c
				}
			}), f
		},
		extend: function (b, c) {
			var d = function () {
				this.constructor = b
			};
			return d.prototype = this.prototype, b.prototype = new d, b.__super__ = this.prototype, a.extend(b, this, c), b.defaults = b.prototype, b
		},
		attach: function (b, c, d) {
			var e = this;
			"object" != typeof c || c instanceof a != !1 || d || (d = c, c = void 0), d = a.extend({}, d);
			var f, g = d.namespace || e.defaults.namespace,
				h = a.extend({}, e.defaults, e.readElementConfig(b[0], g), d);
			return b.on(h.openTrigger + "." + h.namespace, h.filter, function (g) {
				var i = a.extend({
						$source: b,
						$currentTarget: a(this)
					}, e.readElementConfig(b[0], h.namespace), e.readElementConfig(this, h.namespace), d),
					j = f || a(this).data("featherlight-persisted") || new e(c, i);
				"shared" === j.persist ? f = j : j.persist !== !1 && a(this).data("featherlight-persisted", j), i.$currentTarget.blur(), j.open(g)
			}), b
		},
		current: function () {
			var a = this.opened();
			return a[a.length - 1] || null
		},
		opened: function () {
			var b = this;
			return d(), a.grep(c, function (a) {
				return a instanceof b
			})
		},
		close: function (a) {
			var b = this.current();
			return b ? b.close(a) : void 0
		},
		_onReady: function () {
			var b = this;
			b.autoBind && (a(b.autoBind).each(function () {
				b.attach(a(this))
			}), a(document).on("click", b.autoBind, function (c) {
				c.isDefaultPrevented() || "featherlight" === c.namespace || (c.preventDefault(), b.attach(a(c.currentTarget)), a(c.target).trigger("click.featherlight"))
			}))
		},
		_callbackChain: {
			onKeyUp: function (b, c) {
				return 27 === c.keyCode ? (this.closeOnEsc && a.featherlight.close(c), !1) : b(c)
			},
			onResize: function (a, b) {
				if (this.$content.naturalWidth) {
					var c = this.$content.naturalWidth,
						d = this.$content.naturalHeight;
					this.$content.css("width", "").css("height", "");
					var e = Math.max(c / parseInt(this.$content.parent().css("width"), 10), d / parseInt(this.$content.parent().css("height"), 10));
					e > 1 && this.$content.css("width", "" + c / e + "px").css("height", "" + d / e + "px")
				}
				return a(b)
			},
			afterContent: function (a, b) {
				var c = a(b);
				return this.onResize(b), c
			}
		}
	}), a.featherlight = b, a.fn.featherlight = function (a, c) {
		return b.attach(this, a, c)
	}, a(document).ready(function () {
		b._onReady()
	})
}(jQuery);

/**
 * Featherlight Gallery – an extension for the ultra slim jQuery lightbox
 * Version 1.3.5 - http://noelboss.github.io/featherlight/
 *
 * Copyright 2015, Noël Raoul Bossart (http://www.noelboss.com)
 * MIT Licensed.
**/
(function($) {
	"use strict";

	var warn = function(m) {
		if(window.console && window.console.warn) {
			window.console.warn('FeatherlightGallery: ' + m);
		}
	};

	if('undefined' === typeof $) {
		return warn('Too much lightness, Featherlight needs jQuery.');
	} else if(!$.featherlight) {
		return warn('Load the featherlight plugin before the gallery plugin');
	}

	var isTouchAware = ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch,
		jQueryConstructor = $.event && $.event.special.swipeleft && $,
		hammerConstructor = window.Hammer && function($el){
			var mc = new window.Hammer.Manager($el[0]);
			mc.add(new window.Hammer.Swipe());
			return mc;
		},
		swipeAwareConstructor = isTouchAware && (jQueryConstructor || hammerConstructor);
	if(isTouchAware && !swipeAwareConstructor) {
		warn('No compatible swipe library detected; one must be included before featherlightGallery for swipe motions to navigate the galleries.');
	}

	var callbackChain = {
			afterClose: function(_super, event) {
					var self = this;
					self.$instance.off('next.'+self.namespace+' previous.'+self.namespace);
					if (self._swiper) {
						self._swiper
							.off('swipeleft', self._swipeleft) /* See http://stackoverflow.com/questions/17367198/hammer-js-cant-remove-event-listener */
							.off('swiperight', self._swiperight);
						self._swiper = null;
					}
					return _super(event);
			},
			beforeOpen: function(_super, event){
					var self = this;

					self.$instance.on('next.'+self.namespace+' previous.'+self.namespace, function(event){
						var offset = event.type === 'next' ? +1 : -1;
						self.navigateTo(self.currentNavigation() + offset);
					});

					if (swipeAwareConstructor) {
						self._swiper = swipeAwareConstructor(self.$instance)
							.on('swipeleft', self._swipeleft = function()  { self.$instance.trigger('next'); })
							.on('swiperight', self._swiperight = function() { self.$instance.trigger('previous'); });
					} else {
						self.$instance.find('.'+self.namespace+'-content')
							.append(self.createNavigation('previous'))
							.append(self.createNavigation('next'));
					}
					return _super(event);
			},
			onKeyUp: function(_super, event){
				var dir = {
					37: 'previous', /* Left arrow */
					39: 'next'			/* Rigth arrow */
				}[event.keyCode];
				if(dir) {
					this.$instance.trigger(dir);
					return false;
				} else {
					return _super(event);
				}
			}
		};

	function FeatherlightGallery($source, config) {
		if(this instanceof FeatherlightGallery) {  /* called with new */
			$.featherlight.apply(this, arguments);
			this.chainCallbacks(callbackChain);
		} else {
			var flg = new FeatherlightGallery($.extend({$source: $source, $currentTarget: $source.first()}, config));
			flg.open();
			return flg;
		}
	}

	$.featherlight.extend(FeatherlightGallery, {
		autoBind: '[data-featherlight-gallery]'
	});

	$.extend(FeatherlightGallery.prototype, {
		/** Additional settings for Gallery **/
		previousIcon: '&#9664;',     /* Code that is used as previous icon */
		nextIcon: '&#9654;',         /* Code that is used as next icon */
		galleryFadeIn: 100,          /* fadeIn speed when image is loaded */
		galleryFadeOut: 300,         /* fadeOut speed before image is loaded */

		slides: function() {
			if (this.filter) {
				return this.$source.find(this.filter);
			}
			return this.$source;
		},

		images: function() {
			warn('images is deprecated, please use slides instead');
			return this.slides();
		},

		currentNavigation: function() {
			return this.slides().index(this.$currentTarget);
		},

		navigateTo: function(index) {
			var self = this,
				source = self.slides(),
				len = source.length,
				$inner = self.$instance.find('.' + self.namespace + '-inner');
			index = ((index % len) + len) % len; /* pin index to [0, len[ */

			self.$currentTarget = source.eq(index);
			self.beforeContent();
			return $.when(
				self.getContent(),
				$inner.fadeTo(self.galleryFadeOut,0.2)
			).always(function($newContent) {
					self.setContent($newContent);
					self.afterContent();
					$newContent.fadeTo(self.galleryFadeIn,1);
			});
		},

		createNavigation: function(target) {
			var self = this;
			return $('<span title="'+target+'" class="'+this.namespace+'-'+target+'"><span>'+this[target+'Icon']+'</span></span>').click(function(){
				$(this).trigger(target+'.'+self.namespace);
			});
		}
	});

	$.featherlightGallery = FeatherlightGallery;

	/* extend jQuery with selector featherlight method $(elm).featherlight(config, elm); */
	$.fn.featherlightGallery = function(config) {
		return FeatherlightGallery.attach(this, config);
	};

	/* bind featherlight on ready if config autoBind is set */
	$(document).ready(function(){ FeatherlightGallery._onReady(); });

}(jQuery));