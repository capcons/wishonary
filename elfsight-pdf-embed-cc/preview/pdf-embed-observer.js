/*
    Elfsight PDF Embed
    Version: 1.0.1
    Release date: Thu Aug 15 2019

    https://elfsight.com

    Copyright (c) 2019 Elfsight, LLC. ALL RIGHTS RESERVED
*/

(function(window){"use strict";!function(t){var e={};function i(o){if(e[o])return e[o].exports;var n=e[o]={i:o,l:!1,exports:{}};return t[o].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=t,i.c=e,i.d=function(t,e,o){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},i.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(i.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)i.d(o,n,function(e){return t[e]}.bind(null,n));return o},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="",i(i.s=0)}([function(t,e){(window.eapps=window.eapps||{}).observer=function(t){t.$watch("widget.data.files",function(e,i){void 0!==e&&e!==i&&e.forEach(function(o,n){if(e[n]&&i[n]&&e[n].linkType!==i[n].linkType){var r=e[n].linkType;t.setPropertyVisibility("upload","upload"===r),t.setPropertyVisibility("link","link"===r)}})},!0),t.$watch("widget.data.layout",function(e){t.setPropertyVisibility("heightFactor","viewer"===e)}),t.$watch("widget.data.showIcon",function(e){t.setPropertyVisibility("iconColor",!!e),t.setPropertyVisibility("icon",!!e)}),t.$watch("widget.data.showDownloadLink",function(e){t.setPropertyVisibility("downloadColor",!!e),t.setPropertyVisibility("downloadFontSize",!!e)})}}]);})(window)