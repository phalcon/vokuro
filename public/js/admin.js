var Admin = (function () {
    "use strict";

    var $adminDemoContainer;

    function setVars() {
        $adminDemoContainer = $("#adminDemoContainer");
    }

    function getRandomColor() {

        return "#" + "0123456789abcdef".split("").map(function (v, i, a) {
            return i > 5 ? null : a[Math.floor(Math.random() * 16)]
        }).join("");
    }

    function initAdminPrivateDemo() {

        if ( $adminDemoContainer.length === 0 ) {
            return;
        }

        setInterval(function () {
            $adminDemoContainer.css({
                "color": getRandomColor(),
            });
        }, 2000);
    }

    return function () {

        var me = this;

        this.init = function () {
            setVars();
            initAdminPrivateDemo();
        };

        $(document).ready(
            function () {
                me.init();
            }
        );
    };
}());

if ( typeof vokuro === "undefined" ) {
    vokuro = {};
}
vokuro.admin = new Admin();
