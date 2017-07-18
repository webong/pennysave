<style type="text/css">
    input.toggle{position:absolute;visibility:hidden}
    input.toggle+label{display:block;position:relative;cursor:pointer;outline:0;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
    input.toggle-flat+label:after,input.toggle-flat+label:before{display:block;position:absolute;content:""}
    input.toggle-flat+label{width:100px;height:20px;background-color:#BF2A23;-webkit-transition:background .5s;-moz-transition:background .5s;-o-transition:background .5s;transition:background .5s}
    input.toggle-flat+label:before{top:2px;left:2px;bottom:2px;right:2px;-webkit-transition:background .5s;-moz-transition:background .5s;-o-transition:background .5s;transition:background .5s}
    input.toggle-flat+label:after{top:4px;left:4px;bottom:4px;width:45px;background-color:#fff;-webkit-transition:margin .5s,background .5s;-moz-transition:margin .5s,background .5s;-o-transition:margin .5s,background .5s;transition:margin .5s,background .5s}
    input.toggle-flat:checked+label{background-color:#00C176}
    input.toggle-flat:checked+label:after{margin-left:47px;background-color:#fff}
    input.toggle-flip+label{height:20px}
    input.toggle-flip+label:after,input.toggle-flip+label:before{position:absolute;top:0;left:0;bottom:0;width:100%;height:100%;color:#fff;font-size:13px;text-align:center;line-height:20px}
    input.toggle-flip+label:before{background-color:#BF2A23;content:attr(data-off);-webkit-transition:-webkit-transform .5s;-moz-transition:-moz-transform .5s;-o-transition:-o-transform .5s;transition:transform .5s;-webkit-backface-visibility:hidden;-moz-backface-visibility:hidden;-ms-backface-visibility:hidden;-o-backface-visibility:hidden;backface-visibility:hidden}
    input.toggle-flip+label:after{background-color:#00C176;color:#fff;content:attr(data-on);-webkit-transition:-webkit-transform .4s;-moz-transition:-moz-transform .4s;-o-transition:-o-transform .4s;transition:transform .4s;-webkit-transform:rotateX(180deg);-moz-transform:rotateX(180deg);-ms-transform:rotateX(180deg);-o-transform:rotateX(180deg);transform:rotateX(180deg);-webkit-backface-visibility:hidden;-moz-backface-visibility:hidden;-ms-backface-visibility:hidden;-o-backface-visibility:hidden;backface-visibility:hidden}
    input.toggle-flip:checked+label:before{-webkit-transform:rotateX(180deg);-moz-transform:rotateX(180deg);-ms-transform:rotateX(180deg);-o-transform:rotateX(180deg);transform:rotateX(180deg)}
</style>
