!function (global, factory) {
  if (typeof exports === "object" && typeof module !== "undefined") {
    module.exports = factory();
  } else if (typeof define === "function" && define.amd) {
    define(factory);
  } else {
    (global = global || self).LazyLoad = factory();
  }
}(this, function () {
  "use strict";

  function extend() {
    extend = Object.assign || function (target) {
      for (var i = 1; i < arguments.length; i++) {
        var source = arguments[i];
        for (var key in source) {
          if (Object.prototype.hasOwnProperty.call(source, key)) {
            target[key] = source[key];
          }
        }
      }
      return target;
    };
    return extend.apply(this, arguments);
  }

  var isBrowser = typeof window !== "undefined";
  var isBot =
    isBrowser &&
    (!("onscroll" in window) ||
      (typeof navigator !== "undefined" &&
        /(gle|ing|ro)bot|crawl|spider/i.test(navigator.userAgent)));

  var supportsIO = isBrowser && "IntersectionObserver" in window;
  var supportsClassList =
    isBrowser && "classList" in document.createElement("p");
  var isHiDPI = isBrowser && window.devicePixelRatio > 1;

  var defaults = {
    elements_selector: "IMG",
    container: isBrowser ? document : null,
    threshold: 300,
    thresholds: null,
    data_src: "src",
    data_srcset: "srcset",
    data_sizes: "sizes",
    data_bg: "bg",
    data_bg_hidpi: "bg-hidpi",
    data_bg_multi: "bg-multi",
    data_bg_multi_hidpi: "bg-multi-hidpi",
    data_poster: "poster",
    class_applied: "applied",
    class_loading: "loading",
    class_loaded: "loaded",
    class_error: "error",
    unobserve_completed: true,
    unobserve_entered: false,
    cancel_on_exit: false,
    callback_enter: null,
    callback_exit: null,
    callback_applied: null,
    callback_loading: null,
    callback_loaded: null,
    callback_error: null,
    callback_finish: null,
    callback_cancel: null,
    use_native: false
  };

  function getSettings(custom) {
    return extend({}, defaults, custom);
  }

  function dispatchInit(LazyLoadClass, settings) {
    var instance = new LazyLoadClass(settings);
    var eventName = "LazyLoad::Initialized";
    var event;

    try {
      event = new CustomEvent(eventName, {
        detail: { instance: instance }
      });
    } catch (e) {
      event = document.createEvent("CustomEvent");
      event.initCustomEvent(eventName, false, false, {
        instance: instance
      });
    }

    window.dispatchEvent(event);
  }

  var STATUS_LOADING = "loading";
  var STATUS_ERROR = "error";
  var STATUS_NATIVE = "native";

  var DATA_PREFIX = "data-";
  var STATUS_ATTR = "ll-status";

  function getData(el, name) {
    return el.getAttribute(DATA_PREFIX + name);
  }

  function setData(el, name, value) {
    var attr = DATA_PREFIX + name;
    value !== null ? el.setAttribute(attr, value) : el.removeAttribute(attr);
  }

  function getStatus(el) {
    return getData(el, STATUS_ATTR);
  }

  function setStatus(el, value) {
    setData(el, STATUS_ATTR, value);
  }

  function resetStatus(el) {
    setStatus(el, null);
  }

  function isUnprocessed(el) {
    return getStatus(el) === null;
  }

  function isNative(el) {
    return getStatus(el) === STATUS_NATIVE;
  }

  function addClass(el, className) {
    if (supportsClassList) {
      el.classList.add(className);
    } else {
      el.className += (el.className ? " " : "") + className;
    }
  }

  function removeClass(el, className) {
    if (supportsClassList) {
      el.classList.remove(className);
    } else {
      el.className = el.className
        .replace(new RegExp("(^|\\s+)" + className + "(\\s+|$)"), " ")
        .trim();
    }
  }

  function LazyLoad(settings) {
    this._settings = getSettings(settings);
    this.loadingCount = 0;
    this.toLoadCount = 0;

    if (supportsIO && !this._settings.use_native) {
      this._observer = new IntersectionObserver(
        this._onIntersect.bind(this),
        {
          root:
            this._settings.container === document
              ? null
              : this._settings.container,
          rootMargin:
            this._settings.thresholds ||
            this._settings.threshold + "px"
        }
      );
    }

    if (isBrowser) {
      window.addEventListener("online", this.update.bind(this));
    }

    this.update();
  }

  LazyLoad.prototype.update = function (elements) {
    var nodes = elements || this._settings.container.querySelectorAll(
      this._settings.elements_selector
    );

    var toLoad = Array.prototype.slice.call(nodes).filter(isUnprocessed);
    this.toLoadCount = toLoad.length;

    if (!isBot && supportsIO && !this._settings.use_native) {
      this._observer.disconnect();
      toLoad.forEach(this._observer.observe, this._observer);
    } else {
      this.loadAll(toLoad);
    }
  };

  LazyLoad.prototype.loadAll = function (elements) {
    var self = this;
    elements.forEach(function (el) {
      self._load(el);
    });
  };

  LazyLoad.prototype._load = function (el) {
    addClass(el, this._settings.class_loading);
    setStatus(el, STATUS_LOADING);
  };

  LazyLoad.prototype.destroy = function () {
    if (this._observer) {
      this._observer.disconnect();
    }
    delete this._observer;
    delete this._settings;
    delete this.loadingCount;
    delete this.toLoadCount;
  };

  LazyLoad.load = function (el, settings) {
    var opts = getSettings(settings);
    setStatus(el, STATUS_LOADING);
  };

  LazyLoad.resetStatus = function (el) {
    resetStatus(el);
  };

  if (isBrowser && window.lazyLoadOptions) {
    dispatchInit(LazyLoad, window.lazyLoadOptions);
  }

  return LazyLoad;
});
