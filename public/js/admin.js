;var Admin = (function () {
    'use strict';

    var $adminDemoContainer = "";

    function setVars() {
        $adminDemoContainer = $("#adminDemoContainer");
    }

    function getRandomColor() {

        return '#'+Math.floor(Math.random()*16777215).toString(16);
    }

    function initAdminPrivateDemo() {

        if ( $adminDemoContainer.length === 0 ) {
            return;
        }

        setInterval(function () {
            $adminDemoContainer.css({
                "color" : getRandomColor(),
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
    }
})();

//init the javascript "class"
new Admin();
