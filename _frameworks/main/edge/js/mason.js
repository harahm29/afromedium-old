(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
(function($) {
  return $.fn.mason = function(options, complete) {
    var $self, callback, debug_elements, defaults, elements, mason_clear;
    defaults = {
      itemSelector: '',
      viewport: '',
      numRows : 2,
      numCols: 0,
      ratio: 0,
      sizes: [],
      columns: [[0, 480, 1], [480, 780, 2], [780, 1080, 3], [1080, 1320, 4], [1320, 1680, 5]],
      promoted: [],
      filler: {
        itemSelector: options.itemSelector,
        filler_class: 'mason_filler',
        keepDataAndEvents: false
      },
      fillerDefault:'',
      randomSizes: false,
      randomFillers: false,
      layout: 'none',
      gutter: 0,
      debug: false
    };
    $self = null;
    debug_elements = {
      container: $("<div id='debug'></div>"),
      block: "<div class='mason-debug' style='background-color: rgba(255, 255, 255, .5); float: left;'></div>"
    };
    mason_clear = "<div class='mason_clear' style='clear:both; position:relative;'></div>";
    if (complete) {
      callback = {
        complete: complete
      };
    }
    elements = {
      block: {
        viewHeight: 0,
        height: 0,
        width: 0
      },
      matrix: [],
      startWidth: 0,
      d:0
    };
    this.each(function() {
        var callbacks, columnSize, debug, layBricks, mason, resize, settings, setup, sizeElements;
        settings = $.extend(defaults, options);
        callbacks = $.extend(callback, complete);
        $self = $(this);

        setup = function() {
            //$self.append(mason_clear);

            var $body=$('body'),
                d=Math.abs($body[0].clientWidth - $body[0].offsetWidth);
            if(widthScroll!==false&&widthScroll)d=widthScroll;
            var $view=$(settings.viewport);
            elements.d = d;
            elements.startWidth = $body[0].offsetWidth+d;

            elements.block.viewHeight = $view[0].offsetHeight;
            elements.block.height = elements.block.viewHeight/settings.numRows;
            settings.numCols=Math.round(elements.startWidth/elements.block.height);
            elements.block.width = Math.round(parseFloat(elements.startWidth/settings.numCols+1));

            console.log('MASON - setup', elements);

            sizeElements();

            if (settings.debug) {
                //console.log("Running In Debug Mode");
                return debug();
            }

        };

        sizeElements = function() {
            var $block;
            if (columnSize() === 1) {
                $block = $self.children("" + settings.itemSelector);
                $block.css({height:elements.block.height, width:elements.block.width});
                if (typeof callbacks.complete !== "undefined") {
                    return callbacks.complete();
                }
            } else {
                $self.children("" + settings.itemSelector, "." + settings.filler.filler_class).each(function(){
                    var h, p, promoted, promoted_size, ran, size, w;
                    $block = $(this);
                    p = 0;
                    promoted = false;
                    promoted_size = 0;
                    while (p < settings.promoted.length) {
                        if ($block.hasClass(settings.promoted[p][0])) {
                            promoted = true;
                            promoted_size = p;
                        }
                        p++;
                    }
                    if (promoted) {
                        size = settings.promoted[promoted_size];
                        $block.data('size', promoted_size);
                        $block.data('promoted', true);
                        h = parseFloat(elements.block.height * size[2]).toFixed(0);
                        h = h - (settings.gutter * 2);
                        w = parseFloat(elements.block.width * size[1]).toFixed(0);
                        w = w - (settings.gutter * 2);
                    } else {
                        ran = Math.floor(Math.random() * settings.sizes.length);
                        size = settings.sizes[ran];
                        $block.data('size', ran);
                        h = parseFloat(elements.block.height * size[1]).toFixed(0);
                        h = h - (settings.gutter * 2);
                        w = parseFloat(elements.block.width * size[0]).toFixed(0);
                        w = w - (settings.gutter * 2);
                    }
                    $block.height(h + 'px');
                    $block.width(w + 'px');
                    return $block.css({
                        'margin': settings.gutter
                    });
                });
                return mason();
            }
        };

        mason = function() {
            var block_h, c, col, el_h, r;
            col = columnSize();
            el_h = elements.block.viewHeight;//$self.height();
            block_h = Math.round(el_h / elements.block.height);
            elements.matrix = [];
            r = 0;

            while (r < block_h) {
                elements.matrix[r] = [];
                c = 0;
                while (c < col) {
                    elements.matrix[r][c] = false;
                    c++;
                }
                r++;
            }
            console.log('MASON - mason', el_h, block_h, elements.matrix);

            $self.children("" + settings.itemSelector).each(function() {
                var $block, a, bh, bw, h, l, results, s, t, w;
                $block = $(this);
                l = Math.round($block.position().left / elements.block.width);
                t = Math.round($block.position().top / elements.block.height);
                s = parseFloat($block.data('size'));
                if ($block.data('promoted')) {
                    h = settings.promoted[s][2];
                    w = settings.promoted[s][1];
                    a = h * w;
                } else {
                    h = settings.sizes[s][1];
                    w = settings.sizes[s][0];
                    a = h * w;
                }
                r = 0;
                results = [];
                if (t > (settings.numRows - 1)) {
                    return false;
                }
                //console.log(1111, t)
                while (r < a) {
                    bh = 0;
                    while (bh < h) {
                        bw = 0;

                        elements.matrix[t + bh][l] = true;
                        while (bw < w) {
                            elements.matrix[t + bh][l + bw] = true;
                            bw++;
                        }
                        bh++;
                    }
                    results.push(r++);
                }
                return results;
            });

            return layBricks();
        };

        layBricks = function() {
            var hGrid=elements.block.viewHeight;//$('.header_grid')[0].offsetHeight;
            var $filler, $fillerClone, c, filler_index, filler_total, h, r, w, x, y;
            r = 0;

            var $allElements=$("" + settings.filler.itemSelector).removeClass('no_clone').not("." + settings.filler.filler_class);


            $fillerClone = $allElements.each(function(){
                var $el=$(this);
                if ($el[0].offsetTop<hGrid) {
                    $el.addClass('no_clone');
                }
            }).not('.no_clone').add($allElements);

        filler_total = $fillerClone.length;
        filler_index = -1;
        while (r < elements.matrix.length) {
          c = 0;
          while (c < elements.matrix[r].length) {
            if (!elements.matrix[r][c]) {
              h = elements.block.height;
              w = elements.block.width;
              x = (r * h) + settings.gutter;
              y = (c * w) + settings.gutter;
              h = h - settings.gutter * 2;
              w = w - settings.gutter * 2;
              if (settings.randomFillers) {
                filler_index = Math.floor(Math.random() * filler_total);
              } else {
                if (filler_index < filler_total) {
                  filler_index++;
                }
                if (filler_index === filler_total) {
                  filler_index = 0;
                }
              }
              $filler = $fillerClone.eq(filler_index).clone(settings.filler.keepDataAndEvents);
              if (!$filler[0] && settings.fillerDefault) {
                  $filler = $(settings.fillerDefault);
              }
              $filler.addClass(settings.filler.filler_class);
              $filler.css({
                position: 'absolute',
                top: x + 'px',
                left: y + 'px',
                height: h + 'px',
                width: w + 'px',
                margin: '0px'
              });
              console.log('MASON - append filler',  x+h-2, hGrid);
              if((x+h-2)<=hGrid){
                $filler.appendTo($self);
                onLoadImgFromList($filler, $filler.data('src'));
              }
            }
            c++;
          }
          r++;
        }
            if ($self.width() < elements.startWidth) {
                //return $(window, $self).trigger('resize');
            } else {
                if (typeof callbacks.complete !== "undefined") {
                    return callbacks.complete();
                }
            }
        };

        columnSize = function() {
            return settings.numCols;
        };

        debug = function() {
            var $debug, block, block_h, c, col, el_h, i;
            $debug = $self.parent();
        col = columnSize();
        el_h = $self.height();
        block_h = el_h / elements.block.height;
        debug_elements.container.css({
          position: 'absolute',
          top: '0',
          left: '0',
          height: $self.height(),
          width: $self.width()
        });
        i = 0;
        while (i < block_h) {
          c = 0;
          while (c < col) {
            block = $(debug_elements.block);
            block.css({
              height: elements.block.height - (settings.gutter * 2),
              width: elements.block.width - (settings.gutter * 2),
              margin: settings.gutter
            });
            debug_elements.container.append(block);
            c++;
          }
          i++;
        }
        debug_elements.container.append(mason_clear);
        return $debug.prepend(debug_elements.container);
      };



      if (settings.layout === "fluid") {
            resize = null;
            var ev='resize', t=0;
            if(isMobileSite && typeof window.orientation!='undefined'){
                ev='orientationchange';
                t=evWndResTime;
            }
            $(window, $self).on(ev, (function(_this) {
                return function(event) {
                    $("." + settings.filler.filler_class).remove();
                    elements.matrix = [];
                    clearTimeout(resize);
                    resize = null;
                    return resize = setTimeout(function() {
                        return setup();
                    }, t);
                };
            })(this));
        }
        return setup();
    });
    return {
        destroy: function() {
            return $(window, $self).off('resize');
        }
    };
  };
})(jQuery);



},{}]},{},[1]);
