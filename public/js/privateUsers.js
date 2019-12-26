var PrivateUsers = (function () {
    "use strict";

    var $blinkTextContainer;

    function setVars() {
        $blinkTextContainer = $("#usersAssetManagerDemoTextContainer");
    }

    function getRandomColor() {

        return "#" + "0123456789abcdef".split("").map(function (v, i, a) {
            return i > 5 ? null : a[Math.floor(Math.random() * 16)];
        }).join("");
    }

    function initUsersBlinkingTextDemo() {

        if ( $blinkTextContainer.length === 0 ) {
            return;
        }

        setInterval(function () {
            $blinkTextContainer.css({
                "color": getRandomColor(),
            });
        }, 2000);
    }

    return function () {

        var me = this;

        this.init = function () {
            setVars();
            initUsersBlinkingTextDemo();
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
vokuro.privateUsers = new PrivateUsers();
