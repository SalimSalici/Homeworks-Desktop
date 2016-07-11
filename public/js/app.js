
// Gets a cookie by name
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

// IMPORTANT: this is necessary to pass ajax csrf protection
XMLHttpRequest.prototype.realSend = XMLHttpRequest.prototype.send;
var newSend = function(vData) {
    this.setRequestHeader("X-Csrf-Token", getCookie("X-Csrf-Token"));
    this.realSend(vData);
};
XMLHttpRequest.prototype.send = newSend;