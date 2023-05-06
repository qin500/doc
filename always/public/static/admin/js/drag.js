(function () {
    function Drag(elId, title, content) {
        if ($('#' + elId).length > 0) {
            alert(3, "此元素已存在，请更换id！");
            return false;
        } else {
            $('body').append('<div id="' + elId + '"></div>');
            this.el = $('#' + elId)[0];
        }
        this.title = title;
        this.startX = 0;
        this.startY = 0;
        this.sourceX = 0;
        this.sourceY = 0;
        this.width = 0;
        this.height = 0;
        this.drager = "";
        this.dragX = 0;
        this.dragY = 0;
        this.init(content);
    }

    Drag.prototype = {
        constructor: Drag, init: function (content) {
            this.buildHtml(content);
            this.setDrag();
        }, buildHtml: function (content) {
            $(this.el).addClass('q5custom-drag-control');
            var html = `<span class="drager top-left angle" data-direct="topLeft"></span>
						<span class="drager top-right angle" data-direct="topRight"></span>
						<span class="drager bottom-left angle" data-direct="bottomLeft"></span>
						<span class="drager bottom-right angle" data-direct="bottomRight"></span>
						<span class="drager top border" data-direct="top"></span>
						<span class="drager right border" data-direct="right"></span>
						<span class="drager bottom border" data-direct="bottom"></span>
						<span class="drager left border" data-direct="left"></span>
						<div class="head">` + this.title + `<span>x</span></div>
						<div class="body">` + content + `</div>`;
            $(this.el).html(html);
        }, setDrag: function () {
            var self = this;
            $(self.el).find('.head span').on('click', function (event) {
                event.stopPropagation();
                $(self.el).css('display', 'none');
            });
            self.el.getElementsByClassName("head")[0].addEventListener('mousedown', start, false);
            self.el.getElementsByClassName("head")[0].addEventListener('touchend', start, false);

            function start(event) {
                $(self.el).attr('onselectstart', "return false;");
                self.startX = event.pageX;
                self.startY = event.pageY;
                var pos = self.getPosition();
                self.sourceX = pos.x;
                self.sourceY = pos.y;
                document.addEventListener('mousemove', move, false);
                document.addEventListener('mouseup', end, false);
            }

            function move(event) {
                var currentX = event.pageX;
                var currentY = event.pageY;
                var distanceX = currentX - self.startX;
                var distanceY = currentY - self.startY;
                self.setPosition({x: (self.sourceX + distanceX).toFixed(), y: (self.sourceY + distanceY).toFixed()})
            }

            function end(event) {
                $(self.el).removeAttr('onselectstart');
                document.removeEventListener('mousemove', move);
                document.removeEventListener('mouseup', end);
            }

            $(self.el).find('.drager').on('mousedown', resizeStart);

            function resizeStart() {
                $(self.el).attr('onselectstart', "return false;");
                self.startX = event.pageX;
                self.startY = event.pageY;
                self.dragX = event.pageX;
                self.dragY = event.pageY;
                var pos = self.getPosition();
                self.sourceX = pos.x;
                self.sourceY = pos.y;
                self.width = self.getSize().w;
                self.height = self.getSize().h;
                document.addEventListener('mousemove', resizeMove, false);
                document.addEventListener('touchmove', resizeMove, false);
                document.addEventListener('mouseup', resizeEnd, false);
                document.addEventListener('touchend', resizeEnd, false);
            }

            function resizeMove(event) {
                var distanceX = event.pageX - self.dragX;
                var distanceY = event.pageY - self.dragY;
                self.drager = $(event.target).data("direct") ? $(event.target).data("direct") : self.drager;
                self.setSize({x: distanceX.toFixed(), y: distanceY.toFixed()});
                self.dragX = event.pageX;
                self.dragY = event.pageY;
            }

            function resizeEnd() {
                $(self.el).removeAttr('onselectstart');
                document.removeEventListener('mousemove', resizeMove);
                document.removeEventListener('mouseup', resizeEnd);
            }
        }, getPosition: function () {
            var transformValue = document.defaultView.getComputedStyle(this.el, false)["transform"];
            if (transformValue == 'none') {
                return {x: 0, y: 0};
            } else {
                var temp = transformValue.match(/-?\d+/g);
                return {x: parseInt(temp[4].trim()), y: parseInt(temp[5].trim())}
            }
        }, getSize: function () {
            var widthValue = document.defaultView.getComputedStyle(this.el, false)["width"];
            var heightValue = document.defaultView.getComputedStyle(this.el, false)["height"];
            return {w: parseInt(widthValue), h: parseInt(heightValue)};
        }, setPosition: function (pos) {
            this.el.style["transform"] = 'translate(' + pos.x + 'px, ' + pos.y + 'px)';
        }, setSize: function (pos) {
            var self = this;
            var pos = {x: parseInt(pos.x), y: parseInt(pos.y)};
            var translateX = self.getPosition().x;
            var translateY = self.getPosition().y;
            switch (self.drager) {
                case "top":
                    if ((self.height - pos.y) >= 100) {
                        self.height -= pos.y;
                        this.el.style["height"] = self.height + 'px';
                    }
                    break;
                case "right":
                    if ((self.width + pos.x) >= 100) {
                        self.width += pos.x;
                        this.el.style["width"] = self.width + 'px';
                        this.el.style["transform"] = 'translate(' + (translateX + pos.x) + 'px, ' + translateY + 'px)';
                    }
                    break;
                case "bottom":
                    if ((self.height + pos.y) >= 100) {
                        self.height += pos.y;
                        this.el.style["height"] = self.height + 'px';
                        this.el.style["transform"] = 'translate(' + translateX + 'px, ' + (translateY + pos.y) + 'px)';
                    }
                    break;
                case "left":
                    if ((self.width - pos.x) >= 100) {
                        self.width -= pos.x;
                        this.el.style["width"] = self.width + 'px';
                    }
                    break;
                case "topLeft":
                    if ((self.width - pos.x) >= 100) {
                        self.width -= pos.x;
                        this.el.style["width"] = self.width + 'px';
                    }
                    if ((self.height - pos.y) >= 100) {
                        self.height -= pos.y;
                        this.el.style["height"] = self.height + 'px';
                    }
                    break;
                case "topRight":
                    if ((self.height - pos.y) >= 100) {
                        self.height -= pos.y;
                        this.el.style["height"] = self.height + 'px';
                    }
                    if ((self.width + pos.x) >= 100) {
                        self.width += pos.x;
                        this.el.style["width"] = self.width + 'px';
                        this.el.style["transform"] = 'translate(' + (translateX + pos.x) + 'px, ' + translateY + 'px)';
                    }
                    break;
                case "bottomLeft":
                    if ((self.width - pos.x) >= 100) {
                        self.width -= pos.x;
                        this.el.style["width"] = self.width + 'px';
                    }
                    if ((self.height + pos.y) >= 100) {
                        self.height += pos.y;
                        this.el.style["height"] = self.height + 'px';
                        this.el.style["transform"] = 'translate(' + translateX + 'px, ' + (translateY + pos.y) + 'px)';
                    }
                    break;
                case "bottomRight":
                    if ((self.width + pos.x) >= 100) {
                        self.width += pos.x;
                        this.el.style["width"] = self.width + 'px';
                        this.el.style["transform"] = 'translate(' + (translateX + pos.x) + 'px, ' + translateY + 'px)';
                    }
                    if ((self.height + pos.y) >= 100) {
                        self.height += pos.y;
                        this.el.style["height"] = self.height + 'px';
                        this.el.style["transform"] = 'translate(' + translateX + 'px, ' + (translateY + pos.y) + 'px)';
                    }
                    if ((self.height + pos.y) >= 100 && (self.width + pos.x) >= 100) {
                        this.el.style["transform"] = 'translate(' + (translateX + pos.x) + 'px, ' + (translateY + pos.y) + 'px)';
                    }
                    break;
                default:
                    break;
            }
        }
    }
    window.Drag = Drag;
})();
